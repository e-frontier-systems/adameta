<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('metadatas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ticker_id');
            $table->text('json');
            $table->timestamps();

            $table->primary(['id', 'ticker_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metadatas');
    }
};
