<!doctype html>
<html>
<title>Deportes Asis</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<meta name="lenguage" content="es">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="apple-mobile-web-app-capable" content="yes" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-xs-6">
                    <img src="{{asset('storage/logo_asis_transp.png')}}" alt="logo-asis" width="150"/>
                </div>
                <div class="col-xs-6">
                    <p>Fecha: {{ date('Y-m-d') }} 
                    </p>
                </div>
            </div>
        </div>
        <br><br><br><br><br><hr>
        <div align="center">
        <p><h3>Cotizacion</h3</p>
        </div>
        <br><br>
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    @yield('content')
                </div>
            </div>
        </div>
       <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script> 
    </body>
</html>