<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()->latest('created_at')->paginate(12);
        return view('profile.orders-list',compact('orders'));
    }

    public function showDetails(Order $order)
    {
        $this->authorize('view',$order);

        return view('profile.order-details',compact('order'));
    }
}
