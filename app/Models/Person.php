<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\ChangeLog;

class Person extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'ad_guid',
        'user_id',
        'employee_id',
        'username',
        'email',
        'name',
        'job_title',
        'location',
        'address',
        'manager_id',
        'status',
        'employee_type',
        'join_date',
        'leave_date',
        'last_synced_at',
        'source',
    ];

    protected $casts = [
        'join_date' => 'date',
        'leave_date' => 'datetime',
        'last_synced_at' => 'datetime',
    ];

    public function manager()
    {
        return $this->belongsTo(Person::class, 'manager_id');
    }

    public function directReports()
    {
        return $this->hasMany(Person::class, 'manager_id');
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    public function changeLogs()
    {
        return $this->hasMany(ChangeLog::class);
    }
}
