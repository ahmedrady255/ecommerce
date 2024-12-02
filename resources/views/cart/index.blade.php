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
        .empty {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 30px;
            margin: 20px auto;
            width: 600px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #f9f9f9;
            text-align: center;
        }
        .empty h1 {
            margin-bottom: 20px;
            font-size: 50px;
            color: #333;
        }
        .empty .btn {
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            text-decoration: none;
        }
    </style>
@endsection
@section('title','My Cart')
<!-- end header section -->
@section('content')
    @if($cart->isEmpty())
        <div class="empty">
            <h1>Cart is empty</h1>
            <a class="btn btn-primary" href="{{ route('shop') }}">Add some products</a>
        </div>
    @else
        <div class="div">
            <table>
                <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Image</th>
                    <th>Remove</th>
                </tr>
                </thead>
                <tbody>
                @foreach($cart as $item)
                    <tr>
                        <td>{{ $item->Product->name }}</td>
                        <td>{{ $item->Product->price }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>
                            <img style="height: 150px" src="{{ asset('productsImages/'.$item->Product->image) }}" alt="Product Image">
                        </td>
                        <td>
                           <form action="{{route('myCart_delete',$item->id)}}" method="Post">
                               @csrf
                               @method('DELETE')
{{--                               <div style="display: inline-block" class="input-group w-auto justify-content-start align-items-center">--}}
{{--                                   <input type="button" value="-" class="button-minus border rounded-circle  icon-shape icon-sm mx-1 " data-field="quantity">--}}
{{--                                   <input type="number" step="1" max="10" value="{{$item->quantity}}" name="quantity" class="quantity-field border-0 text-center w-25">--}}
{{--                                   <input type="button" value="+" class="button-plus border rounded-circle icon-shape icon-sm " data-field="quantity">--}}
                                   <button style="display: inline-block " type="submit" class="btn btn-danger">Remove</button>
{{--                               </div>--}}
`
                           </form>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td style="font-size: 30px; font-weight: bold;">Total</td>
                    <td colspan="4" style="text-align: right; font-size: 30px; font-weight: bold;">{{ $total }} $</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="order">
            <form method="POST" action="" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" id="name" value="{{ auth()->user()->first_name.' '.auth()->user()->last_name }}">
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" class="form-control" name="phone" id="phone" value="{{ auth()->user()->phone }}">
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control" name="address" id="address" rows="3">{{ auth()->user()->address }}</textarea>
                </div>
                <br>
                <button type="submit" class="btn btn-primary" id="cashButton">Pay with Cash</button>
                <button type="submit" class="btn btn-success" id="paypalButton">Pay with PayPal</button>
            </form>
        </div>
    @endif
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('paymentForm');
            const cashButton = document.getElementById('cashButton');
            const paypalButton = document.getElementById('paypalButton');

            cashButton.addEventListener('click', function (event) {
                form.action = '{{route('placeOrder')}}';
            });

            paypalButton.addEventListener('click', function (event) {
                form.action = '{{route('payWithPaypal')}}';
            });

            function incrementValue(e) {
                e.preventDefault();
                var fieldName = $(e.target).data('field');
                var parent = $(e.target).closest('div');
                var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);

                if (!isNaN(currentVal)) {
                parent.find('input[name=' + fieldName + ']').val(currentVal + 1);
            } else {
                parent.find('input[name=' + fieldName + ']').val(0);
            }
            }

            function decrementValue(e) {
                e.preventDefault();
                var fieldName = $(e.target).data('field');
                var parent = $(e.target).closest('div');
                var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);

                if (!isNaN(currentVal) && currentVal > 0) {
                parent.find('input[name=' + fieldName + ']').val(currentVal - 1);
            } else {
                parent.find('input[name=' + fieldName + ']').val(0);
            }
            }

            $('.input-group').on('click', '.button-plus', function(e) {
                incrementValue(e);
            });

            $('.input-group').on('click', '.button-minus', function(e) {
                decrementValue(e);
            });

        });
    </script>

    <!-- footer section -->
    @include('layouts.master_footer')
    <!-- end info section -->
@endsection

