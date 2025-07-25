@extends('layouts.app')

@section('content')
    @auth 
        <div class="row">
            <div class="col-md-12" style="text-align:center">
                <h2>Welcome, {{ Auth::user()->player->name }} !</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h2>Matchs pour vous</h2>
                <table>
                    <tbody>
                        @foreach($games as $game)
                            @if(count($game->slots->where('player_id', 0)) !== 0) 
                                <tr>
                                    <td>{{ $game->sport->name }}</td>
                                    <td>{{ $game->date }}</td>
                                    <td>{{ count($game->slots->where('player_id', 0)) }}</td>
                                    <td>
                                        <form method="POST" action="{{ route(game.slot.join) }}">
                                            <input type="hidden" name="game_id" value="{{ $game->id }}" />
                                            <button type="submit">Rejoindre</button>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @endforeach 
                    </tbody>
                </table>
            </div>
        </div>
    @endif 
@endsection 