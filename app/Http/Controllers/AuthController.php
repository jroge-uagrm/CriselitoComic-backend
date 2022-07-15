<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Exception;
use App\Models\Role;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function login(Request $request){
        try{
            $user=User::where('email',$request['email'])->first();
            if($user==null){
                return response()->json(['msg'=>'Correo No Registrado'],500);
            }
            $credentials = request(['email', 'password']);        
            if (!Auth::attempt($credentials)) {
                return response()->json(['msg'=>'Contraseña Incorrecta'], 500);
            }
            $role=Role::find($user->role_id);
            $tokenResult = $user->createToken('Personal Access Token');
            $token=$tokenResult->token;
            $token->save();
            return response()->json([
                'role_id'      => $user->role_id,
                'role_name'    => $role->name,
                'access_token' => $tokenResult->accessToken,
                'token_type'   => 'Bearer', 
                'expires_at'   => 'Session closed'
            ],200);
        }catch(Exception $e){
            return response()->json($e->getMessage(),500);
        }
    }

    public function user(Request $r){
        return response()->json($r->user(),200);
    }
}
