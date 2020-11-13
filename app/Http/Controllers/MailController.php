<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Mail;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MailController extends Controller {


   public function enviar(Request $request ) {
      echo "Enviar";
      //mail("cssantam@gmail.com","Correo de Contacto","Contacto desde Portal....");
       //echo "<br>Notificar al usuario";
   
        Mail::send("contacto.contact",$request->all(),function( $msg ) {
            $msg->subject("Correo de Contacto");
            $msg->to("cssantam@gmail.com");
        });
        echo "<br>Notificar al usuario";

   }



   public function basic_email() {
      $data = array('name'=>"Carlos Santa");
   
      Mail::send(['text'=>'mail'], $data, function($message) {
         $message->to('cssantam@gmail.com', 'Carlos Santa Receptor')->subject
            ('Laravel Basic Testing Mail');
         $message->from('cssantam@gmail.com','Carlos Santa Enviador');
      });
      echo "Basic Email Sent. Check your inbox.";
   }
   public function html_email() {
      $data = array('name'=>"Carlos Santa Gandhi");
      Mail::send('mail', $data, function($message) {
         $message->to('cssantam@gmail.com', 'Carlos Santa Receptor')->subject
            ('Laravel HTML Testing Mail');
         $message->from('cssantam@gmail.com','Carlos Santa Enviador');
      });
      echo "HTML Email Sent. Check your inbox.";
   }
   public function attachment_email() {
      $data = array('name'=>"Virat Gandhi");
      Mail::send('mail', $data, function($message) {
         $message->to('abc@gmail.com', 'Tutorials Point')->subject
            ('Laravel Testing Mail with Attachment');
         $message->attach('C:\laravel-master\laravel\public\uploads\image.png');
         $message->attach('C:\laravel-master\laravel\public\uploads\test.txt');
         $message->from('xyz@gmail.com','Virat Gandhi');
      });
      echo "Email Sent with attachment. Check your inbox.";
   }
}