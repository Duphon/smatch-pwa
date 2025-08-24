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
                        <td>{{ $player->currentSportElo()->value }}</td>
                        <td>
                            <img src="{{ asset($player->currentSportElo()->rank->logo) }}" title="{{ $player->currentSportElo()->rank->logo }}" width="30px"/>
                        </td>
                    </tr>
                @endforeach 
            </tbody>
        </table>
@endsection