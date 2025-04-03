<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CareersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $careers = [
            ['name' => 'ADMINISTRACION DE EMPRESAS', 'description' => 'Program focused on business management.', 'faculty_id' => 1],
            ['name' => 'ADMINISTRACIÓN DE EMPRESAS C.I', 'description' => 'Specialized in international business management.', 'faculty_id' => 1],
            ['name' => 'ADMINISTRACIÓN EN SEGURIDAD Y SALUD EN EL TRABAJO', 'description' => 'Focus on workplace safety and health.', 'faculty_id' => 1],
            ['name' => 'CONTADURÍA PUBLICA', 'description' => 'Accounting and financial management.', 'faculty_id' => 1],
            ['name' => 'DERECHO', 'description' => 'Law and legal studies.', 'faculty_id' => 2],
            ['name' => 'INGENIERIA AMBIENTAL', 'description' => 'Environmental engineering.', 'faculty_id' => 3],
            ['name' => 'INGENIERIA CIVIL', 'description' => 'Civil engineering.', 'faculty_id' => 3],
            ['name' => 'INGENIERIA DE PROCESOS', 'description' => 'Process engineering.', 'faculty_id' => 3],
            ['name' => 'INGENIERIA DE SISTEMAS', 'description' => 'Systems engineering.', 'faculty_id' => 3],
            ['name' => 'Ingeniería Electrónica', 'description' => 'Electronic engineering.', 'faculty_id' => 3],
            ['name' => 'INGENIERIA INDUSTRIAL', 'description' => 'Industrial engineering.', 'faculty_id' => 3],
            ['name' => 'N/A', 'description' => 'Not applicable.', 'faculty_id' => null],
            ['name' => 'PSICOLOGIA', 'description' => 'Psychology.', 'faculty_id' => 2],
            ['name' => 'TECNOLOGÍA EN CONTROL DE CALIDAD', 'description' => 'Quality control technology.', 'faculty_id' => 3],
            ['name' => 'TECNOLOGIA EN CONTROL ELECTRONICO DE PROCESOS', 'description' => 'Electronic process control technology.', 'faculty_id' => 3],
            ['name' => 'Tecnología en Desarrollo de Software', 'description' => 'Software development technology.', 'faculty_id' => 3],
            ['name' => 'TECNOLOGIA EN GESTION CONTABLE', 'description' => 'Accounting management technology.', 'faculty_id' => 1],
            ['name' => 'TECNOLOGIA EN GESTION DE MARKETING', 'description' => 'Marketing management technology.', 'faculty_id' => 1],
            ['name' => 'TECNOLOGIA EN GESTION DE NEGOCIOS INTERNACIONALES', 'description' => 'International business management technology.', 'faculty_id' => 1],
            ['name' => 'TECNOLOGIA EN Gestión de redes de computadores', 'description' => 'Computer network management technology.', 'faculty_id' => 3],
            ['name' => 'TECNOLOGIA EN GESTION FINANCIERA', 'description' => 'Financial management technology.', 'faculty_id' => 1],
            ['name' => 'TECNOLOGIA EN GESTION LOGISTICA Y PORTUARIA', 'description' => 'Logistics and port management technology.', 'faculty_id' => 1],
            ['name' => 'TECNOLOGIA EN GESTION TURISTICA Y HOTELERA', 'description' => 'Tourism and hotel management technology.', 'faculty_id' => 1],
            ['name' => 'TECNOLOGÍA EN OPERACIÓN DE PLANTAS Y PROCESOS INDUSTRIALES', 'description' => 'Industrial plant operation technology.', 'faculty_id' => 3],
            ['name' => 'TECNOLOGIA EN PRODUCCION INDUSTRIAL', 'description' => 'Industrial production technology.', 'faculty_id' => 3],
            ['name' => 'TECNOLOGIA EN SEGURIDAD E HIGIENE OCUPACIONAL', 'description' => 'Occupational safety and hygiene technology.', 'faculty_id' => 1],
            ['name' => 'Tecnología Gestión Ambiental Industrial', 'description' => 'Industrial environmental management technology.', 'faculty_id' => 3],
            ['name' => 'TRABAJO SOCIAL', 'description' => 'Social work.', 'faculty_id' => 2],
            ['name' => 'ADMINISTRACION EN SEGURIDAD Y SALUD EN EL TRABAJO', 'description' => 'Workplace safety and health administration.', 'faculty_id' => 1],
            ['name' => 'TECNOLOGÍA EN GESTIÓN LOGÍSTICA Y PORTUARIA', 'description' => 'Logistics and port management technology.', 'faculty_id' => 1],
            ['name' => 'Psicología x', 'description' => 'Psychology specialization.', 'faculty_id' => 2],
        ];

        DB::table('careers')->insert($careers);
    }
}
