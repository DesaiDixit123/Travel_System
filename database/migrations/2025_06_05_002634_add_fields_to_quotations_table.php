<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
{
    Schema::table('quotations', function (Blueprint $table) {
        $table->date('invoice_date')->nullable();
        $table->date('travel_from')->nullable();
        $table->date('travel_to')->nullable();
        $table->string('bill_no')->nullable();
        $table->string('from_to')->nullable();
        $table->decimal('amount', 10, 2)->nullable();
        $table->json('include')->nullable(); // For flight, train, hotel
    });
}

public function down()
{
    Schema::table('quotations', function (Blueprint $table) {
        $table->dropColumn([
            'invoice_date',
            'travel_from',
            'travel_to',
            'bill_no',
            'from_to',
            'amount',
            'include',
        ]);
    });
}

};
