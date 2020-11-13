<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\CatalogoProveedor;
use Exception;
use App\Producto;

class CatalogoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $cbProveedores = DB::table('proveedores')
                         ->orderBy('nombreCorto', 'ASC')
                         ->get();
        
        //print_r( $proveedores[0]->nombre);
        
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        $catalogo = DB::table('catalogoProveedores')
                    ->take(10)
                    ->get();
        $proveedores =  DB::table('catalogoProveedores')
                        ->orderBy('proveedor', 'ASC')
                        ->distinct()
                        ->get(['proveedor']);
        $txtBuscar = "";
        $proveedor = "0";
                     
        return view('admin.adminCatalogo',compact('parametros','items','catalogo','proveedores','txtBuscar','proveedor','cbProveedores'));
        
 
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


    public function productosBuscar(Request $request){
        //echo "<br>Catalogo Productos Buscar:". $request->Input("txtBuscar");
        
        $txtBuscar   = $request->Input("txtBuscar");
        
        if( $request->Input("proveedor") != null) {
           $proveedor  = $request->Input("proveedor");    
        } else {
           $proveedor  = "0";    
        }
        
        //echo "<br>provee:" . $proveedor;
        
       

        $arrProducto = explode(" ",$txtBuscar);
        
        $numPalabrasProducto = count($arrProducto);
         
        if( $numPalabrasProducto == 1  && strcmp($proveedor,"0") ==0) {
             $catalogo = DB::table('catalogoProveedores')
                      ->where('producto','like','%'.$arrProducto[0].'%')
                      ->orderBy('producto', 'ASC')
                      ->orderBy('precio', 'ASC')
                      /*->take(40) */
                      ->get();
        }
        
        if( $numPalabrasProducto == 2  && strcmp($proveedor,"0") ==0) {
             $catalogo = DB::table('catalogoProveedores')
                      ->where('producto','like','%'.$arrProducto[0].'%')
                      ->orWhere('producto','like','%'.$arrProducto[1].'%')
                      ->orderBy('producto', 'ASC')
                      ->orderBy('precio', 'ASC')
                      /*->take(40)*/
                      ->get();
        }
         
         
        if( $numPalabrasProducto == 3  && strcmp($proveedor,"0") ==0) {
             $catalogo = DB::table('catalogoProveedores')
                      ->where('producto','like','%'.$arrProducto[0].'%')
                      ->orWhere('producto','like','%'.$arrProducto[1].'%')
                      ->orWhere('producto','like','%'.$arrProducto[2].'%')

                      ->orderBy('precio', 'ASC')
                      /*->take(40) */
                      ->get();
        }        
        
        
        
        if( $numPalabrasProducto == 4  && strcmp($proveedor,"0") ==0) {
             $catalogo = DB::table('catalogoProveedores')
                      ->where('producto','like','%'.$arrProducto[0].'%')
                      ->where('producto','like','%'.$arrProducto[1].'%')
                      ->where('producto','like','%'.$arrProducto[2].'%')
                      ->where('producto','like','%'.$arrProducto[3].'%')

                      ->orderBy('precio', 'ASC')
                     /* ->take(40) */
                      ->get();
        }   
        
        
        if( $numPalabrasProducto >= 5  && strcmp($proveedor,"0") ==0) {
             $catalogo = DB::table('catalogoProveedores')
                      ->where('producto','like','%'.$arrProducto[0].'%')
                      ->where('producto','like','%'.$arrProducto[1].'%')
                      ->where('producto','like','%'.$arrProducto[2].'%')
                      ->where('producto','like','%'.$arrProducto[3].'%')
                      ->where('producto','like','%'.$arrProducto[4].'%')

                      ->orderBy('precio', 'ASC')
                      /* ->take(40) */
                      ->get();
        }  
        
        
        
        if( $numPalabrasProducto == 1  && strcmp($proveedor,"0") != 0) {
             //echo "<br>producto:" . $arrProducto[0];
             //echo "<br>proveedor:" . $proveedor;
             $catalogo = DB::table('catalogoProveedores')
                      ->where('producto','like','%'.$arrProducto[0].'%')
                      ->where('proveedor',$proveedor)
                      ->orderBy('producto', 'ASC')
                      ->orderBy('precio', 'ASC')
                      /*->take(40)*/
                      ->get();
                      
            $cc = count( $catalogo);
            //echo "<br>cc:".$cc;
        }
        
        
        if( $numPalabrasProducto == 2  && strcmp($proveedor,"0") != 0) {
             $catalogo = DB::table('catalogoProveedores')
                      ->where('producto','like','%'.$arrProducto[0].'%')
                      ->where('producto','like','%'.$arrProducto[1].'%')
                      
                      ->where('proveedor',$proveedor)
                      ->orderBy('producto', 'ASC')
                      ->orderBy('precio', 'ASC')
                      /*->take(40)  */
                      ->get();
        }
       
       
       if( $numPalabrasProducto == 3  && strcmp($proveedor,"0") != 0) {
             $catalogo = DB::table('catalogoProveedores')
                      ->where('producto','like','%'.$arrProducto[0].'%')
                      ->where('producto','like','%'.$arrProducto[1].'%')
                      ->where('producto','like','%'.$arrProducto[2].'%')
                      
                      ->where('proveedor',$proveedor)
                      ->orderBy('producto', 'ASC')
                      ->orderBy('precio', 'ASC')
                      ->take(40)
                      ->get();
        }
        
        
        
       if( $numPalabrasProducto == 4  && strcmp($proveedor,"0") != 0) {
             $catalogo = DB::table('catalogoProveedores')
                      ->where('producto','like','%'.$arrProducto[0].'%')
                      ->where('producto','like','%'.$arrProducto[1].'%')
                      ->where('producto','like','%'.$arrProducto[2].'%')
                      ->where('producto','like','%'.$arrProducto[3].'%')
                      
                      ->where('proveedor',$proveedor)
                      ->orderBy('producto', 'ASC')
                      ->orderBy('precio', 'ASC')
                      ->take(40)
                      ->get();
        }
        
       if( $numPalabrasProducto >= 5  && strcmp($proveedor,"0") != 0) {
             $catalogo = DB::table('catalogoProveedores')
                      ->where('producto','like','%'.$arrProducto[0].'%')
                      ->where('producto','like','%'.$arrProducto[1].'%')
                      ->where('producto','like','%'.$arrProducto[2].'%')
                      ->where('producto','like','%'.$arrProducto[3].'%')
                      ->where('producto','like','%'.$arrProducto[4].'%')
                      
                      ->where('proveedor',$proveedor)
                      ->orderBy('producto', 'ASC')
                      ->orderBy('precio', 'ASC')
                      ->take(40)
                      ->get();
        }
         
         
        if( $numPalabrasProducto == 0  && strcmp($proveedor,"0") == 0) {
             $catalogo = DB::table('catalogoProveedores')
                      
                      ->orderBy('producto', 'ASC')
                      ->orderBy('precio', 'ASC')
                      ->take(40)
                      ->get();
             $proveedor = "0";
        }        
        
        $cbProveedores = DB::table('proveedores')->get();
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        $proveedores =  DB::table('catalogoProveedores')
                        ->orderBy('proveedor', 'ASC')
                        ->distinct()
                        ->get(['proveedor']);

        return view('admin.adminCatalogo',compact('parametros','items','catalogo','proveedores','txtBuscar','proveedor','cbProveedores'));
        

    }
    
    
    public function adminCatalogoCargaImagen(Request $request ) {

        $id          = $request->Input("id");
        $linkImagen  = $request->Input("linkImagen");
        $txtBuscar   = $request->Input("txtBuscar");
        $proveedor   = $request->Input("proveedor");
        $producto    = $request->Input("producto");
        $descripcion = $request->Input("descripcion");
        $codigo      = $request->Input("codigo");
        $precio      = $request->Input("precio");
        $precioVenta = $request->Input("precioVenta");
        
        /*
        echo "<br>txtBuscar:". $txtBuscar;
        echo "<br>provee:". $proveedor;
        echo "<br>codigo:". $codigo;
        echo "<br>precio:". $precio;
        */
        //echo "<br>precio:". $precio;
        //echo "<br>precioVenta:". $precioVenta;
        
    
        
        
        try {
            \DB::table('catalogoProveedores') 
                 ->where('id', $id ) 
                 ->update( [ 'imagen' => $linkImagen,
                             'precio' => $precio,
                             'precioVenta' => $precioVenta,
                             'proveedor' => $proveedor,
                             'producto' => $producto,
                             'descripcion' => $descripcion,
                             'codProducto' => $codigo]
                         );
        } catch( Exception $ex ) {
            \Session::flash('flash-message-warning','Ocurrio un problema al actualizar  ... favor reintentar ... !!'); 
        }   
            

        
        $arrProducto = explode(" ",$txtBuscar);
        
        $numPalabrasProducto = count($arrProducto);
         
        if( $numPalabrasProducto == 1  && strcmp($proveedor,"0") ==0) {
             $catalogo = DB::table('catalogoProveedores')
                      ->where('producto','like','%'.$arrProducto[0].'%')
                      ->orderBy('producto', 'ASC')
                      ->orderBy('precio', 'ASC')
                      /*->take(40)  */
                      ->get();
        }
        
        if( $numPalabrasProducto == 2  && strcmp($proveedor,"0") ==0) {
             $catalogo = DB::table('catalogoProveedores')
                      ->where('producto','like','%'.$arrProducto[0].'%')
                      ->where('producto','like','%'.$arrProducto[1].'%')
                      ->orderBy('producto', 'ASC')
                      ->orderBy('precio', 'ASC')
                      /*->take(40)  */
                      ->get();
        }
         
         
        if( $numPalabrasProducto == 3  && strcmp($proveedor,"0") ==0) {
             $catalogo = DB::table('catalogoProveedores')
                      ->where('producto','like','%'.$arrProducto[0].'%')
                      ->where('producto','like','%'.$arrProducto[1].'%')
                      ->where('producto','like','%'.$arrProducto[2].'%')

                      ->orderBy('precio', 'ASC')
                      /*->take(40)  */
                      ->get();
        }        
        
        
        
        if( $numPalabrasProducto == 4  && strcmp($proveedor,"0") ==0) {
             $catalogo = DB::table('catalogoProveedores')
                      ->where('producto','like','%'.$arrProducto[0].'%')
                      ->where('producto','like','%'.$arrProducto[1].'%')
                      ->where('producto','like','%'.$arrProducto[2].'%')
                      ->where('producto','like','%'.$arrProducto[3].'%')

                      ->orderBy('precio', 'ASC')
                      /*->take(40)  */
                      ->get();
        }   
        
        
        if( $numPalabrasProducto >= 5  && strcmp($proveedor,"0") ==0) {
             $catalogo = DB::table('catalogoProveedores')
                      ->where('producto','like','%'.$arrProducto[0].'%')
                      ->where('producto','like','%'.$arrProducto[1].'%')
                      ->where('producto','like','%'.$arrProducto[2].'%')
                      ->where('producto','like','%'.$arrProducto[3].'%')
                      ->where('producto','like','%'.$arrProducto[4].'%')

                      ->orderBy('precio', 'ASC')
                      /*->take(40)  */
                      ->get();
        }  
        
        
        
        if( $numPalabrasProducto == 1  && strcmp($proveedor,"0") != 0) {
             //echo "<br>producto:" . $arrProducto[0];
             //echo "<br>proveedor:" . $proveedor;
             $catalogo = DB::table('catalogoProveedores')
                      ->where('producto','like','%'.$arrProducto[0].'%')
                      ->where('proveedor',$proveedor)
                      ->orderBy('producto', 'ASC')
                      ->orderBy('precio', 'ASC')
                      /*->take(40)*/
                      ->get();
                      
            $cc = count( $catalogo);
            //echo "<br>cc:".$cc;
        }
        
        
        if( $numPalabrasProducto == 2  && strcmp($proveedor,"0") != 0) {
             $catalogo = DB::table('catalogoProveedores')
                      ->where('producto','like','%'.$arrProducto[0].'%')
                      ->where('producto','like','%'.$arrProducto[1].'%')
                      
                      ->where('proveedor',$proveedor)
                      ->orderBy('producto', 'ASC')
                      ->orderBy('precio', 'ASC')
                      /*->take(40)  */
                      ->get();
        }
       
       
       if( $numPalabrasProducto == 3  && strcmp($proveedor,"0") != 0) {
             $catalogo = DB::table('catalogoProveedores')
                      ->where('producto','like','%'.$arrProducto[0].'%')
                      ->where('producto','like','%'.$arrProducto[1].'%')
                      ->where('producto','like','%'.$arrProducto[2].'%')
                      
                      ->where('proveedor',$proveedor)
                      ->orderBy('producto', 'ASC')
                      ->orderBy('precio', 'ASC')
                      /*->take(40)  */
                      ->get();
        }
        
        
        
       if( $numPalabrasProducto == 4  && strcmp($proveedor,"0") != 0) {
             $catalogo = DB::table('catalogoProveedores')
                      ->where('producto','like','%'.$arrProducto[0].'%')
                      ->where('producto','like','%'.$arrProducto[1].'%')
                      ->where('producto','like','%'.$arrProducto[2].'%')
                      ->where('producto','like','%'.$arrProducto[3].'%')
                      
                      ->where('proveedor',$proveedor)
                      ->orderBy('producto', 'ASC')
                      ->orderBy('precio', 'ASC')
                      /*->take(40)  */
                      ->get();
        }
        
       if( $numPalabrasProducto >= 5  && strcmp($proveedor,"0") != 0) {
             $catalogo = DB::table('catalogoProveedores')
                      ->where('producto','like','%'.$arrProducto[0].'%')
                      ->where('producto','like','%'.$arrProducto[1].'%')
                      ->where('producto','like','%'.$arrProducto[2].'%')
                      ->where('producto','like','%'.$arrProducto[3].'%')
                      ->where('producto','like','%'.$arrProducto[4].'%')
                      
                      ->where('proveedor',$proveedor)
                      ->orderBy('producto', 'ASC')
                      ->orderBy('precio', 'ASC')
                      /*->take(40)  */
                      ->get();
        }
         
         
        if( $numPalabrasProducto == 0  && strcmp($proveedor,"0") == 0) {
             $catalogo = DB::table('catalogoProveedores')
                      
                      ->orderBy('producto', 'ASC')
                      ->orderBy('precio', 'ASC')
                      /*->take(40)  */
                      ->get();
             $proveedor = "0";
        } 
        
        
        
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        $proveedores =  DB::table('catalogoProveedores')
                        ->orderBy('proveedor', 'ASC')
                        ->distinct()
                        ->get(['proveedor']);
        return view('admin.adminCatalogo',compact('parametros','items','txtBuscar','proveedores','catalogo','proveedor'));

        
    }
    
    public function adminCatalogoProductosAgregar(Request $request) {
        //echo "agregar ----";
        $txtBuscar    = $request->Input("txtBuscar");
        $proveedor    = $request->Input("proveedor");
        $producto     = $request->Input("producto");
        $imagen       = $request->Input("imagen");
        $precioCompra = $request->Input("precioCompra");
        $precioIva    = $request->Input("iva");
        $precioVenta  = $request->Input("precioVenta");
        $descripcion  = $request->Input("descripcion");
        
        if( strcmp($proveedor,"") !=0 ) {
            $proveedor   = $request->Input("proveedor");
        }  else {
            $proveedor   = "";
        }
        
        if( strcmp($descripcion,"") !=0 ) {
            $descripcion   = $request->Input("descripcion");
        }  else {
            $descripcion   = "";
        }
        
        if( strcmp($precioCompra,"") !=0 ) {
            $precioCompra   = $request->Input("precioCompra");
        }  else {
            $precioCompra   = "0";
        }
        
        if( strcmp($ivaCompra,"") !=0 ) {
            $ivaCompra   = $request->Input("ivaCompra");
        }  else {
            $ivaCompra   = "0";
        }
        
        if( strcmp($precioVenta,"") !=0 ) {
            $precioVenta   = $request->Input("precioVenta");
        }  else {
            $precioVenta   = "0";
        }        
        
        if( strcmp($imagen,"") !=0 ) {
            $imagen   = $request->Input("imagen");
        }  else {
            $imagen   = "";
        }
        
        $catalogo = new CatalogoProveedor;
        $catalogo->proveedor=$proveedor;
        $catalogo->producto=$producto;
        $catalogo->descripcion=$descripcion;
        $catalogo->precio=$precioVenta;
        $catalogo->precioCompra=$precioCompra;
        $catalogo->ivaCompra=$ivaCompra;
        $catalogo->precioVenta=$precioVenta;
          
        $catalogo->save();
        
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        $proveedores =  DB::table('catalogoProveedores')
                        ->orderBy('proveedor', 'ASC')
                        ->distinct()
                        ->get(['proveedor']);
        $catalogo = DB::table('catalogoProveedores')
                      
                      ->orderBy('id', 'DESC')
                      /*->take(40)  */
                      ->get();
        return view('admin.adminCatalogo',compact('parametros','items','txtBuscar','proveedores','catalogo','proveedor'));
    }
    
    
    
    public function adminCatalogoProveedoresAgregar(Request $request ) {
        //echo "<br>Proveedores Agregar";
        $rut          = $request->Input("rut");
        $nombre       = $request->Input("nombre");
        $nombreCorto  = $request->Input("nombreCorto");
        $direccion    = $request->Input("direccion");
        $contacto     = $request->Input("contacto");
        $email        = $request->Input("email");
        $fonoContacto = $request->Input("fonoContacto");
        
        /*
        echo "<br>rut" . $rut;
        echo "<br>nombre" . $nombre;
        echo "<br>nombreCoorto" . $nombreCorto;
        echo "<br>direccion" . $direccion;
        echo "<br>contacto" . $contacto;
        echo "<br>email" . $email;
        echo "<br>fonoContacto" . $fonoContacto;        
        */
        
    }
    
    public function adminCatalogoAgregarCarritoInterno($id){
        //echo "<br>Catalogo Carrito Interno Agrega Prodcuto".$id;
        $carritoInterno = \Session::get('carrito-interno');
        $carritoInterno[$producto->id] = $id;
        $carritoInterno[$producto->id]->subtotal = $producto->cantidad * $producto->precio;
        //print_r($carrito);
        \Session::put('carritoInterno',$carritoInterno);
        //\Session::put('carrito-count',count($carrito));
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        //return view('carritoInerno.index',compact('carritoInterno','parametros','items'));
    }
    
    
    public function adminCatalogoToProductosAgregar($id){
        //echo "<br>adminCatalogoToProductosAgregar".$id;
        $catalogo = DB::table('catalogoProveedores')
                  ->where('id',$id)
                  ->get();
        
        /*
        print_r( $catalogo );          
        
        echo "<br>provee:". $catalogo[0]->proveedor;
        echo "<br>producto:". $catalogo[0]->producto;
        echo "<br>precio:". $catalogo[0]->precio;
        echo "<br>imagen:". $catalogo[0]->imagen;
        */
        
        $codProducto = $catalogo[0]->codProducto;

        $url = $catalogo[0]->imagen;
        $base = basename($url);
        //echo "<br>Url:".$url;
        //echo "<br>Basename:".$base;
        
        //$url = "http://www.dominio.inicial/imagen.png";
        
        $dir = "/home/cde51983/asis/storage/app/public/";
        $archivoInicial = fopen($url, "r");
        $archivoNombre = $codProducto.".jpg";
        $archivoFinal   = fopen($dir . $archivoNombre, "w");

        while(!feof( $archivoInicial )) 
            fwrite($archivoFinal, fread($archivoInicial, 1), 1);
        
        fclose($archivoFinal);
        fclose($archivoInicial);
        
        $id = 0;
        $subMenu = DB::table('menus')
                     ->select('subMenu')
                     ->where('subMenu','<>','')
                     ->get();
        $subMenuSel = "0";
        $archImage = $archivoNombre;
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        
        
        //echo "<br>archivo:".$archivoNombre;
        
    
        $prod = new Producto;
        $prod->idProducto = $catalogo[0]->codProducto;
        $prod->nombre = $catalogo[0]->producto;
        $prod->descripcion = $catalogo[0]->descripcion;
        $prod->image  = $archivoNombre;
        $prod->precio =  $catalogo[0]->precioVenta;
        return view('admin.adminCatalogoToProductosEditar',compact('parametros','items','archImage','id','subMenu','subMenuSel','prod'));
        
        
    }
    
    
    
    
    public function adminCatalogoProveedorToProductosCargaImagen( Request $request){
        //echo "<br>CargaImagen";
        if( $request->Input('id') ) {
            $id   = $request->Input('id');
            $producto = DB::table('productos')
                       ->where('id',$id)
                       ->get();
            $prod = $producto[0];
        } else  {
            $id = "";
        }
        if( $request->Input('subMenuSel') ) {
            $subMenuSel = $request->Input('id');
        } else  {
            $subMenuSel = "0";
        }
        if( $request->Input('archImage') ) {
            $archImage = $request->Input('archImage');
        } else  {
            $archImage = "0";
        }
        
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        $subMenu = DB::table('menus')
                       ->select('subMenu')
                       ->where('subMenu','<>','')
                       ->get();
                       
        //Validar Archivo Seleccionado
        if ( $request->file('archivo') ) {
            //echo "<br>Archivo OK";
            $file = $request->file('archivo');
            $archImage = $file->getClientOriginalName();
            $tipo = $file->getMimeType();
            $size = filesize($file);
            
            
            // Validar tipo de archivo
            //echo "<br>Tipo:" .$tipo;
            $arrayTipos = array("image/png", "image/jpeg", "image/jpg", "image/gif");
            if( !in_array( $tipo, $arrayTipos) ) {
                if( strcmp($id,"") == 0 ) { 
                    \Session::flash('flash-message-warning','El tipo de archivo no corresponde ... !!'); 
                    return view("admin.adminProductosNuevo",compact('parametros','items','prod','archImage','menu','subMenu','subMenuSel','id'));
                    exit();
                } else {
                    \Session::flash('flash-message-warning','El tipo de archivo no corresponde ... !!'); 
                    return view("admin.adminProductosEditar",compact('parametros','items','prod','archImage','menu','subMenu','subMenuSel','id'));
                    exit();
                    
                }
            }
            
            if( $size > 200000 ) {
                if( strcmp($id,"") == 0 ) { 
                    \Session::flash('flash-message-warning','El tama単o del archivo supera los 200K ... !!'); 
                    return view("admin.adminProductosNuevo",compact('parametros','items','prod','archImage','menu','subMenu','subMenuSel','id'));
                    exit();
                } else {
                    \Session::flash('flash-message-warning','El tama単o del archivo supera los 200K ... !!'); 
                    return view("admin.adminProductosEditar",compact('parametros','items','prod','archImage','menu','subMenu','subMenuSel','id'));
                    exit();
                    
                }
                
            }
            
            
            
            
            
            \Storage::disk('local')->put($archImage,  \File::get($file));
            
            \Session::forget('flash-message-success');
            \Session::forget('flash-message-warning'); 
            if( strcmp($id,"") == 0 ) { 
                return view("admin.adminProductosNuevo",compact('parametros','items','prod','archImage','menu','subMenu','subMenuSel','id'));
                 
            } else {
                 $producto = DB::table('productos')
                       ->where('id',$id)
                       ->get();
                 $prod = $producto[0];

                return view("admin.adminProductosEditar",compact('parametros','items','prod','archImage','menu','subMenu','subMenuSel','id'));
            }
            
        } else {
            //echo "<br>Archivo No-OK";
            \Session::flash('flash-message-warning','Debe seleccionar un  archivo ... !!'); 
            if( strcmp($id,"") == 0 ) { 
                //echo "<br>Prod Nuevo Warning archivo";
                 return view("admin.adminProductosNuevo",compact('parametros','items','prod','archImage','menu','subMenu','subMenuSel','id'));
            } else {
                //echo "<br>Prod Editar Warning archivo id:".$id. "archImage:".$archImage;
                return view("admin.adminProductosEditar",compact('parametros','items','prod','archImage','menu','subMenu','subMenuSel','id'));
            }
        }
        
        
    }
    
    
    public function adminCatalogoProveedorToProductosGuardar(Request $request ) {
        
        
        
        
        $codigoProducto = $request->Input('idProducto');
        $menu           = $request->Input('menu');
        $subMenu        = $request->Input('subMenu');
        $nombre         = $request->Input('nombre');
        $descripcion    = $request->Input('descripcion');
        $precio         = $request->Input('precio');
        $imagen         = $request->Input('image');
        $archImage      = $imagen;
        $id = 0;
        
        
        $prod = new Producto;
        $prod->idProducto = $codigoProducto;
        $prod->nombre = $nombre;
        $prod->image  = $imagen;
        $prod->precio =  $precio;
        
        if( productoYaExiste($codigoProducto) ) {
            
            try {
            \DB::table('productos') 
                 ->where('idProducto', $codigoProducto ) 
                 ->update( [ 'image' => $imagen,
                             'precio' => $precio,
                             'subMenu' => $subMenu,
                             'nombre' => $nombre,
                             'idProducto' => $codigoProducto,
                             'descripcion' => $descripcion]
                         );
            } catch( Exception $ex ) {
                \Session::flash('flash-message-warning','!! Ocurrio un problema al actualizar  ... favor reintentar ... !!'.$ex->getMessage()); 
            }   
            
           $subMenuSel = $subMenu;
           $parametros = DB::table('parametros')->get();
           $items = DB::table('menus')->get();
           $subMenu = DB::table('menus')
                       ->select('subMenu')
                       ->where('subMenu','<>','')
                       ->get();
                       
           return view('admin.adminCatalogoToProductosEditar',compact('parametros','items','prod','archImage','id','subMenu','subMenuSel'));
           
        }
        
        
        try {
        
        $producto = new Producto;
        $producto->idProducto=$codigoProducto;
        $producto->menu=$menu;
        $producto->subMenu=$subMenu;
        $producto->nombre=$nombre;
        $producto->descripcion=$descripcion;
        $producto->precio=$precio;
        //$producto->precioVenta=$precioVenta;
        $producto->image=$imagen;
        $producto->save();
        } catch( Exception $ex ) {
           \Session::flash('flash-message-warning','Ocurrio un Problema al intentar guardar ... !!'. $ex->getMessage()); 
          $id = 0;
          $subMenuSel = "0";
          $subMenu = DB::table('menus')
                       ->select('subMenu')
                       ->where('subMenu','<>','')
                       ->get();
          $parametros = DB::table('parametros')->get();
          $items = DB::table('menus')->get();
          $productos = DB::table('productos')
                       ->orderBy('updated_at', 'DESC')
                       ->get();
          return view('admin.adminCatalogoToProductosEditar',compact('parametros','items','prod','archImage','id','subMenu','subMenuSel'));     
        }
       
        
        \Session::flash('flash-message-success','Producto ha sido cargado en forma exitosa... !!');  
        $id = Producto::max('id');
        $productos = DB::table('productos')
                        ->where('id',$id)
                        ->get();
        $prod  = $productos[0];
        $idProducto  = $prod->idProducto;
        $archImage = $prod->image;
        $subMenuSel = $subMenu;
        $subMenu = DB::table('menus')
                       ->select('subMenu')
                       ->where('subMenu','<>','')
                       ->get();
        
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        $productos = DB::table('productos')
                       ->orderBy('updated_at', 'DESC')
                       ->get();
        
        return view('admin.adminCatalogoToProductosEditar',compact('parametros','items','prod','archImage','id','subMenu','subMenuSel','idProducto'));     
        
        
    }
}
    