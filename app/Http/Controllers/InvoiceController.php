<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customers;
use App\Models\Invoice;
use App\Models\InvoiceMeta;
use App\Models\Product;
use App\Models\Units;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::all();
        $page_title = 'Invoice';

        return view('invoice.index', compact('invoices', 'page_title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $invoice_no = $this->uniqueNumber();
        $page_title = 'Create Invoice';
        $customers = Customers::all();
        $categories = Category::all();
        $units = Units::all();
        $products = Product::all();
        return  view('invoice.create', compact('customers', 'invoice_no', 'products', 'categories', 'units','page_title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'invoice_no' => 'required',
            'customer_name' => 'required',
            'total_amount' => 'required',
            'paid_amount' => 'required',
            'category_id' => 'required',
            'product_id' => 'required',
            'unit_id' => 'required',
            'unit_price' => 'required',
            'quantity' => 'required',
        ]);

        $invoice = Invoice::create([

            'invoice_no' => $request->invoice_no,
            'customer_name' => $request->customer_name,
            'total_amount' => $request->total_amount,
            'paid_amount' => $request->paid_amount,
            'due_amount' => (int)$request->total_amount-(int)$request->paid_amount,

        ]);

        for ($i=0; $i < count($request->category_id); $i++) {

            InvoiceMeta::create([
                'invoice_id' => $invoice->id,
                'category_id' => $request->category_id[$i],
                'product_id' => $request->product_id[$i],
                'unit_price' => $request->unit_price[$i],
                'quantity' => $request->quantity[$i],
                'unit_id' => $request->unit_id[$i],
            ]);



        }

        return redirect()->route('invoice.index');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $invoice = Invoice::findOrFail($id);
        $page_title = 'Invoice Detail';
        return view('invoice.show', compact('invoice', 'page_title'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoice = Invoice::findOrFail($id);
        $page_title = 'Invoice Edit';
        $customers = Customers::all();
        $categories = Category::all();
        $products = Product::all();
        $units = Units::all();



        return view('invoice.edit', compact('invoice', 'products', 'customers', 'categories', 'units', 'page_title'));
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
        $invoice = Invoice::findOrFail($id);

        $request->validate([
            'invoice_no' => 'required',
            'customer_name' => 'required',
            'total_amount' => 'required',
            'paid_amount' => 'required',
            'category_id' => 'required',
            'product_id' => 'required',
            'unit_id' => 'required',
            'unit_price' => 'required',
            'quantity' => 'required',
        ]);

        $invoice->update([

            'invoice_no' => $request->invoice_no,
            'customer_name' => $request->customer_name,
            'total_amount' => $request->total_amount,
            'paid_amount' => $request->paid_amount,
            'due_amount' => (int)$request->total_amount-(int)$request->paid_amount,

        ]);

        foreach($invoice->invoiceMeta as $item){
            $item->delete();
        }

        for ($i=0; $i < count($request->category_id); $i++) {

            InvoiceMeta::create([
                'invoice_id' => $invoice->id,
                'category_id' => $request->category_id[$i],
                'product_id' => $request->product_id[$i],
                'unit_price' => $request->unit_price[$i],
                'quantity' => $request->quantity[$i],
                'unit_id' => $request->unit_id[$i],
                'total_Amount' =>(int)$request->quantity*(int)$request->unit_price,
            ]);



        }


        return redirect()->route('invoice.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);

        foreach($invoice->invoiceMeta as $item) {

            $item->delete();

        }

        $invoice->delete();

        return back();

    }


    // order number function
    public function uniqueNumber(){

        $invoice = Invoice::latest()->first();

        if($invoice){
            $name = $invoice->invoice_no;
            $number = explode('_', $name);
            $invoice_no = 'Inv_'. str_pad((int)$number[1]+1, 7, "0", STR_PAD_LEFT);
        }else{

            $invoice_no = 'Inv_0000001';


        }

        return $invoice_no;

    }

    public function getProduct($id){

        $products = Product::where('category_type', $id)->get();

        return response()->json($products);

    }


}
