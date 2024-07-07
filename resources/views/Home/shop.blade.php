<link rel="stylesheet" type="text/css" href={{asset('css/bootstrap.css')}} />

<!-- Custom styles for this template -->
<link href={{asset('css/style.css')}} rel="stylesheet" />
<!-- responsive style -->
<link href={{asset('css/responsive.css')}} rel="stylesheet" />
<section class="shop_section layout_padding">
    <div class="container">
        <div class="heading_container heading_center">
            <h2>
                Latest Products
            </h2>
        </div>
        <div class="row">
            @foreach($products as $prod)
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="box">
                    <a href="">
                        <div class="img-box">
                            <img style="border-radius:10px " src="{{asset('productsImages/'.$prod->image)}}" alt="">
                        </div>
                        <div class="detail-box">
                            <h6>
                                {{$prod->name}}
                            </h6>
                            <h6>
                               Price
                                <span>
                    {{$prod->price.'$'}}
                  </span>
                            </h6>
                        </div>
                    </a>
                    <div style="padding-top: 10px; white-space: nowrap;">
                        <a style="max-width: fit-content; border-radius: 20px; display: inline-block; margin-right:1px;" class="btn btn-primary" href="{{ route('product_details', $prod->id) }}">More Details</a>
                        <a style="max-width: fit-content; border-radius: 20px; display: inline-block;" class="btn btn-warning" href="{{route('add_cart',$prod->id)}}">Add to cart</a>
                    </div>

                </div>
            </div>
            @endforeach
        </div>
        <div class="btn-box">
            <a href="">
                View All Products
            </a>
        </div>
    </div>
</section>
