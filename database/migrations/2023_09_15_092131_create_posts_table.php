<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', static function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Заголовок поста');
            $table->text('desc')->comment('Краткое описание');
            $table->text('content')->comment('Полное содержание поста');
            $table->foreignId('order')->comment('Порядок сортировки');
            $table->foreignId('horizon_dataset_id')
                ->nullable()
                ->comment('Данные по горизонту')
                ->constrained('post_horizon_dataset');
            $table->foreignId('author_id')->comment('Автор')->constrained('users');
            $table->foreignId('type_paper_id')->comment('Тип ценной бумаги')->constrained('type_papers');
            $table->foreignId('status_id')->comment('Статус активности')->constrained('statuses');
            $table->foreignId('category_id')->comment('Категория')->constrained('categories');
            $table->timestamp('published_at')->comment('Дата публикации')->useCurrent();
            $table->timestamp('expired_at')->comment('Дата окончания публикации');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
