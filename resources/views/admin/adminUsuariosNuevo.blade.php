@extends('layout.layout')

@section('title', 'Deportes Asis')

@section('header')
    <p>Este es el header</p>
@endsection


@section('menuAdmin')
<div class="container">
  <div class="row">
       <div class="col-sm-3">
           <p><h4>Administrador</h4></p>
       </div>
       <div class="col-sm-9">
          @component('admin.adminMenu')
          @endcomponent

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
                 <p align="center">Usuario Nuevo</p>
         
                </div>   
             </form>
             </div>
         </div>
     </div>
</div>
    

<div class="container">
    <div class="row">
        <div class="col-sm-12">
          @if(session()->has('flash-message-success')) 
             <div class="flash-message-success">
               {{ session()->get('flash-message-success') }} 
             </div>
          @endif           
          @if(session()->has('flash-message-warning')) 
             <div class="flash-message-warning">
               <p class="alert alert" align="center"><span style="color:red">{{ session()->get('flash-message-warning') }}</span>>
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
          <form name="fm" id="frm" action="{{route('admin-usuarios-nuevo-guardar')}}" method="POST">
           {{ csrf_field() }}
              <br>
              <table class="table-bordered table-sm">
              <tr><th><td>Rut:</td></th><td><input type="text" name="rut" id="rut" value="{{$datos['rut']}}" onkeyup="formatoRut()" maxlength="10" required></td></tr>
              <tr><th><td>Nombre</td></th><td><input type="text" name="nombre" id="nombre" value="{{$datos['nombre']}}" required size="40"></td></tr>
             
              <tr><th><td>Email</td></th><td><input type="text" name="email" id="email" value="{{$datos['email']}}" required size="40"></td></tr>
              <tr><th><td>Pass</td></th><td><input type="password" name="password" id="password" value="" size="40" required></td></tr
              <tr><th><td>Confirmar Pass</td></th><td><input type="password" name="repassword" id="repassword" value="" size="40" required></td></tr
              <tr><th><td>Fono Contacto</td></th><td><input type="text" name="fonoContacto" id="fonoContacto" value="{{$datos['fonoContacto']}}" size="40"></td></tr>              
              <tr><th><td>Tipo</td></th><td>

                <select name="tipo">
                    <option value="0" selected >Seleccione...</option>
                    <option value="admin">admin</option>
                    <option value="usuario">usuario</option>
                </select>
               </td></tr>
               <tr><td></td><td></td><td><button type="submit" class="btn btn-default btn-block">Guardar</button></td></tr>

          </table>
          
          </form>
      </div>
      <div class="col-sm-2"></div>
  </div>
        
</div>
  
@endsection