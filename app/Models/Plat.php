<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plat extends Model
{
  protected $fillable=[
    'nom',
    'description',
    'menu_id',
    'prix'
  ];

  public function menu(){
   return $this->belongsTo(Menu::class);

  }
}
