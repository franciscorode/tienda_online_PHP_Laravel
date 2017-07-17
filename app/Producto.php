<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $guarded = [];
    //limitamos la vista de productos en 8 por pagina
    protected $perPage = 4;
	
    public function categoria()
    {
	    return $this->belongsTo('App\Categoria');
    }

    public function getRouteKeyName() 
    {
        return 'slug';
    }
    
    //funcion que consulta los productos de la bdd con el nombre pasado por parametro
    public function scopeName($query, $name){
        
        $query->where("name", 'like','%'.$name.'%');
    }     
    //funcion que consulta los productos de la bdd  que no son exclusivos
    public function scopeExclusivo($query){
        
        $query->where('destacado', 1);
    }
    //funcion que consulta los productos de la bdd que tengan el id de la categoria pasado por parametro
    public function scopeIdcategoria($query, $id){
        
        $query->where('categoria_id', $id);
    }

}
