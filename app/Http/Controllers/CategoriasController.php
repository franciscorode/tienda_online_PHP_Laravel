<?php

namespace App\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Categoria;
use App\Producto;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class CategoriasController extends Controller {

    protected $rules = [
        'name' => ['required', 'min:3'],
        'slug' => ['required'],
    ];

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return view('categorias.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return view('categorias.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        $this->validate($request, $this->rules);
        $input = Input::all();
        Categorias::create($input);
        return Redirect::route('categorias.index')->with('message', 'Categoria created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Categorias $project
     * @return Response
     */
    public function show(Categoria $categoria) {
        //$categorias = Categoria::all();
        //$productos = $categoria->productos()->paginate();
        $productos = \App\Producto::idcategoria($categoria->id)->orderBy('name', 'DESC')->paginate(3);
        foreach ($productos as $producto) {
            $preciopromocional = ($producto->precio - (($producto->precio * $producto->descuento) / 100));
            $producto->preciopromocional = round($preciopromocional, 2);
        }
        return view('categorias.show', compact('categoria', 'productos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Categorias $project
     * @return Response
     */
    public function edit(Categorias $categoria) {
        return view('categorias.edit', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Categorias $project
     * @return Response
     */
    public function update(Categorias $categoria, Request $request) {
        $this->validate($request, $this->rules);
        $input = array_except(Input::all(), '_method');
        $categoria->update($input);
        return Redirect::route('categorias.show', $categorias->slug)->with('message', 'Categorias updated.');
    }

    public function destroy(Categorias $categoria) {
        $categoria->delete();
        return Redirect::route('categorias.index')->with('message', 'Categorias deleted.');
    }

    /*
     *  @if (!Session::has('busqueda'))
      <a style="margin:10px;" href="{{ route('ordenarprecio') }}">Ordenar por precio</a>
      <a style="margin:10px;" href="{{ route('ordenarpornombre') }}">Ordenar por orden alfabetico</a>
      @endif
     */

    public function search(Request $request) {
        //recogemos todos las categorias
        $categorias = \App\Categoria::all();
        Session::flash('mensaje', 'Resultado de la busqueda');
        Session::flash('busqueda', true);

        //si el usuario esta logeado
        if (Auth::check()) {

            //recogemos todos los productos con dicho nombre
            $productos = \App\Producto::name($request->get('word'))->orderBy('name', 'DESC')->paginate(100);
            foreach ($productos as $producto) {
                $preciopromocional = ($producto->precio - (($producto->precio * $producto->descuento) / 100));
                $producto->preciopromocional = round($preciopromocional, 2);
            }
            //redirigimos a la vista home enviando las categorias y los productos
            return view('home', compact('productos', 'categorias'));
        } else {
            //recogemos todos los productos con dicho nombre excepto si es un producto exclusivo
            $productos = \App\Producto::name($request->get('word'))->orderBy('name', 'DESC')->paginate(100);
            //redirigimos a la vista home enviando las categorias y los productos
            return view('welcome', compact('productos', 'categorias'));
        }
    }

    public function ordenarpornombrecategoria(Request $request) {
        //recogemos la categoria 
        $id = (int) $request->get('id');
        $categoria = \App\Categoria::first()->where('id', $id)->first();
        //recogemos todos los productos y los ordenamos por nombre
         $productosInit = $categoria->productos;

        foreach ($productosInit as $producto) {
            $preciopromocional = ($producto->precio - (($producto->precio * $producto->descuento) / 100));
            $producto->preciopromocional = round($preciopromocional, 2);
        }
        $productosInit2 = $productosInit->sortBy('name');
        
        //creamos un nuevo LengthAwarePaginator y le pasamos la coleccion de productos y demas parametros
        $page = (int)$request->get('page', 1); // Get the ?page=1 from the url
        $perPage = 4; // Number of items per page
        $offset = ($page * $perPage) - $perPage;
        $productos = new LengthAwarePaginator(
                $productosInit2->slice($offset, $perPage), // Only grab the items we need
                count($productosInit2), // Total items
                $perPage, // Items per page
                $page, // Current page
                ['path' => $request->url(), 'query' => $request->query()] // We need this so we can keep all old query parameters from the url
        );
        //redirigimos a la vista home con dichos productos
        return view('categorias.show', compact('productos', 'categoria'));
    }

    public function ordenarpreciocategoria(Request $request) {
        //recogemos la categoria 
        $id = (int) $request->get('id');
        $categoria = \App\Categoria::first()->where('id', $id)->first();
        $productosInit = $categoria->productos;
        //por cada producto de la categoria
        foreach ($productosInit as $producto) {
            //asignamos al producto su preciopromocional
            $preciopromocional = ($producto->precio - (($producto->precio * $producto->descuento) / 100));
            $producto->preciopromocional = round($preciopromocional, 2);
        }
        //si el usuario esta logeado ordenamos los productos por preciopromociona
        if(Auth::check()){
            $productosInit2 = $productosInit->sortBy('preciopromocional');
        //sino, ordenamos por precio
        } else {
            $productosInit2 = $productosInit->sortBy('precio');
        }

        //creamos un nuevo LengthAwarePaginator y le pasamos la coleccion de productos y demas parametros
        $page = (int)$request->get('page', 1); // Get the ?page=1 from the url
        $perPage = 4; // Number of items per page
        $offset = ($page * $perPage) - $perPage;
        $productos = new LengthAwarePaginator(
                $productosInit2->slice($offset, $perPage), // Only grab the items we need
                count($productosInit2), // Total items
                $perPage, // Items per page
                $page, // Current page
                ['path' => $request->url(), 'query' => $request->query()] // We need this so we can keep all old query parameters from the url
        );
        //redirigimos a la vista home con dichos productos
        return view('categorias.show', compact('productos', 'categoria'));
    }

}
