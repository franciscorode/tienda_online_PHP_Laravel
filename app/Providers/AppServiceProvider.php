<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $productos = \App\Producto::all();
        foreach ($productos as $producto) {
            $preciopromocional = ($producto->precio - (($producto->precio * $producto->descuento) / 100)); 
            $producto->preciopromocional = round($preciopromocional, 2);
        }
		//Schema::defaultStringLength(191);
                $categorias = \App\Categoria::all();
                view()->share(compact('categorias', 'productos'));
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
