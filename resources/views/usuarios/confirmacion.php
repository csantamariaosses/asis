<!doctype html>
<html>
<head><title>Asis SpA Confirmacion</title></head>
<body>
<div class="container"> 
    <div class="row">
            <div class="col-sm-6">
                <div class="well well-sm">
                 <span style="color:blue">
                Confirmacion: </span>  
                <p>Estimado(a) {{$nombre}}.<br>
                Hemos enviado un email para verificar su direccion de correo, pulse el boton de abajo para confirmar.</p>
                <p><a href="{{ url('usuarios/verificar',$token) }}">Click para confirmar</a>
               </p>
                 </div>
            </div>
            <div class="col-sm-6">
                    &nbsp;
            </div>

    </div>
  </div> 
</body>
</html>