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
         </div>
    </div>  
  </div> 
   <div class="container">
         <p><h4>Mi Cuenta:</h4></p>
         <div class="row">
             <div class="col-sm-4">
                 <img src="{{asset('storage/user-icon1.jpg')}}" width="100">
             </div>
             <div class="col-sm-4">

                  @if( strcmp($infoUser->tipo,'admin') == 0 )
                    <input type="button" class="btn-default btn-block" name="btnSalir" value= "Ir a Admin" onclick="location.href='{{action('AdminController@index')}}'"/>
                  @endif
                  
                   @if( \Session::get('carrito') )
                        <input type="button" class="btn-default btn-block" name="btnSalir" value= "Ir al Carrito" onclick="location.href='{{route('cart-show')}}'"/> 
                   @endif
                   <input type="button" class="btn-default btn-block" name="btnSalir" value= "Salir" onclick="location.href='{{action('UsuariosController@salir')}}'"/> 
             </div>
             <div class="col-sm-4">
                
             </div>
         </div>
         <hr>
          <div class="row">
             <div class="col-sm-6">
                 <div class="well well-sm">
                 Bienvenido (a) : <br>
                 {{ $infoUser->nombre}}<br>
                 email: {{ $infoUser->email}}<br>
                 fono: {{ $infoUser->fonoContacto}}<br>
                 
                 </div>   
             </div>
             <div class="col-sm-6">
             </div>
         </div>
         <div class="row">
             <div class="col-sm-6">
             <input type="button" class="btn-default btn-block" name="btnSalir" value= "Modifica Datos Usuario" onclick="location.href='{{route('usuarios-modifica-datos',[$infoUser->id])}}'"/> 
             </div>
             <div class="col-sm-6">
             </div>
         </div>
    </div>
@endsection