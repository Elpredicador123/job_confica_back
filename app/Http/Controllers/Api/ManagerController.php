<?php

namespace App\Http\Controllers\Api;

use App\Models\Zone;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getManagers()
    {
        try {
            //aplicar distinct para que no se repitan los gestores
            $managersAltas = Zone::select('Gestor Altas as manager')
            ->distinct(['Gestor Altas',])
            ->get();
            $managersAverias = Zone::select('Gestor Averias as manager')
            ->distinct(['Gestor Averias',])
            ->get();
            $managers = [];
            foreach ($managersAltas as $manager) {
                $managers[] = $manager;
            }
            foreach ($managersAverias as $manager) {
                $managers[] = $manager;
            }
            //valores unicos listado
            $managers = array_unique($managers, SORT_REGULAR);
            $managers = collect($managers)->values()->all();
            
            return response()->json([
                "status" => "success",
                'message' => 'Lista de gestores',
                'data' => $managers
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: ManagerController getManagers',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getManagersAltas()
    {
        try {
            $managers = Zone::select('Gestor Altas as manager')
            ->distinct(['Gestor Altas',])
            ->get();
            return response()->json([
                "status" => "success",
                'message' => 'Lista de gestores altas',
                'data' => $managers
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: ManagerController getManagersAltas',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getManagersAverias()
    {
        try {
            $managers = Zone::select('Gestor Averias as manager')
            ->distinct(['Gestor Averias',])
            ->get();
            return response()->json([
                "status" => "success",
                'message' => 'Lista de gestores averias',
                'data' => $managers
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: ManagerController getManagersAverias',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Zone  $manager
     * @return \Illuminate\Http\Response
     */
    public function show(Zone $manager)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Zone  $manager
     * @return \Illuminate\Http\Response
     */
    public function edit(Zone $manager)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Zone  $manager
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Zone $manager)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Zone  $manager
     * @return \Illuminate\Http\Response
     */
    public function destroy(Zone $manager)
    {
        //
    }
}
