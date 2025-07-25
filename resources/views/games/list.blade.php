        <h2>Mes Matchs</h2>
        <table class="table-striped table-sm" style="color:#BEB087;background-color:#07051A;width:100%;border:2px solid #EBC758;box-shadow: rgba(0, 0, 0, 0.25) 0px 14px 28px, rgba(0, 0, 0, 0.22) 0px 10px 10px;border-radius: 10px;">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Sport</th>
                    <th>Joueurs</th>
                    <th>Elo</th>
                    <th>Rang</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($games->where('creator_player_id', Auth::user()->id) as $game)
                    <tr>
                        <td>
                           {{  $game->date }}
                        </td>
                        <td>{{ $game->sport->name }}</td>
                        <td>{{ count($game->slots) }}</td>
                        <td>{{ $game->elo_value }}</td>
                        <td>{{ $game->rank->name }}</td>
                        <td>
                            <a class="button-success" href="{{ route('page.game.update', ['$game_id' => $game->id]) }}">
                                Modifier le match</a>
                            <a href="{{  route('game.delete', ['game_id' => $game->id]) }}">Annuler le match</buton>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>