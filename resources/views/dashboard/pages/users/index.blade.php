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

    <!-- Users List -->
    <div class="mt-6">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-2 text-left">Nombre</th>
                    <th class="p-2 text-left">Correo</th>
                    <th class="p-2 text-left">Rol</th>
                    <th class="p-2 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-2">{{ $user->username }}</td>
                        <td class="p-2">{{ $user->email }}</td>
                        <td class="p-2">
                            @foreach ($user->roles as $role)
                                <span
                                    class="px-2 py-1 text-xs font-semibold text-white rounded-full {{ $role->name == 'admin' ? 'bg-red-500' : 'bg-blue-500' }}">
                                    {{ ucfirst($role->name) }}
                                </span>
                            @endforeach
                        </td>
                        <td class="p-2 text-center">
                            @can('manage users')
                                <button class="px-3 py-1 mr-2 text-white bg-blue-500 rounded hover:bg-blue-600"
                                    popovertarget="edit-user"
                                    popoverdata="{{ json_encode([
                                        'id' => $user->id,
                                        'username' => $user->username,
                                        'email' => $user->email,
                                        'role' => $user->roles->first() ? $user->roles->first()->name : '',
                                    ]) }}">
                                    Editar
                                </button>

                                @if ($user->id !== auth()->id())
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1 text-white bg-red-500 rounded hover:bg-red-600"
                                            onclick="return confirm('¿Estás seguro de querer eliminar este usuario?')">
                                            Eliminar
                                        </button>
                                    </form>
                                @endif
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Create User Popover -->
    <div id="create-user" popover class="p-6 bg-white border rounded-lg shadow-lg w-96">
        <h3 class="mb-4 text-xl font-semibold">Crear Nuevo Usuario</h3>
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="username" class="block mb-1 font-medium">Nombre</label>
                <input type="text" id="username" name="username" required
                    class="w-full px-3 py-2 border rounded-md focus:ring focus:ring-primary-300">
            </div>
            <div class="mb-4">
                <label for="email" class="block mb-1 font-medium">Correo Electrónico</label>
                <input type="email" id="email" name="email" required
                    class="w-full px-3 py-2 border rounded-md focus:ring focus:ring-primary-300">
            </div>
            <div class="mb-4">
                <label for="password" class="block mb-1 font-medium">Contraseña</label>
                <input type="password" id="password" name="password" required
                    class="w-full px-3 py-2 border rounded-md focus:ring focus:ring-primary-300">
            </div>
            <div class="mb-4">
                <label for="role" class="block mb-1 font-medium">Rol</label>
                <select id="role" name="role" required
                    class="w-full px-3 py-2 border rounded-md focus:ring focus:ring-primary-300">
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" popovertarget="create-user" popovertargetaction="hide"
                    class="px-4 py-2 text-gray-700 bg-gray-200 rounded hover:bg-gray-300">Cancelar</button>
                <button type="submit"
                    class="px-4 py-2 text-white bg-primary-600 rounded hover:bg-primary-700">Guardar</button>
            </div>
        </form>
    </div>

    <!-- Edit User Popover -->
    <div id="edit-user" popover class="p-6 bg-white border rounded-lg shadow-lg w-96">
        <h3 class="mb-4 text-xl font-semibold">Editar Usuario</h3>
        <form id="edit-user-form" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="edit_username" class="block mb-1 font-medium">Nombre</label>
                <input type="text" id="edit_username" name="username" required
                    class="w-full px-3 py-2 border rounded-md focus:ring focus:ring-primary-300">
            </div>
            <div class="mb-4">
                <label for="edit_email" class="block mb-1 font-medium">Correo Electrónico</label>
                <input type="email" id="edit_email" name="email" required
                    class="w-full px-3 py-2 border rounded-md focus:ring focus:ring-primary-300">
            </div>
            <div class="mb-4">
                <label for="edit_password" class="block mb-1 font-medium">Contraseña (dejar en blanco para mantener la
                    actual)</label>
                <input type="password" id="edit_password" name="password"
                    class="w-full px-3 py-2 border rounded-md focus:ring focus:ring-primary-300">
            </div>
            <div class="mb-4">
                <label for="edit_role" class="block mb-1 font-medium">Rol</label>
                <select id="edit_role" name="role" required
                    class="w-full px-3 py-2 border rounded-md focus:ring focus:ring-primary-300">
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" popovertarget="edit-user" popovertargetaction="hide"
                    class="px-4 py-2 text-gray-700 bg-gray-200 rounded hover:bg-gray-300">Cancelar</button>
                <button type="submit"
                    class="px-4 py-2 text-white bg-primary-600 rounded hover:bg-primary-700">Actualizar</button>
            </div>
        </form>
    </div>

    <!-- JavaScript for the Edit User form -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editButtons = document.querySelectorAll('[popovertarget="edit-user"]');

            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const userData = JSON.parse(this.getAttribute('popoverdata'));
                    const form = document.getElementById('edit-user-form');

                    // Set form action URL
                    form.action = `/dashboard/users/${userData.id}`;

                    // Fill form fields
                    document.getElementById('edit_username').value = userData.username;
                    document.getElementById('edit_email').value = userData.email;
                    document.getElementById('edit_password').value = '';

                    // Set the role
                    const roleSelect = document.getElementById('edit_role');
                    for (let i = 0; i < roleSelect.options.length; i++) {
                        if (roleSelect.options[i].value === userData.role) {
                            roleSelect.selectedIndex = i;
                            break;
                        }
                    }
                });
            });
        });
    </script>
</x-layouts.dashboard-layout>
