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
                 <img src="{{asset('storage/ico-usuarios.png')}}" width="100">
             </div>
             <div class="col-sm-3">
                 <h4>Cotizaciones - Listado</h4>
             </div>
             <div class="col-sm-3">
                 
             </div>
          </div>
          <div class="row">
             <div class="col-sm-6">
                 <div class="well well-sm">
                 </div>
             </div>
         </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
             @if( Session::has('flash-message-success'))
                 <div class="alert alert-success">
                   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button>
                    {{Session::get('flash-message-success')}}
                 </div>
             @endif
             @if( Session::has('flash-message-danger'))
                 <div class="alert alert-danger">
                   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button>
                    {{Session::get('flash-message-danger')}}
                 </div>
             @endif

        </div>
    </div>
</div>    
<div class="container">
        <div class="row">
            <div class="col-sm-12">
                 <button type="button" class="btn btn-default"  onClick="location.href='{{route('admin-cotizaciones-nueva')}}'">Cotizacion Nueva</button>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-6">
                 <div class="well well-sm">
                 <form name="frm" action="{{route("admin-cotizaciones-buscar")}}" method="POST">
               {{ csrf_field() }}
               
               <table>
                 <tr><td>Buscar</td><td></td></tr>

                 <tr><td>Codigo</td><td><input type="text" name="txtCodigo"></td></tr>
                 <tr><td>Nombre</td><td><input type="text" name="txtNombre"></td></tr>
                 <tr><td>Ciudad</td><td><input type="text" name="txtCiudad"></td></tr>
                 <tr><td>Porducto</td><td><input type="text" name="txtProducto" id="txtProducto" ></td></tr>
                 <tr><td></td><td><button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button></td></tr>
                </table>
                </form>
                </div>
            </div>            
            <div class="col-sm-6">
            </div>
        </div>
</div>
    <br>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <table class="table-bordered" width="100%">
                    <th>

                        <td>Id</td>
                        <td>Codigo</td>
                        <td>Fecha</td>
                        <td>Usuario</td>
                        <td>Rut</td>
                        <td>Nombre</td>
                        <td>Fono</td>
                        <td>Contacto</td>
                    </th>
                    <tbody>
              
                    @foreach($registros as $registro )
                    <tr>
                        <td></td>
                        <td>{{$registro->id}}</td>
                        <td>{{$registro->codigo}}</td>
                        <td>{{substr($registro->fecha,0,10)}}</td>
                        <td>{{$registro->usuario}}</td>
                        <td>{{$registro->rut}}</td>
                        <td>{{$registro->nombre}}</td>
                        <td>{{$registro->fonoContacto}}</td>
                        <td>{{$registro->contacto}}</td>
                       

                        <td> 
                            <button type="button" class="btn btn-default" onClick="location.href='{{route('admin-cotizaciones-ver',[$registro->codigo])}}'"><i class="fa fa-eye"></i>&nbsp;Ver</button>
 
                            <button type="button" class="btn btn-default" onClick="location.href='{{route('admin-cotizaciones-descargar',[$registro->codigo])}}'"><i class="fa fa-download"></i>&nbsp;Descarga</button>
                            
                            <button type="button" class="btn btn-default" onClick="location.href='{{route('admin-cotizaciones-editar',[$registro->codigo])}}'"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;Editar</button>

                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal{{$registro->codigo}}">x</button>

                        </td>
                    
                    </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>   
</div>
@foreach($registros as $registro )
<div id="myModal{{$registro->codigo}}" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Advertencia de Eliminacion</h4>
       
      </div>
      <div class="modal-body">
        <p> Esta seguro de querer eliminar al registro...?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" hint="eliminar" onClick="location.href='{{ route('admin-cotizaciones-eliminar-cotiz',[$registro->codigo])}}'">Eliminar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
 @endforeach

@endsection
