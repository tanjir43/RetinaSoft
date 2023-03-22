<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempEmployee extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'nid',
        'phone',
        'email',
        'address',
        'password',
        'is_rejected',
        'created_by',
        'updated_by',
        'deleted_by'
    ];


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