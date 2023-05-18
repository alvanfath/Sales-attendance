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
        Schema::create('absensi', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('sales_id');
            $table->string('image');
            $table->string('location');
            $table->dateTime('in_time');
            $table->dateTime('out_time')->nullable();
            $table->string('place_name');
            $table->string('last_location')->nullable();
            $table->timestamps();
            $table->foreign('sales_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('absensi', function (Blueprint $table) {
            $table->dropForeign('absensi_sales_id_foreign');
            $table->dropColumn('sales_id');
        });
    }
};
