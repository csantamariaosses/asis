<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});




Route::get('/', [
     'as' => '/',
     'uses' => 'homeController@index'
]);

Route::get('/home', "homeController@index");
Route::get('home', "homeController@index");
Route::get('home', [
     'as' => 'home',
     'uses' => 'homeController@index'
]);

Route::get('/usuarios', "UsuariosController@index");
Route::post('/usuarios/acceso', "UsuariosController@acceso");
Route::get('/usuarios/salir', "UsuariosController@salir");
Route::post('/usuarios/registo', "UsuariosController@registro");

Route::get('/usuarios/confirma', "UsuariosController@confirmaEmail");


Route::get('/usuarios/olvidoPassword', "UsuariosController@olvidoPassword");
Route::post('/usuarios/olvidoPasswordEnvioCorreo', "UsuariosController@olvidoPasswordEnvioCorreo");
Route::get('/usuarios/resetPassword', "UsuariosController@resetPassword");
Route::get('/usuarios/nuevaPassword', "UsuariosController@nuevaPassword");
Route::post('/usuarios/updateNuevaPassword', "UsuariosController@updateNuevaPassword");


Route::get('/usuarios/wellcome',[
     'as' => 'usuarios-wellcome',
     'uses' => 'UsuariosController@index'
]);


Route::post('/usuarios/updateInfo',[
     'as' => 'usuarios-update',
     'uses' => 'UsuariosController@updateInfo'

]);


Route::post('productos/buscar', [
     'as' => 'productos-buscar',
     'uses' => 'ProductosController@buscar'
]);


Route::get('/usuarios/modificaDatos/{id}',[
    'as' => 'usuarios-modifica-datos',
    'uses' => 'UsuariosController@modificaDatosUsuarios'
]);

/*
Route::get('/usuarios/confirmaEmail/{email}{token}',[
    'as' => 'usuarios-email-confirma',
    'uses' => 'UsuariosController@usuarioEmailConfirma'
]);
*/

Route::get('/admin', "AdminController@index");
Route::get('/admin/salir', "AdminController@salir");
Route::get('/admin/menu', "AdminController@adminMenu");
Route::get('/admin/usuarios', "AdminController@adminUsuarios");
Route::get('/admin/productos', "AdminController@adminProductos");
Route::get('/admin/adminParams', "AdminController@adminParams");
Route::get('/admin/adminProveedores', "AdminController@adminProveedores");



Route::get('/admin/proveedores/nuevo',[
    'as'   => 'admin-proveedores-nuevo',
    'uses' => 'AdminController@adminProveedoresNuevo'     
]);

Route::post('/admin/proveedores/save',[
    'as'   => 'admin-proveedores-save',
    'uses' => 'AdminController@adminProveedoresSave'     
]);

Route::get('/admin/proveedores/editar/{id}',[
    'as'   => 'admin-proveedores-editar',
    'uses' => 'AdminController@adminProveedoresEditar'     
]);

Route::post('/admin/proveedores/update',[
    'as'   => 'admin-proveedores-update',
    'uses' => 'AdminController@adminProveedoresUpdate'     
]);

Route::get('/admin/proveedores/eliminar/{id}',[
    'as'   => 'admin-proveedores-eliminar',
    'uses' => 'AdminController@adminProveedoresEliminar'     
]);


Route::get('/admin/proveedores/',[
    'as'   => 'admin-proveedor-edit-cancelar',
    'uses' => 'AdminController@adminProveedores'     
]);

Route::post('/admin/proveedores/buscar}',[
    'as'   => 'admin-proveedores-buscar',
    'uses' => 'AdminController@adminProveedoresBuscar'     
]);





Route::get('/admin/menu',[
    'as'   => 'admin-menu',
    'uses' => 'AdminController@adminMenu'     
]);


Route::get('/admin/menu/nuevo',[
    'as'   => 'admin-menu-nuevo',
    'uses' => 'AdminController@adminMenuNuevo'     
]);


