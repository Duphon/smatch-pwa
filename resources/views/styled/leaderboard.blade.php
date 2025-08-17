@extends('layouts.main')

@section('content')
<div class="row">
    @foreach($sports as $sport)
        <div class="col-md-12 game-card rounded shadow">
            <table class="table-striped table-sm" style="width:100%;">
                <thead class="thead-dark">
                    <tr>
                        <td colspan="4" style="font-weight:bolder;text-align:center;">
                            {{$sport->name }}
                        </td>
                    </tr>
                    <tr style="color:#BEB087;">
                        <th style="text-align:center">#</th>
                        <th>Joueur</th>
                        <th>Elo</th>
                        <th>Rang</th>
                    </tr>
                </thead> 
                <tbody style="color:#BEB087;">
                    @php 
                        $rank = 1;
                    @endphp 
                    @foreach($elos->where('sport_id', $sport->id)->sortByDesc('value')->take(20) as $elo)
                        @if(false)
                            <tr class="tr-player" style="color:#EBC758;font-weight:bolder;">
                        @else
                            <tr>
                        @endif
                            <td style="text-align:center">
                                {{ $rank }}
                            </td>
                            <td>
                                {{ $elo->player->name  }}
                            </td>
                            <td>
                                {{ $elo->value }}
                                @if($elo->previous_value < $elo->value)
                                    <div class="up-arrow"></div>
                                @else 
                                    <div class="down-arrow"></div>
                                @endif
                            </td>
                            <td>
                                <img src="{{ asset($elo->rank->logo) }}" title="{{ $elo->rank->logo }}" width="30px"/>
                            </td>
                        </tr>
                        @php 
                            $rank++;
                        @endphp 
                    @endforeach 
                </tbody>
            </table>
        </div>
    @endforeach
    {{-- <div class="column">
        <form method="POST" action="http://127.0.0.1:8000/elo/update" >
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <table class="content-table">
            <thead>
                <tr>
                    <td colspan="3">
                        Entrer le Résultat d'un match
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Joueur 1 - Gagnant</td>
                    <td>
                        <select name="winner_elo_id">
                            @foreach($elos as $elo)
                                <option value="{{ $elo->id }}">{{ $elo->player->name }} ({{ $elo->sport->name }}  {{  $elo->value  }})</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Joueur 2 - Perdant</td>
                    <td>
                        <select name="loser_elo_id">
                            @foreach($elos as $elo)
                                <option value="{{ $elo->id }}">{{ $elo->player->name }} ({{ $elo->sport->name }}  {{  $elo->value  }})</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <button type="submit">
                            Mettre les Elos à jour
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
        </form>
    </div> --}}
</div>
@endsection