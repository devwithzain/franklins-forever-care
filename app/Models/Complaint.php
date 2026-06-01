<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = [
        'client_id',
        'subject',
        'description',
        'priority',
        'status',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}