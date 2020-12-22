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
          <form name="fm" id="frm" action="{{route('admin-usuarios-update')}}" method="POST">
           {{ csrf_field() }}
           <input type="hidden" name="image" value="">
            <input type="hidden" name="id" value="{{$user->id}}">
              <br>
              <table class="table-bordered table-sm">
              <tr><th><td>Id</td></th><td>{{$user->id}}</td></tr>
              <tr><th><td>Rut</td></th><td><input type="text" name="rut" id="rut" value="{{$user->rut}}" onkeyup="formatoRut()" required></td></tr>
              <tr><th><td>Nombre</td></th><td><input type="text" name="nombre" id="nombre" value="{{$user->nombre}}" required size="40"></td></tr>
             
              <tr><th><td>Email</td></th><td><input type="text" name="email" id="email" value="{{$user->email}}" required size="40"></td></tr>
              <tr><th><td>Pass</td></th><td><input type="password" name="password" id="password" value="" disabled size="40">&nbsp;<input type="checkbox" name="cambiaPass" id="cambiaPass">cambio password</td></tr
              <tr><th><td>Fono Contacto</td></th><td><input type="text" name="fonoContacto" id="fonoContacto" value="{{$user->fonoContacto}}" required></td></tr>              
              <tr><th><td>Tipo</td></th><td>

                <select name="tipo">
                    @if( strcmp($user->tipo, 'admin' ) == 0 )
                    <option value="admin" selected >admin</option>
                    @else 
                    <option value="admin">admin</option>
                    @endif
                    @if( strcmp($user->tipo, 'usuario' ) == 0 )
                    <option value="usuario" selected >usuario</option>
                    @else 
                    <option value="usuario">usuario</option>
                    @endif

                </select>
               </td></tr>
               <tr><th><td>Estado</td></th><td>
                   <select name="estadoUsuario">
                       <option value="0">Seleccione...</option>
                       @for($i=0; $i < count($estadoUsuarios); $i++)
                           @if( strcmp($user->estado,$estadoUsuarios[$i]->estado) == 0 ) {
                              <option value="{{$estadoUsuarios[$i]->estado}}" selected>{{$estadoUsuarios[$i]->estado}}</option>
                           @else
                              <option value="{{$estadoUsuarios[$i]->estado}}">{{$estadoUsuarios[$i]->estado}}</option>
                           @endif

                        @endfor
                   </select>
                   
                   </td></tr>
               <tr><td></td><td></td><td><button type="submit" class="btn btn-default btn-block">Actualizar</button></td></tr>

          </table>
          
          </form>
      </div>
      <div class="col-sm-2"></div>
  </div>
        
</div>
  
@endsection