<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\Entidad\PersonalService;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiResponser;
    public function __construct(protected PersonalService $service,)
    {

    }

    public function verifyPasswordDefault(string $pass)
    {
        return Hash::check('123456', $pass);
    }



    public function login(Request $request)
    {


        $request->validate([
            's_user' => 'required|string|min:3|max:200',
            's_pass' => 'required|string|min:3|max:255'
        ]);

        if (User::checkDisabled($request->s_user)) {
            return $this->error('Usuario Desactivado');
        }

        if (Auth::attempt(['s_user' => $request->s_user, 'password' => $request->s_pass])) {
            if ($this->verifyPasswordDefault(auth()->user()->s_pass)) {
                return $this->success([
                    'action' => 'changePassword',
                    'user' => auth()->user(),
                    'token' => auth()->user()->createToken('API Token', ['sistema:admin'])->plainTextToken
                ], "Bienvenido(a) " . auth()->user()->s_user . '!');
            }
            return $this->success([
                'user' => auth()->user(),
                'token' => auth()->user()->createToken('API Token', ['sistema:admin'])->plainTextToken
            ], "Bienvenido(a) " . auth()->user()->s_user . '!');
        } else {
            return $this->error('Credenciales inválidas');
        }
    }


    public function changepassswordDefault(Request $request)
    {
        $request->validate([
            'password1' => 'required|string|min:3|max:100',
            'password2' => 'required|string|min:3|max:100|in:'.$request->password1
        ]);

        $user = User::find(auth()->user()->s_codigo);
        $user->s_pass = Hash::make(trim($request->password1));
        $user->save();
        auth()->user()->tokens()->delete();
        return $this->success([
            'user' => auth()->user(),
            'token' => auth()->user()->createToken('API Token', ['sistema:admin'])->plainTextToken
        ], "Bienvenido(a) " . auth()->user()->s_user . '!');
    }

    public function authenticated()
    {

        $personal = $this->service->authenticated();
        if ($personal) {
            return $this->success($personal);
        }

        return $this->error("No se encontraron datos", 422);
    }

    public function onLogout()
    {
        auth()->user()->currentAccessToken()->delete();
        return [
            'message' => 'Tokens Revoked'
        ];
    }
}
