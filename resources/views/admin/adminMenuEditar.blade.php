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
        <div class="col-sm-2">
        </div>
        <div class="col-sm-6">
          <form name="fm" id="frm" action="{{route('admin-menu-update')}}" method="POST">
            <input type="hidden" name="id" id="id" value="{{ $registro->id }}">
           {{ csrf_field() }}
              <br>
              <table class="table-bordered" width="50%">
                 
          
              <tr><th><td>Id</td></th><td>{{ $registro->id }}</td></tr>
              <tr><th><td>ordenMenu</td></th><td><input type="text" name="ordenMenu" id="ordenMenu" value="{{ $registro->ordenMenu }}" required></td></tr>
              <tr><th><td>Menu</td></th><td><input type="text" name="menu" id="menu" value="{{ $registro->menu }}" required size="40"></td></tr>
              <tr><th><td>Posicion Sub Menu</td></th><td><input type="text" name="posSubMenu" id="posSubMenu" value="{{ $registro->posicion }}"></td></tr>
              <tr><th><td>Sub Menu</td></th><td><input type="text" name="subMenu" id="subMenu" value="{{ $registro->subMenu }}"></td></tr>
              <tr><th><td>Pagina</td></th><td><input type="text" name="pagina" id="pagina" value="{{ $registro->pagina }}" required></td></tr>


               <tr><th><td></td></th><td>
               
                <input type="button" name="btnCancelar" value="Cancelar" onClick="location.href='{{route('admin-menu')}}'">
                 <input type="submit" name="btnSubmit" value="Actualizar">
              </td></tr>

          </table>
          
          </form>
      </div>
      <div class="col-sm-4"></div>
  </div>
        
</div>

<br>
<hr>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <table class="table-bordered" width="100%">
                    <th>

                        <td>Id</td>
                        <td>OrdenMenu</td>
                        <td>Menu</td>
                        <td>Posicion</td>
                        <td>subMenu</td>
                        <td>Pagina</td>

                    </th>
                    <tbody>
              
                    @foreach($itemsMenu as $registro)
                    <tr>
                        <td></td>
                        <td>{{$registro->id}}</td>
                        <td>{{$registro->ordenMenu}}</td>
                        <td>{{$registro->menu}}</td>
                        <td>{{$registro->posicion}}</td>
                        
                        <td>{{$registro->subMenu}}</td>
                        <td>{{$registro->pagina}}</td>                        
                                
                    </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>  
  
@endsection


