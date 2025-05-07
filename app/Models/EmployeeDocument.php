<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeDocument extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'file_path',
        'file_type',
        'file_extension',
        'file_size',
        'file_mime',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
