<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \App\Producto;
use \App\Carro;
use \App\Cotizacion;
use \App\CotizacionDetalle;
use PHPMailer\PHPMailer;
use PDF;


class CotizacionController extends Controller
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
        echo "<br>Listado Cotizaciones";
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        $registros  = DB::table('cotizaciones')->get();
        
        return view('admin.adminCarritoCotizacionesEditor',compact('registros','parametros','items','infoCabecera'));
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
        $items = DB::table('menus')->get();
        $subMenu = session()->get('subMenu');
        $carritoCotizacion = \Session::get('carritoCotizacion');
        $fecha = date('d-m-Y');
        $infoCabecera = \Session::get('infoCabecera');
        if( empty( $infoCabecera )) {
            $infoCabecera = ['codigo' => '',
                             'rut' => '',
                             'nombre' => '',
                             'contacto' => '',
                             'direccion' => '',
                             'email' => '',
                             'fonoContacto' => '',
                             'total' => ''
                             ];
            
        }        
        
        return view('cotizador.index',compact('carritoCotizador','parametros','items','infoCabecera'));
        
    }


    public function add( $idProducto){
        if( session()->has('infoCabecera')) {
            $infoCabecera = \Session::get('infoCabecera'); 
            if( !isset( $infoCabecera['codigo'] ) ){
                $infoCabecera['codigo'] = '';
            }
            if( !isset( $infoCabecera['rut'] ) ){
                $infoCabecera['rut'] = '';
            }
            if( !isset( $infoCabecera['nombre'] ) ){
                $infoCabecera['nombre'] = '';
            }  
            if( !isset( $infoCabecera['direccion'] ) ){
                $infoCabecera['direccion'] = '';
            }              
            if( !isset( $infoCabecera['email'] ) ){
                $infoCabecera['email'] = '';
            }
            if( !isset( $infoCabecera['fonoContacto'] ) ){
                $infoCabecera['fonoContacto'] = '';
            } 
            if( !isset( $infoCabecera['contacto'] ) ){
                $infoCabecera['contacto'] = '';
            }    
            if( !isset( $infoCabecera['validez'] ) ){
                $infoCabecera['validez'] = '';
            }
            if( !isset( $infoCabecera['observaciones'] ) ){
                $infoCabecera['observaciones'] = '';
            }
            if( !isset( $infoCabecera['total'] ) ){
                $infoCabecera['total'] = '';
            }    
            
            /*
            echo "<br>codigo:". $infoCabecera['codigo'];
            echo "<br>rut:". $infoCabecera['rut'];
            echo "<br>nombre:". $infoCabecera['nombre'];
            echo "<br>email:". $infoCabecera['email'];
            echo "<br>fonoContacto:". $infoCabecera['fonoContacto'];
            */
            
        } else {
           // echo "<br>infoCabecera no existe";
             $infoCabecera = ['codigo' => '',
                             'rut' => '',
                             'nombre' => '',
                             'contacto' => '',
                             'direccion' => '',
                             'email' => '',
                             'fonoContacto' => '',
                             'validez' => '',
                             'observaciones' => '',
                             'total' => ''
                             ];
        }
        
        
        
        $carritoCotizacion = \Session::get('carritoCotizacion');
        $producto = DB::table('catalogoProveedores')
                          ->where( 'id',$idProducto)
                          ->get();
        /*
        echo "<br>id". $producto[0]->id;
        echo "<br>prov". $producto[0]->proveedor;
        echo "<br>prod". $producto[0]->producto;
        echo "<br>pre". $producto[0]->precio;
        */
        
        
        
        if( empty( $carritoCotizacion[$idProducto]['id'] )  ) {
            $carritoCotizacion[$idProducto]['id'] = $producto[0]->id;
            $carritoCotizacion[$idProducto]['proveedor'] = $producto[0]->proveedor;
            $carritoCotizacion[$idProducto]['producto'] = $producto[0]->producto;
            $carritoCotizacion[$idProducto]['cantidad'] = 1;
            $carritoCotizacion[$idProducto]['precio'] = $producto[0]->precioVenta;
            $carritoCotizacion[$idProducto]['subtotal'] = $producto[0]->precio;
        } else {
            $carritoCotizacion[$idProducto]['id'] = $producto[0]->id;
            $carritoCotizacion[$idProducto]['proveedor'] = $producto[0]->proveedor;
            $carritoCotizacion[$idProducto]['producto'] = $producto[0]->producto;
            $carritoCotizacion[$idProducto]['cantidad']++;
            $carritoCotizacion[$idProducto]['precio'] = $producto[0]->precioVenta;
            $carritoCotizacion[$idProducto]['subtotal'] = $producto[0]->precio*$carritoCotizacion[$idProducto]['cantidad'];
            
        }
    
    
        \Session::put('carritoCotizacion',$carritoCotizacion);
        \Session::put('carritoCotizacion-count',count($carritoCotizacion));
        $total = 0;
        foreach ( $carritoCotizacion as $dato ) {
            //echo "<br>precio:".$dato['precio']. " cant:".$dato['cantidad'];
            $total += $dato['precio'] * $dato['cantidad'];
        } 
        
        //echo "<br>Total:". $total;
        $infoCabecera['total'] = $total;
        \Session::put('infoCabecera',$infoCabecera ); 
        \Session::put('carritoCotizacion-total',$total ); 

        
        
        
        
        $carritoCotizacion = \Session::get('carritoCotizacion');
        //print_r( $carritoCotizacion);
    
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
       // echo "<br>****";
        //print_r( $infoCabecera);
        return view('admin.adminCotizacionesEditor',compact('carritoCotizacion','parametros','items','infoCabecera'));
        
    

    }
    
    
    
    public function addManual(Request $request) {
        $idProducto = "99999";
        $codCotizacion = $request->Input("id");
        $proveedor = $request->Input("proveedor");
        $producto  = $request->Input("producto");
        $cantidad = $request->Input("cantidad");
        $precio   = $request->Input("precio");
        $subtotal = $cantidad * $precio;
        
        echo "<br>addManual".$codCotizacion;
        echo "<br>proveedor".$proveedor;
        echo "<br>producto".$producto;
        echo "<br>cantidad".$cantidad;
        echo "<br>precio".$precio;
        echo "<br>subtotal".$subtotal;
        
        $infoCabecera = \Session::get('infoCabecera'); 
        $carritoCotizacion = \Session::get('carritoCotizacion');
        
        $carritoCotizacion[$idProducto]['id'] = $idProducto;
        $carritoCotizacion[$idProducto]['proveedor'] = $proveedor;
        $carritoCotizacion[$idProducto]['producto'] = $producto;
        $carritoCotizacion[$idProducto]['cantidad'] = $cantidad;
        $carritoCotizacion[$idProducto]['precio'] = $precio;
        $carritoCotizacion[$idProducto]['subtotal'] = $subtotal;
        
        \Session::put('carritoCotizacion',$carritoCotizacion);
        
        
        $total = 0;
        foreach ( $carritoCotizacion as $dato ) {
            //echo "<br>precio:".$dato['precio']. " cant:".$dato['cantidad'];
            $total += $dato['precio'] * $dato['cantidad'];
        } 
        
        \Session::put('infoCabecera',$infoCabecera ); 
        \Session::put('carritoCotizacion-total',$total );
        
        
        $carritoCotizacion = \Session::get('carritoCotizacion');
        //print_r( $carritoCotizacion);
    
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
       // echo "<br>****";
        //print_r( $infoCabecera);
        return view('admin.adminCotizacionesEditor',compact('carritoCotizacion','parametros','items','infoCabecera'));
        
    }

    public function trash(){
        \Session::forget('carritoCotizacion');
        \Session::put('carritoCotizacion',array());
        $carritoCotizacion = \Session::get('carritoCotizacion');
        \Session::put('carritoCotizacion-count',count($carritoCotizacion));
        //print_r($carrito);
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        return view('cotizador.index',compact('carritoCotizacion','parametros','items'));

    }

    public function delete( $id){
        $carritoCotizacion = \Session::get('carritoCotizacion');
        $infoCabecera  = \Session::get('infoCabecera');
        unset($carritoCotizacion[$id]);
        //print_r($carrito);

        \Session::put('carritoCotizacion',$carritoCotizacion);
        \Session::put('carritoCotizacion-count',count($carritoCotizacion));
        
        $total = 0;
        foreach ( $carritoCotizacion as $dato ) {
            $total += $dato['precio'] * $dato['cantidad'];
        } 
        \Session::put('carritoCotizacion-total',$total ); 
        
        
        if( session()->has('infoCabecera')) {
            if( !isset( $infoCabecera['total'] ) ){
                $infoCabecera['total'] = '';
            }  else {
                $infoCabecera['total'] = $total;
            }
        }
        
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        $subMenu = session()->get('subMenu');
        return view('admin.adminCotizacionesEditor',compact('carritoCotizacion','parametros','items','infoCabecera'));


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
    public function update(Request $request )
    {
        $id       = $request->Input('id');
        $cantidad = $request->Input('qty');
        $precio   = $request->Input('precio');
        
        /*
        echo "<br>id:". $id;
        echo "<br>cantidad:". $cantidad;
        echo "<br>precio:". $precio;
        */
        $carritoCotizacion = \Session::get('carritoCotizacion');
        $carritoCotizacion[$id]['cantidad'] = $cantidad;
        $carritoCotizacion[$id]['subtotal'] = $cantidad *  $precio;
        \Session::put('carritoCotizacion',$carritoCotizacion);
        
        $total = 0;
        foreach ( $carritoCotizacion as $dato ) {
            $total += $dato['precio'] * $dato['cantidad'];
        } 
        \Session::put('carritoCotizacion-total',$total ); 
        
        if( session()->has('infoCabecera')) {
            //echo "<br>infoCabecera existe";
            $infoCabecera = \Session::get('infoCabecera');
            if( !isset( $infoCabecera['total'] ) ){
                $infoCabecera['total'] = '';
            }  else {
                $infoCabecera['total'] = $total;
            }
        } else {
            echo "<br>infoCabecera no existe";
        }
    
        print_r( $infoCabecera);
        
        \Session::put('infoCabecera',$infoCabecera);        
        //echo "<br>infoCabeceraTotal:".$infoCabecera['total'];
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        $subMenu = session()->get('subMenu');
        
        return view('admin.adminCotizacionesEditor',compact('carritoCotizacion','parametros','items','infoCabecera'));
    
    
    }
    
    
    public function saveNew( Request $request) {
        $usuario   = session('usuario');
        $rut       = $request->Input('rut');
        $nombre    = $request->Input('nombre');
        $contacto  = $request->Input('contacto');
        $direccion = $request->Input('direccion');
        $email     = $request->Input('email');
        $validez   = $request->Input('validez');
        $observaciones = $request->Input('observaciones');
        $fonoContacto  = $request->Input('fonoContacto');
        $total = "0";
        
        $now = new \DateTime();
        
        
        $codigo =  rand();
        try{
          echo "<br>Guarda Encabezado";
          $registro = new Cotizacion;
          $registro->usuario = $usuario;
          $registro->codigo=$codigo;
          $registro->rut=$rut;
          $registro->nombre=$nombre;
          $registro->contacto=$contacto;
          $registro->direccion=$direccion;
          $registro->email=$email;
          $registro->fonoContacto=$fonoContacto;
          $registro->total=$total;
          $registro->validez=$validez;
          $registro->fecha=$now->format('d-m-Y H:i:s');
          $registro->observaciones=$observaciones;
          $registro->save();
          
        } catch( Exception $ex) {
            \Session::flash('flash-message-warning','Ocurrio un problema al intentar guardar  ... !!');
            $parametros = DB::table('parametros')->get();
            $items = DB::table('menus')->get();
            return view("admin.adminCotizacionesEditor",compact('carritoCotizacion','parametros','items','infoCabecera'));
        }
        
        
        $infoCabecera = ['usuario' => $usuario,
                         'codigo' => $codigo,
                         'rut' => $rut,
                         'nombre' => $nombre,
                         'contacto' => $contacto,
                         'direccion' => $direccion,
                         'email' => $email,
                         'fonoContacto' => $fonoContacto,
                         'total' => $total,
                         'validez' => $validez,
                         'fecha' => $now,
                         'observaciones' => $observaciones
                         ];
                        
        $carritoCotizacion = [];
        \Session::put('infoCabecera',$infoCabecera);
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        return view("admin.adminCotizacionesEditor",compact('carritoCotizacion','parametros','items','infoCabecera'));
        
        
    }
    
    
    public function save(Request $request) {
        $usuario   = session('usuario');
        $rut       = $request->Input('rut');
        $nombre    = $request->Input('nombre');
        $contacto  = $request->Input('contacto');
        $direccion = $request->Input('direccion');
        $email     = $request->Input('email');
        $validez   = $request->Input('validez');
        $observaciones = $request->Input('observaciones');
        $fonoContacto  = $request->Input('fonoContacto');
        $carritoCotizacion = \Session::get('carritoCotizacion');
        $infoCabecera = \Session::get('infoCabecera');
        $codigo = $infoCabecera['codigo'];
        $now = new \DateTime();
        
        $total = 0;
        foreach( $carritoCotizacion as $dato ) {
                echo "<br>".$dato['producto'] . " " . $dato['cantidad']. " " . $dato['precio'];
                $total+=$dato['cantidad'] * $dato['precio'];
        }
        //echo "<br>total:".$total;
        $infoCabecera['total'] = $total;
        

        if( DB::table('cotizaciones')->where('codigo', $codigo)->exists() ) {
            //echo "<br>Ya existe el codigo en bbdd cotizaciones";
            //echo "<br>Actualizazr";
             try {
             \DB::table('cotizaciones') 
                 ->where('codigo', $codigo) 
                 ->update( [ 'usuario' => $usuario,
                             'rut'  => $rut,
                             'nombre'     => $nombre,
                             'contacto'   => $contacto, 
                             'email'      => $email,
                             'contacto'   => $contacto,
                             'fonoContacto' => $fonoContacto,
                             'total'        => $total,
                             'validez'        => $validez,
                             'fecha'        => $now,
                             'observaciones'  => $observaciones,
                             'updated_at' => date('Y-m-d G:i:s')]);
             $status = true;
             } catch( Exception $ex ) {
                $status = false;
             }
             
        } else {
            //echo "<br>No existe el codigo en bbdd cotizaciones";
            $codigo =  rand();
            try{
              echo "<br>Guarda Encabezado";
              $registro = new Cotizacion;
              $registro->usuario = $usuario;
              $registro->codigo=$codigo;
              $registro->rut=$rut;
              $registro->nombre=$nombre;
              $registro->contacto=$contacto;
              $registro->direccion=$direccion;
              $registro->email=$email;
              $registro->fonoContacto=$fonoContacto;
              $registro->total=$total;
              $registro->validez=$validez;
              $registro->fecha=$now;
              $registro->observaciones=$observaciones;
              $registro->save();
              
              
              
            } catch( Exception $ex) {
                \Session::flash('flash-message-warning','Ocurrio un problema al intentar guardar  ... !!');
                $parametros = DB::table('parametros')->get();
                $items = DB::table('menus')->get();
                return view("admin.adminCotizacionesEditor",compact('carritoCotizacion','parametros','items','infoCabecera'));
            }
        }
        
        if( DB::table('cotizaciones_detalle')->where('codigo', $codigo)->exists() ) {
             
             //echo "<bR>Borrar detalle anterior";
             try {
                CotizacionDetalle::where('codigo', $codigo)->delete();
             }catch( Exception $ex) {
                \Session::flash('flash-message-warning','Ocurrio un problema al intentar guardar  ... !!');
                $parametros = DB::table('parametros')->get();
                $items = DB::table('menus')->get();
                
                return view("admin.adminCarritoCotizacionesEditor",compact('carritoCotizacion','parametros','items','infoCabecera'));
            }
        }    
            
             
         //echo "<bR>Insertar nuevo detalle";
         try{
          foreach( $carritoCotizacion as $dato ) {
             $registro = new CotizacionDetalle;
             $registro->codigo=$codigo;
             $registro->proveedor=$dato['proveedor'];
             $registro->producto=$dato['producto'];
             $registro->cantidad=$dato['cantidad'];
             $registro->precio=$dato['precio'];
             $registro->subtotal=$dato['cantidad'] * $dato['precio'];
             $registro->save();  
          }
          
          
        } catch( Exception $ex) {
            \Session::flash('flash-message-warning','Ocurrio un problema al intentar guardar  ... !!');
            $parametros = DB::table('parametros')->get();
            $items = DB::table('menus')->get();
            
            return view("admin.adminCotizacionesEditor",compact('carritoCotizacion','parametros','items','infoCabecera'));
        }
             
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        $infoCabecera = ['usuario' => $usuario,
                         'codigo' => $codigo,
                         'rut' => $rut,
                         'nombre' => $nombre,
                         'contacto' => $contacto,
                         'direccion' => $direccion,
                         'email' => $email,
                         'fonoContacto' => $fonoContacto,
                         'total' => $total,
                         'validez' => $validez,
                         'fecha' => $now,
                         'observaciones' => $observaciones
                         ];
                        
        \Session::put('carritoCotizacion',$carritoCotizacion);
        \Session::put('infoCabecera',$infoCabecera);
        return view("admin.adminCotizacionesEditor",compact('carritoCotizacion','parametros','items','infoCabecera'));
            
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


    public function generarPDF(){
        
        $carritoCotizacion = \Session::get('carritoCotizacion');
        $infoCabecera      = \Session::get('infoCabecera');       

        if( isset($infoCabecera['codigo']) && strcmp($infoCabecera['codigo'],"") !=0 ) {
            $CODIGO = $infoCabecera['codigo'];
            $FECHA  = $infoCabecera['fecha'];
            $ARCHIVO = "COTIZ-".$CODIGO.".pdf";
            $pdf = \PDF::loadView('admin.carritoCotizacionVer', compact('carritoCotizacion','infoCabecera'));
        return $pdf->download( $ARCHIVO );
    
        
        } else {
             \Session::flash('flash-message-warning','Cotizacion debe ser guardada .. !!'); 
          $parametros = DB::table('parametros')->get();
          $items = DB::table('menus')->get();
          return view("admin.adminCotizacionesEditor",compact('parametros','items','registros','infoCabecera','carritoCotizacion'));
            
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

        
        $carritoCotizador = \Session::get('carritoCotizador');
        foreach( $carritoCotizador as $registro) {
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
}
