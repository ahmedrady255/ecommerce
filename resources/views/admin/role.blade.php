<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    @include('admin.css')
    @include("admin.table_css")
</head>
<body>
@include('admin.header')
@include('admin.sidebar')
<!-- Sidebar Navigation end-->
<div class="page-content">
    <div class="page-header">
        <div class="container-fluid">
            <h1 style="color:white ; display: inline-block" >Roles</h1>
        </div>
    </div>
    <div class="div_des">
        <table class="table_des">
            <tr>
                <th>
                    Name
                </th>
                <th>
                    Email
                </th>
                <th>
                    Phone Number
                </th>
                <th>
                    Role
                </th>
            </tr>
            @foreach($users as $user)
            <tr>
                <td>
                    {{$user->first_name.$user->last_name}}
                </td>
                <td>
                    {{$user->email}}
                </td>
                <td>
                    {{$user->phone}}
                </td>
                <td>
                    <div class="btn-group">
                        <button class="btn btn-primary dropdown-toggle" type="button"  data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                            @if($user->is_admin==1)
                                Admin
                            @elseif($user->is_admin==0)
                                 User
                            @endif
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <form action="{{route('admin.adminRole',$user->id)}}" method="POST">
                                    @csrf
                                <button class="dropdown-item" type="submit" style="color: white"  >Admin</button>
                                </form>
                            </li>

                            <li><form action="{{route('admin.userRole',$user->id)}}" method="POST">
                                    @csrf
                                <button class="dropdown-item"  type="submit" style="color: white ;">User</button>
                            </form>
                                </li>

                        </ul>
                    </div>
                </td>
            </tr>
            @endforeach
        </table>
    </div>

</div>
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
