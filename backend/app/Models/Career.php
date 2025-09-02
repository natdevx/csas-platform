<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    protected $fillable = ['institute_id','name','level'];

    public function institute()
    {
        return $this->belongsTo(Institute::class);
    }

    public function groups()
    {
        return $this->hasMany(Group::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
