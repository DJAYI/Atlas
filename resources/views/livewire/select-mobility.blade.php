<div class="grid grid-cols-1 gap-4 md:grid-cols-2">
    <div class="flex flex-col w-full col-span-1 gap-2">
        <label for="assistanceType" class="text-gray-500">{{ __('¿Quién eres?') }}<span
                class="text-secondary-400">*</span></label>
        <select wire:model.live="selectedAssistanceType" id="assistanceType" name="type"
            class="w-full px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300">
            <option value="" disabled {{ empty($type) ? 'selected' : '' }}>{{ __('Seleccione una opción') }}
            </option>
            @foreach (['estudiante' => __('Estudiante'), 'egresado' => __('Egresado'), 'profesor' => __('Profesor'), 'administrativo' => __('Administrativo'), 'empresario' => __('Empresario')] as $key => $label)
                <option value="{{ $key }}" {{ $type === $key ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div class="flex flex-col w-full col-span-1 gap-2">
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
