<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceSheetDetail extends Model
{
    use HasFactory;
    protected $fillable =  [
        'employee_id',
        'attendance_sheet_id',
        'day',
        'in_time',
        'out_time'
        #'salary',
        #'total_day',
        #'present_days',
        #'absent_days',
        #'annual_days',
        #'sick_days',
        #'payable_salary'
    ];  

    public function  attendance_sheet()
    {
        return $this->belongsTo(AttendanceSheet::class)->withTrashed();
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class)->withTrashed();
    }
}

