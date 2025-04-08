<table>
    <thead>
        @if ($IsColombian === false)
            {{-- Headers for Foráneos --}}
            <tr>
                <th>AÑO</th>
                <th>SEMESTRE</th>
                <th>ID_TIPO_DOCUMENTO</th>
                <th>NUM_DOCUMENTO</th>
                <th>PRIMER_NOMBRE</th>
                <th>SEGUNDO_NOMBRE</th>
                <th>PRIMER_APELLIDO</th>
                <th>SEGUNDO_APELLIDO</th>
                <th>ID_PAIS_EXTRANJERO</th>
                <th>INSTITUCION_EXTRANJERA</th>
                <th>ID_TIPO_MOV_EXTRANJ</th>
                <th>NUM_DIAS_MOVILIDAD</th>
                <th>MOVILIDAD_POR_CONVENIO</th>
                <th>CODIGO_CONVENIO</th>
            </tr>
        @else
            {{-- Headers for Locales --}}
            <tr>
                <th>AÑO</th>
                <th>SEMESTRE</th>
                <th>ID_TIPO_DOCUMENTO</th>
                <th>NUM_DOCUMENTO</th>
                <th>ID_PAIS_EXTRANJERO</th>
                <th>INSTITUCION_EXTRANJERA</th>
                <th>ID_TIPO_MOV_EXTERIOR</th>
                <th>NUM_DIAS_MOVILIDAD</th>
                <th>MOVILIDAD_POR_CONVENIO</th>
                <th>CODIGO_CONVENIO</th>
            </tr>
        @endif
    </thead>
    <tbody>
        @foreach ($ReportCollection as $row)
            <tr>
                <td>{{ $row->event->start_date->format('Y') }}</td>
                <td>{{ $row->event->start_date->month <= 6 ? '1' : '2' }}</td>
                <td>{{ $row->person->document_type }}</td>
                <td>{{ $row->person->document_number }}</td>
                @if ($IsColombian === false)
                    {{-- Foráneos-specific columns --}}
                    <td>{{ $row->person->firstname }}</td>
                    <td>{{ $row->person->middlename }}</td>
                    <td>{{ $row->person->lastname }}</td>
                    <td>{{ $row->person->second_lastname }}</td>
                @endif
                <td>{{ $row->person->country->iso_code_alpha_3 ?? '' }}</td>
                <td>{{ $row->universityDestiny->name ?? '' }}</td>
                <td>{{ $IsColombian === false ? $row->mobility->type : '' }}</td>
                <td>{{ $row->mobility->days ?? '' }}</td>
                <td>{{ $row->event->has_agreement ? 'Sí' : 'No' }}</td>
                <td>{{ $row->event->agreement->code ?? '' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
