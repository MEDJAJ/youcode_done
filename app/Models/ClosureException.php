<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClosureException extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'date',
        'reason',
    ];

    // Relation vers le restaurant
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}

