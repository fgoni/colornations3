<?php
/**
 * Created by PhpStorm.
 * User: martin
 * Date: 05/11/2015
 * Time: 0:34
 */

namespace App\Http\Controllers\Auth;


use App\Classes\Facades\GameInfo;
use App\Http\Controllers\Controller;
use App\User;

class SocialAuthController extends Controller
{

    protected $redirectPath = "/";

    /**
     * Find User and return or Create User and return
     * @param  Object $user
     * @param  String $provider Returns either Twitter or Github
     * @return User User's data
     */
    protected function findOrCreateUser($user, $provider)
    {
        if ($authUser = User::where('social_id', $user->id)->where('provider', $provider)->first())
            return $authUser;

        //Check if username exists an add a number to it to keep it unique
        $name = $user->name;
        for ($i = 1; User::whereName($name)->first() != null; $i++)
            $name = $user->name . $i;

        $newUser = User::create([
            'name'         => $name,
            'email'        => $user->email,
            'race_changes' => GameInfo::raceChanges(),
            'role'         => 0,
            'race_id'      => rand(1, 4),
            'social_id'    => $user->id,
            'provider'     => $provider,
        ]);

        return $newUser;
    }
}