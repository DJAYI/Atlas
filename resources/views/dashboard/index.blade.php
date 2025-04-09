<x-layouts.dashboard-layout title="Estadísticas">
    <div class="flex flex-row items-center justify-between my-4">
        <h2 class="text-2xl text-pretty h-full  flex items-center font-semibold text-primary-700">
            Gestión de Estadísticas y Reportes
        </h2>
    </div>
    <div class="flex flex-col gap-4 mt-4 h-full">
        <h2 class="text-xl font-semibold my-3 text-primary-700 px-2">Reportes de Movilidad</h2>
        <div class="grid grid-cols-[1fr_20px_1fr] p-8 border rounded-md items-center gap-8">
            <div class="grid grid-cols-1 col-span-1 self-start gap-4 px-3 relative">

                <h2 class="text-lg font-semibold my-3 text-secondary-400 px-2 text-center">Reportes de Movilidad Foránea
                </h2>

                @php
                    $localTypes = [
                        'profesor' => 'Docentes Foráneos',
                        'estudiante' => 'Estudiantes Foráneos',
                        'administrativo' => 'Administrativos Foráneos',
                    ];
                @endphp

                @foreach ($localTypes as $type => $title)
                    <x-report-table :filtered-events="$events->filter(fn($event) => $event->assistances->contains(fn($assistance) => $assistance->person->country->name !== 'COLOMBIA' && $assistance->person->type === $type))" :title="$title" :type="$type" is-colombian="false" />
                @endforeach
            </div>

            <div class="flex-col col-span-1 items-center justify-center hidden md:flex">
                <hr class="min-h-96 w-[1px] bg-gray-300/60">
            </div>

            <div class="grid grid-cols-1 col-span-1 self-start gap-4 px-3 relative">

                <h2 class="text-lg text-center font-semibold my-3 text-secondary-400 px-2">Reportes de Movilidad Local
                </h2>

                @php
                    $localTypes = [
                        'profesor' => 'Docentes Locales',
                        'estudiante' => 'Estudiantes Locales',
                        'administrativo' => 'Administrativos Locales',
                    ];
                @endphp

                @foreach ($localTypes as $type => $title)
                    <x-report-table :filtered-events="$events->filter(fn($event) => $event->assistances->contains(fn($assistance) => $assistance->person->country->name === 'COLOMBIA' && $assistance->person->type === $type))" :title="$title" :type="$type" is-colombian="true" />
                @endforeach
            </div>
        </div>
    </div>
</x-layouts.dashboard-layout>
