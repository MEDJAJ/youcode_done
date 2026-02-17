<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Restaurant;
use App\Models\Reservation;
use App\Notifications\NewReservationNotification;
use App\Models\User;

class ReservationController extends Controller
{




public function getSlots(Request $request, $id)
{

 
    $date = Carbon::parse($request->date);

    $restaurant = Restaurant::with('hours')->findOrFail($id);

  
    $dayName = $date->format('l');

    $hours = $restaurant->hours
                ->where('day', $dayName)
                ->first();

    if (!$hours) {
     
      
        return response()->json([]);
    }

   
    $open = Carbon::parse($hours->opening_time)
            ->setDate($date->year, $date->month, $date->day);

    $close = Carbon::parse($hours->closing_time)
            ->setDate($date->year, $date->month, $date->day);

    $slots = [];

    while ($open < $close) {
        $slots[] = $open->format('H:i');
        $open->addMinutes(30);
    }

  

    return response()->json($slots);
}




public function store(Request $request)
{
    $restaurant = Restaurant::findOrFail($request->restaurant_id);

    $amount = 10 * $request->guests;

    $reservation = Reservation::create([
        'user_id' => auth()->id(),
        'restaurant_id' => $restaurant->id,
        'date' => $request->date,
        'time' => $request->time,
        'guests' => $request->guests,
        'amount' => $amount,
        'payment_status' => 'unpaid',
    ]);

    
    $restaurateur = User::find($restaurant->user_id);

   
    $restaurateur->notify(new NewReservationNotification($reservation));

    return redirect()->route('paiement.show', $reservation->id);
}



}
