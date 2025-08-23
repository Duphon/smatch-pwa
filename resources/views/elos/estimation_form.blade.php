<!-- Form to ask user to estimate his elo before playing a sport -->
@auth 
    {{-- @php 
        $favorite_sport_id  = Auth::user()->player->favorite_sport_id;
        $favorite_sport_elo = Auth::user()->player->elos->where('sport_id', $favorite_sport_id)->first();
    @endphp --}}
    
    @if(is_null($elo->value))
    <style>
        datalist {
            display: flex;
            justify-content: space-between;
            color: black;
            font-weight:bolder;
            width: 100%;
        }

        input {
            width: 100%;
        }
    </style>
    <div class="row">
        <div class="col-md-12">
            <div class="game-card shadow rounded" style="text-align:center;">
                <h4>Comment estimez-vous votre niveau au {{$elo->sport->name}} ?</h4>
                <form method="POST" action="{{ route('elo.update') }}" >
                    @csrf
                    <input type="range" list="tickmarks" name="elo_estimation" min="0" max="12">
                    <datalist id="tickmarks">
                        <option value="0" label="Débutant"></option>
                        <option value="1"></option>
                        <option value="2"></option>
                        <option value="3"></option>
                        <option value="4"label="Habitué"></option>
                        <option value="5"></option>
                        <option value="6"></option>
                        <option value="7"></option>
                        <option value="8" label="Confirmé"></option>
                        <option value="9"></option>
                        <option value="10"></option>
                        <option value="11"></option>
                        <option value="12" label="Avancé"></option>
                    </datalist>
                    <input type="hidden" name="elo_id" value="{{ $elo->id }}" />
                    <button type="submit" class="btn btn-primary" style="width:100%">Valider</button>
                </form>
            </div>
        </div>
    </div>
    @endif
@endauth