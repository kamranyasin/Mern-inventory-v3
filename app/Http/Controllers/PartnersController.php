<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;

class PartnersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $partners = Partner::all();
      $page_title = 'Partners';
      return view('partner.index', compact('partners', 'page_title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('partner.create');
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
        'percent' => 'required | integer',
        'name' => 'required | string',
        'phone_no' => 'required|unique:partners,phone_no,bigInteger',
        'Address' => 'required | string',
        'Intity' => 'required | string'
      ]);

      Partner::create([

          'percent' => $request->percent,
          'name' => $request->name,
          'phone_no' => $request->phone_no,
          'Address' => $request->Address,
          'Intity' => $request->Intity

      ]);

      return redirect()->route('partner.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $partner = Partner::findOrFail($id);

      return view('partner.edit', compact('partner'));
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
      $partner = Partner::findOrFail($id);

      $request -> validate([
          'percent' => 'required | integer',
          'name' => 'required | string',
          'phone_no' => 'required| integer',
          'Address' => 'required | string',
          'Intity' => 'required | string'
      ]);

      $partner->update([

        'percent' => $request->percent,
        'name' => $request->name,
        'phone_no' => $request->phone_no,
        'Address' => $request->Address,
        'Intity' => $request->Intity

      ]);

      return redirect()->route('partner.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $partner = Partner::findOrFail($id);

      $partner->delete();

      return redirect()->route('partner.index');
    }
}
