@extends('layouts.app')

<style>
    .auth-bg {
        background-color: #f8f9fa;
        min-height: 85vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px 0;
    }
    .card-stack {
        position: relative;
        width: 100%;
        max-width: 440px;
    }
    .card-stack::before {
        content: "";
        position: absolute;
        width: 100%;
        height: 100%;
        background-color: #eeb10b;
        border-radius: 24px;
        transform: rotate(-4deg);
        top: 0;
        left: 0;
        z-index: 1;
    }
    .auth-card {
        position: relative;
        background: #ffffff;
        border-radius: 24px;
        padding: 40px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        z-index: 2;
        border: none;
    }
    .auth-title {
        font-size: 28px;
        font-weight: 700;
        color: #000000;
        margin-bottom: 30px;
    }
    .custom-input {
        border: none !important;
        border-bottom: 1px solid #cccccc !important;
        border-radius: 0 !important;
        padding: 8px 0 !important;
        box-shadow: none !important;
        font-size: 16px;
        color: #333333;
        background: transparent !important;
    }
    .custom-input:focus {
        border-bottom: 2px solid #00a8e8 !important;
    }
    .custom-label {
        font-size: 14px;
        color: #777777;
        margin-bottom: 0;
        padding-top: 5px;
    }
    .btn-submit {
        background-color: #00a8e8 !important;
        color: #ffffff !important;
        border: none !important;
        border-radius: 8px !important;
        padding: 10px 24px !important;
        font-weight: 600 !important;
        font-size: 16px !important;
    }
    .btn-submit:hover {
        background-color: #008cc2 !important;
    }
</style>

@section('content')
<div class="auth-bg">
    <div class="card-stack">
        <div class="card auth-card">
            <h2 class="auth-title">Criar Conta</h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Nome -->
                <div class="mb-3">
                    <label for="name" class="custom-label">Nome Completo</label>
                    <input id="name" type="text" class="form-control custom-input @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <!-- E-mail -->
                <div class="mb-3">
                    <label for="email" class="custom-label">Endereço de E-mail</label>
                    <input id="email" type="email" class="form-control custom-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                    @error('email')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <!-- Contacto Telefone (Novo campo obrigatório) 
                <div class="mb-3">
                    <label for="phone" class="custom-label">Contacto Telefónico</label>
                    <input id="phone" type="text" class="form-control custom-input @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" placeholder="Ex: 923000000" required>
                    @error('phone')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>-->

                <!-- Palavra-passe -->
                <div class="mb-3">
                    <label for="password" class="custom-label">Palavra-passe</label>
                    <input id="password" type="password" class="form-control custom-input @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <!-- Confirmar Palavra-passe -->
                <div class="mb-4">
                    <label for="password-confirm" class="custom-label">Confirmar Palavra-passe</label>
                    <input id="password-confirm" type="password" class="form-control custom-input" name="password_confirmation" required autocomplete="new-password">
                </div>

                <!-- Botão de Envio -->
                <div class="mb-0 text-end">
                    <button type="submit" class="btn btn-submit w-100">
                        Registar Conta
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

