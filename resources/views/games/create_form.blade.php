<div class="row">
    <div class="col-md-12">
        <h4>Créer un Match</h4>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <form method="POST" class="form shadow rounded" action="{{  route('game.create') }}">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <input type="hidden" name="player_id" value="{{ Auth::user()->player->id }}" />
                    <!-- DATE -->
                    <label for="date" class="col-md-4 col-form-label text-md-end">{{ __('Date du Match') }}</label>

                    <div class="col-md-6">
                        <input id="date" type="datetime-local" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ old('date') }}" required autocomplete="date" autofocus>
                        @error('date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <!-- SPORT -->
                    <input type="hidden" name="sport_id" value="{{ Auth::user()->player->favorite_sport_id }}" />
                    <label for="club_id" class="col-md-4 col-form-label text-md-end">{{ __('Club') }}</label>

                    <div class="col-md-6">
                        <select class="form-control" name="club_id">
                            @foreach($clubs as $club)
                                <option value="{{  $club->id }}">{{ $club->name }} {{ $club->city->name }}</option>
                            @endforeach 
                        </select> 
                        @error('club_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div> 
                    <!-- N OF PLAYERS -->
                    <label for="number_of_players" class="col-md-4 col-form-label text-md-end">{{ __('Nombre de joueurs') }}</label>

                    <div class="col-md-12">
                        <label for="game_number_of_players_2">{{ __('1 contre 1') }}</label>
                        <input id="game_number_of_players_2" type="radio" name="number_of_players" value="2" />
                    </div>
                    <div class="col-md-12">
                        <label for="game_number_of_players_2">{{ __('2 contre 2') }}</label>                
                        <input id="game_number_of_players_1" type="radio" name="number_of_players" value="4" />
                    </div>

                    <!-- VALIDATION -->
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary" style="width:100%;">
                            Zéparti
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>