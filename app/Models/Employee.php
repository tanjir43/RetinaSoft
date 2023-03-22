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
        'name',
        'nid',
        'phone',
        'email',
        'address',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function customer_type()
    {
        return $this->belongsTo(CustomerType::class);
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

