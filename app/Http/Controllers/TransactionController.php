<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $transactions = Transaction::all();
      $page_title = 'Transactions';
      return view('transaction.index', compact('transactions', 'page_title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $partners = Partner::all();
      return view('transaction.create', compact('partners'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $request -> validate([
        'payment_to_from' => 'required | string', // to partner or from anyone
        'type' => 'required | string',  // credit debit
        'using' => 'required | string', // card, cheque, cash
        'amount' => 'required | integer', //
        'status' => 'required | string', // verified, pending, rejected
        'transaction_date_time' => 'required | date'

      ]);

      Transaction::create([

          'payment_to_from' => $request->payment_to_from,
          'type' => $request->type,
          'using' => $request->using,
          'amount' => $request->amount,
          'status' => $request->status,
          'transaction_date_time' => $request->transaction_date_time
      ]);

      return redirect()->route('transaction.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $partners = Partner::all();
      $transaction = Transaction::findOrFail($id);

      return view('transaction.edit', compact('transaction', 'partners'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $transaction = Transaction::findOrFail($id);

      $request -> validate([
        'payment_to_from' => 'required | string', // to partner or from anyone
        'type' => 'required | string',  // credit debit
        'using' => 'required | string', // card, cheque, cash
        'amount' => 'required | integer', //
        'status' => 'required | string', // verified, pending, rejected
        'transaction_date_time' => 'required | date'
      ]);


      $transaction->update([

        'payment_to_from' => $request->payment_to_from,
        'type' => $request->type,
        'using' => $request->using,
        'amount' => $request->amount,
        'status' => $request->status,
        'transaction_date_time' => $request->transaction_date_time
      ]);

      return redirect()->route('transaction.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $transaction = Transaction::findOrFail($id);

      $transaction->delete();

      return redirect()->route('transaction.index');
    }
}
