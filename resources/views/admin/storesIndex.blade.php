<!DOCTYPE html>
<html>
<head>
    @include('admin.css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
@include("admin.table_css")
</head>
<body>
@include('admin.header')
@include('admin.sidebar')
<div class="page-content">
    <div class="page-header">
        <div class="container-fluid">
            <h1 style="color:white">Add Store</h1>
            <p >Total stores : {{$count}}</p>
            <div class="div_design">
                <center>
                      <a class="btn btn-primary" href="{{route("admin.addStore")}}">Add Store</a>
                </center>
            </div>

        </div>
    </div>
    <div>

        <table class="table_des">

            <tr>
                <th >
                    Store Name
                </th>
                <th>
                    Phone
                </th>
                <th>
                    Email
                </th>
                <th>
                    Address
                </th>
                <th>
                    Icon
                </th>
                <th>
                    Option
                </th>

            </tr>
            @foreach($stores as $store)
                <tr>
                    <td >
                        {{$store->name}}
                    </td>
                    <td>
                        {{$store->phone}}
                    </td>
                    <td>
                        {{$store->email}}
                    </td>
                    <td>
                        {{$store->address}}
                    </td>
                    <td>
                        <img src="{{asset('storesIcons/'.$store->icon)}}" style="max-width: 100px;max-height:100px">
                    </td>
                    <td>
                        <div class="btn-group">
                            <form method="POST" action="{{route('admin.destroyStore',$store->id)}}">
                                @csrf
                                @method("DELETE")
                                <button style="display:inline;" type="submit" onclick="return confirm('are you sure you want to delete the post?')" class="btn btn-danger">Delete</button>
                            </form>
                            <br>
                            <a href="{{route("admin.editStore",$store->id)}}"  type="button" class=" btn btn-warning mr-2">Edit</a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>

    </div>
</div>

