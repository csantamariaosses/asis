@extends('layout.layout')

@section('title', 'Deportes Asis')

@section('header')
    <p>Este es el header</p>
@endsection

@section('content')
  <div class="container">
    <div class="row">
         <div class="col-sm-12">
          @if(session()->has('alert-success')) 
             <div class="alert alert-success">
               {{ session()->get('alert-success') }} 
             </div>
          @endif 
           @if(session()->has('alert-warning')) 
             <div class="alert alert-warning">
               {{ session()->get('alert-warning') }} 
             </div>
          @endif 
           @if(session()->has('flash-message-success')) 
             <div class="alert alert-success">
               {{ session()->get('flash-message-success') }} 
             </div>
          @endif 
          @if(session()->has('flash-message-warning')) 
             <div class="alert alert-warning">
               {{ session()->get('flash-message-warning') }} 
             </div>
          @endif 
          
         </div>
    </div>  
    <div class="row">
            <div class="col-sm-6">
                <div class="well well-sm">
                 Acceder
                 <form name="frmAcceso" id="frmAcceso" action="{{ action('UsuariosController@acceso') }}" method="POST">
                  {{ csrf_field() }}
                     <input type="hidden" name="accion" id="accion" value="acceso">
                     <div class="form-group"> <!-- Correo Usuario -->
                       <label for="usuario" class="control-label">Correo electronico</label>
                       <input type="text" class="form-control" id="emailAcc" name="emailAcc" placeholder="Usuario o correo electronico" required>
                     </div>    
                     <div class="form-group"> <!-- Pass -->
                       <label for="passwordAcc" class="control-label">Contrase&nacute;a</label>        <a href="{{ action('UsuariosController@olvidoPassword') }}"><span align="right">Olvido de contrase&nacute;a?</span></a>
                       <input type="password" class="form-control" id="passwordAcc" name="passwordAcc" placeholder="Contrase&nacute;a" required>
                     </div>    
                     <div class="form-group"> <!-- Submit Button -->
                         <button type="submit" class="btn btn-primary">Acceder</button>
                    </div>   
                 </form>
                 </div>
            </div>
            <div class="col-sm-6">
                 <div class="well well-sm">
                 Registrarse 
                 <form name="frmRegistro" id="frmRegistro" action="{{ action('UsuariosController@registro') }}" method="POST">
                  {{ csrf_field() }}
                     <input type="hidden" name="accion" id="accion" value="registro">
                       <div class="form-group"> <!-- Nombre -->
                       <label for="nombre" class="control-label">Nombre</label>
                       <input type="text" class="form-control" id="nombreRegis" name="nombreRegis" placeholder="Nombre" required>
                     </div>                         
                     <div class="form-group"> <!-- Correo Usuario -->
                       <label for="usuario" class="control-label">Correo electronico</label>
                       <input type="text" class="form-control" id="emailRegis" name="emailRegis" placeholder="Usuario o correo electronicor" required>
                     </div>    
                     <div class="form-group"> <!-- Pass -->
                       <label for="passwordRegis" class="control-label">Contrase&nacute;a</label>
                       <input type="password" class="form-control" id="passwordRegis" name="passwordRegis" placeholder="Contrase&nacute;a" required>
                     </div>  
                     <div class="form-group"> <!-- Fono Contacto -->
                       <label for="fonoContacto" class="control-label">Fono Contacto</label>
                       <input type="text" class="form-control" id="fonoContacto" name="fonoContacto" placeholder="Fono contacto" required>
                     </div>  

                   
                      <div class="form-group">
                         <div class="g-recaptcha"  data-sitekey="{{env('GOOGLE_RECAPTCHA_KEY','xxx')}}">
                         </div>
                      </div>
  
                     <div class="form-group"> <!-- Submit Button -->
                         <button type="submit" class="btn btn-primary" onClick="validar();">Registrarse</button>
                    </div>   
                 </form>
                 <!--
                 <?php //if( strlen( $msg ) >0 ) { ?>
                    <div class="alert alert-warning alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                         <?php // echo $msg; ?>
                    </div>
                 
                 <?php //} ?>
               -->
            </div>
        </div>
    </div>
  </div> 
@endsection