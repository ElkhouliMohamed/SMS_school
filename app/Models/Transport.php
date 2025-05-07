<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    protected $fillable = ['vehicle_number', 'driver_name', 'route', 'capacity'];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_transport')
            ->withPivot('start_date', 'status')
            ->withTimestamps();
    }
}
