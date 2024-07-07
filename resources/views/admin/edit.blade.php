<!DOCTYPE html>
<html>
<head>
    @include('admin.css')
    <style>
        input[type='text']{
            width: 300px;
            height:40px
        }
        .dev_design{
            display: flex;
            justify-content: center;
            align-items: center ;
            margin: 30px;
        }
        .table_des{
            text-align: center;
            margin: auto;
            border: 2px solid yellowgreen;
            margin-top: 50px;
            width: 600px;

        }
        th{
            background-color: skyblue;
            padding: 15px;
            font-size: 20px;
            font-weight: bold;
            color: white;
        }
        td{
            color: white;
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
            <h1 style="color:white">Add category</h1>
            <div class="div_design">
                <center>
                    <form action="{{route('admin.update_category',$cat->id)}}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <input type="text" name="category" value="{{$cat->category_name}}" required="required">
                        <input type="submit" class=" btn btn-primary" value="update category">
                    </form>
                </center>
            </div>
        </div>
    </div>
    <div>
<!-- JavaScript files-->
<script type="text/javascript"></script>
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
