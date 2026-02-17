<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClosureException;

class ClosureExceptionController extends Controller
{
        public function store(Request $request)
    {
    
     
        $request->validate([
            'date' => 'required|date',
            'reason' => 'required|string|max:255',
        ]);

       
        ClosureException::create([
            'restaurant_id' => $request->restaurant_id, 
            'date' => $request->date,
            'reason' => $request->reason
        ]);

        return redirect()->back()->with('success_closure', 'Date bloquée avec succès !');
    }


  

  
    public function deleteClosure($id)
    {
        $closure = ClosureException::findOrFail($id);
        $closure->delete();

        return redirect()->back()->with('success', 'Fermeture exceptionnelle supprimée avec succès !');
    }
}
