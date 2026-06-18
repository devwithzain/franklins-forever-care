<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'employee_id',
        'service_booking_id',
        'client_id',
        'patient_id',
        'check_in',
        'check_out',
        'status',
        'note',
        'check_in_latitude',
        'check_in_longitude',
        'check_out_latitude',
        'check_out_longitude',
        'check_in_distance_to_client',
        'check_out_distance_to_client',
    ];

    protected $casts = [
        'check_in' => 'datetime',
        'check_out' => 'datetime',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function serviceBooking()
    {
        return $this->belongsTo(ServiceBooking::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}