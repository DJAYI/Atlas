<table class="text-sm text-center text-gray-500 rounded-lg">
    <thead>
        <tr class="px-2 py-1 text-sm font-semibold text-gray-700 uppercase bg-gray-100">
            <th class="px-2 py-1 border">Nombre</th>
            <th class="px-2 py-1 border">TipoDoc</th>
            <th class="px-2 py-1 border">documento</th>
            <th class="px-2 py-1 border">Participacion</th>
            <th class="px-2 py-1 border">Variable1</th>
            <th class="px-2 py-1 border">Variable2</th>
            <th class="px-2 py-1 border">Dias</th>
            <th class="px-2 py-1 border">Mes</th>
            <th class="px-2 py-1 border">Liderdelarea</th>
            <th class="px-2 py-1 border">Cargolider</th>
            <th class="px-2 py-1 border">Folio</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($assistances as $assistance)
            @php
                $start = \Carbon\Carbon::parse($assistance->event->start_date);
                $end = \Carbon\Carbon::parse($assistance->event->end_date);
                $days = [];
                for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
                    $days[] = $date->day;
                }
                $last = array_pop($days);
            @endphp


            <tr class="transition hover:bg-gray-50">
                <td class="px-2 py-1 border">
                    {{ $assistance->person->firstname . ' ' . ($assistance->person->middlename ?? '') . ' ' . $assistance->person->lastname . ' ' . ($assistance->person->second_lastname ?? '') }}
                </td>
                <td class="px-2 py-1 border">{{ $assistance->person->document_type }}</td>
                <td class="px-2 py-1 border">{{ $assistance->person->document_number }}</td>

                <td>Por su participación en el evento</td>

                <td class="px-2 py-1 border">{{ $assistance->event->activity->name }} - {{ $assistance->event->name }}
                </td>

                <td>Agradecemos su aporte al mejoramiento de la calidad educativa a través de la transferencia del
                    conocimiento y el intercambio de experiencias académicas y multiculturales en Cartagena- Colombia.
                </td>

                <td class="px-2 py-1 border">

                    {{ implode(', ', $days) }}@if ($last)
                        {{ count($days) ? ' y ' : '' }}{{ $last }}
                    @endif
                </td>
                <td class="px-2 py-1 border">
                    {{ \Carbon\Carbon::parse($assistance->event->start_date)->translatedFormat('F \d\e Y') }}</td>
                <td class="px-2 py-1 border">Carmenza Lucia Salgado Jaramillo</td>
                <td class="px-2 py-1 border">Jefe de Internacionalización y Alianzas</td>
        @endforeach
    </tbody>
</table>
