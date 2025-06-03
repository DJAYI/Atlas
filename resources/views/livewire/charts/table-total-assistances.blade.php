<div class="flex flex-col items-center w-full ">
    <div class="flex items-center justify-between w-full px-4 py-2 mt-4 bg-white rounded-lg border">
        <h2 class="text-2xl font-semibold text-pretty text-primary-700">
            Reporte Completo de Asistencias
        </h2>
        <div class="flex items-center gap-2">
            <button
                class="px-4 py-2 font-semibold text-white transition rounded-lg bg-gradient-to-tr from-blue-500 to-blue-700 hover:shadow-[1px_1px_20px] hover:shadow-blue-400/65 hover:bg-blend-darken hover:bg-primary-500">Generar
                Reporte</button>
        </div>

    </div>
    <div class="overflow-x-auto max-w-full">
        <table class="text-sm text-gray-500 rounded-lg text-center">
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
                    <th class="px-2 py-1 border">DEPENDENCIA</th>
                    <th class="px-2 py-1 border">CARGO</th>
                    <th class="px-2 py-1 border">SEMESTRE</th>
                    <th class="px-2 py-1 border">TIPO DE MOVILIDAD</th>
                    <th class="px-2 py-1 border">TIPO DE PARTICIPACION</th>
                    <th class="px-2 py-1 border">NOMBRE DEL EVENTO</th>
                    <th class="px-2 py-1 border">NACIONALIDAD</th>
                    <th class="px-2 py-1 border">E/S</th>
                </tr>
            </thead>
            <tbody>
                {{-- Aquí puedes iterar sobre los datos de asistencias para mostrar las filas --}}
            </tbody>
        </table>
    </div>
</div>
