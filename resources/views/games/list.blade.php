<div class="row">
    <div class="col-md-12">
        <h4>Mes Matchs</h4>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        @foreach($games as $game)
            @include('games.card', ['game' => $game])
        @endforeach 
    </div>
</div>