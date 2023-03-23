<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $data = [
        [
            'name'          => 'Administrator',
            'name_l'        => 'প্রশাসক',
            'permissions'   =>  '[1,2,3,4,5,6,70,71,72,73,74,100,101,200,1000,1001,1002,1003]',
            'created_by'    => '0'
        ],
        [
            'name'          =>  'Admin',
            'name_l'        =>  'অ্যাডমিন',
            'permissions'   =>  '[1,2,3,4,5,6,70,71,72,73,74,100,101,200,1000,1001,1002,1003]',
            'created_by'    =>  '0'
        ],
        [
            'name'          =>  'Employee',
            'name_l'        =>  'কর্মচারী',
            'permissions'   =>  '["0"]',
            'created_by'    =>  '0'
        ],

    ];
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->collation('utf16_general_ci');
            $table->string('name_l')->nullable()->unique()->collation('utf16_general_ci');
            $table->text('permissions')->nullable();

            $table->integer('created_by')->references('id')->on('users');
            $table->integer('updated_by')->nullable()->references('id')->on('users');
            $table->integer('deleted_by')->nullable()->references('id')->on('users');
            
            $table->softDeletes();
            $table->timestamps();
        });
        DB::table('roles')->insert($this->data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
