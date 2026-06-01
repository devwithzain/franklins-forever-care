<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'amount',
        'duration',
        'features',
        'color',
        'text_color',
        'popular',
        'status',
        'service_id',
    ];

    protected $casts = [
        'features' => 'array',
        'popular' => 'boolean',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
