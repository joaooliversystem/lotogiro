@extends('admin.layouts.login')

@section('title', 'Login')

@section('content')

  <div class="col-lg-4 col-md-12 mt-5">
        <div class="login-logo mt-md-5">
            <img src="{{ asset(env('logo')) }}" alt="" width=300 height=150>
        </div>
         @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        
        @if (session('SenhaRecuperada'))
            <div class="alert alert-success" role="alert">
                {{ session('SenhaRecuperada') }}
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
                
                <a href="{{ route('forget.password.get') }}">Esqueceu sua Senha?</a>

                <div class="row">
                    <div class="col-sm-12">
                        <p class="mb-1 text-bold">
                            Não é cadastrado?<br>
                            <a class="btn btn-block btn-info right"
                               href="{{ route('register') }}">
                                Cadastre-se
                            </a>
                        </p>

                        <a href="https://wa.me/558196826967?text=Olá, gostaria de me tornar um consultor."
                           class="btn btn-block btn-success"
                           title="Deseja ser um consultor?"
                           target="_blank">
                            <i style="border:none;"class="fa fa-whatsapp"></i> Deseja ser um consultor?
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
