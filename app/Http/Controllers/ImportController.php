<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ActivitiesImport;
use App\Imports\FuturesImport;
use App\Imports\GeneralsImport;
use App\Imports\DiaryImport;
use App\Imports\DiaryPrimaryImport;
use App\Imports\AuditImport;
use App\Imports\EvidenceImport;
use App\Imports\TechnicalImport;
use App\Models\Activity;
use App\Models\Future;
use App\Models\Diary;
use App\Models\DiaryPrimary;
use App\Models\Audit;
use App\Models\Evidence;
use App\Models\Technical;
use Excel;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
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

    public function indexDiaryPrimary()
    {
        return view('import.diaryprimary');
    }

    public function indexAudit()
    {
        return view('import.audit');
    }

    public function indexEvidence()
    {
        return view('import.evidence');
    }

    public function indexTechnical()
    {
        return view('import.technical');
    }

    public function import(Request $request)
    {
        
        $this->validate($request, [
            'file' => 'required|mimetypes:text/plain'
        ],
        [
            'file.required' => 'El archivo es requerido',
            'file.mimetypes' => 'El archivo debe ser de tipo text/plain'
        ]);
        try{
            Activity::truncate();
            $time_start = microtime(true);
            $file = $request->file('file');
            Excel::import(new ActivitiesImport, $file);
            $filename = $file->getClientOriginalName();
            $time_end = microtime(true);
            $execution_time = round(($time_end - $time_start), 2);
            return redirect()->route('import.index')->with('message', 'Importación de actividades completada archivo '.$filename.' tiempo '.$execution_time);
        } catch(Exception $ex){
            Log::info("Error al importar Activity: "+$ex);
        }
    }

    public function importFuture(Request $request)
    {
        
        $this->validate($request, [
            'file' => 'required|mimetypes:text/plain'
        ],
        [
            'file.required' => 'El archivo es requerido',
            'file.mimetypes' => 'El archivo debe ser de tipo text/plain'
        ]);
        try{
            $time_start = microtime(true);
            $file = $request->file('file');
            Excel::import(new FuturesImport, $file);
            $filename = $file->getClientOriginalName();
            $time_end = microtime(true);
            $execution_time = round(($time_end - $time_start), 2);
            return redirect()->route('importfuture.index')->with('message', 'Importación de actividades completada '.$filename.' tiempo '.$execution_time);
        } catch(Exception $ex){
            Log::info("Error al importar importFuture: "+$ex);
        }
    }
    
    public function importGeneral(Request $request)
    {
        
        $this->validate($request, [
            'file' => 'required|mimetypes:text/plain'
        ],
        [
            'file.required' => 'El archivo es requerido',
            'file.mimetypes' => 'El archivo debe ser de tipo text/plain'
        ]);
        try{
            $time_start = microtime(true);
            $file = $request->file('file');
            Excel::import(new GeneralsImport, $file);
            $filename = $file->getClientOriginalName();
            $time_end = microtime(true);
            $execution_time = round(($time_end - $time_start), 2);
            return redirect()->route('importgeneral.index')->with('message', 'Importación de actividades completada '.$filename.' tiempo '.$execution_time);
        } catch(Exception $ex){
            Log::info("Error al importar importGeneral: "+$ex);
        }
    }

    public function importDiary(Request $request)
    {
        
        $this->validate($request, [
            'file' => 'required|mimetypes:text/plain'
        ],
        [
            'file.required' => 'El archivo es requerido',
            'file.mimetypes' => 'El archivo debe ser de tipo text/plain'
        ]);
        try{
            Diary::truncate();
            $time_start = microtime(true);
            $file = $request->file('file');
            Excel::import(new DiaryImport, $file);
            $filename = $file->getClientOriginalName();
            $time_end = microtime(true);
            $execution_time = round(($time_end - $time_start), 2);
            return redirect()->route('importdiary.index')->with('message', 'Importación de agenda completada '.$filename.' tiempo '.$execution_time);
        } catch(Exception $ex){
            Log::info("Error al importar importDiary: "+$ex);
        }
    }

    public function importDiaryPrimary(Request $request)
    {
        
        $this->validate($request, [
            'file' => 'required|mimetypes:text/plain'
        ],
        [
            'file.required' => 'El archivo es requerido',
            'file.mimetypes' => 'El archivo debe ser de tipo text/plain'
        ]);
        try{
            DiaryPrimary::truncate();
            $time_start = microtime(true);
            $file = $request->file('file');
            Excel::import(new DiaryPrimaryImport, $file);
            $filename = $file->getClientOriginalName();
            $time_end = microtime(true);
            $execution_time = round(($time_end - $time_start), 2);
            return redirect()->route('importdiaryprimary.index')->with('message', 'Importación de agenda primera completada '.$filename.' tiempo '.$execution_time);
        } catch(Exception $ex){
            Log::info("Error al importar importDiaryPrimary: "+$ex);
        }
    }

    public function importAudit(Request $request)
    {
        
        $this->validate($request, [
            'file' => 'required|mimetypes:text/plain'
        ],
        [
            'file.required' => 'El archivo es requerido',
            'file.mimetypes' => 'El archivo debe ser de tipo text/plain'
        ]);
        try{
            Audit::truncate();
            $time_start = microtime(true);
            $file = $request->file('file');
            Excel::import(new AuditImport, $file);
            $filename = $file->getClientOriginalName();
            $time_end = microtime(true);
            $execution_time = round(($time_end - $time_start), 2);
            return redirect()->route('importaudit.index')->with('message', 'Importación de auditoria completada '.$filename.' tiempo '.$execution_time);
        } catch(Exception $ex){
            Log::info("Error al importar importAudit: "+$ex);
        }
    }

    public function importEvidence(Request $request)
    {
        
        $this->validate($request, [
            'file' => 'required|mimetypes:text/plain'
        ],
        [
            'file.required' => 'El archivo es requerido',
            'file.mimetypes' => 'El archivo debe ser de tipo text/plain'
        ]);
        try{
            Evidence::truncate();
            $time_start = microtime(true);
            $file = $request->file('file');
            Excel::import(new EvidenceImport, $file);
            $filename = $file->getClientOriginalName();
            $time_end = microtime(true);
            $execution_time = round(($time_end - $time_start), 2);
            return redirect()->route('importevidence.index')->with('message', 'Importación de evidencia completada '.$filename.' tiempo '.$execution_time);
        } catch(Exception $ex){
            Log::info("Error al importar importEvidence: "+$ex);
        }
    }

    public function importTechnical(Request $request)
    {

        $this->validate($request, [
            'file' => 'required|mimetypes:text/plain'
        ],
        [
            'file.required' => 'El archivo es requerido',
            'file.mimetypes' => 'El archivo debe ser de tipo text/plain'
        ]);

        // $this->validate($request, [
        //     'file' => [
        //         'required',
        //         function($attribute, $value, $fail) {
        //             $extension = $value->getClientOriginalExtension();
        //             if ($extension != 'xlsx') {
        //                 $fail('El archivo debe ser de tipo xlsx');
        //             }
        //         },
        //     ],
        // ],
        // [
        //     'file.required' => 'El archivo es requerido',
        // ]);
        try{
            $time_start = microtime(true);
            $file = $request->file('file');
            Excel::import(new TechnicalImport, $file);
            $filename = $file->getClientOriginalName();
            $time_end = microtime(true);
            $execution_time = round(($time_end - $time_start), 2);
            return redirect()->route('importtechnical.index')->with('message', 'Importación de tecnico completada '.$filename.' tiempo '.$execution_time);
        } catch(Exception $ex){
            Log::info("Error al importar importTechnical: "+$ex);
        }
    }
}
