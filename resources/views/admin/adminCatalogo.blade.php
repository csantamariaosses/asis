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
@endsection

@section('content')
<div class="container">
         <div class="row">
             <div class="col-sm-3">
                 <a href="{{route('catalogo-index')}}"><img src="{{asset('storage/image-productos.png')}}" width="100"></a>
             </div>
             <div class="col-sm-3">
                 <p>Productos - Listado</p>
             </div>
             <div class="col-sm-3">
                  @foreach($proveedores as $item)
                    {{$item->proveedor}}<br>
                  @endforeach
             </div>
          </div>
          <div class="row">
             <div class="col-sm-3">
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
                 <form name="frm" action="{{route("catalogo-productos-buscar")}}" method="POST">
               {{ csrf_field() }}
               
               <table>
                 <tr><td>Buscar</td><td></td></tr>
                <tr><td>Producto</td><td><input type="text" name="txtBuscar" id="txtBuscar" value="{{$txtBuscar}}">&nbsp;palabra1 palabra2 palabra3</td></tr>
                <tr><td>Proveedor</td><td><select name="proveedor">
                     <option value="0">Todos</option>
                 @foreach($proveedores as $item)
                    @if( strcmp($item->proveedor,$proveedor) ==  0 ) 
                       <option value="{{$item->proveedor}}" selected>{{$item->proveedor}}</option>
                    @else
                       <option value="{{$item->proveedor}}">{{$item->proveedor}}</option>
                    @endif
                 @endforeach
                </select></td></tr>
                <tr><td></td><td><button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button></td></tr>
                </table>
                </form>
            </div>                       
        </div>
</div>
<br>

<div class="container">
    <div class="row">
            <div class="col-sm-12">
            <a href="#" class="btn btn-default" role="button" data-toggle="modal" data-target="#miModalAgregaProducto">Agregar Producto ...</a>
            <a href="#" class="btn btn-default" role="button" data-toggle="modal" data-target="#miModalAgregaProveedor">Agregar Proveedor ...</a>
            </div>
    </div>
</div>
<br>
<div class="container">
        <div class="row">
            <div class="col-sm-12">
                <table class="table-bordered" width="90%">
                    <th>

                        <td>Id</td>
                        <td>Proveedor</td>
                        <td>Codigo</td>
                        <td>Nombre</td>
                        <td>Descripcion</td>
                        <td>PrecioAdqu</td>
                        <td>PrecioAsis</td>
                        <td>Image</td>

                    </th>
                    <tbody>
              
                    @foreach($catalogo as $producto)
                    @php
                    $tuArray = explode("*", $producto->descripcion);
                    @endphp
                    <tr>
                        <td></td>
                        <td>{{$producto->id}}</td>
                        <td>{{$producto->proveedor}}</td>
                        <td>{{$producto->codProducto}}</td>
                        <td>{{$producto->producto}}</td>
                        <td>@php
                              foreach($tuArray as $item ) {
                                 if( strcmp($item,"") !=0  ) {
                                      echo "<br>* ".$item;
                                 }
                              }
                            @endphp
                        </td>
                        <td align="right">{{$producto->precio}}</td>
                         <td align="right">{{$producto->precioVenta}}</td>
                        <td align="center"><img src="{{$producto->imagen}}" width="200" eight="200"></td>

                        <td> 
                        <a href="#" class="btn btn-default" role="button" data-toggle="modal" data-target="#miModal{{$producto->id}}">Modificar</a>
                        <a href="{{route('admin-cotizacionesinternas-add',$producto->id)}}" class="btn btn-default" role="button"><span class="glyphicon glyphicon-shopping-cart">Cotiz Interno.{{$producto->id}}</span</a>
                        <a href="{{route('admin-cotizaciones-add',$producto->id)}}" class="btn btn-default" role="button"><span class="glyphicon glyphicon-shopping-cart">Agrega a Cotiz Cliente</span</a>
                        <a href="{{route('catalogo-to-productos-agregar',$producto->id)}}" class="btn btn-default" role="button"><span class="glyphicon glyphicon-shopping-cart">Agregar al Menu Productos</span</a>                        
                        </td>
                    
                    </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>   
