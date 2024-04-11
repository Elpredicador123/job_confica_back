<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Audit;
use App\Models\Evidence;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class QualityController extends Controller
{

    public function getInspectionEffectivenessTable($citie_name='',$month ='')
    {
        try {
            $audits = Audit::join('technicals', 'technicals.Carnet', '=', 'audits.Carnet de Tecnico')
            ->whereRaw("? LIKE CONCAT(technicals.Zonal, '%')", [$citie_name])
            ->whereRaw('CONCAT(audits.AÑO,"-",LPAD(audits.MES,2,"0")) = ?', [$month])
            ->select(
                'technicals.Contrata',
                DB::raw('COUNT(*) AS `Inspecciones Totales`'),
                DB::raw('SUM(CASE WHEN audits.`Se Realizo Inspeccion a Tecnico` = "NO" THEN 1 ELSE 0 END) AS `Inspecciones ausentes`'),
                DB::raw('ROUND(CASE WHEN COUNT(*) = 0 THEN 0 ELSE (SUM(CASE WHEN audits.`Se Realizo Inspeccion a Tecnico` = "NO" THEN 1 ELSE 0 END) / COUNT(*) * 100) END,2) AS `% Participacion`')
            )
            ->groupBy(['technicals.Contrata'])
            ->orderBy('Inspecciones ausentes', 'desc')
            ->take(10)
            ->get();

            $categories = ['Contrata', 'Inspecciones Totales', 'Inspecciones ausentes', '% Participacion'];
            
            $date = Carbon::now()->format('d/m/Y H:i:s');
            return response()->json([
                "status" => "success",
                'message' => 'Avance de inspecciones efectivas general',
                'categories' => $categories,
                'series' => $audits,
                'date' => $date,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: QualityController getInspectionEffectivenessTable',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getInspectionEffectivenessByTecTable($citie_name='',$month ='')
    {
        try {
            $audits = Audit::join('technicals', 'technicals.Carnet', '=', 'audits.Carnet de Tecnico')
            ->whereRaw("? LIKE CONCAT(technicals.Zonal, '%')", [$citie_name])
            ->whereRaw('CONCAT(audits.AÑO,"-",LPAD(audits.MES,2,"0")) = ?', [$month])
            ->select(
                'technicals.Nombre_Completo as Nombre de Tecnico',
                'audits.Carnet de Tecnico as CF',
                'technicals.Contrata',
                DB::raw('COUNT(*) AS `Inspecciones Totales`'),
                DB::raw('ROUND(SUM(CASE WHEN audits.`Se Realizo Inspeccion a Tecnico` = "NO" THEN 1 ELSE 0 END),2) AS `Inspecciones ausentes`'),
                DB::raw('ROUND(CASE WHEN COUNT(*) = 0 THEN 0 ELSE (SUM(CASE WHEN audits.`Se Realizo Inspeccion a Tecnico` = "NO" THEN 1 ELSE 0 END) / COUNT(*) * 100) END,2) AS `% Participacion`')
            )
            ->groupBy(['technicals.Nombre_Completo','audits.Carnet de Tecnico','technicals.Contrata'])
            ->orderBy('Inspecciones ausentes', 'desc')
            ->take(10)
            ->get();

            $categories = ['Nombre de Tecnico','CF','Contrata', 'Inspecciones Totales', 'Inspecciones ausentes', '% Participacion'];

            $date = Carbon::now()->format('d/m/Y H:i:s');
            return response()->json([
                "status" => "success",
                'message' => 'Avance de inspecciones efectivas por tec',
                'categories' => $categories,
                'series' => $audits,
                'date' => $date,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: QualityController getInspectionEffectivenessByTecTable',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getAuditsProgressTable($citie_name='',$month ='')
    {
        try {
            $audits = Audit::join('technicals', 'technicals.Carnet', '=', 'audits.Carnet de Tecnico')
            ->whereRaw("? LIKE CONCAT(technicals.Zonal, '%')", [$citie_name])
            ->whereRaw('CONCAT(audits.AÑO,"-",LPAD(audits.MES,2,"0")) = ?', [$month])
            ->select(
                'technicals.Contrata',
                DB::raw('SUM(CASE WHEN audits.Fotocheck2 = "NO" THEN 1 ELSE 0 END) AS Fotocheck'),
                DB::raw('SUM(CASE WHEN audits.Uniforme2 = "NO" THEN 1 ELSE 0 END) AS Uniforme'),
                DB::raw('SUM(CASE WHEN audits.`Tiene PON Power Meter2` = "NO" THEN 1 ELSE 0 END) AS `PON Power Meter`'),
                DB::raw('SUM(CASE WHEN audits.`Tiene Jumper Preconectorizado2` = "NO" THEN 1 ELSE 0 END) AS `Jumper Preconectorizado`'),
                DB::raw('SUM(CASE WHEN audits.`Tiene Cortadora de fibra2` = "NO" THEN 1 ELSE 0 END) AS `Cortadora de fibra`'),
                DB::raw('SUM(CASE WHEN audits.`Tiene Peladora de Drop2` = "NO" THEN 1 ELSE 0 END) AS `Peladora de Drop`'),
                DB::raw('SUM(CASE WHEN audits.`Tiene Peladora de Acrilato2` = "NO" THEN 1 ELSE 0 END) AS `Peladora de Acrilato`'),
                DB::raw('SUM(CASE WHEN audits.`Tiene One Click2` = "NO" THEN 1 ELSE 0 END) AS `One Click`'),
                DB::raw('SUM(CASE WHEN audits.`Tiene Alcohol Isopropilico2` = "NO" THEN 1 ELSE 0 END) AS `Alcohol Isopropilico`'),
                DB::raw('SUM(CASE WHEN audits.`Tiene Paños Para Limpiar2` = "NO" THEN 1 ELSE 0 END) AS `Paños Para Limpiar`'),
                DB::raw('SUM(
                    CASE WHEN audits.Fotocheck2 = "NO" THEN 1 ELSE 0 END + 
                    CASE WHEN audits.Uniforme2 = "NO" THEN 1 ELSE 0 END +   
                    CASE WHEN audits.`Tiene PON Power Meter2` = "NO" THEN 1 ELSE 0 END +
                    CASE WHEN audits.`Tiene Jumper Preconectorizado2` = "NO" THEN 1 ELSE 0 END +
                    CASE WHEN audits.`Tiene Cortadora de fibra2` = "NO" THEN 1 ELSE 0 END +
                    CASE WHEN audits.`Tiene Peladora de Drop2` = "NO" THEN 1 ELSE 0 END +
                    CASE WHEN audits.`Tiene Peladora de Acrilato2` = "NO" THEN 1 ELSE 0 END +
                    CASE WHEN audits.`Tiene One Click2` = "NO" THEN 1 ELSE 0 END +
                    CASE WHEN audits.`Tiene Alcohol Isopropilico2` = "NO" THEN 1 ELSE 0 END +
                    CASE WHEN audits.`Tiene Paños Para Limpiar2` = "NO" THEN 1 ELSE 0 END
                ) AS Total')
            )
            ->groupBy('technicals.Contrata')
            ->orderBy('Total', 'desc')
            ->take(10)
            ->get();

            $categories = ["Contrata","Fotocheck","Uniforme","PON Power Meter","Jumper Preconectorizado","Cortadora de fibra","Peladora de Drop","Peladora de Acrilato","One Click","Alcohol Isopropilico","Paños Para Limpiar","Total"];
            
            $date = Carbon::now()->format('d/m/Y H:i:s');
            return response()->json([
                "status" => "success",
                'message' => 'Avance de auditorias general',
                'categories' => $categories,
                'series' => $audits,
                'date' => $date,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: QualityController getAuditsProgressTable',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getAuditsProgressByTecTable($citie_name='',$month ='')
    {
        try {
            $audits = Audit::join('technicals', 'technicals.Carnet', '=', 'audits.Carnet de Tecnico')
            ->whereRaw("? LIKE CONCAT(technicals.Zonal, '%')", [$citie_name])
            ->whereRaw('CONCAT(audits.AÑO,"-",LPAD(audits.MES,2,"0")) = ?', [$month])
            ->select(
                'technicals.Nombre_Completo as Nombre de Tecnico',
                'audits.Carnet de Tecnico as CF',
                'technicals.Contrata',
                DB::raw('SUM(CASE WHEN audits.Fotocheck2 = "NO" THEN 1 ELSE 0 END) AS Fotocheck'),
                DB::raw('SUM(CASE WHEN audits.Uniforme2 = "NO" THEN 1 ELSE 0 END) AS Uniforme'),
                DB::raw('SUM(CASE WHEN audits.`Tiene PON Power Meter2` = "NO" THEN 1 ELSE 0 END) AS `PON Power Meter`'),
                DB::raw('SUM(CASE WHEN audits.`Tiene Jumper Preconectorizado2` = "NO" THEN 1 ELSE 0 END) AS `Jumper Preconectorizado`'),
                DB::raw('SUM(CASE WHEN audits.`Tiene Cortadora de fibra2` = "NO" THEN 1 ELSE 0 END) AS `Cortadora de fibra`'),
                DB::raw('SUM(CASE WHEN audits.`Tiene Peladora de Drop2` = "NO" THEN 1 ELSE 0 END) AS `Peladora de Drop`'),
                DB::raw('SUM(CASE WHEN audits.`Tiene Peladora de Acrilato2` = "NO" THEN 1 ELSE 0 END) AS `Peladora de Acrilato`'),
                DB::raw('SUM(CASE WHEN audits.`Tiene One Click2` = "NO" THEN 1 ELSE 0 END) AS `One Click`'),
                DB::raw('SUM(CASE WHEN audits.`Tiene Alcohol Isopropilico2` = "NO" THEN 1 ELSE 0 END) AS `Alcohol Isopropilico`'),
                DB::raw('SUM(CASE WHEN audits.`Tiene Paños Para Limpiar2` = "NO" THEN 1 ELSE 0 END) AS `Paños Para Limpiar`'),
                DB::raw('SUM(
                    CASE WHEN audits.Fotocheck2 = "NO" THEN 1 ELSE 0 END + 
                    CASE WHEN audits.Uniforme2 = "NO" THEN 1 ELSE 0 END +   
                    CASE WHEN audits.`Tiene PON Power Meter2` = "NO" THEN 1 ELSE 0 END +
                    CASE WHEN audits.`Tiene Jumper Preconectorizado2` = "NO" THEN 1 ELSE 0 END +
                    CASE WHEN audits.`Tiene Cortadora de fibra2` = "NO" THEN 1 ELSE 0 END +
                    CASE WHEN audits.`Tiene Peladora de Drop2` = "NO" THEN 1 ELSE 0 END +
                    CASE WHEN audits.`Tiene Peladora de Acrilato2` = "NO" THEN 1 ELSE 0 END +
                    CASE WHEN audits.`Tiene One Click2` = "NO" THEN 1 ELSE 0 END +
                    CASE WHEN audits.`Tiene Alcohol Isopropilico2` = "NO" THEN 1 ELSE 0 END +
                    CASE WHEN audits.`Tiene Paños Para Limpiar2` = "NO" THEN 1 ELSE 0 END
                ) AS Total')
            )
            ->groupBy(['technicals.Nombre_Completo','audits.Carnet de Tecnico','technicals.Contrata'])
            ->orderBy('Total', 'desc')
            ->take(10)
            ->get();

            $categories = ['Nombre de Tecnico','CF','Contrata',"Fotocheck","Uniforme","PON Power Meter","Jumper Preconectorizado","Cortadora de fibra","Peladora de Drop","Peladora de Acrilato","One Click","Alcohol Isopropilico","Paños Para Limpiar","Total"];
            
            $date = Carbon::now()->format('d/m/Y H:i:s');
            return response()->json([
                "status" => "success",
                'message' => 'Avance de auditorias por tec',
                'categories' => $categories,
                'series' => $audits,
                'date' => $date,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: QualityController getAuditsProgressByTecTable',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getErrorsEvidenceTable($citie_name='')
    {
        try {
            $evidences = Evidence::join('technicals', 'technicals.Carnet', '=', 'evidence.CODTECNICO')
            ->whereRaw("? LIKE CONCAT(technicals.Zonal, '%')", [$citie_name])
            /*->whereRaw('CONCAT(evidence.AÑO,"-",
            CASE 
                WHEN evidence.MES = "Enero" THEN "01" 
                WHEN evidence.MES = "Febrero" THEN "02" 
                WHEN evidence.MES = "Marzo" THEN "03" 
                WHEN evidence.MES = "Abril" THEN "04" 
                WHEN evidence.MES = "Mayo" THEN "05" 
                WHEN evidence.MES = "Junio" THEN "06" 
                WHEN evidence.MES = "Julio" THEN "07" 
                WHEN evidence.MES = "Agosto" THEN "08" 
                WHEN evidence.MES = "Septiembre" THEN "09" 
                WHEN evidence.MES = "Octubre" THEN "10" 
                WHEN evidence.MES = "Noviembre" THEN "11" 
                WHEN evidence.MES = "Diciembre" THEN "12" 
                ELSE "01" END
            ,"-",LPAD(evidence.Día,2,"0")) = CURRENT_DATE')*/
            ->select(
                'technicals.Contrata',
                DB::raw('SUM(CASE WHEN evidence.`C_TRIPLEXOR` = "NO CONFORME" THEN 1 ELSE 0 END) AS `FALLAS TRIPLEXOR`'),
                DB::raw('SUM(CASE WHEN evidence.`C_ROSETA OPTICA` = "NO CONFORME" THEN 1 ELSE 0 END) AS `FALLAS ROSETA OPTICA`'),
                DB::raw('SUM(CASE WHEN evidence.`C_HGU-CABLE MODEM` = "NO CONFORME" THEN 1 ELSE 0 END) AS `FALLAS HGU-CABLE MODEM`'),
                DB::raw('SUM(CASE WHEN evidence.`C_SPLITER` = "NO CONFORME" THEN 1 ELSE 0 END) AS `FALLAS SPLITER`'),
                DB::raw('SUM(CASE WHEN evidence.`C_VOIP` = "NO CONFORME" THEN 1 ELSE 0 END) AS `FALLAS VOIP`'),
                DB::raw('SUM(
                    CASE WHEN evidence.`C_TRIPLEXOR` = "NO CONFORME" THEN 1 ELSE 0 END + 
                    CASE WHEN evidence.`C_ROSETA OPTICA` = "NO CONFORME" THEN 1 ELSE 0 END +   
                    CASE WHEN evidence.`C_HGU-CABLE MODEM` = "NO CONFORME" THEN 1 ELSE 0 END +
                    CASE WHEN evidence.`C_SPLITER` = "NO CONFORME" THEN 1 ELSE 0 END +
                    CASE WHEN evidence.`C_VOIP` = "NO CONFORME" THEN 1 ELSE 0 END
                ) AS Total')
            )
            ->groupBy(['technicals.Contrata'])
            ->orderBy('Total', 'desc')
            ->take(10)
            ->get();

            $categories = ['Contrata','FALLAS TRIPLEXOR','FALLAS ROSETA OPTICA','FALLAS HGU-CABLE MODEM','FALLAS SPLITER','FALLAS VOIP','Total'];
            
            $date = Carbon::now()->format('d/m/Y H:i:s');
            return response()->json([
                "status" => "success",
                'message' => 'Evidencia de errores general',
                'categories' => $categories,
                'series' => $evidences,
                'date' => $date,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: QualityController getErrorsEvidenceTable',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getErrorsEvidenceByTecTable($citie_name='')
    {
        try {
            $evidences = Evidence::join('technicals', 'technicals.Carnet', '=', 'evidence.CODTECNICO')
            ->whereRaw("? LIKE CONCAT(technicals.Zonal, '%')", [$citie_name])
            /*->whereRaw('CONCAT(evidence.AÑO,"-",
            CASE 
                WHEN evidence.MES = "Enero" THEN "01" 
                WHEN evidence.MES = "Febrero" THEN "02" 
                WHEN evidence.MES = "Marzo" THEN "03" 
                WHEN evidence.MES = "Abril" THEN "04" 
                WHEN evidence.MES = "Mayo" THEN "05" 
                WHEN evidence.MES = "Junio" THEN "06" 
                WHEN evidence.MES = "Julio" THEN "07" 
                WHEN evidence.MES = "Agosto" THEN "08" 
                WHEN evidence.MES = "Septiembre" THEN "09" 
                WHEN evidence.MES = "Octubre" THEN "10" 
                WHEN evidence.MES = "Noviembre" THEN "11" 
                WHEN evidence.MES = "Diciembre" THEN "12" 
                ELSE "01" END
            ,"-",LPAD(evidence.Día,2,"0")) = CURRENT_DATE')*/
            ->select(
                'technicals.Nombre_Completo as Nombre de Tecnico',
                'evidence.CODTECNICO as CF',
                'technicals.Contrata',
                DB::raw('SUM(CASE WHEN evidence.`C_TRIPLEXOR` = "NO CONFORME" THEN 1 ELSE 0 END) AS `FALLAS TRIPLEXOR`'),
                DB::raw('SUM(CASE WHEN evidence.`C_ROSETA OPTICA` = "NO CONFORME" THEN 1 ELSE 0 END) AS `FALLAS ROSETA OPTICA`'),
                DB::raw('SUM(CASE WHEN evidence.`C_HGU-CABLE MODEM` = "NO CONFORME" THEN 1 ELSE 0 END) AS `FALLAS HGU-CABLE MODEM`'),
                DB::raw('SUM(CASE WHEN evidence.`C_SPLITER` = "NO CONFORME" THEN 1 ELSE 0 END) AS `FALLAS SPLITER`'),
                DB::raw('SUM(CASE WHEN evidence.`C_VOIP` = "NO CONFORME" THEN 1 ELSE 0 END) AS `FALLAS VOIP`'),
                DB::raw('SUM(
                    CASE WHEN evidence.`C_TRIPLEXOR` = "NO CONFORME" THEN 1 ELSE 0 END + 
                    CASE WHEN evidence.`C_ROSETA OPTICA` = "NO CONFORME" THEN 1 ELSE 0 END +   
                    CASE WHEN evidence.`C_HGU-CABLE MODEM` = "NO CONFORME" THEN 1 ELSE 0 END +
                    CASE WHEN evidence.`C_SPLITER` = "NO CONFORME" THEN 1 ELSE 0 END +
                    CASE WHEN evidence.`C_VOIP` = "NO CONFORME" THEN 1 ELSE 0 END
                ) AS Total')
            )
            ->groupBy(['technicals.Nombre_Completo','evidence.CODTECNICO','technicals.Contrata'])
            ->orderBy('Total', 'desc')
            ->take(10)
            ->get();

            $categories = ['Nombre de Tecnico','CF','Contrata','FALLAS TRIPLEXOR','FALLAS ROSETA OPTICA','FALLAS HGU-CABLE MODEM','FALLAS SPLITER','FALLAS VOIP','Total'];
            
            $date = Carbon::now()->format('d/m/Y H:i:s');
            return response()->json([
                "status" => "success",
                'message' => 'Evidencia de errores por tecnico',
                'categories' => $categories,
                'series' => $evidences,
                'date' => $date,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: QualityController getErrorsEvidenceByTecTable',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getErrorInspectionRatioTable()
    {
        try {
            $audits = Audit::query()
            //->whereRaw('CONCAT(audits.AÑO,"-",LPAD(audits.MES,2,"0"),"-",LPAD(audits.DIA,2,"0")) = CURRENT_DATE')
            ->select(
                'audits.CONFORMIDAD',
                DB::raw('COUNT(*) AS `Totales`')
            )
            ->groupBy('audits.CONFORMIDAD')
            ->get();

            $categories = [];
            $series = [];

            foreach ($audits as $audit) {
                $categories[] = $audit->CONFORMIDAD ;
                $series[] = $audit->Totales;
            }

            $date = Carbon::now()->format('d/m/Y H:i:s');
            return response()->json([
                "status" => "success",
                'message' => 'Ratio de inspecciones',
                'categories' => $categories,
                'series' => $series,
                'date' => $date,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: QualityController getErrorInspectionRatioTable',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getErrorFotosToaRatioTable()
    {
        try {
            $evidences = Evidence::query()
            /*->whereRaw('CONCAT(evidence.AÑO,"-",
            CASE 
                WHEN evidence.MES = "Enero" THEN "01" 
                WHEN evidence.MES = "Febrero" THEN "02" 
                WHEN evidence.MES = "Marzo" THEN "03" 
                WHEN evidence.MES = "Abril" THEN "04" 
                WHEN evidence.MES = "Mayo" THEN "05" 
                WHEN evidence.MES = "Junio" THEN "06" 
                WHEN evidence.MES = "Julio" THEN "07" 
                WHEN evidence.MES = "Agosto" THEN "08" 
                WHEN evidence.MES = "Septiembre" THEN "09" 
                WHEN evidence.MES = "Octubre" THEN "10" 
                WHEN evidence.MES = "Noviembre" THEN "11" 
                WHEN evidence.MES = "Diciembre" THEN "12" 
                ELSE "01" END
            ,"-",LPAD(evidence.Día,2,"0")) = CURRENT_DATE')*/
            ->select(
                'evidence.RESULTADO',
                DB::raw('COUNT(*) AS `Totales`')
            )
            ->groupBy('evidence.RESULTADO')
            ->get();

            $categories = [];
            $series = [];

            foreach ($evidences as $audit) {
                $categories[] = $audit->RESULTADO ;
                $series[] = $audit->Totales;
            }

            $date = Carbon::now()->format('d/m/Y H:i:s');
            return response()->json([
                "status" => "success",
                'message' => 'Ratio de fotos de TOA',
                'categories' => $categories,
                'series' => $series,
                'date' => $date,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: QualityController getErrorFotosToaRatioTable',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}