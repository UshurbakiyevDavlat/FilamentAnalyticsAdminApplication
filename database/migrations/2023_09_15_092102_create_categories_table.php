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
        Schema::create('categories', static function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Название категории');
            $table->string('description')->nullable()->comment('Описание категории');
            $table->string('slug')->unique()->comment('Слаг');
            $table->string('img')->nullable()->comment('Изображение');
            $table->integer('order')->comment('Порядок');
            $table->foreignId('status_id')->comment('Статус')->constrained('statuses');
            $table->foreignId('parent_id')->nullable()->comment('Родительская категория')->constrained('categories');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
