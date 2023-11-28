<?php

namespace App\Http\Controllers;

use App\Models\Brands;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Units;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $totalProducts = Product::count('name');
        $totatCategories = Category::count('name');
        $totalBrands = Brands::count('name');

        $products = Product::all();
        $page_title = 'Products';
        return view('product.index', compact('products', 'page_title', 'totalProducts', 'totatCategories', 'totalBrands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = Brands::all();
        $categories = Category::all();
        $suppliers = Supplier::all();
        $units = Units::all();
        return view('product.create', compact('brands', 'categories', 'suppliers', 'units'));
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
            'category_type' => 'required | string',
            'supplier_name' => 'required | string',
            'brand_name' => 'required | string',
            'price' => 'required | integer',
            'unit' => 'required | string'

        ]);

        Product::create([

            'name' => $request->name,
            'category_type' => $request->category_type,
            'supplier_name' => $request->supplier_name,
            'brand_name' => $request->brand_name,
            'price' => $request->price,
            'unit' => $request->unit
        ]);

        return redirect()->route('product.index');
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
        $product = Product::findOrFail($id);
        $brands = Brands::all();
        $categories = Category::all();
        $suppliers = Supplier::all();
        $units = Units::all();

        return view('product.edit', compact('product', 'brands', 'categories', 'suppliers', 'units'));
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
        $product = Product::findOrFail($id);

        $request -> validate([
            'name' => 'required | string',
            'category_type' => 'required | string',
            'supplier_name' => 'required | string',
            'brand_name' => 'required | string',
            'price' => 'required | integer',
            'unit' => 'required | string'
        ]);

        $product->update([


            'name' => $request->name,
            'category_type' => $request->category_type,
            'supplier_name' => $request->supplier_name,
            'brand_name' => $request->brand_name,
            'price' => $request->price,
            'unit' => $request->unit
        ]);

        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        $product->delete();

        return redirect()->route('product.index');
    }
}
