<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    Schema::table('quotations', function (Blueprint $table) {
        $table->string('email_screenshot')->nullable(); // Only add new field
    });
}

public function down()
{
    Schema::table('quotations', function (Blueprint $table) {
        $table->dropColumn('email_screenshot');
    });
}

};
