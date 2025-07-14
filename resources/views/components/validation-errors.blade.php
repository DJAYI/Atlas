@props(['errors'])

@if ($errors->any())
    <div {{ $attributes->merge(['class' => 'bg-red-50 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4']) }} role="alert">
        <strong class="font-bold">Validation Error!</strong>
        <span class="block sm:inline">Please check the form for errors.</span>
        <ul class="mt-2 list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
