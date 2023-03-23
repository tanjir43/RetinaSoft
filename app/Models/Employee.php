<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name', 'name_l',
        'nid','employee_id',

        'dob','id_card',

        'media_id',
        'department_id','designation_id',

        'phone', 'phone_alt',
        'email', 'email_office',
        'address',
        
        'monthly_annual_leave','sick_leave',

        'opening_balance','balance','status',
        'created_by','updated_by','deleted_by',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class)->withTrashed();
    }
    
    public function designation()
    {
        return $this->belongsTo(Designation::class)->withTrashed();
    }

    public function media()
    {
        return $this->belongsTo(Media::class);
    }

    public function appointment()
    {
        return $this->hasOne(EmployeeHistory::class)
        ->where('status','!=', 'working')
        ->latest()->withTrashed();
    }

    public function salary()
    {
        return $this->hasOne(EmployeeHistory::class)
        ->latest();
    }

    public function history()
    {
        return $this->hasMany(EmployeeHistory::class)->latest()->withTrashed();
    }

    public function createdby()
    {
        return $this->belongsTo(User::class,'created_by');
    }

    public function updatedby()
    {
        return $this->belongsTo(User::class,'updated_by');
    }

    public function deletedby()
    {
        return $this->belongsTo(User::class,'deleted_by');
    }
}

