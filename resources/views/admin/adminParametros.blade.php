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
         </div>
         <div class="col-sm-3">
             
         </div>
      </div>
      <div class="row">
         <div class="col-sm-6">
             <div class="well well-sm">
             Bienvenido (a) : {{session()->get('usuario')}};
         
                </div>   
             </form>
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
</div>
    
<div class="container">
    <div class="row">
            <div class="col-sm-2">
            </div>
            <div class="col-sm-8">
                <form name="fm" id="frm" action="{{route('admin-params-guardar')}}" method="POST" enctype="multipart/form-data">
                  {{ csrf_field()}}
                    <br>
                   
                    <br>
                <table class="table-bordered" width="100%">
                    <tr><th><td>Rut Empresa:</td></th><td><input type="text" name="rut" id="rut" value="{{$parametros[0]->rut}}" size="50" maxsize="10" required></td></tr>
                    <tr><th><td>Nombre Empresa</td></th><td><input type="text" name="nombre" id="nombre" value="{{$parametros[0]->nombre}}" size="50" required></td></tr>
                    <tr><th><td>Email-Contacto</td></th><td><input type="text" name="email" id="email" value="{{$parametros[0]->email}}" size="50" required></td></tr>
                    <tr><th><td>Host Email</td></th><td><input type="text" name="hostEmail" id="hostEmail" value="{{$parametros[0]->hostMail}}" size="50" required></td></tr>
                    <tr><th><td>Host Email User</td></th><td><input type="text" name="hostEmailUser" id="hostEmailUser" value="{{$parametros[0]->hostMailUser}}" size="50" required></td></tr>
                    <tr><th><td>Host Email Pass</td></th><td><input type="text" name="hostEmailPass" id="hostEmailPass" value="{{$parametros[0]->hostMailPass}}" size="50"></td></tr>
                    <tr><th><td>Host Email Puerto</td></th><td><input type="text" name="hostEmailPuerto" id="hostEmailPuerto" value="{{$parametros[0]->hostMailPuerto}}" size="50" required></td></tr>
  
                    <tr><th><td>Fono Contacto</td></th><td><input type="text" name="fonoContacto" id="fonoContacto" value="{{$parametros[0]->fonoContacto}}" size="50" required></td></tr>
                    <tr><th><td>Fono Washapp</td></th><td><input type="text" name="fonoWhasappEmp" id="fonoWhasappEmp" value="{{$parametros[0]->fonoWhasap}}" size="50" required></td></tr>
                    <tr><th><td>Direccion-Calle</td></th><td><input type="text" name="direccionEmp" id="direccionEmp" value="{{$parametros[0]->direccion}}" size="50" required></td></tr>
                    <tr><th><td>Sitio web</td></th><td><input type="text" name="direccionWeb" id="direccionWeb" value="{{$parametros[0]->direccionWeb}}" size="50" required></td></tr>
                    <tr><th><td></td></th><td><input type="submit" name="btnSubmit" value="Guardar"></td></tr>

                </table>
                
                </form>
            </div>
             <div class="col-sm-2">
            </div>
        </div>
    
</div>
  
@endsection