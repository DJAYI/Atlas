<div class="gap-4 grid grid-cols-1 md:grid-cols-2">
    <div class="flex flex-col w-full gap-2 col-span-1">
        <label for="assistanceType" class="text-gray-500">{{ __('¿Quién eres?') }}<span
                class="text-secondary-400">*</span></label>
        <select wire:model.live="selectedAssistanceType" id="assistanceType" name="type"
            class="w-full px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300">
            <option value="" disabled {{ empty($type) ? 'selected' : '' }}>{{ __('Seleccione una opción') }}
            </option>
            @foreach (['estudiante' => __('Estudiante'), 'egresado' => __('Egresado'), 'profesor' => __('Profesor'), 'administrativo' => __('Administrativo')] as $key => $label)
                <option value="{{ $key }}" {{ $type === $key ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div class="flex flex-col w-full gap-2 col-span-1">
        <label for="mobility" class="text-gray-500">{{ __('Propósito de Asistencia') }}<span
                class="text-secondary-400">*</span></label>
        <select id="mobility" wire:model.live="mobility" name="mobility_id"
            class="w-full px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300">
            <option value="" disabled selected>{{ __('Seleccione una opción') }}</option>
            @foreach ($mobilities as $mob)
                <option value="{{ $mob->id }}">{{ $mob->name }}</option>
            @endforeach
        </select>
    </div>
</div>
