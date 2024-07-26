@extends('layouts.master_header')
@section('pageIcon')
    <link rel="shortcut icon" href={{asset('images/favicon.png')}} type="image/x-icon">
    <style>
        .div{
            display: flex;
            justify-content: center;
            justify-items: center;
            margin: 60px;
        }
        table{
            border-radius: 20px;
            border: solid black 2px;
            text-align: center;
            width: 800px;
        }
        th{


            text-align: center;
            color:white ;
            font-weight: bold;
            font-size: 20px;
            background-color: #1fa8b4;
        }
        td{
            border: solid black 1px ;
        }
        .order{
            justify-content: center;
            display: flex;
            align-items: center;
            justify-items: center;

        }
    </style>
@endsection
@section('title','My Cart')
<!-- end header section -->
@section('content')

    <div class="div">
       <table>
           <tr>
               <th>Product name</th>
               <th>Price</th>
               <th>Quantity</th>
               <th>Image</th>
               <th>Remove</th>
           </tr>
           @foreach($cart as $cart)
           <tr>
               <td>{{$cart->Product->name}}</td>
               <td>{{$cart->Product->price}}</td>
               <td>{{$cart->quantity}}</td>
               <td >
                   <img width="150px" style="height: fit-content" src="{{asset('productsImages/'.$cart->product->image)}}" alt="product image">
               </td>
               <td>
                   <a class="btn btn-danger" href="{{route('myCart_delete',$cart->id)}}">Delete</a>
               </td>
           </tr>

           @endforeach
           <tr>
                 <td style="font-size: 30px;font-weight: bold">Total</td>
               <td style="border-right: none;justify-content: center;font-size: 30px;font-weight: bold">{{$total.' $'}}</td>
           </tr>
       </table>
    </div>
    <div class="order">
        <form method="POST" id="paymentForm" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Name</label>
                <input type="text" class="form-control" name="name" id="exampleFormControlInput1" value="{{auth()->user()->first_name}}" >
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Phone</label>
                <input type="text" class="form-control" name="phone" id="exampleFormControlInput1" value="{{auth()->user()->phone}}" >
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Address</label>
                <textarea class="form-control" name="address" id="exampleFormControlTextarea1" rows="3">{{auth()->user()->address}}</textarea>
            </div>
            <br>
            <button type="submit" class="btn btn-primary" id="cashButton">Pay with Cash</button>
            <button type="submit" class="btn btn-success" id="paypalButton">Pay with PayPal</button>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('paymentForm');
            const cashButton = document.getElementById('cashButton');
            const paypalButton = document.getElementById('paypalButton');

            cashButton.addEventListener('click', function (event) {
                form.action = '{{route('placeOrder')}}';
            });

            {{--paypalButton.addEventListener('click', function (event) {--}}
            {{--    form.action = '{{route('payWithPaypal')}}';--}}
            {{--});--}}
        });
    </script>

    <!-- footer section -->
    @include('layouts.master_footer')
    <!-- end info section -->
@endsection

