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
        Schema::create('employee_histories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('employee_id')->constrained('employees');
            $table->foreignId('department_id')->constrained('departments');
            $table->foreignId('designation_id')->constrained('designations');

            $table->float('basic_salary',12,2)->default(0);
            $table->float('other_benefits',12,2)->default(0);
            $table->float('overtime_rate',12,2)->comment('hourly overtime rate')->default(0);
            $table->float('bonus',12,2)->default(0);
            
            $table->date('joining_date');
            $table->date('last_working_date')->nullable();

            $table->boolean('is_promoted')->nullable();
            $table->boolean('is_resigned')->nullable();
            $table->boolean('is_fired')->nullable();
            
            $table->text('comment')->nullable()->collation('utf16_general_ci');

            $table->enum('status',['join','rejoin','working'])->default('working');

            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->foreignId('deleted_by')->nullable()->constrained('users');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_histories');
    }
};
