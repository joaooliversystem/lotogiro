@extends('admin.layouts.login')

@section('title', 'Cadastro')

@section('content')
    <style type="text/css">
        .login-page,
        .register-page {
          align-items: center;
          background-image: url(/admin/images/painel/super-lotogiro03.jpg);
          background-size: cover;
          display: flex;
          flex-direction: column;
          height: 100vh;
          justify-content: center;
        }
    </style>
    <div class="col-lg-6 col-md-12 mt-5">
        <div class="login-logo">
            <img src="{{{ asset('admin/images/painel/rodafortuna.png') }}}" alt="" width=150 height=150>
        </div>
        <div class="card">
            <div class="card-body">
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
                    @if($indicator->name)
                    <div class="alert alert-default-primary text-center text-bold fade show">
                        Indicado por {{ $indicator->name }}
                    </div>
                    @endif
                </div>
                <h3 class="login-box-msg">Cadastre-se para começar a jogar!!</h3>

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <input type="hidden" name="indicator" id="indicator" value="{{ $indicator->id }}">
                    <div class="form-group row">
                        <div class="col-sm-12 col-md-6">
                            <label for="name" class="col-form-label text-md-left">Nome</label>
                            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
                            @if ($errors->has('name'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <label for="last_name" class="col-form-label text-md-left">Sobrenome</label>
                            <input id="last_name" type="text" class="form-control{{ $errors->has('last_name') ? '
                            is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}" required autofocus>
                            @if ($errors->has('last_name'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6 col-md-6">
                            <label for="email" class="col-form-label text-md-left">{{ __('E-Mail Address') }}</label>
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                            @if ($errors->has('email'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <label for="phone" class="col-form-label text-md-left">Telefone</label>
                            <input id="phone" type="text"
                                   class="form-control{{ $errors->has('phone') ? 'is-invalid' : '' }}"
                                   name="phone" value="{{ old('phone') }}" required>
                            @if ($errors->has('phone'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12 col-md-6">
                            <label for="password" class="col-form-label text-md-left">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                            @if ($errors->has('password'))
                                <span class="invalid-feedback">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <label for="password-confirm" class="col-form-label text-md-left">{{ __('Confirm
                            Password') }}</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                        </div>
                    </div>


                    @if(config('settings.reCaptchStatus'))
                        <div class="form-group">
                            <div class="col-sm-6 col-sm-offset-4">
                                <div class="g-recaptcha" data-sitekey="{{ config('settings.reCaptchSite') }}"></div>
                            </div>
                        </div>
                    @endif

                    <div class="form-group row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary btn-block">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection

<script src="{{asset('admin/layouts/plugins/jquery/jquery.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7/jquery.inputmask.min.js"></script>
<script>
    $(document).ready(function(){
        let selector = document.getElementById("phone");
        Inputmask("(99) 9 9999-9999").mask(selector);
    });
</script>
