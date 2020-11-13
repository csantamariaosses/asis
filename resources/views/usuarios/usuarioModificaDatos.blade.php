@extends('layout.layout')

@section('title', 'Deportes Asis')

@section('header')
    <p>Este es el header</p>
@endsection


@section('menuAdmin')
<div class="container">
  <div class="row">
       <div class="col-sm-3">
           <h4>Modifica Datos Usuarios</h4>
       </div>
       <div class="col-sm-9">
         
       </div>

  </div>
</div>      
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
     <div class="row">
         <div class="col-sm-3">
             <img src="{{asset('storage/user-icon1.jpg')}}" width="100">
         </div>
         <div class="col-sm-3">
         </div>
         <div class="col-sm-3">
             
         </div>
      </div>
      <div class="row">
         <div class="col-sm-6">
             <div class="well well-sm">
          
         
                </div>   
             </form>
             </div>
         </div>
     </div>
</div>
    

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
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-sm-2">
        </div>
        <div class="col-sm-8">
          <form name="fm" id="frm" action="{{route('usuarios-update')}}" method="POST">
           {{ csrf_field() }}
          
           <input type="hidden" name="image" value="">
            <input type="hidden" name="id" value="{{$infoUser->id}}">
              <br>
              <table class="table-bordered" width="100%">
              <tr><th><td>Id</td></th><td>{{$infoUser->id}}</td></tr>
              <tr><th><td>Rut</td></th><td><input type="text" name="rut" id="rut" value="{{$infoUser->rut}}" required></td></tr>
              <tr><th><td>Nombre</td></th><td><input type="text" name="nombre" id="nombre" value="{{$infoUser->nombre}}" required size="40"></td></tr>
             
              <tr><th><td>Email</td></th><td><input type="text" name="email" id="email" value="{{$infoUser->email}}" required size="40"></td></tr>
              <tr><th><td>Password</td></th><td><input type="password" name="password" id="password" value="" size="40" disabled>&nbsp;<input type="checkbox" name="cambiaPass" id="cambiaPass">cambia password</td></tr>
              <tr><th><td>Fono Contacto</td></th><td><input type="text" name="fonoContacto" id="fonoContacto" value="{{$infoUser->fonoContacto}}" required></td></tr>              
               </td></tr>
               <tr><td></td><td></td><td><button type="button" class="btn btn-default" onClick="location.href='{{action('UsuariosController@index')}}'">Cancelar</button><button type="submit" class="btn btn-default">Actualizar</button></td></tr>

          </table>
          
          </form>
      </div>
      <div class="col-sm-2"></div>
  </div>
        
</div>
  
@endsection