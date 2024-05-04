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
        Schema::create('web_scrapers', function (Blueprint $table) {
            $table->id();
            $table->boolean('get_detail')->default(false);
            $table->string('name');
            $table->string('model');
            $table->string('link');
            $table->json('selectors');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('web_scrapers');
    }
};
