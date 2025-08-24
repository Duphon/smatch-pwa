                    <div class="game-card shadow rounded">
                        <div class="columns">
                            <div class="infos">
                                <div class="location">
                                    <span class="location-club">{{ $game->club->name }} -</span>
                                    <span class="location-city">{{ $game->club->city->name }}</span>
                                </div>
                                <div class="time">
                                    <span>{{ $game->date }}</span>
                                </div>
                            </div>
                            <div class="actions">
                                @php
                                    $player = Auth::user()->player;
                                    $elo_diff = $game->elo_value - $player->currentSportElo()->value;
                                @endphp
                                @if ($elo_diff > 99)
                                    <div class="shadow"
                                        style="background-color:#bd0000;border-radius:60px;width:50px;height:50px;text-align:center;vertical-align:center;padding-top: 10px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                            fill="white" class="bi bi-emoji-dizzy-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16M4.146 5.146a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 1 1 .708.708l-.647.646.647.646a.5.5 0 1 1-.708.708L5.5 7.207l-.646.647a.5.5 0 1 1-.708-.708l.647-.646-.647-.646a.5.5 0 0 1 0-.708m5 0a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708.708l-.647.646.647.646a.5.5 0 0 1-.708.708l-.646-.647-.646.647a.5.5 0 1 1-.708-.708l.647-.646-.647-.646a.5.5 0 0 1 0-.708M8 13a2 2 0 1 1 0-4 2 2 0 0 1 0 4" />
                                        </svg>
                                    </div>
                                @elseif($elo_diff < -99)
                                    <div class="shadow"
                                        style="background-color:#d4c009;border-radius:60px;width:50px;height:50px;text-align:center;vertical-align:center;padding-top: 10px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                            fill="white" class="bi bi-emoji-expressionless-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16M4.5 6h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1m5 0h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1m-5 4h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1 0-1" />
                                        </svg>
                                    </div>
                                @else
                                    <div class="shadow"
                                        style="background-color:#09991c;border-radius:60px;width:50px;height:50px;text-align:center;vertical-align:center;padding-top: 10px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                            fill="white" class="bi bi-emoji-smile-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16M7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5M4.285 9.567a.5.5 0 0 1 .683.183A3.5 3.5 0 0 0 8 11.5a3.5 3.5 0 0 0 3.032-1.75.5.5 0 1 1 .866.5A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1-3.898-2.25.5.5 0 0 1 .183-.683M10 8c-.552 0-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5S10.552 8 10 8" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="slots">
                            @php
                                $player_slot = $game->slots->where('player_id', Auth::user()->player->id)->first();
                            @endphp
                            @include('games.card_players_list', ['game' => $game])
                            @if (!$game->result)
                                @if ($game->creator_player_id !== Auth::user()->player->id)
                                    @if ($player_slot)
                                        <div class="col-md-12">
                                            <form method="POST" action="{{ route('game.quit') }}" style="width:100%;">
                                                @csrf
                                                <input type="hidden" name="game_slot_id"
                                                    value="{{ $player_slot->id }}" />
                                                <button class="btn btn-danger" style="width:100%;">Quitter le
                                                    match</button>
                                            </form>
                                        </div>
                                        @if (count($game->slots->where('player_id', '!=', 0)) > 1)
                                            <div class="col-md-6">
                                                <form id="game-result-{{ $game->id }}-1" method="POST"
                                                    action="{{ route('game.result.create') }}" style="width:100%;">
                                                    @csrf
                                                    <input type="hidden" name="game_id" value="{{ $game->id }}" />
                                                    <input type="hidden" name="player_id"
                                                        value="{{ Auth::user()->player->id }}" />
                                                    <input type="hidden" name="is_winner" value="1" required />
                                                    <button class="btn btn-result-win" onclick="this.form.submit();"
                                                        style="width:100%">J'ai Gagné</button>
                                                </form>
                                            </div>
                                            <div class="col-md-6">
                                                <form id="game-result-{{ $game->id }}-0" method="POST"
                                                    action="{{ route('game.result.create') }}" style="width:100%;">
                                                    @csrf
                                                    <input type="hidden" name="game_id" value="{{ $game->id }}" />
                                                    <input type="hidden" name="player_id"
                                                        value="{{ Auth::user()->player->id }}" />
                                                    <input type="hidden" name="is_winner" value="1" required />
                                                    <button class="btn btn-result-lose" onclick="this.form.submit();"
                                                        style="width:100%">J'ai Perdu</button>
                                                </form>
                                            </div>
                                        @endif
                                    @else
                                        <div class="col-md-12">
                                            <form method="POST" action="{{ route('game.join') }}"
                                                style="float:right;width:100%;">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                <input type="hidden" name="game_id" value="{{ $game->id }}" />
                                                <input type="hidden" name="player_id"
                                                    value="{{ Auth::user()->player->id }}" />
                                                <button type="submit" class="btn btn-primary"
                                                    style="width:100%;">Rejoindre</button>
                                            </form>
                                            {{ count($game->slots->where('player_id', 0)) }} place(s) disponible(s)
                                        </div>
                                    @endif
                                @else
                                    <div class="col-md-12">
                                        <form method="POST" action="{{ route('game.delete') }}"
                                            onsubmit="return confirm('Do you really want to delete the match ? Other players will be notified.');"
                                            style="width:100%;">
                                            @csrf
                                            <input type="hidden" name="game_id" value="{{ $game->id }}" />
                                            <button type="submit" class="btn btn-delete" style="width:100%;">
                                                Supprimer </button>
                                        </form>
                                    </div>
                                    @if (count($game->slots->where('player_id', '!=', 0)) > 1)
                                        <div class="col-md-6">
                                            <form id="game-result-{{ $game->id }}-1" method="POST"
                                                action="{{ route('game.result.create') }}" style="width:100%;">
                                                @csrf
                                                <input type="hidden" name="game_id" value="{{ $game->id }}" />
                                                <input type="hidden" name="player_id"
                                                    value="{{ Auth::user()->player->id }}" />
                                                <input type="hidden" name="is_winner" value="1" required />
                                                <button class="btn btn-result-win" onclick="this.form.submit();"
                                                    style="width:100%">J'ai Gagné</button>
                                            </form>
                                        </div>
                                        <div class="col-md-6">
                                            <form id="game-result-{{ $game->id }}-0" method="POST"
                                                action="{{ route('game.result.create') }}" style="width:100%;">
                                                @csrf
                                                <input type="hidden" name="game_id" value="{{ $game->id }}" />
                                                <input type="hidden" name="player_id"
                                                    value="{{ Auth::user()->player->id }}" />
                                                <input type="hidden" name="is_winner" value="1" required />
                                                <button class="btn btn-result-lose" onclick="this.form.submit();"
                                                    style="width:100%">J'ai Perdu</button>
                                            </form>
                                        </div>
                                    @endif
                                @endif
                            @endif

                            @if ($game->result && $player_slot)
                                <div class="col-md-12">
                                    @if ($game->result->winner_team_identifier === $player_slot->team_identifier)
                                        <span style="color:green;font-weight:bolder;">Victoire</span>
                                    @else
                                        <span style="color:red;font-weight:bolder;">Défaite</span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
