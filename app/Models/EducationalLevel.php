<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EducationalLevel extends Model
{
    use SoftDeletes;

    protected $table = 'educational_levels';

    protected $fillable = [
        'name',
        'description',
        'order',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];


    public function schoolClasses(): HasMany
    {
        return $this->hasMany(SchoolClass::class, 'educational_level_id');
    }
}
