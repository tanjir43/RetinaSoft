<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $data = [
        [
            'name'              =>  'Manager',
            'name_l'            =>  'ব্যবস্থাপক',
            'created_by'        =>  '1'
        ],
        [
            'name'              =>  'Accountant',
            'name_l'            =>  'হিসাবরক্ষক',
            'created_by'        =>  '1'
        ]
    ];
    public function up(): void
    {
        Schema::create('designations', function (Blueprint $table) {
            $table->id();

            $table->string('name')->unique()->collation('utf16_general_ci');
            $table->string('name_l')->unique()->nullable()->collation('utf16_general_ci');

            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->foreignId('deleted_by')->nullable()->constrained('users');

            $table->timestamps();
            $table->softDeletes();
        });
        DB::table('designations')->insert($this->data);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('designations');
    }
};
