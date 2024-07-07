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
            border: 2px white;
            margin-top: 50px;
            width: 600px;

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
            <p >Total Categories : {{$total}}</p>
            <div class="div_design">
                <center>
                <form action="{{route('admin.add_category')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="text" name="category" required="required">
                    <input type="submit" class=" btn btn-primary" value="add category">
                </form>
                </center>
            </div>

        </div>
    </div>
    <div>

            <table class="table_des">

                <tr>
                    <th >
                       Category Name
                    </th>
                    <th>
                        Option
                    </th>
                </tr>
                @foreach($categories as $cat)
                <tr>
                    <td >
                    {{$cat->category_name}}
                    </td>
                    <td>
                        <div class="btn-group">
                        <form method="POST" action="{{route('admin.destroy_category',$cat->id)}}">
                            @csrf
                            @method("DELETE")
                            <button style="display:inline;" type="submit" onclick="return confirm('are you sure you want to delete the post?')" class="btn btn-danger">Delete</button>
                        </form>
                            <br>
                        <a href="{{route("admin.edit_category",$cat->id)}}"  type="button" class=" btn btn-warning mr-2">Edit</a>
                        </div>
                    </td>
                 </tr>
                @endforeach
            </table>

    </div>
</div>
<!-- JavaScript files-->
<script type="text/javascript">
    function confirmation(ev)
    {
       ev.preventDefault() ;
       var urlToRedirect= ev.currentTarget.getAttribute('href')
        console.log(urlToRedirect)
        swal({
            title:"Are you sure about delete this ?",
            text:"this delelte well be permenant",
            icon:"warning",
            button:true,
            dangerMode:true,
        })
            .then((willCancel)=>{
                if(willCancel){
                   window.location.href=urlToRedirect
                }
            });
    }
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
