<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Photo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\RestaurantHour;
use App\Models\ClosureException;

class RestaurantController extends Controller
{
   


public function store(Request $request)
{
    DB::beginTransaction();

    try {

      
        $request->validate([
            'name' => 'required',
            'location' => 'required',
            'type' => 'required',
            'capacity' => 'required|integer',
        ]);

        
        $restaurant = Restaurant::create([
            'nom' => $request->name,
            'location' => $request->location,
            'type_de_cuisin' => $request->type,
            'capacity' => $request->capacity,
            'user_id' => auth()->id(),
             'status' => true ,
            
        ]);

      
        if ($request->hasFile('images')){
            foreach ($request->file('images') as $image) {

                $path = $image->store('restaurants', 'public');

                $restaurant->photos()->create([
                    'path' => $path
                ]);
            }
        }

       
        if ($request->menus) {

            foreach ($request->menus as $menuData) {

                $menu = $restaurant->menus()->create([
                    'nom' => $menuData['name'] ?? null,
                    'description' => $menuData['desc'] ?? null
                ]);

                if (isset($menuData['plats'])) {

                    foreach ($menuData['plats'] as $platData) {

                        $menu->plats()->create([
                            'nom' => $platData['n'] ?? null,
                            'description' => $platData['d'] ?? null,
                            'prix' => $platData['p'] ?? 0,
                        ]);
                    }
                }
            }
        }

        DB::commit();

        return redirect()->route('dashboard.restaurateur');

    } catch (\Exception $e) {

        DB::rollBack();

        return back()->with('error', $e->getMessage());
    }

    
}



public function destory($id)
{
    $restaurant = Restaurant::findOrFail($id);

    
    if ($restaurant->user_id != auth()->id()) {
        abort(403);
    }

    $restaurant->delete();

    return redirect()->back()->with('success', 'Restaurant supprimé');
}



public function edit($id)
{
    $restaurant = Restaurant::findOrFail($id);

    if ($restaurant->user_id != auth()->id()) {
        abort(403);
    }

    return view('vuesrestaurateur.edit_restaurant', compact('restaurant'));
}




public function update(Request $request, $id)
{
    $restaurant = Restaurant::findOrFail($id);

    if ($restaurant->user_id != auth()->id()) {
        abort(403);
    }

   
    $restaurant->update([
        'nom' => $request->name,
        'location' => $request->location,
        'type_de_cuisin' => $request->type,
        'capacity' => $request->capacity,
        'status' => $request->status
    ]);


    if ($request->delete_images) {

        foreach ($request->delete_images as $photoId) {

            $photo = Photo::find($photoId);

            if ($photo) {

                
                Storage::disk('public')->delete($photo->path);

              
                $photo->delete();
            }
        }
    }

    

    if ($request->hasFile('images')) {

        foreach ($request->file('images') as $image) {

            $path = $image->store('restaurants', 'public');

            $restaurant->photos()->create([
                'path' => $path
            ]);
        }
    }

    return redirect()->route('dashboard.restaurateur');

}


public function detail($id){
     $restaurants=Restaurant::with(['menus','photos'])->findOrFail($id);
     $commentaires = Restaurant::with('commentaires.user')->find($id);
    return view('vuesclient.details',compact('restaurants','commentaires'));
}


public function search(Request $request)
{
    $search = $request->search;

    $restaurants = Restaurant::with('photos')
        ->where('nom', 'LIKE', "%$search%")
        ->orWhere('location', 'LIKE', "%$search%")
        ->orWhere('type_de_cuisin', 'LIKE', "%$search%")
        ->get();

    return view('vuesclient.dashboard', compact('restaurants'));
}



public function destroysoft($id)
{
    $restaurant = Restaurant::findOrFail($id);


    
    $restaurant->is_delete = true;
    $restaurant->save();

    return redirect()->back()->with('success', 'Restaurant marqué comme supprimé');
}





public function show($id)
{
    $restaurant = DB::table('restaurants')
        ->select('id','nom', 'location', 'type_de_cuisin')
        ->where('id', $id)
        ->first();


    return view('vuesclient.reservation',compact('restaurant'));
}


public function disponible($id){
   
    return view('vuesrestaurateur.disponibiliter',compact('id'));
}





     public function getSchedule($id)
    {
        // Récupérer tous les horaires du restaurant
        $hours = RestaurantHour::where('restaurant_id', $id)
                    ->orderBy('day')
                    ->get();

        // Récupérer toutes les fermetures exceptionnelles
        $closures = ClosureException::where('restaurant_id', $id)
                    ->orderBy('date')
                    ->get();

                   

       
        return view('vuesrestaurateur.disponibiliter', compact('hours', 'closures', 'id'));
    }
}






