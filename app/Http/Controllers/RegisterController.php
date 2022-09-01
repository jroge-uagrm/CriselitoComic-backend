<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

use Carbon\Carbon;

use CoinbaseCommerce\ApiClient;
use CoinbaseCommerce\Resources\Charge;

class RegisterController extends Controller
{
    public function registerUser(Request $request){
        $user=User::where('email',$request->email)->first();
        try{
            if($user!=null){
                return response()->json('Correo Ya Registrado',500);
            }   
            $user=new User();
            $user->email=$request->email;
            $user->name=$request->name;
            $user->password=bcrypt($request->password);
            $user->available=false;
            $user->role_id=1;
            $user->created_at=Carbon::now();
            $user->save();
            return response()->json('Creado Correctamente',200);
        }catch(Exception $e){
            return response()->json($e->getMessage(),500);
        }
    }

    public function subscription(Request $request){
        ApiClient::init(env('COINBASE_API_KEY'));
        
        try{
            $chargeObj = new Charge();

            $chargeObj->name = 'Suscripcion a Criselito Comic';
            $chargeObj->description = 'La mejor herramienta para traducir tus mangas y comic';
            $chargeObj->local_price = [
                'amount' => 0.07,
                'currency' => 'USD'
            ];
            $chargeObj->pricing_type = 'fixed_price';
            $chargeObj->redirect_url = 'https://criselito-comic-front.herokuapp.com/login';
            $chargeObj->save();

            try {
                $retrievedCharge = Charge::retrieve($chargeObj->id);
               //echo sprintf("Successfully retrieved charge\n");
               //echo $retrievedCharge;
                $object = new \stdClass();
                foreach ($retrievedCharge as $key => $value)
                {
                    $object->$key = $value;
                }
                return $object;
            } catch (Exception $exception) {
                echo sprintf("Enable to retrieve charge. Error: %s \n", $exception->getMessage());
            }
            echo $retrievedCharge;
        }catch(Exception $e){
            return response()->json($e->getMessage(),500);
        }
        
    }
}
