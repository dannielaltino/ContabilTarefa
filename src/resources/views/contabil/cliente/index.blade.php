@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Clientes') }}</span>
                    <a href="{{ route('cliente.create') }}" class="btn btn-primary btn-sm">
                        + Novo Cliente
                    </a>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (session('Error'))
                        <div class="alert alert-danger" role="alert">
                            {{ __('Ocorreu um erro. Tente novamente.') }}
                        </div>
                    @endif

                    @if ($clientes->isEmpty())
                        <p class="text-muted text-center my-4">Nenhum cliente cadastrado.</p>
                    @else
                        <table class="table table-striped table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>{{ __('Nome') }}</th>
                                    <th>{{ __('CNPJ') }}</th>
                                    <th>{{ __('E-mail') }}</th>
                                    <th class="text-end">{{ __('Ações') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clientes as $cliente)
                                    <tr>
                                        <td>{{ $cliente->userclientname }}</td>
                                        <td>{{ $cliente->userclientcnpj }}</td>
                                        <td>{{ $cliente->userclientemail }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('cliente.show', $cliente->userclientid) }}"
                                               class="btn btn-outline-secondary btn-sm">Ver</a>
                                            <a href="{{ route('cliente.edit', $cliente->userclientid) }}"
                                               class="btn btn-outline-primary btn-sm">Editar</a>
                                            <!-- <form action="{{ route('cliente.destroy', $cliente->userclientid) }}"
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('Deseja excluir este cliente?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                                    Excluir
                                                </button>
                                            </form> -->
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection