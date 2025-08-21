@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="game-card shadow rounded">
                <form method="POST" action="{{ route('player.update') }}">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />

                    <div class="row mb-3">
                        <label for="player_name"
                            class="col-md-4 col-form-label text-md-end">{{ __('Nom de joueur') }}</label>

                        <div class="col-md-6">
                            <input id="player_name" type="text"
                                class="form-control @error('player_name') is-invalid @enderror" name="player_name"
                                value="{{ $player->name }}" required autocomplete="player_name" autofocus>

                            @error('player_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="lastname" class="col-md-4 col-form-label text-md-end">{{ __('Nom') }}</label>

                        <div class="col-md-6">
                            <input id="lastname" type="text"
                                class="form-control @error('lastname') is-invalid @enderror" name="lastname"
                                value="{{ $user->lastname }}" required autocomplete="lastname" autofocus>

                            @error('lastname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="firstname" class="col-md-4 col-form-label text-md-end">{{ __('Prénom') }}</label>

                        <div class="col-md-6">
                            <input id="firstname" type="text"
                                class="form-control @error('firstname') is-invalid @enderror" name="firstname"
                                value="{{ $user->firstname }}" required autocomplete="firstname" autofocus>

                            @error('firstname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="firstname" class="col-md-4 col-form-label text-md-end">{{ __('Ville') }}</label>

                        <div class="col-md-6">
                            <select id="city" class="form-control @error('firstname') is-invalid @enderror"
                                name="city_id" required>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}" @if($player->city_id === $city->id) selected @endif>{{ $city->name }}</option>
                                @endforeach
                            </select>

                            @error('firstname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="email"
                            class="col-md-4 col-form-label text-md-end">{{ __('Adresse E-mail') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ $user->email }}" required autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Mettre à jour mes informations') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-12">
            <div class="game-card shadow rounded">
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-danger" type="submit">Logout</button>
                </form>
            </div>
        </div>
    </div>
@endsection
