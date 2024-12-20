<!DOCTYPE html>
<html>
<head>
    @include('admin.css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

    @include("admin.table_css")
</head>
<body>
@include('admin.header')
@include('admin.sidebar')


<!-- Sidebar Navigation end-->
<div class="page-content">
    <div class="page-header">
        <div class="container-fluid">
           <a href="{{route('admin.view_products')}}"> <h1 style="color:white">Products</h1></a>
        </div>
    </div>
    <div class="div_des">
      @if(count($results)>0)

        <table class="table_des">

            <tr>
                <th >
                    Product Name
                </th>
                <th>
                    Description
                </th>
                <th>
                    Category
                </th>
                <th>
                    Quantity
                </th>
                <th>
                    Price
                </th>
                <th>
                    Image
                </th>
                <th>
                    options
                </th>
            </tr>
            @foreach($results as $prod)
                <tr>
                    <td >
                        {{$prod->name}}
                    </td>
                    <td>
                        {!! Str::words($prod->description,5) !!} <!--to limit viewed words from description-->
                    </td>
                    <td>
                        {{$prod->category}}
                    </td>
                    <td>
                        {{$prod->quantity}}
                    </td>
                    <td>
                        {{$prod->price}}
                    </td>
                    <td>
                        <img src="{{asset('productsImages/'.$prod->image)}}" style="max-width: 100px;max-height:100px" alt="prod_image">
                    </td>
                    <td>
                        <div class="btn-group">
                            <form method="POST" action="{{route('admin.destroy_product',$prod->id)}}">
                                @csrf
                                @method("DELETE")
                                <button style="display:inline;" type="submit" onclick="return confirm('are you sure you want to delete the post?')" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>

    </div>
    @else
        <p style="color: white">no results found<p>
    @endif
</div>
<!-- JavaScript files-->
<script type="text/javascript">

</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
