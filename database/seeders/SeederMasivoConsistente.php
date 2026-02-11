<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

use App\Models\Persona;
use App\Models\Usuario;
use App\Models\Rol;
use App\Models\Empresa;
use App\Models\Edificio;
use App\Models\TipoEspacio;
use App\Models\UnidadEspacio;
use App\Models\EspacioRol;

class SeederMasivoConsistente extends Seeder
{
    public function run()
    {   
        try{
            // Borrar datos anteriores para evitar duplicados
            echo "Borrando datos de tablas...\n";
            EspacioRol::truncate();
            UnidadEspacio::truncate();
            TipoEspacio::truncate();
            Edificio::truncate();
            Empresa::truncate();
            Usuario::truncate();
            Persona::truncate();
            Rol::truncate();

            $faker = Faker::create();

            // -------------------------
            // Roles fijos
            // -------------------------
            $roles = [
                ['cod_rol'=>1,'descripcion'=>'Administrador','activo'=>true],
                ['cod_rol'=>2,'descripcion'=>'Propietario','activo'=>true],
                ['cod_rol'=>3,'descripcion'=>'Inquilino','activo'=>true],
            ];
            echo "Creando roles...\n";
            foreach($roles as $r){
                Rol::Create($r);
            }

            // -------------------------
            // Personas (10)
            // -------------------------
            echo "Creando personas...\n";
            $personas = [];
            for($i=1; $i<=10; $i++){
                $personas[] = Persona::create([
                    'cod_persona' => 'P'.str_pad($i,2,'0',STR_PAD_LEFT),
                    'nombre' => $faker->firstName,
                    'apellido' => $faker->lastName,
                    'fec_nacimiento' => $faker->date(),
                    'estado' => true
                ]);
            }

            // -------------------------
            // Usuarios (5 de 10 personas)
            // -------------------------
            echo "Creando usuarios...\n";
            $usuarios = [];
            for($i=0; $i<5; $i++){
                $usuarios[] = Usuario::create([
                    'cod_usuario' => 'U'.str_pad($i+1,2,'0',STR_PAD_LEFT),
                    'cod_persona' => $personas[$i]->cod_persona,
                    'password' => Hash::make('password'.$i),
                    'estado' => 'A'
                ]);
            }

            // -------------------------
            // Empresas (5)
            // -------------------------
            echo "Creando empresas...\n";
            $empresas = [];
            for($i=0; $i<5; $i++){
                $empresas[] = Empresa::create([
                    'cod_persona' => $personas[$i]->id
                ]);
            }

            // -------------------------
            // Edificios (1 por empresa)
            // -------------------------
            echo "Creando edificios...\n";
            $edificios = [];
            foreach($empresas as $index => $empresa){
                $edificios[] = Edificio::create([
                    'cod_empresa' => $empresa->cod_empresa,
                    'nombre' => 'Edificio '.$index,
                    'ruta_logo' => null,
                    'direccion' => $faker->address,
                ]);
            }

            // -------------------------
            // Tipos de espacios (3)
            // -------------------------
            echo "Creando tipo espacios...\n";
            $tipoNombres = ['Oficina','Sala de reuniones','Cafetería'];
            $tipos = [];
            foreach($tipoNombres as $nombre){
                $tipos[] = TipoEspacio::create([
                    'descripcion' => $nombre
                ]);
            }

            // -------------------------
            // Unidades de espacio (30)
            // -------------------------
            echo "Creando unidad espacios...\n";
            $unidadEspacios = [];
            for($i=0; $i<30; $i++){
                $edificio = $edificios[array_rand($edificios)];
                $tipo = $tipos[array_rand($tipos)];
                $unidadEspacios[] = UnidadEspacio::create([
                    'cod_edificio' => $edificio->cod_edificio,
                    'id_espacio' => $tipo->id_espacio,
                    'nro_piso' => $faker->numberBetween(1,10),
                    'nro_departamento' => $faker->optional()->numberBetween(1,50),
                    'descripcion' => $faker->sentence(4),
                    'estado' => true
                ]);
            }

            // -------------------------
            // Espacio Roles (20, consistente)
            // -------------------------
            echo "Creando espacios roles...\n";
            $espacioRolesCreados = [];
            for($i=0; $i<20; $i++){
                $unidad = $unidadEspacios[array_rand($unidadEspacios)];
                $rol = Rol::inRandomOrder()->first();
                $usuario = $usuarios[array_rand($usuarios)];

                // Evitar duplicados lógicos
                $key = $unidad->cod_edificio.'-'.$unidad->id_unidad_espacio.'-'.$rol->cod_rol;
                if(!isset($espacioRolesCreados[$key])){
                    EspacioRol::create([
                        'cod_edificio' => $unidad->cod_edificio,
                        'id_unidad_espacio' => $unidad->id_unidad_espacio,
                        'cod_rol' => $rol->cod_rol,
                        'cod_usuario' => $usuario->cod_usuario
                    ]);
                    $espacioRolesCreados[$key] = true;
                }
            }

            $this->command->info('Datos masivos consistentes generados correctamente.');
        }catch(\Throwable $e){
            echo "Error al poblar dase de datos ".$e;
        }
    }
}
