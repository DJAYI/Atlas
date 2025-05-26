{{-- Popover reutilizable para enviar encuestas --}}
<div id="survey-popover" popover
    class="max-h-screen gap-4 px-5 py-8 transition bg-white shadow-lg backdrop:backdrop-blur-sm backdrop:backdrop-brightness-75 rounded-xl border border-primary-300 w-full max-w-md">
    <h3 class="text-2xl font-semibold text-gray-700 mb-2" id="survey-popover-title">
        Enviar encuesta
    </h3>
    <form class="flex flex-col gap-6">
        <div class="flex flex-col gap-2">
            <label for="survey_url" class="text-gray-500">URL de la encuesta</label>
            <input type="url" name="survey_url" id="survey_url" required placeholder="https://..."
                class="w-full px-4 py-2 bg-white border border-primary-300 rounded-lg shadow-sm transition focus:ring-2 focus:ring-primary-400 focus:border-primary-500">
        </div>
        <div class="flex flex-row items-center justify-end gap-2 mt-2">
            <button type="button"
                class="px-4 py-2 font-semibold text-white transition rounded-lg shadow-md bg-gradient-to-bl to-red-700 from-red-500 hover:scale-95"
                popovertarget="survey-popover" popovertargetaction="hide">
                Cancelar
            </button>
            <button type="button" onclick="sendSurvey()"
                class="px-4 py-2 font-semibold text-white transition rounded-lg shadow-md bg-gradient-to-bl to-primary-700 from-primary-500 hover:scale-95">
                Enviar
            </button>
        </div>
    </form>
</div>
