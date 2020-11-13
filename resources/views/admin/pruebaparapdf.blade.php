<html>
    <head><title></title>
    
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="lenguage" content="es">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="apple-mobile-web-app-capable" content="yes" />
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">    
    <style>

@page {
    margin: 100px 25px;
}


/*
header {
    position: fixed;
    top: -60px;
    left: 0px;
    right: 0px;
    height: 50px;

    /** Extra personal styles **/
    background-color: #03a9f4;
    color: white;
    text-align: center;
    line-height: 35px;
}
*/

#titulo {
    font-family:Arial, Helvetica, sans-serif;
    font-size:20px;
}

#infoCliente tr td{
    font-family:Arial, Helvetica, sans-serif;
    font-size:15px;
}


footer {
    position: fixed; 
    bottom: -60px; 
    left: 0px; 
    right: 0px;
    height: 50px; 

    /** Extra personal styles **/
    background-color: #ffffff;
    color: black;
    text-align: center;
    line-height: 15px;
    font-size:15px;
}


/*.page_break { page-break-after: always; } */
</style>    
    
    
    </head>
    <body>
        <img src="{{asset('storage/encabezadoPlantillaCotizaciones.jpg')}}" width="100%">
        <div align='center' style="background-color:#93b950"><span id="titulo">COTIZACION  -  {{ $infoCabecera['codigo']}}-{{$infoCabecera['DDMMAAAA']}}</span></div> 
         <hr>
         <div id="datosCliente">
           <table id="infoCliente">
             <tr><td><b>Nro</b></td><td>:<b>{{$infoCabecera['codigo']}}</b></td></tr>
             <tr><td><b>Nombre</b></td><td>:{{$infoCabecera['nombre']}}</td></tr>
             <tr><td><b>Contacto</b></td><td>:{{$infoCabecera['contacto']}}</td></tr>
             <tr><td><b>Fecha</b></td><td>:{{ $infoCabecera['fecha']}}</td></tr>  
             <tr><td><b>Validez</b></td><td>:{{ $infoCabecera['validez']}}</td></tr>  
             <tr><td><b>Observaciones</b></td><td>:{{ $infoCabecera['observaciones']}}</td></tr>  
            </table>
        </div>
        <br>
        <div align='center' style="background-color:#FFFFFF"><span id="titulo">DETALLE</span></div> 
        <hr>
        <div>
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
                       <td align="right">${{number_format($dato['precio'],0)}}</td> 
                       <td align="right">$<span id="total">{{number_format($dato['subtotal'],0)}}</td>
                       </tr>
                         
                    @endforeach
                      
                   <tr><td><b>Total Neto</b></td><td align="right">{{$cantidad}}</td><td></td><td align="right"><b>${{number_format($infoCabecera['total'],0)}}</b></td></tr>
                   <tr><td><b>IVA 19%</b></td><td</td><td></td><td align="right"><b>${{number_format($infoCabecera['iva'],0)}}</b></td></tr>
                   <tr><td><b>TOTAL</b></td><td></td><td></td><td align="right"><b>${{number_format($infoCabecera['totalIvaInc'],0)}}</b></td></tr>

               </tbody>
           </table>
        </div>  
    <br>
    

   @else
   <div class="container">
       <p class="text-primary">Carrito se encuentra vacio</p>
   </div>
       
  @endif
  <footer>
    ASIS SpA - Santo Domingo #550 Santiago - fonos: 22 700 8420 - 9 658 82332 - www.deportesasis.cl
  </footer>    
   <!-- <div style="page-break-after:always;"></div>
        <H4>ESTA ES PAGINA 2</H4>
        -->
        
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>        
    </body>
</html>