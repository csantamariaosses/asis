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
    <div class="row">
            <div class="col-sm-6">
                <div class="well well-sm">
                 <span style="color:blue">
                Email Confirmado: </span>  
                <p>Estiamdo(a) {{$nombre}}, su email ha sido confirmado, le invitamos a navegar por nuestro portal.</p>
                <p>Atte. Asis SpA</p>
                 </div>
            </div>
            <div class="col-sm-6">
                    &nbsp;
            </div>

    </div>
  </div> 
@endsection