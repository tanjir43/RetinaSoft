<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BranchCounter extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates  = ['deleted_at'];
    protected $fillable = [
        'name','name_l','branch_id','max_cash_limit','counter_id',
        'created_by','updated_by','deleted_by',
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
