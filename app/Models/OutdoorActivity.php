<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OutdoorActivity extends Model
{
    protected $fillable = [
        'employee_id',
        'client_id',
        'activity_name',
        'activity_type',
        'start_time',
        'end_time',
        'status',
        'location',
        'notes',
        'report_summary',
        'report_participation_level',
        'report_outcome_notes',
        'report_follow_up_recommendations',
        'duration_minutes',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
