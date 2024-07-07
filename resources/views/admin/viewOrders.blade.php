<!DOCTYPE html>
<html>
<head>
    @include('admin.css')
    <style>
        .div_des{
            display: flex;
            justify-content: center;
            align-items:center ;
            margin-top:60px ;
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
    <div class="div_des">
        <table class="table_des">
            <tr>
                <th>Customer name</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Image</th>
                <th>Status</th>
                <th>Option</th>

            </tr>

            @foreach($order as $order)
                <tr>

                    <td>{{$order->name}}</td>
                    <td>{{$order->address}}</td>
                    <td>{{$order->phone}}</td>
                    <td>{{$order->product->name}}</td>
                    <td>{{$order->product->price}}</td>
                    <td>
                        <img width="150px" src="{{asset('productsImages/'.$order->product->image)}}">
                    </td>
                    <td>
                        @if($order->status=='in progress')
                            <span style="color: red" >{{$order->status}}</span>
                        @elseif($order->status=='On The Way')
                            <span style="color: yellow" >{{$order->status}}</span>
                        @else
                            <span style="color: green" >{{$order->status}}</span>
                        @endif
                    </td>
                    <td>
                        <form style="display: inline-block" action="{{ route('admin.order_onTheWay',$order->id)}}" method="POST">
                            @csrf
                            <button type="submit" style="display: inline-block" class="btn btn-primary">On the way</button>
                        </form>
                        <form style="display: inline-block" action="{{ route('admin.order_Delivered',$order->id)}}" method="POST">
                            @csrf
                            <button type="submit" style="display: inline-block" class="btn btn-success">Delivered</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
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
