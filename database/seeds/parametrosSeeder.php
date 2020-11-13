<?php

use Illuminate\Database\Seeder;

class parametrosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Desactivamos la revisión de claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;'); 

        // Desactivamos la revisión de claves foráneas 
        DB::table('parametros')->truncate();
        

        DB::table('parametros')->insert([
            'rut' => '76838196-8',
            'nombre' => 'Deportes Asis',
            'email' => 'contacto@asis.cl',
            'fonoContacto' => '+56 9 65882332',
            'fonoWhasap' => '+56 9 65882332',
            'direccion' => 'Ismael Valdes Vergara 670',
            'direccionWeb' => 'www.deportesasis.cl',
            'hostMail' => 'mail.csantamariao.cl',
            'hostMailUser' => 'user',
            'hostMailPass' => 'pass'
 
        ]);
        
        // Reactivamos la revisión de claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;'); 
    }
}
