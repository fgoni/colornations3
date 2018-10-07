<?php

namespace App\Http\Controllers;

use App\Ranking;
use App\Season;
use App\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ViewController extends Controller
{
    public function getBattlefield()
    {
        $users = User::with('ranking', 'techs', 'units', 'resources')->select(DB::raw('users.*, rankings.overall_rank'))
            ->join('rankings', 'users.id', '=', 'rankings.user_id')
            ->groupBy('user_id', 'overall_rank')
            ->orderBy('rankings.overall_rank', 'asc')
            ->get();

        $users = $users->filter(function ($user) {
            return $user->activated;
        });

        $users = $users->reject(function ($user) {
            return !$user->ranking;
        });

        return view('app.battlefield', compact('users'));
    }

    public function getGameinfo()
    {
        return view('app.gameinfo');
    }

    public function getHistory()
    {
        $seasons = Season::all();

        return view('app.history', compact('seasons'));
    }

    public function getIndex()
    {
        if (Auth::check() && !Auth::user()->activated)
            return redirect('dashboard/settings');

        $topPlayers = new Collection();
        $topRankings = Ranking::with('user')->topPlayers()->get();
        foreach ($topRankings as $ranking) {
            $topPlayers->push($ranking->user);
        }
        $lastSeasonTopPlayers = new Collection();
        $lastSeason = Season::penultimate()->first();
        if ($lastSeason != null) {
            $lastSeasonTopPlayers->push($lastSeason->winner);
            $lastSeasonTopPlayers->push($lastSeason->runnerUp);
            $lastSeasonTopPlayers->push($lastSeason->thirdPlace);
        }

        return view('app.index', compact('topPlayers', 'lastSeasonTopPlayers'));
    }
}
