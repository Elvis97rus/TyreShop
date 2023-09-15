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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('order_details', 1000)->nullable();
            $table->string('contact_name', 200)->nullable();
            $table->string('contact_phone', 200)->nullable();
            $table->string('contact_email', 200)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('order_details');
            $table->dropColumn('contact_name');
            $table->dropColumn('contact_phone');
            $table->dropColumn('contact_email');
        });
    }
};
