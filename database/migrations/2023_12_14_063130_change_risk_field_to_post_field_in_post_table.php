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
        Schema::table('post_horizon_dataset', static function (Blueprint $table) {
            $table->enum('risk', [
                'low',
                'medium',
                'high',
                'very_high',
            ])
                ->comment('Степень риска');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('post_horizon_dataset', static function (Blueprint $table) {
            $table->dropColumn('risk');
        });
    }
};
