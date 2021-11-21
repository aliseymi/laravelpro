<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use function PHPUnit\Framework\isNull;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->seo()->setTitle('بخش محصولات');

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
        $this->seo()->setTitle('ایجاد محصول');

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
            'image' => 'required',
//            'image' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'description' => 'required',
            'inventory' => 'required',
            'price' => 'required',
            'categories' => 'required|array',
            'attributes' => 'array'
        ]);

//        $file = $request->file('image');
//        $destinationPath = '/images/' . now()->year . '/' . now()->month . '/' . now()->day . '/';
//        $file->move(public_path($destinationPath),$file->getClientOriginalName());
//
//        $data['image'] = $destinationPath . $file->getClientOriginalName();

        $product = auth()->user()->products()->create($data);
        $product->categories()->sync($data['categories']);

        if(isset($data['attributes']))
            $this->attachAttributesForProduct($data, $product);

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
        $this->seo()->setTitle('ویرایش محصول');

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
            'image' => 'required',
            'description' => 'required',
            'inventory' => 'required',
            'price' => 'required',
            'categories' => 'required|array',
            'attributes' => 'array'
        ]);


//        if($request->file('image')){
//            $request->validate([
//                'image' => 'required|image|mimes:png,jpg,jpeg|max:2048'
//            ]);
//
//            if(File::exists(public_path($product->image)))
//                File::delete(public_path($product->image));
//
//            $file = $request->file('image');
//            $destinationPath = '/images/' . now()->year . '/' . now()->month . '/' . now()->day . '/';
//            $file->move(public_path($destinationPath),$file->getClientOriginalName());
//
//            $data['image'] = $destinationPath . $file->getClientOriginalName();
//        }

        $product->update($data);
        $product->categories()->sync($data['categories']);

        $product->attributes()->detach();

        if(isset($data['attributes']))
            $this->attachAttributesForProduct($data, $product);

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

    /**
     * @param array $data
     * @param Product $product
     */
    protected function attachAttributesForProduct(array $data, Product $product): void
    {
        $attributes = collect($data['attributes']);
        $attributes->each(function ($item) use ($product) {
            if (is_null($item['name']) || is_null($item['value'])) return;

            $attr = Attribute::firstOrCreate([
                'name' => $item['name']
            ]);

            $attr_value = $attr->values()->firstOrCreate([
                'value' => $item['value']
            ]);

            $product->attributes()->attach($attr->id, ['value_id' => $attr_value->id]);
        });
    }
}
