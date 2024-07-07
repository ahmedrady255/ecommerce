<div class="d-flex align-items-stretch">
    <!-- Sidebar Navigation-->
    <nav id="sidebar">
        <!-- Sidebar Header-->
        <div class="sidebar-header d-flex align-items-center">
            <div class="avatar"><img src="{{asset('adminPanel/img/avatar-6.jpg')}}" alt="..." class="img-fluid rounded-circle"></div>
            <div class="title">
                <h1 class="h5">Mark Stephen</h1>
                <p>Web Designer</p>
            </div>
        </div>
        <!-- Sidebar Navidation Menus--><span class="heading">Main</span>
        <ul class="list-unstyled">
            <li class="@yield('active')"><a href="{{route('admin.dashboard')}}"> <i class="icon-home"></i>Home </a></li>
            <li class="@yield('active')"><a  href="{{route('admin.category')}}"> <i class="icon-grid"></i>Categorise </a></li>
            <li><a  href="#exampledropdownDropdown" aria-expanded="false" data-toggle="collapse"> <i class="icon-windows"></i>Products</a>
                <ul id="exampledropdownDropdown" class="collapse list-unstyled ">
                    <li><a href="{{route('admin.view_products')}}">View Products</a></li>
                    <li><a href="{{route('admin.add_product')}}">Add Product</a></li>
                    <li><a href="#">Page</a></li>
                </ul>
            </li>
            <li class="@yield('active')"><a  href="{{route('admin.orders')}}"> <i class="icon-grid"></i>Orders </a></li>
        </ul>
    </nav>

