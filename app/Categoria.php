<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $guarded = [];
    
    public function productos()
    {
	    return $this->hasMany('App\Producto');
    }
	
    public function getRouteKeyName() 
    {
        return 'slug';
    }
    
    //funcion que consulta los productos de la bdd que tengan el id de la categoria pasado por parametro
    public function scopeIdcategoria($query, $id){
        
        $query->where('id', $id);
    }
}
