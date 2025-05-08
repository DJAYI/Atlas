<x-layouts.dashboard-layout title="Gestión de Eventos">
    <h2 class="text-2xl font-semibold text-primary-700">
        Gestión de Firmas | Registro de Firma
    </h2>

    <h3 class="text-lg font-medium text-gray-700 mt-5 mb-2">Subir Documento</h3>

    <form method="POST" action="{{ route('dashboard.regen.signatures.store') }}" class="flex flex-col gap-4"
        enctype="multipart/form-data">
        @csrf
        <div class="flex-col gap-2 col-span-2 md:col-span-1">
            <label for="name" class="text-gray-500">Nombre Completo<span class="text-secondary-400">*</span></label>
            <input type="text" id="name" name="name" placeholder="" value="{{ $signature->name }}"
                class="w-full px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300">
        </div>

        <div class="flex-col gap-2 col-span-2 md:col-span-1">
            <label for="signature_file_path" class="text-gray-500">Archivo de Firma<span
                    class="text-secondary-400">*</span></label>
            <input type="file" id="signature_file_path" name="signature_file_path"
                class="w-full px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300"
                accept="image/jpeg, image/png, image/jpg, image/webp">
            <p class="text-sm text-gray-500">
                Formato permitido: JPG, JPEG, PNG, WEBP. Tamaño máximo: 2MB.'
            </p>

            <div id="preview" class="flex flex-col  justify-center w-full mt-2">
                <img id="preview-image" onload="this.style.opacity='1'"
                    src="{{ asset('storage/' . $signature->signature_file_path) }}"
                    class="object-cover transition border w-[500px] aspect-video rounded-lg shadow-sm border-primary-300"
                    alt="Vista previa del documento de identidad">
            </div>
        </div>
        {{-- Submit Button --}}
        <button type="submit"
            class="px-4 w-fit col-span-1  mt-4 py-3 text-lg font-semibold text-white transition bg-secondary-500 rounded-md hover:shadow-[1px_1px_20px] bg-gradient-to-tr to-secondary-500 from-primary-500 hover:shadow-primary-400/60 bg-blend-lighten hover:bg-secondary-400">Registrar
            Firma</button>
    </form>
</x-layouts.dashboard-layout>

<script>
    const fileInput = document.getElementById("signature_file_path");
    const previewImage = document.getElementById("preview-image");

    // Event listener for file input
    fileInput.addEventListener("change", function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
            };
            reader.readAsDataURL(file);
        } else {
            previewImage.src = "";
        }
    });
</script>
