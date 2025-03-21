<?php

namespace Database\Seeders;

use App\Models\FinancialEntity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FinancialEntitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $entities = [
            [
                'name' => 'Recursos IES',
                'description' => 'Instituciones de Educación Superior',
                'code' => 'RIES'
            ],
            [
                'name' => 'Colciencias',
                'description' => 'Departamento Administrativo de Ciencia, Tecnología e Innovación',
                'code' => 'COLC'
            ],
            [
                'name' => 'SENA',
                'description' => 'Servicio Nacional de Aprendizaje',
                'code' => 'SENA'
            ],
            [
                'name' => 'Ministerio del Interior y Justicia',
                'description' => 'Entidad encargada de políticas internas y justicia',
                'code' => 'MIJ'
            ],
            [
                'name' => 'Ministerio de Relaciones Exteriores',
                'description' => 'Encargado de la política exterior colombiana',
                'code' => 'MRE'
            ],
            [
                'name' => 'Ministerio de Hacienda y Crédito Público',
                'description' => 'Entidad rectora de las finanzas públicas',
                'code' => 'MHCP'
            ],
            [
                'name' => 'Ministerio de Defensa Nacional',
                'description' => 'Encargado de la defensa y seguridad nacional',
                'code' => 'MDN'
            ],
            [
                'name' => 'Ministerio de Agricultura y Desarrollo Rural',
                'description' => 'Promueve el desarrollo agropecuario y rural',
                'code' => 'MADR'
            ],
            [
                'name' => 'Ministerio de Protección Social',
                'description' => 'Entidad para la protección social y salud',
                'code' => 'MPS'
            ],
            [
                'name' => 'Ministerio de Minas y Energía',
                'description' => 'Gestiona recursos mineros y energéticos',
                'code' => 'MME'
            ],
            [
                'name' => 'Ministerio de Comercio, Industria y Turismo',
                'description' => 'Promueve desarrollo económico y turístico',
                'code' => 'MCIT'
            ],
            [
                'name' => 'Ministerio de Educación Nacional',
                'description' => 'Encargado del sistema educativo nacional',
                'code' => 'MEN'
            ],
            [
                'name' => 'Ministerio de Ambiente, Vivienda y Desarrollo Territorial',
                'description' => 'Gestiona políticas ambientales y de vivienda',
                'code' => 'MAVD'
            ],
            [
                'name' => 'Ministerio de Comunicaciones',
                'description' => 'Entidad para las telecomunicaciones y TIC',
                'code' => 'MCOM'
            ],
            [
                'name' => 'Ministerio de Transporte',
                'description' => 'Encargado de la infraestructura de transporte',
                'code' => 'MT'
            ],
            [
                'name' => 'Ministerio de Cultura',
                'description' => 'Promueve y preserva la cultura nacional',
                'code' => 'MCUL'
            ],
            [
                'name' => 'Recursos públicos departamentales',
                'description' => 'Recursos administrativos a nivel departamental',
                'code' => 'DPTO'
            ],
            [
                'name' => 'Recursos públicos municipales o distritales',
                'description' => 'Recursos administrativos a nivel municipal',
                'code' => 'MUNI'
            ]
        ];

        foreach ($entities as $entity) {
            FinancialEntity::create($entity);
        }
    }
}
