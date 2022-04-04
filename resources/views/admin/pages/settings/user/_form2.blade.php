<div class="row">
    <div class="col-md-12">
        @error('success')
        @push('scripts')
            <script>
                toastr["success"]("{{ $message }}")
            </script>
        @endpush
        @enderror
        @error('error')
        @push('scripts')
            <script>
                toastr["error"]("{{ $message }}")
            </script>
        @endpush
        @enderror
    </div>
    <div class="col-md-7">
        <div class="card card-info pb-5">
            <div class="card-header">
                <h3 class="card-title">Usuário</h3>
            </div>
            <div class="card-body">
                @if(Route::currentRouteName() == 'admin.settings.users.edit')
                @can('update_user')
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="status" name="status"
                               @isset($user->status) @if($user->status == 1) checked @endif @endisset>
                        <label class="custom-control-label" for="status">Ativo?</label>
                    </div>
                    @endcan
                @endif
                <div class="form-row">
                    <input type="text" value="1" hidden class="custom-control-input" id="type_client" name="type_client">
                    <div class="form-group col-md-4">
                        <label for="name">Nome</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                               name="name"
                               maxlength="50" value="{{old('name', $user->name ?? null)}}">
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-8">
                        <label for="last_name">Sobrenome</label>
                        <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name"
                               name="last_name"
                               maxlength="100" value="{{old('last_name', $user->last_name ?? null)}}">
                        @error('last_name')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    @can('editar_conta')
                    <div class="form-group col-md-4">
                        <label for="indicador">ID Indicador</label>
                        <input type="number" class="form-control" id="indicador" name="indicador" value="{{old('indicador', $user->indicador ?? null)}}" maxlength="20">
                    </div>
                    @endcan
                    <div class="form-group col-md-8">
                        <label for="email">E-mail</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                               name="email"
                               maxlength="100" value="{{old('email', $user->email ?? null)}}">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                       {{ $message }}
                    </span>
                        @enderror
                    </div>
                </div>
                <!--<div class="form-row">
                    <div class="form-group col-sm-12">
                        <label for="password">Link de indicação</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon3">https://superjogo.loteriabr.com/admin/indicate/</span>
                            </div>
                            <input type="text" class="form-control" id="link" name="link"
                                   aria-describedby="basic-addon3" value="{{old('link', $user->link ?? null)}}">
                        </div>
                        <div class="col-sm-12">
                            <p class="text-bold">https://superjogo.loteriabr.com/admin/indicate/{{old('link', $user->link ?? null)}}</p>
                        </div>
                    </div>
                </div>-->

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="password">Senha</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                               id="password" name="password"
                               maxlength="15">
                        @if(Route::currentRouteName() == 'admin.settings.users.edit')
                            <small>*Em branco para não alterar</small>
                        @endif
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="confirm_password">Confirme a senha</label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                               id="password_confirmation"
                               name="password_confirmation" maxlength="15">
                        @error('password_confirmation')
                        <span class="invalid-feedback" role="alert">
                           {{ $message }}
                        </span>
                        @enderror
                    </div>

                    {{-- parte de dados do cliente --}}
                    <div class="form-group col-md-6">
                        <label for="pix" id="pixL">pix</label>
                        <input type="" class="form-control @error('pix') is-invalid @enderror"
                               id="pix"
                               name="pix" maxlength="50">
                        @error('pix')
                        <span class="invalid-feedback" role="alert">
                           {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="telefone" id="telefoneL">telefone</label>
                        <input type="text" class="form-control @error('telefone') is-invalid @enderror"
                               id="telefone"
                               name="telefone" maxlength="15">
                        @error('telefone')
                        <span class="invalid-feedback" role="alert">
                           {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="cpf" id="cpfL">cpf</label>
                        <input type="" class="form-control @error('cpf') is-invalid @enderror"
                               id="cpf"
                               name="cpf" maxlength="11">
                        @error('cpf')
                        <span class="invalid-feedback" role="alert">
                           {{ $message }}
                        </span>
                        @enderror
                    </div>

                </div>
            </div>
        </div>
    </div>
    
<div class="row">
    <div class="col-md-6 mb-3">
        <a href="{{route('admin.settings.users.index')}}">
            <button type="button" class="btn btn-block btn-outline-secondary">Voltar a tela principal</button>
        </a>
    </div>
    <div class="col-md-6 mb-3">
        <button type="submit"
                class="btn btn-block btn-outline-success">@if(request()->is('admin/settings/users/create')) Cadastrar
            Usuário  @else  Atualizar Usuário @endif </button>
    </div>
</div>

@push('scripts')
    <script src="{{asset('admin/layouts/plugins/inputmask/jquery.inputmask.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#balance").inputmask('currency', {
                "autoUnmask": true,
                radixPoint: ",",
                groupSeparator: ".",
                allowMinus: false,
                digits: 2,
                digitsOptional: false,
                rightAlign: true,
                unmaskAsNumber: true
            });
        });

        function habilitarcampo(){
            var campoSaldoAtual = document.getElementById('balanceAtual');
            var campoSaldo = document.getElementById('balance');
            campoSaldoAtual.readOnly = false;
            campoSaldo.readOnly = true;
        }
    </script>

    <script>
        function radioCliente(){

            if (document.getElementById("role6").checked) {

                document.getElementById("pix").style.visibility = "visible";
                document.getElementById("telefone").style.visibility = "visible";
                document.getElementById("cpf").style.visibility = "visible";

                document.getElementById("pixL").style.visibility = "visible";
                document.getElementById("telefoneL").style.visibility = "visible";
                document.getElementById("cpfL").style.visibility = "visible";

            }
            else{

                document.getElementById("pix").style.visibility = "hidden";
                document.getElementById("telefone").style.visibility = "hidden";
                document.getElementById("cpf").style.visibility = "hidden";

                document.getElementById("pixL").style.visibility = "hidden";
                document.getElementById("telefoneL").style.visibility = "hidden";
                document.getElementById("cpfL").style.visibility = "hidden";

            }
        }

    </script>
@endpush
