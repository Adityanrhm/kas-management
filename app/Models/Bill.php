<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'student_id',
        'week',
        'month',
        'year',
        'nominal',
        'due_date',
    ];


    // Relation Area
    public function KasPayments()
    {
        return $this->hasMany(KasPayment::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
