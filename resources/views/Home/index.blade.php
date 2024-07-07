@extends('layouts.master_header')
@section('pageIcon')
    <link rel="shortcut icon" href={{asset('images/favicon.png')}} type="image/x-icon">
@endsection
@section('title','Home')
    <!-- end header section -->
@section('content')
    <!-- slider section -->
    <div class="hero_area">
@include('home.slider')
    <!-- end slider section -->
    </div>
    <!-- end hero area -->

    <!-- shop section -->

   @include('home.shop')

    <!-- end shop section -->

    <!-- contact section -->

    @include('home.contact-us')

    <!-- end contact section -->

    <!-- info section -->

    @include('layouts.master_footer')
        <!-- footer section -->

    <!-- end info section -->

@endsection
