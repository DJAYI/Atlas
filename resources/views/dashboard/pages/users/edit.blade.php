<x-layouts.dashboard-layout>
    <div class="flex flex-row items-center justify-between my-4">
        <h2 class="text-2xl font-semibold text-primary-700">
            Gestión de Usuarios | Editar Usuario
        </h2>
    </div>

    <form action="{{ route('users.update', $user->id) }}" class="flex flex-col gap-6" method="POST">
        @csrf
        @method('PUT')

        <div class="flex flex-col gap-3">
            <h3 class="text-xl font-semibold text-gray-600">Información General</h3>
            <div class="grid grid-cols-2 gap-4">
                <div class="flex flex-col gap-2">
                    <label for="username" class="text-gray-500">Nombre</label>
                    <input required type="text" name="username" id="username" value="{{ $user->username }}"
                        class="w-full px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300">
                </div>

                <div class="flex flex-col gap-2">
                    <label for="email" class="text-gray-500">Correo Electrónico</label>
                    <input required type="email" name="email" id="email" value="{{ $user->email }}"
                        class="w-full px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300">
                </div>

                <div class="flex flex-col gap-2">
                    <label for="institutional_email" class="text-gray-500">Correo Electrónico Institucional</label>
                    <input required type="email" name="institutional_email" id="institutional_email"
                        value="{{ $user->institutional_email }}"
                        class="w-full px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300">
                </div>

                <div class="flex flex-col gap-2">
                    <label for="password" class="text-gray-500">Contraseña (dejar en blanco para mantener la
                        actual)</label>
                    <input type="password" name="password" id="password"
                        class="w-full px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300">
                </div>

                <div class="flex flex-col gap-2">
                    <label for="role" class="text-gray-500">Rol</label>
                    <select required name="role" id="role"
                        class="w-full px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300">
                        <option value="" disabled>Seleccione un rol</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}"
                                {{ $user->roles->first() && $user->roles->first()->name == $role->name ? 'selected' : '' }}>
                                {{ ucfirst($role->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1">
            <div class="flex flex-row items-center justify-end gap-2">
                <button type="submit"
                    class="inline-block px-4 py-2 font-semibold text-white transition rounded-lg shadow-md bg-gradient-to-bl to-primary-700 from-primary-500 hover:scale-95">
                    Actualizar Usuario
                </button>
                <a href="{{ route('users') }}"
                    class="px-4 py-2 font-semibold text-white transition rounded-lg shadow-md bg-gradient-to-bl to-red-700 from-red-500 hover:scale-95">
                    Cancelar
                </a>
            </div>
        </div>
    </form>
</x-layouts.dashboard-layout>
