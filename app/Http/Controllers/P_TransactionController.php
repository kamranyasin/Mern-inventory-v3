<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\Transaction;
use Illuminate\Http\Request;

class P_TransactionController extends Controller
{
  public function create()
  {
    $partners = Partner::all();
    return view('transaction.partnersTransaction.create', compact('partners'));
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
}
