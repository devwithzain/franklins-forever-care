<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientRequest extends Model
{
    protected $fillable = [
        'client_id',
        'request_custom_id',
        'type',
        'priority',
        'status',
        'description',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
