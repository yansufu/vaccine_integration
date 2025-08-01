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
        Schema::create('catalog', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('org_id');
            $table->unsignedBigInteger('cat_id');
            $table->decimal('price', 8, 2);
            $table->date('vaccination_date');
            $table->timestamps();

            $table->foreign('cat_id')->references('id')->on('category')->onDelete('cascade');
            $table->foreign('org_id')->references('id')->on('organization')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catalog');
    }
};
