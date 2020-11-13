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
          <p><a href="{{route('cartinterno-show')}}"><i class="fa fa-shopping-cart carrito"></i>Carr Interno</a><a href="{{route('cart-cotizacion-show')}}"><i class="fa fa-shopping-cart carrito"></i>Carr Cotizador</a></p>
         </div>
     </div>   
</div>     



<div class="container">
     <div class="row">
         <div class="col-sm-12">
          <h3><i class="fa fa-shopping-cart"></i>  Cotizacion Clientes Nueva</h3>
          <h4></h4>
         </div>
    </div>
    <div class="row">
         <div class="col-sm-12">
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
               <form name="frmSaveInfoClie" action="{{route('cart-cotizacion-saveInfoClieNew')}}" method="POST">  
                   {{ csrf_field() }}
                   
               <table>
                <tr><td>Rut:</td><td><input type="text" name="rut" size="60" value="{{$infoCabecera['rut']}}"></td></tr>
                 <tr><td>Nombre:</td><td><input type="text" name="nombre" size="60" value="{{$infoCabecera['nombre']}}"></td></tr>
                 <tr><td>Contacto.:</td><td><input type="text" name="contacto" size="60" value="{{$infoCabecera['contacto']}}"></td></tr>
                 <tr><td>Direccion.:</td><td><input type="text" name="direccion" size="60"  value="{{$infoCabecera['direccion']}}"></td></tr>
                 <tr><td>Fono Contacto:</td><td><input type="text" name="fonoContacto" size="60"  value="{{$infoCabecera['fonoContacto']}}"></td></tr>                 
                 <tr><td>Email.:</td><td><input type="text" name="email" size="60"  value="{{$infoCabecera['email']}}"></td></tr>
                 <tr><td>Validez:</td><td><input type="text" name="validez" size="60"  value="{{$infoCabecera['validez']}}"></td></tr>
                 <tr><td>Observaciones:</td><td><textarea name="observaciones" cols="60" rows="4"></textarea></td></tr> 
               </table>
               <br>
                <br>
                <table>
                    <tr>
                      <td>&nbsp;</td><td><input type="submit" name="btnGuardar" value="   Continuar  >>"></td>
                    </tr>
                </table>
                </form>
               <hr>
               <br>
         
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