<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'nis',
        'name',
        'class'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
