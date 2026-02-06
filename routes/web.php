<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\StatistiqueController;
use App\Models\Restaurant;
Route::get('/', function (){
    return view('welcome');
});

Route::get('/dashboard', function (){
     $restaurants=Restaurant::with(['menus','photos'])->get();
        return view('vuesrestaurateur.dashboard',compact('restaurants'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function (){
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';




Route::middleware(['auth'])->group(function() {
    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
    Route::get('/dashboard/restaurateur', [DashboardController::class, 'restaurateur'])->name('dashboard.restaurateur');
    Route::get('/dashboard/client', [DashboardController::class, 'client'])->name('dashboard.client');
});


Route::get('/create',function(){
    return view('vuesrestaurateur.create_restaurant');
});

Route::post('/store',[RestaurantController::class,'store'])->name('res.store');

Route::delete('/supprimer/{id}',[RestaurantController::class,'destory'])->name('restaurants.destroy');

Route::get('/edit/{id}',[RestaurantController::class,'edit'])->name('restaurants.edit');

Route::put('/update/{id}',[RestaurantController::class,'update'])->name('restaurants.update');

Route::get('/details/{id}',[RestaurantController::class,'detail'])->name('restaurant.detail');

Route::get('/dashboard/client/search',[RestaurantController::class,'search'])->name('restaurants.search');
Route::post('/avis/publier',[CommentaireController::class,'publier'])->name('restaurants.publier');

Route::post('/favorite/{id}', [FavoriteController::class, 'toggle'])
    ->name('favorite.toggle')
    ->middleware('auth');

Route::get('/restaurants/favorite',[FavoriteController::class,'afficher'])->name('restaurants.favorite');

Route::post('/restaurant/{id}',[RestaurantController::class,'destroysoft'])->name('restaurants.destroysoft');

Route::get('/statistique/afficher',[StatistiqueController::class,'statistique'])->name('res.statistique');