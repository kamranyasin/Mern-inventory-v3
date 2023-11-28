<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::all();
        $page_title = 'Suppliers';
        return view('supplier.index', compact('suppliers', 'page_title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('supplier.create');
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
            'supplier_name' => 'required | string',
            'supplier_phone' => 'required|unique:suppliers,supplier_phone,bigInteger',
            'supplier_address' => 'required | string',
            'city' => 'required | string'
        ]);

        Supplier::create([

            'supplier_name' => $request->supplier_name,
            'supplier_phone' => $request->supplier_phone,
            'supplier_address' => $request->supplier_address,
            'city' => $request->city

        ]);

        return redirect()->route('supplier.index');

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
        $supplier = Supplier::findOrFail($id);

        return view('supplier.edit', compact('supplier'));
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
        $supplier = Supplier::findOrFail($id);

        if ($request->supplier_phone != $supplier->supplier_phone) {

            $request -> validate([
                'supplier_phone' => 'required|unique:suppliers,supplier_phone,bigInteger',
            ]);
            
        }

        $request -> validate([
            'supplier_name' => 'required | string',
            'supplier_phone' => 'required|numeric',
            'supplier_address' => 'required | string',
            'city' => 'required | string'
        ]);

        $supplier->update([

            'supplier_name' => $request->supplier_name,
            'supplier_phone' => $request->supplier_phone,
            'supplier_address' => $request->supplier_address,
            'city' => $request->city

        ]);

        return redirect()->route('supplier.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);

        $supplier->delete();

        return redirect()->route('supplier.index');

    }
}
