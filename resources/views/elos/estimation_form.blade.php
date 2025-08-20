<!-- Form to ask user to estimate his elo before playing a sport -->
<div class="row">
    <div class="col-md-12">
        <span>Comment estimez-vous votre niveau au {{$sport->name}} ?</span>
        <form method="POST" action="{{ route('elo.update') }}" >
            <input type="range" min="1" max="100" value="50" class="slider" id="myRange">
            <button type="submit">Valider</button>
        </form>
    </div>
</div>