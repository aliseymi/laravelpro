<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::query();

        if($search = \request('search')){
            $orders->where('id',$search)->orWhere('tracking_serial',$search);
        }

        $orders = $orders->whereStatus(\request('type'))->latest()->paginate(10);

        return view('admin.orders.all',compact('orders'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $products = $order->products()->paginate(20);

        return view('admin.orders.details',compact('products','order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        return view('admin.orders.edit',compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(['unpaid','paid','posted','received','preparation','canceled'])],
            'tracking_serial' => 'required'
        ]);

        $order->update($data);

        alert()->success('ویرایش سفارش با موفقیت انجام شد');

        return redirect(route('admin.orders.index') . "?type=$order->status");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();

        alert()->success('سفارش با موفقیت حذف شد');

        return back();
    }

    public function payments(Order $order)
    {
        $payments = $order->payments()->latest()->paginate(20);

        return view('admin.orders.payments',compact('payments','order'));
    }
}
