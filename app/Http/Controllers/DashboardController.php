<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
class DashboardController extends Controller
{
    public function restaurateur(){
        $restaurants=Restaurant::with(['menus','photos'])->get();
        return view('vuesrestaurateur.dashboard',compact('restaurants'));
    }


    public function admin(){
         $restaurants=Restaurant::with(['menus','photos'])->get();
        return view('vuesadmin.dashboard',compact('restaurants'));
    }


      public function client(){
          $restaurants=Restaurant::with(['menus','photos'])->get();
        return view('vuesclient.dashboard',compact('restaurants'));
    }


    
}
