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
        Schema::create('post_horizon_dataset', static function (Blueprint $table) {
            $table->id();
            $table->float('currentPrice')->comment('Текущая цена - подтягивается с ТН');
            $table->float('openPrice')->comment('Цена входа - редактируется в ручную');
            $table->float('targetPrice')->comment('Целевая цена - редактируется в ручную');
            $table->float('potential')->comment('Потенциал - рассчет разницы между 1 и 2 пунктов');
            $table->enum(
                'recommend',
                [
                    'buy',
                    'sell',
                    'hold',
                ],
            )->comment('Рекомендация - редактируется в ручную');
            $table->float('analyzePrice')->comment('Цена на момент анализа - редактируется в ручную');
            $table->float('horizon')->comment('Горизонт - редактируется в ручную');
            $table->foreignId('ticker_id')->comment('Тикер ценной бумаги из ТНА')->constrained('tickers');
            $table->foreignId('country_id')->comment('Страна')->constrained('countries');
            $table->boolean('status')->comment('Состояние - редактируется в ручную');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_horizon_dataset');
    }
};
