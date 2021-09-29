<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_logged = Auth::user();
        if ($user_logged->role_id === 1) {
            return User::all();
        }
        else if ($user_logged->role_id === 2) {
            return User::where('role_id', 3)->get()->all();
        }
        else if ($user_logged->role_id === 3) {
            return User::where('role_id', 4)->get()->all();
        }
        else if ($user_logged->role_id === 4) {
            return User::where('role_id', 5)->get()->all();
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $user = User::find($id);

        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->password = bcrypt($request->get('password'));
        
        if ($user->save()){
        return response()->json($user, 201);
        }
    }



    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string',
            'region_id' => 'sometimes',
            'locality_id' => 'sometimes',
            'vacunatory_center_id' => 'sometimes'
        ]);

        $user_logged = $request->user();
        $user = null;

        Log::emergency('Estoy en auth');
        Log::emergency(Auth::user());
        Log::emergency($request->user()->get('role_id'));
        Log::emergency($request->get('role_id'));


        $new_user_role_id = $request->get('role_id');

        Log::emergency($new_user_role_id);
        $user = null;

        if ($user_logged->role_id === 1) {
            //soy superadmin
            Log::emergency('estoy en superadmin');
            $user = $this->createUser($fields, 2);
            
        } else if ($user_logged->role_id === 2) {
            //soy admin nacional
            Log::emergency('estoy en admin nacional');
            if (array_key_exists('region_id', $fields)) {
                $user = $this->createUser($fields, 3, $fields['region_id']);
            }
        } else if ($user_logged->role_id === 3) {
            //soy admin provincial
            Log::emergency('estoy en admin provincial');
            if (array_key_exists('locality_id', $fields)) {
                $user = $this->createUser($fields, 4, $user_logged->region_id,  $fields['locality_id']);
            }
        } else  if ($user_logged->role_id === 4) {
            //soy admin municipal
            Log::emergency('estoy en admin municipal');
            if (array_key_exists('vacunatory_center_id', $fields)) {
                $user = $this->createUser($fields, 5, $user_logged->region_id, $user_logged->locality_id, $fields['vacunatory_center_id']);
            }
        } else {
            throw new BadRequestException('No tiene permisos para crear usuario');
        }

        if ($user === null) {
            throw new BadRequestException('Faltan parámetros para crear el usuario');
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    private function createUser($fields, $role_id, $region_id = null, $locality_id = null, $vacunatory_center_id = null)
    {
        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'role_id' => $role_id,
            'region_id' => $region_id,
            'locality_id' => $locality_id,
            'vacunatory_center_id' => $vacunatory_center_id
        ]);
        return $user;
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        // Check email
        $user = User::where('email', $fields['email'])->with('role')->first();

        // Check password
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Credenciales erroneas'
            ], 401);
        }

        if (!$token = auth()->setTTL(604800)->attempt($fields)) {
            return response()->json(['error' => 'Usuario y/o contraseña incorrectos'], 400);
        }

        // obtengo provincia y localidad

        if ($user->region_id) {
            $response = Http::get('https://apis.datos.gob.ar/georef/api/provincias?id=' . $user->region_id);
            $region = $response->json();

            if ($region && $region['provincias'] && count($region['provincias']) > 0) {
                $user->region = $region['provincias'][0];
            }
        }

        if ($user->locality_id) {
            $response = Http::get('https://apis.datos.gob.ar/georef/api/municipios?id=' . $user->locality_id);
            $locality = $response->json();

            if ($locality && $locality['municipios'] && count($locality['municipios']) > 0) {
                $user->locality = $locality['municipios'][0];
            }
        }

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function destroy($id)
    {
        if (User::where('id', $id)->delete()) {
            return response()->json(null, 204);
    }

    /*public function logout(Request $request)
    {
        auth()->user->tokens()->delete();

        return [
            'message' => 'Se ha cerrado sesión'
        ];
    }*/
}
}
