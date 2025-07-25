@extends('layouts.app')

@section('content')
@auth 
<div class="row">
    <div class="col-md-6">
        @include('games.list', ['games' => $games])
    </div>
    <div class="col-md-6">
        @include('games.update_form', ['game' => $game])
    </div>
</div>
@endif 
@endsection

