<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'image',
        'two_factor_enabled',
        'two_factor_code',
        'two_factor_expires_at',
        'stripe_customer_id'
    ];
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_code',
    ];
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_enabled' => 'boolean',
            'two_factor_expires_at' => 'datetime',
        ];
    }

    public function client()
    {
        return $this->hasOne(Client::class);
    }

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    public function serviceBookings()
    {
        return $this->hasMany(ServiceBooking::class);
    }

    public function assignedBookings()
    {
        return $this->hasMany(ServiceBooking::class, 'agent_id');
    }

    public function workloads()
    {
        return $this->hasMany(EmployeeWorkload::class, 'user_id');
    }
}
