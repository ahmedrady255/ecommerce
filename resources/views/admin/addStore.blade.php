<!DOCTYPE html>
<html>
<head>
    @include('admin.css')
    <link href="{{url("https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css")}}" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="{{url("https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js")}}" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="{{url("https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js")}}" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{"https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"}}" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</head>
<body>
@include('admin.header')
@include('admin.sidebar')

<!-- Sidebar Navigation end-->
<div class="page-content">
    <div class="page-header">
        <div class="container-fluid">
            <h1 style="color: white">Add store</h1>
        </div>
    </div>
            <div id="success-message" class="alert alert-success" style="display:none;"></div>
            <div id="error-messages" class="alert alert-danger" style="display: none;"></div>
    <form method="POST" action="{{ route('admin.pushStore') }}" enctype="multipart/form-data">
        @csrf
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
            <p style="color: white">Store name:</p>
            <input class="form-control" name="name" type="text" aria-label="default input example" style="width: fit-content; border-radius: 10px;">
            <br>
            <p style="color: white">Store address:</p>
            <textarea class="form-control" name="address" style="max-height: fit-content; border-radius: 10px;" rows="3"></textarea>
            <br>
            <p style="color: white">Store email:</p>
            <input class="form-control" name="email" type="text" aria-label="default input example" style="width: fit-content; border-radius: 10px;">
            <br>
            <p style="color: white">Store phone:</p>
            <input class="form-control" name="phone" type="text" aria-label="default input example" style="width: fit-content; border-radius: 10px;">
            <br>
            <p style="color:white">Description:</p>
            <div class="mb-3">
                <textarea class="form-control" name="description" style="max-height: fit-content; border-radius: 10px;" rows="3"></textarea>
            </div>
            <div class="mb-3" style="display: inline-block;">
                <p style="color: white">Category:</p>
                <select name="category" class="form-control" style="width: fit-content; border-radius: 10px;" id="category-select">
                    @foreach ($category as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                    @endforeach
                    <option value="add">add once.....</option>
                </select>
                <div id="new-category-form" style="display: none; margin-top: 10px;">
                    <input type="text" id="new-category-name" class="form-control" placeholder="Enter new category name">
                    <button type="button" id="submit-new-category" class="btn btn-primary" style="margin-top: 5px;">Add Category</button>
                </div>
            </div>
            <p style="color: white">Store icon:</p>
            <input class="form-control" name="image" type="file" style="max-width: fit-content; border-radius: 10px;" id="formFile">
            <br>
        </div>
        <div style="text-align: center;">
            <button type="submit" class="btn btn-primary">Add Store</button>
        </div>
    </form>




    <!-- JavaScript files-->
    <script src="{{asset('adminPanel/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('adminPanel/vendor/popper.js/umd/popper.min.js')}}"> </script>
    <script src="{{asset('adminPanel/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('adminPanel/vendor/jquery.cookie/jquery.cookie.js')}}"> </script>
    <script src="{{asset('adminPanel/vendor/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('adminPanel/js/front.js')}}"></script>


    <script>


        document.getElementById('category-select').addEventListener('change', function () {
            var selectValue = this.value;
            var newCategoryForm = document.getElementById('new-category-form');

            if (selectValue === 'add') {
                newCategoryForm.style.display = 'block';
            } else {
                newCategoryForm.style.display = 'none';
            }
        });

        document.getElementById('submit-new-category').addEventListener('click', function () {
            var newCategoryName = document.getElementById('new-category-name').value;

            if (newCategoryName.trim() === '') {
                alert('Please enter a category name.');
                return;
            }

            // Send the new category to the server
            fetch('{{route("admin.add_category")}}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ category_name: newCategoryName })
            })
                .then(response => response.json())
                .then(data =>
                {
                    if (data.success) {
                        var newOption = document.createElement('option');
                        newOption.value = data.category.id;
                        newOption.text = data.category.category_name;
                        document.getElementById('category-select').appendChild(newOption);

                        // Select the new category
                        document.getElementById('category-select').value = data.category.id;

                        // Hide the new category form
                        var newCategoryForm = document.getElementById('new-category-form');
                        newCategoryForm.style.display = 'none';
                        document.getElementById('new-category-name').value = '';
                    } else {
                        alert('Error adding category: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred: ' + error.message);
                });
        });
    </script>
</div>
</body>
</html>
