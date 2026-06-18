<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'user_id',
        'client_custom_id',
        'dob',
        'phone',
        'region',
        'care_plan',
        'agent_id',
        'status',
        'address',
        'city',
        'state',
        'zip_code',
        'latitude',
        'longitude',
        'emergency_contact_name',
        'emergency_contact_phone',
        'emergency_contact_relationship',
        'care_needs',
        'mobility_level',
        'preferred_language',
        'special_requirements',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    protected $casts = [
        'dob' => 'date',
    ];

    public function clientRequests()
    {
        return $this->hasMany(ClientRequest::class);
    }

    public function serviceBookings()
    {
        return $this->hasMany(ServiceBooking::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
