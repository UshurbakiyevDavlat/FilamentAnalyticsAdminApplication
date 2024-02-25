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
        Schema::table('tickers', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('isins', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('sectors', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('post_types', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickers', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('isins', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('sectors', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('post_types', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
