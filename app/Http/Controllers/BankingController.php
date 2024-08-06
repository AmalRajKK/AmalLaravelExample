<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class BankingController extends Controller
{
    public function index()
    {
        $account = Account::where('user_id', Auth::id())->first();
        return view('usermenu', compact('account'));
    }

    public function deposit(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $account = Account::where('user_id', Auth::id())->first();
        $account->balance += $request->amount;
        $account->save();

        Transaction::create([
            'user_id' => Auth::id(),
            'account_id' => $account->id,
            'type' => 'deposit',
            'amount' => $request->amount,
        ]);

        return redirect()->back()->with('success', 'Amount deposited successfully');
    }

    public function withdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $account = Account::where('user_id', Auth::id())->first();

        if ($account->balance < $request->amount) {
            return redirect()->back()->with('error', 'Insufficient balance');
        }

        $account->balance -= $request->amount;
        $account->save();

        Transaction::create([
            'user_id' => Auth::id(),
            'account_id' => $account->id,
            'type' => 'withdrawal',
            'amount' => $request->amount,
        ]);

        return redirect()->back()->with('success', 'Amount withdrawn successfully');
    }

    public function transfer(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'email' => 'required|email',
        ]);

        $recipient = User::where('email', $request->email)->first();

        if (!$recipient) {
            return redirect()->back()->with('error', 'Recipient not found');
        }

        $account = Account::where('user_id', Auth::id())->first();
        $recipientAccount = Account::where('user_id', $recipient->id)->first();

        if ($account->balance < $request->amount) {
            return redirect()->back()->with('error', 'Insufficient balance');
        }

        $account->balance -= $request->amount;
        $account->save();

        $recipientAccount->balance += $request->amount;
        $recipientAccount->save();

        Transaction::create([
            'user_id' => Auth::id(),
            'account_id' => $account->id,
            'type' => 'transfer',
            'amount' => $request->amount,
        ]);

        return redirect()->back()->with('success', 'Amount transferred successfully');
    }

    public function statement()
    {
        $transactions = Transaction::where('user_id', Auth::id())->get();
        return view('statement', compact('transactions'));
    }

    public function depositView()
    {
        return view('banking.deposit');
    }
    public function withdrawView()
    {
        return view('banking.withdraw');
    }
}
