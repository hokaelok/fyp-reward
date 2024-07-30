<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'point',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [];

    public function pointTransactions()
    {
        return $this->hasMany(PointTransaction::class);
    }
}