Route::post('/admin/menu/save',[
    'as'   => 'admin-menu-save',
    'uses' => 'AdminController@adminMenuSave'     
]);

Route::get('/admin/menu/editar/{id}',[
    'as'   => 'admin-menu-editar',
    'uses' => 'AdminController@adminMenuEditar'     
]);


Route::post('/admin/menu/update',[
    'as'   => 'admin-menu-update',
    'uses' => 'AdminController@adminMenuUpdate'     
]);


Route::get('/admin/menu/eliminar/{id}',[
    'as'   => 'admin-menu-eliminar',
    'uses' => 'AdminController@adminMenuEliminar'     
]);




Route::post('/admin/productos/buscar',[
    'as'   => 'admin-productos-buscar',
    'uses' => 'AdminController@adminProductosBuscar'    
]);






/* Admin Cotizaciones */
Route::get('/admin/cotizaciones',[
    'as'   => 'admin-cotizaciones-listar',
    'uses' => 'AdminController@adminCotizacionesListar'     
]);

Route::get('/admin/cotizaciones/add/{idProducto}',[
    'as'   => 'admin-cotizaciones-add',
    'uses' => 'AdminController@adminCotizacionesAddProductoFromCatalogo'     
]);

Route::get('/admin/cotizaciones/nuevo',[
    'as'   => 'admin-cotizaciones-nueva',
    'uses' => 'AdminController@adminCotizacionesNueva'     
]);

Route::get('/admin/cotizaciones/editar/{id}',[
    'as'   => 'admin-cotizaciones-editar',
    'uses' => 'AdminController@adminCotizacionesEditar'     
]);

Route::get('/admin/cotizaciones/delete/{id}',[
    'as' => 'admin-cotizaciones-delete-producto',
    'uses' => 'AdminController@adminCotizacionesDeleteProducto'
]);

Route::post('/admin/cotizaciones/save',[
    'as' => 'admin-cotizaciones-saveInfoClie',
    'uses' => 'AdminController@adminCotizacioneSave'
]);

Route::post('/admin/cotizaciones/saveNew',[
    'as' => 'admin-cotizaciones-saveInfoClieNew',
    'uses' => 'AdminController@adminCotizacionesSaveInfoClieNew'
]);

Route::post('/admin/cotizaciones/addManual',[
    'as' => 'admin-cotizaciones-addManual',
    'uses' => 'AdminController@adminCotizacionesAddManual'
]);

Route::post('/admin/cotizaciones/update',[
    'as' => 'admin-cotizaciones-update-producto',
    'uses' => 'AdminController@adminCotizacionesUpdateProducto'
]);

Route::post('/admin/cotizaciones/buscar',[
    'as' => 'admin-cotizaciones-buscar',
    'uses' => 'AdminController@adminCotizacionesBuscar'
]);








/* Admin Cotizaciones Internas  */
Route::get('/admin/cotizacionesinternas',[
    'as'   => 'admin-cotizacionesinternas-listar',
    'uses' => 'AdminController@adminCotizacionesInternasListar'     
]);

Route::get('/admin/cotizacionesinternas/add/{idProducto}',[
    'as'   => 'admin-cotizacionesinternas-add',
    'uses' => 'AdminController@adminCotizacionesInternasAddProductoFromCatalogo'     
]);

Route::get('/admin/cotizacionesinternas/nuevo',[
    'as'   => 'admin-cotizacionesinternas-nueva',
    'uses' => 'AdminController@adminCotizacionesInternasNueva'     
]);

Route::get('/admin/cotizacionesinternas/editar/{id}',[
    'as'   => 'admin-cotizacionesinternas-editar',
    'uses' => 'AdminController@adminCotizacionesInternasEditar'     
]);

Route::get('/admin/cotizacionesinternas/delete/{id}',[
    'as' => 'admin-cotizacionesinternas-delete-producto',
    'uses' => 'AdminController@adminCotizacionesInternasDeleteProducto'
]);

