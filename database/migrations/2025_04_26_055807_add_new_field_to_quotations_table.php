<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void {
        Schema::table('quotations', function (Blueprint $table) {
            $table->string('Quotation')->nullable(); 
            // "new_field_name" ni jagya ae tamne je field nu naam chhe ae lakhvu
        });
    }

    public function down(): void {
        Schema::table('quotations', function (Blueprint $table) {
            $table->dropColumn('Quotation');
        });
    }
};
