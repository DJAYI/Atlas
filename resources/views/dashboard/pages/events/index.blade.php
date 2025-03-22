<x-layouts.dashboard-layout title="Gestión de Eventos">
    <div class="flex flex-row items-center justify-between my-4">
        <h2 class="text-2xl font-semibold text-green-700">
            Gestión de Eventos
        </h2>

        <button
            class="px-4 py-2 font-semibold text-white transition rounded-lg shadow-md bg-gradient-to-bl to-green-700 from-green-500 hover:scale-95"
            popovertarget="create-event">
            Crear Evento
        </button>
    </div>
    <div class="flex flex-col px-4 py-2 bg-gradient-to-b from-green-200/50 to-white rounded-t-xl min-h-52">
        @foreach ($events as $event)
            <div class="flex flex-row items-center justify-between p-4 mb-2 rounded-lg shadow-md bg-white/90">
                <div class="flex flex-col gap-1">
                    <h3 class="text-lg font-semibold text-gray-700">{{ $event->name }}</h3>
                    <p class="text-sm text-gray-500">Código: {{ $event->code }}</p>
                    <p class="text-sm text-gray-500">Fecha: {{ $event->start_date }} - {{ $event->end_date }}</p>
                </div>
                <div class="flex flex-row gap-2">
                    <button
                        class="px-4 py-2 font-semibold text-white transition rounded-lg shadow-md bg-gradient-to-bl to-green-700 from-green-500 hover:scale-95"
                        popovertarget="edit-event" popoverdata="{{ $event->id }}">Editar</button>
                    <button
                        class="px-4 py-2 font-semibold text-white transition rounded-lg shadow-md bg-gradient-to-bl to-red-700 from-red-500 hover:scale-95"
                        popovertarget="delete-event" popoverdata="{{ $event->id }}">Eliminar</button>
                </div>
            </div>
        @endforeach
    </div>

    <div class="flex flex-row justify-between">
        <h3 class="text-lg font-semibold">Todos los eventos</h3>

        <div class="relative sm:w-1/2">

            <input required type="text" placeholder="Buscar evento"
                class="w-full px-4 py-2 pl-10 pr-4 placeholder-gray-500 transition bg-white border border-green-300 rounded-lg shadow-sm">
            <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
    </div>
    <br>
    <table class="w-full text-sm text-left text-gray-500 rtl:text-right ">
        <thead class="text-gray-700 uppercase ">
            <tr>
                <th scope="col" class="px-6 py-3">Nombre</th>
                <th scope="col" class="px-6 py-3">Código</th>
                <th scope="col" class="px-6 py-3">Horario</th>
                <th scope="col" class="px-6 py-3">Fecha</th>
                <th scope="col" class="px-6 py-3">Responsable</th>
                <th scope="col" class="px-6 py-3">Estado</th>
                <th scope="col" class="px-6 py-3">Acciones</th>
            </tr>
        </thead>
    </table>

    <x-modals.create-event-modal />

</x-layouts.dashboard-layout universities="{{ $universities }}" agreements="{{ $agreements }}"
    activities="{{ $activities }}"></x-layouts.dashboard-layout>

{{-- Choice.Js util --}}
@vite(['resources/js/modules/utils/multiSelectUtil.js'])
