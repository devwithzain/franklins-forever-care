<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OutdoorActivity extends Model
{
    protected $fillable = [
        'employee_id',
        'client_id',
        'activity_name',
        'start_time',
        'end_time',
        'status',
        'location',
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