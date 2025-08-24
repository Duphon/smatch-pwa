@extends('layouts.app')

@section('content')
@auth 
<div class="row">
    <div class="col-md-12">
        @if(count($game_slots_next) === 1)
            <h4>Prochain Match</h4>
        @else 
            <h4>Prochains Matchs
        @endif 
    </div>
    <div class="col-md-12">
        @if(count($game_slots_next) > 0)
            @foreach($game_slots_next as $slot)
                @include('games.card', ['game' => $slot->game])
            @endforeach
        @else
            <div class="alert alert-info">
                <h6>Aucun match de prévu pour le moment !</h6>
                <a href="{{ route('page.welcome') }}">Chercher des matchs</a>
            </div>
        @endif 
    </div>
    @include('games.create_form', ['clubs'  => $clubs])
    <div class="col-md-12">
        @if(count($game_slots_played) === 1)
            <h4>Match Joué</h4>
        @else 
            <h4>Matchs Joués</h4> 
        @endif 
    </div>
    <div class="col-md-12">
        @foreach($game_slots_played as $slot)
            @include('games.card', ['game' => $slot->game])
        @endforeach 
    </div>
</div>
@endif 
@endsection

