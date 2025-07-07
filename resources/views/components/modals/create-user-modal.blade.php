<div class="max-h-screen gap-4 px-5 py-8 transition bg-white shadow-lg backdrop:backdrop-blur-sm backdrop:backdrop-brightness-75 rounded-xl"
    id="create-user" popover>
    <h3 class="text-4xl font-semibold">Nuevo Usuario</h3>
    <br>
    <form action="{{ route('users.store') }}" class="flex flex-col gap-6" method="POST">
        @csrf
        @method('POST')

        <div class="flex flex-col gap-3">
            <h3 class="text-xl font-semibold text-gray-600">Información General</h3>
            <div class="grid grid-cols-2 gap-4">
                <div class="flex flex-col gap-2">
                    <label for="username" class="text-gray-500">Nombre</label>
                    <input required type="text" name="username" id="username"
                        class="py-2 px-4 w-[400px] bg-white border border-primary-300 rounded-lg shadow-sm transition">
                </div>

                <div class="flex flex-col gap-2">
                    <label for="email" class="text-gray-500">Correo Electrónico</label>
                    <input required type="email" name="email" id="email"
                        class="py-2 px-4 w-[400px] bg-white border border-primary-300 rounded-lg shadow-sm transition">
                </div>

                <div class="flex flex-col gap-2">
                    <label for="institutional_email" class="text-gray-500">Correo Electrónico Institucional</label>
                    <input required type="email" name="institutional_email" id="institutional_email"
                        class="py-2 px-4 w-[400px] bg-white border border-primary-300 rounded-lg shadow-sm transition">
                </div>

                <div class="flex flex-col gap-2">
                    <label for="password" class="text-gray-500">Contraseña</label>
                    <input required type="password" name="password" id="password"
                        class="py-2 px-4 w-[400px] bg-white border border-primary-300 rounded-lg shadow-sm transition">
                </div>

                <div class="flex flex-col gap-2">
                    <label for="role" class="text-gray-500">Rol</label>
                    <select required name="role" id="role"
                        class="px-4 py-2 transition w-[400px] bg-white border border-primary-300 rounded-lg shadow-sm">
                        <option value="" disabled selected>Seleccione un rol</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-1">
                <div class="flex flex-row items-center justify-end gap-2">
                    <button type="submit"
                        class="inline-block px-4 py-2 font-semibold text-white transition rounded-lg shadow-md bg-gradient-to-bl to-primary-700 from-primary-500 hover:scale-95">
                        Crear Usuario
                    </button>
                    <button type="button" popovertarget="create-user"
                        class="px-4 py-2 font-semibold text-white transition rounded-lg shadow-md bg-gradient-to-bl to-red-700 from-red-500 hover:scale-95">
                        Cancelar
                    </button>
                </div>
            </div>
    </form>
</div>
