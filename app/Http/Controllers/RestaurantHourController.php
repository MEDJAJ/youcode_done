<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RestaurantHour;
use Illuminate\Support\Facades\Auth;
class RestaurantHourController extends Controller
{
 public function store(Request $request)
    {
       
        $request->validate([
            'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'opening_time' => 'required|date_format:H:i',
            'closing_time' => 'required|date_format:H:i|after:opening_time',
            'interval_minutes' => 'required|integer|min:5',
        ]);

        RestaurantHour::create([
            'restaurant_id' => $request->restaurant_id, 
            'day' => $request->day,
            'opening_time' => $request->opening_time,
            'closing_time' => $request->closing_time,
            'interval_minutes' => $request->interval_minutes,
        ]);

        return redirect()->back()->with('success', 'Horaires ajoutés avec succès !');
    }

      
    public function deleteHour($id)
    {
        $hour = RestaurantHour::findOrFail($id);
        $hour->delete();

        return redirect()->back()->with('success', 'Horaires supprimés avec succès !');
    }
}
