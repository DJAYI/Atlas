<x-app-layout>
    <x-utils.language-selector route="assistance" />

    <div
        class="grid w-auto min-h-screen grid-cols-1 gap-5 mx-auto bg-white sm:max-w-5xl rounded-t-xl md:grid-cols-1 place-items-center">

        <h1 class="text-3xl font-bold text-center text-gray-800">Registro de Assistencia</h1>

        <form class="my-5 p-4" action="" method="POST">
            @csrf
            @method('POST')

            {{-- Tipo de documento y número de documento --}}
            <div class="flex flex-col gap-3">
                <h3 class="text-xl font-semibold text-gray-600">Información del Convenio</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col gap-2">
                        <label for="doc_type" class="text-gray-500">Tipo de Documento</label>
                        <select required name="doc_type" id="doc_type"
                            class="px-4 py-2 transition bg-white border border-green-300 rounded-lg shadow-sm">
                            <option selected disabled value="">Seleccione un tipo</option>
                            <option value="marco">Cedula de </option>
                            <option value="especifico">Específico</option>
                        </select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="type" class="text-gray-500">Número de Documento</label>
                        <input required maxlength="6" type="text" name="document_number" id="document_number"
                            class="w-full px-4 py-2 transition bg-white border border-green-300 rounded-lg shadow-sm">
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
