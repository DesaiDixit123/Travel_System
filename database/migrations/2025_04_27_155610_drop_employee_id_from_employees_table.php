<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Dropping the employee_id column from the employees table
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('employee_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // If we want to roll back, we can add the column back
        Schema::table('employees', function (Blueprint $table) {
            $table->string('employee_id')->nullable(); // Or provide the type you prefer
        });
    }
};
