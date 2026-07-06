@extends('layouts.app')

<style>
    .auth-bg {
        background-color: #f8f9fa;
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .card-stack {
        position: relative;
        width: 100%;
        max-width: 420px;
    }
    /* O efeito do card azul rotacionado atrás, igual à imagem image_9.png */
    .card-stack::before {
        content: "";
        position: absolute;
        width: 100%;
        height: 100%;
        background-color: #eeb10b;
        border-radius: 24px;
        transform: rotate(-5deg);
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
        margin-bottom: 35px;
    }
    /* Inputs minimalistas apenas com linha inferior */
    .custom-input {
        border: none !important;
        border-bottom: 1px solid #cccccc !important;
        border-radius: 0 !important;
        padding: 10px 0 !important;
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
        box-shadow: none !important;
    }
    .btn-submit:hover {
        background-color: #008cc2 !important;
    }
</style>

@section('content')
<div class="auth-bg">
    <div class="card-stack">
        <div class="card auth-card">
            <h2 class="auth-title">Entrar</h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- E-mail -->
                <div class="mb-4">
                    <label for="email" class="custom-label">Endereço de E-mail</label>
                    <input id="email" type="email" class="form-control custom-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <!-- Palavra-passe -->
                <div class="mb-4">
                    <label for="password" class="custom-label">Palavra-passe</label>
                    <input id="password" type="password" class="form-control custom-input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <!-- Lembrar-me -->
                <div class="mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label text-muted" for="remember">Lembrar-me</label>
                    </div>
                </div>

                <!-- Botão de Ação -->
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <button type="submit" class="btn btn-submit">
                        Entrar
                    </button>

                    @if (Route::has('password.request'))
                        <a class="btn btn-link p-0 text-decoration-none fs-7 text-muted" href="{{ route('password.request') }}">
                            Esqueceu a senha?
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
