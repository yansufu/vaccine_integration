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
        Schema::table('vaccination', function (Blueprint $table) {
            $table->text('notes')->nullable();
            $table->string('location')->nullable();
            $table->unsignedBigInteger('prov_org_id')->nullable();
            $table->foreign('prov_org_id')
                ->references('id')->on('organization')
                ->onDelete('set null');

                });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vaccination', function (Blueprint $table) {
            $table->dropColumn(['notes', 'location', 'prov_org_id']);
            $table->dropForeign(['prov_org_id']);
        });
    }
};
