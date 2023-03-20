<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name','name_l','branch_manual_code','branch_type','opening_balance',
        'balance','phone','email','address','weekend','in_time','late_count_time',
        'exit_time','absent_count','organization_id','currency','created_by',
        'updated_by','deleted_by'
    ];

    public function createdby()
    {
        return $this->belongsTo(User::class,'created_by');
    }
    
    public function updated_by()
    {
        return $this->belongsTo(User::class,'updated_by');
    }
    
    public function deleted_by()
    {
        return $this->belongsTo(User::class,'deleted_by');
    }
}
