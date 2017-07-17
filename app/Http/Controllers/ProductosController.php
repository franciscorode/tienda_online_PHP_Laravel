<?php namespace App\Http\Controllers;
 
use App\Categoria;
use App\Producto;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
 
use Illuminate\Http\Request;
 
class ProductosController extends Controller {
 
    protected $rules = [
		'name' => ['required', 'min:3'],
		'slug' => ['required'],
		'description' => ['required'],
    ];
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Project $project
     * @return Response
     */
    public function index(Categoria $categoria)
    {
        return view('productos.index', compact('categoria'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Project $project
     * @return Response
     */
    public function create(Categoria $categoria)
    {
        return view('productos.create', compact('categoria'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Project $project
     * @return Response
     */
    public function store(Categoria $categoria, Request $request)
    {
        //obtenemos el campo file definido en el formulario
        $file = $request->file('img');

        //obtenemos el nombre del archivo
        $nombre = $file->getClientOriginalName();
        $random = rand(0,10000)+"";
        //indicamos que queremos guardar un nuevo archivo en el disco local
        \Storage::disk('local')->put($random.$nombre, \File::get($file));


        $this->validate($request, $this->rules);

        $input = Input::all();
        $input['categoria_id'] = $project->id;
        Producto::create( $input );

        //return Redirect::route('projects.show', $project->slug)->with('producto created.');
        return Redirect::route('categorias.show', $categoria->slug)->with('message','producto created.');
    }

    public function save(Request $request) 
    {
        return "archivo guardado";
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project $project
     * @param  \App\producto    $producto
     * @return Response
     */
    public function show(Categoria $categoria, Producto $producto)
            
    {
        
            $preciopromocional = ($producto->precio - (($producto->precio * $producto->descuento) / 100)); 
            $producto->preciopromocional = round($preciopromocional, 2);
        
        return view('productos.show', compact('categoria', 'producto'));
    }


    public function getRouteKeyName() 
    {
        return 'slug';
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project $project
     * @param  \App\producto    $producto
     * @return Response
     */
    public function edit(Categoria $categoria, Producto $producto)
    {
        return view('productos.edit', compact('categoria', 'producto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Project $project
     * @param  \App\producto    $producto
     * @return Response
     */
    public function update(Categoria $categoria, Producto $producto, Request $request)
    {
        $file = $request->file('img');

        //obtenemos el nombre del archivo
        if ($file != null) {
            $nombre = $file->getClientOriginalName();
            //indicamos que queremos guardar un nuevo archivo en el disco local
            \Storage::disk('local')->put($nombre, \File::get($file));
        }


        $this->validate($request, $this->rules);
        $input = array_except(Input::all(), '_method');


        if ($file != null) {
            $input['img'] = $nombre;
        }


        $producto->update($input);
        return Redirect::route('categorias.productos.show', [$categoria->slug, $producto->slug])->with('message', 'producto updated.');
    }

    public function destroy(Categoria $categoria, Producto $producto)
    {
        $producto->delete();
        return Redirect::route('categoria.show', $categoria->slug)->with('message', 'producto deleted.');
    }
  
    
    
    

     public function ordenarprecio(){
        $categorias = \App\Categoria::all();
        $productos = \App\Producto::all();
        
        //por cada producto
        foreach ($productos as $producto) {
            //recogemos el precio promocional, se lo asignamos al prodcuto y lo guardamos en la bdd
            $preciopromocional = ($producto->precio - (($producto->precio * $producto->descuento) / 100)); 
            $producto->preciopromocional = round($preciopromocional, 2);
            $producto->save();
        }
        //volvemos a recoger los productos esta vez ordenados por preciopromocional
        $productos = \App\Producto::orderBy('preciopromocional', 'ASC')->paginate(4);
        //redirigimos a la vista home con dichos productos
        return view('home', compact('productos', 'categorias'));
    }
    
    public function ordenarpornombre(){
        $categorias = \App\Categoria::all();
        //recogemos todos los productos y los ordenamos por nombre
        $productos = \App\Producto::orderBy('name', 'ASC')->paginate(4);
        //le asignamos el precio promocional a cada producto
        foreach ($productos as $producto) {
            $preciopromocional = ($producto->precio - (($producto->precio * $producto->descuento) / 100)); 
            $producto->preciopromocional = round($preciopromocional, 2);
        }
        //redirigimos a la vista home con dichos productos
        return view('home', compact('productos', 'categorias'));
    }
    
    
 
}