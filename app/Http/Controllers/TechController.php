<?php

namespace App\Http\Controllers;

use App\Classes\Facades\GameInfo;
use Config;
use Illuminate\Support\Facades\Auth;

class TechController extends Controller
{
    /**
     * @return int
     */
    public function buyNextSiege()
    {
        $user = Auth::user();
        $cost = GameInfo::costForNextSiege($user->techs->siege);
        //If cost is lower or equal to current gold
        if ($user->resources->gold >= $cost) {
            if ($user->techs->siege + 1 > Config::get('constants.max_siege')) {
                return redirect()->back()->withErrors('Already at Max Siege');
            }
            $user->techs->siege++;
            $user->resources->gold -= $cost;

            $user->resources->save();
            $user->techs->save();

            return redirect()->back()->with('success', 'Upgraded successfully!');
        } else {
            //If cost is greater than current gold
            return redirect()->back()->withErrors('You don\'t have enough gold!');
        }
    }

    public function buyNextFort()
    {
        $user = Auth::user();
        $cost = GameInfo::costForNextFort($user->techs->fortification);
        //If cost is lower or equal to current gold
        if ($user->resources->gold >= $cost) {
            if ($user->techs->fortification + 1 > Config::get('constants.max_fort')) {
                return redirect()->back()->withErrors('Already at Max Fortification');
            }
            $user->techs->fortification++;
            $user->resources->gold -= $cost;

            $user->resources->save();
            $user->techs->save();

            return redirect()->back()->with('success', 'Upgraded successfully!');
        } else {
            //If cost is greater than current gold
            return redirect()->back()->withErrors('You don\'t have enough gold!');
        }
    }

    public function buyNextReplication()
    {
        $user = Auth::user();
        $cost = GameInfo::costForNextReplication($user->techs->replication);
        //If cost is lower or equal to current gold
        if ($user->resources->gold >= $cost) {
            if ($user->techs->replication + 1 > Config::get('constants.max_siege')) {
                return redirect()->back()->withErrors('Already at Max Siege');
            }
            $user->techs->replication++;
            $user->resources->gold -= $cost;

            $user->resources->save();
            $user->techs->save();

            return redirect()->back()->with('success', 'Upgraded successfully!');
        } else {
            //If cost is greater than current gold
            return redirect()->back()->withErrors('You don\'t have enough gold!');
        }
    }

    public function buyNextAutobanking()
    {
        $user = Auth::user();
        $cost = GameInfo::costForNextAutobanking($user->balance->autobanking);
        //If cost is lower or equal to current gold
        if ($user->resources->gold >= $cost) {
            if ($user->balance->autobanking + 1 > Config::get('constants.max_autobanking')) {
                return redirect()->back()->withErrors('Already at Max Autobanking');
            }
            $user->balance->autobanking++;
            $user->resources->gold -= $cost;

            $user->push();

            return redirect()->back()->with('success', 'Upgraded successfully!');
        } else {
            //If cost is greater than current gold
            return redirect()->back()->withErrors('You don\'t have enough gold!');
        }
    }

    public function buyNextIntelligence()
    {
        $user = Auth::user();
        $cost = GameInfo::costForNextIntelligence($user);
        //If cost is lower or equal to current gold
        if ($user->resources->gold >= $cost) {
            if ($user->techs->intelligence + 1 > Config::get('constants.max_intelligence')) {
                return redirect()->back()->withErrors('Already at Max Intelligence');
            }
            $user->techs->intelligence++;
            $user->resources->gold -= $cost;

            $user->push();

            return redirect()->back()->with('success', 'Upgraded successfully!');
        } else {
            //If cost is greater than current gold
            return redirect()->back()->withErrors('You don\'t have enough gold!');
        }
    }
}
