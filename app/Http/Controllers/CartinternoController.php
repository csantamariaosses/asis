<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \App\Producto;
use \App\Carro;
use \App\Cotizacioninterna;
use PHPMailer\PHPMailer;
use PDF;


class CartinternoController extends Controller
{

    public function __Construct(){
        if(!\Session::has('cartInterno')) \Session::put('carritoInterno',array());
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        $subMenu = session()->get('subMenu');
        $carritoInterno = DB::table('cotizacioninternas')
                          ->get();

        
        return view('admin.adminCotizacionInternoListar',compact('carritoInterno','parametros','items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        echo "<br>Create Nueva Cotiz Interna";
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        return view('admin.adminCotizacionInternoNuevo',compact('parametros','items'));
        
    }


    public function saveCabecera(Request $request)
    {
        $nombre      = $request->Input('nombre');
        $descripcion = $request->Input('descripcion');
        
        $codigo = rand();
        $usuario = \Session::get('usuario');
        $tblCarrito = new Cotizacioninterna;
        $tblCarrito->codigo = $codigo;
        $tblCarrito->usuario = $usuario;
        $tblCarrito->nombre = $nombre;
        $tblCarrito->descripcion = $descripcion;
        $tblCarrito->save();
        
        
        
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        $carritoInterno = DB::table('cotizacioninternas')
                          ->get();
        return view('admin.adminCotizacionInternoListar',compact('carritoInterno','parametros','items'));
        
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
        echo "<br>Guardar";
        
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
        $subMenu = session()->get('subMenu');
        $carritoInterno = \Session::get('carritoInterno');
        $fecha = date('d-m-Y');
        
        return view('admin.adminCarritoInterno',compact('carritoInterno','parametros','items'));
        
    }


    public function add( $idProducto){
        //\Session::forget('carritoInterno');
        
        
        $carritoInterno = \Session::get('carritoInterno');
        $producto = DB::table('catalogoProveedores')
                          ->where( 'id',$idProducto)
                          ->get();
        /*
        echo "<br>id". $producto[0]->id;
        echo "<br>prov". $producto[0]->proveedor;
        echo "<br>prod". $producto[0]->producto;
        echo "<br>pre". $producto[0]->precio;
        */
        
        
        if( empty( $carritoInterno[$idProducto]['id'] )  ) {
            $carritoInterno[$idProducto]['id'] = $producto[0]->id;
            $carritoInterno[$idProducto]['proveedor'] = $producto[0]->proveedor;
            $carritoInterno[$idProducto]['producto'] = $producto[0]->producto;
            $carritoInterno[$idProducto]['cantidad'] = 1;
            $carritoInterno[$idProducto]['precio'] = $producto[0]->precio;
            $carritoInterno[$idProducto]['subtotal'] = $producto[0]->precio;
        } else {
            $carritoInterno[$idProducto]['id'] = $producto[0]->id;
            $carritoInterno[$idProducto]['proveedor'] = $producto[0]->proveedor;
            $carritoInterno[$idProducto]['producto'] = $producto[0]->producto;
            $carritoInterno[$idProducto]['cantidad']++;
            $carritoInterno[$idProducto]['precio'] = $producto[0]->precio;
            $carritoInterno[$idProducto]['subtotal'] = $producto[0]->precio*$carritoInterno[$idProducto]['cantidad'];
            
        }
    
         /*
        echo "<br>***";
        foreach ( $carritoInterno as $dato ) {
            echo "<br>id:".$dato['id'];
            echo "<br>prov:".$dato['proveedor'];
            echo "<br>prod:".$dato['producto'];
            echo "<br>precio:".$dato['precio'];
            echo "<br>cant:".$dato['cantidad'];
            echo "<br>sub:".$dato['subtotal'];
            
        } 
         */

        
        \Session::put('carritoInterno',$carritoInterno);
        \Session::put('carritoInterno-count',count($carritoInterno));
    
        
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        return view('admin.adminCarritoInterno',compact('carritoInterno','parametros','items'));


    }

    public function trash( $id ){
        \Session::forget('carritoInterno');
        \Session::put('carritoInterno',array());
        $carritoInterno = \Session::get('carritoInterno');
        \Session::put('carritoInterno-count',count($carritoInterno));

        
        $status = false;
        try{
          DB::table('cotizacioninternas') 
               ->where('id', $id) 
               ->delete();
          $status = true;               
        } catch( Exception $ex) {
          $status = false;
        }
        
        if( $status ) {
             \Session::flash('flash-message-success','Registro ha sido eliminado .. !!'); 
             $parametros = DB::table('parametros')->get();
             $items = DB::table('menus')->get();
             $itemsMenu = DB::table('menus')
                 ->where('subMenu','<>','')
                 ->get();
             $carritoInterno = DB::table('cotizacioninternas')
                          ->get();    
             return view("admin.adminCotizacionInternoListar",compact('parametros','items','carritoInterno'));          
        } else {
             \Session::flash('flash-message-warning',"Hubo un problema al intentar eliminar el registro ... !!"); 
            
             $parametros = DB::table('parametros')->get();
             $items = DB::table('menus')->get();
             $itemsMenu = DB::table('menus')
                 ->where('subMenu','<>','')
                 ->get();
             return view("admin.adminCotizacionInternoListar",compact('parametros','items','carritoInterno'));          
        }
        
        

    }

    public function delete( $id){
        $carritoInterno = \Session::get('carritoInterno');
        unset($carritoInterno[$id]);
        //print_r($carrito);

        \Session::put('carritoInterno',$carritoInterno);
        \Session::put('carritoInterno-count',count($carritoInterno));
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        $subMenu = session()->get('subMenu');
        return view('carritoInterno.index',compact('carritoInterno','parametros','items'));


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editar($codigo)
    {
        echo "<br>Editar:".$codigo;
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        $infoCabecera_ = DB::table('cotizacioninternas')
                                  ->where('codigo',$codigo)
                                  ->get();   
        $infoCabecera = [
            'codigo' => $infoCabecera_[0]->codigo,
            'usuario' => $infoCabecera_[0]->usuario,
            'total' => $infoCabecera_[0]->total,
            'observaciones' => $infoCabecera_[0]->descripcion,
            'nombre' => $infoCabecera_[0]->nombre];


        $carritoCotizacion = DB::table('cotizacioninternas_detalle')
                                 ->where('codigo',$codigo)
                                 ->get();    
        return view("admin.adminCotizacionInternoEditar",compact('parametros','items','infoCabecera','carritoCotizacion'));         
        
        
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
        $id = $request->Input('id');
        $cantidad = $request->Input('qty');
        
        //echo "<br>id:". $id;
        //echo "<br>cantidad:". $cantidad;
        $carritoInterno = \Session::get('carritoInterno');
        $carritoInterno[$id]['cantidad'] = $cantidad;
        $carritoInterno[$id]['subtotal'] = $cantidad *  $carritoInterno[$id]['precio'];
         \Session::put('carritoInterno',$carritoInterno);
        
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        $subMenu = session()->get('subMenu');
        return view('carritoInterno.index',compact('carritoInterno','parametros','items'));
    
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


    public function generarPedido(){
        
        echo "<br>GenerarPedido";
        $carritoInterno = \Session::get('carritoInterno');
        $pdf = \PDF::loadView('carritoInterno.carritoInterno', compact('carritoInterno'));
        return $pdf->download('carritoInterno.pdf');
        //return view('carritoInterno.carritoInterno',compact('carritoInterno'));
        /*
        if( \Session::has('usuario') ) {
            //echo "<br>Usuario:". \Session::get('usuario');
            $usuario = DB::table('usuarios')
                       ->where('email',\Session::get('email'))
                       ->get();
            $parametros = DB::table('parametros')->get();
            $items = DB::table('menus')->get();
            $carritoInterno = \Session::get('carritoInterno');
            return view('carritoInterno.solicitaPedido',compact('carritoInterno','parametros','items'));
        }   else {
            //echo "<br>logearse";
            $parametros = DB::table('parametros')->get();
            $items = DB::table('menus')->get();
            return view('usuarios.index',compact('parametros','items'));
        }    
        */

    }


    public function pedidoEnvia(Request $request) {
        $nombre  = $request->Input('name');
        $email   = $request->Input('email');
        $fonoContacto   = $request->Input('fonoContacto');
        $message = $request->Input('message');
        $codPedido = uniqid('');
        $codPedido = rand();
        $emailCC = "cssantam@gmail.com";

        
        $carritoInterno = \Session::get('carritoInterno');
        foreach( $carritoInterno as $registro) {
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
            \Session::forget('carritoInterno');
            \Session::put('carrito-count',0);
            $parametros = DB::table('parametros')->get();
            $items = DB::table('menus')->get();
            return view("carritoInterno.carritoPedidoEnviado",compact('parametros','items','codPedido'));
        } else {
            $parametros = DB::table('parametros')->get();
            $items = DB::table('menus')->get();
            return view("carritoInterno.carritoPedidoEnviadoNoOk",compact('parametros','items'));
        }
        
    }


    public function pedidoInfoPago(Request $request){
         echo "<br>IrAPagar";
    }
    
    
    public function adminProductosEditar(){
        
    }
}
