@extends('layouts.app')

@section('content')
        <table class="content-table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Elo</th>
                    <th>Rang</th>
                </tr>
            </thead> 
            <tbody>
                @foreach($players as $player)
                    <tr class="table-row">
                        <td>{{ $player->name }}</td>
                        <td>{{ $player->elos->where('sport_id', $player->favorite_sport_id)->first()->value }}</td>
                        <td>
                            <img src="{{ asset($player->elos->where('sport_id', $player->favorite_sport_id)->first()->rank->logo) }}" title="{{ $player->elos->where('sport_id', $player->favorite_sport_id)->first()->rank->logo }}" width="30px"/>
                        </td>
                    </tr>
                @endforeach 
            </tbody>
        </table>
@endsection