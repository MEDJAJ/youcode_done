<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantHour extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'day',
        'opening_time',
        'closing_time',
        'interval_minutes',
    ];

 
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}



