<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $expenses = Expense::all();
      $page_title = 'Expenses';
      return view('expense.index', compact('expenses', 'page_title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('expense.create');
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

          'name' => 'required | string',
          'quantity' => 'required|numeric',
          'paid_amount' => 'required|numeric',
          'due_amount' => 'required|numeric',
          'total_amount' => 'required|numeric'
        ]);

        Expense::create([

            'name' => $request->name,
            'quantity' => $request->quantity,
            'paid_amount' => $request->paid_amount,
            'due_amount' => $request->due_amount,
            'total_amount'=> $request->total_amount,

        ]);

        return redirect()->route('expense.index');

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
      $expense = Expense::findOrFail($id);

      return view('expense.edit', compact('expense'));
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
      $expense = Expense::findOrFail($id);

      $request -> validate([
        'name' => 'required | string',
        'quantity' => 'required|numeric',
        'paid_amount' => 'required|numeric',
        'due_amount' => 'required|numeric',
        'total_amount' => 'required|numeric'
      ]);

      $expense ->update([

        'name' => $request->name,
        'quantity' => $request->quantity,
        'paid_amount' => $request->paid_amount,
        'due_amount' => $request->due_amount,
        'total_amount'=> $request->total_amount,

      ]);

      return redirect()->route('expense.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $expense = Expense::findOrFail($id);

      $expense->delete();

      return redirect()->route('expense.index');
    }
}
