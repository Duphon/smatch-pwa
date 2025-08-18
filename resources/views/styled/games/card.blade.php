<div class="row game">
    <div class="column">
        <div class="court-preview">
            <img src="{{ asset('assets/courts/padel.png') }}">
        </div>
        <div class="row">
            @for ($i = 1; $i <= count($game->slots); $i++)
                @if ($i <= count($game->slots->where('player_id', '!=', 0)))
                    <div class="row slot-busy" style="gap:0px">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                        </svg>
                        <img src="{{ asset("assets/icons/ranks/gold_3.png")}}">
                    </div>
                @else
                    <div class="row slot-open">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                        </svg>
                    </div>    
                @endif
            @endfor
        </div>
    </div>
    <div class="column">
            <div class="location">
                Breizh Padel (Rennes)
            </div>
            <div class="time">
                {{ date('d/m/Y', strtotime($game->date)) }}
            </div>
            <div class="shadow" style="background-color:#CBB3BF;border-radius:60px;width:60px;height:60px;text-align:center;vertical-align:center;padding-top: 10px;">
                <img src="{{ asset($game->rank->logo) }}" title="{{ $game->rank->logo }}" width="45px"/>
            </div>
    </div>
    <!-- <div class="slots">
        @if($game->creator_player_id !== Auth::user()->player->id)
            {{ count($game->slots->where('player_id', 0)) }} place(s) disponible(s) 
            <form method="POST" action="{{ route('game.join') }}" style="float:right;">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" name="game_id" value="{{ $game->id }}" />
                <input type="hidden" name="player_id" value="{{ Auth::user()->player->id }}" />
                <button type="submit" class="btn btn-primary">Rejoindre</button>
            </form>
        @else
            {{-- <button class="btn btn-update"> Modifier </button> --}}
            <form method="POST" action="{{ route('game.delete') }}" onsubmit="return confirm('Do you really want to delete the match ? Other players will be notified.');">
                @csrf
                <input type="hidden" name="game_id" value="{{  $game->id }}" />
                <button type="submit" class="btn btn-delete"> Supprimer </button>
            </form>
        @endif 
    </div> -->
</div>