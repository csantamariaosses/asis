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
          <div class="row">
            <div class="col-sm-6">
                <div class="well well-sm">
                 <h4>Este enlace ha expirado</h4> 
                 </div>
            </div>
            <div class="col-sm-6">

            </div>
        </div>
    </div>
  </div> 
@endsection