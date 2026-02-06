<?php

namespace App\Http\Controllers;
use App\Models\Favorite;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
 

public function toggle($id)
{
    $favorite = Favorite::where('user_id', Auth::id())
        ->where('restaurant_id', $id)
        ->first();

    if ($favorite) {
        $favorite->delete(); 
    } else {
        Favorite::create([
            'restaurant_id' => $id,
            'user_id' => Auth::id()
        ]);
    }

    return back();
}

public function afficher(){
$restaurants = Restaurant::whereHas('favorites', function($query) {
    $query->where('user_id', auth()->id());
})->with(['favorites', 'photos'])->get();

return view('vuesclient.favorite',compact('restaurants'));

}
}
