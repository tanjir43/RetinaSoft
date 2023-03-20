<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    private $data = [
        [
            'name'                  => 'Main Branch',
            'branch_manual_code'    => 1001,
            'organization_id'       => 1,
            'currency'              => 'BDT',
            'created_by'            => 1
        ]
    ];
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();

            $table->string('name')->unique()->collation('utf16_general_ci');
            $table->string('name_l')->nullable()->unique()->collation('utf16_general_ci');
            
            $table->string('branch_manual_code')->unique();

            $table->enum('branch_type',['dairy','pos','others'])->default('pos');
            $table->float('opening_balance',11,2)->default(0);
            $table->float('balance',11,2)->default(0);

            $table->string('phone')->nullable()->collation('utf16_general_ci');
            $table->string('email')->nullable()->collation('utf16_general_ci');
            $table->string('address')->nullable()->collation('utf16_general_ci');

            $table->enum('weekend',['friday','saturday','sunday','monday','tuesday','wednesday','thursday'])->nullable();
            $table->string('in_time')->nullable()->comment('24 hours format');
            $table->string('late_count_time')->nullable()->comment('24 hours format');
            $table->string('exit_time')->nullable()->comment('24 hours format');
            $table->string('absent_count')->nullable()->comment('24 hours format');
            $table->string('currency');

            $table->foreignId('organization_id')->references('id')->on('organizations');
            #$table->foreignId('in_charge_name')->nullable()->references('id')->on('employees');

            $table->integer('created_by')->references('id')->on('users');
            $table->integer('updated_by')->nullable()->references('id')->on('users');
            $table->integer('deleted_by')->nullable()->references('id')->on('users');

            $table->softDeletes();
            $table->timestamps();
        });
        DB::table('branches')->insert($this->data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
