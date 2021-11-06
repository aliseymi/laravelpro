<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::query();

        if($search = \request('search')){
            $products->where('title','LIKE',"%$search%")
                ->orWhere('id','LIKE',"%$search%");
        }


        $products = $products->latest()->paginate(20);
        return view('admin.products.all',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'inventory' => 'required',
            'price' => 'required',
            'categories' => 'required|array'
        ]);

        $product = auth()->user()->products()->create($data);
        $product->categories()->sync($data['categories']);

        alert()->success('محصول با موفقیت اضافه شد','عملیات موفق');

        return redirect(route('admin.products.index'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit',compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'inventory' => 'required',
            'price' => 'required',
            'categories' => 'required|array'
        ]);

        $product->update($data);
        $product->categories()->sync($data['categories']);

        alert()->success('محصول مورد نظر شما با موفقیت ویرایش شد','عملیات موفق');

        return redirect(route('admin.products.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        alert()->success('محصول مورد نظر شما از لیست محصول ها حذف شد','عملیات موفق');
        return back();
    }
}
