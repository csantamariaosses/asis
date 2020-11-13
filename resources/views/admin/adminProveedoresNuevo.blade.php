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
         <div class="col-sm-3">
             <img src="{{asset('storage/user-icon1.jpg')}}" width="100">
         </div>
         <div class="col-sm-3">
             <p><h3>Proveedores - Nuevo</h3></p>
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
        <div class="col-sm-2">
        </div>
        <div class="col-sm-6">
          <div class="well well-sm">
          </div>
          <div class="col-sm-4">
          </div>
    </div>
</div>

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
</div>


<div class="container">
    <div class="row">
        <div class="col-sm-2">
        </div>
        <div class="col-sm-8">
          <form name="fm" id="frm" action="{{route('admin-proveedores-save')}}" method="POST">
           {{ csrf_field() }}
         
              <br>
              <table class="table-bordered" width="100%">

               <tr><th><td>rut</td></th><td><input type="text" name="rut" id="rut" value="{{$datos['rut']}}" onkeyup="formatoRut()" maxlength="10" required></td></tr>
              <tr><th><td>Nombre</td></th><td><input type="text" name="nombre" id="nombre" value="{{$datos['nombre']}}" required size="60"></td></tr>
              <tr><th><td>Nombre Corto</td></th><td><input type="text" name="nombreCorto" id="nombreCorto" value="{{$datos['nombreCorto']}}" required size="60"></td></tr>
              <tr><th><td>Giro / Actividad </td></th><td><input type="text" name="giroActividad" id="giroActividad" value="{{$datos['giroActividad']}}" required size="60"></td></tr>
              <tr><th><td>Direccion</td></th><td><input type="text" name="direccion" id="direccion" value="{{$datos['direccion']}}"  size="60"></td></td></tr>
              <tr><th><td>Contacto</td></th><td><input type="text" name="contacto" id="contacto" value="" size="60"></td></tr>
              <tr><th><td>Fono Contacto</td></th><td><input type="text" name="fonoContacto" id="fonoContacto" value="" size="60"></td></tr>
             <tr><th><td>Email</td></th><td><input type="text" name="email" id="email" value="" size="60"></td></tr>              
              <tr><th><td>Sitio Web</td></th><td><input type="text" name="sitioWeb" id="sitioWeb" value="" size="60"></td></tr>


               <tr><th><td></td></th><td><input type="submit" name="btnSubmit" value="Agregar"></td></tr>

          </table>
          
          </form>
      </div>
      <div class="col-sm-2"></div>
  </div>
        
</div>
  
@endsection


