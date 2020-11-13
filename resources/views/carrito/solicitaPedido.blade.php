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

         </div>
    </div>
</div>
    
<br>
<div class="container">
  <div class="row">
     <div class="col-sm-6">
       <p><h4>Carrito de Compras - Solicitud de Pedido 
     </div
     <div class="col-sm-6">
       </p>
       </div>
  </div>
</div>

 <div class="container">
     <table class="table-ligth table-bordered" width="80%">
         <tbody>
             <tr>
                 <th width="5%">Cod</th>
                 <th width="30%">Producto</th>
                 <th width="3%" class="text-center">cantidad</th>
                 <th width="5%" class="text-center">precio</th>
                 <th width="10%" class="text-center">Total</th>
       
             </tr>
             @php
           
             $i = 0;
             $total = 0;
             $total_productos = 0;
             @endphp

             @foreach($carrito as $dato)
                
                 <tr>
                 <td>{{$dato->idProducto}}</td>     
                 <td>{{$dato->nombre}}</td>
                 <td align="center">{{$dato->cantidad}}</td>
                 <td align="right">${{$dato->precio}}</td>
                 <td align="right">$<span id="total">{{number_format($dato->subtotal,0)}}</td>
                 
                 </tr>

                 @php
                 $total+= (int)$dato->precio * (int) $dato->cantidad;
                 @endphp
             @endforeach
             <tr><td><b>Total</b></td><td>Precio IVA incluido</td><td align="right"></td><td></td><td align="right"><h5><b>${{number_format($total,0)}}</b></h5></td></tr>
             
         </tbody>
  
     </table>
</div>
<br><br><hr>
    <div class="container">
        <form name="frm" id="frm" action="{{ route('cart-pedido-envia') }}" method="POST">
            <input type="hidden" name="hdAccion" id="hdAccion" value="enviarPedido">
            {{ csrf_field() }}
            <div class="row">
               <div class="col-sm-7 text-center">
              <legend class="text-center header"><span style="color:#6E6E6E">Informaci&oacute;n de Contacto</legend>
              </div>
            </div>

            <div class="row">
                <div class="col-sm-7 text-center">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-user fa-fw bigicon" ></i></span>
                      <input class="form-control" type="text" id="name" name="name" id="name"  placeholder="Nombre" value="{{\Session::get('nombre')}}" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-7 text-center">
                    <div class="input-group margin-bottom-sm">
                      <span class="input-group-addon"><i class="fa fa-envelope-o fa-fw bigicon"></i></span>
                      <input class="form-control" type="text" id="email" name="email" placeholder="Correo electronico" value="{{\Session::get('email')}}" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-7 text-center">
                    <div class="input-group margin-bottom-sm">
                      <span class="input-group-addon"><i class="fa fa-phone-square fa-fw bigicon"></i></span>
                      <input class="form-control" type="text" id="fonoContacto" name="fonoContacto" value="{{\Session::get('fonoContacto')}}" placeholder="Telefono">
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-sm-7 text-center">  
                    <div class="input-group margin-bottom-sm">
                      <span class="input-group-addon"><i class="fa fa-pencil-square-o fa-fw bigicon"></i></span>
                       <textarea class="form-control" id="message" name="observaciones" placeholder="Ingrese su mensaje aqui." rows="5" cols="35" required></textarea>
                    </div>
                </div>
            </div>



            <br>
            <div class="row">
                <div class="col-md-12 text-center">
                </div>
                <div  class="col-md-8">
                  <input type="submit" class="btn btn-success"  value="Enviar">
                </div>
            </div>
          </form>
       </div>
     
     </div>
  
@endsection