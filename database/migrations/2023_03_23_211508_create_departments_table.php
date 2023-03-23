<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $data = [
        [
            'name'             =>  'Developer',
            'name_l'           =>  'গূঢ়লেখক',
            'created_by'       =>  '1'
        ],
        [
            'name'             =>  'Account',
            'name_l'           =>  'হিসাব',
            'created_by'       =>  '1'
        ]
    ];
    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            
            $table->string('name')->unique()->collation('utf16_general_ci');
            $table->string('name_l')->unique()->nullable()->collation('utf16_general_ci');

            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->foreignId('deleted_by')->nullable()->constrained('users');

            $table->timestamps();
            $table->softDeletes();
        });
        DB::table('departments')->insert($this->data);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
