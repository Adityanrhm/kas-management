<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KasPayment extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'student_id',
        'approved_by',
        'bill_id',
        'paid_at',
        'updated_at',
        'payment_method',
        'status'
    ];


    // Relation Area
    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class);
    }
}
