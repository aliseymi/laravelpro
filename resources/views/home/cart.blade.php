@extends('layouts.app')

@section('script')
    <script>
        function changeQuantity(event,id,cartName = 'default') {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            });

            $.ajax({
                url: '/cart/quantity/change',
                type: 'POST',
                data: JSON.stringify({
                    id: id,
                    quantity: event.target.value,
                    cart: cartName,
                    _method: 'patch'
                }),
                success: function (res){
                    location.reload();
                }
            });
        }
    </script>
@endsection


@section('content')
    <div class="container px-3 my-5 clearfix">
        <div class="card">
            <div class="card-header">
                <h2>سبد خرید</h2>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered m-0">
                        <thead>
                            <tr>
                                <th class="text-center py-3 px-4" style="width: 600px">نام محصول</th>
                                <th class="text-right py-3 px-4" style="width: 150px">قیمت واحد</th>
                                <th class="text-center py-3 px-4" style="width: 130px">تعداد</th>
                                <th class="text-right py-3 px-4" style="width: 200px">قیمت کل</th>
                                <th class="text-center align-middle py-3 px-0" style="width: 35px"><a href="#" class="shop-tooltip float-none"></a></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\Cart::instance('laralearn')->all() as $cart)

                                @if(isset($cart['product']))
                                    @php
                                        $product = $cart['product'];
                                    @endphp

                                    <tr>
                                        <td class="p-4">
                                            <div class="media">
                                                <div class="media-body">
                                                    <a href="#" class="d-block text-dark">{{ $product->title }}</a>

                                                    @if($product->attributes)
                                                        <small>
                                                           @foreach($product->attributes->take(3) as $attr)
                                                                <span class="text-muted">{{ $attr->name }}:</span> {{ $attr->pivot->value->value }}
                                                           @endforeach
                                                        </small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-right font-weight-semibold align-middle p-4">{{ $product->price }} تومان</td>
                                        <td class="align-middle p-4">
                                            <select name="" onchange="changeQuantity(event,'{{ $cart['id'] }}','laralearn')" class="form-control text-center">
                                                @foreach(range(1,$product->inventory) as $item)
                                                    <option value="{{ $item }}" {{ $item == $cart['quantity'] ? 'selected' : '' }}>{{ $item }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="text-right font-weight-semibold align-middle p-4">{{ $product->price * $cart['quantity'] }} تومان</td>
                                        <form action="{{ route('cart.destroy',$cart['id']) }}" method="POST" id="delete-cart-{{ $product->id }}">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <td class="text-center align-middle px-0"><a href="#" onclick="event.preventDefault();document.getElementById('delete-cart-{{ $product->id }}').submit()" class="shop-tooltip close float-none text-danger">&times;</a></td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>

                    @php
                        $totalPrice = Cart::instance('laralearn')->all()->sum(function ($cart){
                            return $cart['product']->price * $cart['quantity'];
                        });
                    @endphp

                    <div class="media mt-3 float-left">
                        <div class="media-body">
                            <span class="text-muted d-block">قیمت کل</span>

                            <span class="font-weight-bold">{{ $totalPrice }} تومان</span>

                            <form action="{{ route('cart.payment') }}" method="POST" id="cart-payment">
                                @csrf
                            </form>
                            <button onclick="document.getElementById('cart-payment').submit()" class="btn btn-primary d-block mt-4 mr-3">پرداخت</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
