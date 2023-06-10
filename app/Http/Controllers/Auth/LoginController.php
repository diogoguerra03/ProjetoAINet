<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function attemptLogin(Request $request)
    {
        $credentials = $this->credentials($request);

        // Adicionar verificação para usuário bloqueado aqui
        $credentials['blocked'] = 0;

        return $this->guard()->attempt(
            $credentials, $request->filled('remember')
        );
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    protected function authenticated(Request $request, $user)
    {
        if ($request->filled('remember')) {
            Cookie::queue('remember_email', $request->input('email'), 43200); // 30 days
        }
    }

    public function showLoginForm()
    {
        $rememberedEmail = Cookie::get('remember_email');
        return view('auth.login', compact('rememberedEmail'));
    }


}
