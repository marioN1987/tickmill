<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Client;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        $transactionsWithClientDetails = DB::table('clients')
        ->join('transactions', 'clients.id', '=', 'transactions.client_id')
        ->select('transactions.id As id', 'transactions.amount', 'clients.firstname', 'clients.lastname', 'clients.email')
        ->paginate(10);

        return Inertia::render('Transactions/List', [
            'transactions' => $transactionsWithClientDetails
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientsList = Client::all();

        return Inertia::render('Transactions/Create', [
            'clientsList' => $clientsList
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|gt:0',
            'clientId' => 'required|integer|exists:'.Client::class.',id'
        ]);

        // save transaction details in db
        Transaction::create([
            'client_id' => $request->clientId,
            'amount' => $request->amount
        ]);

        return redirect(route('transactions.list'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        // check if id exists in db
        $request->validate([
            'id' => 'required|integer|exists:'.Transaction::class.',id'
        ]);
        
        $transactionAndClientDetails = [];
        $transaction = Transaction::where('id', $request->id)->first();

        $transactionAndClientDetails['id'] = $transaction->id;
        $transactionAndClientDetails['amount'] = $transaction->amount;
        $transactionAndClientDetails['client'] = $transaction->client()->get()->toArray()[0];

        return Inertia::render('Transactions/Edit', [
            'transaction' => $transactionAndClientDetails
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // check if id exists in db
        $request->validate([
            'id' => 'required|integer|exists:'.Transaction::class.',id',
            'amount' => 'required|numeric|gt:0'
        ]);

        $transaction = Transaction::where('id', $request->id)->first();
        $transaction->amount = $request->amount;
        $transaction->update();

        return redirect(route('transactions.list'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        // check if id exists in db
        $request->validate([
            'id' => 'required|integer|exists:'.Transaction::class.',id'
        ]);

        $transaction = Transaction::where('id', $request->id)->first();

        $transaction->delete();

        return redirect(route('transactions.list'));
    }
}
