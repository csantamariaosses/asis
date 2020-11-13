<?php

use Illuminate\Database\Seeder;

class menuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // Desactivamos la revisión de claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;'); 

        // Desactivamos la revisión de claves foráneas 
        DB::table('menus')->truncate();
        DB::table('menus')->insert([
            'ordenMenu' => '1',
            'menu' => 'Inicio',
            'subMenu' => '',
            'pagina' => 'inicio'
        ]);
        DB::table('menus')->insert([
            'ordenMenu' => '2',
            'menu' => 'Productos',
            'subMenu' => 'yoga-y-pilates',
            'pagina' => 'productos'
        ]);
        DB::table('menus')->insert([
            'ordenMenu' => '2',
            'menu' => 'Productos',
            'subMenu' => 'agilidad-y-coordinacion',
            'pagina' => 'productos'
        ]);
        DB::table('menus')->insert([
            'ordenMenu' => '2',
            'menu' => 'Productos',
            'subMenu' => 'Balones',
            'pagina' => 'productos'
        ]);
        DB::table('menus')->insert([
            'ordenMenu' => '2',
            'menu' => 'Productos',
            'subMenu' => 'Vendajes',
            'pagina' => 'productos'
        ]);
        DB::table('menus')->insert([
            'ordenMenu' => '3',
            'menu' => 'Carrito',
            'subMenu' => '',
            'pagina' => 'carrito'
        ]);
        DB::table('menus')->insert([
            'ordenMenu' => '4',
            'menu' => 'Contacto',
            'subMenu' => '',
            'pagina' => 'contacto'
        ]);        
        
        // Reactivamos la revisión de claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;'); 
    }
}
