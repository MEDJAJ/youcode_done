<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\User;
use Spatie\Permission\Models\Role;

class StatistiqueController extends Controller
{
   public function statistique(){

    $clients = Role::findByName('client')->users->count();
    $restaurateurs = Role::findByName('restaurateur')->users->count();

    
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
