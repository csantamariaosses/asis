@extends('layout.layout')

@section('title', 'Deportes Asis')

@section('header')
    <p>Este es el header</p>
@endsection


@section('content')
  <div class="container">
  	<div class="row">
  		<div class="col-sm-4">
  			<a href="#" id="href1"><img id="rotativo1" width="100%"></a>
  		</div>
  		<div class="col-sm-4">
  			 <img src="{{asset('storage/logo_asis_transp.png')}}" id="logo-pag-inicio" width="100%">
  		</div>  		
      <div class="col-sm-4">
           <a href="#" id="href2"><img id="rotativo2" width="100%"></a>
      </div>            
  	</div>
  </div>	


  <div class="container">
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
        <li data-target="#myCarousel" data-slide-to="3"></li>

      </ol>

      <div class="carousel-inner">
        <div class="item active">
         <img src="{{ asset('storage/cuerdasGimnasio.jpg') }}" alt="Cuerdas" style="width:100%;"> 
         <!--<img src="{{ asset('storage/bicis-estaticas.jpg') }}" alt="Los Angeles" style="width:100%;"> -->
        </div>

        <div class="item">
          <img src="{{ asset('storage/hombreGimnasioCrossfit.jpg')}}" alt="Crossfit" style="width:100%;">
        </div>
      
        <div class="item">
          <img src="{{ asset('storage/guantesDeBoxeo.jpg')}}" alt="Guantes Boxeo" style="width:100%;">
        </div>
        
        <div class="item">
          <img src="{{ asset('storage/yoga-2959213_1920.jpg')}}" alt="Yoga" style="width:100%;">
        </div>        
        
        
      </div>

      <a class="left carousel-control" href="#myCarousel" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#myCarousel" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
  </div>


@endsection

@section('jQueryContent')
<script>
    $(document).ready(function() {
        //alert("Settings page was loaded");
        rotar_imagen();
    
      $('.carousel').carousel({
           interval: 5000,
           pause:true,
           wrap:true
      });
      

      $('#myCarousel').carousel();

      // Go to the previous item
      $("#prevBtn").click(function(){
          $("#myCarousel").carousel("prev");
      });
      // Go to the previous item
      $("#nextBtn").click(function(){
          $("#myCarousel").carousel("next");
      });

    });

    
</script>
@endsection