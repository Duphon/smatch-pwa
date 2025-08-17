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
                        <span class="rank">Gold 3 -</span>
                        <span class="season">2025</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row quick-links">
            <a class="link-button" href="#">
                Find a match
            </a>
            <a href="#">
                Register a new match
            </a>
        </div>
        <div class="row">
            <div class="col-md-12">
                @if (session()->has('message'))
                    <div class="alert alert-success" role="alert">
                        {{ session()->get('message') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                @if (count($games_matchmaking) > 0)
                    <div class="row">
                        <div class="col-md-12">
                            @foreach ($games_matchmaking as $game)
                                @include('games.card', ['game' => $game])
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="alert alert-info" role="alert">
                        Aucun match correspondant à votre Elo pour le moment ! <br />
                    </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h4>Tous les matchs</h4>
            </div>
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
