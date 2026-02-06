<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
  protected $fillable=[
    'nom',
    'location',
    'type_de_cuisin',
    'capacity',
    'user_id',
    'status',
    'is_delete',
  ];

  public function photos(){
      return $this->hasMany(Photo::class);
  }
  public function menus(){
    return $this->hasMany(Menu::class);
  }

  public function user(){
   return $this->belongsTo(User::class);
  }

  public function commentaires(){
    return $this->hasMany(Commentaire::class);
  }

  public function favorites()
{
    return $this->hasMany(Favorite::class);
}

public function isFavorited()
{
    return $this->favorites->where('user_id', auth()->id())->count();
}


}
