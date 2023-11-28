<?php

namespace App\Http\Controllers;

use App\Models\Customerstype;
use Illuminate\Http\Request;

class CustomerTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customerstypes = Customerstype::all();
        $page_title = 'Customers Types';
        return view('customer.customerstypes.index', compact('customerstypes', 'page_title'));//
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customer.customerstypes.create');
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
            'type_name' => 'required |unique:customerstypes,type_name,string',
        ]);

        Customerstype::create([

            'type_name' => $request->type_name,

        ]);

        return redirect()->route('customerstypes.index'); 
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
        $customerstype = Customerstype::findOrFail($id);

        return view('customer.customerstypes.edit', compact('customerstype'));
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
        $customertypes = Customerstype::findOrFail($id);

        if ($request->type_name != $customertypes->type_name) {

            $request -> validate([
                'type_name' => 'required |unique:customerstypes,type_name,string',
            ]);
            
        }

        $request->validate([
            'type_name' => 'required|string'
        ]);

        $customertypes->update([
            
            'type_name' => $request->type_name,
        ]);

        return redirect()->route('customerstypes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customertypes = Customerstype::findOrFail($id);

        $customertypes->delete();

        return redirect()->route('customer.customerstypes.index');
    }
}
