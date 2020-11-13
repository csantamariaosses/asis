@extends('layout.layoutCarritoInterno')

@section('content')
    <table class="table table-hover table-striped width="100%">
        <thead>
            <tr>
                <th>Proveedor</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Subtotal</th>                
            </tr>                            
        </thead>
        <tbody>
            @php
            $cantidad = 0;
            $total = 0;
            @endphp
            @foreach($carritoInterno as $dato)
            @php
              $cantidad =  $cantidad + $dato['cantidad'];
              $total    = $total + $dato['subtotal']
            @endphp
            <tr>
                <td>{{ $dato['proveedor'] }}</td>
                <td>{{ $dato['producto'] }}</td>
                <td align='center'>{{ $dato['cantidad'] }}</td>
                <td align='right'>{{ number_format($dato['precio']) }}</td>
                <td align='right'>{{ number_format($dato['subtotal'],0) }}</td>                
            </tr>
            @endforeach
            <tr><td></td><td></td><td align='center'><b>{{$cantidad}}</b></td><td></td><td align='right'><b>{{number_format($total,0)}}</b></td></tr>
        </tbody>
    </table>
@endsection