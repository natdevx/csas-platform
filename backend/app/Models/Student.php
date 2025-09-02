<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'user_id',
        'gender',
        'age',
        'institute_id',
        'career_id',
        'enrollment_id',
        'group_id'
    ];

    public function user()     
    { 
        return $this->belongsTo(User::class); 
    }

    public function institute()
    { 
        return $this->belongsTo(Institute::class); 
    }

    public function career()   
    { 
        return $this->belongsTo(Career::class); 
    }

    public function group()   
    { 
        return $this->belongsTo(Group::class); 
    }
}
