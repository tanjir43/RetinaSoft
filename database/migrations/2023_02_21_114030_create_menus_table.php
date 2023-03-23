<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    private $data = [
        [
            'id'        => 1,
            'parent'    => null,
            'name'      => 'Handle all Organization',
            'name_l'    => 'হ্যান্ডেল সকল প্রকল্প',#শাখা',
            'web'       => '',
            'app'       => '',
            'web_icon'  => '',
            'app_icon'  => '',
            'note'      => '',
            'note_l'    => '',
        ],
        [
            'id'        => 2,
            'parent'    => null,
            'name'      => 'Handle all Branch',
            'name_l'    => 'হ্যান্ডেল সকল শাখা',
            'web'       => '',
            'app'       => '',
            'web_icon'  => '',
            'app_icon'  => '',
            'note'      => '',
            'note_l'    => '',
        ],
        [
            'id'        => 3,
            'parent'    => null,
            'name'      => 'Save / Update',
            'name_l'    => 'সেভ / আপডেট',
            'web'       => '',
            'app'       => '',
            'web_icon'  => '',
            'app_icon'  => '',
            'note'      => '',
            'note_l'    => '',
        ],
        [
            'id'        => 4,
            'parent'    => null,
            'name'      => 'Block / Unblock',
            'name_l'    => 'ব্লক / আনব্লক',
            'web'       => '',
            'app'       => '',
            'web_icon'  => '',
            'app_icon'  => '',
            'note'      => '',
            'note_l'    => '',
        ],
        [
            'id'        => 5,
            'parent'    => null,
            'name'      => 'Delete',
            'name_l'    => 'ডিলিট',
            'web'       => '',
            'app'       => '',
            'web_icon'  => '',
            'app_icon'  => '',
            'note'      => '',
            'note_l'    => '',
        ],
        [
            'id'        => 6,
            'parent'    => null,
            'name'      => 'Dashboard',
            'name_l'    => 'ড্যাশবোর্ড',
            'web'       => 'dashboard',
            ''       => '',
            'web_icon'  => 'uil uil-home-alt',
            'app_icon'  => '',
            'note'      => '',
            'note_l'    => '',
        ],
        #Organization
        [
            'id'        => 100,
            'parent'    => null,
            'name'      => 'Company',
            'name_l'    => 'প্রতিষ্ঠান ',
            'web'       => 'company',
            'app'       => '',
            'web_icon'  =>  'uil uil-cog',
            'app_icon'  =>  '',
            'note'      =>  '',
            'note_l'    =>  '',
        ],

        #Employees
        [
            'id'        =>  70,
            'parent'    =>  null,
            'name'      =>  'Employees',
            'name_l'    =>  'কর্মচারী',
            'web'       =>  'employees',
            'app'       =>  '',
            'web_icon'  =>  'uil uil-users-alt',
            'app_icon'  =>  '',
            'note'      =>  '',
            'note_l'    =>  '',
        ],
        [
            'id'        =>  71,
            'parent'    =>  70,
            'name'      =>  'Departments',
            'name_l'    =>  'বিভাগ',
            'web'       =>  'departments',
            'app'       =>  '',
            'web_icon'  =>  '',
            'app_icon'  =>  '',
            'note'      =>  '',
            'note_l'    =>  '',
        ],
        [
            'id'        =>  72,
            'parent'    =>  70,
            'name'      =>  'Designations',
            'name_l'    =>  'পদবী',
            'web'       =>  'designations',
            'app'       =>  '',
            'web_icon'  =>  '',
            'app_icon'  =>  '',
            'note'      =>  '',
            'note_l'    =>  '',
        ],
        [
            'id'        =>  73,
            'parent'    =>  70,
            'name'      =>  'Employees List',
            'name_l'    =>  'কর্মীদের তালিকা',
            'web'       =>  'employee-list',
            'app'       =>  '',
            'web_icon'  =>  '',
            'app_icon'  =>  '',
            'note'      =>  '',
            'note_l'    =>  '',
        ],
        [
            'id'        => 74,
            'parent'    => 70,
            'name'      => 'Attendance Sheet/Report',
            'name_l'    => 'উপস্থিতি শীট',
            'web'       =>  'attendance-sheet',
            'app'       =>  '',
            'web_icon'  =>  '',
            'app_icon'  =>  '',
            'note'      =>  '',
            'note_l'    =>  '',    
        ],

        #Request new employee
        [
            'id'        => 200,
            'parent'    => null,
            'name'      => 'Requested Employee ',
            'name_l'    => 'আবেদক কর্মচারী ',
            'web'       => 'requested.employee',
            'app'       => '',
            'web_icon'  => 'uil uil-user',
            'app_icon'  => '',
            'note'      => '',
            'note_l'    => '',
        ],
/*         [
            'id'        => 201,
            'parent'    => 200,
            'name'      => 'Employee List',
            'name_l'    => 'আবেদক কর্মচারী ',
            'web'       => 'employee',
            'app'       => '',
            'web_icon'  =>  '',
            'app_icon'  =>  '',
            'note'      =>  '',
            'note_l'    =>  '',
        ], */
        
        #Settings start
        [
            'id'        =>  1000,
            'parent'    =>  null,
            'name'      =>  'Settings',
            'name_l'    =>  'সেটিংস',
            'web'       =>  'settings',
            'app'       =>  '',
            'web_icon'  =>  'uil uil-cog',
            'app_icon'  =>  '',
            'note'      =>  '',
            'note_l'    =>  '',
        ],
        [
            'id'        =>  1001,
            'parent'    =>  1000,
            'name'      =>  'User Role',
            'name_l'    =>  'ব্যবহারকারীর ভূমিকা',
            'web'       =>  'roles',
            'app'       =>  '',
            'web_icon'  =>  '',
            'app_icon'  =>  '',
            'note'      =>  '',
            'note_l'    =>  '',
        ],
        [
            'id'        =>  1002,
            'parent'    =>  1000,
            'name'      =>  'User\'s List',
            'name_l'    =>  'ব্যবহারকারীর তালিকা',
            'web'       =>  'users',
            'app'       =>  '',
            'web_icon'  =>  '',
            'app_icon'  =>  '',
            'note'      =>  '',
            'note_l'    =>  '',
        ],
    ];

    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->integer('parent')->nullable();
            $table->string('name')->collation('utf16_general_ci');
            $table->string('name_l')->collation('utf16_general_ci');

            $table->string('web')->nullable();
            $table->string('web_icon')->nullable();
            
            $table->string('app')->nullable();
            $table->string('app_icon')->nullable();

            $table->string('note')->nullable();
            $table->string('note_l')->nullable();
            $table->timestamps();
        });
        DB::table('menus')->insert($this->data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
