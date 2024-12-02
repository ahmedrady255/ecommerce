<!DOCTYPE html>
<html>
<head>
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
            <h1 style="color:white">Add category</h1>
            <p id="total">Total Categories : {{$total}}</p>
            <div class="div_design">
                <center>
                <form action="{{route('admin.add_category')}}" method="POST" enctype="multipart/form-data" id="addCategoryForm">
                    @csrf
                    <input type="hidden" name="category_id" id="category_id" value="">
                    <input type="text" name="category_name" id="category_name" required="required">
                    <input type="submit" class="btn btn-primary" id="form-submit-button" value="Add Category">
                </form>
                    <div id="success-message" class="alert alert-success" style="display:none;"></div>
                    <div id="error-messages" class="alert alert-danger" style="display: none;"></div>
                </center>
            </div>

        </div>
    </div>
    <div>

        <table class="table_des">
            <tr>
                <th>Category Name</th>
                <th>Option</th>
            </tr>
            @foreach($categories as $cat)
                <tr id="row-{{ $cat->id }}">
                    <td class="category-name" data-id="{{ $cat->id }}">{{ $cat->category_name }}</td>
                    <td>
                        <div class="btn-group">
                            <form method="POST" action="{{ route('admin.destroy_category', $cat->id) }}" class="delete-form" data-id="{{ $cat->id }}">
                                @csrf
                                @method("DELETE")
                                <button type="submit" class="btn btn-danger btn-delete-category">Delete</button>
                            </form>
                            <button type="button" class="btn btn-warning mr-2 btn-edit-category" data-id="{{ $cat->id }}" data-name="{{ $cat->category_name }}">Edit</button>
                        </div>
                    </td>
                </tr>
                <tr id="edit-row-{{ $cat->id }}" style="display: none;">
                    <td>
                        <input type="text" class="form-control" name="category_name" value="{{ $cat->category_name }}">
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary btn-save-category" data-id="{{ $cat->id }}">Save</button>
                        <button type="button" class="btn btn-secondary btn-cancel-edit" data-id="{{ $cat->id }}">Cancel</button>
                    </td>
                </tr>
            @endforeach
        </table>


    </div>
</div>
<!-- JavaScript files-->
<script type="text/javascript">

    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('addCategoryForm').addEventListener('submit', function (e) {
            e.preventDefault(); // Prevent the default form submission

            var formData = new FormData(this); // Create FormData object from the form

            fetch('{{ route("admin.add_category") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Add new category to the table
                        var newRow = '<tr>' +
                            '<td>' + data.category.category_name + '</td>' +
                            '<td>' +
                            '<div class="btn-group">' +
                            '<form method="POST" action="{{ route('admin.destroy_category', '') }}/' + data.category.id + '" class="delete-category-form">' +
                            '@csrf' +
                            '@method("DELETE")' +
                            '<button style="display:inline;" type="submit" class="btn btn-danger btn-delete-category">Delete</button>' +
                            '</form>' +
                            '<br>' +
                            '<a href="/admin/edit_category/' + data.category.id + '" class="btn btn-warning mr-2">Edit</a>' +
                            '</div>' +
                            '</td>' +
                            '</tr>';
                        var categoryTable = document.querySelector('.table_des'); // Select the table
                        categoryTable.insertAdjacentHTML('beforeend', newRow); // Append the new row to the table

                        // Optionally update total categories count
                        var totalCategoriesElement = document.querySelector('#total'); // Select the total categories count element
                        var currentTotal = parseInt(totalCategoriesElement.textContent.replace('Total Categories : ', ''));
                        totalCategoriesElement.textContent = 'Total Categories : ' + (currentTotal + 1);

                        // Optionally show success message
                        var successMessage = document.getElementById('success-message');
                        successMessage.textContent = 'Category added successfully!';
                        successMessage.style.display = 'block';

                        // Hide error messages if any
                        document.getElementById('error-messages').style.display = 'none';

                        // Reset form and hide it
                        document.getElementById('addCategoryForm').reset();
                    } else {
                        // Handle errors
                        var errorMessages = '<ul>';
                        if (typeof data.message === 'string') {
                            errorMessages += '<li>' + data.message + '</li>';
                        } else {
                            Object.keys(data.message).forEach(function (key) {
                                errorMessages += '<li>' + data.message[key].join(', ') + '</li>';
                            });
                        }
                        errorMessages += '</ul>';
                        var errorMessageDiv = document.getElementById('error-messages');
                        errorMessageDiv.innerHTML = errorMessages;
                        errorMessageDiv.style.display = 'block';

                        // Hide success message if any
                        document.getElementById('success-message').style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred: ' + error.message);
                });
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.btn-delete-category').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault(); // Prevent the default form submission

                var form = this.closest('form'); // Get the closest form element

                // Use SweetAlert2 for confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You won\'t be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(form.action, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token
                            }
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Remove the row from the table
                                    form.closest('tr').remove();

                                    // Optionally update total categories count
                                    var totalCategoriesElement = document.querySelector('#total'); // Select the total categories count element
                                    var currentTotal = parseInt(totalCategoriesElement.textContent.replace('Total Categories : ', ''));
                                    totalCategoriesElement.textContent = 'Total Categories : ' + (currentTotal - 1);

                                    // Show success message
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: 'Category has been deleted.',
                                        timer: 2000,
                                        showConfirmButton: false
                                    });

                                    // Hide error messages if any
                                    document.getElementById('error-messages').style.display = 'none';
                                } else {
                                    // Handle errors
                                    var errorMessages = '<ul>';
                                    if (typeof data.message === 'string') {
                                        errorMessages += '<li>' + data.message + '</li>';
                                    } else {
                                        Object.keys(data.message).forEach(function (key) {
                                            errorMessages += '<li>' + data.message[key].join(', ') + '</li>';
                                        });
                                    }
                                    errorMessages += '</ul>';
                                    var errorMessageDiv = document.getElementById('error-messages');
                                    errorMessageDiv.innerHTML = errorMessages;
                                    errorMessageDiv.style.display = 'block';

                                    // Hide success message if any
                                    document.getElementById('success-message').style.display = 'none';
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'An error occurred: ' + error.message
                                });
                            });
                    }
                });
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Handle Edit button click
        document.querySelectorAll('.btn-edit-category').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');

                // Show the edit row and hide the view row
                document.getElementById(`row-${id}`).style.display = 'none';
                document.getElementById(`edit-row-${id}`).style.display = 'table-row';

                // Populate the text box with the current category name
                document.querySelector(`#edit-row-${id} input[name="category_name"]`).value = name;
            });
        });

        // Handle Save button click
        document.querySelectorAll('.btn-save-category').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const newName = document.querySelector(`#edit-row-${id} input[name="category_name"]`).value;

                // Send AJAX request to update the category
                fetch(`/admin/category/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ category_name: newName })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {

                            document.querySelector(`#row-${id} .category-name`).textContent = newName;

                            document.getElementById(`row-${id}`).style.display = 'table-row';
                            document.getElementById(`edit-row-${id}`).style.display = 'none';
                        } else {
                            alert('Error updating category: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred: ' + error.message);
                    });
            });
        });

        // Handle Cancel button click
        document.querySelectorAll('.btn-cancel-edit').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');

                // Hide the edit row and show the view row
                document.getElementById(`row-${id}`).style.display = 'table-row';
                document.getElementById(`edit-row-${id}`).style.display = 'none';
            });
        });
    });

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
