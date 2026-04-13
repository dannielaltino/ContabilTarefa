<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use App\Notifications\TokenNotification;

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
        $this->middleware('guest:cliente')->except('logout');
        $this->middleware('guest:contabil')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function Login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
        ]);

        $login = $request->input('email');

        $loginToken = strval(random_int(10000000, 99999999));
        $expiration = now()->addMinutes((int) config(('auth.toke_timeout')));

        $user = Cliente::where('userclientemail', $login)
            // ->withTrashed()
            ->first();

        if ($user)
        {            
            $user->update([
                'userclienttoken' => $loginToken,
                'userclienttimestamp' => $expiration,
            ]);
        }
        else
        {
            $user = Contabilidade::where('accountinguseremail', $login)
                // ->withTrashed()
                ->first();
            if ($user)
            {
    
                $user->update([
                    'accountingusertoken' => $loginToken,
                    'accountingusertimestamp' => $expiration,
                ]);
            }
            else
            {
                return back()->with('error', 'Usuário não encontrado');
            }
        }

        session()->put('login_token', $loginToken);
        session()->put('user_id', $user->userclientid ? $user->userclientid : $user->accountinguserid);
        session()->put('token_expiration', $expiration);
        session()->put('model', $user->getMorphClass());
        
        $user->notify(new TokenNotification($loginToken, $expiration, $user->userclientname ?? null));

        return redirect() // Redireciona para a página de Token
            ->route('token')
            ->with('success', 'Digite o token recebido');
    }

    public function token() // Mostra a tela de login
    {
        // Busca os dados do usuário para verificar se tem telefone cadastrado
        $model = Relation::getMorphedModel(session()->get('model'));

        if(!$model)
        {
            session()->forget(['login_token', 'user_id', 'token_expiration', 'model']);
            return redirect()
                ->route('login')
                ->with('failure', 'Sessão inválida. Faça login novamente.');
        }

        $user = $model::find(session()->get('user_id'));

        // ============================================================================
        // VALIDAÇÃO CRÍTICA: Garante que o token existe no banco de dados
        // Se não existir, redireciona para login (não deve acontecer, mas protege contra sessão corrompida)
        // ============================================================================
        if (!$user) {
            session()->forget(['login_token', 'user_id', 'token_expiration', 'model']);
            // dd($user, $user_token);
            return redirect()
                ->route('login')
                ->with('failure', 'Sessão inválida. Faça login novamente.');
        }
        
        $expire_date = $user->userclienttimestamp ? $user->userclienttimestamp : $user->accountingusertimestamp;

        // ============================================================================
        // VALIDAÇÃO: Verifica se o token já expirou
        // Se expirou, limpa a sessão e redireciona para login
        // ============================================================================
        if (!$expire_date || $expire_date < now()) {
            session()->forget(['login_token', 'user_id', 'token_expiration', 'model']);
            return redirect()
                ->route('login')
                ->with('failure', 'Token expirado. Solicite um novo token.');
        }

        return view('auth.token', compact('user'));
    }

    public function validateToken(Request $request) // Válida o Token e autentica o usuário
    {
        $this->validate($request, [
            'token' => 'required|numeric',
        ]);
        
        $token = $request->input('token'); // Coleta o token inserido

        /*var_dump($token);
        var_dump(session()->get('token'));
        die();*/

        if ($token !== session()->get('login_token')) { // Caso o Token esteja errado, redireciona o usuário de volta para a tela de Token
            return redirect()
                ->route('token')
                ->with('failure', 'Erro: Token Inválido');
        }

        $model = Relation::getMorphedModel(session()->get('model'));

        if(!$model)
        {
            session()->forget(['login_token', 'user_id', 'token_expiration', 'model']);
            return redirect()
                ->route('login')
                ->with('failure', 'Sessão inválida. Faça login novamente.');
        }

        $user = $model::find(session()->get('user_id'));

        if (!$user) {
            session()->forget(['login_token', 'user_id', 'token_expiration', 'model']);
            // dd($user, $user_token);
            return redirect()
                ->route('login')
                ->with('failure', 'Sessão inválida. Faça login novamente.');
        }
        
        $expire_date = $user->userclienttimestamp ? $user->userclienttimestamp : $user->accountingusertimestamp;

        if (!$expire_date || $expire_date < now()) {
            session()->forget(['login_token', 'user_id', 'token_expiration', 'model']);
            return redirect()
                ->route('login')
                ->with('failure', 'Token expirado. Solicite um novo token.');
        }

        Auth::logoutOtherDevices($token);

        Auth::guard($user->guardName())->login($user);

        if (auth()->guard('contabil')->check()) {
            return redirect()->route('home_contabil');
        }

        if (auth()->guard('cliente')->check()) {
            return redirect()->route('home_cliente');
        }

        session()->forget(['login_token', 'user_id', 'token_expiration', 'model']);
        return redirect()
            ->route('login')
            ->with('failure', 'Erro ao entrar na conta, tente novamente. Se o erro persistir, entre em contato com o suporte!');
    }

    public function logout(Request $request) // Remove o acesso do usuário
    {
        session()->forget(['login_token', 'user_id', 'token_expiration', 'model']);

        Auth::logout();

        $request->session()->invalidate();
 
        $request->session()->regenerateToken();

        return redirect('login'); // Retorna o usuário para a tela de login
    }
}


