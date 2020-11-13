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
         <div class="col-sm-12">
          @if(session()->has('flash-message-warning')) 
             <div class="alert alert-warning">
               {{ session()->get('flash-message-warning') }} 
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
     </div>   
</div>     



<div class="container">
     <div class="row">
         <div class="col-sm-12">
          <h3><i class="fa fa-shopping-cart"></i>  Cotizacion Cliente</h3>
          <h4></h4>
         </div>
    </div>
    <div class="row">
         <div class="col-sm-12">
          <h4>Nro:{{$infoCabecera['codigo']}}</h3>
          <h4></h4>
         </div>
    </div>
</div>
<br><br><hr>


     
<div class="container">    

<div class="row">
         <div class="col-sm-12">
             <div class="well well-sm">

              <!--{{ session()->get('usuario')}} -->
              <hr>
           <br>
               <form name="frmSaveInfoClie" action="{{route('admin-cotizaciones-saveInfoClie')}}" method="POST">  
                   {{ csrf_field() }}
                   
                   <input type="hidden" name="codigo" value="{{$infoCabecera['codigo']}}">
               <table>
                 <tr><td>Total:</td><td><input type="text" name="rut" size="60" value="{{number_format($infoCabecera['total'])}}" disabled></td></tr>                   
                 <tr><td>Codigo:</td><td><input type="text" name="codigo_" size="60" value="{{$infoCabecera['codigo']}}" disabled></td></tr>
                 <tr><td>Rut:</td><td><input type="text" name="rut" size="60" value="{{$infoCabecera['rut']}}"></td></tr>
                 <tr><td>Nombre:</td><td><input type="text" name="nombre" size="60" value="{{$infoCabecera['nombre']}}"></td></tr>
                 <tr><td>Contacto:</td><td><input type="text" name="contacto" size="60" value="{{$infoCabecera['contacto']}}"></td></tr>
                 <tr><td>Direccion.:</td><td><input type="text" name="direccion" size="60"  value="{{$infoCabecera['direccion']}}"></td></tr>
                 <tr><td>Ciudad:</td><td><input type="text" name="ciudad" size="60"  value="{{$infoCabecera['ciudad']}}"></td></tr>
                 <tr><td>Fono Contacto:</td><td><input type="text" name="fonoContacto" size="60"  value="{{$infoCabecera['fonoContacto']}}"></td></tr>                 
                 <tr><td>Email.:</td><td><input type="text" name="email" size="60"  value="{{$infoCabecera['email']}}"></td></tr>
                 <tr><td>Validez:</td><td><input type="text" name="validez" size="60"  value="{{$infoCabecera['validez']}}"></td></tr>                 
                  <tr><td>Observaciones::</td><td><textarea name="observaciones" rows="4" cols="50">{{$infoCabecera['observaciones']}}</textarea></td></tr>    
               </table>
               <br>
                <br>
                      <input type="submit" name="btnGuardar" value="Guardar..">
                      <input type="button" name="btnGenerarPDF" onClick="location.href='{{route('admin-cotizaciones-descargar',$infoCabecera['codigo'])}}'" value="Generar PDF">
                </form>
               <hr>
               <br>
         
             </div>
         </div>
     </div>



     <div class="row">
         <div class="col-sm-12">
          @if( count( $carritoCotizacion) > 0 ) 
                 <table class="table-ligth table-bordered" width="90%">
               <tbody>
                   <tr>
                       <th width="5%">id</th>
                       <th width="5%">codProductoProveedor</th>
                       <th width="20%">Proveedor</th>
                       <th width="30%">Producto</th>
                       <th width="3%" class="text-center">cantidad</th>
                       <th width="5%" class="text-center">precio</th>
                       <th width="10%" class="text-center">SubTotal</th>
                       <th width="20%"></th>
                   </tr>
                   
                   @php 
                   $total = 0;
                   $cantidad = 0;
                   $subTotal = 0;
                   @endphp
                   @foreach($carritoCotizacion as $dato)
                       @php
                          $cantidad+= $dato['cantidad'];
                          $precioProd   =   $dato['precio'];
                          $cantProd     =   $dato['cantidad'];
                          $total+= $cantProd * $precioProd;
                          $subTotal = $cantProd * $precioProd;
                          
                       @endphp
                       <tr style="background-color:#ffcccc">
                       <td>{{$dato['id']}}</td>
                       <td>{{$dato['codProductoCatalogo']}}</td>
                       <td>{{$dato['proveedor']}}</td>     
                       <td>{{$dato['producto']}}</td>
                       <td align="center">
                          <form name="frm" action="{{route('admin-cotizaciones-update-producto')}}" method="POST">  
                          {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{$dato['id']}}">  
                            <input type="hidden" name="precio" value="{{$dato['precio']}}">  
                            <input type="number" id="qty" name="qty" value="{{$dato['cantidad']}}" onChange="submit()" class="input-sm">
                          </form> 
                        </td>
                        
                       <td align="right">${{number_format($dato['precio'],0)}}</td> 
                       <td align="right">$<span id="total">{{number_format($subTotal,0)}}</td>

                         <td align="center">&nbsp;
                               <a href="{{route('admin-cotizaciones-delete-producto',$dato['id'])}}"><span style="color:red">x</span></a>
                        </td> 
                       </tr>
                         
                    @endforeach
                      
                   <tr><td</td><td></td><td><b>Total Neto</b></td><td align="right"></td><td></td><td>{{$cantidad}}</td><td></td><td align="right"><h5><b>${{number_format($total,0)}}</b></h5></td></tr>
                   <tr><td</td><td></td><td><b>IVA 19%</b></td><td align="right"></td><td></td><td></td><td></td><td align="right"><h5><b>${{number_format($total*.19,0)}}</b></h5></td></tr>
                   <tr><td</td><td></td><td><b>TOTAL</b></td><td align="right"></td><td></td><td></td><td></td><td align="right"><h5><b>${{number_format($total*1.19,0)}}</b></h5></td></tr>
               </tbody>
           </table>
           @else
           <div class="container">
               <p class="text-primary">Detalle de productos se encuentra vacio</p>
           </div>
           @endif
            <a href="{{route('catalogo-index',session()->get('subMenu'))}}" class="btn btn-default btn-default">Ir a Catalogo ...</a>
            <hr>
            <p>Agrega Item Libre</p>
            <form name="frm" action="{{route('admin-cotizaciones-addManual')}}" method="POST">  
                          {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{$infoCabecera['codigo']}}">  
                            
                            <table>
                                <tr><td>Proveedor</td><td>Producto</td><td>Cantidad</td><td>Precio</td><td>Subtotal</td></tr>
                                <tr>
                                    <td><input type="text" name="proveedor" required></td>
                                    <td><input type="text" name="producto"  required></td>
                                    <td align="right"><input type="number" name="cantidad" id="cantidad" onChange="recalculaSubtotal();"  required ></td>
                                    <td align="right"><input type="number" name="precio" id="precio" onChange="recalculaSubtotal();" required></td>
                                    <td align="right"><input type="number" name="subtotal" id="subtotal"></td>
                                </tr>
                            
                            </table>
                            <input type="submit" name="btnSubmit" value="Agrega Item">
                            
            </form> 
         </div>
    </div>
     
</div>


<br><br><hr>
<div class="container">
    <div class="row">
        <div class="cols-sm-12">
             
        </div>
       
    </div>
  </div>  
</div>
  
@endsection