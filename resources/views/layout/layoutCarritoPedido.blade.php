<!doctype html>
<html>
<head>
<title></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="lenguage" content="es">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="apple-mobile-web-app-capable" content="yes" />
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<style>
@page {
    margin: 100px 25px;
}

header {
    position: fixed;
    top: -60px;
    left: 0px;
    right: 0px;
    height: 50px;

    /** Extra personal styles **/
    background-color: #03a9f4;
    color: white;
    text-align: center;
    line-height: 35px;
}


#titulo {
    font-family:Arial, Helvetica, sans-serif;
    font-size:20px;
}

#infoCliente tr td{
    font-family:Arial, Helvetica, sans-serif;
    font-size:15px;
}

footer {
    position: fixed; 
    bottom: -60px; 
    left: 0px; 
    right: 0px;
    height: 50px; 

    /** Extra personal styles **/
    background-color: #ffffff;
    color: black;
    text-align: center;
    line-height: 15px;
    font-size:15px;
}
</style>    
</head>
<body>
<header>
    <img src="{{asset('storage/header-cotizacion.jpg')}}" width="100%">
</header>  
@yield('content')
<footer>
    ASIS SpA - Santo Domingo #550 Santiago - fonos: 22 700 8420 - 9 658 82332 - www.deportesasis.cl
</footer>    
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>