Route::post('/admin/cotizacionesinternas/save',[
    'as' => 'admin-cotizacionesinternas-saveInfoClie',
    'uses' => 'AdminController@adminCotizacioneInternasSave'
]);

Route::post('/admin/cotizacionesinternas/saveNew',[
    'as' => 'admin-cotizacionesinternas-saveInfoClieNew',
    'uses' => 'AdminController@adminCotizacionesInternasSaveInfoClieNew'
]);

Route::post('/admin/cotizacionesinternas/addManual',[
    'as' => 'admin-cotizacionesinternas-addManual',
    'uses' => 'AdminController@adminCotizacionesInternasAddManual'
]);

Route::post('/admin/cotizacionesinternas/update',[
    'as' => 'admin-cotizacionesinternas-update-producto',
    'uses' => 'AdminController@adminCotizacionesInternasUpdateProducto'
]);

Route::post('/admin/cotizacionesinternas/buscar',[
    'as' => 'admin-cotizacionesinternas-buscar',
    'uses' => 'AdminController@adminCotizacioneInternasBuscar'
]);

Route::get('/admin/cotizacionesinternas/descargar/{id}',[
    'as' => 'admin-cotizacionesinternas-descargar',
    'uses' => 'AdminController@adminCotizacionesInternasDescargar'
]);

Route::get('/admin/cotizacionesinternas/eliminar/{id}',[
    'as' => 'admin-cotizacionesinternas-eliminar-cotiz',
    'uses' => 'AdminController@adminCotizacionesInternasEliminarCotiz'
]);

Route::get('/admin/cotizacionesinternas/ver/{id}',[
    'as' => 'admin-cotizacionesinternas-ver',
    'uses' => 'AdminController@adminCotizacionesInternasVer'
]);





Route::post('cartcotizacion/update',[
    'as' => 'cart-cotizacion-update',
    'uses' => 'CotizacionController@update'
]);




Route::get('/admin/cotizaciones/ver/{id}',[
    'as'   => 'admin-cotizaciones-ver',
    'uses' => 'AdminController@adminCotizacionesVer'     
]);

Route::get('/admin/cotizaciones/descargar/{id}',[
    'as'   => 'admin-cotizaciones-descargar',
    'uses' => 'AdminController@adminCotizacionesDescargar'     
]);


Route::get('/admin/cotizaciones/eliminar/{id}',[
    'as'   => 'admin-cotizaciones-eliminar-cotiz',
    'uses' => 'AdminController@adminCotizacionesEliminarCotiz'     
]);





/* Admin Carrito Pedidos */
Route::get('/admin/carritopedidos',[
    'as'   => 'admin-carrito-pedidos-listar',
    'uses' => 'AdminController@adminCarritoPedidosListar'     
]);

Route::get('/admin/carritopedidos/descargar/{id}',[
    'as'   => 'admin-carrito-pedidos-descargar',
    'uses' => 'AdminController@adminCarritoPedidosDescargar'     
]);

Route::get('/admin/carritopedidos/eliminar/{id}',[
    'as'   => 'admin-carrito-pedidos-eliminar',
    'uses' => 'AdminController@adminCarritoPedidoEliminar'     
]);


Route::get('/admin/carritopedidos/editar/{id}',[
    'as'   => 'admin-carrito-pedidos-editar',
    'uses' => 'AdminController@adminCarritoPedidoEditar'     
]);


Route::post('/admin/carritopedidos/actualizaestado',[
    'as'   => 'admin-carrito-pedidos-actualizaestado',
    'uses' => 'AdminController@adminCarritoPedidoActualizaEstado'     
]);



/*
Route::post('/admin/cotizaciones/save',[
    'as'   => 'admin-cotizaciones-save',
    'uses' => 'AdminController@adminCotizacionesSave'     
]);



Route::post('/admin/cotizaciones/update',[
    'as'   => 'admin-cotizaciones-update',
    'uses' => 'AdminController@adminCotizacionesUpdate'     
]);



Route::get('/admin/cotizaciones/eliminaritem/{id}',[
    'as'   => 'admin-cotizaciones-eliminar-item',
    'uses' => 'AdminController@adminCotizacionesEliminarItem'     
]);




Route::get('/admin/cotizaciones/cancelar',[
    'as'   => 'admin-cotizaciones-edit-cancelar',
    'uses' => 'AdminController@adminCotizacionesEditarCancelar'     
]);

*/



