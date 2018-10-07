<?php

namespace App\Http\Controllers\Auth;

use App\Classes\Facades\GameInfo;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
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

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

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
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',

        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $name = 'Guest';
        $defaultName = 'Guest';

        for ($i = 1; User::whereName($name)->first() != null; $i++)
            $name = $defaultName . $i;

        $user = User::create([
            'name'         => $name,
            'email'        => $data['email'],
            'race_changes' => GameInfo::raceChanges(),
            'role'         => 0,
            'race_id'      => rand(1, 4),
            'password'     => bcrypt($data['password']),
        ]);

        return $user;
    }
}
