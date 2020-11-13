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
    <br><br><br>
    <div class="row">
            <div class="col-sm-6">
                <div class="well well-sm">
                 <span style="color:blue">
                <p>Estiamdo(a) {{$nombre}}, su sesi&oacute;n ha finalizado.</p>
                <p>Atte.Asis</p>

                 </div>
            </div>
            <div class="col-sm-6">
                    &nbsp;
            </div>

    </div>
  </div> 
@endsection