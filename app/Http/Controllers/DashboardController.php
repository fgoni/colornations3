<?php

namespace App\Http\Controllers;

use App\Bank;
use App\EventLog;
use App\Log;
use App\Ranking;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function Events()
    {
        $eventLogs = EventLog::with('event')->orderBy('started_at', 'desc')->simplePaginate(10);

        return view('app.eventlog', compact('eventLogs'));
    }

    public function Headquarters()
    {
        return view('app.headquarters');
    }

    public function Techs()
    {
        return view('app.techs');
    }

    public function Training()
    {

        return view('app.training');
    }

    public function CombatLog()
    {
        $attacks = Log::whereAttackerId(Auth::user()->id)->orderBy('updated_at', 'desc')->simplePaginate(10);
        $defenses = Log::whereDefenderId(Auth::user()->id)->orderBy('updated_at', 'desc')->simplePaginate(10);

        return view('app.combatlog', compact('attacks', 'defenses'));
    }

    public function Economy()
    {
        $bank_account = Bank::where('user_id', '=', Auth::user()->id)->first();
        if ($bank_account == null) {
            $bank_account = Bank::create([
                'user_id' => Auth::user()->id,
                'balance' => 0,
            ]);
        }
        $balance = $bank_account->balance;
        if (empty($balance))
            $balance = 0;

        return view('app.economy', compact('balance'));
    }

    public function Rankings()
    {
        $rankedPlayers = Ranking::orderBy('overall_rank');

        return view('app.rankings', compact('rankedPlayers'));
    }

    public function Settings()
    {
        return view('app.settings');
    }

    public function Profile()
    {
        return view('app.profile');
    }

    public function Intelligence()
    {
        return view('app.intelligence');
    }
}
