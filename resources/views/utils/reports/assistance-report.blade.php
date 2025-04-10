<table>
    <thead>
        <tr>
            <th>AÑO</th>
            <th>SEMESTRE</th>
            <th>ID_TIPO_DOCUMENTO</th>
            <th>NUM_DOCUMENTO</th>
            @if ($IsColombian == 'false')
                <th>PRIMER_NOMBRE</th>
                <th>SEGUNDO_NOMBRE</th>
                <th>PRIMER_APELLIDO</th>
                <th>SEGUNDO_APELLIDO</th>
            @endif
            <th>ID_PAIS_EXTRANJERO</th>
            <th>INSTITUCION_EXTRANJERA</th>
            <th>ID_TIPO_MOV_{{ $ReportType == 'estudiante' ? 'EST' : ($ReportType == 'profesor' ? 'DOC' : ($ReportType == 'administrativo' ? 'ADM' : '')) }}_{{ $IsColombian == 'true' ? 'EXTERIOR' : 'EXTRANJ' }}
            </th>
            <th>NUM_DIAS_MOVILIDAD</th>
            <th>MOVILIDAD_POR_CONVENIO</th>
            <th>CODIGO_CONVENIO</th>
            <th>ID_FUENTE_NACIONAL_INVESTIG</th>
            <th>VALOR_FINANCIACION_NACIONAL</th>
            <th>ID_FUENTE_INTERNACIONAL</th>
            <th>ID_PAIS_FINANCIADOR</th>
            <th>VALOR_FINANCIACION_INTERNAC</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($ReportCollection as $row)
            <tr>
                <td>{{ $row->event->start_date->format('Y') }}</td>
                <td>{{ $row->event->start_date->month <= 6 ? '1' : '2' }}</td>
                <td>{{ $row->person->document_type }}</td>
                <td>{{ $row->person->document_number }}</td>
                @if ($IsColombian == 'false')
                    <td>{{ $row->person->firstname }}</td>
                    <td>{{ $row->person->middlename }}</td>
                    <td>{{ $row->person->lastname }}</td>
                    <td>{{ $row->person->second_lastname }}</td>
                @endif
                <td>{{ $row->person->country->iso_code }}</td>
                <td>{{ $row->universityDestiny->name ?? '' }}</td>
                <td>{{ $row->mobility->name }}</td>
                <td>{{ $row->event->start_date->diffInDays($row->event->end_date) }}</td>
                <td>{{ strtolower($row->event->has_agreement) === 'si' ? 'S' : 'N' }}</td>
                <td>{{ $row->event->agreement->code ?? '' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
