<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UniversalSearch;

class Bill extends Model
{

    use UniversalSearch;

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
    public function kasPayment()
    {
        return $this->hasMany(KasPayment::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }


    // Logic Area
    public function scopeGetBillKasPaymentData($query)
    {
        return $query->select('bills.id', 'bills.week', 'bills.month', 'bills.year', 'bills.nominal', 'bills.status', 'bills.due_date', 'bills.student_id')->join('students', 'bills.student_id', '=', 'students.id');
    }
}
