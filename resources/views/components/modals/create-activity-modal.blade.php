<div class="max-h-screen gap-4 px-5 py-8 transition bg-white shadow-lg backdrop:backdrop-blur-sm backdrop:backdrop-brightness-75 rounded-xl"
    id="create-activity" popover>
    <h3 class="text-4xl font-semibold">Nueva Actividad</h3>
    <br>
    
    <!-- Display validation errors -->
    <x-validation-errors class="mb-4" :errors="$errors" />

    <form action="{{ route('activities.store') }}" class="flex flex-col gap-6" method="POST">
        @csrf
        @method('POST')

        <div class="flex flex-col gap-3">
            <h3 class="text-xl font-semibold text-gray-600">Información General</h3>
            <div class="grid grid-cols-1 w-[600px] gap-4 ">
                <div class="flex flex-col gap-2">
                    <label for="name" class="text-gray-500">Nombre</label>
                    <input required type="text" name="name" id="name" value="{{ old('name') }}"
                        class="px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300 {{ $errors->has('name') ? 'border-red-500' : '' }}">
                    @error('name')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col gap-2">
                    <label for="description" class="text-gray-500">Descripción</label>
                    <textarea name="description" id="description" rows="3"
                        class="px-4 py-2 transition bg-white border rounded-lg shadow-sm resize-none border-primary-300 {{ $errors->has('description') ? 'border-red-500' : '' }}">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1">
            <div class="flex flex-row items-center justify-end gap-2">
                <button type="submit"
                    class="inline-block px-4 py-2 font-semibold text-white transition rounded-lg shadow-md bg-gradient-to-bl to-primary-700 from-primary-500 hover:scale-95">
                    Crear Actividad
                </button>
                <button type="button" popovertarget="create-activity"
                    class="px-4 py-2 font-semibold text-white transition rounded-lg shadow-md bg-gradient-to-bl to-red-700 from-red-500 hover:scale-95">
                    Cancelar
                    </a>
            </div>
        </div>
    </form>
</div>
