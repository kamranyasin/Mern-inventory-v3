<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $assets = Asset::all();
      $page_title = 'Assets';
      return view('assets.index', compact('assets', 'page_title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('assets.create');
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
        'payment_type' => 'required | string',
        'amount' => 'required | integer',
        'buying_year' => 'required | date',
        'buying_from' => 'required | string'

      ]);

      Asset::create([

          'name' => $request->name,
          'payment_type' => $request->payment_type,
          'amount' => $request->amount,
          'buying_year' => $request-> buying_year,
          'buying_from' => $request-> buying_from,
      ]);

      return redirect()->route('assets.index');
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
      $asset = Asset::findOrFail($id);

      return view('assets.edit', compact('asset'));
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
      $asset = Asset::findOrFail($id);

      $request -> validate([
        'name' => 'required | string',
        'payment_type' => 'required | string',
        'amount' => 'required | integer',
        'buying_year' => 'required | date',
        'buying_from' => 'required | string'
      ]);


      $asset->update([

          'name' => $request->name,
          'payment_type' => $request->payment_type,
          'amount' => $request->amount,
          'buying_year' => $request-> buying_year,
          'buying_from' => $request-> buying_from,

      ]);

      return redirect()->route('assets.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $asset = Asset::findOrFail($id);

      $asset->delete();

      return redirect()->route('assets.index');
    }
}