@foreach($catalogo as $producto)
<div id="miModal{{$producto->id}}" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Actualiza Datos Producto</h4>
        <h5 class="modal-title">{{$producto->proveedor}} - {{$producto->producto}}</h5>
       
      </div>
      
      <div class="modal-body">
         <form name="frm" action="{{route('catalogo-cargaImagen')}}"  method="POST">  
         {{ csrf_field()}}
          
         <input type="hidden" name="id" value="{{$producto->id}}">
         <input type="hidden" name="txtBuscar" value="{{$txtBuscar}}">
         <input type="hidden" name="proveedor" value="{{$producto->proveedor}}">
          <table>
              <tr><td>
          Proveedor</td><td><input type="text" name="proveedor" value="{{$producto->proveedor}}" size="50"></td></tr>
          <tr><td>Codigo</td><td><input type="text" name="codigo" value="{{$producto->codProducto}}" size="50"> </td></tr>
          <tr><td>Producto</td><td><input type="text" name="producto" value="{{$producto->producto}}" size="50"></td></tr>
          <tr><td>Descripcion</td><td><textarea name="descripcion" cols="50" rows="5" >{{$producto->descripcion}}</textarea></td></tr>
          <tr><td>Precio</td><td><input type="number" name="precio" value="{{$producto->precio}}" size="50"></td></tr> 
          <tr><td>PrecioVenta</td><td><input type="number" name="precioVenta" value="{{$producto->precioVenta}}" size="50"></td></tr> 
          <tr><td>Imagen</td><td><input type="text" name="linkImagen" value="{{$producto->imagen}}" size="50"></td></tr>

         <tr><td></td><td><input  type="submit" class="btn btn-default"  value="Guardar"></td></tr>
         </table>
         </form>
      </div>
      <div class="modal-footer">
      </div>
    </div>

  </div>
</div>
 @endforeach
 
 
 <div id="miModalAgregaProducto" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Agrega Producto</h4>
        <h5 class="modal-title"></h5>
       
      </div>
      
      <div class="modal-body">
         <form name="frm" action="{{route("catalogo-productos-agregar")}}" method="POST">
               {{ csrf_field() }}
               
               <table>
                <tr><td>Proveedor</td><td><select name="proveedor">
                          @foreach( $cbProveedores as $item)
                                <option value="">{{$item->nombre}}</option>
                          @endforeach
                </select></td></tr>
                 <tr><td>Producto</td><td><input type="text" name="producto" size="30"></td></tr>
                   <tr><td>Descripcion</td><td><textarea name="descripcion" cols="50" rows="5" ></textarea></td></tr>
                   <tr><td>Imagen</td><td><input type="text" name="imagen" size="50"></td></tr>
                   <tr><td>Precio Compra</td><td><input type="number" name="precioCompra" size="30"></td></tr>
                   <tr><td>IVA</td><td><input type="number" name="ivaCompra" size="30"></td></tr>
                   <tr><td>Precio Venta</td><td><input type="number" name="precioVenta" size="30"></td></tr>
                <tr><td></td><td><button class="btn btn-default" type="submit">Agregar</button></td></tr>
                </table>
                </form>
      </div>
      <div class="modal-footer">
      </div>
    </div>

  </div>
</div>


<div id="miModalAgregaProveedor" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Agrega Proveedor</h4>
        <h5 class="modal-title"></h5>
       
      </div>
      
      <div class="modal-body">
         <form name="frm" action="{{route("catalogo-proveedores-agregar")}}" method="POST">
               {{ csrf_field() }}
               
               <table>
                  <tr><td>Rut</td><td><input type="text" name="rut" size="10"></td></tr>
                  <tr><td>Nombre</td><td><input type="text" name="nombre" size="100"></td></tr>
                  <tr><td>Direccion</td><td><input type="text" name="direccion" size="100"></td></tr>
                  <tr><td>Razon Social</td><td><input type="text" name="razonSocial" size="100"></td></tr>
                  <tr><td>email</td><td><input type="text" name="email" size="100"></td></tr>
                  <tr><td>Imagen</td><td><input type="text" name="imagen" size="50"></td></tr>
                  <tr><td>Contacto</td><td><input type="text" name="contacto" size="100"></td></tr>
                  <tr><td>Fono Contacto</td><td><input type="text" name="fonoContacto" size="100"></td></tr>
                  <tr><td></td><td><button class="btn btn-default" type="submit">Agregar</button></td></tr>
                </table>
                </form>
      </div>
      <div class="modal-footer">
      </div>
    </div>

  </div>
</div>
@endsection
