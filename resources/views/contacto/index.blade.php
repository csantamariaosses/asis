@extends('layout.layout')

@section('title', 'Deportes Asis')

@section('header')
    <p>Este es el header</p>
@endsection

@section('content')
  <div class="container">
    <form name="frm" id="frm" action="{{ action('contactoController@enviar') }}" method="POST">

       {{ csrf_field() }}
<input type="hidden" name="hd_accion" id="hd_accion" value="enviar">

            <div class="container">
            <div class="row">
               <div class="col-sm-7 text-center">
              <legend class="text-center header"><span style="color:#6E6E6E">Contáctenos</legend>
              </div>
            </div>

<div class="row">
<div class="col-sm-7 text-center">
<div class="input-group">
  <span class="input-group-addon"><i class="fa fa-user fa-fw bigicon" ></i></span>
  <input class="form-control" type="text" id="name" name="name" id="name"  placeholder="Nombre" required>
</div>
</div>
</div>

<div class="row">
<div class="col-sm-7 text-center">
<div class="input-group margin-bottom-sm">
  <span class="input-group-addon"><i class="fa fa-envelope-o fa-fw bigicon"></i></span>
  <input class="form-control" type="text" id="email" name="email" placeholder="Correo electronico" required>
</div>
</div>
</div>

<div class="row">
<div class="col-sm-7 text-center">
<div class="input-group margin-bottom-sm">
  <span class="input-group-addon"><i class="fa fa-phone-square fa-fw bigicon"></i></span>
  <input class="form-control" type="text" id="telefono" name="telefono" placeholder="Telefono">
</div>
</div>
</div>


<div class="row">
<div class="col-sm-7 text-center">  
<div class="input-group margin-bottom-sm">
  <span class="input-group-addon"><i class="fa fa-pencil-square-o fa-fw bigicon"></i></span>
   <textarea class="form-control" id="message" name="message" placeholder="Ingrese su mensaje aqui." rows="5" cols="35" required></textarea>
</div>
</div>
</div>

<div class="row">
  <div class="col-sm-7 text-center">  
    <div class="input-group margin-bottom-sm">
        <span class="input-group-addon"><i class="fa fa-pencil-square-o fa-fw bigicon"></i></span>
         <div class="g-recaptcha"  data-sitekey="{{env('GOOGLE_RECAPTCHA_KEY','xxx')}}">
         </div>
    </div>
   </div>
</div>



<br>
        <div class="row">
         <div class="col-md-12 text-center">
         </div>
         <div  class="col-md-8">
           <input type="submit" class="btn btn-success" onClick="validar();" value="Enviar">
         </div>
       </div>
       </div>
  </form>
  </div> 
@endsection