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
        Schema::create('attendance_sheet_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees');
            $table->foreignId('attendance_sheet_id')->constrained('attendance_sheets');
            #$table->float('total_day',12,2)->default(0);
            #$table->float('present_days',12,2)->default(0);
            #$table->float('absent_days',12,2)->default(0);
            #$table->float('annual_days',12,2)->default(0);
            #$table->float('sick_days',12,2)->default(0);
            $table->date('in_time')->nullable();
            $table->date('out_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_sheet_details');
    }
};
