                    <div class="game-card shadow rounded">
                        <div class="columns">
                            <div class="infos">
                                <div class="sport">
                                    <h6>{{ $game->sport->name }}</h6>
                                </div>
                                <div class="location">
                                    <span>Salle de la Cité - Rennes </span>
                                </div>
                                <div class="time">
                                    <span>{{ $game->date }}</span>
                                </div>
                            </div>
                            <div class="actions">
                                <div class="shadow" style="background-color:#CBB3BF;border-radius:60px;width:60px;height:60px;text-align:center;vertical-align:center;padding-top: 10px;">
                                    <img src="{{ asset($game->rank->logo) }}" title="{{ $game->rank->logo }}" width="45px"/>
                                </div>
                            </div>
                        </div>
                        <div class="slots">
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
                        </div>
                    </div>