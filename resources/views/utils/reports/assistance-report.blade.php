<table class="text-sm text-center text-gray-500 rounded-lg">
    <thead>
        <tr class="px-2 py-1 text-sm font-semibold text-gray-700 uppercase bg-gray-100">
            <th class="px-2 py-1 border">FECHA</th>
            <th class="px-2 py-1 border">GENERO</th>
            <th class="px-2 py-1 border">COMUNIDAD</th>
            <th class="px-2 py-1 border">CORREO ELECTRÓNICO</th>
            <th class="px-2 py-1 border">NOMBRE Y APELLIDOS</th>
            <th class="px-2 py-1 border">TIPO DE IDENTIFICACIÓN</th>
            <th class="px-2 py-1 border">N° IDENTIFICACIÓN</th>
            <th class="px-2 py-1 border">FECHA DE NACIMIENTO</th>
            <th class="px-2 py-1 border">TELÉFONO</th>
            <th class="px-2 py-1 border">INSTITUCIÓN</th>
            <th class="px-2 py-1 border">PROGRAMA</th>
            <th class="px-2 py-1 border">TIPO DE MODALIDAD</th>
            <th class="px-2 py-1 border">TIPO DE PARTICIPACION</th>
            <th class="px-2 py-1 border">NOMBRE DEL EVENTO</th>
            <th class="px-2 py-1 border">NACIONALIDAD</th>
            <th class="px-2 py-1 border">E/S</th>
            <th class="px-2 py-1 border">MOVILIDAD</th>
            <th class="px-2 py-1 border">TIPO DE ASISTENTE</th>
            <th class="px-2 py-1 border">PROGRAMA DEL EVENTO</th>
            <th class="px-2 py-1 border">DESCRIPCIÓN DEL EVENTO</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($assistances as $assistance)
            <tr class="transition hover:bg-gray-50">
                <td class="px-2 py-1 border">{{ $assistance->created_at->format('d/m/Y') }}</td>
                <td class="px-2 py-1 border">{{ $assistance->person->genre }}</td>
                <td class="px-2 py-1 border">{{ $assistance->person->minority ?? 'ninguna' }}</td>
                <td class="px-2 py-1 border">{{ $assistance->person->email }}</td>
                <td class="px-2 py-1 border">
                    {{ $assistance->person->firstname . ' ' . ($assistance->person->middlename ?? '') . ' ' . $assistance->person->lastname . ' ' . ($assistance->person->second_lastname ?? '') }}
                </td>
                <td class="px-2 py-1 border">{{ $assistance->person->document_type }}</td>
                <td class="px-2 py-1 border">{{ $assistance->person->document_number }}</td>
                <td class="px-2 py-1 border">
                    {{ $assistance->person->birth_date ? $assistance->person->birth_date->format('d/m/Y') : 'N/A' }}
                </td>
                <td class="px-2 py-1 border">{{ $assistance->person->phone }}</td>
                <td class="px-2 py-1 border">{{ $assistance->person->university->name }}</td>
                <td class="px-2 py-1 border">{{ $assistance->person->career->name }}</td>
                <td class="px-2 py-1 border">{{ $assistance->event->modality }}</td>
                <td class="px-2 py-1 border">{{ $assistance->event->activity->name }}</td>
                <td class="px-2 py-1 border">{{ $assistance->event->name }}</td>
                <td class="px-2 py-1 border">{{ $assistance->person->country->name }}</td>
                <td class="px-2 py-1 border">
                    {{ $assistance->person->university->name === 'Fundación Universitaria Tecnológico Comfenalco' ? 'S' : 'E' }}
                </td>
                <td class="px-2 py-1 border">{{ $assistance->mobility->name }}</td>
                <td class="px-2 py-1 border">{{ $assistance->mobility->type }}</td>
                <td class="px-2 py-1 border">
                    {{ $assistance->event->career ? $assistance->event->career->name : 'N/A' }}
                </td>
                <td class="px-2 py-1 border">{{ $assistance->event->description }}</td>
        @endforeach
    </tbody>
</table>
