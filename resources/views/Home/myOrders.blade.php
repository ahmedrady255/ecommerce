@extends('layouts.master_header')
@section('pageIcon')
    <link rel="shortcut icon" href={{asset('images/favicon.png')}} type="image/x-icon">
@endsection
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
        background-color: #7abaff;
        padding: 15px;
        font-size: 20px;
        font-weight: bold;
        color: white;
    }
    td{
        color: black;
        width: fit-content;
        max-width: max-content;
        padding:10px;
        border:1px solid skyblue;
    }

</style>
@section('title','myOrders')
<!-- end header section -->
@section('content')

    <div class="div_des">
        <table class="table_des">
            <tr>

                <th>Product Name</th>
                <th>Price</th>
                <th>Image</th>
                <th>Status</th>


            </tr>

            @foreach($order as $order)
                <tr>


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
                </tr>
            @endforeach
        </table>
    </div>
    <!-- footer section -->
    @include('layouts.master_footer')
    <!-- end info section -->

@endsection
