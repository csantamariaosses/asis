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
                 Proveedores - Listado
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
            <div class="col-sm-6">
                 <button type="button" class="btn btn-default"  onClick="location.href='{{action('AdminController@adminProveedoresNuevo')}}'">Proveedor Nuevo</button>
            </div>
            <div class="col-sm-6">
                 <form name="frm" action="{{route("admin-proveedores-buscar")}}" method="POST">
               {{ csrf_field() }}
                <input type="hidden" name="accion" value="busqueda">
                Buscar: <input type="text" name="txtBuscar" id="txtBuscar">&nbsp;<button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                </form>
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
                        <td>rut</td>
                        <td>Nombre</td>
                        <td>Fono</td>
                        <td>Contacto</td>
                        <td>Sitio</td>
                    </th>
                    <tbody>
              
                    @foreach($registros as $registro )
                    <tr>
                        <td></td>
                        <td>{{$registro->id}}</td>
                        <td>{{$registro->rut}}</td>
                        <td>{{$registro->nombreCorto}}</td>
                        <td>{{$registro->fonoContacto}}</td>
                        <td>{{$registro->contacto}}</td>
                        <td>{{$registro->sitioWeb}}</td>                        

                        <td> 
                            <button type="button" class="btn btn-default" onClick="location.href='{{route('admin-proveedores-editar',[$registro->id])}}'">Ver / Modificar</button>


                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal{{$registro->id}}">x</button>

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
<div id="myModal{{$registro->id}}" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Advertencia de Eliminacion</h4>
       
      </div>
      <div class="modal-body">
        <p> Esta seguro de querer eliminar al Proveedor:{{$registro->nombre}}?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" hint="eliminar" onClick="location.href='{{ route('admin-proveedores-eliminar',[$registro->id])}}'">Eliminar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
 @endforeach

@endsection
