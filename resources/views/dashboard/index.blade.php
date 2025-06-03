<x-layouts.dashboard-layout title="Estadísticas">
    <div class="flex flex-row items-center justify-between my-4">
        <h2 class="flex items-center h-full text-2xl font-semibold text-pretty text-primary-700">
            Gestión de Estadísticas y Reportes
        </h2>
    </div>


    <livewire:dashboard-sparks />

    <div class="flex flex-col gap-2">
        <livewire:dashboard-charts />

        <livewire:dashboard-map />
    </div>

    <div class="flex flex-col items-center w-full ">
        <div class="flex items-center justify-between w-full px-4 py-2 mt-4 bg-white rounded-lg border">
            <h2 class="text-2xl font-semibold text-pretty text-primary-700">
                Reporte Completo de Asistencias
            </h2>
            <div class="flex items-center gap-2">
                <button
                    class="px-4 py-2 font-semibold text-white transition rounded-lg bg-gradient-to-tr from-blue-500 to-blue-700 hover:shadow-[1px_1px_20px] hover:shadow-blue-400/65 hover:bg-blend-darken hover:bg-primary-500">Generar
                    Reporte</button>
            </div>

        </div>
        <div class="overflow-x-auto max-w-full">
            <table class="text-sm text-gray-500 rounded-lg text-center">
                <thead>
                    <tr class="px-2 py-1 text-sm font-semibold text-gray-700 uppercase bg-gray-100">
                        <th class="px-2 py-1 border">FECHA</th>
                        <th class="px-2 py-1 border">GENERO</th>
                        <th class="px-2 py-1 border">COMUNIDAD</th>
                        <th class="px-2 py-1 border">CORREO ELECTRÓNICO</th>
                        <th class="px-2 py-1 border">NOMBRE Y APELLIDOS</th>
                        <th class="px-2 py-1 border">TIPO DE IDENTIFICACIÓN</th>
                        <th class="px-2 py-1 border">N° IDENTIFICACIÓN</th>
                        <th class="px-2 py-1 border">FECHA DE NACIMIENTO</th>
                        <th class="px-2 py-1 border">TELÉFONO</th>
                        <th class="px-2 py-1 border">INSTITUCIÓN</th>
                        <th class="px-2 py-1 border">PROGRAMA</th>
                        <th class="px-2 py-1 border">DEPENDENCIA</th>
                        <th class="px-2 py-1 border">CARGO</th>
                        <th class="px-2 py-1 border">SEMESTRE</th>
                        <th class="px-2 py-1 border">TIPO DE MOVILIDAD</th>
                        <th class="px-2 py-1 border">TIPO DE PARTICIPACION</th>
                        <th class="px-2 py-1 border">NOMBRE DEL EVENTO</th>
                        <th class="px-2 py-1 border">NACIONALIDAD</th>
                        <th class="px-2 py-1 border">E/S</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Aquí puedes iterar sobre los datos de asistencias para mostrar las filas --}}
                </tbody>
            </table>
        </div>
    </div>

    <details open class="flex flex-col open:[&>summary]:bg-primary-400 open:[&>summary]:text-white mt-4 h-full gap-4 ">
        <summary
            class="flex items-center px-3 py-2 text-lg font-semibold transition duration-75 border rounded-lg cursor-pointer text-pretty text-primary-700 hover:bg-primary-400 hover:text-white">
            <h2 class="text-2xl font-semibold text-pretty">
                Reportes de SNIES</h2>
        </summary>
        <div class="grid grid-cols-[1fr_20px_1fr] p-8 -mt-6 border-x border-b rounded-md items-center gap-8">
            <div class="relative grid self-start grid-cols-1 col-span-1 gap-4 px-3">

                <h2 class="px-2 my-3 text-lg font-semibold text-center text-secondary-400">Reportes de SNIES Movilidad
                    del Exterior hacia Colombia
                </h2>

                @php
                    $localTypes = [
                        'profesor' => 'Movilidad de Docentes del Exterior hacia Colombia',
                        'estudiante' => 'Movilidad de Estudiantes del Exterior hacia Colombia',
                        'administrativo' => 'Movilidad de Administrativos del Exterior hacia Colombia',
                    ];
                @endphp

                @foreach ($localTypes as $type => $title)
                    <x-report-table :filtered-events="$events->filter(fn($event) => $event->modality === 'presencial' && $event->assistances->contains(fn($assistance) => $assistance->person->country->name !== 'Colombia' && $assistance->person->type === $type))" :title="$title" :type="$type" is-colombian="false" />
                @endforeach
            </div>

            <div class="flex-col items-center justify-center hidden col-span-1 md:flex">
                <hr class="min-h-96 w-[1px] bg-gray-300/60">
            </div>

            <div class="relative grid self-start grid-cols-1 col-span-1 gap-4 px-3">

                <h2 class="px-2 my-3 text-lg font-semibold text-center text-secondary-400">Reportes de SNIES Movilidad
                    hacia el Exterior
                </h2>

                @php
                    $localTypes = [
                        'profesor' => 'Movilidad de Docentes hacia el Exterior',
                        'estudiante' => 'Movilidad de Estudiantes hacia el Exterior',
                        'administrativo' => 'Movilidad de Administrativos hacia el Exterior',
                    ];
                @endphp

                @foreach ($localTypes as $type => $title)
                    <x-report-table :filtered-events="$events->filter(fn($event) =>  $event->modality === 'presencial' && $event->assistances->contains(fn($assistance) => $assistance->person->country->name === 'Colombia' && $assistance->person->type === $type))" :title="$title" :type="$type" is-colombian="true" />
                @endforeach
            </div>
        </div>
    </details>

</x-layouts.dashboard-layout>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
