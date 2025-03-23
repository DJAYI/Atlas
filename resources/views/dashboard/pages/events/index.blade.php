@php
    $events = $events->sortByDesc('created_at');
@endphp

<x-layouts.dashboard-layout title="Gestión de Eventos">
    <div class="flex flex-row items-center justify-between my-4">
        <h2 class="text-2xl font-semibold text-green-700">
            Gestión de Eventos | Eventos Recientes
        </h2>

        <button
            class="px-4 py-2 font-semibold text-white transition rounded-lg shadow-md bg-gradient-to-bl to-green-700 from-green-500 hover:scale-95"
            popovertarget="create-event">
            Crear Evento
        </button>
    </div>
    <div
        class="flex flex-col justify-around px-4 py-4 sm:flex-row bg-gradient-to-b from-green-200/50 to-white rounded-t-xl min-h-52">
        @foreach ($events->take(2) as $event)
            <div
                class="flex flex-row items-center justify-between gap-5 px-4 py-2 mb-1 rounded-lg bg-gradient-to-b from-white to-transparent">
                <div class="flex flex-col gap-3">
                    <div class="">
                        <h3 class="text-lg font-semibold text-gray-700">{{ $event->name }}</h3>
                    </div>
                    <p class="text-sm text-gray-500">Código: {{ $event->event_code }}</p>
                    <p class="text-sm text-gray-500">
                        Fecha: {{ \Carbon\Carbon::parse($event->start_date)->format('d/m/Y') }} -
                        {{ \Carbon\Carbon::parse($event->end_date)->format('d/m/Y') }}
                    </p>
                </div>
                <div class="flex flex-row gap-2">
                    <a href="{{ route('events.show', $event->id) }}"
                        class="px-4 py-2 font-semibold text-white transition rounded-lg shadow-md bg-gradient-to-bl to-green-700 from-green-500 hover:scale-95"
                        popovertarget="edit-event" popoverdata="{{ $event->id }}">Editar</a>
                    <form action="{{ route('events.destroy', $event->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 font-semibold text-white transition rounded-lg shadow-md bg-gradient-to-bl to-red-700 from-red-500 hover:scale-95"
                            popovertarget="delete-event" popoverdata="{{ $event->id }}">Eliminar</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <div class="flex flex-row justify-between">
        <h3 class="text-lg font-semibold">Todos los eventos</h3>

        <div class="relative sm:w-1/2">

            <input required type="text" placeholder="Buscar evento" id="filter-search"
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
        <tbody id="table-data">
            @foreach ($eventsPaginated as $event)
                <tr>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        {{ $event->name }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $event->event_code }}
                    </td>
                    <td class="px-6 py-4">
                        {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} -
                        {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}
                    </td>
                    <td class="px-6 py-4">
                        {{ \Carbon\Carbon::parse($event->start_date)->format('d/m/Y') }} -
                        {{ \Carbon\Carbon::parse($event->end_date)->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $event->responsable }}
                    </td>
                    <td class="px-6 py-4">
                        @if (\Carbon\Carbon::parse($event->end_date)->isPast())
                            <span
                                class="inline-flex items-center px-2 py-1 text-sm font-semibold text-red-800 bg-red-100 rounded-full">Inactivo</span>
                        @else
                            <span
                                class="inline-flex items-center px-2 py-1 text-sm font-semibold text-green-800 bg-green-100 rounded-full">Activo</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('events.show', $event->id) }}"
                            class="px-4 py-2 font-semibold text-white transition rounded-lg shadow-md bg-gradient-to-bl to-green-700 from-green-500 hover:scale-95"
                            popovertarget="edit-event" popoverdata="{{ $event->id }}">Editar</a>
                        <form action="{{ route('events.destroy', $event->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-4 py-2 font-semibold text-white transition rounded-lg shadow-md bg-gradient-to-bl to-red-700 from-red-500 hover:scale-95"
                                popovertarget="delete-event" popoverdata="{{ $event->id }}">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            @if ($eventsPaginated->isEmpty())
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                        No hay eventos registrados
                    </td>
                </tr>
            @endif

        </tbody>
    </table>
    {{ $eventsPaginated->links() }}
    <x-modals.create-event-modal universities={{ $universities }} agreements={{ $agreements }}
        activities={{ $activities }}></x-modals.create-event-modal>
</x-layouts.dashboard-layout>

@vite(['resources/js/modules/utils/filterSearch.js'])
