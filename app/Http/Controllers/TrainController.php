<?php

namespace App\Http\Controllers;

use App\Classes\Facades\GameInfo;
use App\Http\Requests\UnitRequest;
use Illuminate\Support\Facades\Auth;

class TrainController extends Controller
{
    public function train(UnitRequest $request)
    {
        $user = Auth::user();
        $train = $request->berserkers + $request->paladins + $request->merchants + $request->archers + $request->saboteurs + $request->spies;
        $cost = GameInfo::costForUnit('Berserker') * $request->berserkers
            + GameInfo::costForUnit('Paladin') * $request->paladins
            + GameInfo::costForUnit('Archer') * $request->archers
            + GameInfo::costForUnit('Spy') * $request->spies
            + GameInfo::costForUnit('Saboteur') * $request->saboteurs
            + GameInfo::costForUnit('Merchant') * $request->merchants;

        //If cost is lower or equal to current gold
        if ($user->resources->gold >= $cost) {
            if ($user->units->untrained < $train) {
                return redirect()->back()->withErrors('You don\'t have enough units to train!');
            }

            $user->units->berserkers += $request->berserkers;
            $user->units->paladins += $request->paladins;
            $user->units->archers += $request->archers;
            $user->units->spies += $request->spies;
            $user->units->saboteurs += $request->saboteurs;
            $user->units->merchants += $request->merchants;
            $user->units->untrained -= $train;
            $user->resources->gold -= $cost;

            $user->resources->save();
            $user->units->save();

            return redirect()->back()->with('success', 'Training successful!');
        } else {
            //If cost is greater than current gold
            return redirect()->back()->withErrors('You don\'t have enough gold!');
        }
    }

    public function untrain(UnitRequest $request)
    {
        $user = Auth::user();
        $untrain = $request->berserkers + $request->paladins + $request->merchants + $request->saboteurs + $request->archers + $request->spies;
        $cost = GameInfo::costForUnit('Untrain') * $untrain;

        //If cost is lower or equal to current gold
        if ($user->resources->gold >= $cost) {
            if ($user->units->paladins < $request->paladins) {
                return redirect()->back()->withErrors('You don\'t have enough paladins to untrain!');
            } else if ($user->units->berserkers < $request->berserkers) {
                return redirect()->back()->withErrors('You don\'t have enough berserkers to untrain');
            } else if ($user->units->archers < $request->archers) {
                return redirect()->back()->withErrors('You don\'t have enough archers to untrain');
            } else if ($user->units->saboteurs < $request->saboteurs) {
                return redirect()->back()->withErrors('You don\'t have enough saboteurs to untrain');
            } else if ($user->units->merchants < $request->merchants) {
                return redirect()->back()->withErrors('You don\'t have enough merchants to untrain');
            } else if ($user->units->spies < $request->spies) {
                return redirect()->back()->withErrors('You don\'t have enough spies to untrain');
            }

            $user->units->berserkers -= $request->berserkers;
            $user->units->paladins -= $request->paladins;
            $user->units->archers -= $request->archers;
            $user->units->saboteurs -= $request->saboteurs;
            $user->units->merchants -= $request->merchants;
            $user->units->spies -= $request->spies;
            $user->units->untrained += $untrain;
            $user->resources->gold -= $cost;

            $user->push();

            return redirect()->back()->with('success', 'Untraining successful!');
        } else {
            //If cost is greater than current gold
            return redirect()->back()->withErrors('You don\'t have enough gold!');
        }
    }

    public function healInjured(UnitRequest $request)
    {
        $user = Auth::user();
        $cost = GameInfo::costForUnit('Injured') * $request->injured;
        //If cost is lower or equal to current gold
        if ($user->resources->gold >= $cost) {
            if ($user->units->injured < $request->injured) {
                return redirect()->back()->withErrors('You don\'t have enough injured units to heal!');
            }
            $user->units->injured -= $request->injured;
            $user->units->untrained += $request->injured;
            $user->resources->gold -= $cost;

            $user->resources->save();
            $user->units->save();

            return redirect()->back()->with('success', 'Healing successful!');
        } else {
            //If cost is greater than current gold
            return redirect()->back()->withErrors('You don\'t have enough gold!');
        }
    }


}
