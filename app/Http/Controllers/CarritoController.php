<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Carrito;

class CarritoController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //echo "<br>carritoController";
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        $carrito = DB::table('carritos')
                       ->where('idSession','=',session()->getId())
                       ->get();
        return view("carrito.index",compact('parametros','items','carrito'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $hdId = $request->Input('hdId');
        $hdIdProducto = $request->Input('hdIdProducto');
        $hdNombre = $request->Input('hdNombre');
        $hdPrecio = $request->Input('hdPrecio');
        $usuario = null;
        if( session()->has('usuario') ) {
            $usuario = session()->get('usuario');
        } else {
            $usuario = "";
        }
        
        if( !$this->productoEnCarrito($hdIdProducto )  ) {
            /*
            echo "<br>store";
            echo "<br>sessionId".session()->getId();
            echo "<br>usuario".$usuario;
            echo "<br>id".$hdId;
            echo "<br>hdIdProducto".$hdIdProducto;
            echo "<br>nombre".$hdNombre;
            echo "<br>precio".$hdPrecio;
*/
            $carrito =  new Carrito();
            $carrito->idSession = session()->getId();
            $carrito->usuario = $usuario;
            $carrito->idProducto = $hdIdProducto;
            $carrito->nombre     = $hdNombre;
            $carrito->precio = $hdPrecio;    
            $carrito->cantidad = 1;    
            $carrito->subtotal = $hdPrecio;
            $carrito->fecha =  date('Y-m-d H:i:s'); 
            $carrito->estado =  'pendiente'; 
            $carrito->save();

        } 
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        $carrito = DB::table('carritos')->get();
        return view("carrito.index",compact('parametros','items','carrito'));
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        //echo "<br>Update:".$id;
        //echo "<br>Cant:".$request->qty;
        //echo "<br>precio:".$request->precio;
        $subtotal =  $request->qty * $request->precio;       
        $carrito = \DB::table('carritos')
                       ->where('idProducto',$id)
                       ->update( [ 'cantidad' => $request->qty,
                                   'subtotal' => $subtotal]);
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        $carrito = DB::table('carritos')->get();
        return view("carrito.index",compact('parametros','items','carrito'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $carrito = \DB::table('carritos')
                       ->where('idProducto',$id)
                       ->delete();
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        $carrito = DB::table('carritos')->get();
        return view("carrito.index",compact('parametros','items','carrito'));                       
    }


    public function productoEnCarrito($idProducto ) {
        $id = DB::table('carritos')
                  ->where('idProducto',$idProducto)
                  ->value('id');
        if( $id) {
            return $id;
        } else {
            return 0;
        }
    }


    public function vaciar(){
        $carrito = \DB::table('carritos')
                       ->delete();
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        $carrito = DB::table('carritos')->get();
        return view("carrito.index",compact('parametros','items','carrito'));
    }


}
