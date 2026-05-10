@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Serviços') }}</span>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Solicitação enviada com sucesso!') }}
                        </div>
                    @endif

                    @if (session('Error'))
                        <div class="alert alert-danger" role="alert">
                            {{ __('Ocorreu um erro. Tente novamente.') }}
                        </div>
                    @endif

                    @if ($servicos->isEmpty())
                        <p class="text-muted text-center my-4">Nenhum serviço disponível.</p>
                    @else
                        <table class="table table-striped table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>{{ __('Código') }}</th>
                                    <th>{{ __('Descrição') }}</th>
                                    <th class="text-end">{{ __('Ações') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($servicos as $servico)
                                    <tr>
                                        <td>{{ $servico->servico_id }}</td>
                                        <td>{{ $servico->servico_desc }}</td>
                                        <td class="text-end">
                                            <form action="{{ route('solicitacao_store') }}"
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('Deseja solicitar o serviço {{ $servico->servico_desc }}?')">
                                                @csrf
                                                <input type="hidden" name="servico_id" value="{{ $servico->servico_id }}">
                                                <button type="submit" class="btn btn-outline-primary btn-sm">
                                                    Solicitar
                                                </button>
                                            </form>
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