@extends('layouts.app')

@section('content')
@auth 
<div class="row">
    <div class="col-md-12">
        <h4>Mes Matchs</h4>
    </div>
    <div class="col-md-12">
        @foreach($game_slots as $slot)
            @include('games.card', ['game' => $slot->game])
        @endforeach 
    </div>
    <div class="col-md-12">
        @include('games.create_form')
    </div>
</div>
@endif 
@endsection

