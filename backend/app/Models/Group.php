<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['career_id','name','semester','generation'];

    public function career()
    {
        return $this->belongsTo(Career::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
