<?php

namespace App\Http\Controllers;

use Modules\Cart\Helpers\Cart;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PayPing\PayPingException;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use Shetabit\Multipay\Invoice;
use \Shetabit\Payment\Facade\Payment as ShetabitPayment;

class PaymentController extends Controller
{
    public function payment()
    {
        $cart = Cart::instance('laralearn');
        $cartItems = $cart->all();

        if ($cartItems->count()) {
            $price = $cartItems->sum(function ($cart) {
                return $cart['discount_percent'] == 0
                    ? $cart['product']->price * $cart['quantity']
                    : ($cart['product']->price - ($cart['product']->price * $cart['discount_percent'])) * $cart['quantity'];
            });

            $orderItems = $cartItems->mapWithKeys(function ($item) {
                return [$item['product']->id => ['quantity' => $item['quantity'] , 'total_price' => $item['product']->price * $item['quantity']]];
            });

            $order = auth()->user()->orders()->create([
                'price' => $price,
                'status' => 'unpaid'
            ]);

            $order->products()->attach($orderItems);

            // Create new invoice.
            $invoice = (new Invoice)->amount(1000);

            return ShetabitPayment::callbackUrl(route('payment.callback'))->purchase($invoice, function($driver, $transactionId) use($order,$cart,$invoice) {
                // Store transactionId in database as we need it to verify payment in the future.
                $res_number = $invoice->getUuid();

                $order->payments()->create([
                    'resnumber' => $res_number,
                ]);

                $cart->flush();
            })->pay()->render();
//            $res_number = Str::random();
//
//            $token = config('services.payping.token');
//            $args = [
//                "amount" => 1000,
//                "payerName" => auth()->user()->name,
//                "returnUrl" => route('payment.callback'),
//                "clientRefId" => $res_number
//            ];
//
//            $payment = new \PayPing\Payment($token);
//
//            try {
//                $payment->pay($args);
//            } catch (\Exception $e) {
//                throw $e;
//            }
////echo $payment->getPayUrl();
//
//
//
//            return redirect($payment->getPayUrl());

        }

        return back();
    }

    public function callback(Request $request)
    {

        $payment = Payment::where('resnumber',$request->clientrefid)->firstOrFail();

        try {
            $receipt = ShetabitPayment::amount(1000)->transactionId($request->clientrefid)->verify();

            $payment->update([
                'status' => 1
            ]);

            $payment->order()->update([
                'status' => 'paid'
            ]);

            alert()->success('پرداخت با موفقیت انجام شد');
            return redirect('/products');

        } catch (InvalidPaymentException $exception) {
            /**
            when payment is not verified, it will throw an exception.
            We can catch the exception to handle invalid payments.
            getMessage method, returns a suitable message that can be used in user interface.
             **/

            alert()->error($exception->getMessage());
            return redirect('/products');
        }


//        $payment = Payment::where('resnumber',$request->clientrefid)->firstOrFail();
//
//        $token = config('services.payping.token');
//
//        $payping = new \PayPing\Payment($token);
//
//        try {
//            if($payping->verify($request->refid, 1000)){
//                $payment->update([
//                    'status' => 1
//                ]);
//
//                $payment->order()->update([
//                    'status' => 'paid'
//                ]);
//
//                alert()->success('پرداخت با موفقیت انجام شد');
//                return redirect('/products');
//
//            }else{
//                alert()->error('پرداخت شما موفق نبود');
//                return redirect('/products');
//            }
//        }
//        catch (PayPingException $e) {
////            foreach (json_decode($e->getMessage(), true) as $msg) {
////                echo $msg;
////            }
//            $errors = collect(json_decode($e->getMessage(),true));
//
//            alert()->error($errors->first());
//            return redirect('/products');
//        }
    }
}
