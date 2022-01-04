<?php

namespace App\Http\Livewire\Site\Pages\Bets\Games\Bet;

use App\Http\Controllers\Site\Pages\Bets\GameController;
use App\Models\Client;
use App\Models\TypeGameValue;
use Livewire\Component;

class Create extends Component
{
    public $bet, $typeGame, $user, $cpf, $name, $last_name, $pix, $phone, $value;
    public $numbers, $matriz, $selectedNumbers, $values;
    public $selecionado = 0;
    public $premio, $vv;
    public $valueId;
    public $typeGameValue;

    protected $rules = [
        'value' => 'required',
        'premio' => 'required'
    ];
 
    public function mount($bet, $typeGame)
    {
 
        $this->bet = $bet;
        $this->typeGame = $typeGame;
        $this->user = $bet->user;
        $this->selectedNumbers = [];
        //$this->selectedNumbers = [];
        $this->numbers = $typeGame->numbers;
        $this->matriz($typeGame->numbers, $typeGame->columns);
    }

    public function selectNumber($number)
    {
        if (in_array($number, $this->selectedNumbers)) {
            $key = array_search($number, $this->selectedNumbers);
            if ($key !== false) {
                unset($this->selectedNumbers[$key]);
            }
        } else {
            array_push($this->selectedNumbers, $number);
        } 
        $this->reset('vv');
        $this->reset('premio');
        $this->verifyValue();

    }
    public function selecionaTudo(){
         $startnumberselected = 0;

        if($this->selecionado == 0){
         foreach ($this->selectedNumbers as $value) {
            array_pop($this->selectedNumbers);
        }
        for($i = 1;$i <= $this->typeGame->numbers; $i++){
        $startnumberselected = $i;
        array_push($this->selectedNumbers, $startnumberselected);
        }
        $this->selecionado = 1;
        $this->verifyValue();
         }

    }

    public function verifyValue()
    {
        $numbers = count($this->selectedNumbers);
       
        $this->typeGameValue = TypeGameValue::where([
            ['type_game_id', $this->typeGame->id],
            ['numbers', $numbers],
        ])->get();

        if (!empty($this->typeGameValue)) {
            $this->values = $this->typeGameValue;
            $this->reset('value');
            $this->reset('vv');
            $this->reset('premio');
        }

    }

    public function matriz($numbers, $columns)
    {
        $matriz = [];
        $line = [];
        $index = 0;
        $i = 0;

        foreach (range(1, $numbers) as $number) {
            if ($i < $columns) {
                $i++;
            } else {
                $index++;
                $i = 1;
            }
            $matriz[$index][] = array_push($line, $number);
        }

        $this->matriz = $matriz;
    }

    public function randomNumbers($quantidadeAletorizar){
        $selectedNumbers = 0;
        $numerosAletatorios = array();
        $loopVezes = $quantidadeAletorizar;
        $rangeMax = $this->typeGame->numbers;

        for($i = 0; $i != $loopVezes ; $i++){

            $addNumeroAleatorio =  rand(1, $rangeMax);
            
            // condição pra checar se o número já existe na lista
            while (in_array($addNumeroAleatorio, $numerosAletatorios)){
                $addNumeroAleatorio =  rand(1, $rangeMax);
            }

            array_push($numerosAletatorios, $addNumeroAleatorio);

        }
        // $selectedNumbers = array();
        // $numerosAletatorios = json_decode($numerosAletatorios);
        $selectedNumbers = $numerosAletatorios;
        $this->selectedNumbers = $numerosAletatorios;
        $this->verifyValue();
    }

    public function calcular(){
        $multiplicador = 0; 
        $valueid=0;
        $numMax=0;       
        foreach($this->typeGameValue as $type){
            $multiplicador = $type->multiplicador;
            $valueid = $type->id;
            $numMax = $type->maxreais;
        }
        //evento dispara quando retira o foco do campo texto
        if($this->vv > 1){

        
        if( $numMax >= $this->vv ){
            $resultado = $this->vv  * $multiplicador;
            $this->premio = $resultado;
            }else{
            $resultado = $numMax * $multiplicador;
            $this->premio = $resultado;
            $this->vv =  $numMax;
            }
        }else{
             $resultado = 1  * $multiplicador;
             $this->premio = $resultado;
             $this->vv =  1;
        }
    
     $this->valueId = $valueid;
    
    }

    public function submit()
    {
        //$data = $this->validate();
        $valor = $this->vv;
        $premio =$this->premio;
        $valueid = $this->valueId;
       if (!empty($this->typeGame->competitions->last())) {
            try {
                $store = (new GameController())->store($this->bet, $this->typeGame, $this->selectedNumbers, $valor, $premio, $valueid );

                session()->flash('success', 'Jogo criado com sucesso!');
                return redirect()->route('games.bet', ['user' => $this->bet->user->id, 'bet' => $this->bet->id]);

            } catch (\Exception $exception) {
             session()->flash('error', config('app.env') != 'production' ? $exception->getMessage() : 'Ocorreu um erro no processo!');
             return redirect()->route('games.bet', ['user' => $this->bet->user->id, 'bet' => $this->bet->id]);
            }
        }
    }

    public function render()
    {

        $busca = TypeGameValue::select('numbers')->where('type_game_id', $this->typeGame->id)->orderBy('numbers', 'asc')->get();
        $this->busca = $busca;
        return view('livewire.site.pages.bets.games.bet.create', compact('busca'));
    }
}