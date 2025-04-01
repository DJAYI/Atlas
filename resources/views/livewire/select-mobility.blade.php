<div class="flex gap-4">

    <div class="flex w-full flex-col gap-2 ">
        <label for="type" class="text-gray-500">{{ __('¿Quién eres?') }}<span
                class="text-secondary-400">*</span></label>
        <select wire:model="selectedAssistanceType" id="type" name="type"
            class="w-full px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300">
            <option value="" disabled selected>{{ __('Seleccione una opción') }}
            </option>
            <option value="estudiante">
                {{ __('Estudiante') }}</option>
            <option value="egresado">
                {{ __('Egresado') }}</option>
            <option value="profesor">
                {{ __('Profesor') }}</option>
            <option value="administrativo">
                {{ __('Administrativo') }}</option>
        </select>
    </div>

    <div class="flex w-full flex-col gap-2">
        <label for="mobility" wire:model="mobility" class="text-gray-500">{{ __('¿A qué vienes?') }}<span
                class="text-secondary-400">*</span></label>
        <select id="mobility" name="mobility"
            class="w-full px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300">
            <option value="" disabled selected>{{ __('Seleccione una opción') }}
            </option>
            @foreach ($this->mobilities as $mobility)
                <option value="{{ $mobility->id }}">{{ $mobility->name }}</option>
            @endforeach
        </select>
    </div>

</div>
