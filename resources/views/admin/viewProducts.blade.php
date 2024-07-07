<!DOCTYPE html>
<html>
<head>
    @include('admin.css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

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
        <div class="container-fluid">
            <h1 style="color:white ; display: inline-block" >Products</h1>
            <a href="{{route('admin.add_product')}}" class="btn btn-primary" style=" display: inline-block;float: right ;max-width: fit-content ; padding: 5px ; border-radius: 10px;margin-top:25px ">Add product</a>
            <p>Total Products : {{$total}}</p>
        </div>
    </div>

    <div class="div_des">

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
            @foreach($products as $prod)
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
                      <img src="{{asset('productsImages/'.$prod->image)}}" style="max-width: 100px;max-height:100px">
                    </td>
                    <td>
                        <div class="btn-group">
                            <form method="POST" action="{{route('admin.destroy_product',$prod->id)}}">
                                @csrf
                                @method("DELETE")
                                <button style="display:inline;" type="submit" onclick="return confirm('are you sure you want to delete the post?')" class="btn btn-danger">Delete</button>
                            </form>
                            <a href="{{route("admin.edit_product",$prod->id)}}"  type="button" class=" btn btn-warning mr-2">Edit</a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>

    </div>
    <div class="div_des">
            {{$products->links()}}
    </div>
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
