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
            $start = Carbon::now()->addDays(0)->format('Y-m-d');
            $end = Carbon::now()->addDays(60)->format('Y-m-d');
            $reservations = Reservation::with(['user'])
            ->whereBetween('date', [$start, $end])
            ->orderBy('date', 'asc')
            ->take(10)
            ->get();

            return response()->json([
                "status" => "success",
                'message' => 'Listado de reservas',
                'data' => $reservations,
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
            $reservations = Reservation::with(['user'])->get();

            return response()->json([
                "status" => "success",
                'message' => 'Listado de reservas',
                'data' => $reservations,
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
                $reservation = Reservation::find($request->id);
                if ($reservation) {
                    $reservation_exists = Reservation::where('date', $request->date)
                    ->where(function ($query) use ($request) {
                        $query->where('start_time', '<', $request->start_time)
                            ->where('end_time', '>', $request->start_time);
                    })
                    ->orWhere(function ($query) use ($request) {
                        $query->where('start_time', '<', $request->end_time)
                            ->where('end_time', '>', $request->end_time);
                    })
                    ->orWhere(function ($query) use ($request) {
                        $query->where('start_time', '>', $request->start_time)
                            ->where('end_time', '<', $request->end_time);
                    })
                    ->first();
                    
                    if (!$reservation_exists) {
                        $reservation->update($request->all());
                        $message = 'Reserva actualizada correctamente';
                    } else {
                        return response()->json([
                            "status" => "error",
                            'message' => 'Ya existe una reserva en ese horario',
                        ], 400);
                    }
                } else {
                    return response()->json([
                        "status" => "error",
                        'message' => 'Reserva no encontrada',
                    ], 404);
                }
            } else {
                $reservation_exists = Reservation::where('date', $request->date)
                    ->where(function ($query) use ($request) {
                        $query->where('start_time', '<', $request->start_time)
                            ->where('end_time', '>', $request->start_time);
                    })
                    ->orWhere(function ($query) use ($request) {
                        $query->where('start_time', '<', $request->end_time)
                            ->where('end_time', '>', $request->end_time);
                    })
                    ->orWhere(function ($query) use ($request) {
                        $query->where('start_time', '>', $request->start_time)
                            ->where('end_time', '<', $request->end_time);
                    })
                    ->first();

                if (!$reservation_exists) {
                    $reservation = Reservation::create($request->all());
                    $message = 'Reserva creada correctamente';
                } else {
                    return response()->json([
                        "status" => "error",
                        'message' => 'Ya existe una reserva en ese horario',
                    ], 400);
                }
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
