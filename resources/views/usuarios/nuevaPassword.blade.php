@extends('layout.layout')

@section('title', 'Deportes Asis')

@section('header')
    <p>Este es el header</p>
@endsection

@section('content')
  <div class="container">
    <div class="row">
         <div class="col-sm-12">
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
                 <span style="color:blue">
                Reseteo de Password para: </span>  {{$email}}
                 <form name="frmAcceso" id="frmAcceso" action="{{action('UsuariosController@updateNuevaPassword')}}" method="POST" onSubmit="return validar();">
                   {{ csrf_field() }}
                     <input type="hidden" name="accion" id="accion" value="updateNuevaPassword">
                     <input type="hidden" name="user" id="user" value="{{$email}}">
                     <input type="hidden" name="token" id="token" value="{{$token}}">
                     <div class="form-group"> <!-- Correo Usuario -->
                       <label for="nuevaPassword" class="control-label">Nueva Password</label>
                       <input type="password" class="form-control" id="nuevaPassword" name="nuevaPassword" nuevaPassword="Nueva Password" placeholder="Ingrese Password" required onClick="focusPass();">
                     </div>    
                     <div class="form-group"> <!-- Pass -->
                       <label for="nuevaRePassword" class="control-label">Reingreso Password</label>        
                       <input type="password" class="form-control" id="nuevaRePassword" name="nuevaRePassword" placeholder="Reingrese Password" required>
                     </div>    
                     <div class="form-group"> <!-- Submit Button -->
                         <button type="submit" class="btn btn-primary">Enviar</button>
                    </div>   
                 </form>
                 </div>
            </div>
            <div class="col-sm-6">
                    &nbsp;
            </div>

    </div>
  </div> 
@endsection