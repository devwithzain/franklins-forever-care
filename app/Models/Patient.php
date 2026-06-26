<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'age',
        'relationship',
        'address',
        'city',
        'state',
        'zip_code',
        'latitude',
        'longitude',
        'care_plan',
        'care_needs',
        'mobility_level',
        'preferred_language',
        'special_requirements',
        'emergency_contact_name',
        'emergency_contact_phone',
        'emergency_contact_relationship',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function serviceBookings()
    {
        return $this->hasMany(ServiceBooking::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }
}
