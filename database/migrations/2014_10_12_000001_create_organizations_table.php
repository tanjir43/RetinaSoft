<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
   private $data = [
       [
        'name'          => 'Obligate gadgets',
        'created_by'    => 1
        ]
   ];
    public function up(): void
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->collation('utf16_general_ci');
            $table->string('name_l')->nullable()->collation('utf16_general_ci');
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('trade_license')->nullable()->collation('utf16_general_ci');
            $table->string('vat')->nullable();
            $table->string('vat_area_code')->nullable();
            $table->string('mashuk_no')->nullable();
            $table->string('tin')->nullable();
            $table->string('registration_no')->nullable();
            $table->foreignId('media_id')->nullable()->constrained('media');
            
            $table->integer('created_by')->references('id')->on('users');
            $table->integer('updated_by')->nullable()->references('id')->on('users');
            $table->integer('deleted_by')->nullable()->references('id')->on('users');

            $table->softDeletes();
            $table->timestamps();
        });
        DB::table('organizations')->insert($this->data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};
