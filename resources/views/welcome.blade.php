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
                <h4>Matchs pour vous</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @if (count($games_matchmaking) > 0)
                    @foreach ($games_matchmaking as $game)
                        @include('games.card', ['game' => $game])
                    @endforeach
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
