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
          <p><a href="{{route('cartinterno-show')}}"><i class="fa fa-shopping-cart carrito"></i>Carr Interno</a><a href="{{route('cart-cotizador-show')}}"><i class="fa fa-shopping-cart carrito"></i>Carr Cotizador</a></p>
         </div>
         <div class="col-sm-3">
             
         </div>
      </div>
      <div class="row">
         <div class="col-sm-3">
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
          <h3><i class="fa fa-shopping-cart"></i>  Cotizacion </h3>
          <h4></h4>
         </div>
    </div>
</div>
<br><br><hr>
<div class="container">
    <div class="row">
        <div class="cols-sm-12">
         
          @if( count( $carritoCotizador) > 0 ) 
           <table class="table-ligth table-bordered" width="90%">
               <tbody>
                   <tr>
                       <th width="5%">Cod</th>
                       <th width="20%">Proveedor</th>
                       <th width="30%">Producto</th>
                       <th width="3%" class="text-center">cantidad</th>
                       <th width="5%" class="text-center">precio</th>
                       <th width="10%" class="text-center">Total</th>
                       <th width="20%"></th>
                   </tr>
                   
                   @php 
                   $total = 0;
                   $cantidad = 0;
                   @endphp
                   @foreach($carritoCotizador as $dato)
                       @php
                         $total = $total + $dato['precio'] * $dato['cantidad'];
                         $cantidad+= $dato['cantidad'];
                       @endphp
                       
                          {{ csrf_field() }}

                       <tr>
                       <td>{{$dato['id']}}</td>
                       <td>{{$dato['proveedor']}}</td>     
                       <td>{{$dato['producto']}}</td>
                       <td align="center">
                          <form name="frm" action="{{route('cart-cotizador-update')}}" method="POST">  
                          {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{$dato['id']}}">  
                            <input type="hidden" name="precio" value="{{$dato['precio']}}">  
                            <input type="number" id="qty" name="qty" value="{{$dato['cantidad']}}" onChange="submit()" class="input-sm">
                          </form> 
                        </td>
                        
                       <td align="right">{{number_format($dato['precio'],0)}}</td> 
                       <td align="right">$<span id="total">{{number_format($dato['subtotal'],0)}}</td>

                         <td align="center">&nbsp;
                         <a href="{{route('cartinterno-delete',$dato['id'])}}"><span style="color:red">x</span></a>
                        </td> 
                       </tr>
                         
                    @endforeach
                      
                   <tr><td><b>Total</b></td><td></td><td align="right"></td><td>{{$cantidad}}</td><td></td><td align="right"><h5><b>${{number_format($total,0)}}</b></h5></td></tr>
                   
               </tbody>
           </table>
           
           <br>
           <hr>
           <br>
               <form name="frmSaveInfoClie" action="{{route('cart-cotizador-saveInfoClie')}}" method="POST">  
                   {{ csrf_field() }}
                   
               <table>
                 <tr><td>Nombre:</td><td><input type="text" name="nombre" size="40"></td></tr>
                 <tr><td>Atte.:</td><td><input type="text" name="atte" size="40"></td></tr>
                 <tr><td>Direccion.:</td><td><input type="text" name="direccion" size="40"></td></tr>
               </table>
               <br>
                <br>
                      <input type="submit" name="btnGuardar" value="Guardar">
                </form>
               <hr>
               <br>
     
     
           <div>
           <a href="{{route('catalogo-index',session()->get('subMenu'))}}" class="btn btn-default btn-default">Ir a Catalogo ...</a>

            <a href="{{route('cart-cotizador-trash')}}" class="btn btn-default btn-default">Vaciar Carrito Cotizador</a>
            <a href="{{route('cart-cotizador-generarPDF')}}" class="btn btn-default btn-default">Generar PDF</a>
            <a href="{{route('cart-cotizador-generarEXC')}}" class="btn btn-default btn-default">Generar Excel</a>

           &nbsp;
           &nbsp;<input type="button" class="btn btn-default" value="Ir a Pagar" onClick="location.href='{{route('cartinterno-pedido-infoPago')}}'"/>
           </div>
           
           @else
           <div class="container">
               <p class="text-primary">Carrito se encuentra vacio</p>
               <a href="{{route('catalogo-index',session()->get('subMenu'))}}" class="btn btn-default btn-default">Ir a Catalogo ...</a>
           </div>
           @endif
        </div>
       
    </div>
  </div>  
</div>
  
@endsection