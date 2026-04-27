@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Novo Cliente') }}</span>
                    <a href="{{ route('cliente.index') }}" class="btn btn-outline-secondary btn-sm">
                        ← Voltar
                    </a>
                </div>

                <div class="card-body">
                    @if (session('Error'))
                        <div class="alert alert-danger" role="alert">
                            {{ __('Já existe um cliente com este e-mail ou CNPJ.') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('cliente.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="userclientname" class="form-label">{{ __('Nome') }}</label>
                            <input
                                type="text"
                                class="form-control @error('userclientname') is-invalid @enderror"
                                id="userclientname"
                                name="userclientname"
                                value="{{ old('userclientname') }}"
                                required
                                autofocus
                            >
                            @error('userclientname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="userclientcnpj" class="form-label">{{ __('CNPJ') }}</label>
                            <input
                                type="text"
                                class="form-control @error('userclientcnpj') is-invalid @enderror"
                                id="userclientcnpj"
                                name="userclientcnpj"
                                value="{{ old('userclientcnpj') }}"
                                required
                            >
                            @error('userclientcnpj')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="userclientemail" class="form-label">{{ __('E-mail') }}</label>
                            <input
                                type="email"
                                class="form-control @error('userclientemail') is-invalid @enderror"
                                id="userclientemail"
                                name="userclientemail"
                                value="{{ old('userclientemail') }}"
                                required
                            >
                            @error('userclientemail')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Cadastrar') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection