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
           @if(session()->has('alert-warning')) 
             <div class="alert alert-warning">
               {{ session()->get('alert-warning') }} 
             </div>
          @endif 
         </div>
    </div>  
  </div> 
  
  <div class="container">
    <div class="row">
        <div class="col-sm-12">
            <a href="#" id="linkRotProds1"><img id="rotativoProductos1" width="100%"></a>
        </div>
    </div>
  </div>

  <div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h3> @php
                 foreach( $ITEM as $elem) {
                    echo  ucfirst( $elem ) . " ";
                 }
                 @endphp
            </h3>
        </div>
    </div>


	
    <div class="row">

    </div>
    <div class="row">
        <div class="col-sm-12">
        <!--   <img src="{{asset('storage/pilates-1-2-3.png')}}" width="100%">  -->
        </div>
    </div>
    <br><hr>    
    
    <div class="row">
          @if( count( $productos) >0 )        
          @foreach($productos as $dato)
          <div class="col-sm-4">
               <div class="thumbnail">
                    <p class="cuadro-imagen"><img src="{{asset('storage')}}/{{$dato->image}}" alt="..." width="200" class="zoom"></p>
                    <div class="caption">
                    <h5>Codigo: {{$dato->idProducto}}</h3> 
                    <h6>{{$dato->nombre}}</h3> 
                    @if( $dato->precio > 0 )
                    <p>${{$dato->precio}}</p>
                    @endif
                   
                  <p>
                  <form name="frm" action="" method="POST">
                      {{csrf_field() }}  
                     <input type="hidden" name="hdAccion" value="agregarAlCarrito">
                     <input type="hidden" name="hdId" value="{{$dato->id}}">
                     <input type="hidden" name="hdIdProducto" value="{{$dato->idProducto}}">
                     <input type="hidden" name="hdNombre" value="{{$dato->nombre}}">
                     <input type="hidden" name="hdPrecio" value="{{$dato->precio}}">
  
                    <a href="#" class="btn btn-default" role="button" data-toggle="modal" data-target="#miModal{{$dato->id}}"><i class="fa fa-eye" aria-hidden="true"></i>  Ver...</a>
                 
                    <!--<button type="button" class="btn btn-default"><i class="fa fa-shopping-cart"></i> Agregar al carrito...</button>-->
                    <a href="{{route('cart-add',$dato->id)}}" class="btn btn-default">Agregar al carrito</a>


                                       
                    
                  </form>
                   @if( strcmp(session()->get('tipo'),'admin' ) == 0 )
                    <button type="button" class="btn btn-default" onClick="location.href='{{action('AdminController@adminProductosEditar',[$dato->id])}}'">Ir a Config...</button>
                   @endif
                </p>
                  </div> <!-- caption -->
                </div> <!-- thum -->


              <!-- Modal -->
              <div class="modal fade" id="miModal{{$dato->id}}" role="dialog">
                <div class="modal-dialog modal-lg">
                
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">{{$dato->nombre}}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="thumbnail">
                        <table align="center">
                            <tr>
                                <td><img src="{{asset('storage')}}/{{$dato->image}}" alt="..." width="400"></td>
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                <td><p><b>Codigo:</b>{{$dato->idProducto}}</p>
                           <p><b>Descripcion:</b><br><?php echo $dato->descripcion;?></p>
                           @if( $dato->precio > 0 )
                              <p><b>Precio:</b>${{$dato->precio}}</p></td>
                           @endif
                           
                            </tr>
                        </table>
                        </div> 
                    </div>
                    <div class="modal-footer">
                        <form name="frm" action="" method="POST">
                            <input type="hidden" name="hdAccion" value="agregarAlCarrito">
                            <input type="hidden" name="hdId" value="{{$dato->id}}">
                            <input type="hidden" name="hdIdProducto" value="{{$dato->idProducto}}">
                            <input type="hidden" name="hdNombre" value="{{$dato->nombre}}">
                            <input type="hidden" name="hdPrecio" value="{{$dato->precio}}">

                            <a href="{{route('cart-add',$dato->id)}}" class="btn btn-default">Agregar al carrito</a>
                      <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times-circle" aria-hidden="true"></i>  Cerrar</button>


                        </form> 
                    </div>
                  </div>
                  
                </div>
              </div>
        </div>
            
          
                
          @endforeach 
       @else
           <br><h4>No Existen Productos En Su Busqueda</h4>
       
       @endif
        </div>

    </div>
 </div>

@endsection

@section('jQueryContent')
<script>
    $(document).ready(function() {
        //alert("Settings page was loaded");
        //rotar_imagen_productos();
       rotar_imagen_productos();
    });
</script>
@endsection