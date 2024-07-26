<!DOCTYPE html>
<html>
<head>
    @include('admin.css')
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
            background-color: black;
        }
        .order-card h1 {
            font-weight: bold;
            color: whitesmoke;
            margin-bottom: 20px;
        }
        .order-card p {
            margin: 5px 0;
        }
        .order-card span {
            font-weight: bold;
        }
        input[type='text']{
            width: 300px;
            height:40px
        }
        .table_des{
            text-align: center;
            margin: auto;
            border: 2px white;
            margin-top: 50px;
            width: fit-content;

        }
        th{
            background-color: hotpink;
            padding: 15px;
            font-size: 20px;
            font-weight: bold;
            color: white;
        }
        td{
            color: white;
            width: fit-content;
            max-width: max-content;
            padding:10px;
            border:1px solid skyblue;
        }

    </style>
</head>
<body>
@include('admin.header')
@include('admin.sidebar')

<!-- Sidebar Navigation end-->
<div class="page-content">
    <div class="page-header">
       <h1 style="color: white;font-weight: bold">Orders</h1>
        <p1>Total Orders : {{$total}}</p1>
    </div>
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
                        <form style="display: inline-block" action="{{ route('admin.order_onTheWay',$order->id)}}" method="POST">
                            @csrf
                            <button type="submit" style="display: inline-block" class="btn btn-primary">On the way</button>
                        </form>
                        <form style="display: inline-block" action="{{ route('admin.order_Delivered',$order->id)}}" method="POST">
                            @csrf
                            <button type="submit" style="display: inline-block" class="btn btn-success">Delivered</button>
                        </form>
{{--                    <form style="display: inline-block" action="{{ route('admin.order_canceled',$order->id)}}" method="POST">--}}
{{--                            @csrf--}}
{{--                            <button type="submit" style="display: inline-block" class="btn btn-danger">Cancel</button>--}}
{{--                        </form>--}}
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
                                <img style="height: 150px" src="{{ asset('productsImages/'.$item['image']) }}" alt="Product Image">
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @endforeach
    </div>
</div>
<!-- JavaScript files-->
<script src="{{asset('adminPanel/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('adminPanel/vendor/popper.js/umd/popper.min.js')}}"> </script>
<script src="{{asset('adminPanel/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('adminPanel/vendor/jquery.cookie/jquery.cookie.js')}}"> </script>
<script src="{{asset('adminPanel/vendor/chart.js/Chart.min.js')}}"></script>
<script src="{{asset('adminPanel/vendor/jquery-validation/jquery.validate.min.js')}}"></script>
<script src="{{asset('adminPanel/js/charts-home.js')}}"></script>
<script src="{{asset('adminPanel/js/front.js')}}"></script>
</body>
</html>
