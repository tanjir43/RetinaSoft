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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();

            $table->string('name')->collation('utf16_general_ci');
            $table->string('name_l')->nullable()->collation('utf16_general_ci');

            $table->string('nid')->unique()->collation('utf16_general_ci');
            $table->string('employee_id')->unique();
           
            $table->date('dob');
            $table->string('id_card')->unique()->nullable()->collation('utf16_general_ci');

            $table->foreignId('media_id')->nullable()->constrained('media');

            $table->foreignId('department_id')->constrained('departments');
            $table->foreignId('designation_id')->constrained('designations');
            
            $table->string('phone',20)->unique()->collation('utf16_general_ci');
            $table->string('phone_alt',20)->nullable()->collation('utf16_general_ci');
            $table->string('email')->nullable()->unique()->collation('utf16_general_ci');
            $table->string('email_office')->nullable()->collation('utf16_general_ci');

            $table->text('address')->nullable()->collation('utf16_general_ci');
            
            $table->float('opening_balance', 11, 2)->default(0);
            $table->float('balance', 11, 2)->default(0);
            $table->enum('status',['resigned','working','fired'])->default('working');
            
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
        Schema::dropIfExists('employees');
    }
};
