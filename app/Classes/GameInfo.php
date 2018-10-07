<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 14/06/2015
 * Time: 03:20 PM
 */

namespace App\Classes;


use App\Classes\Facades\GameEvents as ColorEvents;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class GameInfo
{
    public $unitTypes, $unitColumns, $unitCombatColumns, $intelColumns;

    public function __construct()
    {
        $this->unitTypes = ['Untrained', 'Berserker', 'Paladin', 'Archer', 'Saboteur', 'Merchant', 'Injured'];
        $this->unitColumns = ['untrained', 'berserkers', 'paladins', 'archers', 'saboteurs', 'merchants', 'injured'];
        $this->unitCombatColumns = ['untrained', 'berserkers', 'paladins', 'archers', 'saboteurs'];
        $this->intelColumns = [
            'techs.siege',
            'techs.replication',
            'resources.turns',
            'resources.gold',
            'units.untrained',
            'units.berserkers',
            'units.paladins',
            'units.archers',
            'units.saboteurs',
            'units.injured',
            'units.spies',
            'units.merchants'];
    }

    public function intelColumns()
    {
        return $this->intelColumns;
    }

    public function unitTypes()
    {
        return $this->unitTypes;
    }

    public function unitCombatColumns()
    {
        return $this->unitCombatColumns;
    }

    public function unitColumns()
    {
        return $this->unitColumns;
    }

    public function maxTurns()
    {
        return 200;
    }

    public function raceChanges()
    {
        return 3;
    }

    public function startingUnits()
    {
        return 50;
    }

    public function startingGold()
    {
        return 500;
    }

    public function startingTurns()
    {
        return 20;
    }

    public function startingBerserkers()
    {
        return 0;
    }

    public function startingPaladins()
    {
        return 0;
    }

    public function startingMerchants()
    {
        return 0;
    }

    public function startingInjured()
    {
        return 0;
    }

    public function startingArchers()
    {
        return 0;
    }

    public function startingSaboteurs()
    {
        return 0;
    }

    public function startingSpies()
    {
        return 0;
    }

    public function startingFortification()
    {
        return 0;
    }

    public function startingSiege()
    {
        return 0;
    }

    public function startingReplication()
    {
        return 0;
    }

    public function costForNextIntelligence($user)
    {
        $intelligence = $user->techs->intelligence;
        if ($intelligence + 1 > Config::get('constants.max_intelligence'))
            return false;
        $string = Config::get('constants.value_intelligence')[$intelligence + 1];

        if ($user->race_name == "oranges")
            $string *= $this->orangeBonus();

        return $string;
    }

    public function orangeBonus()
    {
        return 0.85;
    }

    public function intelligenceForUser($user)
    {
        return $user->units->spies * $this->intelligenceBonus($user->techs->intelligence);
    }

    public function intelligenceBonus($final)
    {
        if ($final != 0) {
            return round(GameInfo::intelligenceBonus($final - 1) * (1 + 0.35), 2);
        } else return 1;
    }

    public function nextSiegeToString($siege)
    {
        return GameInfo::siegeToString($siege + 1);
    }

    public function siegeToString($siege)
    {
        if ($siege > Config::get('constants.max_siege'))
            return false;
        $string = Config::get('constants.tech_siege')[$siege];

        return $string;
    }

    public function costForNextSiege($siege)
    {
        $user = Auth::user();
        if ($siege + 1 > Config::get('constants.max_siege'))
            return false;
        $string = Config::get('constants.value_siege')[$siege + 1];

        if ($user->race_name == "oranges")
            $string *= $this->orangeBonus();

        return $string;
    }

    public function nextFortToString($fort)
    {
        return GameInfo::fortToString($fort + 1);
    }

    public function fortToString($fort)
    {
        if ($fort > Config::get('constants.max_fort'))
            return false;
        $string = Config::get('constants.tech_fort')[$fort];

        return $string;
    }

    public function costForNextFort($fort)
    {
        $user = Auth::user();
        if ($fort + 1 > Config::get('constants.max_fort'))
            return false;
        $string = Config::get('constants.value_fort')[$fort + 1];

        if ($user->race_name == "oranges")
            $string *= $this->orangeBonus();

        return $string;
    }

    public function nextReplication($replication)
    {
        return GameInfo::replication($replication + 1);
    }

    public function replication($replication)
    {
        if ($replication > Config::get('constants.max_repli'))
            return "Already at max Unit Replication";
        $string = Config::get('constants.tech_replication')[$replication];

        return $string;
    }

    public function costForNextReplication($replication)
    {
        $user = Auth::user();
        if ($replication + 1 > Config::get('constants.max_repli'))
            return false;
        $string = Config::get('constants.value_repli')[$replication + 1];

        if ($user->race_name == "oranges")
            $string *= $this->orangeBonus();

        return $string;
    }

    public function incomeForUser(User $user)
    {
        $income = 0;
        $income += $user->units->untrained * Config::get('constants.untrained_income');
        $income += $user->units->berserkers * Config::get('constants.berserker_income');
        $income += $user->units->paladins * Config::get('constants.paladin_income');
        $income += $user->units->merchants * Config::get('constants.merchant_income');
        $income += $user->units->archers * Config::get('constants.archer_income');
        $income += $user->units->saboteurs * Config::get('constants.saboteur_income');

        if ($user->race_name == "greens")
            $income *= $this->greenBonus();

        return $income;
    }

    public function greenBonus()
    {
        return 1.30;
    }

    public function goldRushBonus()
    {
        return 2;
    }

    public function titheIncomeForUser(User $user)
    {
        $income = $user->units->paladins * Config::get('constants.paladin_income') * 2;
        if ($user->race_name == "greens")
            $income *= $this->greenBonus();

        return $income;

    }

    public function swissTimeIncomeForUser(User $user)
    {
        $income = $user->units->merchants * Config::get('constants.merchant_income');
        if ($user->race_name == "greens")
            $income *= $this->greenBonus();

        return $income;

    }

    public function attackForUser(User $user, $type = 'All')
    {
        $attack = 0;
        if ($type == 'All' || $type == 'Untrained')
            $attack += $user->units->untrained * Config::get('constants.untrained_attack');
        if ($type == 'All' || $type == 'Berserker') {
            $berserkerAttack = $user->units->berserkers * Config::get('constants.berserker_attack');
            if (ColorEvents::currentEvent() != null && ColorEvents::currentEvent()->event->code == 'berserkers')
                $berserkerAttack *= 2;
            $attack += $berserkerAttack;
        }
        if ($type == 'All' || $type == 'Paladin')
            $attack += $user->units->paladins * Config::get('constants.paladin_attack');
        if ($type == 'All' || $type == 'Archer') {
            if (ColorEvents::currentEvent() != null && ColorEvents::currentEvent()->event->code == 'archers')
                $attack += $user->units->archers * $user->techs->fortification;
            else
                $attack += $user->units->archers * Config::get('constants.archer_attack');
        }
        if ($type == 'All' || $type == 'Saboteur')
            $attack += $user->units->saboteurs * $user->techs->siege;
        if ($type == 'All' || $type == 'Merchant')
            $attack += $user->units->merchants * Config::get('constants.merchant_attack');
        if ($type == 'All' || $type == 'Injured')
            $attack += $user->units->injured * Config::get('constants.injured_attack');

        $attack *= GameInfo::attackBonus($user->techs->siege);
        if ($user->race_name == "reds") $attack *= $this->redBonus();
        if (ColorEvents::currentEvent() != null && ColorEvents::currentEvent()->event->code == 'blood_rage')
            $attack *= $this->bloodRageBonus();

        return $attack;
    }

    public function attackBonus($final)
    {
        if ($final != 0) {
            return round(GameInfo::attackBonus($final - 1) * (1 + Config::get('constants.attack_percent')), 2);
        } else return 1;
    }

    public function redBonus()
    {
        return 1.30;
    }

    public function bloodRageBonus()
    {
        return 1.25;
    }

    public function defenseForUser(User $user, $type = 'All')
    {
        $defense = 0;
        if ($type == 'All' || $type == 'Untrained')
            $defense = $user->units->untrained * Config::get('constants.untrained_defense');
        if ($type == 'All' || $type == 'Berserker')
            $defense += $user->units->berserkers * Config::get('constants.berserker_defense');
        if ($type == 'All' || $type == 'Paladin')
            $defense += $user->units->paladins * Config::get('constants.paladin_defense');
        if ($type == 'All' || $type == 'Archer')
            $defense += $user->units->archers * $user->techs->fortification;
        if ($type == 'All' || $type == 'Saboteur')
            $defense += $user->units->saboteurs * Config::get('constants.saboteur_defense');
        if ($type == 'All' || $type == 'Merchant')
            $defense += $user->units->merchants * Config::get('constants.merchant_defense');
        if ($type == 'All' || $type == 'Injured')
            $defense += $user->units->injured * Config::get('constants.injured_defense');
        $defense *= GameInfo::defenseBonus($user->techs->fortification);
        if ($user->race_name == "blues") $defense *= $this->blueBonus();
        if (ColorEvents::currentEvent() != null && ColorEvents::currentEvent()->event->code == 'sandstorm')
            $defense *= $this->sandstormBonus();

        return $defense;
    }

    public function defenseBonus($final)
    {
        if ($final != 0) {
            return round(GameInfo::defenseBonus($final - 1) * (1 + Config::get('constants.def_percent')), 2);
        } else return 1;
    }

    public function blueBonus()
    {
        return 1.30;
    }

    public function sandstormBonus()
    {
        return 1.25;
    }

    public function costForUnit($type)
    {
        if ($type == 'Untrained')
            return Config::get('constants.untrained_cost');
        if ($type == 'Berserker')
            return Config::get('constants.berserker_cost');
        if ($type == 'Paladin')
            return Config::get('constants.paladin_cost');
        if ($type == 'Archer')
            return Config::get('constants.archer_cost');
        if ($type == 'Saboteur')
            return Config::get('constants.saboteur_cost');
        if ($type == 'Merchant')
            return Config::get('constants.merchant_cost');
        if ($type == 'Spy')
            return Config::get('constants.spy_cost');
        if ($type == 'Injured')
            return Config::get('constants.injured_cost');
        if ($type == 'Untrain')
            return Config::get('constants.untrain_cost');

        return 0;
    }

    public function attackForUnit($type)
    {
        if ($type == 'Untrained')
            return Config::get('constants.untrained_attack');
        if ($type == 'Berserker')
            return Config::get('constants.berserker_attack');
        if ($type == 'Paladin')
            return Config::get('constants.paladin_attack');
        if ($type == 'Archer')
            return Config::get('constants.archer_attack');
        if ($type == 'Saboteur')
            return '1 * level of Siege Technology';
        if ($type == 'Merchant')
            return Config::get('constants.merchant_attack');
        if ($type == 'Injured')
            return Config::get('constants.injured_attack');
        if ($type == 'Untrain')
            return Config::get('constants.untrain_attack');

        return 0;
    }

    public function defenseForUnit($type)
    {
        if ($type == 'Untrained')
            return Config::get('constants.untrained_defense');
        if ($type == 'Berserker')
            return Config::get('constants.berserker_defense');
        if ($type == 'Paladin')
            return Config::get('constants.paladin_defense');
        if ($type == 'Archer')
            return '1 * level of Fortification Technology';
        if ($type == 'Saboteur')
            return Config::get('constants.saboteur_defense');
        if ($type == 'Merchant')
            return Config::get('constants.merchant_defense');
        if ($type == 'Injured')
            return Config::get('constants.injured_defense');
        if ($type == 'Untrain')
            return Config::get('constants.untrain_defense');

        return 0;
    }

    public function incomeForUnit($type)
    {
        if ($type == 'Untrained')
            return Config::get('constants.untrained_income');
        if ($type == 'Berserker')
            return Config::get('constants.berserker_income');
        if ($type == 'Paladin')
            return Config::get('constants.paladin_income');
        if ($type == 'Archer')
            return Config::get('constants.archer_income');
        if ($type == 'Saboteur')
            return Config::get('constants.saboteur_income');
        if ($type == 'Spy')
            return Config::get('constants.spy_income');
        if ($type == 'Merchant')
            return Config::get('constants.merchant_income');
        if ($type == 'Injured')
            return Config::get('constants.injured_income');
        if ($type == 'Untrain')
            return Config::get('constants.untrain_income');

        return 0;
    }

    public function spyForUnit($type)
    {
        if ($type == 'Spy')
            return 1;
        else return 0;
    }

    public function siegeModifier()
    {
        return Config::get('constants.attack_percent') * 100 . '%';
    }

    public function fortModifier()
    {
        return Config::get('constants.def_percent') * 100 . '%';
    }

    public function replicationFrequency()
    {
        return Config::get('constants.unit_freq');
    }

    public function incomeFrequency()
    {
        return Config::get('constants.income_freq');
    }

    public function formatNum($val)
    {
        $precision = 2;
        if ($val < 1000) {
            $n_format = number_format($val);
        } else if ($val < 1000000) {
            $n_format = number_format($val / 1000, $precision) . 'K';
        } else if ($val < 1000000000) {
            $n_format = number_format($val / 1000000, $precision, '.', ',') . 'M';
        } else {
            $n_format = number_format($val / 1000000000, $precision, '.', ',') . 'B';
        }

        return $n_format;
    }

    public function turnsForUser(User $user = null)
    {
        return 2;
    }

    public function attackCost()
    {
        return 4;
    }

    public function spyCost()
    {
        return 1;
    }

    public function costForNextAutobanking($autobanking)
    {
        $user = Auth::user();

        if ($autobanking + 1 > Config::get('constants.max_autobanking'))
            return false;
        $string = Config::get('constants.value_autobanking')[$autobanking + 1];

        if ($user->race_name == "oranges")
            $string *= $this->orangeBonus();

        return $string;
    }

    public function nextAutobanking($user)
    {
        return GameInfo::autobanking($user, true);
    }

    public function autobanking(User $user = null, $next = false)
    {
        if ($user) {
            if ($user->balance->autobanking + $next > Config::get('constants.max_autobanking'))
                return false;
            if ($user->race_name == 'blues')
                return ($user->balance->autobanking + 1 + $next + $this->blueAutoBankingBonus()) * 5;

            return ($user->balance->autobanking + 1 + $next) * 5;
        }

        return (1 + $next) * 5;
    }

    public function blueAutoBankingBonus()
    {
        return 2;
    }

    public function calcularInjureds($attacker, $defender, $attack, $defense)
    {
        if ($attack > $defense) {
            $ratio = round($defense * 50 / $attack);
            $ar = $ratio / 100;
            $dr = (100 - $ratio) / 100;
        } else {
            $ratio = round($attack * 50 / $defense);
            $ar = (100 - $ratio) / 100;
            $dr = $ratio / 100;
        }
        $a_units = self::unitsForUser($attacker);
        $a_berserker_ratio = $attacker->units->berserkers / $a_units;
        $a_paladin_ratio = $attacker->units->paladins / $a_units;
        $a_archer_ratio = $attacker->units->archers / $a_units;
        $a_saboteur_ratio = $attacker->units->saboteurs / $a_units;
        $a_untrained_ratio = $attacker->units->untrained / $a_units;

        $d_units = self::unitsForUser($defender);
        $d_berserker_ratio = $defender->units->berserkers / $d_units;
        $d_paladin_ratio = $defender->units->paladins / $d_units;
        $d_archer_ratio = $defender->units->archers / $d_units;
        $d_saboteur_ratio = $defender->units->saboteurs / $d_units;
        $d_untrained_ratio = $defender->units->untrained / $d_units;
        $injureds = [
            'attacker' => [
                'untrained'  => round(mt_rand($a_units / 500, $a_units / 100) * $ar * $a_untrained_ratio),
                'berserkers' => round(mt_rand($a_units / 1000, $a_units / 200) * $ar * $a_berserker_ratio),
                'paladins'   => round(mt_rand($a_units / 1000, $a_units / 200) * $ar * $a_paladin_ratio),
                'archers'    => round(mt_rand($a_units / 1000, $a_units / 200) * $ar * $a_archer_ratio),
                'saboteurs'  => round(mt_rand($a_units / 1000, $a_units / 200) * $ar * $a_saboteur_ratio),
            ],
            'defender' => [
                'untrained'  => round(mt_rand($d_units / 500, $d_units / 100) * $dr * $d_untrained_ratio),
                'berserkers' => round(mt_rand($d_units / 1000, $d_units / 200) * $dr * $d_berserker_ratio),
                'paladins'   => round(mt_rand($d_units / 1000, $d_units / 200) * $dr * $d_paladin_ratio),
                'archers'    => round(mt_rand($d_units / 1000, $d_units / 200) * $dr * $d_archer_ratio),
                'saboteurs'  => round(mt_rand($d_units / 1000, $d_units / 200) * $dr * $d_saboteur_ratio),
            ],
        ];

        return $injureds;
    }

    public function unitsForUser(User $user)
    {
        $untrained = $user->units->untrained;
        $berserkers = $user->units->berserkers;
        $paladins = $user->units->paladins;
        $archers = $user->units->archers;
        $saboteurs = $user->units->saboteurs;
        $total = $untrained + $berserkers + $paladins + $archers + $saboteurs;

        return $total;
    }
}

