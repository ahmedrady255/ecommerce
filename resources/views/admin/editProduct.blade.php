<!DOCTYPE html>
<html>
<head>
    @include('admin.css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</head>
<body>
@include('admin.header')
@include('admin.sidebar')

<!-- Sidebar Navigation end-->
<div class="page-content">
    <div class="page-header">
        <div class="container-fluid">
            <h1 style="color: white">Edit Product</h1>
            <div id="success-message" class="alert alert-success" style="display:none;"></div>
            <div id="error-messages" class="alert alert-danger" style="display: none;"></div>
            <form method="POST" action="{{route('admin.update_product',$product->id)}}" enctype="multipart/form-data" id="addproduct">
                @csrf
                @method('PUT')
                <div class="container mt-4">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <p style="color: white">Product name:</p>
                    <input class="form-control" name="name" type="text" value="{{$product->name}}"  aria-label="default input example" style="width: fit-content;border-radius: 10px">
                    <br>
                    <p style="color:white">Description:</p>
                    <div class="mb-3">
                        <textarea class="form-control" name="description" style="max-height: fit-content;border-radius: 10px" id="exampleFormControlTextarea1" rows="3">{{$product->description}} </textarea>
                    </div>
                    <div class="mb-3" style="display: inline-block">
                        <p style="color: white">Category :</p>
                        <select name="category" class="form-control" style="width: fit-content ;border-radius: 10px">
                            @foreach ($category as $cat )
                                <option @selected($product->id==$cat->category_name) value="{{$cat->category_name}}">{{$cat->category_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <span><span></span></span>
                    <div style="display: inline-block;margin-left: 10px">
                        <p style="color: white">Quantity:</p>
                        <input class="form-control" name="quantity" type="number" value="{{$product->quantity}}" aria-label="default input example" style="max-width: fit-content;border-radius: 10px">
                    </div>
                    <div style="display: inline-block;margin-left: 10px;border-radius: 10px">
                        <p style="color: white">Price:</p>
                        <input class="form-control" name="price" value="{{$product->price}}" type="number" min="0.00" max="10000.00" step="0.05" style="border-radius: 10px"/>
                    </div>
                    <div class="mb-3">
                        <label>current image :</label>
                        <img width="150px" src="{{asset('productsImages/'.$product->image)}}">
                        <br>
                        <p style="color: white">Product image : </p>
                        <input class="form-control" name="image" type="file"  style="max-width: fit-content;border-radius: 10px" id="formFile">
                    </div>
                        <br>
                        <div class="form-group">
                            <label for="add_multiple_files" style="color: white">
                                <input type="checkbox" name="slider" value="{{$product->with_slider}}" id="add_multiple_files"> Add Multiple Images
                            </label>
                        </div>
                        <div id="multiple_files_input" class="mb-3" style="display: none;">
                            <p style="color: white">Additional Images : </p>
                            <input type="file" class="form-control"  name="images[]" multiple style="max-width: fit-content;border-radius: 10px">
                        </div>
                    <br>
                    <div style="align-items: center;align-content: center">
                        <input type="submit" value="Update Product" class="btn btn-primary" style="border-radius: 10px" >
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#add_multiple_files').change(function(){
                if(this.checked) {
                    $('#multiple_files_input').show();
                } else {
                    $('#multiple_files_input').hide();
                }
            });
        });
    </script>
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
