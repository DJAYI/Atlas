<x-layouts.dashboard-layout title="Estadísticas">
    <div class="flex flex-row items-center justify-between my-4">
        <h2 class="text-2xl text-pretty h-full  flex items-center font-semibold text-primary-700">
            Gestión de Estadísticas y Reportes
        </h2>
    </div>
    <div class="">


        <div class="flex flex-col gap-4 mt-4 h-full">
            <div class="flex flex-row justify-center mt-20 items-center gap-8 ">
                <div class="grid grid-cols-1 self-start gap-4 px-3 relative">
                    <div
                        class="absolute top-0  w-1/2 h-1/2 blur-2xl opacity-15 rounded-full -z-[0] left-0 bg-gradient-to-r from-secondary-500 to-transparent">
                    </div>
                    <h2 class="text-2xl font-semibold my-3 text-secondary-400 px-2 text-center">Reportes de Movilidad
                        Foranea
                    </h2>


                    <details class="col-span-1 max-h-32 overflow-y-auto">
                        <summary
                            class="text-lg text-pretty   flex items-center text-primary-700 px-3 py-2 border rounded-lg font-semibold">
                            Reportes de
                            Movilidad de
                            Eventos de
                            Docentes Foraneos
                        </summary>


                        <table class="w-full text-sm text-left text-gray-500 rtl:text-right">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">Evento</th>
                                    <th class="px-4 py-2">Num. Asistentes</th>
                                    <th class="px-4 py-2">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- <tr>
                                    <td class="px-4 py-2">Evento 1</td>
                                    <td class="px-4 py-2">10</td>
                                    <td class="px-4 py-2">
                                        <button
                                            class="px-4 py-2 font-semibold text-sm text-white transition rounded-lg bg-gradient-to-tr from-blue-500 to-blue-700 hover:shadow-[1px_1px_20px] hover:shadow-blue-400/65 hover:bg-blend-darken hover:bg-primary-500">
                                            Generar Reporte
                                        </button>
                                    </td>
                                </tr>
                                 --}}
                            </tbody>
                        </table>
                    </details>
                    <details class="col-span-1 max-h-32 overflow-y-auto">
                        <summary
                            class="text-lg text-pretty   flex items-center text-primary-700 px-3 py-2 border rounded-lg font-semibold">
                            Reportes de
                            Movilidad de
                            Eventos de
                            Estudiantes Foraneos
                        </summary>
                        <table class="w-full text-sm text-left text-gray-500 rtl:text-right">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">Evento</th>
                                    <th class="px-4 py-2">Num. Asistentes</th>
                                    <th class="px-4 py-2">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- <tr>
                                    <td class="px-4 py-2">Evento 1</td>
                                    <td class="px-4 py-2">10</td>
                                    <td class="px-4 py-2">
                                        <button
                                            class="px-4 py-2 font-semibold text-sm text-white transition rounded-lg bg-gradient-to-tr from-blue-500 to-blue-700 hover:shadow-[1px_1px_20px] hover:shadow-blue-400/65 hover:bg-blend-darken hover:bg-primary-500">
                                            Generar Reporte
                                        </button>
                                    </td>
                                </tr>
                                 --}}
                            </tbody>
                        </table>
                    </details>
                    <details class="col-span-1 max-h-32 overflow-y-auto">
                        <summary
                            class="text-lg text-pretty   flex items-center text-primary-700 px-3 py-2 border rounded-lg font-semibold">
                            Reportes de
                            Movilidad de
                            Eventos de
                            Administrativos Foraneos
                        </summary>
                        <table class="w-full text-sm text-left text-gray-500 rtl:text-right">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">Evento</th>
                                    <th class="px-4 py-2">Num. Asistentes</th>
                                    <th class="px-4 py-2">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- <tr>
                                    <td class="px-4 py-2">Evento 1</td>
                                    <td class="px-4 py-2">10</td>
                                    <td class="px-4 py-2">
                                        <button
                                            class="px-4 py-2 font-semibold text-sm text-white transition rounded-lg bg-gradient-to-tr from-blue-500 to-blue-700 hover:shadow-[1px_1px_20px] hover:shadow-blue-400/65 hover:bg-blend-darken hover:bg-primary-500">
                                            Generar Reporte
                                        </button>
                                    </td>
                                </tr>
                                 --}}
                            </tbody>
                        </table>
                    </details>
                </div>

                <div class="flex-col items-center justify-center hidden 
                 md:flex">
                    <hr class="h-56 w-[3px] bg-gradient-to-t from-primary-300 to-transparent">
                    <hr class="h-56 w-[3px] bg-gradient-to-b from-secondary-300 to-transparent">
                </div>

                <div class="grid grid-cols-1 self-start gap-4 px-3 relative">
                    <div
                        class="absolute top-0  w-1/2 h-1/2 blur-2xl opacity-15 rounded-full -z-[0] right-0 bg-gradient-to-r from-secondary-500 to-transparent">
                    </div>
                    <h2 class="text-2xl text-center font-semibold my-3 text-secondary-400 px-2">Reportes de Movilidad
                        Local
                    </h2>
                    <details class="col-span-1 max-h-32 overflow-y-auto">
                        <summary
                            class="text-lg text-pretty   flex items-center text-primary-700 px-3 py-2 border rounded-lg font-semibold">
                            Reportes de
                            Movilidad de
                            Eventos de
                            Docentes Locales
                        </summary>
                        <table class="w-full text-sm text-left text-gray-500 rtl:text-right">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">Evento</th>
                                    <th class="px-4 py-2">Num. Asistentes</th>
                                    <th class="px-4 py-2">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- <tr>
                                    <td class="px-4 py-2">Evento 1</td>
                                    <td class="px-4 py-2">10</td>
                                    <td class="px-4 py-2">
                                        <button
                                            class="px-4 py-2 font-semibold text-sm text-white transition rounded-lg bg-gradient-to-tr from-blue-500 to-blue-700 hover:shadow-[1px_1px_20px] hover:shadow-blue-400/65 hover:bg-blend-darken hover:bg-primary-500">
                                            Generar Reporte
                                        </button>
                                    </td>
                                </tr>
                                 --}}
                            </tbody>
                        </table>
                    </details>
                    <details class="col-span-1 max-h-32 overflow-y-auto">
                        <summary
                            class="text-lg text-pretty   flex items-center text-primary-700 px-3 py-2 border rounded-lg font-semibold">
                            Reportes de
                            Movilidad de
                            Eventos de
                            Estudiantes Locales
                        </summary>
                        <table class="w-full text-sm text-left text-gray-500 rtl:text-right">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">Evento</th>
                                    <th class="px-4 py-2">Num. Asistentes</th>
                                    <th class="px-4 py-2">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- <tr>
                                    <td class="px-4 py-2">Evento 1</td>
                                    <td class="px-4 py-2">10</td>
                                    <td class="px-4 py-2">
                                        <button
                                            class="px-4 py-2 font-semibold text-sm text-white transition rounded-lg bg-gradient-to-tr from-blue-500 to-blue-700 hover:shadow-[1px_1px_20px] hover:shadow-blue-400/65 hover:bg-blend-darken hover:bg-primary-500">
                                            Generar Reporte
                                        </button>
                                    </td>
                                </tr>
                                 --}}
                            </tbody>
                        </table>
                    </details>
                    <details class="col-span-1 max-h-32 overflow-y-auto">
                        <summary
                            class="text-lg text-pretty   flex items-center text-primary-700 px-3 py-2 border rounded-lg font-semibold">
                            Reportes de
                            Movilidad de
                            Eventos de
                            Administrativos Locales
                        </summary>
                        <table class="w-full text-sm text-left text-gray-500 rtl:text-right">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">Evento</th>
                                    <th class="px-4 py-2">Num. Asistentes</th>
                                    <th class="px-4 py-2">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- <tr>
                                    <td class="px-4 py-2">Evento 1</td>
                                    <td class="px-4 py-2">10</td>
                                    <td class="px-4 py-2">
                                        <button
                                            class="px-4 py-2 font-semibold text-sm text-white transition rounded-lg bg-gradient-to-tr from-blue-500 to-blue-700 hover:shadow-[1px_1px_20px] hover:shadow-blue-400/65 hover:bg-blend-darken hover:bg-primary-500">
                                            Generar Reporte
                                        </button>
                                    </td>
                                </tr>
                                 --}}
                            </tbody>
                        </table>
                    </details>
                </div>
            </div>
        </div>
</x-layouts.dashboard-layout>
