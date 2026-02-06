<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\StatistiqueController;
use App\Models\Restaurant;


Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);


Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);


Route::get('/dashboard', function (){
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


Route::get('/', function () {
    return view('welcome');
});

require __DIR__.'/auth.php';



Route::middleware(['auth'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});




Route::middleware(['auth','role:admin'])->group(function () {

    Route::get('/dashboard/admin',
        [DashboardController::class,'admin']
    )->name('dashboard.admin');

    Route::get('/statistique/afficher',
        [StatistiqueController::class,'statistique']
    )->name('res.statistique');

    Route::post('/restaurant/{id}',[RestaurantController::class,'destroysoft'])->name('restaurants.destroysoft');

});




Route::middleware(['auth','role:restaurateur'])->group(function () {

    Route::get('/dashboard/restaurateur',
        [DashboardController::class,'restaurateur']
    )->name('dashboard.restaurateur');

    Route::get('/create', function () {
        return view('vuesrestaurateur.create_restaurant');
    });

    Route::post('/store',
        [RestaurantController::class,'store']
    )->name('res.store');

    Route::get('/edit/{id}',
        [RestaurantController::class,'edit']
    )->name('restaurants.edit');

    Route::put('/update/{id}',
        [RestaurantController::class,'update']
    )->name('restaurants.update');

    Route::delete('/supprimer/{id}',
        [RestaurantController::class,'destory']
    )->name('restaurants.destroy');

});




Route::middleware(['auth','role:client'])->group(function () {

    Route::get('/dashboard/client',
        [DashboardController::class,'client']
    )->name('dashboard.client');

    Route::post('/favorite/{id}',
        [FavoriteController::class,'toggle']
    )->name('favorite.toggle');

    Route::post('/avis/publier',
        [CommentaireController::class,'publier']
    )->name('restaurants.publier');

    Route::get('/restaurants/favorite',
        [FavoriteController::class,'afficher']
    )->name('restaurants.favorite');

});



Route::middleware(['auth'])->group(function () {

    Route::get('/details/{id}',
        [RestaurantController::class,'detail']
    )->name('restaurant.detail');

    Route::get('/dashboard/client/search',
        [RestaurantController::class,'search']
    )->name('restaurants.search');

});
