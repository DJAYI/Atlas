<x-layouts.dashboard-layout title="Gestión de Eventos">
    <div class="my-4 flex flex-row justify-between items-center">
        <h2 class="text-2xl font-semibold text-green-700">
            Gestión de Eventos
        </h2>

        <button
            class="px-4 py-2 bg-gradient-to-bl to-green-700 from-green-500 text-white font-semibold rounded-lg shadow-md  hover:scale-95 transition"
            popovertarget="create-event">
            Crear Evento
        </button>
    </div>
    <div class="px-4 py-2 flex flex-col bg-gradient-to-b from-green-200/50 to-white rounded-t-xl min-h-52">
        @foreach ($events as $event)
            <div class="flex flex-row justify-between items-center bg-white/90 rounded-lg shadow-md p-4 mb-2">
                <div class="flex flex-col gap-1">
                    <h3 class="text-lg font-semibold text-gray-700">{{ $event->name }}</h3>
                    <p class="text-sm text-gray-500">Código: {{ $event->code }}</p>
                    <p class="text-sm text-gray-500">Fecha: {{ $event->start_date }} - {{ $event->end_date }}</p>
                </div>
                <div class="flex flex-row gap-2">
                    <button
                        class="px-4 py-2 bg-gradient-to-bl to-green-700 from-green-500 text-white font-semibold rounded-lg shadow-md  hover:scale-95 transition"
                        popovertarget="edit-event" popoverdata="{{ $event->id }}">Editar</button>
                    <button
                        class="px-4 py-2 bg-gradient-to-bl to-red-700 from-red-500 text-white font-semibold rounded-lg shadow-md  hover:scale-95 transition"
                        popovertarget="delete-event" popoverdata="{{ $event->id }}">Eliminar</button>
                </div>
            </div>
        @endforeach
    </div>

    <div class="flex flex-row justify-between">
        <h3 class="text-lg font-semibold">Todos los eventos</h3>

        <div class="relative sm:w-1/2">

            <input required type="text" placeholder="Buscar evento"
                class="py-2 pl-10 pr-4 w-full placeholder-gray-500 px-4  bg-white border border-green-300 rounded-lg shadow-sm  transition">
            <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
    </div>
    <br>
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 ">
        <thead class=" text-gray-700 uppercase">
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
    countries="{{ $countries }}" financialEntities="{{ $financialEntities }}"></x-layouts.dashboard-layout>

{{-- Choice.Js util --}}
@vite(['resources/js/modules/utils/multiSelectUtil.js'])
