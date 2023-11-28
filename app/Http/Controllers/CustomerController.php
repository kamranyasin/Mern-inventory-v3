<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\Customerstype;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customers::all();
        $page_title = 'Customers';
        return view('customer.index', compact('customers', 'page_title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customerTypes = Customerstype::all();
        return view('customer.create', compact('customerTypes'));
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
            'customer_name' => 'required | string',
            'customer_phone' => 'required|unique:customers,customer_phone,bigInteger',
            'customer_address' => 'required | string',
            'customer_city' => 'required | string',
            'customer_type' => 'required | string',

        ]);

        Customers::create([

            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_address' => $request->customer_address,
            'customer_city' => $request->customer_city,
            'customer_type' => $request->customer_type

        ]);

        return redirect()->route('customer.index');

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
        $customer = Customers::findOrFail($id);
        $customerTypes = Customerstype::all();

        return view('customer.edit', compact('customer', 'customerTypes'));
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
        $customer = Customers::findOrFail($id);

        if ($request->customer_phone != $customer->customer_phone) {

            $request -> validate([
                'customer_phone' => 'required|unique:customers,customer_phone,bigInteger',
            ]);
            
        }

        $request -> validate([
            'customer_name' => 'required | string',
            'customer_phone' => 'required|numeric',
            'customer_address' => 'required | string',
            'customer_city' => 'required | string',
            'customer_type' => 'required'
        ]);

        $customer->update([

            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_address' => $request->customer_address,
            'customer_city' => $request->customer_city,
            'customer_type' => $request->customer_type
        ]);

        return redirect()->route('customer.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customers::findOrFail($id);

        $customer->delete();

        return redirect()->route('customer.index');
    }
}
