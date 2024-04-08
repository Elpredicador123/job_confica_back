<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Zone;
use Illuminate\Support\Facades\DB;

class ManagementController extends Controller
{

    public function getInstallationProgressTable($citie_name='')
    {
        try {
            $zones = Zone::join('activities','activities.Nodo_zona','=', 'zones.Nodo')
            ->where('zones.Zonal', $citie_name)
            ->whereIn('activities.Estado actividad', ['Completado', 'Iniciado', 'Pendiente','Suspendido'])
            ->where('activities.Subtipo de Actividad', 'NOT LIKE', '%Rutina%')
            ->where(function ($query) {
                $query->where('activities.Subtipo de Actividad','LIKE', '%Migración%')
                ->orWhere('activities.Subtipo de Actividad','LIKE', '%Instalación%');
            })
            #->whereRaw('DATE_FORMAT(STR_TO_DATE(`Fecha de Cita`, "%d/%m/%y"), "%Y-%m-%d") = CURRENT_DATE')
            ->select(
                'zones.Gestor Altas',
                DB::raw('COUNT(DISTINCT CASE WHEN activities.Técnico NOT LIKE "%BK%" THEN activities.Técnico ELSE NULL END) AS Rutas'),
                DB::raw('SUM(CASE WHEN activities.`Estado actividad` = "Completado" THEN 1 ELSE 0 END) AS Completado'),
                DB::raw('SUM(CASE WHEN activities.`Estado actividad` = "Iniciado" THEN 1 ELSE 0 END) AS Iniciado'),
                DB::raw('SUM(CASE WHEN activities.`Estado actividad` = "Pendiente" THEN 1 ELSE 0 END) AS Pendiente'),
                DB::raw('SUM(CASE WHEN activities.`Estado actividad` = "Suspendido" THEN 1 ELSE 0 END) AS Suspendido')
            )
            ->groupBy('Gestor Altas')
            ->orderBy('Rutas', 'desc')
            ->get();

            $fields = ['Gestor Altas','Rutas','Completado','Iniciado','Pendiente','Suspendido'];

            return response()->json([
                "status" => "success",
                'message' => 'Listado Avance de instalaciones',
                'fields' => $fields,
                'series' => $zones,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: ManagementController getInstallationProgressTable',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getMaintenanceProgressTable($citie_name='')
    {
        try {
            $zones = Zone::join('activities','activities.Nodo_zona','=', 'zones.Nodo')
            ->where('zones.Zonal', $citie_name)
            ->whereIn('activities.Estado actividad', ['Completado', 'Iniciado', 'Pendiente','Suspendido'])
            ->where('activities.Subtipo de Actividad','LIKE', '%Reparación%')
            #->whereRaw('DATE_FORMAT(STR_TO_DATE(`Fecha de Cita`, "%d/%m/%y"), "%Y-%m-%d") = CURRENT_DATE')
            ->select(
                'zones.Gestor Averias',
                DB::raw('COUNT(DISTINCT CASE WHEN activities.Técnico NOT LIKE "%BK%" THEN activities.Técnico ELSE NULL END) AS Rutas'),
                DB::raw('SUM(CASE WHEN activities.`Estado actividad` = "Completado" THEN 1 ELSE 0 END) AS Completado'),
                DB::raw('SUM(CASE WHEN activities.`Estado actividad` = "Iniciado" THEN 1 ELSE 0 END) AS Iniciado'),
                DB::raw('SUM(CASE WHEN activities.`Estado actividad` = "Pendiente" THEN 1 ELSE 0 END) AS Pendiente'),
                DB::raw('SUM(CASE WHEN activities.`Estado actividad` = "Suspendido" THEN 1 ELSE 0 END) AS Suspendido')
            )
            ->groupBy('Gestor Averias')
            ->orderBy('Rutas', 'desc')
            ->get();

            $fields = ['Gestor Averias','Rutas','Completado','Iniciado','Pendiente','Suspendido'];

            return response()->json([
                "status" => "success",
                'message' => 'Listado Avance de mantenimientos',
                'fields' => $fields,
                'series' => $zones,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: ManagementController getMaintenanceProgressTable',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getInstallationLogManagerTable($manager_alta = '')
    {
        try {
            $zones = Zone::join('activities','activities.Nodo_zona','=', 'zones.Nodo')
            ->where('zones.Gestor Altas', $manager_alta)
            ->where('activities.Tipo de Cita','LIKE', '%Cliente%')
            ->whereIn('activities.Estado actividad', ['Completado'])
            ->where('activities.Subtipo de Actividad', 'NOT LIKE', '%Rutina%')
            ->where(function ($query) {
                $query->where('activities.Subtipo de Actividad','LIKE', '%Migración%')
                ->orWhere('activities.Subtipo de Actividad','LIKE', '%Instalación%');
            })
            #->whereRaw('DATE_FORMAT(STR_TO_DATE(`Fecha de Cita`, "%d/%m/%y"), "%Y-%m-%d") = CURRENT_DATE')
            ->select(
                'activities.Nodo_zona',
                DB::raw('SUM(CASE WHEN activities.`Time Slot` = "09-13" THEN 1 ELSE 0 END) AS "09-13"'),
                DB::raw('SUM(CASE WHEN activities.`Time Slot` = "13-18" THEN 1 ELSE 0 END) AS "13-18"'),
                DB::raw('
                SUM(CASE WHEN activities.`Time Slot` = "09-13" THEN 1 ELSE 0 END) + 
                SUM(CASE WHEN activities.`Time Slot` = "13-18" THEN 1 ELSE 0 END) AS Total')
            )
            ->groupBy(['Nodo_zona'])
            ->orderBy('Total', 'desc')
            ->get();

            $categories = ['Nodo_zona','09-13','13-18','Total'];

            return response()->json([
                "status" => "success",
                'message' => 'Agendas por gestor', 
                'categories' => $categories,    
                'series' => $zones,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: ManagementController getInstallationLogManagerTable',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getOrdermanagerTable($manager_averia = '')
    {
        try {
            $zones = Zone::join('activities','activities.Nodo_zona','=', 'zones.Nodo')
            ->join('technicals', 'activities.Carnet', '=', 'technicals.Carnet')
            ->where('zones.Gestor Averias', $manager_averia)
            ->where('activities.Tipo de Cita','LIKE', '%Cliente%')
            ->whereIn('activities.Estado actividad', ['Pendiente'])
            ->where('activities.Subtipo de Actividad','LIKE', '%Reparación%')
            #->whereRaw('DATE_FORMAT(STR_TO_DATE(`Fecha de Cita`, "%d/%m/%y"), "%Y-%m-%d") = CURRENT_DATE')
            ->select(
                'activities.Número de Petición as Orden',
                'activities.Nodo_zona as Nodo',
                'zones.Gestor Averias',
                'technicals.Contrata',
                DB::raw("CONCAT(TIMESTAMPDIFF(HOUR,activities.`Fecha Registro de Actividad en TOA`,NOW()),':',  LPAD(TIMESTAMPDIFF(MINUTE,activities.`Fecha Registro de Actividad en TOA`,NOW())% 60, 2, '0')) as `Tiempo sin atención`")
            )
            ->orderByRaw('TIMESTAMPDIFF(HOUR,activities.`Fecha Registro de Actividad en TOA`,NOW()) desc')
            ->get();

            $categories = ['Orden','Nodo','Gestor Averias','Contrata','Tiempo sin atención'];

            return response()->json([
                "status" => "success",
                'message' => 'Avance de ordenes por gestor horas pendientes',
                'categories' => $categories,      
                'series' => $zones,    
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: ManagementController getOrdermanagerTable',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
}
