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
            $table->foreignId('sector_id')->constrained('sectors');
            $table->foreignId('isin_id')->nullable()->constrained('isins');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('post_horizon_dataset', static function (Blueprint $table) {
            $table->dropConstrainedForeignId('sector_id');
            $table->dropConstrainedForeignId('isin_id');
        });
    }
};
