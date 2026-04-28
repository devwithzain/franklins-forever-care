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
}
