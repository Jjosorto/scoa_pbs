<?php

namespace App\Http\Controllers;

use App\Models\Activo;
use App\Models\Cliente;
use App\Models\Departamento;
use App\Models\Producto;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $activosActivos = Activo::query()->where('estado', true);

        $kpis = [
            'total_activos' => (clone $activosActivos)->count(),
            'activos_disponibles' => (clone $activosActivos)->where('estadoActivo', 'Disponible')->count(),
            'activos_asignados' => (clone $activosActivos)->where('estadoActivo', 'Asignado')->count(),
            'activos_en_reparacion' => (clone $activosActivos)->where('estadoActivo', 'Reparacion')->count(),
            'activos_descartados' => (clone $activosActivos)->where('estadoActivo', 'Descartado')->count(),
            'garantias_vigentes' => (clone $activosActivos)
                ->where('garantia', true)
                ->whereDate('fecha_final_garantia', '>=', now()->toDateString())
                ->count(),
            'garantias_vencidas' => (clone $activosActivos)
                ->where('garantia', true)
                ->whereDate('fecha_final_garantia', '<', now()->toDateString())
                ->count(),
            'clientes_activos' => Cliente::query()->where('estado', true)->count(),
            'productos_activos' => Producto::query()->where('estadoProductos', true)->count(),
            'departamentos_activos' => Departamento::query()->where('estado', true)->count(),
        ];

        $activosPorEstado = (clone $activosActivos)
            ->select('estadoActivo', DB::raw('COUNT(*) as total'))
            ->groupBy('estadoActivo')
            ->orderByDesc('total')
            ->get();

        $topDepartamentos = (clone $activosActivos)
            ->select('departamento_id', DB::raw('COUNT(*) as total'))
            ->with('departamento:id,nombreDepartamento')
            ->groupBy('departamento_id')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        $activosPorCiudad = (clone $activosActivos)
            ->select('ciudad', DB::raw('COUNT(*) as total'))
            ->whereNotNull('ciudad')
            ->groupBy('ciudad')
            ->orderByDesc('total')
            ->get();

        return view('dashboard', [
            'kpis' => $kpis,
            'activosPorEstado' => $activosPorEstado,
            'topDepartamentos' => $topDepartamentos,
            'activosPorCiudad' => $activosPorCiudad,
        ]);
    }
}
