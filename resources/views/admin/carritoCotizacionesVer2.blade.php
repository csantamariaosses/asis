@extends('layout.layoutCarritoCotizador')

@section('title', 'Deportes Asis')

@section('header')
    <p>Este es el header</p>
@endsection

@section('content')
<div id="datosCliente">
<table>
     <tr><td><b>Nro:</b></td><td>{{$infoCabecera['codigo']}}</td></tr>
     <tr><td><b>Nombre:</b></td><td>{{$infoCabecera['nombre']}}</td></tr>
     <tr><td><b>Contacto:</b></td><td>{{$infoCabecera['contacto']}}</td></tr>
     <tr><td><b>Direccion:</b></td><td>{{ $infoCabecera['direccion']}}</td></tr>
     <tr><td><b>Email:</b></td><td>{{ $infoCabecera['email']}}</td></tr>   
     <tr><td><b>Fono Contacto:</b></td><td>{{ $infoCabecera['fonoContacto']}}</td></tr>   
     <tr><td><b>Fecha:</b></td><td>{{ date("d-m-Y")}}</td></tr>  
     <tr><td><b>Validez:</b></td><td>{{ $infoCabecera['validez']}}</td></tr>  
</table>
</div>



<br><br><hr>
<div id="datosDetalle">
  @if( count( $carritoCotizacion) > 0 ) 
   <table class="table-ligth table-bordered" width="90%">
       <tbody>
           <tr>
               <th width="5%">Cod</th>
               <th width="30%">Producto</th>
               <th width="3%" class="text-center">cantidad</th>
               <th width="5%" class="text-center">precio</th>
               <th width="10%" class="text-center">SubTotal</th>
           </tr>
           
           @php 
           $total = 0;
           $cantidad = 0;
           @endphp
           @foreach($carritoCotizacion as $dato)
               @php
                 $total = $total + $dato['precio'] * $dato['cantidad'];
                 $cantidad+= $dato['cantidad'];
               @endphp
               <tr>
               <td>{{$dato['id']}}</td>
               <td>{{$dato['producto']}}</td>
               <td align='right'>{{$dato['cantidad']}}</td>
               <td align="right">{{number_format($dato['precio'],0)}}</td> 
               <td align="right">$<span id="total">{{number_format($dato['subtotal'],0)}}</td>
               </tr>
                 
            @endforeach
              
           <tr><td><b>Total</b></td><td></td><td align="right">{{$cantidad}}</td><td></td><td align="right"><h5><b>${{number_format($total,0)}}</b></h5></td></tr>
           
       </tbody>
   </table>
 </div>  
   <br>
   <hr>
   <br>
          
     
       <br>

   @else
   <div class="container">
       <p class="text-primary">Carrito se encuentra vacio</p>
   </div>
   @endif
@endsection