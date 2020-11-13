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
             <p><h3>Editando Producto Catalogo -> Productos</h3></p>
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
             <div class="well well-sm">
              
              <img src="{{asset('storage')}}/{{$archImage}}" width="200"><br>
            <br>
              </div>
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
               <p class="alert alert-success">{{ session()->get('flash-message-success') }} </p>
             </div>
          @endif           
          @if(session()->has('flash-message-warning')) 
             <div class="flash-message-warning">
               <p class="alert alert-warning" align="center"><span style="color:red">{{ session()->get('flash-message-warning') }}</span>
             </div>
          @endif 
         </div>
    </div> 
</div>



<div class="container">
    <div class="row">
        <div class="col-sm-2">
        </div>
        <div class="col-sm-6">
          <form name="fm" id="frm" action="{{route('catalogo-to-productos-guardar')}}" method="POST">
           {{ csrf_field() }}
           <input type="hidden" name="image" value="{{$archImage}}">
            <input type="hidden" name="id" value="{{$id}}">
              <br>
              <table class="table-bordered" width="50%">
                  <tr>
                      <th><td>Menu</td></th>
                      <td><select name="menu"><option valure="productos">Productos</option></select></td>
                  </tr>
                  <tr>
                      <th><td>SubMenu</td></th>
                      <td>
                        <select name="subMenu">
                          @for($i=0; $i < count($subMenu); $i++)
                            @if( strcmp($subMenu[$i]->subMenu, $subMenuSel) == 0 ) {
                                <option value="{{$subMenu[$i]->subMenu}}" selected>{{$subMenu[$i]->subMenu}}</option>
                            @else
                                <option value="{{$subMenu[$i]->subMenu}}">{{$subMenu[$i]->subMenu}}</option>
                            @endif

                          @endfor
                        

                      </select></td>
                  </tr>

          
              <tr><th><td>Id</td></th><td>{{$id}}</td></tr>
              <tr><th><td>Codigo</td></th><td><input type="text" name="idProducto" id="idProducto" value="{{$prod->idProducto}}" required></td></tr>
              <tr><th><td>Nombre</td></th><td><input type="text" name="nombre" id="nombre" value="{{$prod->nombre}}" required size="40"></td></tr>
              <tr><th><td>Descripcion</td></th><td><textarea name="descripcion" id="descripcion" rows="5" cols="50">{{$prod->descripcion}}</textarea></td></tr>
              <tr><th><td>Precio</td></th><td><input type="number" name="precio" id="precio" value="{{$prod->precio}}" required></td></tr>
              <tr><th><td>image</td></th><td><input type="text" name="image" id="image" value="{{$prod->image}}" required disabled size="40"></td></tr>

               <tr><th><td></td></th><td><input type="submit" name="btnSubmit" value="Guardar"></td></tr>

          </table>
          
          </form>
      </div>
      <div class="col-sm-4"></div>
  </div>
        
</div>
  
@endsection