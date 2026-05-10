<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contabilidade;
use App\Models\Servico;
use Illuminate\Support\Facades\Auth;
use App\Models\ExecucaoServico;
use App\Notifications\executionRequestNotification;

class ExecutionController extends Controller
{
    public function index()
    {
        $servicos = Servico::all();

        return view('cliente.solicitacao.index', compact('servicos'));
    }

    public function createExecution(Request $request)
    {
        $validated = $request->validate([
            'servico_id' => ['required', 'integer', 'min:0'],
        ]);

        $servico = Servico::where('servico_id', $validated["servico_id"])->first();

        if (is_null($servico))
        {
            return redirect()->back()->with('Error');
        }

        $user = Auth::user();

        ExecucaoServico::create([
            'datetime_creation' => now(),
            'usuario_cli_id' => $user->userclientid,
            'servico_id' => $validated["servico_id"],
        ]);

        foreach ($user->tenant->contabil as $contabil)
        {
            // dd($servico);
            $contabil->notify(new executionRequestNotification($user->userclientname, $servico->servico_desc));
        }

        return redirect()->route('solicitacao')->with('success');
    }
}
