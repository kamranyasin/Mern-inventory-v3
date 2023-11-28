<?php

namespace App\Http\Controllers;

use App\Models\Labour;
use Illuminate\Http\Request;

class LabourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $labours = Labour::all();
      $page_title = 'Labour';
      return view('labour.index', compact('labours', 'page_title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('labour.create');
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
        'first_name' => 'required | string',
        'last_name' => 'required | string',
        'idn_number' => 'required| integer',
        'phone' => 'required | integer',
        'age' => 'required | integer',
        'address' => 'required | string',
        'city' => 'required | string',
        'work_type' => 'required | string',
        'join_date' => 'required | date',
        'salary' => 'required | integer'
      ]);

      Labour::create([

          'first_name' => $request->first_name,
          'last_name' => $request->last_name,
          'idn_number' => $request->idn_number,
          'phone' => $request->phone,
          'age' => $request->age,
          'address' => $request->address,
          'city' => $request->city,
          'work_type' => $request->work_type,
          'join_date' => $request->join_date,
          'salary' => $request->salary

      ]);

      return redirect()->route('labour.index');
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
      $labour = Labour::findOrFail($id);

      return view('labour.edit', compact('labour'));
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
      $labour = Labour::findOrFail($id);

      $request -> validate([
        'first_name' => 'required | string',
        'last_name' => 'required | string',
        'idn_number' => 'required| integer',
        'phone' => 'required | integer',
        'age' => 'required | integer',
        'address' => 'required | string',
        'city' => 'required | string',
        'work_type' => 'required | string',
        'join_date' => 'required | date',
        'salary' => 'required | integer'
      ]);

      $labour->update([

          'first_name' => $request->first_name,
          'last_name' => $request->last_name,
          'idn_number' => $request->idn_number,
          'phone' => $request->phone,
          'age' => $request->age,
          'address' => $request->address,
          'city' => $request->city,
          'work_type' => $request->work_type,
          'join_date' => $request->join_date,
          'salary' => $request->salary

      ]);

      return redirect()->route('labour.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $labour = Labour::findOrFail($id);

      $labour->delete();

      return redirect()->route('labour.index');
    }
}
