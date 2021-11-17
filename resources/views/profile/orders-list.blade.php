@extends('profile.layout')

@section('main')
    <table class="table text-center">

        <tbody>
        <tr>
            <th>شماره سفارش</th>
            <th>تاریخ ثبت</th>
            <th>وضعیت</th>
            <th>کد رهگیری پستی</th>
            <th>اقدامات</th>
        </tr>
        @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ jdate($order->created_at)->format('%A %d %B %Y') }}</td>
                <td style="padding: 10px 0">
                    @switch($order->status)
                        @case('unpaid')
                            پرداخت نشده
                        @break

                        @case('paid')
                        پرداخت شده
                        @break

                        @case('posted')
                        ارسال شده
                        @break

                        @case('received')
                        دریافت شده
                        @break

                        @case('canceled')
                        لغو شده
                        @break
                    @endswitch
                </td>
                <td>{{ $order->tracking_serial ?? 'هنوز ثبت نشده' }}</td>
                <td>
                    <a href="{{ route('profile.orders.details',$order->id) }}" class="btn btn-sm btn-info">جزئیات سفارش</a>

                    @if($order->status == 'unpaid')
                        <a href="{{ route('profile.orders.payment',$order->id) }}" class="btn btn-sm btn-warning">پرداخت سفارش</a>
                    @endif
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>

    {{ $orders->render() }}
@endsection
