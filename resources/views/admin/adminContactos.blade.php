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
                 <h4>Contactos  - Clientes</h4>
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
<br>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <table class="table-bordered" width="100%">
                    <th>

                        <td>Id</td>
                        <td>Nombre</td>
                        <td>Email</td>
                        <td>FonoContacto</td>
                        <td>Fecha</td>
                        <td>Comentarios</td>
                    </th>
                    <tbody>
              
                    @foreach($registros as $registro )
                    <tr>
                        <td></td>
                        <td>{{$registro->id}}</td>
                        <td>{{$registro->nombre}}</td>
                        <td>{{$registro->email}}</td>
                        <td>{{$registro->fonoContacto}}</td>
                        <td>{{$registro->created_at}}</td>
                        <td>{{$registro->comentarios}}</td>

                        <td> 
                            <button type="button" class="btn btn-default" onClick="location.href='{{route('admin-carrito-pedidos-editar',[$registro->id])}}'" disabled><i class="fa fa-eye"></i>&nbsp;Modificar</button>
 
                            <button type="button" class="btn btn-default" onClick="location.href='{{route('admin-carrito-pedidos-descargar',[$registro->id])}}'" disabled><i class="fa fa-download"></i>&nbsp;Descarga</button>
                            
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal{{$registro->id}}" disabled>x</button>

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
        <p> Esta seguro de querer eliminar al registro...?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" hint="eliminar" onClick="location.href='{{ route('admin-carrito-pedidos-eliminar',[$registro->id])}}'">Eliminar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
 @endforeach

@endsection
