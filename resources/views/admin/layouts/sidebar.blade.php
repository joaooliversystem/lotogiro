<aside class="main-sidebar sidebar-dark-info elevation-4" style="overflow-x: hidden">
    <a href="/" class="brand-link">
        <img src="{{asset('admin/images/painel/Logomarca.png')}}"
             alt="Logo"
             class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light" style="font-size: 15px">Giro da Sorte</span>
    </a>

    <div class="sidebar">

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-child-indent" data-widget="treeview"
                role="menu" data-accordion="false">
                <center>
                    <li>
                        <a href="/" class="nav-link"><button type="button" class="btn btn-success">Faça Seu Jogo</button></a>
                    </li>
                </center>
                @canany(['read_sale', 'read_gain'])
                    <li class="nav-item has-treeview @if(request()->is('admin/dashboards/*')) menu-open @endif">
                        <a href="#" class="nav-link @if(request()->is('admin/dashboards/*')) active @endif">
                            <i class="nav-icon fas fa-chart-line"></i>
                            <p>
                                Dashboards
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('read_extract')
                                <li class="nav-item">
                                    <a href="{{route('admin.dashboards.extracts.index')}}"
                                       class="nav-link @if(request()->is('admin/dashboards/extracts/')) active @endif">
                                        <i class="fas fa-file-alt nav-icon"></i>
                                        <p>Extrato</p>
                                    </a>
                                </li>
                            @endcan
                            @if(\App\Helper\UserValidate::iAmAdmin())
                                <li class="nav-item">
                                    <a href="{{route('admin.dashboards.extracts.manualRecharge')}}"
                                       class="nav-link @if(request()->is('admin/dashboards/extracts/manual-recharge')) active @endif">
                                        <i class="fas fa-file-alt nav-icon"></i>
                                        <p>Extrato Recarga Manual</p>
                                    </a>
                                </li>
                            @endif
{{--                            @if(\App\Helper\UserValidate::iAmAdmin())--}}
{{--                                <li class="nav-item">--}}
{{--                                    <a href="{{route('admin.dashboards.extracts.sales')}}"--}}
{{--                                       class="nav-link @if(request()->is('admin/dashboards/extracts/sales')) active @endif">--}}
{{--                                        <i class="fas fa-file-alt nav-icon"></i>--}}
{{--                                        <p>Extrato de Vendas</p>--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                            @endif--}}
                            @can('read_gain')
                            <li class="nav-item">
                                <a href="/admin/dashboards/Reportday" class="nav-link">
                                <i class="nav-icon fas fa-list-alt "></i>
                                    <p>
                                        Vendas da Rede
                                    </p>
                                </a>
                            </li>
                                <li class="nav-item">
                                    <a href="{{route('admin.dashboards.gains.index')}}"
                                       class="nav-link @if(request()->is('admin/dashboards/gains*')) active @endif">
                                        <i class="fas fa-hand-holding-usd nav-icon"></i>
                                        <p>Ganhos</p>
                                    </a>
                                </li>
                            @endcan
                            @can('read_sale')
                                <li class="nav-item">
                                    <a href="{{route('admin.dashboards.sales.index')}}"
                                       class="nav-link @if(request()->is('admin/dashboards/sales*')) active @endif">
                                        <i class="fas fa-funnel-dollar nav-icon"></i>
                                        <p>Vendas</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany
                @canany(['read_client', 'read_competition', 'read_type_game', 'read_game'])
                    <li class="nav-item has-treeview @if(request()->is('admin/bets/*')) menu-open @endif">
                        <a href="#" class="nav-link @if(request()->is('admin/bets/*')) active @endif">
                            <i class="nav-icon fas fa-ticket-alt"></i>
                            <p>
                                Apostas
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('read_client')
                                <li class="nav-item">
                                    <a href="{{route('admin.bets.clients.index')}}"
                                       class="nav-link @if(request()->is('admin/bets/clients*')) active @endif">
                                        <i class="fas fa-users nav-icon"></i>
                                        <p>Clientes</p>
                                    </a>
                                </li>
                            @endcan
                            @can('read_client')
                                <li class="nav-item">
                                 <a href="{{route('admin.bets.validate-games.index')}}"
                                   class="nav-link @if(request()->is('admin/bets/validate-games*')) active @endif">
                                     <i class="fas fa-check nav-icon"></i>
                                     <p>Validar Jogo</p>
                                    </a>
                                </li>
                            @endcan
                            @can('read_competition')
                                <li class="nav-item">
                                    <a href="{{route('admin.bets.competitions.index')}}"
                                       class="nav-link @if(request()->is('admin/bets/competitions*')) active @endif">
                                        <i class="fas fa-trophy nav-icon"></i>
                                        <p>Concursos</p>
                                    </a>
                                </li>
                            @endcan
                            @can('read_type_game')
                                <li class="nav-item">
                                    <a href="{{route('admin.bets.type_games.index')}}"
                                       class="nav-link @if(request()->is('admin/bets/type_games*')) active @endif">
                                        <i class="fas fa-tags nav-icon"></i>
                                        <p>Tipos de Jogo</p>
                                    </a>
                                </li>
                            @endcan
                            @can('read_type_game')
                                <li class="nav-item">
                                    <a href="{{route('admin.bets.validate-games.index')}}"
                                       class="nav-link @if(request()->is('admin/bets/validate-games*')) active @endif">
                                        <i class="fas fa-check nav-icon"></i>
                                        <p>Validar Jogo</p>
                                    </a>
                                </li>
                            @endcan
                            @can('read_game')
                                <li class="nav-item has-treeview @if(request()->is('admin/bets/games*')) menu-open @endif">
                                    <a href="#"
                                       class="nav-link">
                                        <i class="fas fa-ticket-alt nav-icon"></i>
                                        <p>Jogos</p>
                                        <i class="right fas fa-angle-left"></i>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @if(\App\Models\TypeGame::count() > 0)
                                            @foreach(\App\Models\TypeGame::get() as $menu)
                                                <li class="nav-item">
                                                    <a href="{{route('admin.bets.games.index', ['type_game' => $menu->id])}}"
                                                       class="nav-link @if(request()->is('admin/bets/games/'. $menu->id) || request()->is('admin/bets/games/create/'. $menu->id)) active @endif">
                                                        <i class="far fa-dot-circle nav-icon"></i>
                                                        <p>{{$menu->name}}</p>
                                                    </a>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </li>
                            @endcan
                            @canany(['read_payments_commission', 'read_payments_draw'])
                                <li class="nav-item has-treeview @if(request()->is('admin/bets/payments*')) menu-open @endif">
                                    <a href="#"
                                       class="nav-link">
                                        <i class="fas fa-dollar-sign nav-icon"></i>
                                        <p>Pagamentos</p>
                                        <i class="right fas fa-angle-left"></i>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @can('read_payments_commission')
                                            <li class="nav-item">
                                                <a href="{{route('admin.bets.payments.commissions.index')}}"
                                                   class="nav-link @if(request()->is('admin/bets/payments/commissions')) active @endif">
                                                    <i class="fas fa-comments-dollar nav-icon"></i>
                                                    <p>Comissões</p>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('read_payments_draw')
                                            <li class="nav-item">
                                                <a href="{{route('admin.bets.payments.draws.index')}}"
                                                   class="nav-link @if(request()->is('admin/bets/payments/draws')) active @endif">
                                                    <i class="fas fa-donate nav-icon"></i>
                                                    <p>Prêmios</p>
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </li>
                            @endcanany
                            @can('read_draw')
                                <li class="nav-item">
                                    <a href="{{route('admin.bets.draws.index')}}"
                                       class="nav-link @if(request()->is('admin/bets/draws*')) active @endif">
                                        <i class="fas fa-hand-scissors nav-icon"></i>
                                        <p>Sorteios</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany
                @canany(['read_user', 'read_role', 'read_permission'])
                    <li class="nav-item has-treeview @if(request()->is('admin/settings/*')) menu-open @endif">
                        <a href="#" class="nav-link @if(request()->is('admin/settings/*')) active @endif">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>
                                Configurações
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('read_permission')
                                <li class="nav-item">
                                    <a href="{{route('admin.settings.permissions.index')}}"
                                       class="nav-link @if(request()->is('admin/settings/permissions*')) active @endif">
                                        <i class="fas fa-user-lock nav-icon"></i>
                                        <p>Permissões</p>
                                    </a>
                                </li>
                            @endcan
                            @can('read_role')
                                <li class="nav-item">
                                    <a href="{{route('admin.settings.roles.index')}}"
                                       class="nav-link @if(request()->is('admin/settings/roles*')) active @endif">
                                        <i class="fas fa-user-tag nav-icon"></i>
                                        <p>Funções</p>
                                    </a>
                                </li>
                            @endcan
                            @can('read_user')
                                <li class="nav-item">
                                    <a href="{{route('admin.settings.users.index')}}"
                                       class="nav-link @if(request()->is('admin/settings/users*')) active @endif">
                                        <i class="fas fa-user nav-icon"></i>
                                        <p>Usuários</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany

                <li class="nav-item">
                    <a href="{{ route('admin.dashboards.wallet.index') }}" class="nav-link @if(request()->is
                    ('admin/dashboards/wallet/*')) menu-open @endif">
                    <i class="nav-icon fas fa-wallet"></i>
                        <p>
                            Carteira
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>


