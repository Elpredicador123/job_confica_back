<?php

namespace App\Http\Controllers\Api;

use App\Models\Birthday;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BirthdayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $birthdays = Birthday::all();

            return response()->json([
                "status" => "success",
                'message' => 'Listado de cumpleaños',
                'data' => $birthdays,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: BirthdayController index',
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
        // Asumiendo que tienes un campo 'id' en tu solicitud para identificar el registro a actualizar
        $birthdayId = $request->input('id');

        $data = $request->except(['id']); // Excluir el 'id' de los datos que se almacenarán/actualizarán

        $birthday = Birthday::updateOrCreate(
            ['id' => $birthdayId], // Cláusula where
            $data // Datos para crear o actualizar
        );

        $message = $birthday->wasRecentlyCreated ? 'Cumpleaños creado correctamente' : 'Cumpleaños actualizado correctamente';

        return response()->json([
            "status" => "success",
            'message' => $message,
            'data' => $birthday,
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            "status" => "error",
            'message' => 'Error al procesar la solicitud',
            'error' => $e->getMessage(),
        ], 500);
    }
}

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Birthday  $birthday
     * @return \Illuminate\Http\Response
     */
    public function show(Birthday $birthday)
    {
        try {
            return response()->json([
                "status" => "success",
                'message' => 'Cumpleaños encontrado',
                'data' => $birthday,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: BirthdayController show',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Birthday  $birthday
     * @return \Illuminate\Http\Response
     */
    public function edit(Birthday $birthday)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Birthday  $birthday
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Birthday $birthday)
    {
        try {
            $birthday->update($request->all());
            return response()->json([
                "status" => "success",
                'message' => 'Cumpleaños actualizado correctamente',
                'data' => $birthday,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: BirthdayController update',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Birthday  $birthday
     * @return \Illuminate\Http\Response
     */
    public function destroy(Birthday $birthday)
    {
        try {
            $birthday->delete();
            return response()->json([
                "status" => "success",
                'message' => 'Cumpleaños eliminado correctamente',
                'data' => $birthday,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: BirthdayController destroy',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
