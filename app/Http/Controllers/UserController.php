<?php

namespace App\Http\Controllers;

use App\Classes\Facades\GameEvents;
use App\Classes\Facades\GameInfo;
use App\Http\Requests\RaceChangeRequest;
use App\Log;
use App\Report;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function updateFirstTimeUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'race' => 'required|exists:races,id',
            'name' => 'required|unique:users',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $user = Auth::user();
        $user->race_id = $request->race;
        $user->name = $request->name;
        $user->activated = true;
        $user->save();

        return redirect('dashboard/training')->with([
            'success' => ['Updated your race and name successfully!',
                'Start training some units before attacking a player.'],
        ]);
    }

    public function getUser($id)
    {
        $user = User::find($id);

        return view('app.user', compact('user'));
    }

    public function postSpy(Request $request)
    {
        $attacker = Auth::user();
        $defender = User::whereId($request->id)->activated()->first();

        if (!$attacker->activated)
            return redirect("user/$defender->id")->withErrors('You need to activate your account in Settings first before spying');
        if ($defender == null)
            return redirect("user/$defender->id")->withErrors('User is not spyable');
        if ($attacker->id == $defender->id)
            return redirect("user/$defender->id")->withErrors('You can\'t spy yourself!');
        if ($attacker->resources->turns < GameInfo::spyCost())
            return redirect("user/$defender->id")->withErrors('You don\'t have enough turns');

        $attackerDamage = GameInfo::intelligenceForUser($attacker) * rand(90, 110) / 100;
        $defenderDamage = GameInfo::intelligenceForUser($defender) * rand(90, 110) / 100;
        $intel = [];
        $report = Report::create([
            'attacker_id'     => $attacker->id,
            'defender_id'     => $defender->id,
            'attacker_damage' => $attackerDamage,
            'defender_damage' => $defenderDamage,
        ]);
        if ($attackerDamage > $defenderDamage) {
            $ratio = round($defenderDamage * 50 / $attackerDamage);
            foreach (GameInfo::intelColumns() as $intelColumn) {
                $explode = explode('.', $intelColumn);
                $table = $explode[0];
                $column = $explode[1];
                if (rand(0, 100) > $ratio) {
                    $intel[$table][$column] = $defender->$table->$column;
                }
            }
            if (rand(0, 100) > $ratio) {
                $intel['stats']['attack'] = GameInfo::attackForUser($defender);
            }
            if (rand(0, 100) > $ratio) {
                $intel['stats']['defense'] = GameInfo::defenseForUser($defender);
            }
            $report->result = 1;
        } else if ($attackerDamage < $defenderDamage) {
            $report->result = -1;

        } else {
            $report->result = 0;
        }

        $attacker->resources->turns -= GameInfo::spyCost();
        $attacker->resources->save();
        $report->url = '';
        $report->save();

        return view('app.covert', compact('attacker', 'defender', 'attackerDamage', 'defenderDamage', 'report', 'intel'));
    }

    public function postAttack(Request $request)
    {

        $attacker = Auth::user();
        $defender = User::whereId($request->id)->activated()->first();

        if (!$attacker->activated)
            return redirect("user/$defender->id")->withErrors('You need to activate your account in Settings first before attacking');
        if ($defender == null)
            return redirect("user/$defender->id")->withErrors('User is not attackable');
        if ($attacker->id == $defender->id)
            return redirect("user/$defender->id")->withErrors('You can\'t attack yourself!');
        if ($attacker->resources->turns < GameInfo::attackCost())
            return redirect("user/$defender->id")->withErrors('You don\'t have enough turns');


        $attackerDamage = GameInfo::attackForUser($attacker) * rand(90, 110) / 100;
        $defenderDamage = GameInfo::defenseForUser($defender) * rand(90, 110) / 100;
        $attackerLosses = 0;
        $defenderLosses = 0;
        $stolen = 0;
        $bankStolen = 0;
        $berserkerBonus = 0;
        $smallerBonus = 0;

        $log = Log::create([
            'attacker_id'     => $attacker->id,
            'defender_id'     => $defender->id,
            'attacker_damage' => $attackerDamage,
            'defender_damage' => $defenderDamage,
        ]);

        if ($attackerDamage > $defenderDamage) {
            $result = 'attacker';
            $attackerRatio = GameInfo::unitsForUser($attacker) / GameInfo::unitsForUser($defender);
            $stolen = $defender->resources->gold * rand(80, 100) / 100;
            if ($attackerRatio > 1)
                $stolen = $stolen * max(0.75, 2 - $attackerRatio);
            else if ($attackerRatio < 1)
                $smallerBonus = $stolen * min(0.25, 1 - $attackerRatio);

            if (GameEvents::currentEvent() != null && GameEvents::currentEvent()->event->code == 'saboteurs') {
                $saboteur_ratio = $attacker->units->saboteurs / GameInfo::unitsForUser($attacker);
                $bankStolen = round($saboteur_ratio * $defender->balance->balance * rand(20, 25) / 100);
                $defender->balance->balance -= $bankStolen;
                $defender->balance->save();
            }

            if (GameEvents::currentEvent() != null && GameEvents::currentEvent()->event->code == 'berserkers') {
                $berserker_ratio = $attacker->units->berserkers / GameInfo::unitsForUser($attacker);
                $berserkerBonus = round($berserker_ratio * $stolen);
            }
            $defender->resources->gold -= $stolen;
            $defender->resources->save();
            if ($attacker->race_name == 'reds')
                $stolen *= 1.1;
            $attacker->resources->gold += $stolen;
            $attacker->resources->gold += $berserkerBonus;
            $attacker->resources->gold += $bankStolen;
            $attacker->resources->gold += $smallerBonus;
            $attacker->resources->save();
            $log->result = 1;

        } else if ($attackerDamage < $defenderDamage) {
            $result = 'defender';
            $log->result = -1;

        } else {
            $result = 'tie';
            $log->result = 0;

        }
        $injureds = GameInfo::calcularInjureds($attacker, $defender, $attackerDamage, $defenderDamage);
        foreach (GameInfo::unitCombatColumns() as $column) {
            $attacker->units->$column -= $injureds['attacker'][$column];
            $defender->units->$column -= $injureds['defender'][$column];

            $attackerLosses += $injureds['attacker'][$column];
            $defenderLosses += $injureds['defender'][$column];
        }

        $attacker->units->injured += $attackerLosses;
        if (GameEvents::currentEvent() != null && GameEvents::currentEvent()->event->code != 'take_no_prisioners_comrade')
            $defender->units->injured += $defenderLosses;

        $log->attacker_losses = $attackerLosses;
        $log->defender_losses = $defenderLosses;
        $log->gold_stolen = $stolen;
        $log->bank_stolen = $bankStolen;
        $attacker->resources->turns -= GameInfo::attackCost();
        $attacker->resources->save();
        $attacker->units->save();
        $defender->units->save();

        $log->save();

        return view('app.combat', compact('smallerBonus', 'attacker', 'defender', 'attackerDamage', 'defenderDamage', 'result', 'stolen', 'bankStolen', 'berserkerBonus', 'injureds'));
    }

    public function updateRace(RaceChangeRequest $request)
    {
        $user = Auth::user();

        if ($user->race_changes <= 0) {
            return redirect('dashboard/settings')->withErrors('You have no race changes left!');
        }
        if ($user->race_id == $request->race) {
            return redirect('dashboard/settings')->withErrors('Choose a different race from your current one.');
        }

        $user->race_id = $request->race;
        $user->race_changes--;
        $user->save();

        return redirect('dashboard/settings')->with('success', 'You changed your race to ' . strtoupper($user->race_name) . ' successfully!');
    }
}
