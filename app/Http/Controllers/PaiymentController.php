<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;

class PaiymentController extends Controller
{
   public function show($id){
    $reservation=Reservation::findOrFail($id);
   
       return view('vuesclient.paiement',compact('reservation'));
   }
}
