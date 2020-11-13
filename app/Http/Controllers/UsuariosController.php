<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Usuario;
use PHPMailer\PHPMailer;
use App\Session;
use Illuminate\Support\Facades\Mail;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //echo "usuariosController.index";
        $email_ = \Session()->get('email');
        if( isset( $email_ ) ) {
                $usuario = DB::table('usuarios')
                        ->where('email', $email_)
                        ->get();
                $infoUser = $usuario[0];
               
                $parametros = DB::table('parametros')->get();
                $items = DB::table('menus')
                           ->orderBy('subMenu')
                           ->get();
                return view("usuarios.wellcome",compact('parametros','items','infoUser'));        
                
                
        } else {
           $parametros = DB::table('parametros')->get();
           $items = DB::table('menus')
                      ->orderBy('subMenu')
                      ->get();
           return view("usuarios.index",compact('parametros','items'));            
        }

    }


    public function acceso(Request $request)
    {
        //
        //echo "usuariosController.acceso";
        $emailAcc = $request->input("emailAcc");
        $passwordAcc = $request->input("passwordAcc");
        $pass = md5($passwordAcc);

        $registro = DB::table('usuarios')
                    //->select('email')
                    ->where('email',$emailAcc)
                    ->where('password',$pass)
                    ->get();

        //echo "<br>count". count($registro) ;
        if( count( $registro ) > 0 ) {
            $registro = DB::table('usuarios')
                    //->select('email')
                    ->where('email',$emailAcc)
                    ->where('estado','confirmado')
                    ->get();
            if( count( $registro ) > 0 ) {
                $email = $registro[0]->email;
                $nombre = $registro[0]->nombre;
                $fonoContacto = $registro[0]->fonoContacto;
                $tipo = $registro[0]->tipo;
                echo "<script> console.log('Tipo".$tipo."');</script>";
                //echo "tipo:" + $tipo;
                
                $request->session()->put('usuario',$nombre);
                $request->session()->put('email',$email);
                $request->session()->put('nombre',$nombre);
                $request->session()->put('fonoContacto',$fonoContacto);
                $request->session()->put('tipo',$tipo);
                
                //mail("cssantam@gmail.com","tipo:"+ strval( $tipo) );
                //session()->put('tipo',$tipo);
                if( strcmp($tipo,'admin')==0){
                    $admin = true;
                }
                //echo "<br>tipo:" . $tipo;
                //$usr = $request->session()->get('usuario',$email);
                //echo "<br>usr:".$usr;
                $usuario = DB::table('usuarios')
                        ->where('email', $email)
                        ->get();
                $infoUser = $usuario[0];
                $parametros = DB::table('parametros')->get();  
                $items = DB::table('menus')
                             ->orderBy('subMenu')
                             ->get();
                return view("usuarios.wellcome",compact('parametros','items','email','tipo','infoUser'));
            } else {
                $parametros = DB::table('parametros')->get();  
                $items = DB::table('menus')
                             ->orderBy('subMenu')
                             ->get();
                return redirect('usuarios')->with('alert-warning','Su Registro no ha sido confirmado, favor revisar su email para completar su registro.'); 
    
            }
        } else {
            $parametros = DB::table('parametros')->get();  
            $items = DB::table('menus')
                         ->orderBy('subMenu')
                         ->get();
            return redirect('usuarios')->with('alert-warning','Usuario - Password no corresponden. Favor reintentar.'); 

        }
    
      
    }


    public function salir(Request $request){
        //$request->session()->flush();
        $nombre = \Session::get('usuario');
        \Session::forget('usuario');
        \Session::forget('email');
        \Session::forget('nombre');
        \Session::forget('fonoContacto');
        \Session::forget('tipo');
        \Session::forget('carritoCotizacion');
        \Session::forget('carritoCotizacionInterna');
        
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')
                     ->orderBy('subMenu')
                     ->get();
        return view("usuarios.usuariosSalidaCofirmada",compact('parametros','items','nombre'));
    }


    public function registro( Request $request )
    {
        //
       
        //$parametros = DB::table('parametros')->get();
        // echo "usuariosController.registro";
        $nombreRegis   = $request->input("nombreRegis");
        $emailRegis    = $request->input("emailRegis");
        $fonoContacto  = $request->input("fonoContacto");
        $passwordRegis = $request->input("passwordRegis");

        //echo "<br>nombreRegis:" . $nombreRegis;
        //echo "<br>emailRegis:" . $emailRegis;
        //echo "<br>passwordRegis:" . $passwordRegis;

        // VERIF USUARIO
        $usrExist = DB::table('usuarios')
                    ->where('email', $emailRegis)
                    ->get();
                  
        if( count( $usrExist ) > 0 ) {
           \Session::flash('flash-message-warning','Usuario ya existe, verifique su email .. !!'); 
            $parametros = DB::table('parametros')->get();
            $items = DB::table('menus')
                        ->orderBy('subMenu')
                        ->get(); 
            return view('usuarios.index',compact('parametros','items'));
        } else {
            $token = md5(uniqid(rand(), true));
            $usuario = new Usuario;
            $usuario->nombre = $nombreRegis;
            $usuario->email = $emailRegis;
            $usuario->fonoContacto = $fonoContacto;
            $usuario->password = md5($passwordRegis);
            $usuario->token  =  $token;
            $usuario->tipo = "usuario";
            $usuario->estado = "pendiente";
            if( $usuario->save() ) {
                //$request->session()->flash('alert-success', 'Usuario fue agregado en forma exitosa..!'); 
                $data['email'] = $emailRegis;
                $data['nombre'] = $nombreRegis;
                $data['token'] = $token;
                /*
                Mail::send('usuarios.confirmacion',$data, function($message) use ($data) {
                    $message->to($data['email'],$data['nombre'])->subject('Por favor confirmae email')
                });
                

               //$data = array('name'=>"Carlos Santa Gandhi");
            
               Mail::send('usuarios.confirmacion', $data, function($message) use ($data) {
                     $message->to($data['email'], $data['nombre'])
                             ->subject('Por favor confirmae email')
                             ->from('contacto@deportesasis.cl','Asis SpA');
               });
                */

                
                
                $subject = "Asis SpA - Verificacion de email";
                $emailDestino = $emailRegis;
                $body = "<!doctype html>";
                $body .= "<html>";
                /*$body .= "<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><title>Asis</title></head>";*/
                $body .= "<body>";
                $body .= "<div align='center'><img src='http://deportesasis.cl/asis/storage/logo_asis_transp.png' width='200' height='180'></div>";
                $body .= "<div align='center'><h4>Bienvenido  a Asis SpA</h4></div>";
                $body .= "<div align='center'>Usted ha ingresado una solicitud de registro en nuestro portal. Por favor confirmar su correo haciendo click en el siguiente link para porder completar su registro:  <a href='http://deportesasis.cl/asis/usuarios/confirma?user=".urlencode($emailRegis)."&token=".$token."'>Confirmar</a><br><br>Atte.<br> Asis SpA.</div>";
                $body .= "</body>";
                $body .= "</html>";



                if( enviarEmail($subject, $emailDestino, "cssantam@gmail.com",$body) ) {
                    $parametros = DB::table('parametros')->get();
                    $items = DB::table('menus')
                                 ->orderBy('subMenu')
                                 ->get();
                    return view('usuarios.usuarioConfirmaEmail',compact('parametros','items','emailRegis'));
                } else {
                    $msg = "Ocurrio un problema al tratar de enviar email de solicitud de registro del cliente:" .$nombreRegis. " email:". $emailRegis. " fonoCtto:" .$fonoContacto;
                    mail("cssantam@gmail.com","Deportes Asis... ocurrio un problema ...", $msg);
                    
                }
                

            } else {
                return redirect('usuarios')->with('alert-warning','Ocurrio un problema al intentar agregar usuario.'); 
            }
        }

        
    }


    public function olvidoPassword() {
        //echo "<br>Olvido Password";
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')
                     ->orderBy('subMenu')
                     ->get();
        return view('usuarios.olvidoPassword',compact('parametros','items'));
    }


    public function olvidoPasswordEnvioCorreo(Request $request){
        //echo "<br>Envio Correo a Usuario";
        $email  = $request->input("emailResetPass");
        $token = md5(uniqid(rand(), true));
        //echo "<br>token:" . $token;
        
        $user = new Usuario();
        $user = Usuario::where('email',$email)->first();
        $user->token = $token;
        $user->save();

        
        $status = $this->enviaCorreo($email, $token);
        $subject = "Contacto Reseteo de Password";
        $emailDestino =  $email;
        $body = "<!doctype html>";
                $body .= "<html>";
                $body .= "<body>";
                $body .= "<div align='center'><img src='http://deportesasis.cl/asis/storage/logo_asis_transp.png' width='200' height='180'></div>";
                $body .= "<div align='center'><h4>Bienvenido  a Asis SpA</h4></div>";
                $body .= "<div align='center'>A traves de este enlace puede resetear su password.<br><a href='http://deportesasis.cl/asis/usuarios/nuevaPassword?token=".$token."'>Enlace</a>";
                $body .= "<br><br>Atte.<br> Asis SpA.</div>";
                $body .= "</body>";
                $body .= "</html>";
                
        
        
        if( enviarEmail($subject, $emailDestino, "cssantam@gmail.com", $body ) ) {
             \Session::flash('flash-message-success','Se ha enviado correo para el reseteo de su password ... !!'); 
             $parametros = DB::table('parametros')->get();
             $items = DB::table('menus')
                          ->orderBy('subMenu')
                          ->get();
             return view('usuarios/olvidoPassword', compact('parametros','items'));
        } else {
             \Session::flash('flash-message-warning','Ocurrio un problema al intentar enviar correo ... !!'); 
             $parametros = DB::table('parametros')->get();
             $items = DB::table('menus')
                          ->orderBy('subMenu')
                          ->get();             
             return view('usuarios/olvidoPassword', compact('parametros','items'));
        }
        
    }


    public function nuevaPassword(Request $request){
       // echo "<br>reset Password";
        $token  = $request->input("token");
       // echo "<br>Token:".$token;

        $user = new Usuario();
        $user = Usuario::where('token',$token)->first();
        //dd( $user);
         \Session::forget('flash-message-success');
        if( !is_null( $user ) ) {
            //echo "<br>user:".$user->email;
            $parametros = DB::table('parametros')->get();
            $items = DB::table('menus')
                        ->orderBy('subMenu')
                        ->get();
            $email = $user->email;
            //echo "<br>email:".$email;

            return view('usuarios.nuevaPassword',compact('parametros','email','token','items'));
        } else {

            \Session::flash('flash-message-warning','Esta pagina ha expirado ... !!'); 
            $parametros = DB::table('parametros')->get();
            $items = DB::table('menus')
                         ->orderBy('subMenu')
                         ->get();
            return view('usuarios.expirado',compact('parametros','items'));
        }
        


    }


    public function updateNuevaPassword(Request $request ){
        //echo "<br>UpdateNuevaPass";
        //echo "<br>NuevaPass:".$request->input("nuevaPassword");

        $token = $request->input("token");
        $email = $request->input("user");
        $nuevaPass = $request->input("nuevaPassword");
        $nuevaRePass = $request->input("nuevaRePassword");
        if( strcmp($nuevaPass, $nuevaRePass) != 0) {
            \Session::flash('flash-message-warning','Las password deben coincidir ... !!'); 
            $parametros = DB::table('parametros')->get();
            $items = DB::table('menus')
                         ->orderBy('subMenu')
                         ->get();
            //echo "<br>Aqui";
            return view('usuarios.nuevaPassword',compact('parametros','items','email','token'));
        } else {
            try {
                \DB::table('usuarios') 
                 ->where('token', $token) 
                 ->update( [ 'password' => md5($nuevaPass),
                             'token' => '',
                             'updated_at' => date('Y-m-d G:i:s')]);
            } catch( Exception $ex ) {
                \Session::flash('flash-message-warning','Ocurrio un problema al actualizar password ... favor reintentar ... !!'); 
                $parametros = DB::table('parametros')->get();
                $items = DB::table('menus')
                             ->orderBy('subMenu')
                             ->get();
                return view('usuarios.olvidoPassword',compact('parametros','items'));

            }

            \Session::flash('flash-message-success','Password cambiada en forma exitosa ... !!'); 
            $parametros = DB::table('parametros')->get();
            $items = DB::table('menus')
                         ->orderBy('subMenu')
                         ->get();
            return view('usuarios.index',compact('parametros','items'));

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
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')
                     ->orderBy('subMenu')
                     ->get();
        return view("usuarios.index",compact('parametros','items'));
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


    protected function enviaCorreo($email, $token){

        $subject = "Contacto Reseteo de Password";
        $msg = "Contacto Reseteo de Password";
        $msg = "<br><br>Contacto desde portal Asis<br><br>";
        $msg .= "A traves de este enlace puede resetear su password<br>";
        $msg .= "<a href='http://deportesasis.cl/asis/usuarios/nuevaPassword?token=".$token."'>Enlace</a>";
        $msg .= "<br><br>Atte.<br>";
        $msg .= "Portal Asis.";
        
        //echo $msg;

        $mail             = new PHPMailer\PHPMailer(); // create a n
        $mail->SMTPDebug  = 1; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth   = true; // authentication enabled
        $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail

        $mail->Host       = "mail.deportesasis.cl";
        $mail->Port       = 465; // or 587
        $mail->IsHTML(true);
        $mail->Username = "contacto@deportesasis.cl";
        $mail->Password = "deportesAsis2019";

        $mail->SetFrom("contacto@deportesasis.cl", 'Reseteo Password');
        $mail->Subject = $subject;
        $mail->Body    = $msg;
        $mail->AddAddress("cssantam@gmail.com", "Carlos Santa");
        if ($mail->Send()) {
            return true;
        } else {
            return false;
        }
    }
    
    
    /*
    public function enviarEmail(String $subject, String $emailDestino, String $body) {
        
        $mail             = new PHPMailer\PHPMailer(); // create a n
        $mail->SMTPDebug  = 1; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth   = true; // authentication enabled
        $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail

        $mail->Host       = "mail.deportesasis.cl";
        $mail->Port       = 465; // or 587
        $mail->IsHTML(true);
        $mail->Username = "contacto@deportesasis.cl";
        $mail->Password = "deportesAsis2019";

        $mail->SetFrom("contacto@deportesasis.cl");
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->AddAddress($emailDestino, "Carlos Santa");
        $mail->AddEmbeddedImage("http://deportesasis.cl/asis/storage/logo_asis_transp.png",'logo');
        if ($mail->Send()) {
            return true;
        } else {
            return false;
        }
        
    }
*/

    public function modificaDatosUsuarios( $id){
        //echo "<br>Modifica Datos Usuario:".$id;
        \Session::forget('flash-message-success'); 

        $usuario    = DB::table('usuarios')
                    ->where('id', $id)
                    ->get();
        $infoUser = $usuario[0];
        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')
                     ->orderBy('subMenu')
                     ->get();
        return view('usuarios.usuarioModificaDatos',compact('parametros','items','infoUser'));

    }



    public function updateInfo(Request $request){
        $id  = $request->input("id");
        $rut  = $request->input("rut");
        $nombre  = $request->input("nombre");
        $email  = $request->input("email");
        $fonoContacto  = $request->input("fonoContacto");
        $password  = $request->input("password");
        
        // Actualiza con cambio de pass
        if( strlen($password) > 0 ) {
            
            $password = md5( $password );
            $status = false;
            try {
                \DB::table('usuarios') 
                   ->where('id', $id) 
                   ->update( [ 'nombre' => $nombre,
                               'email' => $email,
                               'password' => $password,
                               'fonoContacto' => $fonoContacto, 
                               'rut' => $rut,
                               'updated_at' => date('Y-m-d G:i:s')]);
                \Session::put('nombre',$nombre);
                \Session::put('email',$email);
                \Session::put('fonoContacto',$fonoContacto);
                //\Session::put('tipo',$tipo);

                $status = true;
            } catch( Exception $ex ) {
                $status = false;
            }
            
        } else {
            
            // Actualiza sin cambio de pass
            try {
                \DB::table('usuarios') 
                 ->where('id', $id) 
                 ->update( [ 'nombre' => $nombre,
                             'email' => $email,
                             'fonoContacto' => $fonoContacto, 
                             'rut' => $rut,
                             'updated_at' => date('Y-m-d G:i:s')]);
                             
                \Session::put('nombre',$nombre);
                \Session::put('email',$email);
                \Session::put('fonoContacto',$fonoContacto);
                //\Session::put('tipo',$tipo);
                $status = true;
            } catch( Exception $ex ) {
               $status = false;
            }
        }
        
        if( $status ) {
          $usuario = DB::table('usuarios')
                      ->where('id','=',$id)
                      ->get();
          $infoUser = $usuario[0];
          
          \Session::flash('flash-message-success','Usuario actualizado .. !!'); 
          $parametros = DB::table('parametros')->get();
          $items = DB::table('menus')
                           ->orderBy('subMenu')
                           ->get();
         
          return view('usuarios/wellcome',compact('parametros','items','infoUser'));  
        }

    }


    public function confirmaEmail(Request $request){
        $email  = $request->Input('user');
        $token  = $request->Input('token');


        $usuario = DB::table('usuarios')
                      ->where('email',$email)
                      ->where('token',$token)
                      ->get();

        if( count( $usuario ) > 0 ) {
            \DB::table('usuarios') 
                 ->where('email', $email) ->where('token',$token)
                 ->where('email', $email) 
                 ->update( [ 'estado' => 'confirmado',
                             'updated_at' => date('Y-m-d G:i:s')
                           ]);
                           
            // Se envia email de confirmacion               
            $subject = "Asis SpA - Confirmacion de email";
            $emailDestino = $email;
            $body = "<!doctype html>";
            $body .= "<html>";
            /*$body .= "<head><title>Asis</title></head>";*/
            $body .= "<body>";
            $body .= "<div align='center'><img src='http://deportesasis.cl/asis/storage/logo_asis_transp.png' width='200' height='180'></div>";
            $body .= "<div align='center'><h4>Bienvenido  a Asis SpA</h4></div>";
            
            $body .= "<div align='center'>";
            $body .= "Estimado usuario su email ha sido confirmado en forma exitosa. Le invitamos a visitar nuestro portal<br><br>";
            $body .= "Atte<br><br>Asis SpA.";
            $body .= "</body>";
            $body .= "</html>";                           

            if( enviarEmail($subject, $emailDestino, "cssantam@gmail.com", $body) ) {
                // Se muestra vista de Confirmacion
                $parametros = DB::table('parametros')->get();
                $items = DB::table('menus')->get();
                $nombre = $usuario[0]->nombre;
                return view('usuarios.usuarioEmailConfirmado',compact('parametros','items','nombre'));
            }

        } else {
            echo "<br>Email No-Ok";
        }


    }


    public function emailConfirmado(){

    }
}

