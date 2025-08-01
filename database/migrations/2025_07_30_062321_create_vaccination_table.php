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
        Schema::create('vaccination', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('child_id');
            $table->unsignedBigInteger('prov_id')->nullable(); 
            $table->unsignedBigInteger('vaccine_id');
            $table->string('lot_id')->nullable(); 
            $table->boolean('is_completed')->default(false);
            $table->timestamps();

            $table->foreign('child_id')->references('childID')->on('child')->onDelete('cascade');
            $table->foreign('prov_id')->references('id')->on('provider')->onDelete('set null');
            $table->foreign('vaccine_id')->references('id')->on('vaccine')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vaccination');
    }
};
