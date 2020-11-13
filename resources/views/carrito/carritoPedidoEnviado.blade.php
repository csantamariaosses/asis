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
             <div class="alert alert-success">
                <h4>Estimado cliente su pedido ha sido enviado a nuestros ejecutivos, <br>el codigo de su solicitud es: {{ $codPedido }}. <br>Lo contactaremos a la brevedad<br><br>Asis SpA</h4> 
             </div>
        </div>
    </div>
  </div>  
</div>
  
@endsection