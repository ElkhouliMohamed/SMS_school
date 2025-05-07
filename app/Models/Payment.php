<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['student_id', 'amount', 'payment_date', 'status', 'payment_method', 'notes'];

    protected $casts = [
        'amount' => 'float',
        'payment_date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
