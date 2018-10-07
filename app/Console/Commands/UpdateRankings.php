<?php

namespace App\Console\Commands;

use App\Classes\Facades\GameInfo;
use App\Ranking;
use App\User;
use Exception;
use Illuminate\Console\Command;

class UpdateRankings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cn:updaterankings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates the rankings of the players';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Starting update...');

        try {
            $users = User::whereActivated(true)->get();

            $attack[] = [];
            $defense[] = [];
            $overall[] = [];

            //Cargo todos los usuarios en un array de Ataque y Defensa.
            foreach ($users as $key => $user) {
                $attack[$key] = [GameInfo::attackForUser($user), $user->id];
                $defense[$key] = [GameInfo::defenseForUser($user), $user->id];
            }

            //Los ordeno
            array_multisort($defense, SORT_DESC);
            array_multisort($attack, SORT_DESC);

            //Ahora que ya están ordenados, les agrego el ranking.
            foreach ($attack as $key => $value) {//0=ataque, 1=usuario, 2=ranking
                $attack[$key] = [$value[0], $value[1], $key + 1];
            }
            foreach ($defense as $key => $value) {//0=ataque, 1=usuario, 2=ranking
                $defense[$key] = [$value[0], $value[1], $key + 1];
            }


            foreach ($users as $key => $user) {
                $overall[$key] = [self::getRankF($user->id, $attack) + self::getRankF($user->id, $defense), $user->id, GameInfo::attackForUser($user) + GameInfo::defenseForUser($user)];
            }

            //Tengo que crear dos arrays nuevos donde almaceno los valores de SumaRankings y SumaStats, que es el que desempata en caso de que
            //dos jugadores tengan el mismo SumaRankings.

            foreach ($overall as $value) {
                $overallRank[] = $value[0];
            }
            foreach ($overall as $value) {
                $overallStats[] = $value[2];
            }

            //Ordeno primero por sumaRank y dsp por sumaStats.
            array_multisort($overallRank, SORT_ASC, $overallStats, SORT_DESC, $overall);

            foreach ($overall as $key => $value) {//0=sumaRankings, 1=sumaStats, 2=usuario, 3=ranking
                $overall[$key] = [$value[0], $value[1], $value[2], $key + 1];
            }

            foreach ($users as $user) {
                $ar = self::getRankF($user->id, $attack);
                $dr = self::getRankF($user->id, $defense);
                $or = self::getRankF($user->id, $overall);
                $ranking = Ranking::whereUserId($user->id)->first();

                if ($ranking == null) {
                    $ranking = Ranking::create([
                        'user_id'      => $user->id,
                        'attack_rank'  => $ar,
                        'defense_rank' => $dr,
                        'overall_rank' => $or,
                    ]);
                } else {
                    $ranking->attack_rank = $ar;
                    $ranking->defense_rank = $dr;
                    $ranking->overall_rank = $or;
                }
                $ranking->save();
            }
        } catch (Exception $e) {
            $this->error('Something bad happened!');
            $this->error('UpdateRankings Command: ' . $e->getMessage());
            $this->error('Error: ' . $e->getTraceAsString());
        }
        $this->info('Rankings updated successfully!');
    }

    //Para funciones
    private function getRankF($id, $array)
    {
        foreach ($array as $key => $val) {
            if ($val[1] == $id) {
                return $key + 1;
            }
        }

        return null;
    }
}
