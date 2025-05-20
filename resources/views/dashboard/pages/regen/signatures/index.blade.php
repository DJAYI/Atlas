<x-layouts.dashboard-layout title="Gestión de Eventos">
    <h2 class="text-2xl font-semibold text-primary-700">
        Gestión de Firmas | Registro de Firma
    </h2>

    <h3 class="text-lg font-medium text-gray-700 mt-5 mb-2">Subir Documento</h3>

    <form method="POST" enctype="multipart/form-data">
        @csrf
        <div class="flex-col gap-2 col-span-2 md:col-span-1">
            <label for="signature_document" class="text-gray-500">{{ __('Fotocopia de Documento de Identidad') }}<span
                    class="text-secondary-400">*</span></label>
            <input type="file" id="signature_document"
                value="{{ old('signature_document', session('signature_document_file')) }}" name="signature_document"
                class="w-full px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300"
                accept="image/jpeg, image/png, image/jpg, image/webp">
            <p class="text-sm text-gray-500">
                Formato permitido: JPG, JPEG, PNG, WEBP. Tamaño máximo: 2MB.'
            </p>

            <div id="preview" class="flex flex-col  justify-center w-full mt-2">
                <img id="preview-image" onload="this.style.opacity='1'"
                    src="{{ asset('storage/' . session('signature_document_file')) }}"
                    class="object-cover transition border w-[500px] aspect-video rounded-lg shadow-sm border-primary-300"
                    alt="Vista previa del documento de identidad">
            </div>
        </div>
        {{-- Submit Button --}}
        <button type="submit"
            class="px-4 w-fit col-span-1 items-center mx-auto mt-4 py-3 text-lg font-semibold text-white transition bg-secondary-500 rounded-md hover:shadow-[1px_1px_20px] bg-gradient-to-tr to-secondary-500 from-primary-500 hover:shadow-primary-400/60 bg-blend-lighten hover:bg-secondary-400">Registrar
            Firma</button>
    </form>
</x-layouts.dashboard-layout>

<script>
    const fileInput = document.getElementById("signature_document");
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
