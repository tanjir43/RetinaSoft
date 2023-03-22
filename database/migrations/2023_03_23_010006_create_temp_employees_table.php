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
        Schema::create('temp_employees', function (Blueprint $table) {
            $table->id();

            $table->string('name')->collation('utf16_general_ci');

            $table->string('nid')->nullable()->unique()->collation('utf16_general_ci');
            $table->string('phone')->nullable()->unique()->collation('utf16_general_ci');
            $table->string('email')->nullable()->unique()->collation('utf16_general_ci');
            $table->text('address')->nullable()->collation('utf16_general_ci');
            $table->boolean('is_rejected')->default(false);
            $table->string('password');

            $table->integer('created_by')->references('id')->on('users');
            $table->integer('updated_by')->nullable()->references('id')->on('users');
            $table->integer('deleted_by')->nullable()->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temp_employees');
    }
};
