<x-layouts.dashboard-layout title="Gestión de Usuarios">
    <div class="flex flex-row items-center justify-between my-4">
        <h2 class="text-2xl font-semibold text-primary-700">
            Gestión de Usuarios
        </h2>

        @can('manage users')
            <button
                class="inline-block px-4 py-2 font-semibold text-white transition rounded-lg shadow-md bg-gradient-to-bl to-primary-700 from-primary-500 hover:scale-95"
                popovertarget="create-user">
                Crear Usuario
            </button>
        @endcan
    </div>
    <br>
    <div class="flex flex-row justify-between mx-5">
        <h3 class="text-lg font-semibold">Todos los Usuarios</h3>

        <div class="relative sm:w-1/2">
            <input required type="text" placeholder="Buscar usuario" id="filter-search"
                class="w-full px-4 py-2 pl-10 pr-4 placeholder-gray-500 transition bg-white border rounded-lg shadow-sm border-primary-300">
            <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
    </div>
    <br>

    <!-- Users List -->
    <table class="w-full text-sm text-left text-gray-500 rtl:text-right">
        <thead class="text-gray-700 uppercase">
            <tr>
                <th scope="col" class="px-6 py-3">Nombre</th>
                <th scope="col" class="px-6 py-3">Correo</th>
                <th scope="col" class="px-6 py-3">Rol</th>
                <th scope="col" class="px-6 py-3">Acciones</th>
            </tr>
        </thead>
        <tbody id="table-data">
            @foreach ($users as $user)
                <tr class="transition hover:bg-primary-50/50">
                    <td
                        class="max-w-full px-6 py-4 overflow-hidden font-medium text-gray-900 text-ellipsis whitespace-nowrap">
                        {{ $user->username }}
                    </td>
                    <td class="px-6 py-4 text-ellipsis max-w-[200px] overflow-hidden whitespace-nowrap">
                        {{ $user->email }}
                    </td>
                    <td class="px-6 py-4">
                        @foreach ($user->roles as $role)
                            <span
                                class="px-2 py-1 text-xs font-semibold text-white rounded-full {{ $role->name == 'admin' ? 'bg-red-500' : 'bg-blue-500' }}">
                                {{ ucfirst($role->name) }}
                            </span>
                        @endforeach
                    </td>
                    <td class="flex gap-2 px-6 py-4">
                        @can('manage users')
                            <a href="{{ route('users.edit', $user->id) }}"
                                class="inline-block px-4 py-2 font-semibold text-white transition rounded-lg shadow-md w-fit bg-gradient-to-bl to-primary-700 from-primary-500 hover:scale-95">
                                Ver más
                            </a>

                            @if ($user->id !== auth()->id())
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-4 py-2 font-semibold text-white transition rounded-lg shadow-md bg-gradient-to-bl to-red-700 from-red-500 hover:scale-95"
                                        onclick="return confirm('¿Estás seguro de querer eliminar este usuario?')">
                                        Eliminar
                                    </button>
                                </form>
                            @endif
                        @endcan
                    </td>
                </tr>
            @endforeach

            @if ($users->isEmpty())
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center">
                        No hay usuarios disponibles.
                    </td>
                </tr>
            @endif
        </tbody>
    </table>

    @if (method_exists($users, 'links'))
        {{ $users->links() }}
    @endif
</x-layouts.dashboard-layout>

<x-modals.create-user-modal :roles="$roles" />

<script src="{{ asset('js/modules/utils/filterSearch.js') }}"></script>
