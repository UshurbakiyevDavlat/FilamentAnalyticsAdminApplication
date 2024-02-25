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
        Schema::create('file_types', static function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Именование типа файла');
            $table->string('extension')->comment('Расширение файла');
            $table->string('mime_type')->comment('MIME-тип файла');
            $table->string('icon')->comment('Иконка файла');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_types');
    }
};
