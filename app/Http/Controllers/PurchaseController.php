<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseMeta;
use App\Models\Supplier;
use App\Models\Units;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\CodeCoverage\Report\Xml\Unit;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchases = Purchase::all();
        $page_title = 'Purchase';

        return view('purchase.index', compact('purchases', 'page_title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $purchase_no = $this->uniqueNumber();
        $page_title = 'Create Purchase';
        $suppliers = Supplier::all();
        $categories = Category::all();
        $units = Units::all();
        return  view('purchase.create', compact('suppliers', 'purchase_no', 'categories', 'units','page_title'));
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
            'purchase_no' => 'required',
            'supplier_name' => 'required',
            'total_amount' => 'required',
            'paid_amount' => 'required',
            'category_id' => 'required',
            'product_id' => 'required',
            'unit_id' => 'required',
            'unit_price' => 'required',
            'quantity' => 'required',
        ]);

        $purchase = Purchase::create([

            'purchase_no' => $request->purchase_no,
            'supplier_name' => $request->supplier_name,
            'total_amount' => $request->total_amount,
            'paid_amount' => $request->paid_amount,
            'due_amount' => (int)$request->total_amount-(int)$request->paid_amount,

        ]);

        for ($i=0; $i < count($request->category_id); $i++) {

            PurchaseMeta::create([
                'purchase_id' => $purchase->id,
                'category_id' => $request->category_id[$i],
                'product_id' => $request->product_id[$i],
                'unit_price' => $request->unit_price[$i],
                'quantity' => $request->quantity[$i],
                'unit_id' => $request->unit_id[$i],
            ]);



        }

        return redirect()->route('purchase.index');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $purchase = Purchase::findOrFail($id);
        $page_title = 'Purchase Detail';
        return view('purchase.show', compact('purchase', 'page_title'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $purchase = Purchase::findOrFail($id);
        $page_title = 'Purchase Edit';
        $suppliers = Supplier::all();
        $categories = Category::all();
        $products = Product::all();
        $units = Units::all();



        return view('purchase.edit', compact('purchase', 'products', 'suppliers', 'categories', 'units', 'page_title'));
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
        $purchase = Purchase::findOrFail($id);

        $request->validate([
            'purchase_no' => 'required',
            'supplier_name' => 'required',
            'total_amount' => 'required',
            'paid_amount' => 'required',
            'category_id' => 'required',
            'product_id' => 'required',
            'unit_id' => 'required',
            'unit_price' => 'required',
            'quantity' => 'required',
        ]);

        $purchase->update([

            'purchase_no' => $request->purchase_no,
            'supplier_name' => $request->supplier_name,
            'total_amount' => $request->total_amount,
            'paid_amount' => $request->paid_amount,
            'due_amount' => (int)$request->total_amount-(int)$request->paid_amount,

        ]);

        foreach($purchase->purchaseMeta as $item){
            $item->delete();
        }

        for ($i=0; $i < count($request->category_id); $i++) {

            PurchaseMeta::create([
                'purchase_id' => $purchase->id,
                'category_id' => $request->category_id[$i],
                'product_id' => $request->product_id[$i],
                'unit_price' => $request->unit_price[$i],
                'quantity' => $request->quantity[$i],
                'unit_id' => $request->unit_id[$i],
                'total_Amount' =>(int)$request->quantity*(int)$request->unit_price,
            ]);



        }


        return redirect()->route('purchase.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $purchase = Purchase::findOrFail($id);

        foreach($purchase->purchaseMeta as $item) {

            $item->delete();

        }

        $purchase->delete();

        return back();

    }


    // order number function
    public function uniqueNumber(){

        $purchase = Purchase::latest()->first();

        if($purchase){
            $name = $purchase->purchase_no;
            $number = explode('_', $name);
            $purchase_no = 'PS_'. str_pad((int)$number[1]+1, 7, "0", STR_PAD_LEFT);
        }else{

            $purchase_no = 'PS_0000001';


        }

        return $purchase_no;

    }

    public function getProduct($id){

        $products = Product::where('category_type', $id)->get();

        return response()->json($products);

    }





}
