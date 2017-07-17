<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
/**
 * Description of ProfilesController
 *
 * @author 2daw
 */
class ProfilesController {
    //put your code here
    
    
    public function edit(){
        //recogemos el usuario
        if($user = Auth::user()){
            ////redirigimos a la vista edit enviando el usuario
            return view("auth.edit")->with('user' , $user);
        } else {
            return view("auth.login")->with('user' , $user);
        }
    }
    
    public function save(Request $request){
        //recogemos el usuario
        if($user = Auth::user()){
            //modificamos sus atributos
            $user->name = $request->get('name');
            if($request->get('email')){
                $user->email = $request->get('email');
            }
            $user->apellidos = $request->get('apellidos');
            if($request->get('foto')){
                $user->foto = $request->get('foto');
            }
            $user->interes = $request->get('interes');
            $user->pais = $request->get('pais');
            //guardamos los cambios del usuario en la bdd
            $user->save();
            //borramos los datos de la sesion
            Session::forget('name');
            Session::forget('email+');
            Session::forget('apellidos');
            Session::forget('foto');
            Session::forget('interes');
            Session::forget('pais');


            Session::flash('mensaje', 'El usuario se ha modificado');
            //redirigimos a la vista home con las categorias y los productos
            $categorias = \App\Categoria::all();
            $productos = \App\Producto::paginate();
            foreach ($productos as $producto) {
                $preciopromocional = ($producto->precio - (($producto->precio * $producto->descuento) / 100)); 
                $producto->preciopromocional = round($preciopromocional, 2);
            }
            return view('home', compact('productos', 'categorias'));
        } else {
            return view("auth.login")->with('user' , $user);
        }
    }
    
    public function delete(){
        //recogemos el usuario y lo borramos de la bdd
        $user = Auth::user();

        $user->destroy($user->id);
        
        Auth::logout();
        Session::flash('mensaje', 'El usuario se ha eliminado');
        
        return view('auth.login');
    }
    
}
