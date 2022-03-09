@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
        @endcomponent
    @endslot

    <div style="width: 100%;">
    @php $gameName = '' @endphp
        <div style="width: 100%; background-color: #2b97ff">
            <h2 style="color: #FFF; font-size: 2rem; text-align: center">🤑 SLG  🤑</h2>
            <h2 style="color: #FFF; text-align: center;"> SORTEIOS DO DIA: {{ \Carbon\Carbon::today()->format('d/m/Y')
            }}</h2>
            <h2 style="color: #FFF; text-align: center;"> {{ $drawsByDay->totalCupons }} BILHETES PREMIADOS🤑</h2>
            <h2 style="color: #FFF; text-align: center;"> Total de Premios 💰 R$ {{ $drawsByDay->totalPremio }} 💰</h2>
            <br><br><hr>
        </div>
    @forelse($drawsByDay as $draw)
        @if($draw->typeGame->name != $gameName)
            @php $gameName = $draw->typeGame->name  @endphp
            <div style="padding: 3px; background-color: #0080ff">
                <h1 style="color: #FFF; font-size: 2rem;">🟡 {{ $gameName }}</h1>
            </div>
        @endif
        @forelse($draw->game as $game)
            <div style="border: 1px #333 solid; padding: 3px 2px; margin: 3px 1px;">
                <h3 style="width:100%; display: flex; flex-flow: row;">
                    <b>✓ {{ $game->fullName }}, {{ $game->cupons }} Cupons</b>
                </h3>
                @if($draw->typeRequest == 'financeiro')
                <h3 style="width:100%; display: flex; flex-flow: row;">
                     <b>💳 Pix: {{ $game->pix }}</b>
                </h3>
                @endif
                <h3 style="width:100%; display: flex; flex-flow: row;">
                    <b>💰 Prêmio: R$ {!! \App\Helper\Money::toReal($game->total) !!} 💰</b>
                </h3>
                <br>
            </div>
        @empty
            <p>Nenhum ganhador.</p>
        @endforelse
    @empty
        <p>Nenhum sorteio realizado hoje.</p>
    @endforelse
    </div>


    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')

        @endcomponent
    @endslot
@endcomponent
