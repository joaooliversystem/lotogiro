@extends('admin.layouts.login')

@section('title', 'Login')

@section('content')

  <div class="col-md-4 col-sm-12 mt-md-5">
        <div class="login-logo mt-md-5">
            <img src="{{{ asset('admin/images/painel/Trevo.png') }}}" alt="" width=150 height=150>
        </div>
         @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif
        <div class="card">
            <div class="card-body login-card-body">
                <div class="col-md-12 px-4">
                    @error('success')
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ $message }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @enderror
                    @error('error')
                    <div class="alert alert-default-danger alert-dismissible fade show">
                        {{ $message }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @enderror
                </div>
                <h3 class="login-box-msg">Realize o login para iniciar a sessão</h3>

                <form method="POST" action="{{route('admin.post.login')}}">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                               placeholder="E-mail">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                               name="password" placeholder="Senha">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" name="remember"
                                       id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    Manter conectado
                                </label>
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Acessar</button>
                        </div>
                    </div>
                </form>
                @if (Route::has('password.request'))
                    <p class="mb-1">
                        <a href="{{ route('password.request') }}">Esqueci minha senha</a>
                    </p>
                @endif

                <div class="row">
                    <div class="col-sm-12">
                        <p class="mb-1 text-bold">
                            Não é cadastrado?
                        </p>
{{--                        <a href="https://api.whatsapp.com/send?phone=558196826967&text=Oi, Ainda não tenho cadastrado.">--}}
{{--                            <button type="submit" class="btn btn-primary btn-block">Fale Conosco</button>--}}
{{--                        </a>--}}
                        <a class="btn btn-block btn-primary"
                            href="{{ route('register') }}">
                            Cadastre-se
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .pulse-button {
            cursor: pointer;
            box-shadow: 0 0 0 0 rgba(37, 211, 102, 1);
            -webkit-animation: pulse 1.5s infinite;
        }

        @-webkit-keyframes pulse {
            0% {
                -moz-transform: scale(0.9);
                -ms-transform: scale(0.9);
                -webkit-transform: scale(0.9);
                transform: scale(0.9);
            }
            70% {
                -moz-transform: scale(1);
                -ms-transform: scale(1);
                -webkit-transform: scale(1);
                transform: scale(1);
                box-shadow: 0 0 0 50px rgba(37, 211, 102, 1);
            }
            100% {
                -moz-transform: scale(0.9);
                -ms-transform: scale(0.9);
                -webkit-transform: scale(0.9);
                transform: scale(0.9);
                box-shadow: 0 0 0 0 rgba(37, 211, 102, 1);
            }
        }

    </style>
    <div class="d-flex flex-md-column flex-sm-row align-items-md-center align-items-sm-start
    justify-content-md-center justify-content-sm-start"
        style="bottom:40px;right:40px;text-align:center;z-index:1000;position:absolute;">
        <div class="alert my-auto" style="background-color: #25d366; color: #fff;" role="alert">Deseja ser um
            consultor?</div>
        <div class="ml-4">
            <a href="https://wa.me/558196826967?text=Olá, gostaria de me tornar um consultor."
                class="row pulse-button"
                target="_blank" style="min-width:70px;min-height:70px;width:70px;height:70px;display: flex;align-items:
                center;justify-content: center;background-color:#25d366;color:#FFF;border-radius:50px;padding: 2px;">
                <i class="fa fa-whatsapp fa-3x"></i>
            </a>
        </div>
    </div>
@endsection
