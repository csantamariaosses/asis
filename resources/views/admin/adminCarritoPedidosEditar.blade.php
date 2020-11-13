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
             <img src="{{asset('storage/user-icon1.jpg')}}" width="100">
         </div>
         <div class="col-sm-3">
         </div>
         <div class="col-sm-3">
             
         </div>
      </div>
      <div class="row">
         <div class="col-sm-6">
             <div class="well well-sm">
          
         
                </div>   
             </form>
             </div>
         </div>
     </div>
</div>
    
<div class="container">
    <div class="row">
        <div class="col-sm-2">
        </div>
        <div class="col-sm-6">
          </div>
          <div class="col-sm-4">
          </div>
    </div>
</div>

<div class="container">
    <div class="row">
         <div class="col-sm-12">

          @if(session()->has('flash-message-success')) 
             <div class="flash-message-success">
               {{ session()->get('flash-message-success') }} 
             </div>
          @endif           
          @if(session()->has('flash-message-warning')) 
             <div class="flash-message-warning">
               <p class="alert alert" align="center"><span style="color:red">{{ session()->get('flash-message-warning') }}</span>>
             </div>
          @endif 
         </div>
    </div> 
</div>



<div class="container">
    <div class="row">
        <div class="col-sm-12">
        <br><br><br><br><br><br><br>
        <div align='center' style="background-color:#93b950"><span id="titulo">PEDIDO</span></div> 
        <hr>
        <div align='center' style="background-color:#FFFFFF"><h4>{{$infoCabecera['estado']}}</h4></div> 
        <br>
        <div id="datosCliente">
        <table id="infoCliente">
             <tr><td><b>Nro:</b></td><td>{{$infoCabecera['codigo']}}</td></tr>
             <tr><td><b>Nombre:</b></td><td>{{$infoCabecera['nombre']}}</td></tr>
             <tr><td><b>Email:</b></td><td>{{ $infoCabecera['email']}}</td></tr>   
             <tr><td><b>Fono Contacto:</b></td><td>{{ $infoCabecera['fonoContacto']}}</td></tr>   
             <tr><td><b>Fecha:</b></td><td>{{ $infoCabecera['fecha']}}</td></tr>  
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
               @endphp
               @foreach($carritoCotizacion as $dato)
                   @php
                     $total = $total + $dato->precio * $dato->cantidad;
                     $cantidad+= $dato->cantidad;
                   @endphp
                   <tr>
                   <td>{{$dato->producto}}</td>
                   <td align='right'>{{$dato->cantidad}}</td>
                   <td align="right">{{number_format($dato->precio,0)}}</td> 
                   <td align="right">$<span id="total">{{number_format($dato->subtotal,0)}}</td>
                   </tr>
                     
                @endforeach
                  
               <tr><td><b>Total</b></td><td align="right">{{$cantidad}}</td><td></td><td align="right"><h5><b>${{number_format($total,0)}}</b></h5></td></tr>
               
           </tbody>
       </table>
       @endif
      </div>  
   <br>
   <hr>
  </div>
</div>

<div class="container">
     <div class="row">
        <div class="col-sm-12">
             <div align="center">Seguimiento</div>
        </div>
     </div>
     <div class="row">
        <div class="col-sm-12">
            <form name="frm" action="{{route('admin-carrito-pedidos-actualizaestado')}}" method="POST">
                {{csrf_field()}}
                <input type="hidden" name="codigo" value="{{$infoCabecera['codigo']}}">
                <input type="hidden" name="usuario" value="{{session()->get('usuario')}}">
                 <table>
                     <tr><td>Estado</td><td>
                                 <select name="estado">
                                     <option value="pedido">pedido</option>
                                     <option value="en proceso">en proceso</option>
                                     <option value="entregado">entregado</option>
                                     <option value="cancelado">cancelado</option>
                                 </select></td></tr>
                     <tr><td>Observaciones</td><td><textarea name="observaciones" cols="80" rows="4"></textarea></td></tr>
                     <tr><td></td><td><input type="submit" value="Guardar"></td></tr>
                 </table>
             </form>
        </div>
     </div>
     <br><br>
     
     <div class="row">
        <div class="col-sm-12">
             <div id="estadoDetalle" align="center">
               <table class="table-bordered" width="100%">
                 <tr><td>Fecha</td><td>Usuario</td><td>Estado</td><td>Observaciones</td></tr>

                  @foreach($carritoSeguimiento as $dato)
                   <tr>
                   <td>{{$dato->updated_at}}</td>
                   <td align='center'>{{$dato->usuario}}</td>
                   <td align="center">{{$dato->estado}}</td> 
                   <td>{{$dato->observaciones}}</td>
                   </tr>
                  @endforeach
               </table>
             </div>
        </div>
    </div>
</div>
  
@endsection