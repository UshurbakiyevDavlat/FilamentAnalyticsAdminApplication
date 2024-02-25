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
        Schema::create('post_files', static function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Именование файла');
            $table->string('path')->comment('Путь к файлу');
            $table->integer('order')->comment('Порядок сортировки');
            $table->foreignId('file_type_id')->comment('Тип файла')->constrained('file_types');
            $table->foreignId('post_id')->comment('Пост')->constrained('posts');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_files');
    }
};
