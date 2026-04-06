<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\Models\Cliente;
use App\Models\Contabilidade;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
        {
            $this->middleware('guest')->except('logout');
            $this->middleware('guest:users_client')->except('logout');
            $this->middleware('guest:users_contabil')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function adminLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
        ]);

        $login = $request->input('email');

        $user = Cliente::where('email', $login)
            // ->withTrashed()
            ->first();

        if ($user)
        {
            $loginToken = strval(random_int(10000000, 99999999));

            session()->put('login_token', $loginToken);
            session()->put('user_id', $user->id);
            session()->put('token_expiration', now()->addMinutes((int) env('TOKEN_LIFETIME', 15)));
        }

        $user = Contabilidade::where('email', $login)
            // ->withTrashed()
            ->first();
        
        if ($user)
        {
            $loginToken = strval(random_int(10000000, 99999999));

            session()->put('login_token', $loginToken);
            session()->put('user_id', $user->id);
            session()->put('token_expiration', now()->addMinutes((int) env('TOKEN_LIFETIME', 15)));
        }

        return back()->with('error', 'Usuário não encontrado');
    }
}


