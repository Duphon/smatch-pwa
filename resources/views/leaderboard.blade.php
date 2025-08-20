@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 game-card rounded shadow">
            <table class="table-striped table-sm" style="width:100%;">
                <thead class="thead-dark">
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
                    @foreach($elos->sortByDesc('value')->take(20) as $elo)
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
    </div>
@endsection