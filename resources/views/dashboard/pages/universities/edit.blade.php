<x-layouts.dashboard-layout>
    <div class="flex flex-row items-center justify-between my-4">
        <h2 class="text-2xl font-semibold text-green-700">
            Gestión de Universidades | Editar Universidad
        </h2>


    </div>
    <br>
    <form action="{{ route('universities.update', $university->id) }}" class="flex flex-col gap-6" method="POST">
        @csrf
        @method('PUT')

        <div class="flex flex-col gap-3">
            <h3 class="text-xl font-semibold text-gray-600">Información General</h3>
            <div class="grid grid-cols-2 gap-4">
                <div class="flex flex-col gap-2">
                    <label for="name" class="text-gray-500">Nombre</label>
                    <input required type="text" name="name" value="{{ $university->name }}" id="name"
                        class="w-full px-4 py-2 transition bg-white border border-green-300 rounded-lg shadow-sm">
                </div>
                <div class="flex flex-col gap-2">
                    <label for="code" class="text-gray-500">Código</label>
                    <input required type="text" name="code" id="code" value="{{ $university->code }}"
                        class="w-full px-4 py-2 transition bg-white border border-green-300 rounded-lg shadow-sm">
                </div>
                <div class="flex flex-col gap-2">
                    <label for="country_id" class="text-gray-500">País</label>
                    <select required name="country_id" id="country_id"
                        class="px-4 py-2 transition bg-white border border-green-300 rounded-lg shadow-sm">
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}"
                                {{ $university->country_id == $country->id ? 'selected' : '' }}>
                                {{ $country->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex flex-col gap-2">
                    <label for="description" class="text-gray-500">Descripción</label>
                    <textarea required name="description" id="description" rows="3"
                        class="w-full px-4 py-2 transition bg-white border border-green-300 rounded-lg shadow-sm resize-none">{{ $university->description }}</textarea>
                </div>

            </div>
            <div class="grid grid-cols-1">
                <div class="flex flex-row items-center justify-end gap-2">
                    <button type="submit"
                        class="inline-block px-4 py-2 font-semibold text-white transition rounded-lg shadow-md bg-gradient-to-bl to-green-700 from-green-500 hover:scale-95">
                        Actualizar Universidad
                    </button>
                    <A href="{{ route('universities') }}"
                        class="px-4 py-2 font-semibold text-white transition rounded-lg shadow-md bg-gradient-to-bl to-red-700 from-red-500 hover:scale-95">
                        Cancelar
                    </A>
                </div>
            </div>
        </div>
    </form>
</x-layouts.dashboard-layout>
