<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('permissions')->delete();

        \DB::table('permissions')->insert(array(
            0 =>
                array(
                    'id' => 1,
                    'name' => 'create_user',
                    'guard_name' => 'admin',
                    'alias' => 'Cadastrar Usuário',
                    'menu' => 'settings/users',
                    'created_at' => \Carbon\Carbon::now()->toDateTime(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTime(),
                ),
            1 =>
                array(
                    'id' => 2,
                    'name' => 'read_user',
                    'guard_name' => 'admin',
                    'alias' => 'Acessar Usuário',
                    'menu' => 'settings/users',
                    'created_at' => \Carbon\Carbon::now()->toDateTime(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTime(),
                ),
            2 =>
                array(
                    'id' => 3,
                    'name' => 'update_user',
                    'guard_name' => 'admin',
                    'alias' => 'Editar Usuário',
                    'menu' => 'settings/users',
                    'created_at' => \Carbon\Carbon::now()->toDateTime(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTime(),
                ),
            3 =>
                array(
                    'id' => 4,
                    'name' => 'delete_user',
                    'guard_name' => 'admin',
                    'alias' => 'Deletar Usuário',
                    'menu' => 'settings/users',
                    'created_at' => \Carbon\Carbon::now()->toDateTime(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTime(),
                ),
            4 =>
                array(
                    'id' => 5,
                    'name' => 'create_role',
                    'guard_name' => 'admin',
                    'alias' => 'Cadastrar Função',
                    'menu' => 'settings/roles',
                    'created_at' => \Carbon\Carbon::now()->toDateTime(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTime(),
                ),
            5 =>
                array(
                    'id' => 6,
                    'name' => 'read_role',
                    'guard_name' => 'admin',
                    'alias' => 'Acessar Função',
                    'menu' => 'settings/roles',
                    'created_at' => \Carbon\Carbon::now()->toDateTime(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTime(),
                ),
            6 =>
                array(
                    'id' => 7,
                    'name' => 'update_role',
                    'guard_name' => 'admin',
                    'alias' => 'Editar Função',
                    'menu' => 'settings/roles',
                    'created_at' => \Carbon\Carbon::now()->toDateTime(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTime(),
                ),
            7 =>
                array(
                    'id' => 8,
                    'name' => 'delete_role',
                    'guard_name' => 'admin',
                    'alias' => 'Deletar Função',
                    'menu' => 'settings/roles',
                    'created_at' => \Carbon\Carbon::now()->toDateTime(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTime(),
                ),
            8 =>
                array(
                    'id' => 9,
                    'name' => 'create_permission',
                    'guard_name' => 'admin',
                    'alias' => 'Cadastrar Permissão',
                    'menu' => 'settings/permissions',
                    'created_at' => \Carbon\Carbon::now()->toDateTime(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTime(),
                ),
            9 =>
                array(
                    'id' => 10,
                    'name' => 'read_permission',
                    'guard_name' => 'admin',
                    'alias' => 'Acessar Permissão',
                    'menu' => 'settings/permissions',
                    'created_at' => \Carbon\Carbon::now()->toDateTime(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTime(),
                ),
            10 =>
                array(
                    'id' => 11,
                    'name' => 'update_permission',
                    'guard_name' => 'admin',
                    'alias' => 'Editar Permissão',
                    'menu' => 'settings/permissions',
                    'created_at' => \Carbon\Carbon::now()->toDateTime(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTime(),
                ),
            11 =>
                array(
                    'id' => 12,
                    'name' => 'delete_permission',
                    'guard_name' => 'admin',
                    'alias' => 'Deletar Permissão',
                    'menu' => 'settings/permissions',
                    'created_at' => \Carbon\Carbon::now()->toDateTime(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTime(),
                ),
            12 =>
                array(
                    'id' => 13,
                    'name' => 'create_client',
                    'guard_name' => 'admin',
                    'alias' => 'Cadastrar Cliente',
                    'menu' => 'bets/clients',
                    'created_at' => \Carbon\Carbon::now()->toDateTime(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTime(),
                ),
            13 =>
                array(
                    'id' => 14,
                    'name' => 'read_client',
                    'guard_name' => 'admin',
                    'alias' => 'Acessar Cliente',
                    'menu' => 'bets/clients',
                    'created_at' => \Carbon\Carbon::now()->toDateTime(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTime(),
                ),
            14 =>
                array(
                    'id' => 15,
                    'name' => 'update_client',
                    'guard_name' => 'admin',
                    'alias' => 'Editar Cliente',
                    'menu' => 'bets/clients',
                    'created_at' => \Carbon\Carbon::now()->toDateTime(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTime(),
                ),
            15 =>
                array(
                    'id' => 16,
                    'name' => 'delete_client',
                    'guard_name' => 'admin',
                    'alias' => 'Deletar Cliente',
                    'menu' => 'bets/clients',
                    'created_at' => \Carbon\Carbon::now()->toDateTime(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTime(),
                ),
            16 =>
                array(
                    'id' => 17,
                    'name' => 'create_type_game',
                    'guard_name' => 'admin',
                    'alias' => 'Cadastrar Tipo de Jogo',
                    'menu' => 'bets/type_games',
                    'created_at' => \Carbon\Carbon::now()->toDateTime(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTime(),
                ),
            17 =>
                array(
                    'id' => 18,
                    'name' => 'read_type_game',
                    'guard_name' => 'admin',
                    'alias' => 'Acessar Tipo de Jogo',
                    'menu' => 'bets/type_games',
                    'created_at' => \Carbon\Carbon::now()->toDateTime(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTime(),
                ),
            18 =>
                array(
                    'id' => 19,
                    'name' => 'update_type_game',
                    'guard_name' => 'admin',
                    'alias' => 'Editar Tipo de Jogo',
                    'menu' => 'bets/type_games',
                    'created_at' => \Carbon\Carbon::now()->toDateTime(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTime(),
                ),
            19 =>
                array(
                    'id' => 20,
                    'name' => 'delete_type_game',
                    'guard_name' => 'admin',
                    'alias' => 'Deletar Tipo de Jogo',
                    'menu' => 'bets/type_games',
                    'created_at' => \Carbon\Carbon::now()->toDateTime(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTime(),
                ),
            20 =>
                array(
                    'id' => 21,
                    'name' => 'create_game',
                    'guard_name' => 'admin',
                    'alias' => 'Cadastrar Jogo',
                    'menu' => 'bets/games',
                    'created_at' => \Carbon\Carbon::now()->toDateTime(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTime(),
                ),
            21 =>
                array(
                    'id' => 22,
                    'name' => 'read_game',
                    'guard_name' => 'admin',
                    'alias' => 'Acessar Jogo',
                    'menu' => 'bets/games',
                    'created_at' => \Carbon\Carbon::now()->toDateTime(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTime(),
                ),
            22 =>
                array(
                    'id' => 23,
                    'name' => 'update_game',
                    'guard_name' => 'admin',
                    'alias' => 'Editar Jogo',
                    'menu' => 'bets/games',
                    'created_at' => \Carbon\Carbon::now()->toDateTime(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTime(),
                ),
            23 =>
                array(
                    'id' => 24,
                    'name' => 'delete_game',
                    'guard_name' => 'admin',
                    'alias' => 'Deletar Jogo',
                    'menu' => 'bets/games',
                    'created_at' => \Carbon\Carbon::now()->toDateTime(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTime(),
                ),
            24 =>
                array(
                    'id' => 25,
                    'name' => 'create_draw',
                    'guard_name' => 'admin',
                    'alias' => 'Cadastrar Sorteio',
                    'menu' => 'bets/draws',
                    'created_at' => \Carbon\Carbon::now()->toDateTime(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTime(),
                ),
            25 =>
                array(
                    'id' => 26,
                    'name' => 'read_draw',
                    'guard_name' => 'admin',
                    'alias' => 'Acessar Sorteio',
                    'menu' => 'bets/draws',
                    'created_at' => \Carbon\Carbon::now()->toDateTime(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTime(),
                ),
            26 =>
                array(
                    'id' => 27,
                    'name' => 'update_draw',
                    'guard_name' => 'admin',
                    'alias' => 'Editar Sorteio',
                    'menu' => 'bets/draws',
                    'created_at' => \Carbon\Carbon::now()->toDateTime(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTime(),
                ),
            27 =>
                array(
                    'id' => 28,
                    'name' => 'delete_draw',
                    'guard_name' => 'admin',
                    'alias' => 'Deletar Sorteio',
                    'menu' => 'bets/draws',
                    'created_at' => \Carbon\Carbon::now()->toDateTime(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTime(),
                ),
            28 =>
                array(
                    'id' => 29,
                    'name' => 'read_all_games',
                    'guard_name' => 'admin',
                    'alias' => 'Visualizar Todos Jogos',
                    'menu' => 'bets/games',
                    'created_at' => \Carbon\Carbon::now()->toDateTime(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTime(),
                ),
            29 =>
                array(
                    'id' => 30,
                    'name' => 'read_sale',
                    'guard_name' => 'admin',
                    'alias' => 'Acessar Venda',
                    'menu' => 'dashboards/sales',
                    'created_at' => \Carbon\Carbon::now()->toDateTime(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTime(),
                ),
            30 =>
                array(
                    'id' => 31,
                    'name' => 'read_all_sales',
                    'guard_name' => 'admin',
                    'alias' => 'Visualizar Todas Vendas',
                    'menu' => 'dashboards/sales',
                    'created_at' => \Carbon\Carbon::now()->toDateTime(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTime(),
                ),
            31 =>
                array(
                    'id' => 32,
                    'name' => 'read_gain',
                    'guard_name' => 'admin',
                    'alias' => 'Acessar Ganho',
                    'menu' => 'dashboards/gains',
                    'created_at' => \Carbon\Carbon::now()->toDateTime(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTime(),
                ),
            32 =>
                array(
                    'id' => 33,
                    'name' => 'read_all_gains',
                    'guard_name' => 'admin',
                    'alias' => 'Visualizar Todos Ganhos',
                    'menu' => 'dashboards/gains',
                    'created_at' => \Carbon\Carbon::now()->toDateTime(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTime(),
                ),
            33 =>
                array(
                    'id' => 34,
                    'name' => 'read_payments_commission',
                    'guard_name' => 'admin',
                    'alias' => 'Acessar Pagamentos de Comissão',
                    'menu' => 'payments/commissions',
                    'created_at' => \Carbon\Carbon::now()->toDateTime(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTime(),
                ),
            34 =>
                array(
                    'id' => 35,
                    'name' => 'read_payments_draw',
                    'guard_name' => 'admin',
                    'alias' => 'Acessar Pagamentos de Sorteios',
                    'menu' => 'payments/draws',
                    'created_at' => \Carbon\Carbon::now()->toDateTime(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTime(),
                ),
            35 =>
                array(
                    'id' => 36,
                    'name' => 'read_extract',
                    'guard_name' => 'admin',
                    'alias' => 'Acessar Extrato',
                    'menu' => 'dashboards/extracts',
                    'created_at' => \Carbon\Carbon::now()->toDateTime(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTime(),
                ),
            36 =>
                array(
                    'id' => 37,
                    'name' => 'read_competition',
                    'guard_name' => 'admin',
                    'alias' => 'Acessar Concurso',
                    'menu' => 'bets/competitions',
                    'created_at' => \Carbon\Carbon::now()->toDateTime(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTime(),
                ),
            37 =>
                array(
                    'id' => 38,
                    'name' => 'create_competition',
                    'guard_name' => 'admin',
                    'alias' => 'Cadastrar Concurso',
                    'menu' => 'bets/competitions',
                    'created_at' => \Carbon\Carbon::now()->toDateTime(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTime(),
                ),
            38 =>
                array(
                    'id' => 39,
                    'name' => 'update_competition',
                    'guard_name' => 'admin',
                    'alias' => 'Editar Concurso',
                    'menu' => 'bets/competitions',
                    'created_at' => \Carbon\Carbon::now()->toDateTime(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTime(),
                ),
            39 =>
                array(
                    'id' => 40,
                    'name' => 'delete_competition',
                    'guard_name' => 'admin',
                    'alias' => 'Deletar Concurso',
                    'menu' => 'bets/competitions',
                    'created_at' => \Carbon\Carbon::now()->toDateTime(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTime(),
                ),
        ));


    }
}
