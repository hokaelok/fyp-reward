<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'point_id',
        'transaction_type',
        'point',
        'consumer_pickup_id',
        'reward_id',
    ];

    protected $hidden = [
        'updated_at',
    ];

    protected $casts = [];

    public function point()
    {
        return $this->belongsTo(Point::class);
    }

    public function reward()
    {
        return $this->belongsTo(Reward::class);
    }
}
