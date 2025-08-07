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
        Schema::table('parent', function (Blueprint $table) {
            $table->dropColumn("email");
            $table->string("phone")->unique();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('parent', function (Blueprint $table) {
            $table->dropColumn("phone");
            $table->string("email")->unique();
        });
    }
};
