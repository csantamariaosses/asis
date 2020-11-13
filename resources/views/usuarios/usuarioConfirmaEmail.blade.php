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
         </div>
    </div>  
    <div class="row">
            <div class="col-sm-6">
                <div class="well well-sm">
                 <span style="color:blue">
                Solicita Confirmacion: </span>  
                <p>Hemos enviado un email a {{$emailRegis}}, Por favor verifique su email, siga las instrucciones para verificar su direccion de correo, y pulse el boton de abajo para continuar.</p>
                <p>
                 <form name="frmAcceso" id="frmAcceso" action="{{action('UsuariosController@index')}}" method="POST">
                   {{ csrf_field() }}
                    
                     <div class="form-group"> <!-- Submit Button -->
                         <button type="submit" class="btn btn-primary">Continuar</button>
                    </div>   
                 </form>
               </p>
                 </div>
            </div>
            <div class="col-sm-6">
                    &nbsp;
            </div>

    </div>
  </div> 
@endsection