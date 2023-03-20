<?php

namespace App\Models\organization;

use App\Models\User;
use App\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Organization extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name','address','email','phone','trade_license','vat',
        'vat_area_code', 'mashuk_no','tin','registration_no','media_id',
        'created_by', 'updated_by', 'deleted_by'
    ];

    public function media()
    {
        return $this->belongsTo(Media::class);
    }

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
