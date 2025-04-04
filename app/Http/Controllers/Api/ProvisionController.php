<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Zone;
use App\Models\Diary;
use App\Models\DiaryPrimary;
use App\Models\General;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProvisionController extends Controller
{

    public function getDiaryContrataGraphic($citie_name='')
    {
        try {
            $diaries = DiaryPrimary::query()
            ->when($citie_name != 'Todos', function ($query) use ($citie_name) {
                $query->whereRaw("? LIKE CONCAT(diary_primaries.Zonal, '%')", [$citie_name]);
            })
            //->whereRaw('DATE_FORMAT(STR_TO_DATE(diary_primaries.fecha_tde, "%Y%m%d"), "%Y-%m-%d") = CURRENT_DATE')
            ->select(
                'diary_primaries.Contrata as Contrata',
                DB::raw('ROUND(SUM(diary_primaries.toa_cumpl_1ra) / SUM(diary_primaries.`Cuenta primera agenda`) * 100,2) as porcentaje')
            )
            ->groupBy(['diary_primaries.Contrata'])
            ->orderBy('porcentaje', 'desc')
            ->take(5)
            ->get();

            $categories = [];
            $series = [];

            foreach ($diaries as $diary) {
                $categories[] = $diary->Contrata;
                $series[] = $diary->porcentaje;
            }

            $date = '';
            if (DiaryPrimary::count() == 0) {
                $date = 'No hay datos';
            } else {
                $date = DiaryPrimary::orderBy('created_at', 'desc')->first()->created_at;
                $date = Carbon::parse($date)->format('d/m/Y H:i:s');
            }
            return response()->json([
                "status" => "success",
                'message' => 'Cumplimiento agenda - Contrata',
                'categories' => $categories,
                'series' => $series,
                'date' => $date,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: ProvisionController getDiaryContrataGraphic',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getDiaryManagerGraphic($citie_name='')
    {
        try {

            $diaries = DiaryPrimary::query()
            ->when($citie_name != 'Todos', function ($query) use ($citie_name) {
                $query->whereRaw("? LIKE CONCAT(diary_primaries.Zonal, '%')", [$citie_name]);
            })
            #->whereRaw('DATE_FORMAT(STR_TO_DATE(diary_primaries.fecha_tde, "%Y%m%d"), "%Y-%m-%d") = CURRENT_DATE')
            ->select(
                'Gestor',
                DB::raw('ROUND(SUM(diary_primaries.toa_cumpl_1ra) / SUM(diary_primaries.`Cuenta primera agenda`) * 100,2) as porcentaje')
            )
            ->groupBy(['Gestor'])
            ->orderBy('porcentaje', 'desc')
            ->take(5)
            ->get();

            $categories = [];
            $series = [];

            foreach ($diaries as $diary) {
                $categories[] = $diary['Gestor'];
                $series[] = $diary->porcentaje;
            }

            $date = '';
            if (DiaryPrimary::count() == 0) {
                $date = 'No hay datos';
            } else {
                $date = DiaryPrimary::orderBy('created_at', 'desc')->first()->created_at;
                $date = Carbon::parse($date)->format('d/m/Y H:i:s');
            }
            return response()->json([
                "status" => "success",
                'message' => 'Cumplimiento agenda - Gestor',
                'categories' => $categories,
                'series' => $series,
                'date' => $date,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: ProvisionController getDiaryManagerGraphic',
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
            ->when($citie_name != 'Todos', function ($query) use ($citie_name) {
                $query->where('zones.Zonal', $citie_name);
            })
            ->where('generals.Subtipo de Actividad', 'NOT LIKE', '%Rutina%')
            ->where(function ($query) {
                $query->where('generals.Subtipo de Actividad','LIKE', '%igraci%')
                ->orWhere('generals.Subtipo de Actividad','LIKE', '%nstalaci%');
            })
            ->where(DB::raw("DATE_FORMAT(STR_TO_DATE(`Fecha de Cita`, '%d/%m/%y'), '%Y-%m-%d')"), $startDateInstalations)
            ->select(
                'zones.Gestor Altas',
                DB::raw('count(*) as total')
            )
            ->groupBy(['Gestor Altas'])
            ->get();

            $instalacionsclients = Zone::join('generals','generals.Nodo_zona','=', 'zones.Nodo')
            ->whereIn('generals.Estado actividad', ['Completado'])
            ->when($citie_name != 'Todos', function ($query) use ($citie_name) {
                $query->where('zones.Zonal', $citie_name);
            })
            ->whereIn('zones.Gestor Altas', $managers->pluck('Gestor Altas')->toArray())
            ->where('generals.Subtipo de Actividad', 'NOT LIKE', '%Rutina%')
            ->where(function ($query) {
                $query->where('generals.Subtipo de Actividad','LIKE', '%igraci%')
                ->orWhere('generals.Subtipo de Actividad','LIKE', '%nstalaci%');
            })
            ->where(DB::raw("DATE_FORMAT(STR_TO_DATE(`Fecha de Cita`, '%d/%m/%y'), '%Y-%m-%d')"), $startDateInstalations)
            ->select('generals.Código de Cliente')
            ->get();

            $reparationsclients = Zone::join('generals','generals.Nodo_zona','=', 'zones.Nodo')
            ->whereIn('generals.Estado actividad', ['Completado'])
            ->when($citie_name != 'Todos', function ($query) use ($citie_name) {
                $query->where('zones.Zonal', $citie_name);
            })
            ->whereIn('generals.Código de Cliente', $instalacionsclients->pluck('Código de Cliente')->toArray())
            ->where('generals.Subtipo de Actividad','LIKE', '%eparaci%')
            ->whereBetween(DB::raw("DATE_FORMAT(STR_TO_DATE(`Fecha de Cita`, '%d/%m/%y'), '%Y-%m-%d')"), [$startDateReparations, $endDateReparations])
            ->select(
                'zones.Gestor Altas',
                DB::raw('count(*) as total'),
            )
            ->groupBy(['Gestor Altas'])
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
                    'Infancia %' => $porcentaje,
                ];
            });
            
            $fields = ['Gestor Altas', 'Altas Totales', 'Altas con infancia', 'Infancia %'];
            
            $date = '';
            if (General::count() == 0) {
                $date = 'No hay datos';
            } else {
                $date = General::orderBy('created_at', 'desc')->first()->created_at;
                $date = Carbon::parse($date)->format('d/m/Y H:i:s');
            }
            return response()->json([
                "status" => "success",
                'message' => 'Averias con infancia por gestor',
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
                'message' => 'Error: ProvisionController getChildhoodBreakdownsManagers',
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
            ->when($citie_name != 'Todos', function ($query) use ($citie_name) {
                $query->where('zones.Zonal', $citie_name);
            })
            ->where('generals.Técnico','NOT LIKE', '%BK%')
            ->where('generals.Subtipo de Actividad', 'NOT LIKE', '%Rutina%')
            ->where(function ($query) {
                $query->where('generals.Subtipo de Actividad','LIKE', '%igraci%')
                ->orWhere('generals.Subtipo de Actividad','LIKE', '%nstalaci%');
            })
            ->where(DB::raw("DATE_FORMAT(STR_TO_DATE(`Fecha de Cita`, '%d/%m/%y'), '%Y-%m-%d')"), $startDateInstalations)
            ->select(
                'generals.Técnico',
                DB::raw('count(*) as total')
            )
            ->groupBy(['generals.Técnico'])
            ->get();

            $instalacionsclients = Zone::join('generals','generals.Nodo_zona','=', 'zones.Nodo')
            ->whereIn('generals.Estado actividad', ['Completado'])
            ->when($citie_name != 'Todos', function ($query) use ($citie_name) {
                $query->where('zones.Zonal', $citie_name);
            })
            ->whereIn('generals.Técnico', $managers->pluck('Técnico')->toArray())
            ->where('generals.Técnico','NOT LIKE', '%BK%')
            ->where('generals.Subtipo de Actividad', 'NOT LIKE', '%Rutina%')
            ->where(function ($query) {
                $query->where('generals.Subtipo de Actividad','LIKE', '%igraci%')
                ->orWhere('generals.Subtipo de Actividad','LIKE', '%nstalaci%');
            })
            ->where(DB::raw("DATE_FORMAT(STR_TO_DATE(`Fecha de Cita`, '%d/%m/%y'), '%Y-%m-%d')"), $startDateInstalations)
            ->select('generals.Código de Cliente')
            ->get();

            $reparationsclients = Zone::join('generals','generals.Nodo_zona','=', 'zones.Nodo')
            ->whereIn('generals.Estado actividad', ['Completado'])
            ->when($citie_name != 'Todos', function ($query) use ($citie_name) {
                $query->where('zones.Zonal', $citie_name);
            })
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
                    'Infancia %' => $porcentaje,
                ];
            });

            $fields = ['Técnico','CF', 'Altas Totales', 'Altas con infancia', 'Infancia %'];
            
            $date = '';
            if (General::count() == 0) {
                $date = 'No hay datos';
            } else {
                $date = General::orderBy('created_at', 'desc')->first()->created_at;
                $date = Carbon::parse($date)->format('d/m/Y H:i:s');
            }
            return response()->json([
                "status" => "success",
                'message' => 'Averias con infancia por tecnico',
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
                'message' => 'Error: ProvisionController getChildhoodBreakdownsTechnicians',
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
            ->where('generals.Subtipo de Actividad', 'NOT LIKE', '%Rutina%')
            ->where(function ($query) {
                $query->where('generals.Subtipo de Actividad','LIKE', '%igraci%')
                ->orWhere('generals.Subtipo de Actividad','LIKE', '%nstalaci%');
            })
            ->where(DB::raw("DATE_FORMAT(STR_TO_DATE(`Fecha de Cita`, '%d/%m/%y'), '%Y-%m-%d')"), $startDateInstalations)
            ->select('zones.Gestor Altas','zones.Zonal as city_name','generals.Fecha de Cita')
            ->count();

            $instalacionsclients = Zone::join('generals','generals.Nodo_zona','=', 'zones.Nodo')
            ->whereIn('generals.Estado actividad', ['Completado'])
            ->where('generals.Subtipo de Actividad', 'NOT LIKE', '%Rutina%')
            ->where(function ($query) {
                $query->where('generals.Subtipo de Actividad','LIKE', '%igraci%')
                ->orWhere('generals.Subtipo de Actividad','LIKE', '%nstalaci%');
            })
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

            $porcentaje = round(($managers > 0 ? $reparationsclients / $managers * 100: 0),2). ' %';

            $date = '';
            if (General::count() == 0) {
                $date = 'No hay datos';
            } else {
                $date = General::orderBy('created_at', 'desc')->first()->created_at;
                $date = Carbon::parse($date)->format('d/m/Y H:i:s');
            }
            return response()->json([
                "status" => "success",
                'message' => 'Avence de averias con infancia',
                'Altas Totales' => $managers,
                'Altas con infancia' => $reparationsclients,
                'Infancia %' => $porcentaje,
                'date' => $date,

            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: ProvisionController getChildhoodBreakdownsGeneral',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
}
