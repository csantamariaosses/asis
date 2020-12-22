          <button type="button" class="btn btn-default" onClick="location.href='{{route('admin-menu')}}'">Admin Menu</button>
          <button type="button" class="btn btn-default" onClick="location.href='{{action('AdminController@adminProductos')}}'">Admin Productos</button>
          <button type="button" class="btn btn-default" onClick="location.href='{{route('admin-usuarios')}}'">Admin Usuarios</button>
          <button type="button" class="btn btn-default"  onClick="location.href='{{action('AdminController@adminParams')}}'">Admin Parametros</button>
          <button type="button" class="btn btn-default"  onClick="location.href='{{action('AdminController@adminProveedores')}}'">Admin Proveedores</button>      
          <button type="button" class="btn btn-default"  onclick="location.href='{{route('catalogo-index')}}'">Catalogo Proveedores</button>      
          <button type="button" class="btn btn-default"  onclick="location.href='{{route('admin-cotizaciones-listar')}}'">Cotizaciones Clientes</button>  
          <button type="button" class="btn btn-default"  onclick="location.href='{{route('admin-carrito-pedidos-listar')}}'">Carrito Pedidos Clientes</button>           
          <button type="button" class="btn btn-default"  onclick="location.href='{{route('admin-cotizacionesinternas-listar')}}'">Cotizacion Interna</button> 
          <button type="button" class="btn btn-default"  onclick="location.href='{{route('admin-contactos-listar')}}'">Contactos Clientes</button> 
          <button type="button" class="btn btn-outline-danger"  onClick="location.href='{{action('AdminController@salir')}}'">Salir</button>