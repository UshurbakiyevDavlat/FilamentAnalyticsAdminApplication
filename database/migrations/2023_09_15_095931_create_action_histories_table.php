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
        Schema::create('action_histories', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('action_id')->comment('Действие')->constrained('actions');
            $table->foreignId('user_id')->comment('Пользователь')->constrained('users');
            $table->morphs('actionable');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('action_histories');
    }
};
