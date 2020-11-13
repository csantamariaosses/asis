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
             <img src="{{'storage/user-icon1.jpg'}}" width="100">
         </div>
         <div class="col-sm-3">
         </div>
         <div class="col-sm-3">
             
         </div>
      </div>
      <div class="row">
         <div class="col-sm-6">
             <div class="well well-sm">
             Bienvenido (a) : {{session()->get('usuario')}};
         
                </div>   
             </form>
             </div>
         </div>
     </div>
</div>
    
<div class="container">
    <div class="row">
        <div class="cols-sm-12">

        </div>
    </div>
    
</div>
  
@endsection