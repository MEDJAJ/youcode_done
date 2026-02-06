<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\User;
class StatistiqueController extends Controller
{
   public function statistique(){

    $clients = User::where('role','client')->count();
    
$restaurateurs = User::where('role','restaurateur')->count();

    
    $restaurants = Restaurant::count();


    $restaurantsActifs = Restaurant::where('status', true)->count();

    return view('vuesadmin.statistique', compact(
        'clients',
        'restaurateurs',
        'restaurants',
        'restaurantsActifs'
    ));
     
   }
}
