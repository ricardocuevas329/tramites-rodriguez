<?php

namespace App\Http\Controllers\External\Auth;

use App\Dtos\External\Auth\AuthRegisterDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\External\Auth\StoreRegisterRequest;
use App\Notifications\Auth\ConfirEmailNotification;
use App\Services\External\Auth\AuthService;
use App\Traits\ApiResponser;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    use ApiResponser;

    public function __construct(protected AuthService $service,)
    {

    }


    public function login(Request $request)
    {

        $is_company = $request->is_company;
        $request->validate([
            'email' => 'required|string|min:3|max:200',
            'password' => 'required|string|min:3|max:255'
        ]);


       /*
        if ($this->service->checkDisabled($request->email)) {
            return $this->error('Usuario Desactivado');
        }*/


          $user = null;
            if($is_company){

                $credentials = ['s_email' => $request->email, 'password' => $request->password];
                $check = Auth::guard('sanctum-company')
                    ->attempt($credentials);

                if(!$check){
                    return response()->json(['message' => 'Credenciales Inválidas!'], 421);
                }

                $user = Auth('sanctum-company')->user();


            }else{


                $credentials = ['s_correo' => $request->email, 'password' => $request->password];
                $check = Auth::guard('sanctum-client')
                    ->attempt($credentials);

                if(!$check){
                    return response()->json(['message' => 'Credenciales Inválidas!'], 421);
                }

                $user = Auth('sanctum-client')->user();

            }




        $token = $user->createToken('auth_token')->plainTextToken;
        return $this->success([
            'user' => $user,
            'token' =>  $token
        ], "Bienvenido(a) " . $user->nombre_compuesto . '!');


    }

    public function register(StoreRegisterRequest $request)
    {

        if ($this->service->findExistEmail($request->email, $request->id_tipo_documento, $request->documento)) {
            return $this->error('Email ya ha sido tomado, por favor Ingrese otro!');
        }

        $data = $this->service->register(
            AuthRegisterDto::fromApiRequest($request)
        );
        return $this->success($data, 'Tu registro se realizó correctamente!');

    }


    public function authenticated(Request $request)
    {

        if ($request->user()) {
            return $this->success($request->user());
        }

        return $this->error("No se encontraron datos", 422);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return [
            'message' => 'Tokens Revoked'
        ];
    }
}
