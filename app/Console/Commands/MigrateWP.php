<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Post;
use App\Models\PostType;
use App\Models\Status;
use App\Models\TypePaper;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MigrateWP extends Command
{
    /**
     * @const  WP_POSTS_TABLE
     */
    public const WP_POSTS_TABLE = 'wp_posts';

    /**
     * @const  WP_CATEGORIES_TABLE
     */
    public const WP_CATEGORIES_TABLE = 'wp_term_taxonomy';

    /**
     * @const  WP_PIVOT_POST_CATEGORIES_TABLE
     */
    public const WP_PIVOT_POST_CATEGORIES_TABLE = 'wp_term_relationships';

    /**
     * @const  WP_TERMS_TABLE
     */
    public const WP_TERMS_TABLE = 'wp_terms';

    /**
     * @const  WP_STATUS_PUBLISH
     */
    public const WP_STATUS_PUBLISH = 'publish';

    /**
     * @const  WP_POST_STATUS_FIELD
     */
    public const WP_POST_STATUS_FIELD = '.post_status';

    /**
     * @const  MYSQL_CONNECTION
     */
    public const MYSQL_CONNECTION = 'mysql';

    /**
     * @const  CHUNK_SIZE
     */
    public const CHUNK_SIZE = 500;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wp:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get wp data from db to migrate to laravel db';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Start migrating wp data to laravel db...');
        $this->migrateData();
        $this->info('Migrating completed.');
    }

    /**
     * Migrate wp data to laravel db
     *
     * @return void
     */
    public function migrateData(): void
    {
        Auth::loginUsingId(User::all()->random()->id);

        $categories_data = $this->prepareWpCategoriesData();
        $this->createCategories($categories_data);

        $post_data = $this->prepareWpPostData();
        $this->createPosts($post_data);
    }

    /**
     * Prepare wp post data
     *
     * @return Collection
     */
    private function prepareWpPostData(): Collection
    {
        return DB::connection(self::MYSQL_CONNECTION)
            ->table(self::WP_POSTS_TABLE)
            ->select(
                self::WP_POSTS_TABLE . '.post_title',
                self::WP_POSTS_TABLE . '.post_content',
                self::WP_POSTS_TABLE . '.post_date',
                self::WP_POSTS_TABLE . '.post_modified',
                DB::raw('MIN(' . self::WP_PIVOT_POST_CATEGORIES_TABLE . '.term_taxonomy_id) as old_category_id')
            )
            ->leftJoin(
                self::WP_PIVOT_POST_CATEGORIES_TABLE,
                self::WP_PIVOT_POST_CATEGORIES_TABLE . '.object_id',
                '=',
                self::WP_POSTS_TABLE . '.ID'
            )
            ->where(
                self::WP_POSTS_TABLE . self::WP_POST_STATUS_FIELD,
                self::WP_STATUS_PUBLISH
            )
            ->groupBy(
                self::WP_POSTS_TABLE . '.post_title',
                self::WP_POSTS_TABLE . '.post_content',
                self::WP_POSTS_TABLE . '.post_date',
                self::WP_POSTS_TABLE . '.post_modified'
            )
            ->where(self::WP_POSTS_TABLE . '.post_content', '!=', '')
            ->get();
    }

    /**
     * Prepare wp categories data
     *
     * @return mixed
     */
    private function prepareWpCategoriesData(): mixed
    {
        $data = DB::connection(self::MYSQL_CONNECTION)
            ->table(self::WP_CATEGORIES_TABLE)
            ->select(
                self::WP_CATEGORIES_TABLE . '.term_taxonomy_id as old_id',
                self::WP_TERMS_TABLE . '.name',
                self::WP_CATEGORIES_TABLE . '.description as category_desc',
                'parent_category.description as parent_category_desc',
                self::WP_CATEGORIES_TABLE . '.parent as old_parent_id'
            )
            ->where(self::WP_CATEGORIES_TABLE . '.taxonomy', 'category')
            ->join(
                self::WP_TERMS_TABLE,
                self::WP_TERMS_TABLE . '.term_id',
                self::WP_CATEGORIES_TABLE . '.term_id'
            )
            ->leftJoin(
                self::WP_CATEGORIES_TABLE . ' as parent_category',
                'parent_category.term_id',
                self::WP_CATEGORIES_TABLE . '.parent'
            )
            ->get();

        return collect($data)->map(function ($item) {
            return [
                'title' => $item->name,
                'description' => $item->category_desc,
                'parent_description' => $item->parent_category_desc,
                'status_id' => Status::find(1)->id,
                'old_id' => $item->old_id,
                'old_parent_id' => $item->old_parent_id,
            ];
        });
    }

    /**
     * Create categories
     *
     * @param Collection $insertionData insertion data
     * @return void
     */
    private function createCategories(Collection $insertionData): void
    {
        $startTime = microtime(true);

        $mainCategories = $insertionData->filter(function ($item) {
            return $item['parent_description'] === null;
        });


        $mainCategories = $mainCategories->map(function ($item) {
            return [
                'title' => $item['title'],
                'description' => $item['description'],
                'slug' => Str::slug($item['title'] . '-' . $item['old_id']),
                'status_id' => $item['status_id'],
                'order' => random_int(1, 10),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        });

        Category::insert($mainCategories->toArray());

        $subCategories = $insertionData->filter(function ($item) {
            return $item['parent_description'] !== null;
        });


        $subCategoriesInsertionData = $subCategories->map(function ($item) {
            $parentCategory = Category::where(function ($query) use ($item) {
                $query->where(
                    'slug',
                    'like',
                    '%'
                    . $item['old_parent_id']
                    . '%'
                );
            })
                ->first();

            return [
                'title' => $item['title'],
                'description' => $item['description'],
                'created_at' => now(),
                'updated_at' => now(),
                'order' => random_int(1, 10),
                'status_id' => Status::find(1)->id,
                'parent_id' => $parentCategory?->id,
                'slug' => Str::slug($item['title'] . '-' . $item['old_id']),
            ];
        })
            ->all();

        Category::insert($subCategoriesInsertionData);

        $endTime = microtime(true);

        $this->info('Categories are created in ' . ($endTime - $startTime) . ' seconds');
    }

    /**
     * Create posts
     *
     * @param Collection $data data to insert
     * @return void
     */
    private function createPosts(Collection $data): void
    {
        $startTime = microtime(true);

        $this->info('Creating posts...');

        $data->chunk(self::CHUNK_SIZE)->each(function ($chunk) {
            $insertionData = $chunk->map(function ($item) {
                $oldCategory = DB::connection(self::MYSQL_CONNECTION)
                    ->table(self::WP_CATEGORIES_TABLE)
                    ->where('term_taxonomy_id', $item->old_category_id)
                    ->first();

                $category = Category::where('description', $oldCategory?->description)->first();

                return [
                    'title' => $item->post_title,
                    'content' => $item->post_content,
                    'created_at' => $item->post_date,
                    'published_at' => $item->post_date,
                    'updated_at' => $item->post_modified,
                    'desc' => $item->post_title,
                    'author_id' => User::all()->random()->id,
                    'type_paper_id' => TypePaper::all()->random()->id,
                    'status_id' => Status::find(1)->id,
                    'category_id' => $category->id ?? 1,
                    'post_type_id' => PostType::all()->random()->id,
                    'is_published' => false,
                    'publisher_type' => User::class,
                    'is_current' => true,
                ];
            })
                ->all();

            Post::insert($insertionData);
        });

        $endTime = microtime(true);

        $this->info('Posts are created in ' . ($endTime - $startTime) . ' seconds');
    }
}
