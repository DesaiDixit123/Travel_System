<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void {
        Schema::table('quotations', function (Blueprint $table) {
            $table->dropColumn(['hotel', 'limit']);
        });
    }

    public function down(): void {
        Schema::table('quotations', function (Blueprint $table) {
            $table->string('hotel')->nullable();
            $table->string('limit')->nullable(); // Change datatype if needed
        });
    }
};
