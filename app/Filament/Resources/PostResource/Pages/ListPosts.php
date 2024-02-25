<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Guava\FilamentDrafts\Admin\Resources\Pages\List\Draftable;
use Illuminate\Database\Eloquent\Builder;

class ListPosts extends ListRecords
{
    use Draftable;

    /**
     * resource class name for the model being managed
     *
     * @var string
     */
    protected static string $resource = PostResource::class;

    /**
     * Get header actions for the page.
     *
     * @return array
     */
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    /**
     * Get the tabs for the page.
     *
     * @return array|\Filament\Resources\Components\Tab[]
     */
    public function getTabs(): array
    {
        return [
            'All posts' => Tab::make()
                ->label(__('post.all-published'))
                ->modifyQueryUsing(fn(Builder $query) => $query->where('is_published', true)),

            'All drafts' => Tab::make()
                ->label(__('post.all-drafts'))
                ->modifyQueryUsing(
                    fn(Builder $query) => $query->where('is_published', false)
                    ->where('is_current', true)
                ),

            'My published posts' => Tab::make()
                ->label(__('post.my-published'))
                ->modifyQueryUsing(fn(Builder $query) => $query->where('is_published', true)
                    ->where('author_id', auth()->id())),

            'My drafts' => Tab::make()
                ->label(__('post.my-drafts'))
                ->modifyQueryUsing(fn(Builder $query) => $query->where('is_published', false)
                    ->where('author_id', auth()->id())),
        ];
    }
}
