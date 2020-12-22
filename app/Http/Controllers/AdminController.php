<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;


use App\Producto;
use App\Parametro;
use App\Menu;
use App\Proveedor;
use App\CarroSeguimiento;
use App\CotizacionDetalle;
use \App\CarroDetalle;
use App\Cotizacion;
use App\Cotizacioninterna;
use App\CotizacioninternaDetalle;
use App\UsuarioEstado;
//CotizacioninternaDetalle
use App\Usuario;
use PDF;
use App\Http\Requests\CotizNuevaRequest;




class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //echo "<br>index";
       //echo "<br>session:".session()->get('tipo');

        if( strcmp( session()->get('tipo'),'admin')==0 ) {
          $parametros = DB::table('parametros')->get();
          $items = DB::table('menus')->get();
          return view("admin.index",compact('parametros','items'));
        } else {
          $parametros = DB::table('parametros')->get();
          $items = DB::table('menus')->get();
          //return view("usuarios.index",compact('parametros','items'));  
        }
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


    public function salir(Request $request){
        //echo "<br>Salir";
        
        $request->session()->flush();
        Session::flush();
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        return view("usuarios.index",compact('parametros','items'));
        
    }



    public function adminMenu(){

        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        $itemsMenu = DB::table('menus')
                 ->where('subMenu','<>','')
                 ->orderBy('ordenMenu','ASC')
                 ->orderBy('posicion','ASC')
                 ->get();
        return view("admin.adminMenuListar",compact('parametros','items','itemsMenu'));
    }



    public function adminMenuNuevo(){
        
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        $itemsMenu = DB::table('menus')
                 ->where('subMenu','<>','')
                 ->get();
        return view("admin.adminMenuNuevo",compact('parametros','items','itemsMenu'));
        
    }


    public function adminMenuSave(Request $request){

        $ordenMenu = $request->Input('ordenMenu');
        $menu = $request->Input('menu');
        $posSubMenu = $request->Input('posSubMenu');
        $subMenu = $request->Input('subMenu');
        $pagina = $request->Input('pagina');

        
        try{
          $registro = new Menu;
          $registro->ordenMenu=$ordenMenu;
          $registro->menu=$menu;
          $registro->posicion=$posSubMenu;
          $registro->subMenu=$subMenu;
          $registro->pagina=$pagina;
          $registro->save();
          
          $itemsMenu = DB::table('menus')
                 ->where('subMenu','<>','')
                 ->get();
           
        
        } catch( Exception $ex) {
           \Session::flash('flash-message-warning','Ocurrio un problema al intentar agregar Menu .. !!');
          $parametros = DB::table('parametros')->get();
          $items = DB::table('menus')->get();
          $itemsMenu = DB::table('menus')
                 ->where('subMenu','<>','')
                 ->get();
           return view("admin.adminMenuListar",compact('parametros','items','itemsMenu'));

        }

        $this->adminCotizacionesSessionToDdbb();
        \Session::flash('flash-message-success','Menu agregado en forma exitosa .. !!');
          $parametros = DB::table('parametros')->get();
          $items = DB::table('menus')->get();
          $itemsMenu = DB::table('menus')
                 ->where('subMenu','<>','')
                 ->get();
        return view("admin.adminMenuListar",compact('parametros','items','itemsMenu'));
        
    }


    public function adminMenuEditar($id){

        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        $itemsMenu = DB::table('menus')
                 ->where('subMenu','<>','')
                 ->get();

        $menu = DB::table('menus')
                 ->where('id',$id)
                 ->get();                 
        $registro = $menu[0];
        return view("admin.adminMenuEditar",compact('parametros','items','itemsMenu','registro'));

    }


    public function adminMenuUpdate(Request $request ) {
        $id         = $request->Input('id');
        $ordenMenu  = $request->Input('ordenMenu');
        $menu       = $request->Input('menu');
        $posSubMenu = $request->Input('posSubMenu');
        $subMenu    = $request->Input('subMenu');
        $pagina     = $request->Input('pagina');
        $status = false;
        try {
        \DB::table('menus') 
                 ->where('id', $id) 
                 ->update( [ 'ordenMenu'  => $ordenMenu,
                             'menu'       => $menu,
                             'posicion'   => $posSubMenu, 
                             'subMenu'    => $subMenu,
                             'pagina'     => $pagina,
                             'updated_at' => date('Y-m-d G:i:s')]);
             $status = true;
        } catch( Exception $ex ) {
             $status = false;
        }

        if( $status ) {
           $itemsMenu = DB::table('menus')
                 ->where('subMenu','<>','')
                 ->orderBy('ordenMenu','ASC')
                 ->orderBy('posicion','ASC')
                 ->get();

           \Session::flash('flash-message-success','Menu actualizado .. !!'); 
           $parametros = DB::table('parametros')->get();
           $items = DB::table('menus')->get();

           return view('admin/adminMenuListar',compact('parametros','items','itemsMenu'));  
        }  else {
            \Session::flash('flash-message-warniong','Ocurrio un problema al actualizar Menu  .. !!'); 
           $parametros = DB::table('parametros')->get();
           $items = DB::table('menus')->get();
           $itemsMenu = DB::table('menus')
                 ->where('subMenu','<>','')
                 ->get();
           return view('admin/adminMenuListar',compact('parametros','items','itemsMenu'));  

        }

    }



    public function adminMenuEliminar($id){
        //echo "<br>adminMenuEliminar".$id;
        if( strcmp( session()->get('tipo'),'admin')==0 ) {

          $status = false;
          try{
              DB::table('menus') 
                   ->where('id', $id) 
                   ->delete();
          } catch( Exception $ex) {
              $status = false;
          }
          if( $status ) {
             \Session::flash('flash-message-success','Menu ha sido eliminado .. !!'); 
             $parametros = DB::table('parametros')->get();
             $items = DB::table('menus')->get();
             $itemsMenu = DB::table('menus')
                 ->where('subMenu','<>','')
                 ->get();
             return view("admin.adminMenuListar",compact('parametros','items','itemsMenu'));          
          } else {
             \Session::flash('flash-message-warning',"Hubo un problema al intentar eliminar el menu .. !!"); 

             $parametros = DB::table('parametros')->get();
             $items = DB::table('menus')->get();
             $itemsMenu = DB::table('menus')
                 ->where('subMenu','<>','')
                 ->get();
             return view("admin.adminMenuListar",compact('parametros','items','itemsMenu'));          
          }



        } else {
           $parametros = DB::table('parametros')->get();
           $items = DB::table('menus')->get();
           return view("usuarios.index",compact('parametros','items','productos'));
        }        
    }




    public function adminUsuarios(){
        //echo "<br>adminUsuarios";   
        
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        $usuarios = DB::table('usuarios')->get();
        return view("admin.adminUsuarios",compact('parametros','items','usuarios'));  

    }



    public function adminUsuariosNuevo(){
        
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        $usuarios = DB::table('usuarios')->get();
        $datos = ['rut' => '',
                  'nombre' => '',
                  'email' => '',
                  'fonoContacto' => ''];
                       
        return view("admin.adminUsuariosNuevo",compact('parametros','items','usuarios','datos'));  
        
    }
    
    

     public function adminUsuariosNuevoGuardar(Request $request) {

         $rut = $request->Input('rut');
         $nombre = $request->Input('nombre');
         $email = $request->Input('email');
         $password = $request->Input('password');
         $repassword = $request->Input('repassword');
         $fonoContacto = $request->Input('fonoContacto');
         $tipo = $request->Input('tipo');
         
         /*
         echo "<br>rut:". $rut;
         echo "<br>nombre:". $nombre;
         echo "<br>email:". $email;
         echo "<br>pass:". $password;
         echo "<br>repass:". $repassword;
         echo "<br>fono:". $fonoContacto;
         */
         
         /* Valida Rut */
         /* quita el guion para validar */
         
         $rutnumero = substr($rut,0,strlen($rut)-2);
         $digito    = substr($rut,-1);
         //echo "<br>rutnumero:".$rutnumero. " dv:".$digito;
         
         $dv_ = $this->dv($rutnumero);
         //echo "<br>dv_:".$dv_;
         
         if( strcmp( strtoupper($digito), strtoupper($dv_) ) != 0   ) {
             \Session::flash('flash-message-warning',"El rut ingreasdo es incorrecto, favor verificar y reintentarlo .. !!"); 
             $parametros = DB::table('parametros')->get();
             $items = DB::table('menus')->get();
             $datos = ['rut' => $rut,
                       'nombre' => $nombre,
                       'email' => $email,
                       'fonoContacto' => $fonoContacto];
             return view("admin.adminUsuariosNuevo",compact('parametros','items','datos'));              
         }
         
         /* Verificacion Igualdad de Password */
         if( strcmp($password,$repassword) !=0 ) {
             \Session::flash('flash-message-warning',"Las passwords ingresadas son distintas, favor verificar y reintentarlo .. !!"); 
             $parametros = DB::table('parametros')->get();
             $items = DB::table('menus')->get();
             $datos = ['rut' => $rut,
                       'nombre' => $nombre,
                       'email' => $email,
                       'fonoContacto' => $fonoContacto];
             return view("admin.adminUsuariosNuevo",compact('parametros','items','datos'));  
         }
         
         
         /* Verificacion existencia de Rut */
         $verifRut = $this->verifExisteRut( $rut );
         //echo "<br>".$verifRut;
         if( $verifRut > 0 ) {
             echo "<br>Email ya existe";
             \Session::flash('flash-message-warning',"El rut ingresado ya esta registrado, favor verificar y reintentarlo .. !!"); 
             $parametros = DB::table('parametros')->get();
             $items = DB::table('menus')->get();
             $datos = ['rut' => $rut,
                       'nombre' => $nombre,
                       'email' => $email,
                       'fonoContacto' => $fonoContacto];
                       
             return view("admin.adminUsuariosNuevo",compact('parametros','items','datos'));  
             
         } 
         
         
         
         
         
         
         
         
         /* Verificacion existencia de email */
         $verifEmail = $this->verifExisteEmail($email);
         //echo "<br>".$verifEmail;
         
         if( $verifEmail > 0 ) {
             \Session::flash('flash-message-warning',"El email ingresado ya esta registrado, favor verificar y reintentarlo .. !!"); 
             $parametros = DB::table('parametros')->get();
             $items = DB::table('menus')->get();
             $datos = ['rut' => $rut,
                       'nombre' => $nombre,
                       'email' => $email,
                       'fonoContacto' => $fonoContacto];
                       
             return view("admin.adminUsuariosNuevo",compact('parametros','items','datos'));  
             
         } 
         
         
        try{
          $registro = new Usuario;
          $registro->rut=$rut;
          $registro->nombre=$nombre;
          $registro->email=$email;
          $registro->password=md5( $password );
          $registro->tipo=$tipo;
          $registro->fonoContacto=$fonoContacto;
          $registro->estado = "confirmado";
          $registro->save();
          

        } catch( Exception $ex) {
           \Session::flash('flash-message-warning','Ocurrio un problema al intentar guardar usuario .. !!');
          $parametros = DB::table('parametros')->get();
          $items = DB::table('menus')->get();
          $itemsMenu = DB::table('menus')
                 ->where('subMenu','<>','')
                 ->get();
           return view("admin.adminUsuariosNuevo",compact('parametros','items'));
        }
        
        
        \Session::flash('flash-message-success','Nuevo Usuario se ha agregado en forma exitosa .. !!');
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        $usuarios = DB::table('usuarios')->get();
        return view("admin.adminUsuarios",compact('parametros','items','usuarios'));  
        
     }
     
     
     
     
    
     public function adminUsuariosBuscar( Request $request){
       // echo "<br>Update Producto";
        $texto = $request->txtBuscar;
        
        
        
        
        $arrBuscar = explode(" ",$texto );
        
        $numPalabrasBuscar = count($arrBuscar);
        
        
        if( $numPalabrasBuscar == 0  ) {
             $usuarios = DB::table('usuarios')
                      ->orderBy('nombre', 'ASC')
                      ->get();
        }
        
        
         
        if( $numPalabrasBuscar == 1  ) {
             $usuarios = DB::table('usuarios')
                      ->where('nombre','like','%'.$arrBuscar[0].'%')
                      ->orWhere('rut','like','%'.$arrBuscar[0].'%')
                      ->orderBy('nombre', 'ASC')
                      ->get();
        }
        
        if( $numPalabrasBuscar == 2  ) {
             $usuarios = DB::table('usuarios')
                      ->where('nombre','like','%'.$arrProducto[0].'%')
                      ->orWhere('nombre','like','%'.$arrProducto[1].'%')
                      ->orWhere('rut','like','%'.$arrBuscar[0].'%')
                      ->orWhere('rut','like','%'.$arrBuscar[1].'%')
                      ->orderBy('nombre', 'ASC')
                      ->get();
        }
         
         
        if( $numPalabrasBuscar >= 3  ) {
             $usuarios = DB::table('usuarios')
                      ->where('nombre','like','%'.$arrProducto[0].'%')
                      ->orWhere('nombre','like','%'.$arrProducto[1].'%')
                      ->orWhere('nombre','like','%'.$arrProducto[2].'%')
                      ->orWhere('rut','like','%'.$arrBuscar[0].'%')
                      ->orWhere('rut','like','%'.$arrBuscar[1].'%')                      
                      ->orderBy('nombre', 'ASC')
                      ->get();
        }        
        
        

        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();


        $subMenu = DB::table('menus')
        ->select('subMenu')
        ->where('subMenu','<>','')
        ->get();
        //print_r($subMenu);

        \Session::flash('flash-message-success','Usuarios encontrados ...'); 
        return view('admin/adminUsuarios',compact('parametros','items','usuarios'));  
     

    }
    
     
     
     
     
    public function verifExisteEmail($email) {
        $email = \DB::table('usuarios')
                      ->where('email',$email)
                      ->get();
        
        $cont = count($email);
        return( $cont );
    } 


    public function verifExisteRut( $rut ) {
        $rut = \DB::table('usuarios')
                      ->where('rut',$rut)
                      ->get();
        
        $cont = count($rut);
        return( $cont );
    } 
    
    
    
    function dv($r){
       $s=1;
       for($m=0;$r!=0;$r/=10)
          $s=($s+$r%10*(9-$m++%6))%11;
        //echo 'El digito verificador es: ',chr($s?$s+47:75);
       return ( chr($s?$s+47:75) );
    }
    
    function validadorRut($trut) {
        $dvt = substr($trut, strlen($trut) - 1, strlen($trut));
        $rutt = substr($trut, 0, strlen($trut) - 1);
        
        echo "<br>rutt:".$rutt;
        echo "<br>dvt:".$dvt;
        
        $rut = intval($rutt. "0");
        $pa = $rut;
        $c = 2;
        $sum = 0;
        while ($rut > 0)
        {
            $a1 = $rut % 10;
            $rut = floor($rut / 10);
            $sum = $sum + ($a1 * $c);
            $c = $c + 1;
            if ($c == 8)
            {
                $c = 2;
            }
        }
        $di = $sum % 11;
        $digi = 11 - $di;
        $digi1 = ((string )($digi));
        if (($digi1 == '10')) {
            $digi1 = 'K';
        }
        if (($digi1 == '11')) {
            $digi1 = '0';
        }
        
        echo "<br>Div Result:".$digi1;
        /*
        if (($dvt == $digi1)) {
            return ( true );
        } else {
            return ( false );
        }
        */
   }    
    



    public function adminUsuariosEditar( $id){
        //echo "<br>AminProductosEditar";

        //echo "<br>session:".session()->get('tipo');
        if( strcmp( session()->get('tipo'),'admin')==0 ) {
          $parametros = DB::table('parametros')->get();
          $items = DB::table('menus')->get();
          $productos = DB::table('productos')->get();
          $archImage = "";
          $subMenu = DB::table('menus')
                     ->select('subMenu')
                     ->where('subMenu','<>','')
                     ->get();
                  //print_r($subMenu);

          $usuario = DB::table('usuarios')
                      ->where('id','=',$id)
                      ->get();
          $user = $usuario[0];
  
          $estadoUsuarios = DB::table('usuariosEstados')
                            ->get();
          return view("admin.adminUsuariosEditar",compact('parametros','items','user','subMenu','id','estadoUsuarios'));  
        } else {
          $parametros = DB::table('parametros')->get();
          $items = DB::table('menus')->get();
           return view("usuarios.index",compact('parametros','items','productos'));
        }
    }



    public function adminUsuariosUpdate( Request $request){
       // echo "<br>Update Producto";
        $id = $request->id;
        $rut = $request->rut;
        $nombre = $request->nombre;
        $email = $request->email;
        $password = $request->password;
        $fonoContacto = $request->fonoContacto;
        $tipo = $request->tipo;
        $estadoUsuario = $request->estadoUsuario;

        
        $rutnumero = substr($rut,0,strlen($rut)-2);
        $digito    = substr($rut,-1);
     
         
        $dv_ = $this->dv($rutnumero);
    
         
        if( strcmp( strtoupper($digito), strtoupper($dv_) ) != 0   ) {
             \Session::flash('flash-message-warning',"El rut ingreasdo es incorrecto, favor verificar y reintentarlo .. !!"); 
             $parametros = DB::table('parametros')->get();
             $items = DB::table('menus')->get();
             $datos = ['rut' => $rut,
                       'nombre' => $nombre,
                       'email' => $email,
                       'fonoContacto' => $fonoContacto];
            $usuario = DB::table('usuarios')
                      ->where('id','=',$id)
                      ->get();
            $user = $usuario[0];      
            $estadoUsuarios = DB::table('usuariosEstados')
                            ->get();
            return view("admin.adminUsuariosEditar",compact('parametros','items','user','subMenu','id','datos','estadoUsuarios'));              
        }
         
        
        
        $status = false;
        if( empty($request->password)) {
            // Actualiza sin password
             try {
            \DB::table('usuarios') 
                     ->where('id', $id) 
                     ->update( [ 'nombre' => $nombre,
                                 'email' => $email,
                                 'fonoContacto' => $fonoContacto, 
                                 'rut' => $rut,
                                 'tipo' => $tipo,
                                 'estado' => $estadoUsuario,
                                 'updated_at' => date('Y-m-d G:i:s')]);
            $status = true;
            } catch( Exception $ex ) {
                 $status = false;
            }
            
        } else  {
            echo "nueva pass:". $password;
             try {
            \DB::table('usuarios') 
                     ->where('id', $id) 
                     ->update( [ 'nombre' => $nombre,
                                 'email' => $email,
                                 'password' => md5($password),
                                 'fonoContacto' => $fonoContacto, 
                                 'rut' => $rut,
                                 'tipo' => $tipo,
                                 'estado' => $estadoUsuario,
                                 'updated_at' => date('Y-m-d G:i:s')]);
                 $status = true;
            } catch( Exception $ex ) {
                 $status = false;
            }
        }
  
       

        if( $status ) {
          $usuario = DB::table('usuarios')
                      ->where('id','=',$id)
                      ->get();
          $user = $usuario[0];
           \Session::flash('flash-message-success','Usuario actualizado .. !!'); 
           $parametros = DB::table('parametros')->get();
           $items = DB::table('menus')->get();
           $estadoUsuarios = DB::table('usuariosEstados')
                            ->get();
           return view('admin/adminUsuariosEditar',compact('parametros','items','user','estadoUsuarios'));  
        }  else {
            \Session::flash('flash-message-warniong','Ocurrio un problema al actualizar Usuario  .. !!'); 
           $parametros = DB::table('parametros')->get();
           $items = DB::table('menus')->get();
           $usuario = DB::table('usuarios')
                      ->where('id','=',$id)
                      ->get();
           $user = $usuario[0];
           $estadoUsuarios = DB::table('usuariosEstados')
                            ->get();
           return view('admin/adminUsuariosEditar',compact('parametros','items','user','estadoUsuarios'));  

        }
     

    }





    public function adminUsuariosEliminar( $id) {
        //echo "<br>Eliminar Producto:".$id;
       // echo "<br>session:".session()->get('tipo');
        if( strcmp( session()->get('tipo'),'admin')==0 ) {

          $status = false;
          try{
              DB::table('usuarios') 
                   ->where('id', $id) 
                   ->delete();
          } catch( Exception $ex) {
              $status = false;
          }
          if( $status ) {
             \Session::flash('flash-message-success','Usuarios ha sido eliminado .. !!'); 
             $parametros = DB::table('parametros')->get();
             $items = DB::table('menus')->get();
             $usuarios = DB::table('usuarios')->get();
             return view("admin.adminUsuarios",compact('parametros','items','usuarios'));          
          } else {
             \Session::flash('flash-message-warning',"Hubo un problema al intentar eliminar el usuario .. !!"); 

             $parametros = DB::table('parametros')->get();
             $items = DB::table('menus')->get();
             $usuarios = DB::table('usuarios')->get();
             return view("admin.adminUsuarios",compact('parametros','items','usuarios'));          
          }



        } else {
           $parametros = DB::table('parametros')->get();
           $items = DB::table('menus')->get();
           return view("usuarios.index",compact('parametros','items','productos'));
        }

    }







    public function adminProductos(){
        //echo "<br>adminProductos";   
        //echo "<br>session:".session()->get('tipo');
        if( strcmp( session()->get('tipo'),'admin')==0 ) {
          $parametros = DB::table('parametros')->get();
          $items = DB::table('menus')->get();
          $productos = DB::table('productos')
                       ->orderBy('updated_at', 'DESC')
                       ->get();

          return view("admin.adminProductos",compact('parametros','items','productos'));  
        } else {
          $parametros = DB::table('parametros')->get();
          $items = DB::table('menus')->get();
           return view("usuarios.index",compact('parametros','items','productos'));  
        }

    }


    public function adminProductosNuevo(){
        //echo "<br>AminProductosNew";
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        $productos = DB::table('productos')->get();
        $archImage = "image-camara-300x350.jpg";
        $subMenu = DB::table('menus')
                   ->select('subMenu')
                   ->where('subMenu','<>','')
                   ->get();
                //print_r($subMenu);
        //echo "<br>".$subMenu[0]->subMenu;
        //echo "<br>".$subMenu[1]->subMenu;


        return view("admin.adminProductosNuevo",compact('parametros','items','productos','archImage','subMenu'));  
    }


    public function cargaImage( Request $request){
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
        if( $request->Input('subMenu') ) {
            $subMenuSel = $request->Input('subMenu');
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
            
            if( $size > 400000 ) {
                if( strcmp($id,"") == 0 ) { 
                    \Session::flash('flash-message-warning','El tamano del archivo supera los 200K ... !!'); 
                    return view("admin.adminProductosNuevo",compact('parametros','items','prod','archImage','menu','subMenu','subMenuSel','id'));
                    exit();
                } else {
                    \Session::flash('flash-message-warning','El tamano del archivo supera los 200K ... !!'); 
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


    public function adminProductosSave( Request $request){
        //echo "string";
        $menu = $request->input("menu");
        $subMenu = $request->input("submenu");
        $idProducto = $request->input("idProducto");
        $nombre  = $request->input("nombre");
        $descripcion  = $request->input("descripcion");
        $precio  = $request->input("precio");
        $stock  = $request->input("stock");
        $visible  = $request->input("visible");
        $image   = $request->input("image");

        
        if( $this->productoYaExiste($idProducto) ) {
            //echo "<br>Producto ya existe";
            \Session::flash('flash-message-danger','Codigo de Producto Ya existe, favor verificar .. !!');
           $parametros = DB::table('parametros')->get();
           $items = DB::table('menus')->get();
           $productos = DB::table('productos')->get();
           return view('admin.adminProductos',compact('parametros','items','productos'));
        } else {
           // echo "<br>Producto Nuevo";  
          // Inserta contacto en tabla contactos
          
          $contacto = new Producto;
          $contacto->idProducto=$idProducto;
          $contacto->menu=$menu;
          $contacto->subMenu=$subMenu;
          $contacto->nombre=$nombre;
          $contacto->descripcion=$descripcion;
          $contacto->precio=$precio;
          $contacto->image=$image;
          $contacto->stock = $stock;
          $contacto->visible=$visible;
          $contacto->save();

          \Session::flash('flash-message-success','Producto ha sido cargado en forma exitosa... !!'); 

          $parametros = DB::table('parametros')->get();
          $items = DB::table('menus')->get();
          $productos = DB::table('productos')
                       ->orderBy('updated_at', 'DESC')
                       ->get();
          return view('admin/adminProductos',compact('parametros','items','productos')); 
        }
        
    }


    public function adminProductosEditar( $id){
        //echo "<br>AminProductosEditar";

        //echo "<br>session:".session()->get('tipo');
        if( strcmp( session()->get('tipo'),'admin')==0 ) {
          $parametros = DB::table('parametros')->get();
          $items = DB::table('menus')->get();
          $productos = DB::table('productos')->get();
          $archImage = "";
          $subMenu = DB::table('menus')
                     ->select('subMenu')
                     ->where('subMenu','<>','')
                     ->get();
                  //print_r($subMenu);

          $producto = DB::table('productos')
                      ->where('id','=',$id)
                      ->get();
          $prod = $producto[0];
          $archImage = $prod->image;
          $subMenuSel = $prod->subMenu;

          return view("admin.adminProductosEditar",compact('parametros','items','prod','archImage','subMenu','id','subMenuSel'));  
        } else {
          $parametros = DB::table('parametros')->get();
          $items = DB::table('menus')->get();
           return view("usuarios.index",compact('parametros','items','productos'));
        }
    }



    public function adminProductosUpdate( Request $request){
       // echo "<br>Update Producto";
        $id = $request->id;
        $idProducto  = $request->idProducto;
        $nombre = $request->nombre;
        $menu = $request->menu;
        $subMenu = $request->subMenu;
        $descripcion = $request->descripcion;
        $image = $request->image;
        $precio = $request->precio;
        $stock = $request->stock;
        $visible = $request->visible;

        /*echo "<br>id:".$id;
        echo "<br>nombre:".$nombre;
        echo "<br>image:".$image;
        echo "<br>precio:".$precio;
        */
        $status = \DB::table('productos') 
                 ->where('id', $id) 
                 ->update( [ 'nombre' => $nombre,
                             'idProducto' => $idProducto,
                             'menu' => $menu,
                             'subMenu' => $subMenu,
                             'descripcion' => $descripcion,
                             'image' => $image, 
                             'precio' => $precio,
                             'stock' => $stock,
                             'visible' => $visible,
                             'updated_at' => date('Y-m-d G:i:s')]);
      
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        $productos = DB::table('productos')
                       ->orderBy('updated_at', 'DESC')
                       ->get();
        $archImage = "";
        $subMenu = DB::table('menus')
        ->select('subMenu')
        ->where('subMenu','<>','')
        ->get();
        //print_r($subMenu);

        $producto = DB::table('productos')
        ->where('id',$id)
        ->get();
        $prod = $producto[0];
        $archImage = $prod->image;
        //session(['alert-success'=> 'Producto ha sido actualizado en forma exitosa.']);
        \Session::flash('flash-message-success','Producto actualizado .. !!'); 
        $parametros = DB::table('parametros')->get();
        return view('admin/adminProductos',compact('parametros','items','productos'));  

        //return redirect("admin.adminProductosEditar",compact('parametros','items','prod','archImage','subMenu','id'))->with('alert-success','Producto ha sido actualizado en forma exitosa.'); 
     

    }



    public function adminProductosEliminar( $id) {
        //echo "<br>Eliminar Producto:".$id;
       // echo "<br>session:".session()->get('tipo');
        if( strcmp( session()->get('tipo'),'admin')==0 ) {

          try{
              DB::table('productos') 
                   ->where('id', $id) 
                   ->delete();
          } catch( Exception $ex) {
              echo "Error";
          }
          \Session::flash('flash-message-success','Producto ha sido eliminado .. !!'); 
          return redirect('admin/productos');  
        } else {
           $parametros = DB::table('parametros')->get();
           $items = DB::table('menus')->get();
           return view("usuarios.index",compact('parametros','items','productos'));
        }

    }




   public function adminProductosBuscar( Request $request){
       // echo "<br>Update Producto";
        $texto = $request->txtBuscar;
        
        
        
        
        $arrProducto = explode(" ",$texto );
        
        $numPalabrasProducto = count($arrProducto);
         
        if( $numPalabrasProducto == 1  ) {
             $productos = DB::table('productos')
                      ->where('nombre','like','%'.$arrProducto[0].'%')
                      ->orderBy('nombre', 'ASC')
                      ->get();
        }
        
        if( $numPalabrasProducto == 2  ) {
             $productos = DB::table('productos')
                      ->where('nombre','like','%'.$arrProducto[0].'%')
                      ->where('nombre','like','%'.$arrProducto[1].'%')
                      ->orderBy('nombre', 'ASC')
                      ->get();
        }
         
         
        if( $numPalabrasProducto == 3  ) {
             $productos = DB::table('productos')
                      ->where('nombre','like','%'.$arrProducto[0].'%')
                      ->where('nombre','like','%'.$arrProducto[1].'%')
                      ->where('nombre','like','%'.$arrProducto[2].'%')
                      ->orderBy('nombre', 'ASC')
                      ->get();
        }        
        
        
        
        if( $numPalabrasProducto >= 4 ) {
             $productos = DB::table('catalogoProveedores')
                      ->where('nombre','like','%'.$arrProducto[0].'%')
                      ->where('nombre','like','%'.$arrProducto[1].'%')
                      ->where('nombre','like','%'.$arrProducto[2].'%')
                      ->where('nombre','like','%'.$arrProducto[3].'%')
                      ->orderBy('nombre', 'ASC')                      
                      ->get();
        }   
        
        

        


        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();


        $subMenu = DB::table('menus')
        ->select('subMenu')
        ->where('subMenu','<>','')
        ->get();
        //print_r($subMenu);

        \Session::flash('flash-message-success','Productos encontrados ...'); 
        return view('admin/adminProductos',compact('parametros','items','productos'));  
     

    }



    protected function productoYaExiste($idProducto){
        //echo "<br>idProduto:" . $idProducto;
        $producto = DB::table('productos') 
                     ->where('idProducto', $idProducto) 
                     ->get();         
         $count = count( $producto);
         if( $count > 0 ) {
            return true;
         } else {
            return false;
         }
        
    }


    public function adminParams(){
        //echo "<br>adminParams";    
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        //print_r($parametros);

        return view("admin.adminParametros",compact('parametros','items'));  
    }




    public function adminParamsGuardar(Request $request){
         //echo "<br>Params Guardar";

      
          $rut = $request->Input('rut');
          $nombre = $request->Input('nombre');
          $email = $request->Input('email');
          $hostEmail = $request->Input('hostEmail');
          $hostEmailUser = $request->Input('hostEmailUser');
          $hostEmailPass = $request->Input('hostEmailPass');
          $hostEmailPuerto = $request->Input('hostEmailPuerto');
          $fonoContacto = $request->Input('fonoContacto');
          $fonoWhasappEmp = $request->Input('fonoWhasappEmp');

          $direccionEmp = $request->Input('direccionEmp');
          $direccionWeb = $request->Input('direccionWeb');
        
          $status = false;
          try {
              \DB::table('parametros') 
                           ->update([
                             'rut' => $rut,
                             'nombre' => $nombre, 
                             'email' => $email,
                             'hostMail' => $hostEmail,
                             'hostMailUser' => $hostEmailUser,
                             'hostMailPass' => $hostEmailPass,
                             'hostMailPuerto' => $hostEmailPuerto,
                             'fonoContacto' => $fonoContacto,
                             'fonoWhasap' => $fonoWhasappEmp,
                             'direccion' => $direccionEmp,
                             'direccionWeb' => $direccionWeb
                           ]);
              $status = true;

          }catch( Exception $ex){
               $status = false;
    
          }

          if( $status ) {
            \Session::flash('flash-message-success','Parametros han sido actualizados en forma exitosa... !!'); 

            $parametros = DB::table('parametros')->get();
            $items = DB::table('menus')->get();
            $productos = DB::table('productos')->get();
            return view('admin/adminParametros',compact('parametros','items')); 
         } else {
           \Session::flash('flash-message-warning','Ha ocurrido un problema al actualizar parametros!!'); 

            $parametros = DB::table('parametros')->get();
            $items = DB::table('menus')->get();
            $productos = DB::table('productos')->get();
            return view('admin/adminParametros',compact('parametros','items')); 
         }
      


    }
    
    
    public function adminProveedores(){
        //echo "<BR>AdminProveedores";
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        $registros = DB::table('proveedores')->orderBy('updated_at','DESC')->get();
        return view('admin/adminProveedores',compact('parametros','items','registros')); 
        
    }
    
    
    public function adminProveedoresNuevo(){
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        $registros = DB::table('proveedores')->get();
        $datos = [ 'rut' => '',
                   'nombre' => '',
                   'nombreCorto' => '',
                   'giroActividad' => '',
                   'direccion' => '',
                   'contacto' => '',
                   'email' => '',
                   'fonoContacto' => '',
                   'sitioWeb' => ''
                   ];
        echo "<br>rut:".$datos['rut'];
        return view('admin/adminProveedoresNuevo',compact('parametros','items','registros','datos')); 
    }
    
    
    
    public function adminProveedoresBuscar(Request $request ) {
        $texto = $request->Input('txtBuscar');    
        echo "<br>Buscar:" . $texto;
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        $registros = DB::table('proveedores')
                       ->where('nombre','like','%'.$texto.'%')
                       ->whereOr('nombreCorto','like','%'.$texto.'%')
                       ->orderBy('updated_at','DESC')->get();
        return view('admin/adminProveedores',compact('parametros','items','registros')); 
        
    }
    
    public function adminProveedoresSave(Request $request) {
        //echo "<BR>AdminProveedores Save";
        $rut       = $request->Input('rut');
        $nombre    = strtoupper($request->Input('nombre'));
        $nombreCorto =  strtoupper($request->Input('nombreCorto'));
        $giroActividad =  strtoupper($request->Input('giroActividad'));
        $direccion = strtoupper($request->Input('direccion'));
        $email     = $request->Input('email');
        $contacto  = $request->Input('contacto');
        $fonoContacto     = $request->Input('fonoContacto');
        $sitioWeb     = $request->Input('sitioWeb');
        $email        = $request->Input('email');
        
        
        
        $rutnumero = substr($rut,0,strlen($rut)-2);
        $digito    = substr($rut,-1);
        $dv_ = $this->dv($rutnumero);
        if( strcmp( strtoupper($digito), strtoupper($dv_) ) != 0   ) {
            \Session::flash('flash-message-warning',"El rut ingreasdo es incorrecto, favor verificar y reintentarlo .. !!"); 
            $parametros = DB::table('parametros')->get();
            $items = DB::table('menus')->get();
            $datos = [ 'rut' => $rut,
                       'nombre' => $nombre,
                       'email' => $email,
                       'fonoContacto' => $fonoContacto];
            return view("admin.adminProveedoresNuevo",compact('parametros','items','datos'));              
        }
        
         try{
          $registro = new Proveedor;
          $registro->rut=$rut;
          $registro->nombre=$nombre;
          $registro->nombreCorto=$nombreCorto;
          $registro->giroActividad=$giroActividad;
          $registro->direccion=$direccion;
          $registro->contacto=$contacto;
          $registro->fonoContacto=$fonoContacto;
          $registro->sitioWeb=$sitioWeb;
          $registro->email=$email;
          $registro->save();
          
          $itemsMenu = DB::table('menus')
                 ->where('subMenu','<>','')
                 ->get();
           
        
        } catch( Exception $ex) {
           \Session::flash('flash-message-warning','Ocurrio un problema al intentar agregar Menu .. !!');
          $parametros = DB::table('parametros')->get();
          $items = DB::table('menus')->get();
          $itemsMenu = DB::table('menus')
                 ->where('subMenu','<>','')
                 ->get();
           return view("admin.adminMenuListar",compact('parametros','items','itemsMenu'));

        }

        \Session::flash('flash-message-success','Menu agregado en forma exitosa .. !!');
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        $registros = DB::table('proveedores')->orderBy('updated_at','DESC')->get();
        return view("admin.adminProveedores",compact('parametros','items','registros'));
        
        
    }
    
     public function adminProveedoresEditar( $id ) {
        //echo "<br>Editar Proveedores".$id;
        $registro_ = DB::table('proveedores')
                 ->where('id', $id )
                 ->get();
        
        $registro =  $registro_[0];
        
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        return view("admin.adminProveedoresEditar",compact('parametros','items','registro','id'));

         
     }
     
     
     
     
     
     public function adminProveedoresEliminar(   $id ) {
         //echo "<br>Eliminar Proveedores". $id;
        if( strcmp( session()->get('tipo'),'admin')==0 ) {

          try{
              DB::table('proveedores') 
                   ->where('id', $id) 
                   ->delete();
          } catch( Exception $ex) {
              echo "Error";
          }
          \Session::flash('flash-message-success','Proveedor ha sido eliminado .. !!'); 
          $parametros = DB::table('parametros')->get();
          $items = DB::table('menus')->get();
          $registros = DB::table('proveedores')->orderBy('updated_at','DESC')->get();
          return view("admin.adminProveedores",compact('parametros','items','registros'));
        } else {
           $parametros = DB::table('parametros')->get();
           $items = DB::table('menus')->get();
           return view("usuarios.index",compact('parametros','items','productos'));
        }
         
     }     
     
     
     
      public function adminProveedoresUpdate(Request $request){
         //echo "<br>Params Guardar";

          $id = $request->Input('id');
          $rut = $request->Input('rut');
          
          $nombre    = strtoupper($request->Input('nombre'));
          $nombreCorto =  strtoupper($request->Input('nombreCorto'));
          $giroActividad =  strtoupper($request->Input('giroActividad'));
          $direccion = strtoupper($request->Input('direccion'));
          
          $email = $request->Input('email');
          $fonoContacto = $request->Input('fonoContacto');
          $contacto = $request->Input('contacto');
          $sitioWeb = $request->Input('sitioWeb');
          $email  = $request->Input('email');

        
          $status = false;
          try {
              \DB::table('proveedores') 
                           ->where('id', $id) 
                           ->update([
                             'rut' => $rut,
                             'nombre' => $nombre, 
                             'nombreCorto' => $nombreCorto,
                             'giroActividad' => $giroActividad,
                             'direccion' => $direccion,
                             'email' => $email,
                             'contacto' => $contacto,
                             'fonoContacto' => $fonoContacto,
                             'sitioWeb' => $sitioWeb,
                             'email' => $email
                           ]);
              $status = true;

          }catch( Exception $ex){
               $status = false;
    
          }

          if( $status ) {
            \Session::flash('flash-message-success','Proveedor han sido actualizados en forma exitosa... !!'); 

            $registro_ = DB::table('proveedores')
                 ->where('id', $id )
                 ->get();
        
            $registro =  $registro_[0];
            
            $parametros = DB::table('parametros')->get();
            $items = DB::table('menus')->get();
            return view("admin.adminProveedoresEditar",compact('parametros','items','registro','id'));
         } else {
           \Session::flash('flash-message-warning','Ha ocurrido un problema al actualizar proveedor!!'); 

            $registro_ = DB::table('proveedores')
                 ->where('id', $id )
                 ->get();
        
            $registro =  $registro_[0];
            
            $parametros = DB::table('parametros')->get();
            $items = DB::table('menus')->get();
            return view("admin.adminProveedoresEditar",compact('parametros','items','registro','id'));
         }
      


    }
    
    
    
    /*  Cotizaciones Para Cliente */
    public function adminCotizacionesListar() {
        //echo "<br>Listado Cotizaciones";
        
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        $registros  = DB::table('cotizaciones')
                          ->orderBy('fecha','DESC')
                          ->get();
        
        //print_r( $proveedoes );
        return view('admin.adminCotizaciones',compact('registros','parametros','items','proveedores'));
    }
    
    
    public function adminCotizacionesNueva() {
        //echo "<br>Cotizacion Nueva";
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        \Session::forget('carritoCotizacion');
        $carritoCotizacion = \Session::get('carritoCotizacion');
        $infoCabecera = [
        'usuario'=>session('usuario'),
        'codigo'=>'',
        'rut'=>'',
        'nombre'=>'',
        'contacto'=>'',
        'direccion'=>'',
        'ciudad' => '',
        'email'=>'',
        'fonoContacto'=>'',
        'validez'=>'',
        'fecha'=>'',
        'observaciones'=>'',
        'total'=>'0'
        ];
        \Session::put('infoCabecera',$infoCabecera);
        return view('admin.adminCotizacionesNueva',compact('carritoCotizacion','parametros','items','infoCabecera'));
    }
    
    
    
    
    public function adminCotizacionesSaveInfoClieNew( Request $request) {
        $usuario   = session('usuario');
        $rut       = $request->Input('rut');
        $nombre    = $request->Input('nombre');
        $contacto  = $request->Input('contacto');
        $direccion = $request->Input('direccion');
        $ciudad    = $request->Input('ciudad');
        $email     = $request->Input('email');
        $validez   = $request->Input('validez');
        $observaciones = $request->Input('observaciones');
        $fonoContacto  = $request->Input('fonoContacto');
        $total = "0";
        
        
        if( strlen( $rut ) > 0 ) {
            $rutnumero = substr($rut,0,strlen($rut)-2);
            $digito    = substr($rut,-1);
            //echo "<br>rutnumero:".$rutnumero. " dv:".$digito;
             
            $dv_ = $this->dv($rutnumero);
            //echo "<br>dv_:".$dv_;
             
            if( strcmp( strtoupper($digito), strtoupper($dv_) ) != 0   ) {
                 \Session::flash('flash-message-warning',"El rut ingreasdo es incorrecto, favor verificar y reintentarlo .. !!"); 
                 $parametros = DB::table('parametros')->get();
                 $items = DB::table('menus')->get();
                 $datos = ['rut' => $rut,
                           'nombre' => $nombre,
                           'email' => $email,
                           'fonoContacto' => $fonoContacto];
                 $infoCabecera = [
                    'usuario'=>session('usuario'),
                    'codigo'=>'',
                    'rut'=>'',
                    'nombre'=>'',
                    'contacto'=>'',
                    'direccion'=>'',
                    'ciudad' => '',
                    'email'=>'',
                    'fonoContacto'=>'',
                    'validez'=>'',
                    'fecha'=>'',
                    'observaciones'=>'',
                    'total'=>'0'
                    ];
                 \Session::put('infoCabecera',$infoCabecera);
                 $carritoCotizacion = \Session::get('carritoCotizacion');
                 return view("admin.adminCotizacionesNueva",compact('parametros','items','datos','infoCabecera','carritoCotizacion'));              
            }
        }
        
        
        
        
        $now = new \DateTime();
        
        
        $codigo =  rand();
        try{
          //echo "<br>Guarda Encabezado";
          $registro = new Cotizacion;
          $registro->usuario = $usuario;
          $registro->codigo=$codigo;
          $registro->rut=$rut;
          $registro->nombre=$nombre;
          $registro->contacto=$contacto;
          $registro->direccion=$direccion;
          $registro->ciudad=$ciudad;
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
                         'ciudad' => $ciudad,
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
    
    
    
    
    public function adminCotizacionesEliminarCotiz(   $codigo ) {
        //echo "<br>Elimina Cotizacion ". $codigo;
        if( strcmp( session()->get('tipo'),'admin')==0 ) {
          /* Elimina Header */
          try{
              DB::table('cotizaciones') 
                   ->where('codigo', $codigo) 
                   ->delete();
          } catch( Exception $ex) {
              echo "Error";
          }
          
          /* Elimina Detalle */
          try{
              DB::table('cotizaciones_detalle') 
                   ->where('codigo', $codigo) 
                   ->delete();
          } catch( Exception $ex) {
              echo "Error";
              
              \Session::flash('flash-message-warning','Ocurrio un problema al intentar eliminar registro  .. !!'); 
              $parametros = DB::table('parametros')->get();
              $items = DB::table('menus')->get();
              $registros = DB::table('cotizaciones')->get();
              return view("admin.adminCotizaciones",compact('parametros','items','registros'));              
              
          }          
          \Session::flash('flash-message-success','Registro ha sido eliminado .. !!'); 
          $parametros = DB::table('parametros')->get();
          $items = DB::table('menus')->get();
          $registros = DB::table('cotizaciones')->get();
          return view("admin.adminCotizaciones",compact('parametros','items','registros'));
        } else {
           $parametros = DB::table('parametros')->get();
           $items = DB::table('menus')->get();
           return view("usuarios.index",compact('parametros','items','productos'));
        }
         
     }   
     
     
     
    public function adminCotizacionesAddManual(Request $request) {
        $idProducto = "99999";
        $codCotizacion = $request->Input("id");
        $codProductoCatalogo = "SIN-CODIGO";
        $proveedor = $request->Input("proveedor");
        $producto  = $request->Input("producto");
        $cantidad = $request->Input("cantidad");
        $precio   = $request->Input("precio");
        $subtotal = $cantidad * $precio;
        
        /*
        echo "<br>addManual".$codCotizacion;
        echo "<br>proveedor".$proveedor;
        echo "<br>producto".$producto;
        echo "<br>cantidad".$cantidad;
        echo "<br>precio".$precio;
        echo "<br>subtotal".$subtotal;
        */
        
        
        $infoCabecera = \Session::get('infoCabecera'); 
        $carritoCotizacion = \Session::get('carritoCotizacion');
        
        $carritoCotizacion[$idProducto]['id'] = $idProducto;
        $carritoCotizacion[$idProducto]['proveedor'] = $proveedor;
        $carritoCotizacion[$idProducto]['codProductoCatalogo'] =$codProductoCatalogo;
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
        
        
        $this->adminCotizacionesSessionToDdbb();
         
        $carritoCotizacion = \Session::get('carritoCotizacion');
        print_r( $carritoCotizacion);
    
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
       // echo "<br>****";
        //print_r( $infoCabecera);
        return view('admin.adminCotizacionesEditor',compact('carritoCotizacion','parametros','items','infoCabecera'));
        
    }
     
     
     
    public function adminCotizacionesBuscar(Request $request ) {
        //$texto = $request->Input('txtBuscar');
        $codigo = $request->Input('txtCodigo');
        $nombre = strtoupper ($request->Input('txtNombre'));
        $producto = strtoupper ($request->Input('txtProducto'));
        $ciudad = strtoupper ($request->Input('txtCiudad'));
        //echo "<br>adminCotizacioneBuscar:".$texto;
        
        
        /*
        $registros = \DB::statement(" select * from cotizaciones where cotizaciones.codigo in ( select codigo from cotizaciones_detalle where producto like '%'.$texto.'%' ");
        print_r( $registros );
        */
/*
        $registros = DB::table('cotizaciones')
        ->join('cotizaciones_detalle', function ($join) {
            $join->on('cotizaciones.codigo', '=', 'cotizaciones_detalle.codigo')
                 ->where('cotizaciones_detalle.producto', 'like', '%'.$texto,'%')
                 ->orWhere('cotizaciones_detalle.nombre', 'like', '%'.$nombre,'%')
                 ->orWhere('cotizaciones_detalle.codigo', '=', $codigo)
        ->get();
    
    */
    
        if( strcmp( $codigo, "") != 0 ) {
            $parametros = DB::table('parametros')->get();
            $items = DB::table('menus')->get();    
            $registros = DB::table('cotizaciones')
                          ->where('codigo',$codigo)
                          ->get();
            return view('admin.adminCotizaciones',compact('registros','parametros','items'));
        }
        
        
        if( strcmp( $nombre, "") != 0 ) {
            $parametros = DB::table('parametros')->get();
            $items = DB::table('menus')->get();    
            $registros = DB::table('cotizaciones')
                          ->where('nombre','like','%'.$nombre.'%')
                          ->get();
            return view('admin.adminCotizaciones',compact('registros','parametros','items'));
        }
        
        
        
        
        if( strcmp( $ciudad, "") != 0 ) {
            $parametros = DB::table('parametros')->get();
            $items = DB::table('menus')->get();    
            $registros = DB::table('cotizaciones')
                          ->where('ciudad',$ciudad)
                          ->get();
            return view('admin.adminCotizaciones',compact('registros','parametros','items'));
        }        
        
        
        if( strcmp( $producto, "") != 0 ) {
        
            $registros  = DB::table('cotizaciones')
            ->leftJoin('cotizaciones_detalle', 'cotizaciones.codigo', '=', 'cotizaciones_detalle.codigo')
            ->where('cotizaciones_detalle.producto','like','%'.$producto.'%')
            ->select('cotizaciones.id','cotizaciones.codigo','cotizaciones.usuario','cotizaciones.rut','cotizaciones.nombre','cotizaciones.fonoContacto','cotizaciones.contacto','cotizaciones.fecha')
            ->distinct()
            ->get();
   
            $parametros = DB::table('parametros')->get();
            $items = DB::table('menus')->get();                        
            return view('admin.adminCotizaciones',compact('registros','parametros','items'));
   
        
        }
        
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();    
        $registros = DB::table('cotizaciones')
                          ->orderBy('fecha','DESC')
                          ->get();
        return view('admin.adminCotizaciones',compact('registros','parametros','items'));
        
                        
        
    } 
    
    
    
    
    
    
    /*  Cotizaciones Internas e */
    public function adminCotizacionesInternasListar() {
        //echo "<br>Listado Cotizaciones";
        
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        $registros  = DB::table('cotizacionesinternas')->get();
        
        //print_r( $proveedoes );
        return view('admin.adminCotizacionesInternas',compact('registros','parametros','items','proveedores'));
    }
    
    
    
    public function adminCotizacionesInternasNueva() {
        //echo "<br>Cotizacion Nueva";
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        \Session::forget('carritoCotizacionInterna');
        $carritoCotizacionInterna = \Session::get('carritoCotizacionInterna');
        $infoCabecera = [
        'usuario'=>session('usuario'),
        'codigo'=>'',
        'rut'=>'',
        'nombre'=>'',
        'contacto'=>'',
        'direccion'=>'',
        'ciudad'=>'',
        'email'=>'',
        'fonoContacto'=>'',
        'validez'=>'',
        'fecha'=>'',
        'observaciones'=>'',
        'total'=>'0'
        ];
        \Session::put('infoCabecera',$infoCabecera);
        return view('admin.adminCotizacionesInternasNueva',compact('carritoCotizacionInterna','parametros','items','infoCabecera'));
    }
    
    
    public function adminCotizacionesInternasSaveInfoClieNew( CotizNuevaRequest $request) {
        
        //echo "<br>adminCotizacionesInternasSaveInfoClieNew";
        
        $validated = $request->validated();
        
        
        $usuario   = session('usuario');
        $rut       = $request->Input('rut');
        $nombre    = $request->Input('nombre');
        $contacto  = $request->Input('contacto');
        $direccion = $request->Input('direccion');
        $ciudad    = $request->Input('ciudad');
        $email     = $request->Input('email');
        $validez   = $request->Input('validez');
        $observaciones = $request->Input('observaciones');
        $fonoContacto  = $request->Input('fonoContacto');
        $total = "0";
        
        $now = new \DateTime();
        $fecha = $now->format('d-m-Y H:i:s');
        $codigo =  rand();
        try{
          //echo "<br>Guarda Encabezado";
          $registro = new Cotizacioninterna;
          $registro->usuario = $usuario;
          $registro->codigo=$codigo;
          $registro->rut=$rut;
          $registro->nombre=$nombre;
          $registro->contacto=$contacto;
          $registro->direccion=$direccion;
          $registro->ciudad=$ciudad;
          $registro->email=$email;
          $registro->fonoContacto=$fonoContacto;
          $registro->total=$total;
          $registro->validez=$validez;
          $registro->fecha=$fecha;
          $registro->observaciones=$observaciones;
          $registro->save();
          
        } catch( Exception $ex) {
             $carritoCotizacion = [];
            \Session::flash('flash-message-warning','Ocurrio un problema al intentar guardar  ... !!');
            $parametros = DB::table('parametros')->get();
            $items = DB::table('menus')->get();
            return view("admin.adminCotizacionesInternasEditor",compact('carritoCotizacion','parametros','items','infoCabecera'));
        }
        
        
        $infoCabeceraCotizInterna = [
                         'usuario' => $usuario,
                         'codigo' => $codigo,
                         'rut' => $rut,
                         'nombre' => $nombre,
                         'contacto' => $contacto,
                         'direccion' => $direccion,
                         'ciudad' => $ciudad,
                         'email' => $email,
                         'fonoContacto' => $fonoContacto,
                         'total' => $total,
                         'validez' => $validez,
                         'fecha' => $fecha,
                         'observaciones' => $observaciones
                         ];
                   
        $carritoCotizacionInterna = [];
        \Session::put('infoCabeceraCotizInterna',$infoCabeceraCotizInterna);
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        return view("admin.adminCotizacionesInternasEditor",compact('carritoCotizacionInterna','parametros','items','infoCabeceraCotizInterna'));
    
        
    }
    
    
    
    public function adminCotizacionesInternasDescargar($codigo){
        //echo "<br>adminCotizacioneInternasDescargar:".$codigo;
        $infoCabeceraCotizInterna_ = \DB::table('cotizacionesinternas')->where('codigo',$codigo)->get();
        $infoCabeceraCotizInterna = ['codigo' => $infoCabeceraCotizInterna_[0]->codigo,
                         'rut' => $infoCabeceraCotizInterna_[0]->rut,
                         'usuario' => strtoupper($infoCabeceraCotizInterna_[0]->usuario),
                         'nombre' => strtoupper($infoCabeceraCotizInterna_[0]->nombre),
                         'contacto' => strtoupper($infoCabeceraCotizInterna_[0]->contacto),
                         'direccion' => strtoupper($infoCabeceraCotizInterna_[0]->direccion),
                         'email' => $infoCabeceraCotizInterna_[0]->email,
                         'fonoContacto' => $infoCabeceraCotizInterna_[0]->fonoContacto,
                         'fecha' => $infoCabeceraCotizInterna_[0]->fecha,
                         'validez' => $infoCabeceraCotizInterna_[0]->validez,
                         'observaciones' => strtoupper($infoCabeceraCotizInterna_[0]->observaciones),
                         'total' => $infoCabeceraCotizInterna_[0]->total
                         ];
                         
                         
        //print_r( $infoCabeceraCotizInterna );
        
        $carritoCotizacionDetalleInterna_ = \DB::table('cotizacionesinternas_detalle')
                              ->where('codigo',$codigo)
                              ->orderBy('proveedor')
                              ->orderBy('producto')
                              ->get();
                              
        $carritoCotizacionInterna = [];
        foreach(  $carritoCotizacionDetalleInterna_ as $dato ) {
                //echo "<br>".$dato->codigo.";".$dato->producto.";".$dato->cantidad.";".$dato->precio.";".$dato->subtotal;
                $carritoCotizacionInterna[$dato->id]['id'] = $dato->id;
                $carritoCotizacionInterna[$dato->id]['codigo'] = $dato->codigo;
                $carritoCotizacionInterna[$dato->id]['proveedor'] = strtoupper($dato->proveedor);
                $carritoCotizacionInterna[$dato->id]['producto'] = strtoupper($dato->producto);
                $carritoCotizacionInterna[$dato->id]['cantidad'] = $dato->cantidad;
                $carritoCotizacionInterna[$dato->id]['precio'] = $dato->precio;
                $carritoCotizacionInterna[$dato->id]['subtotal'] = $dato->subtotal;
        }
        
        //print_r( $carritoCotizacionInterna );
    
       $ddmmaaaa = date('dmY');
       $ARCHIVO = "COTIZ-INTERNA-".$infoCabeceraCotizInterna['codigo']."-".$ddmmaaaa.".pdf";
       $pdf = \PDF::loadView('admin.pruebaparapdfcotizinterna',compact('infoCabeceraCotizInterna','carritoCotizacionInterna'));
       return $pdf->download( $ARCHIVO );
      
        
    }
    
    
    public function adminCotizacionesInternasEliminarCotiz(   $codigo ) {
        //echo "<br>Elimina Cotizacion ". $codigo;
        if( strcmp( session()->get('tipo'),'admin')==0 ) {
          /* Elimina Header */
          try{
              DB::table('cotizacionesinternas') 
                   ->where('codigo', $codigo) 
                   ->delete();
          } catch( Exception $ex) {
              echo "Error";
          }
          
          /* Elimina Detalle */
          try{
              DB::table('cotizacionesinternas_detalle') 
                   ->where('codigo', $codigo) 
                   ->delete();
          } catch( Exception $ex) {
              echo "Error";
              
              \Session::flash('flash-message-warning','Ocurrio un problema al intentar eliminar registro  .. !!'); 
              $parametros = DB::table('parametros')->get();
              $items = DB::table('menus')->get();
              $registros = DB::table('cotizacionesinternas')->get();
              return view("admin.adminCotizacionesInternas",compact('parametros','items','registros'));              
              
          }          
          \Session::flash('flash-message-success','Registro ha sido eliminado .. !!'); 
          $parametros = DB::table('parametros')->get();
          $items = DB::table('menus')->get();
          $registros = DB::table('cotizacionesinternas')->get();
          return view("admin.adminCotizacionesInternas",compact('parametros','items','registros'));
        } else {
           $parametros = DB::table('parametros')->get();
           $items = DB::table('menus')->get();
           return view("usuarios.index",compact('parametros','items','productos'));
        }
         
     }   
    
    
    
    public function adminCotizacionesInternasEditar($item) {
        //echo "<br>adminCotizacionesEditar";
    
        $infoCabeceraCotizInterna_ = \DB::table('cotizacionesinternas')->where('codigo',$item)->get();
        $infoCabeceraCotizInterna = [
                         'codigo' => $infoCabeceraCotizInterna_[0]->codigo,
                         'usuario' => $infoCabeceraCotizInterna_[0]->usuario,
                         'rut' => $infoCabeceraCotizInterna_[0]->rut,
                         'nombre' => $infoCabeceraCotizInterna_[0]->nombre,
                         'contacto' => $infoCabeceraCotizInterna_[0]->contacto,
                         'direccion' => $infoCabeceraCotizInterna_[0]->direccion,
                         'ciudad' => $infoCabeceraCotizInterna_[0]->ciudad,
                         'email' => $infoCabeceraCotizInterna_[0]->email,
                         'fonoContacto' => $infoCabeceraCotizInterna_[0]->fonoContacto,
                         'fecha' => $infoCabeceraCotizInterna_[0]->fecha,
                         'validez' => $infoCabeceraCotizInterna_[0]->validez,
                         'observaciones' => $infoCabeceraCotizInterna_[0]->observaciones,
                         'total' => $infoCabeceraCotizInterna_[0]->total
                         ];
        \Session::put('infoCabeceraCotizInterna',$infoCabeceraCotizInterna);
        $carritoCotizacionInterna_ = \DB::table('cotizacionesinternas_detalle')
                                     ->where('codigo',$item)
                                     ->orderBy('proveedor')
                                     ->orderBy('producto')
                                     ->get();
        $carritoCotizacionInterna = [];
        foreach(  $carritoCotizacionInterna_ as $dato ) {
            //echo "<br>".$dato->codigo.";".$dato->producto.";".$dato->cantidad.";".$dato->precio.";".$dato->subtotal;
            $carritoCotizacionInterna[$dato->id]['id'] = $dato->id;
            $carritoCotizacionInterna[$dato->id]['codigo'] = $dato->codigo;
            $carritoCotizacionInterna[$dato->id]['codProductoCatalogo'] = $dato->codProductoCatalogo;
            $carritoCotizacionInterna[$dato->id]['proveedor'] = $dato->proveedor;
            $carritoCotizacionInterna[$dato->id]['producto'] = $dato->producto;
            $carritoCotizacionInterna[$dato->id]['cantidad'] = $dato->cantidad;
            $carritoCotizacionInterna[$dato->id]['precio'] = $dato->precio;
            $carritoCotizacionInterna[$dato->id]['subtotal'] = $dato->subtotal;
        }
        \Session::put('carritoCotizacionInterna',$carritoCotizacionInterna);
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        return view('admin.adminCotizacionesInternasEditor',compact('carritoCotizacionInterna','parametros','items','infoCabeceraCotizInterna'));
    }
    
    
     public function adminCotizacionesInternasAddProductoFromCatalogo( $idProducto){
       // echo "<br>Cotiz agrega producto:adminCotizacionesInternasAddProducto from catalogo:".$idProducto;

        if( session()->has('infoCabeceraCotizInterna')) {
            echo "<br>Cabecera existe";
            $infoCabeceraCotizInterna = \Session::get('infoCabeceraCotizInterna'); 
            if( !isset( $infoCabeceraCotizInterna['codigo'] ) ){
                $infoCabeceraCotizInterna['codigo'] = '';
            }
            if( !isset( $infoCabeceraCotizInterna['rut'] ) ){
                $infoCabeceraCotizInterna['rut'] = '';
            }
            if( !isset( $infoCabeceraCotizInterna['nombre'] ) ){
                $infoCabeceraCotizInterna['nombre'] = '';
            }  
            if( !isset( $infoCabeceraCotizInterna['direccion'] ) ){
                $infoCabeceraCotizInterna['direccion'] = '';
            }              
            if( !isset( $infoCabeceraCotizInterna['email'] ) ){
                $infoCabeceraCotizInterna['email'] = '';
            }
            if( !isset( $infoCabeceraCotizInterna['fonoContacto'] ) ){
                $infoCabeceraCotizInterna['fonoContacto'] = '';
            } 
            if( !isset( $infoCabeceraCotizInterna['contacto'] ) ){
                $infoCabeceraCotizInterna['contacto'] = '';
            }    
            if( !isset( $infoCabeceraCotizInterna['validez'] ) ){
                $infoCabeceraCotizInterna['validez'] = '';
            }
            if( !isset( $infoCabeceraCotizInterna['observaciones'] ) ){
                $infoCabeceraCotizInterna['observaciones'] = '';
            }
            if( !isset( $infoCabeceraCotizInterna['total'] ) ){
                $infoCabeceraCotizInterna['total'] = '';
            }    
            
        } else {
            echo "<br>infoCabecera no existe";
             $infoCabeceraCotizInterna = ['codigo' => '',
                             'rut' => '',
                             'nombre' => '',
                             'contacto' => '',
                             'direccion' => '',
                             'ciudad' => '',
                             'email' => '',
                             'fonoContacto' => '',
                             'validez' => '',
                             'observaciones' => '',
                             'total' => ''
                             ];
        }
        
        
    //echo "<br>Codigo:". $infoCabeceraCotizInterna['codigo'];
        if( session()->has('carritoCotizacionInterna')) {
            echo "<br>Carrito detalle  existe";
            $carritoCotizacionInterna = \Session::get('carritoCotizacionInterna');
        }
        $producto = DB::table('catalogoProveedores')
                          ->where( 'id',$idProducto)
                          ->get();

        if( empty( $carritoCotizacionInterna[$idProducto]['id'] )  ) {
            $carritoCotizacionInterna[$idProducto]['id'] = $producto[0]->id;
            $carritoCotizacionInterna[$idProducto]['codProductoCatalogo'] = $producto[0]->codProductoProveedor;
            $carritoCotizacionInterna[$idProducto]['proveedor'] = $producto[0]->proveedor;
            $carritoCotizacionInterna[$idProducto]['producto'] = $producto[0]->producto;
            $carritoCotizacionInterna[$idProducto]['cantidad'] = 1;
            $carritoCotizacionInterna[$idProducto]['precio'] = $producto[0]->precio;
            $carritoCotizacionInterna[$idProducto]['subtotal'] = $producto[0]->precio;
        } else {
            $carritoCotizacionInterna[$idProducto]['id'] = $producto[0]->id;
            $carritoCotizacionInterna[$idProducto]['proveedor'] = $producto[0]->proveedor;
            $carritoCotizacionInterna[$idProducto]['codProductoCatalogo'] = $producto[0]->codProductoProveedor;            
            $carritoCotizacionInterna[$idProducto]['producto'] = $producto[0]->producto;
            $carritoCotizacionInterna[$idProducto]['cantidad']++;
            $carritoCotizacionInterna[$idProducto]['precio'] = $producto[0]->precio;
            $carritoCotizacionInterna[$idProducto]['subtotal'] = $producto[0]->precio*$carritoCotizacionInterna[$idProducto]['cantidad'];
            
        }
    
    
        \Session::put('carritoCotizacionInterna',$carritoCotizacionInterna);
        \Session::put('carritoCotizacionInterna-count',count($carritoCotizacionInterna));
        $total = 0;
        foreach ( $carritoCotizacionInterna as $dato ) {
            //echo "<br>precio:".$dato['precio']. " cant:".$dato['cantidad'];
            $total += $dato['precio'] * $dato['cantidad'];
        } 
        
        //echo "<br>Total:". $total;
        $infoCabecera['total'] = $total;
        \Session::put('infoCabeceraCotizInterna',$infoCabeceraCotizInterna ); 
        \Session::put('carritoCotizacionInterna-total',$total ); 

        $carritoCotizacionInterna = \Session::get('carritoCotizacionInterna');
        $infoCabeceraCotizInterna = \Session::get('infoCabeceraCotizInterna'); 
        
        
        $this->adminCotizacionesInternasSessionToDdbb();
        
    
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        
        //print_r( $infoCabecera);

        return view('admin.adminCotizacionesInternasEditor',compact('carritoCotizacionInterna','parametros','items','infoCabeceraCotizInterna'));
        
    }
    
    
    
    
     public function adminCotizacionesInternasAddManual(Request $request) {
        $idProducto = "99999";
        $codCotizacion = $request->Input("id");
        $codProductoCatalogo = "SIN-CODIGO";
        $proveedor = $request->Input("proveedor");
        $producto  = $request->Input("producto");
        $cantidad = $request->Input("cantidad");
        $precio   = $request->Input("precio");
        $subtotal = $cantidad * $precio;
        
        /*
        echo "<br>addManual".$codCotizacion;
        echo "<br>proveedor".$proveedor;
        echo "<br>producto".$producto;
        echo "<br>cantidad".$cantidad;
        echo "<br>precio".$precio;
        echo "<br>subtotal".$subtotal;
        */
        
        $infoCabeceraCotizInterna = \Session::get('infoCabeceraCotizInterna'); 
        $carritoCotizacionInterna = \Session::get('carritoCotizacionInterna');
        
        $carritoCotizacionInterna[$idProducto]['id'] = $idProducto;
        $carritoCotizacionInterna[$idProducto]['proveedor'] = $proveedor;
        $carritoCotizacionInterna[$idProducto]['codProductoCatalogo'] =$codProductoCatalogo;
        $carritoCotizacionInterna[$idProducto]['producto'] = $producto;
        $carritoCotizacionInterna[$idProducto]['cantidad'] = $cantidad;
        $carritoCotizacionInterna[$idProducto]['precio'] = $precio;
        $carritoCotizacionInterna[$idProducto]['subtotal'] = $subtotal;
        
        \Session::put('carritoCotizacionInterna',$carritoCotizacionInterna);
        
        
        $total = 0;
        foreach ( $carritoCotizacionInterna as $dato ) {
            //echo "<br>precio:".$dato['precio']. " cant:".$dato['cantidad'];
            $total += $dato['precio'] * $dato['cantidad'];
        } 
        
        \Session::put('infoCabeceraCotizInterna',$infoCabeceraCotizInterna ); 
        \Session::put('carritoCotizacionInterna-total',$total );
        
        
        $this->adminCotizacionesInternasSessionToDdbb();
         
        $carritoCotizacionInterna = \Session::get('carritoCotizacionInterna');
        print_r( $carritoCotizacionInterna);
    
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
       // echo "<br>****";
        //print_r( $infoCabecera);
        return view('admin.adminCotizacionesInternasEditor',compact('carritoCotizacionInterna','parametros','items','infoCabeceraCotizInterna'));
        
    }
     
    
    
    
    public function adminCotizacionesInternasUpdateProducto(Request $request )    {
        //echo "<br>Cotiz Update Producto:";
        $id       = $request->Input('id');
        $cantidad = $request->Input('qty');
        $precio   = $request->Input('precio');
        
        /*
        echo "<br>id:". $id;
        echo "<br>cantidad:". $cantidad;
        echo "<br>precio:". $precio;
        */
        $carritoCotizacionInterna = \Session::get('carritoCotizacionInterna');
        $carritoCotizacionInterna[$id]['cantidad'] = $cantidad;
        $carritoCotizacionInterna[$id]['subtotal'] = $cantidad *  $precio;
        \Session::put('carritoCotizacionInterna',$carritoCotizacionInterna);
        
        $total = 0;
        foreach ( $carritoCotizacionInterna as $dato ) {
            $total += $dato['precio'] * $dato['cantidad'];
        } 
        \Session::put('carritoCotizacionInterna-total',$total ); 
        
        if( session()->has('infoCabeceraCotizInterna')) {
            //echo "<br>infoCabecera existe";
            $infoCabeceraCotizInterna = \Session::get('infoCabeceraCotizInterna');
            if( !isset( $infoCabeceraCotizInterna['total'] ) ){
                $infoCabeceraCotizInterna['total'] = '';
            }  else {
                $infoCabeceraCotizInterna['total'] = $total;
            }
        } else {
            echo "<br>infoCabecera no existe";
        }
    
        //print_r( $infoCabecera);
        
        
        
        \Session::put('infoCabeceraCotizInterna',$infoCabeceraCotizInterna);        
        //echo "<br>infoCabeceraTotal:".$infoCabecera['total'];
        
        $this->adminCotizacionesInternasSessionToDdbb();
        
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        $subMenu = session()->get('subMenu');
        
        return view('admin.adminCotizacionesInternasEditor',compact('carritoCotizacionInterna','parametros','items','infoCabeceraCotizInterna'));
    
    
    }
    
    
    
    public function adminCotizacionesInternasDeleteProducto( $id){
        //echo "<br>Cotiz Delete Producto:";
        $carritoCotizacionInterna = \Session::get('carritoCotizacionInterna');
        $infoCabeceraCotizInterna  = \Session::get('infoCabeceraCotizInterna');
        unset($carritoCotizacionInterna[$id]);
        //print_r($carrito);

        \Session::put('carritoCotizacionInterna',$carritoCotizacionInterna);
        \Session::put('carritoCotizacionInterna-count',count($carritoCotizacionInterna));
        
        $total = 0;
        foreach ( $carritoCotizacionInterna as $dato ) {
            $total += $dato['precio'] * $dato['cantidad'];
        } 
        \Session::put('carritoCotizacionInterna-total',$total ); 
        
        
        if( session()->has('infoCabecera')) {
            if( !isset( $infoCabeceraCotizInterna['total'] ) ){
                $infoCabeceraCotizInterna['total'] = '';
            }  else {
                $infoCabeceraCotizInterna['total'] = $total;
            }
        }
        
        $this->adminCotizacionesInternasSessionToDdbb();
        
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        $subMenu = session()->get('subMenu');
        return view('admin.adminCotizacionesInternasEditor',compact('carritoCotizacionInterna','parametros','items','infoCabeceraCotizInterna'));


    }    
    
    
    
    
    public function adminCotizacioneInternasSave( Request $request) {
        //echo "<br>Guarda Cotiz Interna";
        $codigo    = $request->Input('codigo');
       // echo "<br>Cotiz Save:".$codigo;
        $codigo    = $request->Input('codigo');
        $usuario   = session('usuario');
        $rut       = $request->Input('rut');
        $nombre    = $request->Input('nombre');
        $contacto  = $request->Input('contacto');
        $direccion = $request->Input('direccion');
        $email     = $request->Input('email');
        $validez   = $request->Input('validez');
        $observaciones = $request->Input('observaciones');
        $ciudad    = $request->Input('ciudad');
        $fonoContacto  = $request->Input('fonoContacto');
        $carritoCotizacionInterna = \Session::get('carritoCotizacionInterna');
        $infoCabeceraCotizInterna = \Session::get('infoCabeceraCotizInterna');
        //$codigo = $infoCabecera['codigo'];
        $now = new \DateTime();
        
        //print_r($infoCabecera);
        //print_r($carritoCotizacion);
        
        
        
        $total = 0;
        foreach( $carritoCotizacionInterna as $dato ) {
               //echo "<br>".$dato['producto'] . " " . $dato['cantidad']. " " . $dato['precio'];
                $total+=$dato['cantidad'] * $dato['precio'];
        }
        //echo "<br>total:".$total;
        $infoCabeceraCitizInterna['total'] = $total;
        

        if( DB::table('cotizacionesinternas')->where('codigo', $codigo)->exists() ) {
            //echo "<br>Ya existe el codigo en bbdd cotizaciones";
            //echo "<br>Actualizazr";
             try {
             \DB::table('cotizacionesinternas') 
                 ->where('codigo', $codigo) 
                 ->update( [ 'usuario' => $usuario,
                             'rut'  => $rut,
                             'nombre'     => $nombre,
                             'contacto'   => $contacto, 
                             'direccion'   => $direccion, 
                             'email'      => $email,
                             'contacto'   => $contacto,
                             'ciudad'     => $ciudad,
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
              $registro = new Cotizacioninterna;
              $registro->usuario = $usuario;
              $registro->codigo=$codigo;
              $registro->rut=$rut;
              $registro->nombre=$nombre;
              $registro->contacto=$contacto;
              $registro->direccion=$direccion;
              $registro->ciudad=$ciudad0;
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
                return view("admin.adminCotizacionesInternasEditor",compact('carritoCotizacionInterna','parametros','items','infoCabeceraCotizInterna'));
            }
        }
        
        if( DB::table('cotizacionesinternas_detalle')->where('codigo', $codigo)->exists() ) {
             
             //echo "<bR>Borrar detalle anterior";
             try {
                //echo "<br>Borrando Detalle Codigo;".$codigo;
                CotizacioninternaDetalle::where('codigo', $codigo)->delete();
                
             }catch( Exception $ex) {
                \Session::flash('flash-message-warning','Ocurrio un problema al intentar guardar  ... !!');
                $parametros = DB::table('parametros')->get();
                $items = DB::table('menus')->get();
                
                return view("admin.adminCotizacionesInternasEditor",compact('carritoCotizacionInterna','parametros','items','infoCabeceraCotizInterna'));
            }
        }    
            
             
        // echo "<bR>Guarda Detalle";
         try{
          foreach( $carritoCotizacionInterna as $dato ) {
             $registro = new CotizacioninternaDetalle;
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
            
            return view("admin.adminCotizacionesInternasEditor",compact('carritoCotizacionInterna','parametros','items','infoCabeceraCotizInterna'));
        }
             
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        $infoCabeceraCotizInterna = ['usuario' => $usuario,
                         'codigo' => $codigo,
                         'rut' => $rut,
                         'nombre' => $nombre,
                         'contacto' => $contacto,
                         'direccion' => $direccion,
                         'ciudad' => $ciudad,
                         'email' => $email,
                         'fonoContacto' => $fonoContacto,
                         'total' => $total,
                         'validez' => $validez,
                         'fecha' => date('d-m-Y'),
                         'observaciones' => $observaciones
                         ];
                        
        //$this->adminCotizacionesInternasSessionToDdbb();
        \Session::put('carritoCotizacionInterna',$carritoCotizacionInterna);
        \Session::put('infoCabeceraCotizInterna',$infoCabeceraCotizInterna);
        //print_r($infoCabeceraCotizInterna);
        //print_r($carritoCotizacionInterna);
        
        return view("admin.adminCotizacionesInternasEditor",compact('carritoCotizacionInterna','parametros','items','infoCabeceraCotizInterna'));
            
    }
    
    
    

    public function adminCotizacioneInternasBuscar(Request $request ) {
        echo "<br>adminCotizacioneInternasBuscar";
        $codigo = $request->Input('txtCodigo');
        $nombre = $request->Input('txtNombre');
        $ciudad  = $request->Input('txtCiudad');
        $producto =  $request->Input('txtProducto');
        
        echo "<br>Codigo:".$codigo;
        echo "<br>Nombre:".$nombre;
        echo "<br>Ciudad:".$ciudad;
        echo "<br>Producto:".$producto;
        
        
        if( strcmp( $codigo, "") != 0 ) {
            $parametros = DB::table('parametros')->get();
            $items = DB::table('menus')->get();    
            $registros = DB::table('cotizacionesinternas')
                          ->where('codigo',$codigo)
                          ->get();
            return view('admin.adminCotizacionesInternas',compact('registros','parametros','items'));
        }
        
        
        if( strcmp( $nombre, "") != 0 ) {
            $parametros = DB::table('parametros')->get();
            $items = DB::table('menus')->get();    
            $registros = DB::table('cotizacionesinternas')
                          ->where('nombre','like','%'.$nombre.'%')
                          ->get();
            return view('admin.adminCotizacionesInternas',compact('registros','parametros','items'));
        }
        
        
        
        
        if( strcmp( $ciudad, "") != 0 ) {
            $parametros = DB::table('parametros')->get();
            $items = DB::table('menus')->get();    
            $registros = DB::table('cotizacionesinternas')
                          ->where('ciudad',$ciudad)
                          ->get();
            return view('admin.adminCotizacionesInternas',compact('registros','parametros','items'));
        }        
        
        
        if( strcmp( $producto, "") != 0 ) {
        
            $registros  = DB::table('cotizacionesinternas')
            ->leftJoin('cotizacionesinternas_detalle', 'cotizacionesinternas.codigo', '=', 'cotizacionesinternas_detalle.codigo')
            ->where('cotizacionesinternas_detalle.producto','like','%'.$producto.'%')
            ->select('cotizacionesinternas.id','cotizacionesinternas.codigo','cotizacionesinternas.usuario','cotizacionesinternas.rut','cotizacionesinternas.nombre','cotizacionesinternas.fonoContacto','cotizacionesinternas.contacto','cotizacionesinternas.fecha')
            ->distinct()
            ->get();
   
            $parametros = DB::table('parametros')->get();
            $items = DB::table('menus')->get();                        
            return view('admin.adminCotizacionesInternas',compact('registros','parametros','items'));
   
        
        }
        
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();    
        $registros = DB::table('cotizacionesinternas')
                          ->orderBy('fecha','DESC')
                          ->get();
        return view('admin.adminCotizacionesInternas',compact('registros','parametros','items'));

        
    }
    
    
    
    
    public function adminCotizacionesInternasVer($item) {
        $infoCabeceraCotizInterna_ = \DB::table('cotizacionesinternas')->where('codigo',$item)->get();
        $infoCabeceraCotizInterna = ['codigo' => $infoCabeceraCotizInterna_[0]->codigo,
                         'rut' => $infoCabeceraCotizInterna_[0]->rut,
                         'nombre' => $infoCabeceraCotizInterna_[0]->nombre,
                         'contacto' => $infoCabeceraCotizInterna_[0]->contacto,
                         'direccion' => $infoCabeceraCotizInterna_[0]->direccion,
                         'email' => $infoCabeceraCotizInterna_[0]->email,
                         'fonoContacto' => $infoCabeceraCotizInterna_[0]->fonoContacto,
                         'fecha' => $infoCabeceraCotizInterna_[0]->fecha,
                         'validez' => $infoCabeceraCotizInterna_[0]->validez,
                         'observaciones' => $infoCabeceraCotizInterna_[0]->observaciones,
                         'total' => $infoCabeceraCotizInterna_[0]->total
                         ];

        $carritoCotizacionInterna_ = \DB::table('cotizacionesinternas_detalle')->where('codigo',$item)->get();
        $carritoCotizacionInterna = [];
        foreach(  $carritoCotizacionInterna_ as $dato ) {
            //echo "<br>".$dato->codigo.";".$dato->producto.";".$dato->cantidad.";".$dato->precio.";".$dato->subtotal;
            $carritoCotizacionInterna[$dato->id]['id'] = $dato->id;
            $carritoCotizacionInterna[$dato->id]['codigo'] = $dato->codigo;
            $carritoCotizacionInterna[$dato->id]['producto'] = $dato->producto;
            $carritoCotizacionInterna[$dato->id]['cantidad'] = $dato->cantidad;
            $carritoCotizacionInterna[$dato->id]['precio'] = $dato->precio;
            $carritoCotizacionInterna[$dato->id]['subtotal'] = $dato->subtotal;
        }
        



        $CODIGO = $infoCabeceraCotizInterna['codigo'];
        $FECHA  = $infoCabeceraCotizInterna['fecha'];
        $ARCHIVO = "COTIZ-".$CODIGO.".pdf";
        
        $view = \View::make('admin.adminCotizacionesInternasVer',compact('infoCabeceraCotizInterna','carritoCotizacionInterna'));
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream( $ARCHIVO);
        

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
     
     
    /*  
    public function adminCotizacionesAdd($idProducto) {
        echo "<br>Cotizaciones Agregar  ";
        $carritoCotizador = \Session::get('carritoCotizador');
        $producto = DB::table('catalogoProveedores')
                          ->where( 'id',$idProducto)
                          ->get();

        if( empty( $carritoCotizador[$idProducto]['id'] )  ) {
            echo "<br>Agrega Nuevo Item";
            $carritoCotizador[$idProducto]['id'] = $producto[0]->id;
            $carritoCotizador[$idProducto]['proveedor'] = $producto[0]->proveedor;
            $carritoCotizador[$idProducto]['codProducto'] = $producto[0]->codProductoProveedor;
            $carritoCotizador[$idProducto]['producto'] = $producto[0]->producto;
            $carritoCotizador[$idProducto]['cantidad'] = 1;
            $carritoCotizador[$idProducto]['precio'] = $producto[0]->precioVenta;
            $carritoCotizador[$idProducto]['subtotal'] = $producto[0]->precio;
        } else {
            echo "<br>Agrega Unidad Item";
            $cantidad = $carritoCotizador[$idProducto]['cantidad'];
            $cantidad++;
            $precio   = $carritoCotizador[$idProducto]['precio'];
            $subtotal = $cantidad * $precio;
            
            $carritoCotizador[$idProducto]['subtotal'] = $cantidad * $precio;
        }
    
        $total = 0;
        print_r($carritoCotizador );
        
        
        
        foreach ( $carritoCotizador as $dato ) {
            echo "<br>".$dato['producto'];
            //$total += $dato['precio'] * $dato['cantidad'];
        } 

        \Session::put('carritoCotizador-total',$total ); 
        \Session::put('carritoCotizador',$carritoCotizador);
        \Session::put('carritoCotizador-count',count($carritoCotizador));
        
    
        
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        $carritoCotizacion = \Session::get('carritoCotizador');
        $infoCabecera  = \Session::get('infoCabecera');
        
        return view('admin.adminCarritoCotizacionesEditor',compact('carritoCotizacion','parametros','items','infoCabecera'));
    }
    */

    
    public function adminCotizacionesDeleteProducto( $id){
        //echo "<br>Cotiz Delete Producto:";
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
        
        $this->adminCotizacionesSessionToDdbb();
        
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        $subMenu = session()->get('subMenu');
        return view('admin.adminCotizacionesEditor',compact('carritoCotizacion','parametros','items','infoCabecera'));


    }
    
    /*
    public function adminCotizacionesEliminarItem($item) {
        echo "<br>Cotizacion Eliminar item:". $item;
        $carritoCotizador = \Session::get('carritoCotizador');
        $carritoCotizador['codigo'] = "0";
        unset($carritoCotizador[$item]);
        //print_r($carrito);

        \Session::put('carritoCotizador',$carritoCotizador);
        \Session::put('carritoCotizador-count',count($carritoCotizador));
        
        
        $total = 0;
        foreach ( $carritoCotizador as $dato ) {
            $total += $dato['precio'] * $dato['cantidad'];
        } 
        \Session::put('carritoCotizador-total',$total ); 
        
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        $subMenu = session()->get('subMenu');
        return view('admin.adminCotizacionesEditor',compact('carritoCotizador','parametros','items'));
        
        
    }
    */
    
    
    public function adminCotizacionesEditar($item) {
        //echo "<br>adminCotizacionesEditar";
    
        $infoCabecera_ = \DB::table('cotizaciones')->where('codigo',$item)->get();
        $infoCabecera = ['codigo' => $infoCabecera_[0]->codigo,
                         'usuario' => $infoCabecera_[0]->usuario,
                         'rut' => $infoCabecera_[0]->rut,
                         'nombre' => $infoCabecera_[0]->nombre,
                         'contacto' => $infoCabecera_[0]->contacto,
                         'direccion' => $infoCabecera_[0]->direccion,
                         'ciudad' => $infoCabecera_[0]->ciudad,
                         'email' => $infoCabecera_[0]->email,
                         'fonoContacto' => $infoCabecera_[0]->fonoContacto,
                         'fecha' => $infoCabecera_[0]->fecha,
                         'validez' => $infoCabecera_[0]->validez,
                         'observaciones' => $infoCabecera_[0]->observaciones,
                         'total' => $infoCabecera_[0]->total,
                         'iva' => $infoCabecera_[0]->iva,
                         'totalIvaInc' => $infoCabecera_[0]->totalIvaInc
                         ];
        \Session::put('infoCabecera',$infoCabecera);
        $carritoCotizacion_ = \DB::table('cotizaciones_detalle')
                              ->where('codigo',$item)
                              ->orderBy('proveedor')
                              ->orderBy('producto')
                              ->get();
        $carritoCotizacion = [];
        foreach(  $carritoCotizacion_ as $dato ) {
            //echo "<br>".$dato->codigo.";".$dato->producto.";".$dato->cantidad.";".$dato->precio.";".$dato->subtotal;
            $carritoCotizacion[$dato->id]['id'] = $dato->id;
            $carritoCotizacion[$dato->id]['codigo'] = $dato->codigo;
            $carritoCotizacion[$dato->id]['codProductoCatalogo'] = $dato->codProductoCatalogo;
            $carritoCotizacion[$dato->id]['proveedor'] = $dato->proveedor;
            $carritoCotizacion[$dato->id]['producto'] = $dato->producto;
            $carritoCotizacion[$dato->id]['cantidad'] = $dato->cantidad;
            $carritoCotizacion[$dato->id]['precio'] = $dato->precio;
            $carritoCotizacion[$dato->id]['subtotal'] = $dato->subtotal;
        }
        \Session::put('carritoCotizacion',$carritoCotizacion);
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        return view('admin.adminCotizacionesEditor',compact('carritoCotizacion','parametros','items','infoCabecera'));
    }
    
    
    
    public function adminCotizacionesVer($item) {
        $infoCabecera_ = \DB::table('cotizaciones')->where('codigo',$item)->get();
        $infoCabecera = ['codigo' => $infoCabecera_[0]->codigo,
                         'rut' => $infoCabecera_[0]->rut,
                         'nombre' => $infoCabecera_[0]->nombre,
                         'contacto' => $infoCabecera_[0]->contacto,
                         'direccion' => $infoCabecera_[0]->direccion,
                         'email' => $infoCabecera_[0]->email,
                         'fonoContacto' => $infoCabecera_[0]->fonoContacto,
                         'fecha' => $infoCabecera_[0]->fecha,
                         'validez' => $infoCabecera_[0]->validez,
                         'observaciones' => $infoCabecera_[0]->observaciones,
                         'total' => $infoCabecera_[0]->total
                         ];

        $carritoCotizacion_ = \DB::table('cotizaciones_detalle')->where('codigo',$item)->get();
        $carritoCotizacion = [];
        foreach(  $carritoCotizacion_ as $dato ) {
            //echo "<br>".$dato->codigo.";".$dato->producto.";".$dato->cantidad.";".$dato->precio.";".$dato->subtotal;
            $carritoCotizacion[$dato->id]['id'] = $dato->id;
            $carritoCotizacion[$dato->id]['codigo'] = $dato->codigo;
            $carritoCotizacion[$dato->id]['producto'] = $dato->producto;
            $carritoCotizacion[$dato->id]['cantidad'] = $dato->cantidad;
            $carritoCotizacion[$dato->id]['precio'] = $dato->precio;
            $carritoCotizacion[$dato->id]['subtotal'] = $dato->subtotal;
        }
        



        $CODIGO = $infoCabecera['codigo'];
        $FECHA  = $infoCabecera['fecha'];
        $ARCHIVO = "COTIZ-".$CODIGO.".pdf";
        
        $view = \View::make('admin.adminCotizacionesVer',compact('infoCabecera','carritoCotizacion'));
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('cotizacion');
        
        /*
        $pdf = \PDF::loadView('admin.carritoCotizacionVer',compact('infoCabecera','carritoCotizacion'));
         return $pdf->download( $ARCHIVO );
         */

    }
    
    
    public function adminCotizacionesDescargar($item) {
        $infoCabecera_ = \DB::table('cotizaciones')->where('codigo',$item)->get();
        $infoCabecera = ['codigo' => $infoCabecera_[0]->codigo,
                         'rut' => $infoCabecera_[0]->rut,
                         'nombre' => strtoupper($infoCabecera_[0]->nombre),
                         'contacto' => strtoupper($infoCabecera_[0]->contacto),
                         'direccion' => strtoupper($infoCabecera_[0]->direccion),
                         'ciudad' => strtoupper($infoCabecera_[0]->ciudad),
                         'email' => $infoCabecera_[0]->email,
                         'fonoContacto' => $infoCabecera_[0]->fonoContacto,
                         'fecha' => $infoCabecera_[0]->fecha,
                         'validez' => $infoCabecera_[0]->validez,
                         'observaciones' => strtoupper($infoCabecera_[0]->observaciones),
                         'DDMMAAAA' => date('dmY'),
                         'total' => $infoCabecera_[0]->total,
                         'iva' => $infoCabecera_[0]->iva,
                         'totalIvaInc' => $infoCabecera_[0]->totalIvaInc
                         ];
                         
        $carritoCotizacion_ = \DB::table('cotizaciones_detalle')
                              ->where('codigo',$item)
                              ->orderBy('proveedor')
                              ->orderBy('producto')
                              ->get();
                              
        $carritoCotizacion = [];
    
        foreach(  $carritoCotizacion_ as $dato ) {
                //echo "<br>".$dato->codigo.";".$dato->producto.";".$dato->cantidad.";".$dato->precio.";".$dato->subtotal;
                $carritoCotizacion[$dato->id]['id'] = $dato->id;
                $carritoCotizacion[$dato->id]['codigo'] = $dato->codigo;
                $carritoCotizacion[$dato->id]['producto'] = strtoupper($dato->producto);
                $carritoCotizacion[$dato->id]['cantidad'] = $dato->cantidad;
                $carritoCotizacion[$dato->id]['precio'] = $dato->precio;
                $carritoCotizacion[$dato->id]['subtotal'] = $dato->subtotal;
        }
        
      $ddmmaaaa = date('dmY');
      $ARCHIVO = "COTIZACION-".$infoCabecera_[0]->codigo."-".$ddmmaaaa.".pdf";    
      $pdf = \PDF::loadView('admin.pruebaparapdf',compact('infoCabecera','carritoCotizacion'));
      return $pdf->download( $ARCHIVO);
      //echo "<br>Ver  Cotiz:".$item;
       
     /*
        
        $infoCabecera_ = \DB::table('cotizaciones')->where('codigo',$item)->get();
        $infoCabecera = ['codigo' => $infoCabecera_[0]->codigo,
                         'rut' => $infoCabecera_[0]->rut,
                         'nombre' => $infoCabecera_[0]->nombre,
                         'contacto' => $infoCabecera_[0]->contacto,
                         'direccion' => $infoCabecera_[0]->direccion,
                         'email' => $infoCabecera_[0]->email,
                         'fonoContacto' => $infoCabecera_[0]->fonoContacto,
                         'fecha' => $infoCabecera_[0]->fecha,
                         'validez' => $infoCabecera_[0]->validez,
                         'observaciones' => $infoCabecera_[0]->observaciones,
                         'total' => $infoCabecera_[0]->total
                         ];

        $carritoCotizacion_ = \DB::table('cotizaciones_detalle')
                              ->where('codigo',$item)
                              ->get();
                              
        $countFilas = count( $carritoCotizacion_ );
        
        if( $countFilas <= 7 ) {
            $carritoCotizacion = [];
            foreach(  $carritoCotizacion_ as $dato ) {
                //echo "<br>".$dato->codigo.";".$dato->producto.";".$dato->cantidad.";".$dato->precio.";".$dato->subtotal;
                $carritoCotizacion[$dato->id]['id'] = $dato->id;
                $carritoCotizacion[$dato->id]['codigo'] = $dato->codigo;
                $carritoCotizacion[$dato->id]['producto'] = $dato->producto;
                $carritoCotizacion[$dato->id]['cantidad'] = $dato->cantidad;
                $carritoCotizacion[$dato->id]['precio'] = $dato->precio;
                $carritoCotizacion[$dato->id]['subtotal'] = $dato->subtotal;
            }
            
    
    
    
            $CODIGO = $infoCabecera['codigo'];
            $FECHA  = $infoCabecera['fecha'];
            $ARCHIVO = "COTIZ-".$CODIGO.".pdf";
            
            $pdf = \PDF::loadView('admin.adminCotizacionesVer',compact('infoCabecera','carritoCotizacion'));
             return $pdf->download( $ARCHIVO );            
        }
        if( $countFilas > 7) {
            $carritoCotizacion_ = \DB::table('cotizaciones_detalle')
                              ->where('codigo',$item)
                              ->take(7)
                              ->get(); 
            foreach(  $carritoCotizacion_ as $dato ) {
                //echo "<br>".$dato->codigo.";".$dato->producto.";".$dato->cantidad.";".$dato->precio.";".$dato->subtotal;
                $carritoCotizacion[$dato->id]['id'] = $dato->id;
                $carritoCotizacion[$dato->id]['codigo'] = $dato->codigo;
                $carritoCotizacion[$dato->id]['producto'] = $dato->producto;
                $carritoCotizacion[$dato->id]['cantidad'] = $dato->cantidad;
                $carritoCotizacion[$dato->id]['precio'] = $dato->precio;
                $carritoCotizacion[$dato->id]['subtotal'] = $dato->subtotal;
            }
            
    
    
    
            $CODIGO = $infoCabecera['codigo'];
            $FECHA  = $infoCabecera['fecha'];
            $ARCHIVO = "COTIZ-".$CODIGO.".pdf";
            
            $pdf = \PDF::loadView('admin.adminCotizacionesVer',compact('infoCabecera','carritoCotizacion'));
             return $pdf->download( $ARCHIVO );            
            
        }
        */
    
        
    }
    
    
    public function adminCotizacioneSave(Request $request) {
        $codigo    = $request->Input('codigo');
       // echo "<br>Cotiz Save:".$codigo;
        $codigo    = $request->Input('codigo');
        $usuario   = session('usuario');
        $rut       = $request->Input('rut');
        $nombre    = $request->Input('nombre');
        $contacto  = $request->Input('contacto');
        $direccion = $request->Input('direccion');
        $email     = $request->Input('email');
        $validez   = $request->Input('validez');
        $observaciones = $request->Input('observaciones');
        $ciudad    = $request->Input('ciudad');
        $fonoContacto  = $request->Input('fonoContacto');
        $carritoCotizacion = \Session::get('carritoCotizacion');
        $infoCabecera = \Session::get('infoCabecera');
        //$codigo = $infoCabecera['codigo'];
        $now = new \DateTime();
        
        //print_r($infoCabecera);
        //print_r($carritoCotizacion);
        
        
        
        $total = 0;
        foreach( $carritoCotizacion as $dato ) {
               //echo "<br>".$dato['producto'] . " " . $dato['cantidad']. " " . $dato['precio'];
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
                             'direccion'   => $direccion, 
                             'email'      => $email,
                             'contacto'   => $contacto,
                             'ciudad'     => $ciudad,
                             'fonoContacto' => $fonoContacto,
                             'total'        => $total,
                             'iva'        => $total*0.19,
                             'totalIvaInc' => $total*1.19,
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
              $registro->ciudad=$ciudad0;
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
                
                return view("admin.adminCotizacionesEditor",compact('carritoCotizacion','parametros','items','infoCabecera'));
            }
        }    
            
             
        // echo "<bR>Guarda Detalle";
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
                         'ciudad' => $ciudad,
                         'email' => $email,
                         'fonoContacto' => $fonoContacto,
                         'total' => $total,
                         'iva' => $total*0.19,
                         'totalIvaIncl' => $total * 1.19,
                         'validez' => $validez,
                         'fecha' => $now,
                         'observaciones' => $observaciones
                         ];
                        
        $this->adminCotizacionesSessionToDdbb();
        \Session::put('carritoCotizacion',$carritoCotizacion);
        \Session::put('infoCabecera',$infoCabecera);
        return view("admin.adminCotizacionesEditor",compact('carritoCotizacion','parametros','items','infoCabecera'));
            
    }
    
    
    
   
    
    
    
    
    
    public function adminCotizacioneUpdateProducto(Request $request )    {
        echo "<br>Cotiz Update Producto:";
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
    
        //print_r( $infoCabecera);
        
        
        
        \Session::put('infoCabecera',$infoCabecera);        
        //echo "<br>infoCabeceraTotal:".$infoCabecera['total'];
        
        $this->adminCotizacionesSessionToDdbb();
        
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        $subMenu = session()->get('subMenu');
        
        return view('admin.adminCotizacionesEditor',compact('carritoCotizacion','parametros','items','infoCabecera'));
    
    
    }
    
    
    
    
    

    
     public function trash(){
        \Session::forget('carritoCotizador');
        \Session::put('carritoCotizador',array());
        $carritoCotizador = \Session::get('carritoCotizador');
        \Session::put('carritoCotizador-count',count($carritoCotizador));
        //print_r($carrito);
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        return view('cotizador.index',compact('carritoCotizador','parametros','items'));

    }
    
    

    
    
    /*
    public function adminCarritoPedidoActualizaEstado(Request $request ) {
         echo "<br>Cotiz Actualiza Estado:";
         $codigo        = $request->Input('codigo');
         $usuario       = $request->Input('usuario');
         $estado        = $request->Input('estado');
         $observaciones = $request->Input('observaciones');
         
         

         $status = false;
         try {
         $contacto = new CarroSeguimiento;
         $contacto->codigo=$codigo;
         $contacto->usuario=$usuario;
         $contacto->estado=$estado;
         $contacto->observaciones=$observaciones;
         $contacto->save();
         $status = true;
         }catch(Exception $ex ) {
             $status = false;
         }
         
         if( !$status ) {
             \Session::flash('flash-message-warning','Ha ocurrido un problema al actualizar..!!'); 
            $parametros = DB::table('parametros')->get();
            $items = DB::table('menus')->get();
            $registros  = DB::table('carritos')->get();
            return view("admin.adminCarritoPedidos",compact('parametros','items','registros'));
         }
         
         
         $status = false;
         try {
         \DB::table('carritos') 
                 ->where('codigo', $codigo) 
                 ->update( [ 'estado'       => $estado,
                             'updated_at' => date('Y-m-d G:i:s')]);
             $status = true;
        } catch( Exception $ex ) {
             $status = false;
        }
         
        if( !$status ) {
             \Session::flash('flash-message-warning','Ha ocurrido un problema al actualizar..!!'); 
            $parametros = DB::table('parametros')->get();
            $items = DB::table('menus')->get();
            $registros  = DB::table('carritos')->get();
            return view("admin.adminCarritoPedidos",compact('parametros','items','registros'));
         }

             
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        $registros  = DB::table('carritos')->get();
        
        return view('admin.adminCarritoPedidos',compact('registros','parametros','items'));
         
    }
    
    */
    
    
    public function adminCotizacionesAddProductoFromCatalogo( $idProducto){
        echo "<br>Cotiz agrega producto:adminCotizacionesAddProducto from catalogo";
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

        if( empty( $carritoCotizacion[$idProducto]['id'] )  ) {
            $carritoCotizacion[$idProducto]['id'] = $producto[0]->id;
            $carritoCotizacion[$idProducto]['codProductoCatalogo'] = $producto[0]->codProductoProveedor;
            $carritoCotizacion[$idProducto]['proveedor'] = $producto[0]->proveedor;
            $carritoCotizacion[$idProducto]['producto'] = $producto[0]->producto;
            $carritoCotizacion[$idProducto]['cantidad'] = 1;
            $carritoCotizacion[$idProducto]['precio'] = $producto[0]->precioVenta;
            $carritoCotizacion[$idProducto]['subtotal'] = $producto[0]->precio;
        } else {
            $carritoCotizacion[$idProducto]['id'] = $producto[0]->id;
            $carritoCotizacion[$idProducto]['proveedor'] = $producto[0]->proveedor;
            $carritoCotizacion[$idProducto]['codProductoCatalogo'] = $producto[0]->codProductoProveedor;            
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
        $infoCabecera = \Session::get('infoCabecera'); 
        
        
        $this->adminCotizacionesSessionToDdbb();
        
    
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
       // echo "<br>****";
        //print_r( $infoCabecera);
        return view('admin.adminCotizacionesEditor',compact('carritoCotizacion','parametros','items','infoCabecera'));
        
    }
    
    
    public function adminCotizacionesSessionToDdbb(){
        //echo "<br>*****  SESSION TO DDBB";
        $carritoCotizacion = \Session::get('carritoCotizacion');
        $infoCabecera = \Session::get('infoCabecera'); 
        //$infoCabecera = $infoCabecera_[0];
        //echo "<br>Codigo:". $infoCabecera['codigo'];
        $codigo = $infoCabecera['codigo'];
        
        
        /* Elimina Detalle Cotizacion */
        if( DB::table('cotizaciones_detalle')->where('codigo', $codigo)->exists() ) {
             try {
                CotizacionDetalle::where('codigo', $codigo)->delete();
             }catch( Exception $ex) {
                \Session::flash('flash-message-warning','Ocurrio un problema al intentar guardar  ... !!');
                $parametros = DB::table('parametros')->get();
                $items = DB::table('menus')->get();
                
                return view("admin.adminCotizacionesEditor",compact('carritoCotizacion','parametros','items','infoCabecera'));
            }
        }  
        
        
        /* Agrega Nuevo Detalle Cotizacion */
         //echo "<bR>Guarda Detalle";
         try{
          $total = 0;
          foreach( $carritoCotizacion as $dato ) {
             //echo "<br>codProdcutoCatalogo:".$dato['codProductoCatalogo']; 
             $total += $dato['cantidad']*$dato['precio'];
             $registro = new CotizacionDetalle;
             $registro->codigo=$codigo;
             $registro->codProductoCatalogo=$dato['codProductoCatalogo'];
             $registro->proveedor=$dato['proveedor'];
             $registro->producto=$dato['producto'];
             $registro->cantidad=$dato['cantidad'];
             $registro->precio=$dato['precio'];
             $registro->subtotal=$dato['cantidad'] * $dato['precio'];
             $registro->save();  
          }
          
           \DB::table('cotizaciones') 
                 ->where('codigo', $codigo) 
                 ->update( [ 'total'  => $total,
                             'iva'       => $total*.19,
                             'totalIvaInc' => $total *1.19,
                             'updated_at' => date('Y-m-d G:i:s')]);
          
          
        } catch( Exception $ex) {
            \Session::flash('flash-message-warning','Ocurrio un problema al intentar guardar  ... !!');
            $parametros = DB::table('parametros')->get();
            $items = DB::table('menus')->get();
            
            return view("admin.adminCotizacionesEditor",compact('carritoCotizacion','parametros','items','infoCabecera'));
        }
        
    }
    
    
    
    
    
     public function adminCotizacionesInternasSessionToDdbb(){
        //echo "<br>*****  SESSION TO DDBB";
        $carritoCotizacionInterna = \Session::get('carritoCotizacionInterna');
        $infoCabeceraCotizInterna = \Session::get('infoCabeceraCotizInterna'); 
        //$infoCabecera = $infoCabecera_[0];
        //echo "<br>Codigo:". $infoCabecera['codigo'];
        $codigo = $infoCabeceraCotizInterna['codigo'];
        
        
        /* Elimina Detalle Cotizacion */
        if( DB::table('cotizacionesinternas_detalle')->where('codigo', $codigo)->exists() ) {
             try {
                CotizacioninternaDetalle::where('codigo', $codigo)->delete();
             }catch( Exception $ex) {
                \Session::flash('flash-message-warning','Ocurrio un problema al intentar guardar  ... !!');
                $parametros = DB::table('parametros')->get();
                $items = DB::table('menus')->get();
                
                return view("admin.adminCotizacionesInternasEditor",compact('carritoCotizacion','parametros','items','infoCabecera'));
            }
        }  
        
        
        /* Agrega Nuevo Detalle Cotizacion */
         //echo "<bR>Guarda Detalle";
         try{
          foreach( $carritoCotizacionInterna as $dato ) {
             //echo "<br>codProdcutoCatalogo:".$dato['codProductoCatalogo']; 
             $registro = new CotizacioninternaDetalle;
             $registro->codigo=$codigo;
             $registro->codProductoCatalogo=$dato['codProductoCatalogo'];
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
            
            return view("admin.adminCotizacionesInternasEditor",compact('carritoCotizacionInterna','parametros','items','infoCabeceraCotizInterna'));
        }
        
    }
    
    
    
    
    
    
    
    /**
     *  PEDIDOS
    */
    public function adminCarritoPedidosListar(){
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        $registros  = DB::table('carritos')->orderBy('created_at', 'desc')->get();
        
        return view('admin.adminCarritoPedidos',compact('registros','parametros','items'));
    }
    
    
    public function adminCarritoPedidosDescargar($item) {
       //echo "<br>Ver  P3EDIDOS:".$item;
        
        $pdf = new PDF();
        
        
    
        $infoCabecera_ = \DB::table('carritos')->where('codigo',$item)->get();
        $infoCabecera = ['codigo' => $infoCabecera_[0]->codigo,
                         'nombre' => $infoCabecera_[0]->nombreUsuario,
                         'email' => $infoCabecera_[0]->email,
                         'fonoContacto' => $infoCabecera_[0]->fonoContacto,
                         'fecha' => $infoCabecera_[0]->fecha,
                         'estado' => $infoCabecera_[0]->estado,
                         'observaciones' => $infoCabecera_[0]->observaciones,
                         'total' => $infoCabecera_[0]->total
                         ];

        $carritoCotizacion_ = \DB::table('carritos_detalle')->where('codigo',$item)->get();
        $carritoCotizacion = [];
        foreach(  $carritoCotizacion_ as $dato ) {
            //echo "<br>".$dato->codigo.";".$dato->producto.";".$dato->cantidad.";".$dato->precio.";".$dato->subtotal;
            $carritoCotizacion[$dato->id]['id'] = $dato->id;
            $carritoCotizacion[$dato->id]['codigo'] = $dato->codigo;
            $carritoCotizacion[$dato->id]['producto'] = $dato->producto;
            $carritoCotizacion[$dato->id]['cantidad'] = $dato->cantidad;
            $carritoCotizacion[$dato->id]['precio'] = $dato->precio;
            $carritoCotizacion[$dato->id]['subtotal'] = $dato->subtotal;
        }
        


        //print_r($infoCabecera);
        
        $CODIGO = $infoCabecera['codigo'];
        $FECHA  = $infoCabecera['fecha'];
        $ARCHIVO = "PEDIDO-".$CODIGO.".pdf";
        
        $pdf = \PDF::loadView('admin.carritoPedidoDescargar',compact('infoCabecera','carritoCotizacion'));
        return $pdf->download( $ARCHIVO );
        
    }
    
    
    public function adminCarritoPedidoEliminar($codigo) {
        try{
              DB::table('carritos_detalle') 
                   ->where('codigo', $codigo) 
                   ->delete();
          } catch( Exception $ex) {
              echo "Error";
          }          
          
        try{
              DB::table('carritos') 
                   ->where('codigo', $codigo) 
                   ->delete();
          } catch( Exception $ex) {
              echo "Error";
          }        
          
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        $registros  = DB::table('carritos')->get();
        
        return view('admin.adminCarritoPedidos',compact('registros','parametros','items'));
        
    }
    
    
    public function adminCarritoPedidoEditar($codigo) {
        //echo "<br>Editar:". $codigo;
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();

         

        $cabecera = DB::table('carritos')
                      ->where('codigo',$codigo)
                      ->get();
                              
        //print_r($cabecera[0]);
        
        
        $infoCabecera = ['codigo' => $cabecera[0]->codigo,
                         'nombre' => $cabecera[0]->nombreUsuario,
                         'email' => $cabecera[0]->email,
                         'fonoContacto' => $cabecera[0]->fonoContacto,
                         'fecha' => $cabecera[0]->fecha,
                         'estado' => $cabecera[0]->estado,
                         'observaciones' => $cabecera[0]->observaciones
                        ];

        $carritoCotizacion = DB::table('carritos_detalle')
                      ->where('codigo',$codigo)
                      ->get();
        
        $carritoSeguimiento = DB::table('carritos_seguimiento')
                      ->where('codigo',$codigo)
                      ->get();
        
        return view('admin.adminCarritoPedidosEditar',compact('infoCabecera','carritoCotizacion','carritoSeguimiento','parametros','items'));
        
        
    }
    
    
    public function adminContactosListar(){
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')->get();
        $registros = DB::table('contactos')
                        ->orderBy('created_at', 'desc')
                        ->get();
        return view('admin.adminContactos',compact('registros','parametros','items'));
    }
}
