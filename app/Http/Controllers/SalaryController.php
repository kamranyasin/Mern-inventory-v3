<?php

namespace App\Http\Controllers;

use App\Models\Labour;
use App\Models\Salary;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $salaries = Salary::all();
      $page_title = 'Salary';
      return view('salary.index', compact('salaries', 'page_title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $labour_details = Labour::all();
      return view('salary.create', compact('labour_details'));
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
        'labour_name' => 'required | string',
        'salary' => 'required | integer',
        'bonus' => 'required | integer',
        'total' => 'required | integer',
        'issue_date' => 'required| date',
      ]);

      Salary::create([

          'labour_name' => $request->labour_name,
          'salary' => $request->salary,
          'bonus' => $request->bonus,
          'total' => $request->total,
          'issue_date' => $request->issue_date,


      ]);

      return redirect()->route('salary.index');
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
      $labours = Labour::all();
      $salary = Salary::findOrFail($id);
      return view('salary.edit', compact('salary','labours'));
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
      $salary = Salary::findOrFail($id);

      $request -> validate([
        'labour_name' => 'required | string',
        'salary' => 'required | integer',
        'bonus' => 'required | integer',
        'total' => 'required | integer',
        'issue_date' => 'required| date',
      ]);

      $salary->update([

        'labour_name' => $request->labour_name,
        'salary' => $request->salary,
        'bonus' => $request->bonus,
        'total' => $request->total,
        'issue_date' => $request->issue_date,

      ]);

      return redirect()->route('salary.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $salary = Salary::findOrFail($id);

      $salary->delete();

      return redirect()->route('salary.index');
    }
}
