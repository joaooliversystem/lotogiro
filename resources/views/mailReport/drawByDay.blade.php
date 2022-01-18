@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            {{ config('app.name') }}

            <h1>Relatório de sorteios</h1>
        @endcomponent
    @endslot

    <div style="width: 100%;">
    @php $gameName = '' @endphp
    @forelse($drawsByDay as $draw)
        @if($draw->typeGame->name != $gameName)
            @php $gameName = $draw->typeGame->name  @endphp
            <div style="padding: 3px; background-color: #0080ff">
                <h1 style="color: #FFF; font-size: 2rem;">Jogo: {{ $gameName }}</h1>
            </div>
        @endif
        @forelse($draw->game as $game)
            <div style="border: 1px #333 solid; padding: 3px 2px; margin: 3px 1px;">
                <span style="font-size: 10px !important; display: flex; flex-flow: row;">
                    <b>Nome: </b> {{ $game->fullName }} | <b>Pix: </b> {{ $game->pix }}</span>
                <span style="font-size: 10px !important; display: flex; flex-flow: row;">
                    <b>{{ $game->cupons }} Cupons</b>
                </span>
                <span style="font-size: 10px !important; display: flex; flex-flow: row;">
                    <b>Prêmio: R$ {!! \App\Helper\Money::toReal($game->total) !!}</b>
                </span>
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
            © {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
        @endcomponent
    @endslot
@endcomponent