/*  CATALOGO */
Route::get('/catalogo',[
    'as'   => 'catalogo-index',
    'uses' => 'CatalogoController@index'
]);


Route::post('/catalogo/buscar',[
    'as'   => 'catalogo-productos-buscar',
    'uses' => 'CatalogoController@productosBuscar'
]);


Route::post('/catalogo/cargarImagen',[
    'as'   => 'catalogo-cargaImagen',
    'uses' => 'CatalogoController@adminCatalogoCargaImagen'
]);



Route::post('/catalogo/productos/agregar',[
    'as'   => 'catalogo-productos-agregar',
    'uses' => 'CatalogoController@adminCatalogoProductosAgregar'
]);


Route::post('/catalogo/proveedores/agregar',[
    'as'   => 'catalogo-proveedores-agregar',
    'uses' => 'CatalogoController@adminCatalogoProveedoresAgregar'
]);



Route::get('/catalogo/proveedorestoproductos/agregar/{id}',[
    'as'   => 'catalogo-to-productos-agregar',
    'uses' => 'CatalogoController@adminCatalogoToProductosAgregar'
]);


Route::post('/catalogo/proveedorestoproductos/cargarImagen',[
    'as'   => 'catalogo-to-productos-cargaImagen',
    'uses' => 'CatalogoController@adminCatalogoProveedorToProductosCargaImagen'
]);


Route::post('/catalogo/proveedorestoproductos/guardar',[
    'as'   => 'catalogo-to-productos-guardar',
    'uses' => 'CatalogoController@adminCatalogoProveedorToProductosGuardar'
]);




Route::get('/admin/usuarios',[
    'as'   => 'admin-usuarios',
    'uses' => 'AdminController@adminUsuarios'
]);


Route::get('/admin/usuarios/nuevo',[
    'as'   => 'admin-usuarios-nuevo',
    'uses' => 'AdminController@adminUsuariosNuevo'
]);


Route::post('/admin/usuarios/buscar',[
    'as'   => 'admin-usuarios-buscar',
    'uses' => 'AdminController@adminUsuariosBuscar'
]);


Route::post('/admin/usuarios/nuevoguardar',[
    'as'   => 'admin-usuarios-nuevo-guardar',
    'uses' => 'AdminController@adminUsuariosNuevoGuardar'
]);


Route::get('/admin/usuarios/{id}/editar',[
    'as'   => 'admin-usuarios-editar',
    'uses' => 'AdminController@adminUsuariosEditar'
]);

Route::post('/admin/usuarios/update',[
    'as'   => 'admin-usuarios-update',
    'uses' => 'AdminController@adminUsuariosUpdate'
]);


Route::get('/admin/usuarios/{id}/eliminar',[
    'as'   => 'admin-usuarios-eliminar',
    'uses' => 'AdminController@adminUsuariosEliminar'
]);


Route::post('/admin/params/guardar',[
     'as' => 'admin-params-guardar',
     'uses' => 'AdminController@adminParamsGuardar'
]);


//Route::resource('/admin/productos','AdminController');

Route::get('/admin/productos/nuevo', "AdminController@adminProductosNuevo");
Route::post('/admin/productos/cargaImage', "AdminController@cargaImage");
Route::post('/admin/productos/save', "AdminController@adminProductosSave");
Route::post('/admin/productos/update', "AdminController@adminProductosUpdate");

Route::get('/admin/productos/{id}/editar', "AdminController@adminProductosEditar");
Route::get('/admin/productos/{id}/eliminar', "AdminController@adminProductosEliminar");

Route::get('/productos/show/{item?}', "ProductosController@show"); 


