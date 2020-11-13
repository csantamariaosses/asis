<?php
use PHPMailer\PHPMailer;
use Illuminate\Support\Facades\DB;


function enviarEmail(String $subject, String $emailDestino, String $emailCC, String $body ){

        //return "<br>EnviarEmail";
    
        $parametros = DB::table('parametros')->get();
        $fromEmail = $parametros[0]->email;
        $fromNombre = $parametros[0]->nombre;
        $hostMail = $parametros[0]->hostMail;
        $hostMailUser = $parametros[0]->hostMailUser;
        $hostMailPass = $parametros[0]->hostMailPass;
        $hostMailPuerto = $parametros[0]->hostMailPuerto;

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
        $mail->Body    = $body;
        $mail->AddAddress( $emailDestino);
        $mail->AddAddress( $emailCC );
        if ($mail->Send()) {
            return true;
        } else {
            return false;
        }
    

}


function test(){
    echo"<br>Test";
}


 function productoYaExiste($idProducto){
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