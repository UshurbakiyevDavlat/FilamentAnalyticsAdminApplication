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
        Schema::create('posts_has_tags', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->comment('Идентификатор поста')->constrained('posts');
            $table->foreignId('tag_id')->comment('Идентификатор тега')->constrained('tags');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
