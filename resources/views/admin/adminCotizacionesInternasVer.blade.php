@extends('layout.layoutCarritoCotizador')

@section('title', 'Deportes Asis')

@section('header')
    <p>Este es el header</p>
@endsection

@section('content')
<br><br><br><br><br><br><br>
<div align='center' style="background-color:#93b950
"><span id="titulo">COTIZACION</span></div> 
<hr>
<br>
<div id="datosCliente">
<table id="infoCliente">
     <tr><td><b>Nro:</b></td><td>{{$infoCabecera['codigo']}}</td></tr>
     <tr><td><b>Nombre:</b></td><td>{{$infoCabecera['nombre']}}</td></tr>
     <tr><td><b>Contacto:</b></td><td>{{$infoCabecera['contacto']}}</td></tr>
     <tr><td><b>Direccion:</b></td><td>{{ $infoCabecera['direccion']}}</td></tr>
     <tr><td><b>Email:</b></td><td>{{ $infoCabecera['email']}}</td></tr>   
     <tr><td><b>Fono Contacto:</b></td><td>{{ $infoCabecera['fonoContacto']}}</td></tr>   
     <tr><td><b>Fecha:</b></td><td>{{ date("d-m-Y")}}</td></tr>  
     <tr><td><b>Validez:</b></td><td>{{ $infoCabecera['validez']}}</td></tr>  
     <tr><td><b>Observaciones:</b></td><td>{{ $infoCabecera['observaciones']}}</td></tr>  
</table>
</div>
<br><hr>
<div align="center">Detalle</div>
<div id="datosDetalle" align="center">
  @if( count( $carritoCotizacion) > 0 ) 
   <table class="table-ligth table-bordered" width="90%">
       <tbody>
           <tr>
               <th width="30%">Producto</th>
               <th width="3%" class="text-center">cantidad</th>
               <th width="5%" class="text-center">precio</th>
               <th width="10%" class="text-center">SubTotal</th>
           </tr>
           
           @php 
           $total = 0;
           $cantidad = 0;
           $numfilas = 0;
           @endphp
           @foreach($carritoCotizacion as $dato)
               @php
                 $total = $total + $dato['precio'] * $dato['cantidad'];
                 $cantidad+= $dato['cantidad'];
                 $numfilas++;

               @endphp
               <tr>
               <td>{{$dato['producto']}}</td>
               <td align='right'>{{$dato['cantidad']}}</td>
               <td align="right">{{number_format($dato['precio'],0)}}</td> 
               <td align="right">$<span id="total">{{number_format($dato['subtotal'],0)}}</td>
               </tr>
                 
            @endforeach
              
           <tr><td><b>Total</b></td><td align="right">{{$cantidad}}</td><td></td><td align="right"><h5><b>${{number_format($total,0)}}</b></h5></td></tr>
           <tr><td colspan="4"><b>Precios IVA inclu&iacute;do</b></td></tr>
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