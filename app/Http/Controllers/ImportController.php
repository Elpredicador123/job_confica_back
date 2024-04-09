<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ActivitiesImport;
use App\Imports\FuturesImport;
use App\Imports\GeneralsImport;
use App\Imports\DiaryImport;
use App\Imports\AuditImport;
use App\Imports\EvidenceImport;
use App\Models\Activity;
use App\Models\Future;
use Excel;

class ImportController extends Controller
{
    
    public function index()
    {
        return view('import.index');
    }

    public function indexFuture()
    {
        return view('import.future');
    }

    public function indexGeneral()
    {
        return view('import.general');
    }

    public function indexDiary()
    {
        return view('import.diary');
    }

    public function indexAudit()
    {
        return view('import.audit');
    }

    public function indexEvidence()
    {
        return view('import.evidence');
    }

    public function import(Request $request)
    {
        // $this->validate($request, 
        //     [
        //     'file' => 'required|mimes:csv'
        //     ],
        //     [
        //         'file.required' => 'El archivo es requerido',
        //         'file.mimes' => 'El archivo debe ser de tipo csv'
        //     ]
        // );
        
        $time_start = microtime(true);
        $file = $request->file('file');
        Excel::import(new ActivitiesImport, $file);
        $filename = $file->getClientOriginalName();
        $time_end = microtime(true);
        $execution_time = round(($time_end - $time_start), 2);
        return redirect()->route('import.index')->with('message', 'Importación de actividades completada archivo '.$filename.' tiempo '.$execution_time);
    }

    public function importFuture(Request $request)
    {
        // $this->validate($request, [
        //     'file' => 'required|mimes:xls,xlsx,csv'
        // ]);
        $time_start = microtime(true);
        $file = $request->file('file');
        Excel::import(new FuturesImport, $file);
        $filename = $file->getClientOriginalName();
        $time_end = microtime(true);
        $execution_time = round(($time_end - $time_start), 2);
        return redirect()->route('importfuture.index')->with('message', 'Importación de actividades completada '.$filename.' tiempo '.$execution_time);
    }
    
    public function importGeneral(Request $request)
    {
        // $this->validate($request, [
        //     'file' => 'required|mimes:xls,xlsx,csv'
        // ]);
        $time_start = microtime(true);
        $file = $request->file('file');
        Excel::import(new GeneralsImport, $file);
        $filename = $file->getClientOriginalName();
        $time_end = microtime(true);
        $execution_time = round(($time_end - $time_start), 2);
        return redirect()->route('importgeneral.index')->with('message', 'Importación de actividades completada '.$filename.' tiempo '.$execution_time);
    }

    public function importDiary(Request $request)
    {
        // $this->validate($request, [
        //     'file' => 'required|mimes:xls,xlsx,csv'
        // ]);
        $time_start = microtime(true);
        $file = $request->file('file');
        Excel::import(new DiaryImport, $file);
        $filename = $file->getClientOriginalName();
        $time_end = microtime(true);
        $execution_time = round(($time_end - $time_start), 2);
        return redirect()->route('importdiary.index')->with('message', 'Importación de agenda completada '.$filename.' tiempo '.$execution_time);
    }

    public function importAudit(Request $request)
    {
        // $this->validate($request, [
        //     'file' => 'required|mimes:xls,xlsx,csv'
        // ]);
        $time_start = microtime(true);
        $file = $request->file('file');
        Excel::import(new AuditImport, $file);
        $filename = $file->getClientOriginalName();
        $time_end = microtime(true);
        $execution_time = round(($time_end - $time_start), 2);
        return redirect()->route('importaudit.index')->with('message', 'Importación de auditoria completada '.$filename.' tiempo '.$execution_time);
    }

    public function importEvidence(Request $request)
    {
        // $this->validate($request, [
        //     'file' => 'required|mimes:xls,xlsx,csv'
        // ]);
        $time_start = microtime(true);
        $file = $request->file('file');
        Excel::import(new EvidenceImport, $file);
        $filename = $file->getClientOriginalName();
        $time_end = microtime(true);
        $execution_time = round(($time_end - $time_start), 2);
        return redirect()->route('importevidence.index')->with('message', 'Importación de evidencia completada '.$filename.' tiempo '.$execution_time);
    }
}
