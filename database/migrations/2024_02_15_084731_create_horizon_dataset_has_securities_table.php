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
        Schema::create('horizon_dataset_has_securities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('horizon_dataset_id')->constrained('post_horizon_dataset');
            $table->foreignId('security_id');
            $table->string('security_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horizon_dataset_has_securities');
    }
};
