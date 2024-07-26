@extends('layouts.master_header')
@section('pageIcon')
    <link rel="shortcut icon" href={{asset('images/favicon.png')}} type="image/x-icon">
        <!-- ... other head elements ... -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
    /*****************globals*************/
    body {
    font-family: 'open sans';
    overflow-x: hidden; }

    img {
    max-width: 100%; }

    .carousel-inner{
        height: 600px;
        object-fit: cover;
    }
    .preview {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -webkit-flex-direction: column;
    -ms-flex-direction: column;
    flex-direction: column; }
    @media screen and (max-width: 996px) {
    .preview {
    margin-bottom: 20px; } }


    .card {
    margin-top: 50px;
    background: #eee;
    padding: 3em;
    line-height: 1.5em; }

    @media screen and (min-width: 997px) {
    .wrapper {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex; } }

    .details {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -webkit-flex-direction: column;
    -ms-flex-direction: column;
    flex-direction: column; }

    .product-title, .price, .sizes, .colors {
    text-transform: UPPERCASE;
    font-weight: bold; }

    .checked, .price span {
    color: #ff9f1a; }

    .product-title, .rating, .product-description, .price, .vote, .sizes {
    margin-bottom: 15px; }

    .product-title {
    margin-top: 0; }


    .add-to-cart, .like {
    background: #ff9f1a;
    padding: 1.2em 1.5em;
    border: none;
    text-transform: UPPERCASE;
    font-weight: bold;
    color: #fff;
    -webkit-transition: background .3s ease;
    transition: background .3s ease; }
    .add-to-cart:hover, .like:hover {
    background: #b36800;
    color: #fff; }

    .not-available {
    text-align: center;
    line-height: 2em; }
    .not-available:before {
    font-family: fontawesome;
    content: "\f00d";
    color: #fff; }

    .orange {
    background: #ff9f1a; }

    .green {
    background: #85ad00; }

    .blue {
    background: #0076ad; }

    .tooltip-inner {
    padding: 1.3em; }

    @-webkit-keyframes opacity {
    0% {
    opacity: 0;
    -webkit-transform: scale(3);
    transform: scale(3); }
    100% {
    opacity: 1;
    -webkit-transform: scale(1);
    transform: scale(1); } }

    @keyframes opacity {
    0% {
    opacity: 0;
    -webkit-transform: scale(3);
    transform: scale(3); }
    100% {
    opacity: 1;
    -webkit-transform: scale(1);
    transform: scale(1); } }
   .icon-shape {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        vertical-align: middle;
    }

    .icon-sm {
        width: 2rem;
        height: 2rem;

    }

    /*# sourceMappingURL=style.css.map */
</style>
@endsection
@section('title','productDetails')
<!-- end header section -->
@section('content')
    <div class="container">
        <div class="card">
            <div class="container-fluid">
                <div class="wrapper row">
                    <div class="preview col-md-6">
                        <div class="slider-box">
                            @if($product->with_slider== 1)
                                <div id="product-slider-{{ $product->id }}" class="carousel slide" data-ride="carousel">
                                    <div class="carousel-inner">
                                        @foreach($product->images as $key => $image)
                                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                                <img src="{{ asset('productsImages/' . $image->image_path) }}" class="d-block w-100" alt="Product Image">
                                            </div>
                                        @endforeach
                                    </div>
                                    <a class="carousel-control-prev" href="#product-slider-{{ $product->id }}" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#product-slider-{{ $product->id }}" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            @else
                                <img style="border-radius:20px" src="{{ asset('productsImages/' . $product->image) }}" class="d-block w-100" alt="Product Image">

                            @endif
                        </div>
                    </div>
                    <div class="details col-md-6">
                        <h3 class="product-title">{{ $product->name }}</h3>
                        <p class="product-description">{{ $product->description }}</p>
                        <h4 class="price">current price: <span>{{ $product->price }}$</span></h4>

                        @if($product->quantity>2)

                            <p style="color: green">in stock</p>
                            <div class="action">
                                <form action="{{route('add_cart',$product->id)}}" method="POST">
                                    @csrf
                                    <h5>Quantity</h5>
                                    <div class="input-group w-auto justify-content-start align-items-center">
                                        <input type="button" value="-" class="button-minus border rounded-circle  icon-shape icon-sm mx-1 " data-field="quantity">
                                        <input type="number" step="1" max="10" value="1" name="quantity" class="quantity-field border-0 text-center w-25">
                                        <input type="button" value="+" class="button-plus border rounded-circle icon-shape icon-sm " data-field="quantity">
                                    </div>
                                    <button class="add-to-cart btn btn-default" href="{{route('add_cart',$product->id)}}" >add to cart</button>
                                </form>
                                <button class="like btn btn-default" type="button"><span class="fa fa-heart"></span></button>
                            </div>

                        @elseif($product->quantity<=2 && $product->quantity!=0)
                            <p style="color: red">last {{$product->quantity}} in stock </p>

                            <div class="action">
                                <form action="{{route('add_cart',$product->id)}}" method="POST">
                                    @csrf
                                    <h5>Quantity</h5>
                                    <div class="input-group w-auto justify-content-start align-items-center">
                                        <input type="button" value="-" class="button-minus border rounded-circle  icon-shape icon-sm mx-1 " data-field="quantity">
                                        <input type="number" step="1" max="{{$product->quantity}}" value="1" name="quantity" class="quantity-field border-0 text-center w-25">
                                        <input type="button" value="+" class="button-plus border rounded-circle icon-shape icon-sm " data-field="quantity">
                                    </div>
                                    <button class="add-to-cart btn btn-default" href="{{route('add_cart',$product->id)}}" >add to cart</button>
                                </form>
                                <button class="like btn btn-default" type="button"><span class="fa fa-heart"></span></button>
                            </div>

                        @else
                            <p>out of stock</p>
                        @endif

                    </div>
                </div>
            </div>
        </div>

        <div class="comments-container">
            <h4>Comments</h4>
            @if ($product->comments->isNotEmpty())
                @foreach ($product->comments as $comment)
                    <div class="card mb-2" >
                        <div style="border-radius: 10px" class="card-body">
                            <p>{{ $comment->comment }}</p>
                            <small class="text-muted">by {{ $comment->user->first_name }} on {{ $comment->created_at }}</small>
                            @if(Auth::user('id') === $comment->user_id)
                                <div class="btn-group" style="float: right;margin-top: -50px;">
                                    <button style="width:10px;height: 10px;" class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false"></button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">Edit comment</a></li>
                                        <li>
                                            <form method="POST" action="#" enctype="multipart/form-data">
                                                @csrf
                                                @method('delete')
                                                <button class="dropdown-item">Delete</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <p>No comments yet.</p>
            @endif

            @auth
                <form action="{{ route('comments.store', $product->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="body">Add a Comment:</label>
                        <textarea style="border-radius: 10px" name="comment" id="body" rows="3" class="form-control" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Submit</button>
                </form>
            @endauth

            @guest
                <p>Please <a href="{{ route('login') }}">login</a> to comment.</p>
            @endguest
        </div>
    </div>
<script>
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
</script>

        <!-- footer section -->
    @include('layouts.master_footer')
    <!-- end info section -->

@endsection
