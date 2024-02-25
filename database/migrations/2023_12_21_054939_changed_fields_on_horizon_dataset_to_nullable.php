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
        Schema::table('post_horizon_dataset', function (Blueprint $table) {
            $table->foreignId('ticker_id')->nullable()->change();
            $table->foreignId('isin_id')->nullable()->change();
            $table->double('currentPrice')->nullable()->change();
            $table->double('potential')->nullable()->change();
            $table->double('openPrice')->nullable()->change();
            $table->double('targetPrice')->nullable()->change();
            $table->double('analyzePrice')->nullable()->change();
            $table->integer('horizon')->nullable()->change();
            $table->boolean('status')->nullable()->change();

            $typesRecommend = ['buy', 'sell', 'hold', 'default'];
            $typesRisk = ['low', 'medium', 'high', 'very_high', 'default'];

            $resultRecommend = join(', ', array_map(function ($value) {
                return sprintf("'%s'::character varying", $value);
            }, $typesRecommend));

            $resultRisk = join(', ', array_map(function ($value) {
                return sprintf("'%s'::character varying", $value);
            }, $typesRisk));

            DB::statement("ALTER TABLE post_horizon_dataset DROP CONSTRAINT post_horizon_dataset_recommend_check");
            DB::statement("ALTER TABLE post_horizon_dataset DROP CONSTRAINT post_horizon_dataset_risk_check");

            DB::statement(
                "ALTER TABLE post_horizon_dataset
                ALTER COLUMN recommend SET DEFAULT 'default',
                ADD CONSTRAINT post_horizon_dataset_recommend_check
                CHECK (recommend::text = ANY (ARRAY[$resultRecommend]::text[]))"
            );

            DB::statement(
                "ALTER TABLE post_horizon_dataset
                ALTER COLUMN risk SET DEFAULT 'default',
                ADD CONSTRAINT post_horizon_dataset_risk_check
                CHECK (risk::text = ANY (ARRAY[$resultRisk]::text[]))"
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('post_horizon_dataset', function (Blueprint $table) {
            $table->foreignId('ticker_id')->change();
            $table->foreignId('isin_id')->change();
            $table->double('currentPrice')->change();
            $table->double('potential')->change();
            $table->double('openPrice')->change();
            $table->double('targetPrice')->change();
            $table->double('analyzePrice')->change();
            $table->double('horizon')->change();
            $table->boolean('status')->change();
        });
    }
};
