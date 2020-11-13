<?php

use Illuminate\Database\Seeder;

class usuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;'); 

        // Desactivamos la revisión de claves foráneas 
        //DB::table('usuarios')->truncate();
        DB::table('usuarios')->insert([
            'nombre' => 'Jacinto',
            'email' => 'asisfba@gmail.com',
            'tipo' => 'admin',
            'password' => md5('jacinto')
        ]);
        DB::table('usuarios')->insert([
            'nombre' => 'Carlos SantaM',
            'email' => 'cssantam@gmail.com',
            'tipo' => 'usuario',
            'password' => md5('123')
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;'); 
    }
}
