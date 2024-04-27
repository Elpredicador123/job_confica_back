<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $users = User::join('roles','roles.id', '=','users.role_id' )
                ->select(
                    'users.id',
                    'users.username',
                    'roles.description as rol',
                    'users.role_id',
                )
                ->get();

            return response()->json([
                "status" => "success",
                'message' => 'Listado de usuarios',
                'data' => $users,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: UserController index',
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
            $requestData = $request->all();
            $requestData['password'] = bcrypt($requestData['password']);
            //obtener el username y hacerle una transformacion: Que se complete con [Primera letra del nombre][Apellido Paterno][2 primeros dígitos del DNI]
            $requestData['username'] = strtolower(substr($requestData['Nombres'], 0, 1) . $requestData['Apellido_Paterno'] . substr($requestData['Dni'], 0, 2));
            
            $user = User::create($requestData);

            return response()->json([
                "status" => "success",
                'message' => 'Usuario creado',
                'data' => $user,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: UserController store',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($user_id)
    {
        try {
            $user = User::find($user_id);

            return response()->json([
                "status" => "success",
                'message' => 'Usuario encontrado',
                'data' => $user,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: UserController show',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user_id)
    {
        try {
            $user = User::find($user_id);
            //si el password viene vacio, no se actualiza, caso contrario se encripta
            if($request->password != ''){
                $request['password'] = bcrypt($request->password);
            }else{
                unset($request['password']);
            }
            $user->update($request->all());

            return response()->json([
                "status" => "success",
                'message' => 'Usuario actualizado',
                'data' => $user,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: UserController update',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();

            return response()->json([
                "status" => "success",
                'message' => 'Usuario eliminado',
                'data' => $user,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: UserController destroy',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
