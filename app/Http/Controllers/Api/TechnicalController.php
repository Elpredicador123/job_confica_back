<?php

namespace App\Http\Controllers\Api;

use App\Models\Technical;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class TechnicalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listWeekBirthdays()
    {
        try {
            $start = Carbon::now()->addDays(0)->format('Y-m-d');
            $end = Carbon::now()->addDays(60)->format('Y-m-d');
            $technical = Technical::query()
            ->where('Estado','OK')
            ->where('Contrata','COMFICA')
            ->where(function($query) use ($start, $end) {
                $query->whereRaw('DAYOFYEAR(Fecha_Nacimiento) BETWEEN DAYOFYEAR(?) AND DAYOFYEAR(?)', [$start, $end]);
            })
            ->orderByRaw('DAYOFYEAR(Fecha_Nacimiento)', 'asc')
            ->take(10)
            ->get();

            return response()->json([
                "status" => "success",
                'message' => 'Listado de técnicos',
                'data' => $technical,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: TechnicalController listWeekBirthdays',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function index()
    {
        try {
            //traer todo excepto el campo Apellido_materno y Apellido_paterno y nombres y formato de fecha 
            $technical = Technical::all()
            ->map(function ($item) {
                $item->Fecha_Nacimiento = Carbon::parse($item->Fecha_Nacimiento)->format('d-m-Y');
                return $item;
            });

            return response()->json([
                "status" => "success",
                'message' => 'Listado de técnicos',
                'data' => $technical,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: TechnicalController index',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $technical = Technical::create($request->all());

            return response()->json([
                "status" => "success",
                'message' => 'Técnico creado',
                'data' => $technical,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: TechnicalController store',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Technical  $technical
     * @return \Illuminate\Http\Response
     */
    public function show($technical_id)
    {
        try {
            $technical = Technical::find($technical_id);

            return response()->json([
                "status" => "success",
                'message' => 'Técnico encontrado',
                'data' => $technical,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: TechnicalController show',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Technical  $technical
     * @return \Illuminate\Http\Response
     */
    public function edit(Technical $technical)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Technical  $technical
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $technical_id)
    {
        try {
            $technical = Technical::find($technical_id);
            $technical->update($request->all());

            return response()->json([
                "status" => "success",
                'message' => 'Técnico actualizado',
                'data' => $technical,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: TechnicalController update',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Technical  $technical
     * @return \Illuminate\Http\Response
     */
    public function destroy(Technical $technical)
    {
        try {
            $technical->delete();

            return response()->json([
                "status" => "success",
                'message' => 'Técnico eliminado',
                'data' => $technical,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: TechnicalController destroy',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getTechnicalByCarnet($carnet=null)
    {
        try {
            $technical = Technical::where('Carnet', $carnet)->first();

            return response()->json([
                "status" => "success",
                'message' => 'Técnico encontrado',
                'data' => $technical,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: TechnicalController getTechnicalByCarnet',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
