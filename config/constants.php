<?php

if (!function_exists('generateValues')) {
    function generateValues($starting, $first, $times, $modifier = 2)
    {
        $aux = null;
        for ($i = 0; $i < $times; $i++) {
            if ($i != 0) {
                if ($i != 1) {
                    $aux[$i] = $aux[$i - 1] * $modifier;
                } else $aux[$i] = $first;
            } else $aux[$i] = $starting;
        }

        return $aux;
    }
}

$tech_siege = ["None", "Sticks", "Spears", "Chariots", "War Galleys", "Battering Rams", "Siege Towers", "Triremes", "Ballistae", "Greek Fire", "Trebuchets", "Catapults", "Cannons", "Big Bertha", "Rockets", "ATG Missiles", "Nukes"];
$tech_fort = ["None", "Palisade", "Stone Walls", "Battlements", "Bastion", "Towers", "Moat", "Stronghold", "Castle", "Boiling Oil", "Citadel", "Trenches", "Fortress", "Bunker", "Shelter", "AEGIS System", "Force Field"];
$tech_replication = generateValues(1, 2, 14);

return [
    'siege'              => 0,
    'fort'               => 0,
    'unitprod'           => 0,
    'gold'               => 500,
    'unit_freq'          => 6,
    'income_freq'        => 30,
    'attack_percent'     => 0.20,
    'def_percent'        => 0.20,
    'units'              => 30,
    'race_changes'       => 2,
    'deposit_rate'       => 0.8,
    'deposit_interval'   => 1,
    'tech_siege'         => $tech_siege,
    'tech_fort'          => $tech_fort,
    'value_siege'        => generateValues(0, 100, count($tech_siege)),
    'value_fort'         => generateValues(0, 100, count($tech_fort)),
    'value_autobanking'  => generateValues(0, 2000, 10, 3),
    'value_intelligence' => generateValues(0, 1000, 11, 3),
    'tech_replication'   => $tech_replication,
    'value_repli'        => generateValues(0, 40, count($tech_replication), 3),
    'world_bank'         => generateValues(0, 100, 10),
    'max_siege'          => count($tech_siege) - 1,
    'max_fort'           => count($tech_fort) - 1,
    'max_repli'          => count($tech_replication) - 1,
    'max_autobanking'    => 9,
    'max_intelligence'   => 10,
    'bonus_rojos'        => "25% Attack Strength",
    'bonus_verdes'       => "25% Defense Strength",
    'bonus_azules'       => "20% Extra Income",
    'bonus_naranjas'     => "20% Cheaper Upgrades",
    'racestyle'          => "",
    'site_name'          => "Color Nations",
    'untrained_attack'   => 2,
    'untrained_defense'  => 2,
    'untrained_income'   => 2,
    'berserker_attack'   => 8,
    'berserker_defense'  => 4,
    'berserker_income'   => 2,
    'paladin_attack'     => 4,
    'paladin_defense'    => 8,
    'paladin_income'     => 2,
    'archer_attack'      => 3,
    'archer_defense'     => 0,
    'archer_income'      => 2,
    'saboteur_attack'    => 0,
    'saboteur_defense'   => 3,
    'saboteur_income'    => 2,
    'archer_cost'        => 50,
    'saboteur_cost'      => 50,
    'berserker_cost'     => 50,
    'paladin_cost'       => 50,
    'untrain_cost'       => 10,
    'string_oro'         => "Treasure",
    'string_moneda'      => 'gold',
    'string_units'       => "Army",
    'string_fort'        => "Fortification",
    'string_siege'       => "Siege",
    'string_unitprod'    => "Unit Replication",
    'string_attack'      => "Attack Strength",
    'string_defense'     => "Defense Strength",
    'string_income'      => "Income",
    'string_race0'       => 'reds',
    'string_race1'       => 'greens',
    'string_race2'       => 'blues',
    'string_race3'       => 'oranges',
    'injured_attack'     => 0,
    'injured_defense'    => 0,
    'injured_cost'       => 200,
    'injured_income'     => 0,
    'merchant_attack'    => 0,
    'merchant_defense'   => 0,
    'merchant_income'    => 8,
    'merchant_cost'      => 100,
    'spy_income'         => 0,
    'spy_cost'           => 100,
    'season'             => 1,
    'season_length'      => 90,
];

