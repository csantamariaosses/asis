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
             <div class="well well-sm">
              
              <img src="{{asset('storage')}}/{{$archImage}}" width="200"><br>
              
              <form name="fmImage" id="frmImage" action="{{action('AdminController@cargaImage')}}" method="POST" enctype="multipart/form-data">
                 {{ csrf_field() }}
                   <input type="hidden" name="id" id="id" value="{{ $id }}">
                   <p><span style="color:blue">Favor seleccionar archivo de los tipos: png,jpg,gif.</span></p>
                <input type="hidden" name="accion" id="accion" value="cargaImage">
                <input type="hidden" name="archImage" id="archImage" value="{{$archImage}}">
                <input type="hidden" name="subMenu" value="{{$subMenuSel}}">
                <input type="file" name="archivo" id="archivo">
                <input type="submit" name="btnSubmit" value="Carga Nueva Imagen">
              </form>
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
        <div class="col-sm-2">
        </div>
        <div class="col-sm-6">
          <form name="fm" id="frm" action="{{action('AdminController@adminProductosUpdate')}}" method="POST">
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
              <tr><th><td>image</td></th><td><input type="text" name="image" id="image" value="{{$archImage}}" required disabled size="40"></td></tr>
              <tr><th><td>Visible</td></th><td>
                  {{$prod->visible}}
                  <select name="visible">
                      
                      @if( $prod->visible == 1 ) {
                      <option value="1" selected>Visible</option>
                      <option value="0">No Visible</option>
                      @endif
                      @if( $prod->visible == 0 ) {
                      <option value="1">Visible</option>
                      <option value="0" selected>No Visible</option>
                      @endif
                      
                  </select>
                  </td>
               </tr>
                <tr><th><td>Stock</td></th><td>
                    {{$prod->stock}}
                  <select name="stock">
                      @if( $prod->stock == 1 ) {
                      <option value="1" selected>Con Stock</option>
                      <option value="0">Sin Stock</option>
                      @endif
                      @if( $prod->stock == 0 ) {
                      <option value="1">Con Stock</option>
                      <option value="0" selected>Sin Stock</option>
                      @endif
                      
                  </select>
                  </td>
               </tr>
               <tr><th><td></td></th><td><input type="submit" name="btnSubmit" value="Actualizar"></td></tr>

          </table>
          
          </form>
      </div>
      <div class="col-sm-4"></div>
  </div>
        
</div>
  
@endsection