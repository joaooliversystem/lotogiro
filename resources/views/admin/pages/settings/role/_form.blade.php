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
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Função</h3>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">Nome</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" placeholder="Ex: Administrador de Sistemas"
                                   maxlength="50" value="{{ $role->name ?? null }}">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-danger">
            <div class="card-header">
                <h3 class="card-title">Permissões</h3>
            </div>
            <div class="card-body">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-settings-tab" data-toggle="tab" href="#nav-settings" role="tab" aria-controls="nav-settings" aria-selected="true">Configurações</a>
                        <a class="nav-item nav-link" id="nav-bets-tab" data-toggle="tab" href="#nav-bets" role="tab" aria-controls="nav-bets" aria-selected="true">Apostas</a>
                        <a class="nav-item nav-link" id="nav-dashboards-tab" data-toggle="tab" href="#nav-dashboards" role="tab" aria-controls="nav-dashboards" aria-selected="true">Dashboards</a>
                        <a class="nav-item nav-link" id="nav-payments-tab" data-toggle="tab" href="#nav-payments" role="tab" aria-controls="nav-payments" aria-selected="true">Pagamentos</a>
                      </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-settings" role="tabpanel" aria-labelledby="nav-settings-tab">
                        <div class="row my-2">
                            <div class="col-md-3">
                                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    <a class="nav-link active" id="v-pills-users-tab" data-toggle="pill" href="#v-pills-users" role="tab" aria-controls="v-pills-users" aria-selected="true">Usuários</a>
                                    <a class="nav-link" id="v-pills-roles-tab" data-toggle="pill" href="#v-pills-roles" role="tab" aria-controls="v-pills-roles" aria-selected="false">Funções</a>
                                    <a class="nav-link" id="v-pills-permissions-tab" data-toggle="pill" href="#v-pills-permissions" role="tab" aria-controls="v-pills-permissions" aria-selected="false">Permissões</a>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="tab-content" id="v-pills-tabContent">
                                    <div class="tab-pane fade show active" id="v-pills-users" role="tabpanel" aria-labelledby="v-pills-users-tab">
                                        @if(isset($permissions) && $permissions->count() > 0)
                                            @foreach($permissions as $permission)
                                                @if($permission->menu == 'settings/users')
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="permission_{{$permission->id}}" value="{{$permission->id}}" name="permissions[]" @if($permission->can) checked @endif>
                                                        <label class="custom-control-label" for="permission_{{$permission->id}}">{{$permission->alias}}</label>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-roles" role="tabpanel" aria-labelledby="v-pills-roles-tab">
                                        @if(isset($permissions) && $permissions->count() > 0)
                                            @foreach($permissions as $permission)
                                                @if($permission->menu == 'settings/roles')
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="permission_{{$permission->id}}" value="{{$permission->id}}" name="permissions[]" @if($permission->can) checked @endif>
                                                        <label class="custom-control-label" for="permission_{{$permission->id}}">{{$permission->alias}}</label>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-permissions" role="tabpanel" aria-labelledby="v-pills-permissions-tab">
                                        @if(isset($permissions) && $permissions->count() > 0)
                                            @foreach($permissions as $permission)
                                                @if($permission->menu == 'settings/permissions')
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="permission_{{$permission->id}}" value="{{$permission->id}}" name="permissions[]" @if($permission->can) checked @endif>
                                                        <label class="custom-control-label" for="permission_{{$permission->id}}">{{$permission->alias}}</label>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="nav-bets" role="tabpanel" aria-labelledby="nav-bets-tab">
                        <div class="row my-2">
                            <div class="col-md-3">
                                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    <a class="nav-link active" id="v-pills-clients-tab" data-toggle="pill" href="#v-pills-clients" role="tab" aria-controls="v-pills-clients" aria-selected="true">Clientes</a>
                                    <a class="nav-link" id="v-pills-competitions-tab" data-toggle="pill" href="#v-pills-competitions" role="tab" aria-controls="v-pills-competitions" aria-selected="true">Concursos</a>
                                    <a class="nav-link" id="v-pills-type_games-tab" data-toggle="pill" href="#v-pills-type_games" role="tab" aria-controls="v-pills-type_games" aria-selected="true">Tipos de Jogo</a>
                                    <a class="nav-link" id="v-pills-games-tab" data-toggle="pill" href="#v-pills-games" role="tab" aria-controls="v-pills-games" aria-selected="true">Jogos</a>
                                    <a class="nav-link" id="v-pills-draws-tab" data-toggle="pill" href="#v-pills-draws" role="tab" aria-controls="v-pills-draws" aria-selected="true">Sorteios</a>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="tab-content" id="v-pills-tabContent">
                                    <div class="tab-pane fade show active" id="v-pills-clients" role="tabpanel" aria-labelledby="v-pills-clients-tab">
                                        @if(isset($permissions) && $permissions->count() > 0)
                                            @foreach($permissions as $permission)
                                                @if($permission->menu == 'bets/clients')
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="permission_{{$permission->id}}" value="{{$permission->id}}" name="permissions[]" @if($permission->can) checked @endif>
                                                        <label class="custom-control-label" for="permission_{{$permission->id}}">{{$permission->alias}}</label>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-competitions" role="tabpanel" aria-labelledby="v-pills-competitions-tab">
                                        @if(isset($permissions) && $permissions->count() > 0)
                                            @foreach($permissions as $permission)
                                                @if($permission->menu == 'bets/competitions')
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="permission_{{$permission->id}}" value="{{$permission->id}}" name="permissions[]" @if($permission->can) checked @endif>
                                                        <label class="custom-control-label" for="permission_{{$permission->id}}">{{$permission->alias}}</label>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-type_games" role="tabpanel" aria-labelledby="v-pills-type_games-tab">
                                        @if(isset($permissions) && $permissions->count() > 0)
                                            @foreach($permissions as $permission)
                                                @if($permission->menu == 'bets/type_games')
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="permission_{{$permission->id}}" value="{{$permission->id}}" name="permissions[]" @if($permission->can) checked @endif>
                                                        <label class="custom-control-label" for="permission_{{$permission->id}}">{{$permission->alias}}</label>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-games" role="tabpanel" aria-labelledby="v-pills-games-tab">
                                        @if(isset($permissions) && $permissions->count() > 0)
                                            @foreach($permissions as $permission)
                                                @if($permission->menu == 'bets/games')
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="permission_{{$permission->id}}" value="{{$permission->id}}" name="permissions[]" @if($permission->can) checked @endif>
                                                        <label class="custom-control-label" for="permission_{{$permission->id}}">{{$permission->alias}}</label>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-draws" role="tabpanel" aria-labelledby="v-pills-draws-tab">
                                        @if(isset($permissions) && $permissions->count() > 0)
                                            @foreach($permissions as $permission)
                                                @if($permission->menu == 'bets/draws')
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="permission_{{$permission->id}}" value="{{$permission->id}}" name="permissions[]" @if($permission->can) checked @endif>
                                                        <label class="custom-control-label" for="permission_{{$permission->id}}">{{$permission->alias}}</label>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="nav-dashboards" role="tabpanel" aria-labelledby="nav-dashboards-tab">
                        <div class="row my-2">
                            <div class="col-md-3">
                                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    <a class="nav-link active" id="v-pills-extracts-tab" data-toggle="pill" href="#v-pills-extracts" role="tab" aria-controls="v-pills-extracts" aria-selected="true">Extrato</a>
                                    <a class="nav-link" id="v-pills-sales-tab" data-toggle="pill" href="#v-pills-sales" role="tab" aria-controls="v-pills-sales" aria-selected="true">Vendas</a>
                                    <a class="nav-link" id="v-pills-gains-tab" data-toggle="pill" href="#v-pills-gains" role="tab" aria-controls="v-pills-gains" aria-selected="true">Ganhos</a>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="tab-content" id="v-pills-tabContent">
                                    <div class="tab-pane fade show active" id="v-pills-extracts" role="tabpanel" aria-labelledby="v-pills-extracts-tab">
                                        @if(isset($permissions) && $permissions->count() > 0)
                                            @foreach($permissions as $permission)
                                                @if($permission->menu == 'dashboards/extracts')
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="permission_{{$permission->id}}" value="{{$permission->id}}" name="permissions[]" @if($permission->can) checked @endif>
                                                        <label class="custom-control-label" for="permission_{{$permission->id}}">{{$permission->alias}}</label>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-sales" role="tabpanel" aria-labelledby="v-pills-sales-tab">
                                        @if(isset($permissions) && $permissions->count() > 0)
                                            @foreach($permissions as $permission)
                                                @if($permission->menu == 'dashboards/sales')
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="permission_{{$permission->id}}" value="{{$permission->id}}" name="permissions[]" @if($permission->can) checked @endif>
                                                        <label class="custom-control-label" for="permission_{{$permission->id}}">{{$permission->alias}}</label>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-gains" role="tabpanel" aria-labelledby="v-pills-gains-tab">
                                        @if(isset($permissions) && $permissions->count() > 0)
                                            @foreach($permissions as $permission)
                                                @if($permission->menu == 'dashboards/gains')
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="permission_{{$permission->id}}" value="{{$permission->id}}" name="permissions[]" @if($permission->can) checked @endif>
                                                        <label class="custom-control-label" for="permission_{{$permission->id}}">{{$permission->alias}}</label>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="nav-payments" role="tabpanel" aria-labelledby="nav-payments-tab">
                        <div class="row my-2">
                            <div class="col-md-3">
                                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    <a class="nav-link active" id="v-pills-payments-commissions-tab" data-toggle="pill" href="#v-pills-payments-commissions" role="tab" aria-controls="v-pills-payments-commissions" aria-selected="true">Comissão</a>
                                    <a class="nav-link" id="v-pills-payments-draws-tab" data-toggle="pill" href="#v-pills-payments-draws" role="tab" aria-controls="v-pills-payments-draws" aria-selected="true">Sorteio</a>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="tab-content" id="v-pills-tabContent">
                                    <div class="tab-pane fade show active" id="v-pills-payments-commissions" role="tabpanel" aria-labelledby="v-pills-payments-commissions-tab">
                                        @if(isset($permissions) && $permissions->count() > 0)
                                            @foreach($permissions as $permission)
                                                @if($permission->menu == 'payments/commissions')
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="permission_{{$permission->id}}" value="{{$permission->id}}" name="permissions[]" @if($permission->can) checked @endif>
                                                        <label class="custom-control-label" for="permission_{{$permission->id}}">{{$permission->alias}}</label>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-payments-draws" role="tabpanel" aria-labelledby="v-pills-payments-draws-tab">
                                        @if(isset($permissions) && $permissions->count() > 0)
                                            @foreach($permissions as $permission)
                                                @if($permission->menu == 'payments/draws')
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="permission_{{$permission->id}}" value="{{$permission->id}}" name="permissions[]" @if($permission->can) checked @endif>
                                                        <label class="custom-control-label" for="permission_{{$permission->id}}">{{$permission->alias}}</label>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <a href="{{route('admin.settings.roles.index')}}">
            <button type="button" class="btn btn-block btn-info">Voltar a tela principal</button>
        </a>
    </div>
    <div class="col-md-6 mb-3">
        <button type="submit"
                class="btn btn-block btn-success">@if(request()->is('admin/settings/roles/create'))
                Cadastrar Função  @else  Atualizar Função @endif </button>
    </div>
</div>
