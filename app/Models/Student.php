<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone',
        'address',
        'city',
        'postal_code',
        'country',
        'gender',
        'marital_status',
        'nationality',
        'identity_number',
        'guardian_name',
        'guardian_phone',
        'guardian_address',
        'birth_date',
        'class_id',
        'image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function guardians()
    {
        return $this->belongsToMany(Guardian::class, 'guardian_student');
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function transports()
    {
        return $this->belongsToMany(Transport::class, 'student_transport')
            ->withPivot('start_date', 'status')
            ->withTimestamps();
    }
}
