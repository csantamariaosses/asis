@extends('layout.layout')

@section('title', 'Deportes Asis')

@section('header')
    <p>Este es el header</p>
@endsection



@section('content')
  <div class="container">
    <div class="row">
         <div class="col-sm-12">
          @if(session()->has('alert-success')) 
             <div class="alert alert-success">
               {{ session()->get('alert-success') }} 
             </div>
          @endif 
         </div>
    </div> 
  </div>


<div class="container">
     <div class="row">
         <div class="col-sm-3">
             <img src="{{asset('storage/shopping-cart-png_224349.jpg')}}" width="100">
         </div>
         <div class="col-sm-3">
          
         </div>
         <div class="col-sm-3">
             
         </div>
      </div>
      <div class="row">
         <div class="col-sm-6">
             <div class="well well-sm">

              {{session()->get('usuario')}}
         
                </div>   
             </form>
             </div>
         </div>
     </div>
</div>

<div class="container">
     <div class="row">
         <div class="col-sm-6">
          <h3><i class="fa fa-shopping-cart"></i>  Carrito de Compras</h3>
          <h4></h4>
         </div>
    </div>
</div>
    
<div class="container">
    <div class="row">
        <div class="cols-sm-12">
          @if( count( $carrito) > 0 ) 
           <table class="table-ligth table-bordered" width="90%">
               <tbody>
                   <tr>
                       <th width="5%">Cod</th>
                       <th width="30%">Producto</th>
                       <th width="3%" class="text-center">cantidad</th>
                       <th width="5%" class="text-center">precio</th>
                       <th width="10%" class="text-center">Total</th>
                       <th width="20%"></th>
                   </tr>
                   
                   @php 
                   $total = 0;
                   @endphp
                   @foreach($carrito as $dato)
                       @php
                         $total = $total + $dato->precio * $dato->cantidad;
                       @endphp

                       <tr>
                       <td>{{$dato->idProducto}}</td>     
                       <td>{{$dato->nombre}}</td>
                       <td align="center">
                        <form name="frm" action="{{route('cart-update',$dato->id)}}" method="GET">
                          {{ csrf_field() }}
                        <input type="hidden" name="precio" value="{{$dato->precio}}">  
                        <input type="number" id="qty" name="qty" value="{{$dato->cantidad}}" onChange="submit()" class="input-sm"></td>
                        </form>
                       <td align="right">{{number_format($dato->precio,0)}}</td>
                       <td align="right">$<span id="total">{{number_format($dato->subtotal,0)}}</td>

                      <td align="center">&nbsp;
                       <!--<form name="frm" action="{{action('CarritoController@destroy',[$dato->idProducto])}}" method="POST">
                          {{ csrf_field() }}
                  -->

                        <a href="{{route('cart-delete',$dato->id)}}"><span style="color:red">x</span></a>
                     <!--   </form> -->
                      


                        </td>
                       </tr>
                    @endforeach
                   <tr><td><b>Total</b></td><td>Precio IVA incluido</td><td align="right"></td><td></td><td align="right"><h5><b>${{number_format($total,0)}}</b></h5></td></tr>
                   
               </tbody>
        
           </table>
           <br>
           <div>
           <a href="{{route('productos-index',session()->get('subMenu'))}}" class="btn btn-default btn-default">Seguir Comprando...</a>
            <a href="{{route('cart-trash')}}" class="btn btn-default btn-default">Vaciar Carrito</a>
            <a href="{{route('cart-pedido')}}" class="btn btn-default btn-default">Solicitar Pedido</a>

           &nbsp;
           &nbsp;
           <!--<input type="button" class="btn btn-default" value="Ir a Pagar" onClick="location.href='{{route('cart-pedido-infoPago')}}'"/> -->
           </div>
           
           @else
           <div class="container">
               <p class="text-primary">Carrito se encuentra vacio</p>
           </div>
           @endif
        </div>
    </div>
  </div>  
</div>
  
@endsection