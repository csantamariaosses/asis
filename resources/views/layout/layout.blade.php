<!doctype html>
<html>
<title>Deportes Asis</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="lenguage" content="es">
<meta name="description" content="Deportes Asis, Comercializacion de Articulos Deportivos">
<meta name="keywords" content="articulos deportivos, poleras, camisetas, yoga, mancuernas, pelotas, estampados, balones, futbol, basquetbol">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="apple-mobile-web-app-capable" content="yes" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/estilos_falcon2.css') }}">
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
<script src="{{ asset('js/funciones.js')}}"></script>
<script src="{{ asset('js/funcionesJs3.js')}}"></script>
<script src="{{ asset('js/fnRotativos.js')}}"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>



</head>
<body>
  <br>
<div class="container-fluid div-logo-fonos">
  <div class="row">
    <div class="col-sm-5 col-sm-offset-1">
       <div id="logo"><a href="{{action('homeController@index')}}"><img src="{{asset('storage/logo_asis_transp.png')}}" alt="logo-asis" width="150"/></a>
       </div>
    </div>
    <div class="col-sm-6 zona-fonos">
     <div>
      <ul class="ul-fonos-header">  
          <li><h4><i class="fa fa-phone"></i>&nbsp;<a href="tel:{{$parametros[0]->fonoContacto}}">{{$parametros[0]->fonoContacto}}</a></h4>
              <h4><i class="fa fa-whatsapp color-whatsapp"></i>
              <a href="tel:{{$parametros[0]->fonoWhasap}}">{{$parametros[0]->fonoWhasap}}</a></h4>
              <h4><i class="fa fa-envelope sobreEmail color-sobreMail"></i>
              <a href="{{action('contactoController@index')}}">contactenos</a></h4>
              <h4><a href="{{route('cart-show')}}"><i class="fa fa-shopping-cart carrito"></i></a><span class="span-usuario">{{session('carrito-count')}}</span></h4>
              
              <h4><a href="{{action('UsuariosController@index')}}">Mi Cuenta</a></h4>
              @if(  session('usuario') ) 
              <h4></h4><span style="color:green">{{\Session::get('nombre')}}</span></h4>
              <p><button class="btn btn-default" type="button" onclick="location.href='{{action('UsuariosController@salir')}}'"><i class="fa fa-power-off" aria-hidden="true"></i></button></p>

              @endif
          </li>
      </ul>
     </div>
    </div>
  </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-sm-6">
            BUSQUEDA<form name="frm" action="{{route("productos-buscar")}}" method="POST">
               {{ csrf_field() }}
                <input type="hidden" name="accion" value="busqueda">
                <input type="text" name="txtBuscar" id="txtBuscar">&nbsp;<button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                </form>
        </div>
        <div class="col-sm-6">
            
        </div>
        
    </div>
</div>
<br>
<br>

 <div class="contenedor-menu">
        <a href="#" class="btn-menu">Menu<i class="icono fa fa-bars"></i></a>
        
        <ul class="menu">
            <li><a href="{{route('home')}}"><i class="icono izquierda fa fa-home"></i>Inicio</a></li>
            <li><a href="#"><i class="icono izquierda fa fa-star"></i>Productos<i class="icono derecha fa fa-chevron-down"></i></a>
                <ul>
                   @foreach( $items as $item)
                       @php
                         $ITEM_KEY =  $item->subMenu;
                         $ITEM_Titulo = ucfirst(str_replace("-"," ",$ITEM_KEY));
                       @endphp
                       @if( strcmp($ITEM_Titulo,"")!=0)
                       <li><a href="{{ route('productos-index',$ITEM_KEY) }}">{{$ITEM_Titulo}}</a></li>
                       @endif
                    @endforeach
                </ul>
            </li>
            <li><a href="{{route('cart-show')}}"><i class="fa fa-shopping-cart carrito"></i>Carrito</a></li>
            <li><a href="{{action('contactoController@index')}}"><i class="icono izquierda fa fa-envelope"></i>Contacto</a></li>
         
        </ul>
    </div>
<br>



<br>
   <div class="container">
       @if(session('message')) {{session('message')}} @endif 
       @yield('menuAdmin')
       @yield('content')        
    </div>
    
   <br><br>


<!--   FOOTER TOP -->
<div class="footer">
<div class="container">
    <div class="row">
        <div class="col-sm-12 text-center">
            <h4>Deportes Asis</h4>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-sm-6 text-left">
            <p><a href="{{action('homeController@index')}}"><img src="{{asset('storage/logo_asis_transp.png')}}" alt="logo-asis" width="150"/></a></p>
        </div>
        <div class="col-sm-6 text-left">
            <p><h4>Informaci&oacute;n de Contacto</h4></p>
            <i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;&nbsp; {{ $parametros[0]->direccion}}<br>
            <i class="fa fa-phone" aria-hidden="true"></i>&nbsp;&nbsp;{{$parametros[0]->fonoContacto}}<br>
            <i class="fa fa-whatsapp" aria-hidden="true"></i>&nbsp;&nbsp;{{$parametros[0]->fonoWhasap}}<br>
            <i class="fa fa-envelope-o" aria-hidden="true"></i> &nbsp; {{$parametros[0]->email}}<br>
            <i class="fa fa-globe" aria-hidden="true"></i>&nbsp;&nbsp;{{$parametros[0]->direccionWeb}}
            

        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-sm-12">
            <a href="https://www.facebook.com/profile.php?id=100034189782538" target="_blank"><i class="fa fa-facebook-square fa-2x ico-face-footer" aria-hidden="true"></i></a>
        </div>
    </div>
    <br><br>
</div>
</div>


<!--   FOOTER END -->
<script src="{{asset('js/jquery.js')}}"></script>
<script src="{{asset('js/main-falcon.js')}}"></script>  
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script> 
@yield('jQueryContent') 

</body>
</html>