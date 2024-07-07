@extends('layouts.master_header')
@section('pageIcon')
    <link rel="shortcut icon" href={{asset('images/favicon.png')}} type="image/x-icon">
        <!-- ... other head elements ... -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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
                        <div class="action">
                            <a class="add-to-cart btn btn-default" href="{{route('add_cart',$product->id)}}" type="button">add to cart</a>
                            <button class="like btn btn-default" type="button"><span class="fa fa-heart"></span></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- footer section -->
    @include('layouts.master_footer')
    <!-- end info section -->

@endsection
