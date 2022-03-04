<?php

namespace App\Http\Controllers\Admin\Pages\Dashboards;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReportDayController extends Controller
{
    public function index()
    {
        if (!auth()->user()->hasPermissionTo('read_gain')) {
            abort(403);
        }

        $indicador = Auth()->User()->id;

        // relacionamento de tabelas a fim de pegar os valores de ganhos da rede
        $result = DB::select("SELECT u.id, u.name, u.last_name, u.email, CAST(SUM(g.value) AS decimal(10,2)) as valorVenda FROM games as g INNER JOIN users as u ON  u.id = g.user_id WHERE u.indicador = :id group by u.id", ['id' => $indicador]);

        $jogosFeitos = DB::select("SELECT count(g.value) as jogoFeitos FROM games as g INNER JOIN users as u ON  u.id = g.user_id WHERE u.indicador = :id", ['id' => $indicador]);

        $data = [
            'result' => $result,
            'valorTotal' => 0,
            'totalJogos' => 0,
            'jogosFeitos' => $jogosFeitos
        ];

        return view('admin.pages.dashboards.ReportDay.index', $data);
    }

    public function calcularData($Dias){
        $Dias = $Dias;

        $indicador = Auth()->User()->id;
        
         // filtro para semana
         $hoje = date('Y/m/d');
         $dataEspecificaIngles = implode("-", array_reverse(explode("/", $hoje)));
         $dataSubtraida1 = strtotime($dataEspecificaIngles . $Dias);
         $dataInicio = date('Y/m/d', $dataSubtraida1);

         // pegando data especifica
         $result = DB::select("SELECT u.id, u.name, u.last_name, u.email, CAST(SUM(g.value) AS decimal(10,2)) as valorVenda FROM games as g INNER JOIN  users as u ON u.id = g.user_id WHERE u.indicador = :id AND  DATE_FORMAT(g.created_at, '%Y%m%d') BETWEEN DATE_FORMAT(:dataInicio, '%Y%m%d') AND DATE_FORMAT(:dataFinal, '%Y%m%d') group by u.id", ['id' => $indicador, 'dataInicio' => $dataInicio, 'dataFinal' => $hoje]);

        //  pegando jogos feitos com filtro
        $jogosFeitos = DB::select("SELECT count(g.value) as jogoFeitos FROM games as g INNER JOIN users as u ON  u.id = g.user_id WHERE u.indicador = :id AND  DATE_FORMAT(g.created_at, '%Y%m%d') BETWEEN DATE_FORMAT(:dataInicio, '%Y%m%d') AND DATE_FORMAT(:dataFinal, '%Y%m%d')", ['id' => $indicador, 'dataInicio' => $dataInicio, 'dataFinal' => $hoje]);
         
        return [$result, $jogosFeitos];         
    }

    public function getFiltro($receber){
        $FiltroData = $receber;
        
        $indicador = Auth()->User()->id;
        
            // condição para filtros

            // diario
            if ($FiltroData == 1){
                $result = DB::select("SELECT u.id, u.name, u.last_name, u.email, CAST(SUM(g.value) AS decimal(10,2)) as valorVenda FROM games as g INNER JOIN  users as u ON u.id = g.user_id WHERE u.indicador = :id AND DATE_FORMAT(g.created_at, '%Y%m%d') = DATE_FORMAT(:dataFinal, '%Y%m%d') group by u.id", ['id' => $indicador,  'dataFinal' => date('Y/m/d')]);
                $jogosFeitos = DB::select("SELECT count(g.value) as jogoFeitos FROM games as g INNER JOIN users as u ON  u.id = g.user_id WHERE u.indicador = :id AND DATE_FORMAT(g.created_at, '%Y%m%d') = DATE_FORMAT(:dataFinal, '%Y%m%d') group by u.id", ['id' => $indicador,  'dataFinal' => date('Y/m/d')]);
            }
            // semanal
            elseif($FiltroData == 2){
                $array = ReportDayController::calcularData('-7 day');
                $result = $array[0];
                $jogosFeitos = $array[1];
            }
            //  mensal
            elseif($FiltroData == 3){
                $array = ReportDayController::calcularData('-30 day');
                $result = $array[0];
                $jogosFeitos = $array[1];
            }

            $data = [
                'result' => $result,
                'valorTotal' => 0,
                'totalJogos' => 0,
                'jogosFeitos' => $jogosFeitos
            ];
            return view('admin.pages.dashboards.ReportDay.index', $data);
    }

    public function FiltroEspecifico(Request $request){
        $data = $request->only('dataInicio', 'dataFinal');
        $indicador = Auth()->User()->id;

        $result = DB::select("SELECT u.id, u.name, u.last_name, u.email, CAST(SUM(g.value) AS decimal(10,2)) as valorVenda FROM games as g INNER JOIN  users as u ON u.id = g.user_id WHERE u.indicador = :id AND  DATE_FORMAT(g.created_at, '%Y%m%d') BETWEEN DATE_FORMAT(:dataInicio, '%Y%m%d') AND DATE_FORMAT(:dataFinal, '%Y%m%d') group by u.id", ['id' => $indicador, 'dataInicio' => $data['dataInicio'], 'dataFinal' => $data['dataFinal']]);
        $jogosFeitos = DB::select("SELECT count(g.value) as jogoFeitos FROM games as g INNER JOIN users as u ON  u.id = g.user_id WHERE u.indicador = :id AND  DATE_FORMAT(g.created_at, '%Y%m%d') BETWEEN DATE_FORMAT(:dataInicio, '%Y%m%d') AND DATE_FORMAT(:dataFinal, '%Y%m%d') group by u.id", ['id' => $indicador, 'dataInicio' => $data['dataInicio'], 'dataFinal' => $data['dataFinal']]);
        $data = [
            'result' => $result,
            'valorTotal' => 0,
            'totalJogos' => 0,
            'jogosFeitos' => $jogosFeitos
        ];

        return view('admin.pages.dashboards.ReportDay.index', $data);
    }
}
