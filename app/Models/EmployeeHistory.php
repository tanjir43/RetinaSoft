<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeHistory extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'employee_id',
        'joining_date','last_working_date',
        'is_promoted', 'is_resigned', 'is_fired',
        'department_id','designation_id',
        'basic_salary','other_benefits','overtime_rate','bonus',
        'comment','status',
        'created_by','updated_by','deleted_by'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class)->withTrashed();
    }
    
    public function department()
    {
        return $this->belongsTo(Department::class)->withTrashed();
    }
    
    public function designation()
    {
        return $this->belongsTo(Designation::class)->withTrashed();
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