Route::get('productos/index/{item?}', [
     'as' => 'productos-index',
     'uses' => 'ProductosController@show'
]);



Route::bind('producto', function($id) {
    return App\Producto::where('id',$id)->first();
});

/* Carrito de Compras */
Route::get('cart/show',[
    'as' => 'cart-show',
    'uses' => 'CartController@show'
]);

Route::get('cart/add/{producto}',[
    'as' => 'cart-add',
    'uses' => 'CartController@add'
]);

Route::get('cart/delete/{item}',[
    'as' => 'cart-delete',
    'uses' => 'CartController@delete'
]);

Route::get('cart/update/{producto}',[
    'as' => 'cart-update',
    'uses' => 'CartController@update'
]);

Route::get('cart/trash',[
    'as' => 'cart-trash',
    'uses' => 'CartController@trash'
]);

Route::get('cart/pedido',[
    'as' => 'cart-pedido',
    'uses' => 'CartController@pedido'
]);

Route::post('cart/pedido/envia',[
    'as' => 'cart-pedido-envia',
    'uses' => 'CartController@pedidoEnvia'
]);

Route::get('cart/pedido/infoPago',[
    'as' => 'cart-pedido-infoPago',
    'uses' => 'CartController@pedidoInfoPago'
]);




Route::bind('CatalogoProveedor', function($id) {
    return App\CatalogoProveedor::where('id',$id)->first();
});




/* Carrito de CotizaCION */
/*
Route::get('cartcotizacion/show',[
    'as' => 'cart-cotizacion-show',
    'uses' => 'CartcotizacionController@show'
]);

Route::get('cartcotizacion/add/{producto}',[
    'as' => 'cart-cotizacion-add',
    'uses' => 'CotizadorController@add'
]);

Route::get('cartcotizacion/delete/{item}',[
    'as' => 'cart-cotizacion-delete',
    'uses' => 'CartcotizacionController@delete'
]);

Route::get('cartcotizacion/update/{producto}',[
    'as' => 'cart-cotizacion-update',
    'uses' => 'CartcotizacionController@update'
]);

Route::get('cartcotizacion/trash',[
    'as' => 'cart-cotizacion-trash',
    'uses' => 'CartcotizacionController@trash'
]);

Route::get('cartcotizacion/pedido',[
    'as' => 'cart-cotizacion-pedido',
    'uses' => 'CartcotizacionController@pedido'
]);

Route::post('cartcotizacion/pedido/envia',[
    'as' => 'cart-cotizacion-pedido-envia',
    'uses' => 'CartcotizacionController@pedidoEnvia'
]);

*/





/*  CarritoInterno */


/*Route::get('/cartinterno/add/{producto}', "CartinternoController@add");
*/
Route::get('cartinterno/index',[
    'as' => 'cartinterno-listar',
    'uses' => 'CartinternoController@index'
]);


Route::get('cartinterno/create',[
    'as' => 'cartinterno-create',
    'uses' => 'CartinternoController@create'
]);

Route::post('cartinterno/saveCabecera',[
    'as' => 'cartinterno-saveCabecera',
    'uses' => 'CartinternoController@saveCabecera'
]);


Route::get('cartinterno/editar/{codigo}',[
    'as' => 'cartinterno-editar',
    'uses' => 'CartinternoController@editar'
]);



Route::get('cartinterno/add/{id}',[
    'as' => 'cartinterno-add',
    'uses' => 'CartinternoController@add'
]);


Route::get('cartinterno/show',[
    'as' => 'cartinterno-show',
    'uses' => 'CartinternoController@show'
]);


Route::get('cartinterno/store',[
    'as' => 'cartinterno-guardar',
    'uses' => 'CartinternoController@store'
]);


Route::get('cartinterno/delete/{item}',[
    'as' => 'cartinterno-delete',
    'uses' => 'CartinternoController@delete'
]);

Route::get('cartinterno/update',[
    'as' => 'cartinterno-update',
    'uses' => 'CartinternoController@update'
]);

