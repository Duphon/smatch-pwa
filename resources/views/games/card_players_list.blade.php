<style>
    .dropbtn {
        background-color: #3498DB;
        color:white;
        cursor: pointer;
    }

    .dropbtn:hover,
    .dropbtn:focus {
        background-color: #2980B9;
    }

    .dropdown-content {
        display: none;
        z-index: 1;
    }

    .dropdown-content a:hover {
        background-color: #ddd;
    }

    .show {
        display: block;
    }
</style>
<div class="col-md-12">
    <button onclick="myFunction('list-{{ $game->id }}')" class="btn dropbtn" style="width:100%;">Voir les joueurs</button>
</div>
<div id="list-{{ $game->id }}" class="dropdown-content">
    <div class="col-md-12">
        <table class="table">
            @foreach ($game->slots as $slot)
                @if ($slot->player)
                    <tr>
                        <td>{{ $slot->player->name }}</td>
                        <td>{{ $slot->player->currentSportElo()->value }}
                    </tr>
                @endif
            @endforeach
        </table>
    </div>
</div>
<script>
    function myFunction(listId) {
        document.getElementById(listId).classList.toggle("show");
    }

    window.onclick = function(event) {
        if (!event.target.matches('.dropbtn')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
</script>
