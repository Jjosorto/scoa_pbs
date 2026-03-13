<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white shadow-sm sm:rounded-lg p-5">
                    <p class="text-sm text-gray-500">Total activos</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $kpis['total_activos'] }}</p>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-5">
                    <p class="text-sm text-gray-500">Activos disponibles</p>
                    <p class="text-3xl font-bold text-emerald-600">{{ $kpis['activos_disponibles'] }}</p>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-5">
                    <p class="text-sm text-gray-500">Activos asignados</p>
                    <p class="text-3xl font-bold text-blue-600">{{ $kpis['activos_asignados'] }}</p>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-5">
                    <p class="text-sm text-gray-500">En reparación</p>
                    <p class="text-3xl font-bold text-amber-600">{{ $kpis['activos_en_reparacion'] }}</p>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-5">
                    <p class="text-sm text-gray-500">Activos descartados</p>
                    <p class="text-3xl font-bold text-rose-600">{{ $kpis['activos_descartados'] }}</p>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-5">
                    <p class="text-sm text-gray-500">Garantías vigentes</p>
                    <p class="text-3xl font-bold text-indigo-600">{{ $kpis['garantias_vigentes'] }}</p>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-5">
                    <p class="text-sm text-gray-500">Garantías vencidas</p>
                    <p class="text-3xl font-bold text-rose-600">{{ $kpis['garantias_vencidas'] }}</p>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-5">
                    <p class="text-sm text-gray-500">Clientes activos</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $kpis['clientes_activos'] }}</p>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-5 sm:col-span-2 lg:col-span-2">
                    <p class="text-sm text-gray-500">Productos activos</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $kpis['productos_activos'] }}</p>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-5 sm:col-span-2 lg:col-span-2">
                    <p class="text-sm text-gray-500">Departamentos activos</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $kpis['departamentos_activos'] }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="bg-white shadow-sm sm:rounded-lg p-5 lg:col-span-1">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Activos por estado</h3>
                    <ul class="space-y-3">
                        @forelse ($activosPorEstado as $estado)
                            <li class="flex items-center justify-between border-b pb-2">
                                <span class="text-gray-600">{{ $estado->estadoActivo }}</span>
                                <span class="font-semibold text-gray-900">{{ $estado->total }}</span>
                            </li>
                        @empty
                            <li class="text-sm text-gray-500">Sin datos disponibles.</li>
                        @endforelse
                    </ul>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-5 lg:col-span-1">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Top departamentos</h3>
                    <ul class="space-y-3">
                        @forelse ($topDepartamentos as $departamento)
                            <li class="flex items-center justify-between border-b pb-2">
                                <span class="text-gray-600">{{ $departamento->departamento?->nombre ?? 'Sin departamento' }}</span>
                                <span class="font-semibold text-gray-900">{{ $departamento->total }}</span>
                            </li>
                        @empty
                            <li class="text-sm text-gray-500">Sin datos disponibles.</li>
                        @endforelse
                    </ul>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-5 lg:col-span-1">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Activos por ciudad</h3>
                    <ul class="space-y-3">
                        @forelse ($activosPorCiudad as $ciudad)
                            <li class="flex items-center justify-between border-b pb-2">
                                <span class="text-gray-600">{{ $ciudad->ciudad }}</span>
                                <span class="font-semibold text-gray-900">{{ $ciudad->total }}</span>
                            </li>
                        @empty
                            <li class="text-sm text-gray-500">Sin datos disponibles.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
