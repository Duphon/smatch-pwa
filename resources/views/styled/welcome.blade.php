@extends('layouts.main')

@section('content')
    @auth
        <div class="row">
            <div class="row player-card">
                <div class="rank-image">
                    <img src="{{ asset("assets/icons/ranks/gold_3.png")}}">
                </div>
                <div class="column player-info">
                    <div class="player-name">
                        {{ Auth::user()->player->name }}
                    </div>
                    <div>
                        <span class="rank">Gold 3</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row quick-links">
            <a class="link-button" href="#">
                Trouver un match
            </a>
            <a href="#">
                Enregistrer un match
            </a>
        </div>

        <div class="row title">
            Matchs recommandés
        </div>
        <div class="column">
            @if (count($games_matchmaking) > 0)
                <div class="column">
                    @foreach ($games_matchmaking as $game)
                        @include('styled.games.card', ['game' => $game])
                    @endforeach
                </div>
            @else
                <div class="alert alert-info" role="alert">
                    Aucun match ne correspond à votre Classement pour le moment ! <br />
                </div>
            @endif
        </div>

        <div class="row title">
            Tous les matchs
        </div>
        <div class="row">
            <div class="col-md-12">
                @foreach ($games as $game)
                    @include('games.card', ['game' => $game])
                @endforeach
            </div>
        </div>
        @endif
@endsection
