<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'name_l',
        'created_by','updated_by','deleted_by',
    ];

    public function employees()
    {
        $this->hasMany(Employee::class)->withTrashed();
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
