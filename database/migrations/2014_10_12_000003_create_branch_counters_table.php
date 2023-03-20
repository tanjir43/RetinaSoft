<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    private $data = [
        [
            'counter_id'        => '11-01',
            'name'              => 'Cash Counter',
            'branch_id'         => 1,
            'created_by'        => 1,
        ]
    ];
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('branch_counters', function (Blueprint $table) {
            $table->id();
            $table->string('counter_id');
            
            $table->string('name')->unique()->collation('utf16_general_ci');
            $table->string('name_l')->nullable()->unique()->collation('utf16_general_ci');
            
            $table->foreignId('branch_id')->references('id')->on('branches');
            $table->float('max_cash_limit',11,2)->default(0);

            $table->integer('created_by')->references('id')->on('users');
            $table->integer('updated_by')->nullable()->references('id')->on('users');
            $table->integer('deleted_by')->nullable()->references('id')->on('users');

            $table->softDeletes();
            $table->timestamps();
        });
        DB::table('branch_counters')->insert($this->data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branch_counters');
    }
};
