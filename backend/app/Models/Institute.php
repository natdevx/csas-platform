<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Institute extends Model
{
    protected $fillable = [
        'name',
        'type',
        'location'
    ];

    public function careers()
    {
        return $this->hasMany(Career::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function staff()
    {
        return $this->hasMany(Staff::class);
    }
}
