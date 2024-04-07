<?php

namespace App\Http\Controllers\Api;

use App\Models\Infographic;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InfographicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $infographics = Infographic::all();

            return response()->json([
                "status" => "success",
                'message' => 'Listado de infografías',
                'data' => $infographics,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: InfographicController index',
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
            $infographic = Infographic::create($request->except(['file']));
            if ($request->hasFile('file')) {
                $url = Storage::disk('public')->put('infographics', $request->file('file'));
                $infographic->url = $url;
            }
            $infographic->save();
            return response()->json([
                "status" => "success",
                'message' => 'Infografía creada',
                'data' => $infographic,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: InfographicController store',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Infographic  $infographic
     * @return \Illuminate\Http\Response
     */
    public function show($infographic_id)
    {
        try {
            $infographic = Infographic::find($infographic_id);
            return response()->json([
                "status" => "success",
                'message' => 'Infografía',
                'data' => $infographic,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: InfographicController show',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Infographic  $infographic
     * @return \Illuminate\Http\Response
     */
    public function edit(Infographic $infographic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Infographic  $infographic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $infographic_id)
    {
        try {
            $infographic = Infographic::find($infographic_id);
            $infographic->update($request->except(['file']));
            if ($request->hasFile('file')) {
                if ($infographic->url && Storage::disk('public')->exists('infographics', $infographic->url)) {
                    Storage::disk('public')->delete('infographics', $infographic->url);
                }
                $url = Storage::disk('public')->put('infographics', $request->file('file'));
                $infographic->url = $url;
            }
            $infographic->save();
            return response()->json([
                "status" => "success",
                'message' => 'Infografía actualizada',
                'data' => $infographic,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: InfographicController update',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Infographic  $infographic
     * @return \Illuminate\Http\Response
     */
    public function destroy(Infographic $infographic)
    {
        try {
            if ($infographic->url && Storage::disk('public')->exists($infographic->url)) {
                Storage::disk('public')->delete($infographic->url);
            }
            $infographic->delete();
            return response()->json([
                "status" => "success",
                'message' => 'Infografía eliminada',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: InfographicController destroy',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
