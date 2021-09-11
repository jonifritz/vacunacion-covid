<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string',
            'region_id' => 'sometimes|number',
            'locality_id' => 'sometimes|number',
            'vacunatory_center_id' => 'sometimes|number'
        ]);

        $user_logged = $request->user;
        $user = null;
        if ($user_logged->role_id === 1) {
            $user = $this->createUser($fields, 2);
        } else if ($user_logged->role_id === 2) {
            //soy admin nacional
            if (array_key_exists('region_id', $fields)) {
                $user = $this->createUser($fields, 3, $fields['region_id']);
            }
        } else if ($user_logged->role_id === 3) {
            //soy admin provincial
            if (array_key_exists('locality_id', $fields)) {
                $user = $this->createUser($fields, 4, $user_logged->region_id,  $fields['locality_id']);
            }
        } else  if ($user_logged->role_id === 4) {
            //soy admin municipal
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
        $user = User::where('email', $fields['email'])->first();

        // Check password
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Credenciales erroneas'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function logout(Request $request)
    {
        auth()->user->tokens()->delete();

        return [
            'message' => 'Se ha cerrado sesión'
        ];
    }
}
