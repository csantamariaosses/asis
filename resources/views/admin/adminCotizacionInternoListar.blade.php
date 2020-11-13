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
          @component('../admin.adminMenu')
          @endcomponent

  </div>
</div>      
@endsection

@section('content')
<div class="container">
         <div class="row">
             <div class="col-sm-3">
                 <img src="{{asset('storage/image-productos.png')}}" width="100">
             </div>
             <div class="col-sm-3">
                 Cotizaciones Internas - Listado
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
            <div class="col-sm-3">
                 <button type="button" class="btn btn-default"  onClick="location.href='{{action('CartinternoController@create')}}'">Cotizacion Nueva</button>
            </div>
            <div class="col-sm-9">
                 <form name="frm" action="{{route("admin-productos-buscar")}}" method="POST">
               {{ csrf_field() }}
                <input type="hidden" name="accion" value="busqueda">
                <input type="text" name="txtBuscar" id="txtBuscar">&nbsp;<button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
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
                        <td>Codigo</td>
                        <td>Usuario</td>
                        <td>Nombre</td>
                        <td>Fecha</td>
                        <td>Item</td>
                    </th>
                    <tbody>
              
                    @foreach($carritoInterno as $producto)
                    <tr>
                        <td></td>
                        <td>{{$producto->id}}</td>
                        <td>{{$producto->codigo}}</td>
                        <td>{{$producto->usuario}}</td>
                        <td>{{$producto->nombre}}</td>
                        <td>{{$producto->fecha}}</td>
                        <td> 
                            <button type="button" class="btn btn-default" onClick="location.href='{{route('cartinterno-editar',[$producto->codigo])}}'">Modificar:</button>

                            <!--<button type="button" class="btn btn-danger" hint="eliminar" onClick="location.href='{{action('AdminController@adminProductosEliminar',[$producto->id])}}'">x</button>-->

                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal{{$producto->id}}">x</button>

                        </td>
                    
                    </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>   
</div>
@foreach($carritoInterno as $producto)
<div id="myModal{{$producto->id}}" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Advertencia de Eliminacion</h4>
       
      </div>
      <div class="modal-body">
        <p> Esta seguro de querer eliminar el registro:{{$producto->id}}?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" hint="eliminar" onClick="location.href='{{route('cartinterno-trash',[$producto->id])}}'">Eliminar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
 @endforeach

@endsection