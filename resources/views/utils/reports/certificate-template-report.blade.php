<table class="text-sm text-gray-500 rounded-lg text-center">
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


            <tr class="hover:bg-gray-50 transition">
                <td class="px-2 py-1 border">
                    {{ $assistance->person->firstname . ' ' . ($assistance->person->middlename ?? '') . ' ' . $assistance->person->lastname . ' ' . ($assistance->person->second_lastname ?? '') }}
                </td>
                <td class="px-2 py-1 border">{{ $assistance->person->document_type }}</td>
                <td class="px-2 py-1 border">{{ $assistance->person->document_number }}</td>

                <td>Por su participación en el evento <b>{{ $assistance->event->activity->name }}</b> del programa
                    {{ $assistance->person->career->name }} en modalidad {{ $assistance->event->modality }} durante
                    {{ $start->translatedFormat('F \d\e Y') }} - {{ $end->translatedFormat('F \d\e Y') }} días</td>

                <td class="px-2 py-1 border">{{ $assistance->event->name }}</td>

                <td></td>

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
