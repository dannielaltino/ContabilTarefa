<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Contabilidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreUpdateClienteRequest;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $clientes = Cliente::where('tenant_id', $user->tenant_id)->get();

        return view('contabil.cliente.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $person = null;

        return view('contabil.cliente.create', compact('person'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdateClienteRequest $request)
    {
        $dataclient = $request->all();

        $user = Auth::user();

        $dataclient['tenant_id'] = $user->tenant_id;

        if ((!is_null(Cliente::where('userclientemail', $dataclient['userclientemail'])->first())) || (!is_null(Contabilidade::where('accountinguseremail', $dataclient['userclientemail'])->first())))
        {
            return redirect()->back()->with('Error');
        }
        if (!is_null(Cliente::where('userclientcnpj', $dataclient['userclientcnpj'])->first()))
        {
            return redirect()->back()->with('Error');
        }

        Cliente::create($dataclient);

        return redirect()->route('cliente.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cliente = Cliente::find($id);

        $user = Auth::user();

        if ($cliente->tenant_id != $user->tenant_id)
        {
            return redirect()->back()->with('Error');
        }

        return view('contabil.cliente.show', compact("cliente"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cliente = Cliente::find($id);

        $user = Auth::user();

        if ($cliente->tenant_id != $user->tenant_id)
        {
            return redirect()->back()->with('Error');
        }

        return view('contabil.cliente.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdateClienteRequest $request, string $id)
    {
        $cliente = Cliente::find($id);

        $user = Auth::user();

        if ($cliente->tenant_id != $user->tenant_id)
        {
            return redirect()->back()->with('Error');
        }

        if ((!is_null(Cliente::where('userclientemail', $dataclient['userclientemail'])->whereNot('userclientid', $cliente->userclientid)->first())) || (!is_null(Contabilidade::where('accountinguseremail', $dataclient['userclientemail'])->first())))
        {
            return redirect()->back()->with('Error');
        }
        if (!is_null(Cliente::where('userclientcnpj', $dataclient['userclientcnpj'])->whereNot('userclientid', $cliente->userclientid)->first()))
        {
            return redirect()->back()->with('Error');
        }

        $cliente->update($dataclient);

        return redirect()->route('cliente.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cliente = Cliente::find($id);

        $cliente->delete();

        return redirect()->route('cliente.index');
    }
}
