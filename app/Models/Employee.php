<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps = true;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'position',
        'department_id',
        'photo',
    ];
    
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}

