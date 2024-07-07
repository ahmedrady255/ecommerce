@include('admin.css')
<header class="header">
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid d-flex align-items-center justify-content-between">
            <div class="navbar-header">
                <!-- Navbar Header--><a href="{{route('admin.dashboard')}}" class="navbar-brand">
                    <div class="brand-text brand-big visible text-uppercase"><strong class="text-primary">Dark</strong><strong>Admin</strong></div>
                    <div class="brand-text brand-sm"><strong class="text-primary">D</strong><strong>A</strong></div></a>
                <!-- Sidebar Toggle Btn-->
                <button class="sidebar-toggle"><i class="fa fa-long-arrow-left"></i></button>
            </div>
            <div style="display: inline ;margin-right: 50px">
                <form action="{{ route('admin.search_product') }}" method="post" enctype="multipart/form-data" class="form-inline">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="search" class="form-control" style="display: inline-block; width: auto; margin-right: 5px;border-radius: 10px;max-width: fit-content">
                    </div>
                    <input type="submit" value="Search" class="btn btn-primary" style="display: inline-block;border-radius: 10px">
                </form>
            </div>

        </div>

                <!-- Log out               -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <input type="submit" style="padding:10px ;border-radius: 10px; max-width: fit-content" class="btn-primary" value="logout">
            </form>

            </div>
        </div>
    </nav>
</header>
