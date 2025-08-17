@extends('layouts.main')

@section('content')
    @auth
        <div class="row">
            <div class="col-md-12" style="text-align:center">
                <h2>Welcome, {{ Auth::user()->player->name }} !</h2>
            </div>
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
            <form method="GET" action="{{ route('page.welcome') }}">
                <input type="hidden" name="search" value="true" />
                <div class="col-md-4">
                    <select name="sport_id" class="form-control">
                        <option value="0">Choisir un sport</option>
                        @foreach ($sports as $sport)
                            <option value="{{ $sport->id }}">{{ $sport->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-primary">
                        Filtrer
                    </button>
                </div>
            </form>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h4>Matchs pour vous</h4>
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
