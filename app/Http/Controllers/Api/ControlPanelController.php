<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Zone;
use App\Models\Activity;
use App\Models\Future;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ControlPanelController extends Controller
{

    public function getInstallationProgressGraphic()
    {
        try {
            $zones = Zone::join('activities','activities.Nodo_zona','=', 'zones.Nodo')
            ->whereIn('activities.Estado actividad', ['Completado', 'Iniciado', 'Pendiente'])
            ->where('activities.Subtipo de Actividad', 'NOT LIKE', '%Rutina%')
            ->where(function ($query) {
                $query->where('activities.Subtipo de Actividad','LIKE', '%igraci%')
                ->orWhere('activities.Subtipo de Actividad','LIKE', '%nstalaci%');
            })
            #->whereRaw('DATE_FORMAT(STR_TO_DATE(`Fecha de Cita`, "%d/%m/%y"), "%Y-%m-%d") = CURRENT_DATE')
            ->select(
                'zones.Zonal',
                DB::raw('SUM(CASE WHEN activities.`Estado actividad` = "Completado" THEN 1 ELSE 0 END) AS Completado'),
                DB::raw('SUM(CASE WHEN activities.`Estado actividad` = "Iniciado" THEN 1 ELSE 0 END) AS Iniciado'),
                DB::raw('SUM(CASE WHEN activities.`Estado actividad` = "Pendiente" THEN 1 ELSE 0 END) AS Pendiente')
            )
            ->groupBy(['zones.Zonal'])
            ->orderBy('zones.Zonal', 'asc')
            ->get();

            $categories = $zones->pluck('Zonal');
            $series = [
                [
                    'name' => 'Completado',
                    'data' => $zones->pluck('Completado'),
                ],
                [
                    'name' => 'Iniciado',
                    'data' => $zones->pluck('Iniciado'),
                ],
                [
                    'name' => 'Pendiente',
                    'data' => $zones->pluck('Pendiente'),
                ],
            ];


            $date = '';
            if (Activity::count() == 0) {
                $date = 'No hay datos';
            } else {
                $date = Activity::orderBy('created_at', 'desc')->first()->created_at;
                $date = Carbon::parse($date)->format('d/m/Y H:i:s');
            }
            return response()->json([
                "status" => "success",
                'message' => 'Avance de instalaciones',
                'categories' => $categories,
                'series' => $series,
                'date' => $date,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: ControlPanelController getInstallationProgressGraphic',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getInstallationProgressTable()
    {
        try {
            $zones = Zone::join('activities','activities.Nodo_zona','=', 'zones.Nodo')
            ->whereIn('activities.Estado actividad', ['Completado', 'Iniciado', 'Pendiente'])
            ->where('activities.Subtipo de Actividad', 'NOT LIKE', '%Rutina%')
            ->where(function ($query) {
                $query->where('activities.Subtipo de Actividad','LIKE', '%igraci%')
                ->orWhere('activities.Subtipo de Actividad','LIKE', '%nstalaci%');
            })
            #->whereRaw('DATE_FORMAT(STR_TO_DATE(`Fecha de Cita`, "%d/%m/%y"), "%Y-%m-%d") = CURRENT_DATE')
            ->select(
                'zones.Zonal as Ciudad',
                DB::raw('SUM(CASE WHEN activities.`Estado actividad` = "Completado" THEN 1 ELSE 0 END) AS Completado'),
                DB::raw('SUM(CASE WHEN activities.`Estado actividad` = "Iniciado" THEN 1 ELSE 0 END) AS Iniciado'),
                DB::raw('SUM(CASE WHEN activities.`Estado actividad` = "Pendiente" THEN 1 ELSE 0 END) AS Pendiente')
            )
            ->groupBy(['zones.Zonal'])
            ->orderBy('Ciudad', 'asc')
            ->get();
            
            $fields = ['Ciudad', 'Completado', 'Iniciado', 'Pendiente'];

            $date = '';
            if (Activity::count() == 0) {
                $date = 'No hay datos';
            } else {
                $date = Activity::orderBy('created_at', 'desc')->first()->created_at;
                $date = Carbon::parse($date)->format('d/m/Y H:i:s');
            }
            return response()->json([
                "status" => "success",
                'message' => 'Listado Avance de instalaciones',
                'fields' => $fields,
                'series' => $zones,
                'date' => $date,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: ControlPanelController getInstallationProgressTable',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getMaintenanceProgressGraphic()
    {
        try {
            $zones = Zone::join('activities','activities.Nodo_zona','=', 'zones.Nodo')
            ->whereIn('activities.Estado actividad', ['Completado', 'Iniciado', 'Pendiente'])
            ->where('activities.Subtipo de Actividad','LIKE', '%eparaci%')
            #->whereRaw('DATE_FORMAT(STR_TO_DATE(`Fecha de Cita`, "%d/%m/%y"), "%Y-%m-%d") = CURRENT_DATE')
            ->select(
                'zones.Zonal',
                DB::raw('SUM(CASE WHEN activities.`Estado actividad` = "Completado" THEN 1 ELSE 0 END) AS Completado'),
                DB::raw('SUM(CASE WHEN activities.`Estado actividad` = "Iniciado" THEN 1 ELSE 0 END) AS Iniciado'),
                DB::raw('SUM(CASE WHEN activities.`Estado actividad` = "Pendiente" THEN 1 ELSE 0 END) AS Pendiente')
            )
            ->groupBy(['zones.Zonal'])
            ->orderBy('zones.Zonal', 'asc')
            ->get();

            $categories = $zones->pluck('Zonal');
            $series = [
                [
                    'name' => 'Completado',
                    'data' => $zones->pluck('Completado'),
                ],
                [
                    'name' => 'Iniciado',
                    'data' => $zones->pluck('Iniciado'),
                ],
                [
                    'name' => 'Pendiente',
                    'data' => $zones->pluck('Pendiente'),
                ],
            ];

            $date = '';
            if (Activity::count() == 0) {
                $date = 'No hay datos';
            } else {
                $date = Activity::orderBy('created_at', 'desc')->first()->created_at;
                $date = Carbon::parse($date)->format('d/m/Y H:i:s');
            }
            return response()->json([
                "status" => "success",
                'message' => 'Avance de mantenimientos',
                'categories' => $categories,
                'series' => $series,
                'date' => $date,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: ControlPanelController getMaintenanceProgressGraphic',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getMaintenanceProgressTable()
    {
        try {
            $zones = Zone::join('activities','activities.Nodo_zona','=', 'zones.Nodo')
            ->whereIn('activities.Estado actividad', ['Completado', 'Iniciado', 'Pendiente'])
            ->where('activities.Subtipo de Actividad','LIKE', '%eparaci%')
            ->select('zones.Zonal','activities.Estado actividad')
            #->whereRaw('DATE_FORMAT(STR_TO_DATE(`Fecha de Cita`, "%d/%m/%y"), "%Y-%m-%d") = CURRENT_DATE')
            ->select(
                'zones.Zonal as Ciudad',
                DB::raw('SUM(CASE WHEN activities.`Estado actividad` = "Completado" THEN 1 ELSE 0 END) AS Completado'),
                DB::raw('SUM(CASE WHEN activities.`Estado actividad` = "Iniciado" THEN 1 ELSE 0 END) AS Iniciado'),
                DB::raw('SUM(CASE WHEN activities.`Estado actividad` = "Pendiente" THEN 1 ELSE 0 END) AS Pendiente')
            )
            ->groupBy(['zones.Zonal'])
            ->orderBy('Ciudad', 'asc')
            ->get();

            $fields = ['Ciudad', 'Completado', 'Iniciado', 'Pendiente'];

            $date = '';
            if (Activity::count() == 0) {
                $date = 'No hay datos';
            } else {
                $date = Activity::orderBy('created_at', 'desc')->first()->created_at;
                $date = Carbon::parse($date)->format('d/m/Y H:i:s');
            }
            return response()->json([
                "status" => "success",
                'message' => 'Listado Avance de mantenimientos',
                'fields' => $fields,
                'series' => $zones,
                'date' => $date,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: ControlPanelController getMaintenanceProgressTable',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getDiaryTable()
    {
        try {

            $startDate = Carbon::now()->addDays(0)->startOfDay();
            $endDate = Carbon::now()->addDays(7)->endOfDay();
            $day1 = Carbon::now()->addDays(1)->format('d/m/y');
            $day2 = Carbon::now()->addDays(2)->format('d/m/y');
            $day3 = Carbon::now()->addDays(3)->format('d/m/y');
            $day4 = Carbon::now()->addDays(4)->format('d/m/y');
            $day5 = Carbon::now()->addDays(5)->format('d/m/y');
            $day6 = Carbon::now()->addDays(6)->format('d/m/y');
            $day7 = Carbon::now()->addDays(7)->format('d/m/y');
            
            $instalaciones = Future::query()
            ->where('futures.Tipo de Cita','LIKE', '%Cliente%')
            ->where('futures.Subtipo de Actividad', 'NOT LIKE', '%Rutina%')
            ->where(function ($query) {
                $query->where('futures.Subtipo de Actividad','LIKE', '%nstalaci%')
                ->where('futures.Subtipo de Actividad','NOT LIKE', '%igraci%');
            })
            ->whereBetween(DB::raw("DATE_FORMAT(STR_TO_DATE(`Fecha de Cita`, '%d/%m/%y'), '%Y-%m-%d')"), [$startDate, $endDate])
            ->select(
                DB::raw("'Altas' as Tipo"),
                'futures.Time Slot as Hora',
                DB::raw("SUM(CASE WHEN DATE_FORMAT(STR_TO_DATE(`Fecha de Cita`, '%d/%m/%y'), '%Y-%m-%d') = (CURRENT_DATE + INTERVAL 1 DAY) THEN 1 ELSE 0 END) AS `$day1`"),
                DB::raw("SUM(CASE WHEN DATE_FORMAT(STR_TO_DATE(`Fecha de Cita`, '%d/%m/%y'), '%Y-%m-%d') = (CURRENT_DATE + INTERVAL 2 DAY) THEN 1 ELSE 0 END) AS `$day2`"),
                DB::raw("SUM(CASE WHEN DATE_FORMAT(STR_TO_DATE(`Fecha de Cita`, '%d/%m/%y'), '%Y-%m-%d') = (CURRENT_DATE + INTERVAL 3 DAY) THEN 1 ELSE 0 END) AS `$day3`"),
                DB::raw("SUM(CASE WHEN DATE_FORMAT(STR_TO_DATE(`Fecha de Cita`, '%d/%m/%y'), '%Y-%m-%d') = (CURRENT_DATE + INTERVAL 4 DAY) THEN 1 ELSE 0 END) AS `$day4`"),
                DB::raw("SUM(CASE WHEN DATE_FORMAT(STR_TO_DATE(`Fecha de Cita`, '%d/%m/%y'), '%Y-%m-%d') = (CURRENT_DATE + INTERVAL 5 DAY) THEN 1 ELSE 0 END) AS `$day5`"),
                DB::raw("SUM(CASE WHEN DATE_FORMAT(STR_TO_DATE(`Fecha de Cita`, '%d/%m/%y'), '%Y-%m-%d') = (CURRENT_DATE + INTERVAL 6 DAY) THEN 1 ELSE 0 END) AS `$day6`"),
                DB::raw("SUM(CASE WHEN DATE_FORMAT(STR_TO_DATE(`Fecha de Cita`, '%d/%m/%y'), '%Y-%m-%d') = (CURRENT_DATE + INTERVAL 7 DAY) THEN 1 ELSE 0 END) AS `$day7`"),
                DB::raw('count(*) as Total'),
            )
            ->groupBy(['futures.Time Slot'])
            ->orderByRaw('futures.`Time Slot` asc')
            ->get();

            $migraciones = Future::query()
            ->where('futures.Tipo de Cita','LIKE', '%Cliente%')
            ->where('futures.Subtipo de Actividad', 'NOT LIKE', '%Rutina%')
            ->where(function ($query) {
                $query->where('futures.Subtipo de Actividad','LIKE', '%igraci%')
                ->where('futures.Subtipo de Actividad','NOT LIKE', '%nstalaci%');
            })
            ->whereBetween(DB::raw("DATE_FORMAT(STR_TO_DATE(`Fecha de Cita`, '%d/%m/%y'), '%Y-%m-%d')"), [$startDate, $endDate])
            ->select(
                DB::raw("'Migracion' as Tipo"),
                'futures.Time Slot as Hora',
                DB::raw("SUM(CASE WHEN DATE_FORMAT(STR_TO_DATE(`Fecha de Cita`, '%d/%m/%y'), '%Y-%m-%d') = (CURRENT_DATE + INTERVAL 1 DAY) THEN 1 ELSE 0 END) AS `$day1`"),
                DB::raw("SUM(CASE WHEN DATE_FORMAT(STR_TO_DATE(`Fecha de Cita`, '%d/%m/%y'), '%Y-%m-%d') = (CURRENT_DATE + INTERVAL 2 DAY) THEN 1 ELSE 0 END) AS `$day2`"),
                DB::raw("SUM(CASE WHEN DATE_FORMAT(STR_TO_DATE(`Fecha de Cita`, '%d/%m/%y'), '%Y-%m-%d') = (CURRENT_DATE + INTERVAL 3 DAY) THEN 1 ELSE 0 END) AS `$day3`"),
                DB::raw("SUM(CASE WHEN DATE_FORMAT(STR_TO_DATE(`Fecha de Cita`, '%d/%m/%y'), '%Y-%m-%d') = (CURRENT_DATE + INTERVAL 4 DAY) THEN 1 ELSE 0 END) AS `$day4`"),
                DB::raw("SUM(CASE WHEN DATE_FORMAT(STR_TO_DATE(`Fecha de Cita`, '%d/%m/%y'), '%Y-%m-%d') = (CURRENT_DATE + INTERVAL 5 DAY) THEN 1 ELSE 0 END) AS `$day5`"),
                DB::raw("SUM(CASE WHEN DATE_FORMAT(STR_TO_DATE(`Fecha de Cita`, '%d/%m/%y'), '%Y-%m-%d') = (CURRENT_DATE + INTERVAL 6 DAY) THEN 1 ELSE 0 END) AS `$day6`"),
                DB::raw("SUM(CASE WHEN DATE_FORMAT(STR_TO_DATE(`Fecha de Cita`, '%d/%m/%y'), '%Y-%m-%d') = (CURRENT_DATE + INTERVAL 7 DAY) THEN 1 ELSE 0 END) AS `$day7`"),
                DB::raw('count(*) as Total'),
            )
            ->groupBy(['futures.Time Slot'])
            ->orderByRaw('futures.`Time Slot` asc')
            ->get();

            $fields = ['Tipo','Hora', $day1, $day2, $day3, $day4, $day5, $day6, $day7, 'Total'];
            $series = [];
            $series = array_merge($instalaciones->toArray(), $migraciones->toArray());

            $date = '';
            if (Future::count() == 0) {
                $date = 'No hay datos';
            } else {
                $date = Future::orderBy('created_at', 'desc')->first()->created_at;
                $date = Carbon::parse($date)->format('d/m/Y H:i:s');
            }
            return response()->json([
                "status" => "success",
                'message' => 'Agenda Diaria',
                'fields' => $fields,
                'series' => $series,
                'date' => $date,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: ControlPanelController getDiaryTable',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getInstallationRatioGraphic()
    {
        try {
            $zones = Zone::join('activities','activities.Nodo_zona','=', 'zones.Nodo')
            ->whereIn('activities.Estado actividad', ['Completado'])
            ->where('activities.Subtipo de Actividad', 'NOT LIKE', '%Rutina%')
            ->where(function ($query) {
                $query->where('activities.Subtipo de Actividad','LIKE', '%igraci%')
                ->orWhere('activities.Subtipo de Actividad','LIKE', '%nstalaci%');
            })
            #->whereRaw('DATE_FORMAT(STR_TO_DATE(`Fecha de Cita`, "%d/%m/%y"), "%Y-%m-%d") = CURRENT_DATE')
            ->select(
                'activities.Tipo de Tecnología Legados as Categoria',
                DB::raw('COUNT(*) AS `Totales`')
            )
            ->groupBy(['activities.Tipo de Tecnología Legados'])
            ->orderBy('Totales', 'desc')
            ->get();
            
            $categories = [];
            $series = [];

            foreach ($zones as $manager) {
                $categories[] = $manager->Categoria ;
                $series[] = $manager->Totales;
            }

            $date = '';
            if (Activity::count() == 0) {
                $date = 'No hay datos';
            } else {
                $date = Activity::orderBy('created_at', 'desc')->first()->created_at;
                $date = Carbon::parse($date)->format('d/m/Y H:i:s');
            }
            return response()->json([
                "status" => "success",
                'message' => 'Ratio de instalaciones',
                'labels' => $categories,
                'series' => $series,
                'date' => $date,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: ControlPanelController getInstallationRatioGraphic',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getMaintenanceRatioGraphic()
    {
        try {
            $zones = Zone::join('activities','activities.Nodo_zona','=', 'zones.Nodo')
            ->whereIn('activities.Estado actividad', ['Completado'])
            ->where('activities.Subtipo de Actividad', 'NOT LIKE', '%Rutina%')
            ->where('activities.Subtipo de Actividad','LIKE', '%eparaci%')
            ->where('activities.Tipo de Tecnología Legados','!=', '')
            #->whereRaw('DATE_FORMAT(STR_TO_DATE(`Fecha de Cita`, "%d/%m/%y"), "%Y-%m-%d") = CURRENT_DATE')
            ->select(
                'activities.Tipo de Tecnología Legados as Categoria',
                DB::raw('COUNT(*) AS `Totales`')
            )
            ->groupBy(['activities.Tipo de Tecnología Legados'])
            ->orderBy('Totales', 'desc')
            ->get();
            
            $categories = [];
            $series = [];

            foreach ($zones as $manager) {
                $categories[] = $manager->Categoria ;
                $series[] = $manager->Totales;
            }

            $date = '';
            if (Activity::count() == 0) {
                $date = 'No hay datos';
            } else {
                $date = Activity::orderBy('created_at', 'desc')->first()->created_at;
                $date = Carbon::parse($date)->format('d/m/Y H:i:s');
            }
            return response()->json([
                "status" => "success",
                'message' => 'Ratio de mantenimientos',
                'labels' => $categories,
                'series' => $series,
                'date' => $date,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: ControlPanelController getMaintenanceRatioGraphic',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getProductionTable()
    {
        try {
            $zones = Zone::join('activities','activities.Nodo_zona','=', 'zones.Nodo')
            ->whereIn('activities.Estado actividad', ['Completado'])
            ->where('activities.Subtipo de Actividad', 'NOT LIKE', '%Rutina%')
            ->where(function ($query) {
                $query->where('activities.Subtipo de Actividad','LIKE', '%igraci%')
                ->orWhere('activities.Subtipo de Actividad','LIKE', '%nstalaci%')
                ->orWhere('activities.Subtipo de Actividad','LIKE', '%eparaci%');
            })
            #->whereRaw('DATE_FORMAT(STR_TO_DATE(`Fecha de Cita`, "%d/%m/%y"), "%Y-%m-%d") = CURRENT_DATE')
            ->select(
                'zones.Zonal as Ciudad',
                DB::raw('SUM(
                    CASE WHEN 
                        activities.`Subtipo de Actividad` LIKE "%igraci%" OR
                        activities.`Subtipo de Actividad` LIKE "%nstalaci%" THEN 1 ELSE 0 END)*133.71 AS Altas'),
                DB::raw('SUM(CASE WHEN activities.`Subtipo de Actividad` LIKE "%Reparación%" THEN 1 ELSE 0 END)*66.18 AS Averias'),
                DB::raw('SUM(
                    CASE WHEN 
                        activities.`Subtipo de Actividad` LIKE "%igraci%" OR
                        activities.`Subtipo de Actividad` LIKE "%nstalaci%" THEN 1 ELSE 0 END)*133.71 + 
                    SUM(CASE WHEN activities.`Subtipo de Actividad` LIKE "%Reparación%" THEN 1 ELSE 0 END)*66.18 AS Total')
            )
            ->groupBy(['zones.Zonal'])
            ->orderBy('zones.Zonal', 'asc')
            ->get();

            $categories = ['Ciudad', 'Altas', 'Averias', 'Total'];

            $totales = 0;
            foreach ($zones as $manager) {
                $totales += $manager->Total;
            }

            $total = new \stdClass();
            $total->Ciudad = 'Total';
            $total->Altas = $zones->sum('Altas');
            $total->Averias = $zones->sum('Averias');
            $total->Total = $zones->sum('Total');
            $zones->push($total);

            foreach ($zones as $manager) {
                $manager->Altas = 'S/ '.number_format($manager->Altas, 2, '.', ',');
                $manager->Averias = 'S/ '.number_format($manager->Averias, 2, '.', ',');
                $manager->Total = 'S/ '.number_format($manager->Total, 2, '.', ',');
            }

            $date = '';
            if (Activity::count() == 0) {
                $date = 'No hay datos';
            } else {
                $date = Activity::orderBy('created_at', 'desc')->first()->created_at;
                $date = Carbon::parse($date)->format('d/m/Y H:i:s');
            }
            return response()->json([
                "status" => "success",
                'message' => 'Lista de produccion del dia',
                'fields' => $categories,
                'series' => $zones,
                'totales' => round($totales,2),
                'date' => $date,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: ControlPanelController getProductionTable',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getProductionTableInstallations()
    {
        try {
            $zones = Zone::join('activities','activities.Nodo_zona','=', 'zones.Nodo')
            ->whereIn('activities.Estado actividad', ['Completado'])
            ->where('activities.Subtipo de Actividad', 'NOT LIKE', '%Rutina%')
            ->where(function ($query) {
                $query->where('activities.Subtipo de Actividad','LIKE', '%igraci%')
                ->orWhere('activities.Subtipo de Actividad','LIKE', '%nstalaci%');
            })
            #->whereRaw('DATE_FORMAT(STR_TO_DATE(`Fecha de Cita`, "%d/%m/%y"), "%Y-%m-%d") = CURRENT_DATE')
            ->select(
                'zones.Zonal as Ciudad',
                DB::raw('SUM(
                    CASE WHEN 
                        activities.`Subtipo de Actividad` LIKE "%igraci%" OR
                        activities.`Subtipo de Actividad` LIKE "%nstalaci%" THEN 1 ELSE 0 END)*133.71 AS Altas'),
            )
            ->groupBy(['zones.Zonal'])
            ->orderBy('zones.Zonal', 'asc')
            ->get();

            $categories = [];
            $series = [];
            $totales = 0;

            foreach ($zones as $manager) {
                $categories[] = $manager->Ciudad ;
                $series[] = (float)$manager->Altas;
                $totales += $manager->Altas;
            }

            $date = '';
            if (Activity::count() == 0) {
                $date = 'No hay datos';
            } else {
                $date = Activity::orderBy('created_at', 'desc')->first()->created_at;
                $date = Carbon::parse($date)->format('d/m/Y H:i:s');
            }
            return response()->json([
                "status" => "success",
                'message' => 'Lista de produccion del dia de instalaciones',
                'fields' => $categories,
                'series' => $series,
                'totales' => round($totales,2),
                'date' => $date,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: ControlPanelController getProductionTableInstallations',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function getProductionTableMaintenance()
    {
        try {
            $zones = Zone::join('activities','activities.Nodo_zona','=', 'zones.Nodo')
            ->whereIn('activities.Estado actividad', ['Completado'])
            ->where('activities.Subtipo de Actividad', 'NOT LIKE', '%Rutina%')
            ->where(function ($query) {
                $query->where('activities.Subtipo de Actividad','LIKE', '%eparaci%');
            })
            #->whereRaw('DATE_FORMAT(STR_TO_DATE(`Fecha de Cita`, "%d/%m/%y"), "%Y-%m-%d") = CURRENT_DATE')
            ->select(
                'zones.Zonal as Ciudad',
                DB::raw('SUM(CASE WHEN activities.`Subtipo de Actividad` LIKE "%Reparación%" THEN 1 ELSE 0 END)*66.18 AS Averias'),
            )
            ->groupBy(['zones.Zonal'])
            ->orderBy('zones.Zonal', 'asc')
            ->get();

            $categories = [];
            $series = [];
            $totales = 0;

            foreach ($zones as $manager) {
                $categories[] = $manager->Ciudad ;
                $series[] = (float)$manager->Averias;
                $totales += $manager->Averias;
            }

            $date = '';
            if (Activity::count() == 0) {
                $date = 'No hay datos';
            } else {
                $date = Activity::orderBy('created_at', 'desc')->first()->created_at;
                $date = Carbon::parse($date)->format('d/m/Y H:i:s');
            }
            return response()->json([
                "status" => "success",
                'message' => 'Lista de produccion del dia de reparaciones',
                'fields' => $categories,
                'series' => $series,
                'totales' => round($totales,2),
                'date' => $date,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: ControlPanelController getProductionTableMaintenance',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}