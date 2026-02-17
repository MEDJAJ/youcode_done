<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;


class StatistiqueController extends Controller
{
  public function statistique()
{
    // 👥 عدد العملاء
    $clients = Role::findByName('client')->users->count();
    $restaurateurs = Role::findByName('restaurateur')->users->count();

    // 🍽 عدد المطاعم
    $restaurants = Restaurant::count();
    $restaurantsActifs = Restaurant::where('status', true)->count();

    // ✅ عدد الحجوزات المؤكدة
    $reservationsConfirmees = Reservation::where('payment_status', 'paid')->count();
 
    // 🔥 Top 5 Restaurants (الأكثر حجوزات)
    $topRestaurants = Reservation::select('restaurant_id', DB::raw('COUNT(*) as total'))
        ->where('payment_status', 'paid')
        ->groupBy('restaurant_id')
        ->orderByDesc('total')
        ->with('restaurant')
        ->take(5)
        ->get();

    // ⏰ Pics horaires (الساعات الأكثر حجزاً)
    $picsHoraires = Reservation::select('time', DB::raw('COUNT(*) as total'))
        ->where('payment_status', 'paid')
        ->groupBy('time')
        ->orderByDesc('total')
        ->take(5)
        ->get();

    // 🌍 Restaurants par ville (Query Builder ONLY)
    $restaurantsParVille = DB::table('restaurants')
        ->select('location', DB::raw('COUNT(*) as total'))
        ->groupBy('location')
        ->orderByDesc('total')
        ->get();

    return view('vuesadmin.statistique', compact(
        'clients',
        'restaurateurs',
        'restaurants',
        'restaurantsActifs',
        'reservationsConfirmees',
        'topRestaurants',
        'picsHoraires',
        'restaurantsParVille'
    ));
}

}
