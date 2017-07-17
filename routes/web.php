<?php
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//ruta raiz
Route::get('/', function () {
    //recogemos las categorias
    $categorias = \App\Categoria::all();
    //recogemos los productos excepto aquellos que sean exclusivos para los usuarios logeados
    $productos = \App\Producto::exclusivo()->orderBy('name', 'DESC')->paginate(4);
    //redirigimos a la vista home enviando las categorias y los productos
    return view('welcome', compact('productos', 'categorias'));
    
});

Route::resource('categorias', 'CategoriasController');
Route::resource('categorias.productos', 'ProductosController');

Route::model('categorias', 'categoria');
Route::model('productos', 'producto');


Route::bind('productos', function($value, $route) {
	return App\producto::whereSlug($value)->first();
});
Route::bind('categorias', function($value, $route) {
	return App\Categoria::whereSlug($value)->first();
});



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/user/edit', "ProfilesController@edit")->name('user/edit');

Route::get('/user/save', "ProfilesController@save")->name('user/save');

Route::get('/user/delete', "ProfilesController@delete")->name('user/delete');

Route::get('/search', "CategoriasController@search")->name('search');

Route::get('/ordenarprecio', "ProductosController@ordenarprecio")->name('ordenarprecio');

Route::get('/ordenarpornombre', "ProductosController@ordenarpornombre")->name('ordenarpornombre');

Route::get('/ordenarpreciocategoria', "CategoriasController@ordenarpreciocategoria")->name('ordenarpreciocategoria');

Route::get('/ordenarpornombrecategoria', "CategoriasController@ordenarpornombrecategoria")->name('ordenarpornombrecategoria');


Route::get('/respuesta', function(){
    //recogemos las categorias
    $categorias = \App\Categoria::all();
    //recogemos los productos excepto aquellos que sean exclusivos para los usuarios logeados
    $productos = \App\Producto::exclusivo()->orderBy('name', 'DESC')->paginate();
    Auth::logout();
    //redirigimos a la vista home enviando las categorias y los productos
    return view('welcome', compact('productos', 'categorias'));
});

Route::get('activacion/{code}', 'UserController@activate');


Route::post('complete/{id}', 'UserController@complete');

Route::get('tiendascerca', 'SoapController@show')->name('tiendascerca');

Route::get('/edit/autocompletar', 'UserController@peticionyrespuesta')->name('edit/autocompletar');