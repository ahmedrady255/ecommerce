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
            <h1 style="color: white">Add Product</h1>
        </div>
    </div>
            <div id="success-message" class="alert alert-success" style="display:none;"></div>
            <div id="error-messages" class="alert alert-danger" style="display: none;"></div>
            <form method="POST" action="{{route('admin.store_product')}}" enctype="multipart/form-data" id="addproduct">
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
                    <p style="color: white">Product name:</p>
                    <input class="form-control" name="name" type="text"  aria-label="default input example" style="width: fit-content;border-radius: 10px" >
                    <br>
                    <p style="color:white">Description:</p>
                    <div class="mb-3">
                        <textarea class="form-control" name="description" style="max-height: fit-content;border-radius: 10px" id="exampleFormControlTextarea1" rows="3" ></textarea>
                    </div>
                    <div class="mb-3" style="display: inline-block">
                        <p style="color: white">Category :</p>
                        <select name="category" class="form-control" style="width: fit-content ;border-radius: 10px" id="category-select" >
                            @foreach ($category as $cat )
                                <option value="{{$cat->category_name}}">{{$cat->category_name}}</option>
                            @endforeach
                                <option value="add">add once.....</option>
                        </select>
                        <div id="new-category-form" style="display: none; margin-top: 10px;">
                            <input type="text" id="new-category-name" style="width: fit-content ;border-radius: 10px;display: inline-block" class="form-control" placeholder="Enter new category name">
                            <button type="button" id="submit-new-category" class="btn btn-primary" style="margin-top: 5px;">Add Category</button>
                        </div>
                    </div>
                        <br>

                    <span><span></span></span>
                    <div style="display: inline-block;margin-left: 10px">
                        <p style="color: white">Quantity:</p>
                        <input class="form-control" name="quantity" type="number"  aria-label="default input example" style="max-width: fit-content;border-radius: 10px">
                    </div>
                    <div style="display: inline-block;margin-left: 10px;border-radius: 10px">
                        <p style="color: white">Price:</p>
                        <input class="form-control" name="price" type="number" min="0.00"  step="0.05" style="border-radius: 10px"/>
                    </div>
                    <div class="mb-3">
                        <p style="color: white">Product image : </p>
                        <input class="form-control" name="image" type="file" style="max-width: fit-content;border-radius: 10px" id="formFile">
                    </div>
                    <br>
                    <!-- Checkbox to show/hide multiple file input -->
                    <div class="form-group">
                        <label for="add_multiple_files" style="color: white">
                            <input type="checkbox" name="slider" value="1" id="add_multiple_files"> Add Multiple Images
                        </label>
                    </div>
                    <div id="multiple_files_input" class="mb-3" style="display: none;">
                        <p style="color: white">Additional Images : </p>
                        <input type="file" class="form-control" name="images[]" multiple style="max-width: fit-content;border-radius: 10px">
                    </div>
                    <br>
                    <div style="align-items: center;align-content: center">
                        <input type="submit" value="Add Product" class="btn btn-primary" style="border-radius: 10px" >
                    </div>
                </div>
            </form>



    <script type="text/javascript">
        $(document).ready(function () {

            $('#add_multiple_files').change(function () {
                if (this.checked) {
                    $('#multiple_files_input').show();
                } else {
                    $('#multiple_files_input').hide();
                }
            });


            $('#category-select').change(function () {
                var selectValue = $(this).val();
                var newCategoryForm = $('#new-category-form');

                if (selectValue === 'add') {
                    newCategoryForm.show();
                } else {
                    newCategoryForm.hide();
                }
            });


            $('#submit-new-category').click(function () {
                var newCategoryName = $('#new-category-name').val();

                if (newCategoryName.trim() === '') {
                    alert('Please enter a category name.');
                    return;
                }


                fetch('{{ route("admin.add_category") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ category_name: newCategoryName })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Append the new category to the select box
                            var newOption = $('<option>', {
                                value: data.category.id,
                                text: data.category.category_name
                            });
                            $('#category-select').append(newOption);

                            // Select the new category
                            $('#category-select').val(data.category.id);

                            // Hide the new category form and reset the input
                            $('#new-category-form').hide();
                            $('#new-category-name').val('');
                        } else {
                            alert('Error adding category: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred: ' + error.message);
                    });
            });


            $('#addproduct').submit(function (e) {
                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.success) {
                            window.location.href = '{{ route("admin.view_products") }}';
                        } else {
                            displayErrors(response.message);
                        }
                    },
                    error: function (xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.message;
                            displayErrors(errors);
                        } else {
                            displayErrors('An unexpected error occurred. Please try again.');
                        }
                    }
                });
            });


            function displayErrors(errors) {
                var errorMessages = '<ul>';
                if (typeof errors === 'string') {
                    errorMessages += '<li>' + errors + '</li>';
                } else {
                    $.each(errors, function (key, value) {
                        if (Array.isArray(value)) {
                            $.each(value, function (index, message) {
                                errorMessages += '<li>' + message + '</li>';
                            });
                        } else {
                            errorMessages += '<li>' + value + '</li>';
                        }
                    });
                }
                errorMessages += '</ul>';
                $('#error-messages').html(errorMessages).show();
            }
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
</div>
</body>
</html>
