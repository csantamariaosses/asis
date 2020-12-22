<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \App\Producto;
use \App\Carro;
use \App\CarroDetalle;
use PHPMailer\PHPMailer;


class CartController extends Controller
{

    public function __Construct(){
        if(!\Session::has('carrito')) \Session::put('carrito',array());
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
        $items = DB::table('menus')
                     ->orderBy('subMenu')
                     ->get();
        $carrito = \Session::get('carrito');
        \Session::put('carrito-count',count($carrito));
        //print_r( $carrito);
        return view('carrito.index',compact('carrito','parametros','items'));
    }


    public function add(Producto $producto){

        $carrito = \Session::get('carrito');
        $producto->cantidad =1 ;
        $carrito[$producto->id] = $producto;
        $carrito[$producto->id]->subtotal = $producto->cantidad * $producto->precio;
        //print_r($carrito);
        \Session::put('carrito',$carrito);
        \Session::put('carrito-count',count($carrito));
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')
                     ->orderBy('subMenu')
                     ->get();
        return view('carrito.index',compact('carrito','parametros','items'));


    }

    public function trash(){
        \Session::forget('carrito');
        \Session::put('carrito',array());
        $carrito = \Session::get('carrito');
        \Session::put('carrito-count',count($carrito));
        //print_r($carrito);
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')
                     ->orderBy('subMenu')
                     ->get();
        return view('carrito.index',compact('carrito','parametros','items'));

    }

    public function delete( $id){
        $carrito = \Session::get('carrito');
        unset($carrito[$id]);

        \Session::put('carrito',$carrito);
        \Session::put('carrito-count',count($carrito));
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')
                     ->orderBy('subMenu')
                     ->get();
        $subMenu = session()->get('subMenu');
        return view('carrito.index',compact('carrito','parametros','items'));


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
    public function update(Request $request , Producto $producto)
    {
        //
        $carrito = \Session::get('carrito');
        $carrito[$producto->id]->cantidad = $request->qty;
        $carrito[$producto->id]->subtotal = $request->qty * $request->precio;
         \Session::put('carrito',$carrito);
        
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')
                      ->orderBy('subMenu')
                      ->get();
        $subMenu = session()->get('subMenu');
        return view('carrito.index',compact('carrito','parametros','items'));
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
            $items = DB::table('menus')
                        ->orderBy('subMenu')
                        ->get();
            $carrito = \Session::get('carrito');
            return view('carrito.solicitaPedido',compact('carrito','parametros','items'));
        }   else {
            //echo "<br>logearse";
            $parametros = DB::table('parametros')->get();
            $items = DB::table('menus')
                       ->orderBy('subMenu')
                       ->get();
            return view('usuarios.index',compact('parametros','items'));
        }    

    }


    public function pedidoEnvia(Request $request) {
        
        
        $nombre = session('nombre');
        $email  = session('email');
        $fonoContacto  = session('fonoContacto');
        $message = $request->Input('message');
        
        //echo "message:" . $message."*";
        //exit();
        
        $codPedido = rand();
        $emailCC = "cssantam@gmail.com";
        
        $total = 0;
        $carrito = \Session::get('carrito');
        
        // LLena Carrito Detalle
        try {
        foreach( $carrito as $registro) {
           $total+=$registro->cantidad*$registro->precio;    
            
           $tblCarritoDetalle = new CarroDetalle;
           $tblCarritoDetalle->codigo = $codPedido;
           $tblCarritoDetalle->codProducto  = $registro->idProducto;
           $tblCarritoDetalle->producto  = $registro->nombre;
           $tblCarritoDetalle->precio  = $registro->precio;
           $tblCarritoDetalle->cantidad  = $registro->cantidad;
           $tblCarritoDetalle->subTotal  = $registro->cantidad*$registro->precio;
           $tblCarritoDetalle->estado = "pedido";
           $tblCarritoDetalle->save();
        }
        } catch(Exception $ex) {
            $parametros = DB::table('parametros')->get();
            $items = DB::table('menus')
                         ->orderBy('subMenu')
                         ->get();
            return view("carrito.carritoPedidoEnviadoNoOk",compact('parametros','items'));
        }
        
        // Crea Fila en Carrito PPal
        $now = date('d-m-Y H:i:s'); 
        try {
        $tblCarrito = new Carro;
        $tblCarrito->codigo = $codPedido;
        $tblCarrito->usuario = $request->Input('email');;
        $tblCarrito->nombreUsuario =  $request->Input('name');;
        $tblCarrito->email = $request->Input('email');;
        $tblCarrito->fonoContacto = $request->Input('fonoContacto');
        $tblCarrito->total = $total;
        $tblCarrito->observaciones = $message;
        $tblCarrito->estado = "pedido";
        $tblCarrito->fecha = $now;
        $tblCarrito->save();
        } catch(Exception $ex) {
            $parametros = DB::table('parametros')->get();
            $items = DB::table('menus')->get();
            return view("carrito.carritoPedidoEnviadoNoOk",compact('parametros','items'));
        } 
        
        // Crear correo
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
        //$emailDestino = "asisfba@gmail.com";
        $emailDestino = "asisfba@gmail.com";
        $emailCC = "cssantam@gmail.com";
        if( enviarEmail( $subject, $emailDestino, $emailCC, $body)) {
            \Session::forget('carrito');
            \Session::put('carrito-count',0);
            $parametros = DB::table('parametros')->get();
            $items = DB::table('menus')
                         ->orderBy('subMenu')
                         ->get();
            return view("carrito.carritoPedidoEnviado",compact('parametros','items','codPedido'));
        } else {
            $parametros = DB::table('parametros')->get();
            $items = DB::table('menus')
                         ->orderBy('subMenu')
                         ->get();
            return view("carrito.carritoPedidoEnviadoNoOk",compact('parametros','items'));
        }
        
    }


    public function pedidoInfoPago(Request $request){
         echo "<br>IrAPagar";
    }
}

