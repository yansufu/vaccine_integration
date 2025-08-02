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
            $table->dropForeign(['prov_org_id']);
            $table->dropColumn('prov_org_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vaccination', function (Blueprint $table) {
            $table->unsignedBigInteger('prov_org_id')->nullable();
            $table->foreign('prov_org_id')
                ->references('id')->on('organization')
                ->onDelete('set null');
        });
    }
};
