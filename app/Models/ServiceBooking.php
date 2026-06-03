<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'plan_type',
        'patient_name',
        'patient_age',
        'relationship',
        'address',
        'city',
        'state',
        'zip_code',
        'preferred_date',
        'notes',
        'status',
        'amount',
        'payment_status',
        'stripe_session_id',
        'stripe_customer_id',
        'stripe_subscription_id',
        'subscription_status',
        'subscription_ends_at',
        'user_id',
        'agent_id',
        'booking_date',
    ];

    protected $casts = [
        'subscription_ends_at' => 'datetime',
        'preferred_date' => 'date',
        'booking_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }
}
