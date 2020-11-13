<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \App\Producto;
use \App\CatalogoProveedor;
use \App\Carro;
use PHPMailer\PHPMailer;


class CartcotizacionController extends Controller
{

    public function __Construct(){
        if(!\Session::has('carritoCotizacion')) \Session::put('carritoCotizacion',array());
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        echo "<br>Nueva Corizacion";
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();

        return view('admin.adminCotizacionInternoNuevo',compact('parametros','items'));
        
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        $carritoCotizacion = \Session::get('carritoCotizacion');
        \Session::put('carritoCotizacion-count',count($carritoCotizacion));
        //print_r( $carrito);
        return view('carritoCotizacion.index',compact('carritoCotizacion','parametros','items'));
    }


    public function add(Producto $producto){
        
        echo "<br>agrega";
        /*
        $carritoCotizacion = \Session::get('carritoCotizacion');
        $producto->cantidad =1 ;
        $carritoCotizacion[$producto->id] = $producto;
        $carritoCotizacion[$producto->id]->subtotal = $producto->cantidad * $producto->precio;
        //print_r($carrito);
        \Session::put('carritoCotizacion',$carritoCotizacion);
        \Session::put('carritoCotizacion-count',count($carritoCotizacion));
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        return view('carritoCotizacion.index',compact('carritoCotizacion','parametros','items'));
        */

    }

    public function trash(){
        \Session::forget('carritoCotizacion');
        \Session::put('carritoCotizacion',array());
        $carritoCotizacion = \Session::get('carritoCotizacion');
        \Session::put('carrito-count',count($carrito));
        //print_r($carrito);
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        return view('carritoCotizacion.index',compact('carritoCotizacion','parametros','items'));

    }

    public function delete( $id){
        $carritoCotizacion = \Session::get('carritoCotizacion');
        unset($carritoCotizacion[$id]);
        //print_r($carrito);

        \Session::put('carritoCotizacion',$carritoCotizacion);
        \Session::put('carritoCotizacion-count',count($carritoCotizacion));
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        $subMenu = session()->get('subMenu');
        return view('carritoCotizacion.index',compact('carritoCotizacion','parametros','items'));


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
    public function update(Request $request , CatalogoProveedor $producto)
    {
        //
        $carritoCotizacion = \Session::get('carritoCotizacion');
        $carritoCotizacion[$producto->id]->cantidad = $request->qty;
        $carritoCotizacion[$producto->id]->subtotal = $request->qty * $request->precio;
         \Session::put('carritoCotizacion',$carritoCotizacion);
        
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        $subMenu = session()->get('subMenu');
        return view('carritoCotizacion.index',compact('carritoCotizacion','parametros','items'));
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
    }


    public function pedido(){
        if( \Session::has('usuario') ) {
            //echo "<br>Usuario:". \Session::get('usuario');
            $usuario = DB::table('usuarios')
                       ->where('email',\Session::get('email'))
                       ->get();
            $parametros = DB::table('parametros')->get();
            $items = DB::table('menus')->get();
            $carrito = \Session::get('carrito');
            return view('carrito.solicitaPedido',compact('carrito','parametros','items'));
        }   else {
            //echo "<br>logearse";
            $parametros = DB::table('parametros')->get();
            $items = DB::table('menus')->get();
            return view('usuarios.index',compact('parametros','items'));
        }    

    }


    public function pedidoEnvia(Request $request) {
        $nombre  = $request->Input('name');
        $email   = $request->Input('email');
        $fonoContacto   = $request->Input('fonoContacto');
        $message = $request->Input('message');
        $codPedido = uniqid('');
        $codPedido = rand();
        $emailCC = "cssantam@gmail.com";

        
        $carrito = \Session::get('carrito');
        foreach( $carrito as $registro) {
          // echo "<br>linea". $registro->idProducto;
           $tblCarrito = new Carro;
           //$tblCarrito->idSession = \Session::getId();
           $tblCarrito->idSession = $codPedido;
           $tblCarrito->usuario = $email;
           $tblCarrito->nombreUsuario = $nombre;
           $tblCarrito->email = $email;
           $tblCarrito->fonoContacto = $fonoContacto;
           $tblCarrito->idProducto  = $registro->idProducto;
           $tblCarrito->nombreProducto  = $registro->nombre;
           $tblCarrito->precio  = $registro->precio;
           $tblCarrito->cantidad  = $registro->cantidad;
           $tblCarrito->subTotal  = $registro->cantidad*$registro->precio;
           $tblCarrito->estado = "pedido";
           $tblCarrito->save();
        }


        
        $body  = "<br><h3>Asis SpA</h3>";
        $body .= "<h4>Solicitud de Pedido</h4>";
        $body .= "<table>";
        $body .= "<tr><td>Nro Solicitud</td><td>".$codPedido."</td></tr>";
        $body .= "<tr><td>Nombre</td><td>".$nombre."</td></tr>";
        $body .= "<tr><td>Email</td><td>".$email."</td></tr>";
        $body .= "<tr><td>Fono</td><td>".$fonoContacto."</td></tr>";
        $body .= "<tr><td>Mensaje</td><td>".$message."</td></tr>";
        $body .= "</table>";
        $body .= "<br>";
        $body .= "<table border='1' width='70%'>";
        $body .= "<tr><td>CodProducto</td><td>Nombre</td><td>Cantidad</td><td>Precio</td><td>SubTotal</td></tr>";

        $carrito = \Session::get('carrito');
        $total = 0;
        foreach( $carrito as $registro) {
            $total += $registro->cantidad * $registro->precio;
            $body .= "<tr><td>". $registro->idProducto . "</td>";
            $body .= "<td>". $registro->nombre . "</td>";
            $body .= "<td align='right'>". number_format($registro->cantidad,0) . "</td>";
            $body .= "<td align='right'>". number_Format($registro->precio,0) . "</td>";
            $body .= "<td align='right'>". number_format($registro->cantidad * $registro->precio,0) . "</td></tr>";
                       
        }
        $body .=     "<tr><td></td><td><b>Total</b></td><td></td><td></td><td align='right'><b>". number_format($total,0) . "</b></td></tr>";
        $body .= "</table>";
        $body .= "<br><br>Fin del mensaje";


        //echo "<br>".$body;


         // Envia email  - asisfba@gmail.com
        $subject = "Pedido desde Portal Asis";
        $emailDestino = "asisfba@gmail.com";
        $emailCC = "cssantam@gmail.com";
        if( enviarEmail( $subject, $emailDestino, $emailCC, $body)) {
            \Session::forget('carrito');
            \Session::put('carrito-count',0);
            $parametros = DB::table('parametros')->get();
            $items = DB::table('menus')->get();
            return view("carrito.carritoPedidoEnviado",compact('parametros','items','codPedido'));
        } else {
            $parametros = DB::table('parametros')->get();
            $items = DB::table('menus')->get();
            return view("carrito.carritoPedidoEnviadoNoOk",compact('parametros','items'));
        }
        
    }


    public function pedidoInfoPago(Request $request){
         echo "<br>IrAPagar";
    }
}
