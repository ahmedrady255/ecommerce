@extends('layouts.master_header')
@section('pageIcon')
    <link rel="shortcut icon" href={{asset('images/favicon.png')}} type="image/x-icon">
@endsection
@section('content')
<style>
    .container {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 60px;
        gap: 20px; /* Adds spacing between orders */
    }
    .order-card {
        width: 800px;
        border: 1px solid black;
        border-radius: 20px;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        background-color: #fff;
    }
    .order-card h1 {
        font-weight: bold;
        color: black;
        margin-bottom: 20px;
    }
    .order-card p {
        margin: 5px 0;
    }
    .order-card span {
        font-weight: bold;
    }
    .table_des {
        text-align: center;
        margin: auto;
        margin-top: 20px;
        width: fit-content;
        border-collapse: collapse;
    }
    .table_des th {
        background-color: #7abaff;
        padding: 15px;
        font-size: 20px;
        font-weight: bold;
        color: white;
    }
    .table_des td {
        color: black;
        padding: 10px;
        border: 1px solid skyblue;
    }
    .table_des img {
        width: 150px;
    }
</style>

<div class="container">
    @foreach($orders as $order)
        <div class="order-card">
            <div class="order_info">
                <h1>Order Details</h1>
                <p>Order ID: <span>#{{ $order->id }}</span></p>
                <p>Customer Name: <span>{{ $order->name }}</span></p>
                <p>Customer Phone: <span>{{ $order->phone }}</span></p>
                <p>Customer Address: <span>{{ $order->address }}</span></p>
                <p>Sub total: <span>{{ $order->sub_total }}$</span></p>
                <p>Order Status:
                    @if($order->status == 'in progress')
                        <span style="color: red;">{{ $order->status }}</span>
                    @elseif($order->status == 'On The Way')
                        <span style="color: yellow;">{{ $order->status }}</span>
                    @else
                        <span style="color: green;">{{ $order->status }}</span>
                    @endif
                </p>
            </div>

            <table class="table_des">
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Image</th>
                </tr>
                @php
                    $orderItems = json_decode($order->order_items, true);
                @endphp
                @foreach($orderItems as $item)
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['price'] }}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>
                            <img src="{{ asset('productsImages/'.$item['image']) }}" alt="Product Image">
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    @endforeach
</div>
<!-- footer section -->
@include('layouts.master_footer')
<!-- end footer section -->
@endsection

