<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Producto;

class ProductosController extends Controller
{
    //
    public function show($item) {
    	//echo "<br>ProductosController:".$item;
        session()->put('subMenu',$item);
        //echo "<br>sesion(submenu):".session()->get('subMenu');
    	$productos = DB::table('productos')
                         ->where('subMenu', '=',session()->get('subMenu'))
                         ->get();
    	//print_r( $productos);
    	$parametros = DB::table('parametros')->get();
        //$items = DB::table('menus')->get();
        $items = DB::table('menus')
                     ->orderBy('subMenu')
                     ->get();
        $ITEM = explode("-",$item);

        return view("productos.index",compact('parametros','items','productos','item','ITEM'));
        //return view('productos',compact('productos','parametros','items'));
    }



    public function buscar(Request $request){
        $strBuscar = $request->Input("txtBuscar");
        //echo "<br>Busca:". $strBuscar;
        $productos = DB::table('productos')
                         ->where('nombre', 'like', '%'.$strBuscar.'%')
                         ->orWhere('idProducto', 'like', '%'.$strBuscar.'%')
                         ->get();
        //print_r($productos);
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')

                     ->orderBy('subMenu')
                     ->get();
        $ITEM = array();
        return view("productos.index",compact('parametros','items','productos','ITEM'));

    }

    
}
