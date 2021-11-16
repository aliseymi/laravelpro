<?php

namespace App\Http\Controllers;

use App\Helpers\Cart\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function payment()
    {
        $cart = Cart::instance('laralearn');
        $cartItems = $cart->all();

        if ($cartItems->count()) {
            $price = $cartItems->sum(function ($cart) {
                return $cart['product']->price * $cart['quantity'];
            });

            $orderItems = $cartItems->mapWithKeys(function ($item) {
                return [$item['product']->id => ['quantity' => $item['quantity']]];
            });

            $order = auth()->user()->orders()->create([
                'price' => $price,
                'status' => 'unpaid'
            ]);

            $order->products()->attach($orderItems);

            $res_number = Str::random();

            $token = config('services.payping.token');
            $args = [
                "amount" => 1000,
                "payerName" => auth()->user()->name,
                "returnUrl" => route('payment.callback'),
                "clientRefId" => $res_number
            ];

            $payment = new \PayPing\Payment($token);

            try {
                $payment->pay($args);
            } catch (\Exception $e) {
                throw $e;
            }
//echo $payment->getPayUrl();
            $order->payments()->create([
                'resnumber' => $res_number,
                'price' => $price
            ]);

            $cart->flush();

            return redirect($payment->getPayUrl());

        }

        return back();
    }
}
