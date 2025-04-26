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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->string('employee_mobile');
            $table->string('corporate_mobile');
            $table->string('corporate_email');
            $table->string('department');
            $table->string('hotel');
            $table->decimal('limit', 10, 2);
            $table->string('flight');
            $table->text('other_expenses')->nullable();
            $table->timestamps();
    
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
