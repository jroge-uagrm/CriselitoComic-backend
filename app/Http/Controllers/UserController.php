<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Exception;
use App\Role;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->responseOk(User::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|max:50',
            'email' => 'required|unique:users|max:30',
            'password' => 'required|min:3|max:20'
        ]);
        if ($validator->fails()) {
            return $this->responseBadRequest($validator->getMessageBag());
        }
        $request['password'] = bcrypt($request['password']);
        $user = new User($request->toArray());
        $user->save();
        return $this->responseCreated($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function login(Request $request){
        return response()->json("jijijija");
        try{
            $user=User::where('email',$request['email'])->first();
            if($user==null){
                return response()->json('Correo No Registrado',500);
            }
            $credentials = request(['email', 'password']);        
            if (!Auth::attempt($credentials)) {
                return response()->json('Contraseña Incorrecta', 500);
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
