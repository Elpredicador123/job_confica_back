<?php

namespace App\Http\Controllers\Api;

use App\Models\Reservation;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//usar carbon
use Carbon\Carbon;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listWeek()
    {
        try {
            $startOfWeek = Carbon::now()->startOfWeek()->format('Y-m-d');
            $endOfWeek = Carbon::now()->endOfWeek()->format('Y-m-d');
            $reservations = Reservation::with(['user'])->whereBetween('date', [$startOfWeek, $endOfWeek])->get();
            $transformedReservations = collect($reservations)->map(function ($reservation) {
                return [
                    'id' => $reservation->id,
                    'title' => $reservation->title,
                    'description' => $reservation->description,
                    'number_of_people' => $reservation->number_of_people,
                    'date' => $reservation->date . "T" . substr($reservation->start_time, 0, 5) . "-" . substr($reservation->end_time, 0, 5),
                    'start_time' => $reservation->start_time,
                    'end_time' => $reservation->end_time,
                    'user_id' => $reservation->user_id,
                    'is_active' => $reservation->is_active,
                    'username' => $reservation->user->username,
                    // Agrega cualquier otro campo que necesites
                ];
            });

            return response()->json([
                "status" => "success",
                'message' => 'Listado de reservas',
                'data' => $transformedReservations,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: ReservationController listWeek',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function index()
    {
        try {
            $reservations = Reservation::all();
            $transformedReservations = collect($reservations)->map(function ($reservation) {
                return [
                    'id' => $reservation->id,
                    'title' => $reservation->title,
                    'description' => $reservation->description,
                    'number_of_people' => $reservation->number_of_people,
                    'date' => $reservation->date . "T" . substr($reservation->start_time, 0, 5) . "-" . substr($reservation->end_time, 0, 5),
                    'start_time' => $reservation->start_time,
                    'end_time' => $reservation->end_time,
                    'user_id' => $reservation->user_id,
                    'is_active' => $reservation->is_active,
                    // Agrega cualquier otro campo que necesites
                ];
            });

            return response()->json([
                "status" => "success",
                'message' => 'Listado de reservas',
                'data' => $transformedReservations,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: ReservationController index',
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
            if ($request->has('id')) {
                // Actualizar la reserva existente
                $reservation = Reservation::find($request->id);
                if ($reservation) {
                    $reservation->update($request->all());
                    $message = 'Reserva actualizada correctamente';
                } else {
                    return response()->json([
                        "status" => "error",
                        'message' => 'Reserva no encontrada',
                    ], 404);
                }
            } else {
                // Crear una nueva reserva
                $reservation = Reservation::create($request->all());
                $message = 'Reserva creada correctamente';
            }

            return response()->json([
                "status" => "success",
                'message' => $message,
                'data' => $reservation,
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
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function show(Reservation $reservation)
    {
        try {
            return response()->json([
                "status" => "success",
                'message' => 'Reserva',
                'data' => $reservation,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: ReservationController show',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reservation $reservation)
    {
            try {
                $reservation->update($request->all());
                return response()->json([
                    "status" => "success",
                    'message' => 'Reserva actualizada correctamente',
                    'data' => $reservation,
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    "status" => "error",
                    'message' => 'Error: ReservationController update',
                    'error' => $e->getMessage(),
                ], 500);
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation)
    {
            try {
                $reservation->delete();
                return response()->json([
                    "status" => "success",
                    'message' => 'Reserva eliminada correctamente',
                    'data' => $reservation,
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    "status" => "error",
                    'message' => 'Error: ReservationController destroy',
                    'error' => $e->getMessage(),
                ], 500);
            }
    }
}
