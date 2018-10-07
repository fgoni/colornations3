<?php

namespace App\Http\Controllers;

use App\Bank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class BankController extends Controller
{

    public function deposit(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $user_balance = Bank::where('user_id', '=', $user->id)->first();
            if ($user_balance == null) {
                $user_balance = Bank::create([
                    'user_id' => $user->id,
                    'balance' => 0,
                ]);
            }
            if ($request->get('deposit') <= $user->resources->gold) {
                $user->resources->gold -= $request->get('deposit');
                $user_balance->balance = $user_balance->balance + $request->get('deposit') * Config::get('constants.deposit_rate');
                $user->resources->save();
                $user_balance->save();
            } else {
                return redirect()->back()->withErrors('Not enough gold in your bank account');
            }

            return redirect()->back()->with('success', 'You deposited ' . $request->get('deposit') . ' gold in your bank account.');
        }
    }

    public function withdraw(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $user_balance = Bank::where('user_id', '=', $user->id)->first();
            if ($user_balance == null) {
                $user_balance = Bank::create([
                    'user_id' => $user->id,
                    'balance' => 0,
                ]);
            }
            if ($request->get('withdraw') <= $user_balance->balance) {
                $user->resources->gold += $request->get('withdraw');
                $user_balance->balance -= $request->get('withdraw');
                $user->resources->save();
                $user_balance->save();
            } else {
                return redirect()->back()->withErrors('Not enough gold in your bank account');
            }

            return redirect()->back()->with('success', 'You withdrew ' . $request->get('withdraw') . ' gold from your bank account.');
        }
    }
}
