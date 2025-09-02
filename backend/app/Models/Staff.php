<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'user_id',
        'institute_id',
        'staff_type',
        'gender',
        'department',
        'employee_id',
        'academic_rank',
    ];

    public function user() { 
        return $this->belongsTo(User::class); 
    }

    public function institute()
    {
        return $this->belongsTo(Institute::class);
    }
}
