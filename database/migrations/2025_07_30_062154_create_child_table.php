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
        Schema::create('child', function (Blueprint $table) {
            $table->id('childID');
            $table->unsignedBigInteger('parent_id');
            $table->string('name');
            $table->date('date_of_birth');
            $table->string('NIK');
            $table->string('gender');
            $table->float('weight',5 ,2);
            $table->float('height',5 ,2);
            $table->string('medical_history')->nullable();
            $table->string('allergy')->nullable();
            $table->unsignedBigInteger('org_id');
            $table->timestamps();

            $table->unique(['parent_id', 'name']);

            $table->foreign('parent_id')->references('id')->on('parent')->onDelete('cascade');
            $table->foreign('org_id')->references('id')->on('organization')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('child');
    }
};