Route::get('cartinterno/trash/{id}',[
    'as' => 'cartinterno-trash',
    'uses' => 'CartinternoController@trash'
]);


Route::get('cartinterno/generarpedido',[
    'as' => 'cartinterno-generarpedido',
    'uses' => 'CartinternoController@generarPedido'
]);



Route::post('cartinterno/pedido/envia',[
    'as' => 'cartinterno-pedido-envia',
    'uses' => 'CartInternoController@pedidoEnvia'
]);


Route::get('cartinterno/pedido/infoPago',[
    'as' => 'cartinterno-pedido-infoPago',
    'uses' => 'CartInternoController@pedidoInfoPago'
]);



/*  Cart Cotiz Cliente */

Route::get('cartcotizacion/',[
    'as' => 'cotizaciones-index',
    'uses' => 'CotizadorController@index'
]);


Route::get('cartcotizacion/add/{id}',[
    'as' => 'cart-cotizacion-add',
    'uses' => 'CotizacionController@add'
]);



Route::post('cartcotizacion/addManual',[
    'as' => 'cart-cotizacion-add-manual',
    'uses' => 'CotizacionController@addManual'
]);



Route::get('cartcotizacion/show',[
    'as' => 'cart-cotizacion-show',
    'uses' => 'CotizacionController@show'
]);


Route::post('cartcotizacion/update',[
    'as' => 'cart-cotizacion-update',
    'uses' => 'CotizacionController@update'
]);



Route::get('cartcotizacion/delete/{id}',[
    'as' => 'cart-cotizacion-delete',
    'uses' => 'CotizacionController@delete'
]);


Route::post('cartcotizacion/saveNew',[
    'as' => 'cart-cotizacion-saveInfoClieNew',
    'uses' => 'CotizacionController@saveNew'
]);


Route::post('cartcotizacion/save',[
    'as' => 'cart-cotizacion-saveInfoClie',
    'uses' => 'CotizacionController@save'
]);

Route::get('cartcotizacion/generarPDF',[
    'as' => 'cart-cotizacion-generarPDF',
    'uses' => 'CotizacionController@generarPDF'
]);

Route::get('cartcotizacion/generarEXC',[
    'as' => 'cart-cotizacion-generarEXC',
    'uses' => 'CotizacionController@generarEXC'
]);

Route::get('cartcotizacion/trash',[
    'as' => 'cart-cotizadcion-trash',
    'uses' => 'CotizacionController@trash'
]);






Route::get('/carrito', "CarritoController@index");
Route::post('/carrito/store', "CarritoController@store");
Route::post('/carrito/{id}/update', "CarritoController@update");
Route::get('/carrito/{id}/destroy', "CarritoController@destroy");
Route::get('/carrito/vaciar', "CarritoController@vaciar");




Route::get('/contacto', "contactoController@index");
Route::post('contacto/enviar', "contactoController@enviar");
//Route::get('/laravel-send-email', 'MailController@sendEMail');
Route::get('sendbasicemail','MailController@basic_email');
Route::get('sendhtmlemail','MailController@html_email');
Route::get('sendattachmentemail','MailController@attachment_email');


//Route::get('/usuarios', "UserController@index");


#Rutas con parámetros
Route::get('/usuarios/{id}', function ($id) {
    //return view('welcome');
    return "Usuario:{$id}";
})->where('id','[0-9]+');


Route::get('/usuarios/nuevo', function () {
    //return view('welcome');
    return "Nuevo Usuario";
});


Route::get('/saludo/{nombre}/{sobrenombre}', function ($nombre, $sobrenombre) {
    //return view('welcome');
    return "Hola {$nombre} tu apodo es {$sobrenombre}";
});


#Rutas con parámetros opcionales
Route::get('/saludo/{nombre}/{sobrenombre?}', function ($nombre, $sobrenombre=null) {
    if( $sobrenombre) {
       return "Hola {$nombre} tu apodo es {$sobrenombre}";	
    } else {
       return "Hola {$nombre}";	
    }
    
});