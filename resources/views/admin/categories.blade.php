@extends('layouts.admin') {{-- Assuming 'layouts.admin' is your admin layout file --}}

@section('content')
    <div class="container mt-3 overflow-scroll">
        <h2 class="text-center">Manage Categories</h2>
        <div class="mb-2 d-flex justify-content-end">
            {{-- <h2>Manage Categories</h2> --}}
            <div>
                <div class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                    <i class="fa fa-plus"></i> Add Category
                </div>
            </div>
        </div>
        <table class="table table-head-bg-primary bg-white table-bordered-bd-primary table-hover" id="categoryTable">
            <thead class="bg-grey">
                <tr>
                    <th style="max-width:20px">ID</th>
                    <th>Category Name</th>
                    <th>Description</th>
                    <th>Keywords</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->category_id }}</td>
                        <td style="width:100px">
                            <div class="row">
                                <div class="12 text-center">
                                    {{ $category->category_name }}
                                </div>
                                <div class="12">
                                    <img class="w-100"
                                        src="{{ isset($category->image_url) && $category->image_url != null ? asset('storage') . '/' . $category->image_url : '' }}"
                                        onerror="this.src='/img/image-placeholder-300-500.jpg'">
                                </div>
                            </div>
                        </td>
                        <td>{{ $category->c_description }}</td>
                        <td>{{ $category->c_keywords }}</td>
                        <td style="width:175px !important">
                            <div class="btn btn-primary mt-1" data-bs-toggle="modal" data-bs-target="#editCategoryModal"
                                onclick="setEditCategoryData('{{ $category->category_name }}', '{{ $category->category_id }}', '{{ $category->c_description }}','{{ $category->c_keywords }}')">
                                <i class="fa fa-edit"></i>
                            </div>
                            <div class="btn btn-danger mt-1" onclick="deleteCategory('{{ $category->category_id }}')">
                                <i class="fa fa-trash"></i>
                            </div>
                            <div class="btn btn-success w-100 mt-1"
                                onclick="window.location=('categories/{{ $category->category_id }}/products')">
                                <i class="fa fa-stream"></i>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Add Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Add Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Add Category Form -->
                    <form id="addCategoryForm">
                        @csrf
                        <div class="mb-3 form-floating">
                            <input type="text" class="form-control" id="category_name" name="category_name" placeholder
                                required>
                            <label for="category_name" class="form-label">Category Name:</label>
                        </div>
                        <div class="mb-3 form-floating">
                            <input type="text" class="form-control" id="c_description" name="description"
                                style="height:70px !important" placeholder required>
                            <label for="c_description" class="form-label">Description:</label>
                        </div>
                        <div class="mb-3 form-floating">
                            <input type="text" class="form-control" id="c_keywords" name="description"
                                style="height:70px !important" placeholder required>
                            <label for="c_keywords" class="form-label">Keywords:</label>
                        </div>
                        <div>
                            <button type="button" class="btn btn-primary float-end" onclick="addCategory()">Add
                                Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Edit Category Form -->
                    <form id="editCategoryForm">
                        @csrf
                        <div class="mb-3">
                            <label for="category_name" class="form-label">Category Name:</label>
                            <input type="text" class="form-control" id="category_name" name="category_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="c_description" class="form-label">Description:</label>
                            <input type="text" class="form-control" id="c_description" name="description"
                                style="height:70px !important" required>
                        </div>
                        <div class="mb-3">
                            <label for="c_keywords" class="form-label">Keywords:</label>
                            <input type="text" class="form-control" id="c_keywords" name="description"
                                style="height:70px !important" required>
                            <input type="hidden" name="category_id" id="category_id" value="">
                        </div>
                        <div>
                            <button type="button" class="btn btn-primary float-end" onclick="updateCategory()">Update
                                This
                                Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#categoryTable').DataTasble(); // Initialize DataTable
        });

        function updateCategory() {
            var category_id = $('#editCategoryForm #category_id').val();
            var category_name = $('#editCategoryForm #category_name').val();
            var c_description = $('#editCategoryForm #c_description').val();
            var c_keywords = $('#editCategoryForm #c_keywords').val();

            // Check if category name and code are not empty
            if (category_name.trim() === '' || c_description.trim() === '' || category_id.trim() === '') {
                swal('Please enter category name and code.');
                return;
            }

            // Make AJAX request to update category
            $.ajax({
                type: 'PUT',
                url: '{{ route('admin.categories.update') }}',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'category_id': category_id,
                    'category_name': category_name,
                    'c_description': c_description,
                    'c_keywords': c_keywords
                },
                success: function(response) {
                    if (response.status.trim() === 'success') {
                        swal({
                            title: 'Category Updated successfully!',
                            icon: 'success'
                        }).then(function() {
                            window.location.reload();
                        });
                    } else {
                        swal({
                            title: 'Failed to update category. Please try again.'
                        }).then(function() {
                            window.location.reload();
                        });
                    }
                },
                error: function() {
                    swal('An error occurred while Updating category. Please try again later.').then(function() {
                        window.location.reload();
                    });
                }
            });
        }

        function addCategory() {
            var category_name = $('#category_name').val();
            var c_description = $('#c_description').val();
            var c_keywords = $('#c_keywords').val();

            // Check if category name and code are not empty
            if (category_name.trim() === '' || c_description.trim() === '') {
                swal('Please enter category name and code.');
                return;
            }

            // Make AJAX request to add category
            $.ajax({
                type: 'POST',
                url: '{{ route('admin.categories.add') }}',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'category_name': category_name,
                    'c_description': c_description,
                    'c_keywords': c_keywords
                },
                success: function(response) {
                    if (response.status.trim() === 'success') {
                        swal({
                            title: 'Category added successfully!',
                            icon: 'success'
                        }).then(function() {
                            window.location.reload();
                        });
                    } else {
                        swal('Failed to add category. Please try again.').then(function() {
                            window.location.reload();
                        });
                    }
                },
                error: function() {
                    swal('An error occurred while adding category. Please try again later.').then(function() {
                        window.location.reload();
                    });
                }
            });
        }

        function deleteCategory(category_id) {
            swal({
                title: "Sure Delete Category?",
                text: "This action cannot be undone.",
                icon: "warning",
                buttons: ["Cancel", "Confirm"],
                dangerMode: true,
            }).then((isConfirmed) => {
                if (isConfirmed) {
                    $.ajax({
                        type: 'DELETE',
                        url: '{{ route('admin.categories.delete') }}',
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'category_id': category_id
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                swal({
                                    icon: "success",
                                    title: "Category Deleted Successfully!"
                                }).then(function() {
                                    window.location.reload();
                                });
                            } else if (response === 'data') {
                                swal({
                                    icon: "info",
                                    title: "There are some products associated with this category!"
                                })
                            } else {
                                swal({
                                    icon: "error",
                                    title: "Something went wrong. Please try again later!"
                                })
                            }
                        },
                        error: function() {
                            swal({
                                icon: "error",
                                title: "Something went wrong. Please try again!"
                            })
                        }
                    });
                }
            });
        }

        function setEditCategoryData(category_name, category_id, c_description, c_keywords) {
            $('#editCategoryForm #category_name').val(category_name);
            $('#editCategoryForm #category_id').val(category_id);
            $('#editCategoryForm #c_description').val(c_description);
            $('#editCategoryForm #c_keywords').val(c_keywords);
        }
    </script>
@endsection
