@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Detalhes do Cliente') }}</span>
                    <div>
                        <a href="{{ route('cliente.edit', $cliente->userclientid) }}" class="btn btn-outline-primary btn-sm">
                            Editar
                        </a>
                        <a href="{{ route('cliente.index') }}" class="btn btn-outline-secondary btn-sm ms-1">
                            ← Voltar
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('Error'))
                        <div class="alert alert-danger" role="alert">
                            {{ __('Acesso não autorizado.') }}
                        </div>
                    @endif

                    <dl class="row mb-0">
                        <dt class="col-sm-3">{{ __('Nome') }}</dt>
                        <dd class="col-sm-9">{{ $cliente->userclientname }}</dd>

                        <dt class="col-sm-3">{{ __('CNPJ') }}</dt>
                        <dd class="col-sm-9">{{ $cliente->userclientcnpj }}</dd>

                        <dt class="col-sm-3">{{ __('E-mail') }}</dt>
                        <dd class="col-sm-9">{{ $cliente->userclientemail }}</dd>
                    </dl>
                </div>

                <!-- <div class="card-footer d-flex justify-content-end">
                    <form action="{{ route('cliente.destroy', $cliente->userclientid) }}"
                          method="POST"
                          onsubmit="return confirm('Deseja excluir este cliente?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            Excluir Cliente
                        </button>
                    </form>
                </div> -->
            </div>
        </div>
    </div>
</div>
@endsection