<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commentaire;
use App\Models\Restaurant;
class CommentaireController extends Controller
{
    public function publier(Request $request){
        $request->validate([
    'contenu' => 'required|min:3'
]);

Commentaire::create([
    'contenu' => $request->contenu,
    'restaurant_id' => $request->restaurant_id,
    'user_id' => auth()->id(),
]);

return redirect()->back();


    }
}
