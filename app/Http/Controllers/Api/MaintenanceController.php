<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Zone;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MaintenanceController extends Controller
{

    public function getIneffectiveContrataGraphic($citie_name='')
    {
        try {
            $managers = Zone::join('activities','activities.Nodo_zona','=', 'zones.Nodo')
            ->join('effectives', 'effectives.cod_liq', '=', 'activities.Cod_liq')//queda
            ->join('technicals', 'activities.Carnet', '=', 'technicals.Carnet')
            ->where('zones.Zonal', $citie_name)
            ->whereIn('activities.Estado actividad', ['Completado'])//queda
            ->where('activities.Subtipo de Actividad','LIKE', '%eparaci%')//queda
            ->whereNotIn('activities.Subtipo de Actividad', ['Reparación Telefonía Básica','Reparación Speedy'])//queda
            #->whereRaw('DATE_FORMAT(STR_TO_DATE(`Fecha de Cita`, "%d/%m/%y"), "%Y-%m-%d") = CURRENT_DATE')
            ->select(
                'technicals.Contrata',
                DB::raw('ROUND(SUM(CASE WHEN effectives.tip_visita = "Inefectiva" THEN 1 ELSE 0 END) / count(*) * 100,2) as porcentaje')
            )
            ->groupBy(['technicals.Contrata'])
            ->orderBy('porcentaje', 'desc')
            ->take(10)
            ->get();

            $categories = [];
            $series = [];

            foreach ($managers as $manager) {
                $categories[] = $manager->Contrata;
                $series[] = $manager->porcentaje;
            }

            $date = Carbon::now()->format('d/m/Y H:i:s');
            return response()->json([
                "status" => "success",
                'message' => 'Distribucion inefectivas por contrata',
                'categories' => $categories,
                'series' => $series,
                'date' => $date,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: MaintenanceController getIneffectiveContrataGraphic',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getIneffectiveDistributionRatioGraphic()
    {
        try {
            $managers = Zone::join('activities','activities.Nodo_zona','=', 'zones.Nodo')
            ->join('effectives', 'effectives.cod_liq', '=', 'activities.Cod_liq')//queda
            ->join('technicals', 'activities.Carnet', '=', 'technicals.Carnet')
            ->whereIn('activities.Estado actividad', ['Completado'])//queda
            ->where('activities.Subtipo de Actividad','LIKE', '%eparaci%')//queda
            ->where('activities.tipo_inefectiva','!=', '')
            ->whereNotIn('activities.Subtipo de Actividad', ['Reparación Telefonía Básica','Reparación Speedy'])//queda
            #->whereRaw('DATE_FORMAT(STR_TO_DATE(`Fecha de Cita`, "%d/%m/%y"), "%Y-%m-%d") = CURRENT_DATE')
            ->select(
                'activities.tipo_inefectiva',
                DB::raw('count(*) as total')
            )
            ->groupBy(['activities.tipo_inefectiva'])
            ->orderByDesc('total')
            ->take(6)
            ->get();
            $categories = [];
            $series = [];

            foreach ($managers as $manager) {
                $categories[] = $manager->tipo_inefectiva;
                $series[] = $manager->total;
            }

            $date = Carbon::now()->format('d/m/Y H:i:s');
            return response()->json([
                "status" => "success",
                'message' => 'Distribucion inefectivas',
                'categories' => $categories,
                'series' => $series,
                'date' => $date,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: MaintenanceController getIneffectiveDistributionRatioGraphic',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getChildhoodBreakdownsManagers($citie_name='')
    {
        try {
            $startDateInstalations = Carbon::now()->subDays(30)->format('Y-m-d');
            $startDateReparations = Carbon::now()->subDays(29)->format('Y-m-d');
            $endDateReparations = Carbon::now()->format('Y-m-d');

            $managers = Zone::join('generals','generals.Nodo_zona','=', 'zones.Nodo')
            ->whereIn('generals.Estado actividad', ['Completado'])
            ->where('zones.Zonal', $citie_name)
            ->where('generals.Subtipo de Actividad','LIKE', '%eparaci%')
            ->where(DB::raw("DATE_FORMAT(STR_TO_DATE(`Fecha de Cita`, '%d/%m/%y'), '%Y-%m-%d')"), $startDateInstalations)
            ->select(
                'zones.Gestor Altas',
                DB::raw('count(*) as total')
            )
            ->groupBy(['zones.Gestor Altas'])
            ->get();

            $instalacionsclients = Zone::join('generals','generals.Nodo_zona','=', 'zones.Nodo')
            ->whereIn('generals.Estado actividad', ['Completado'])
            ->where('zones.Zonal', $citie_name)
            ->whereIn('zones.Gestor Altas', $managers->pluck('Gestor Altas')->toArray())
            ->where('generals.Subtipo de Actividad','LIKE', '%eparaci%')
            ->where(DB::raw("DATE_FORMAT(STR_TO_DATE(`Fecha de Cita`, '%d/%m/%y'), '%Y-%m-%d')"), $startDateInstalations)
            ->select('generals.Código de Cliente')
            ->get();

            $reparationsclients = Zone::join('generals','generals.Nodo_zona','=', 'zones.Nodo')
            ->whereIn('generals.Estado actividad', ['Completado'])
            ->where('zones.Zonal', $citie_name)
            ->whereIn('generals.Código de Cliente', $instalacionsclients->pluck('Código de Cliente')->toArray())
            ->where('generals.Subtipo de Actividad','LIKE', '%eparaci%')
            ->whereBetween(DB::raw("DATE_FORMAT(STR_TO_DATE(`Fecha de Cita`, '%d/%m/%y'), '%Y-%m-%d')"), [$startDateReparations, $endDateReparations])
            ->select(
                'zones.Gestor Altas',
                DB::raw('count(*) as total'),
            )
            ->groupBy(['zones.Gestor Altas'])
            ->get();

            $series = $managers->map(function ($item) use ($reparationsclients) {
                $total = $item->total;
                $ocurrencias = $reparationsclients
                                ->where('Gestor Altas', $item['Gestor Altas'])
                                ->first()? 
                                $reparationsclients
                                ->where('Gestor Altas', $item['Gestor Altas'])
                                ->first()->total: 0;
                $porcentaje = round(($total > 0 ? $ocurrencias / $total * 100: 0),2). ' %';
                return [
                    'Gestor Altas' => $item['Gestor Altas'],
                    'Altas Totales' => $total,
                    'Altas con infancia' => $ocurrencias,
                    '% infancia' => $porcentaje,
                ];
            });

            $fields = ['Gestor Altas', 'Altas Totales', 'Altas con infancia', '% infancia'];
            
            $date = Carbon::now()->format('d/m/Y H:i:s');
            return response()->json([
                "status" => "success",
                'message' => 'Averias reiteradas con infancia por gestor',
                'startDateInstalations' => $startDateInstalations,
                'startDateReparations' => $startDateReparations,
                'endDateReparations' => $endDateReparations,
                'fields' => $fields,
                'series' => $series,
                'date' => $date,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: MaintenanceController getChildhoodBreakdownsManagers',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getChildhoodBreakdownsTechnicians($citie_name='')
    {
        try {
            $startDateInstalations = Carbon::now()->subDays(30)->format('Y-m-d');
            $startDateReparations = Carbon::now()->subDays(29)->format('Y-m-d');
            $endDateReparations = Carbon::now()->format('Y-m-d');

            $managers = Zone::join('generals','generals.Nodo_zona','=', 'zones.Nodo')
            ->whereIn('generals.Estado actividad', ['Completado'])
            ->where('zones.Zonal', $citie_name)
            ->where('generals.Técnico','NOT LIKE', '%BK%')
            ->where('generals.Subtipo de Actividad','LIKE', '%eparaci%')
            ->where(DB::raw("DATE_FORMAT(STR_TO_DATE(`Fecha de Cita`, '%d/%m/%y'), '%Y-%m-%d')"), $startDateInstalations)
            ->select(
                'generals.Técnico',
                DB::raw('count(*) as total')
            )
            ->groupBy(['generals.Técnico'])
            ->get();

            $instalacionsclients = Zone::join('generals','generals.Nodo_zona','=', 'zones.Nodo')
            ->whereIn('generals.Estado actividad', ['Completado'])
            ->where('zones.Zonal', $citie_name)
            ->whereIn('generals.Técnico', $managers->pluck('Técnico')->toArray())
            ->where('generals.Técnico','NOT LIKE', '%BK%')
            ->where('generals.Subtipo de Actividad','LIKE', '%eparaci%')
            ->where(DB::raw("DATE_FORMAT(STR_TO_DATE(`Fecha de Cita`, '%d/%m/%y'), '%Y-%m-%d')"), $startDateInstalations)
            ->select('generals.Código de Cliente')
            ->get();

            $reparationsclients = Zone::join('generals','generals.Nodo_zona','=', 'zones.Nodo')
            ->whereIn('generals.Estado actividad', ['Completado'])
            ->where('zones.Zonal', $citie_name)
            ->whereIn('generals.Código de Cliente', $instalacionsclients->pluck('Código de Cliente')->toArray())
            ->where('generals.Técnico','NOT LIKE', '%BK%')
            ->where('generals.Subtipo de Actividad','LIKE', '%eparaci%')
            ->whereBetween(DB::raw("DATE_FORMAT(STR_TO_DATE(`Fecha de Cita`, '%d/%m/%y'), '%Y-%m-%d')"), [$startDateReparations, $endDateReparations])
            ->select(
                'generals.Técnico',
                DB::raw('count(*) as total'),
            )
            ->groupBy(['generals.Técnico'])
            ->get();

            $series = $managers->map(function ($item) use ($reparationsclients) {
                $total = $item->total;
                $ocurrencias = $reparationsclients
                                ->where('Técnico', $item->Técnico)
                                ->first()?
                                $reparationsclients
                                ->where('Técnico', $item->Técnico)
                                ->first()->total: 0;
                $porcentaje = round(($total > 0 ? $ocurrencias / $total * 100: 0),2). ' %';
                return [
                    'Técnico' => explode("-",  $item->Técnico)[1],
                    'CF' => explode("-",  $item->Técnico)[0],
                    'Altas Totales' => $total,
                    'Altas con infancia' => $ocurrencias,
                    '% infancia' => $porcentaje,
                ];
            });

            $fields = ['Técnico','CF', 'Altas Totales', 'Altas con infancia', '% infancia'];
            
            $date = Carbon::now()->format('d/m/Y H:i:s');
            return response()->json([
                "status" => "success",
                'message' => 'Averias reiteradas con infancia por tecnico',
                'startDateInstalations' => $startDateInstalations,
                'startDateReparations' => $startDateReparations,
                'endDateReparations' => $endDateReparations,
                'fields' => $fields,
                'series' => $series,
                'date' => $date,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: MaintenanceController getChildhoodBreakdownsTechnicians',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getChildhoodBreakdownsGeneral()
    {
        try {
            $startDateInstalations = Carbon::now()->subDays(30)->format('Y-m-d');
            $startDateReparations = Carbon::now()->subDays(29)->format('Y-m-d');
            $endDateReparations = Carbon::now()->format('Y-m-d');

            $managers = Zone::join('generals','generals.Nodo_zona','=', 'zones.Nodo')
            ->whereIn('generals.Estado actividad', ['Completado'])
            ->where('generals.Subtipo de Actividad','LIKE', '%eparaci%')
            ->where(DB::raw("DATE_FORMAT(STR_TO_DATE(`Fecha de Cita`, '%d/%m/%y'), '%Y-%m-%d')"), $startDateInstalations)
            ->select('zones.Gestor Altas','zones.Zonal as city_name','generals.Fecha de Cita')
            ->count();

            $instalacionsclients = Zone::join('generals','generals.Nodo_zona','=', 'zones.Nodo')
            ->whereIn('generals.Estado actividad', ['Completado'])
            ->where('generals.Subtipo de Actividad','LIKE', '%eparaci%')
            ->where(DB::raw("DATE_FORMAT(STR_TO_DATE(`Fecha de Cita`, '%d/%m/%y'), '%Y-%m-%d')"), $startDateInstalations)
            ->select('generals.Código de Cliente')
            ->get();

            $reparationsclients = Zone::join('generals','generals.Nodo_zona','=', 'zones.Nodo')
            ->whereIn('generals.Estado actividad', ['Completado'])
            ->whereIn('generals.Código de Cliente', $instalacionsclients->pluck('Código de Cliente')->toArray())
            ->where('generals.Subtipo de Actividad','LIKE', '%eparaci%')
            ->whereBetween(DB::raw("DATE_FORMAT(STR_TO_DATE(`Fecha de Cita`, '%d/%m/%y'), '%Y-%m-%d')"), [$startDateReparations, $endDateReparations])
            ->select('generals.Código de Cliente')
            ->count();

            $porcentaje = round(($managers > 0 ? $reparationsclients / $managers * 100: 0),2);
            $resto = 100 - $porcentaje;
            $categories = ['% infancia',''];
            $series = [$porcentaje, $resto];

            $date = Carbon::now()->format('d/m/Y H:i:s');
            return response()->json([
                "status" => "success",
                'message' => 'Avence de averias reiteradas con infancia',
                'Altas Totales' => $managers,
                'Altas con infancia' => $reparationsclients,
                '% infancia' => $porcentaje,
                'categories' => $categories,
                'series' => $series,
                'date' => $date,

            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: MaintenanceController getChildhoodBreakdownsGeneral',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

}
