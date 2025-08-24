<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Player\Player;
use App\Models\Elo\Elo;
use App\Models\Elo\EloRank;
use App\Models\Sport\Sport;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    public const BASE_ELO = 900;

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'player_name' => ['required', 'string', 'max:255'],
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'city_id' => ['required']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $player = Player::create([
            'name'              => $data['player_name'],
            'city_id'           => $data['city_id'],
            'player_type_id'    => 1 // CLASSIC
        ]);

        $user = User::create([
            'firstname'     => $data['firstname'],
            'lastname'      => $data['lastname'],
            'email'         => $data['email'],
            'password'      => Hash::make($data['password']),
            'player_id'     => $player->id
        ]);

        $sports = Sport::all();
        foreach($sports as $sport){
            // $base_rank = EloRank::where('sport_id', $sport->id)
            //     ->where('min', '<=', self::BASE_ELO)
            //     ->where('max', '>=', self::BASE_ELO)
            //     ->first();
            Elo::create([
                'sport_id'      => $sport->id,
                'player_id'     => $player->id,
                // 'value'         => self::BASE_ELO,
                // 'previous_value'=> self::BASE_ELO,
                // 'best'          => self::BASE_ELO,
                // 'elo_rank_id'   => $base_rank->id,
            ]);
        }

        return $user;
    }
}
