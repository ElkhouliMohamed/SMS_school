<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Guardian extends Model
{
    use SoftDeletes;

    protected $table = 'guardians';

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone',
        'address',
        'city',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /*************  ✨ Windsurf Command ⭐  *************/
    /**
     * Get the students of the Guardian
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    /*******  96469dfe-67c1-4e7e-ae58-7a73659d5bd5  *******/
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'guardian_student', 'guardian_id', 'student_id')
            ->withTimestamps();
    }
}
