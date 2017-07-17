<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //recogemos todos las categorias y toddos los productos
        $categorias = \App\Categoria::all();
        $productos = \App\Producto::paginate();
        foreach ($productos as $producto) {
            $preciopromocional = ($producto->precio - (($producto->precio * $producto->descuento) / 100)); 
            $producto->preciopromocional = round($preciopromocional, 2);
        }
        //redirigimos a la vista home enviando las categorias y los productos
        return view('home', compact('productos', 'categorias'));
    }

    
    
     
}
