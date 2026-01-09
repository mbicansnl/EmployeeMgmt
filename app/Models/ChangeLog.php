<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChangeLog extends Model
{
    protected $fillable = [
        'person_id',
        'change_type',
        'summary',
        'payload',
    ];

    protected $casts = [
        'payload' => 'array',
    ];
}
