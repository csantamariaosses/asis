<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//use Mail;

use PHPMailer\PHPMailer;
use App\Contacto;


class contactoController extends Controller
{
    public function index(){
        //$parametros = Parametro::all();	

        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')
                    ->orderBy('subMenu')
                    ->get();
        return view("contacto.index",compact('parametros','items'));

    }

    
    public function enviar(Request $request){

        /* Datos Contacto */
        $nombreCtto = $request->input("name");
        $emailCtto = $request->input("email");
        $telefonoCtto = $request->input("telefono");
        $messageCtto = $request->input("message");
        
        if(strcmp($telefonoCtto,"") == 0 ) {
            $telefonoCtto = "";
        }

        
        
        // Inserta contacto en tabla contactos
        $contacto = new Contacto;
        $contacto->nombre=$nombreCtto;
        $contacto->email=$emailCtto;
        $contacto->fonoContacto=$telefonoCtto;
        $contacto->comentarios=$messageCtto;
        $contacto->save();
        
        // Parametros internos
        $parametros = DB::table('parametros')->get();
        $emailEmpresa = $parametros[0]->email;
        $nombreEmpresa = $parametros[0]->nombre;
        $hostMail = $parametros[0]->hostMail;
        $hostMailUser = $parametros[0]->hostMailUser;
        $hostMailPass = $parametros[0]->hostMailPass;
        $hostMailPuerto = $parametros[0]->hostMailPuerto;


        // Prepara email
        $emailCC = "cssantam@gmail.com";
        $cc2 = "";
        $subject = "Contacto desde Portal Asis SpA";
      
        $body = "<!doctype html>";
        $body .= "<html>";
        $body .= "<body>";
        $body .= "<div><img src='http://deportesasis.cl/asis/storage/logo_asis_transp.png' width='150' height='150'></div>";
        $body .= "<div><h4>Contacto desde portal Asis SpA</h4></div>";
        $body .= "<div><table>";
        $body .= "<tr><td>Nombre</td><td>".$nombreCtto."</td></tr>";
        $body .= "<tr><td>Email</td><td>".$emailCtto."</td></tr>";
        $body .= "<tr><td>Fono Contacto</td><td>".$telefonoCtto."</td></tr>";
        $body .= "<tr><td>Message</td><td>".$messageCtto."</td></tr>";
        $body .= "</table></div>";
        $body .= "<p>Atte.</py>";
        $body .= "<div><img src='http://deportesasis.cl/asis/storage/logo_asis_transp.png' width='50' height='70'></div>";
        $body .= "</body>";
        $body .= "</html>";

        if( enviarEmail( $subject, $emailEmpresa, $emailCC, $body)) {
            $parametros = DB::table('parametros')->get();
            $items = DB::table('menus')
                         ->orderBy('subMenu')
                         ->get();
            return view('contacto.emailEnviadoOk',compact('parametros','items'));
        } else {
            $parametros = DB::table('parametros')->get();
            $items = DB::table('menus')
                         ->orderBy('subMenu')
                         ->get();
            return view("contacto.emailEnviadoNoOk",compact('parametros','items'));
        }
        
        /*
        // Inserta contacto en tabla contactos
        $contacto = new Contacto;
        $contacto->nombre=$nombre;
        $contacto->email=$email;
        $contacto->fonoContacto=$telefono;
        $contacto->comentarios=$message;
        $contacto->save();


        // Envia email
        $mail             = new PHPMailer\PHPMailer(); // create a n
        $mail->SMTPDebug  = 1; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth   = true; // authentication enabled
        $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail

        $mail->Host       = $hostMail;
        $mail->Port       = $hostMailPuerto; // or 465 587
        $mail->IsHTML(true);
        $mail->Username = $hostMailUser;
        $mail->Password = $hostMailPass;

        $mail->SetFrom( $fromEmail, $fromNombre );
        $mail->Subject = $subject;
        $mail->Body    = $msg;
        $mail->AddAddress($email, $nombre);
        if ($mail->Send()) {
            //return 'Email Sended Successfully';
            $parametros = DB::table('parametros')->get();
            $items = DB::table('menus')->get();
            return view("contacto.emailEnviadoOk",compact('parametros','items'));
        } else {
            $parametros = DB::table('parametros')->get();
            $items = DB::table('menus')->get();
            return view("contacto.emailEnviadoNoOk",compact('parametros','items'));
        }
        */

    }

}



