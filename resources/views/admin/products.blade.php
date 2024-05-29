@extends('layouts.admin')
@section('content')
    @if ($categoryId)
        <div class="container overflow-scroll mt-2">
            <div class="text-center h2 text-pri"><span class="h2">{{ $categoryName }}</span></div>
            {{-- <h2>Manage Products </h2> --}}
            <div class="mb-2 d-flex justify-content-between">
                <h2>Manage Products</h2>
                <div>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addProductModal">
                        <i class="fa fa-plus"></i> Add Product</button>
                </div>
            </div>
            <table class="table table-head-bg-primary bg-white table-bordered-bd-primary table-hover" id="productTable">
                <thead class="bg-grey">
                    <tr>
                        <th>Priority</th>
                        <th>
                            <div class="row">
                                <div class="col-4">Product Details</div>
                                <div class="col-8"><input type="text" id="productDetailsSearch"
                                        placeholder="Search product details" class="form-control"></div>
                            </div>
                        </th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($products)
                        @foreach ($products as $product)
                            <tr>
                                <td>
                                    <div style="d-flex flex-column">
                                        <div class="w-100 btn text-success fa fa-caret-up"
                                            onclick="editPriority('products', 'product_id', '{{ $product->product_id }}', 'minus')">
                                        </div>
                                        <div class="text-center">{{ $product->priority }}</div>
                                        <div class="w-100 btn text-danger fa fa-caret-down"
                                            onclick="editPriority('products', 'product_id', '{{ $product->product_id }}', 'plus')">
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="row">
                                        <div class="col-2 d-flex">
                                            <i
                                                class="fa fa-circle {{ $product->status ? 'spinner-grow spinner-grow-sm text-green' : 'text-red' }}"></i>
                                            <img class="w-100" src="images/item_images/image }}">
                                        </div>
                                        <div class="col-10">
                                            <div class="h3">{{ $product->category_name }}</div>
                                            <div class="h5">{{ $product->product_name }}
                                                ({{ $product->gender === 'm' ? 'Male' : 'Female' }})
                                            </div>
                                            <div><code>{{ $product->product_code }}</code></div>
                                            <div>{{ $product->keywords }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="min-width:170px">
                                    <div class="btn btn-primary my-1" title="Edit" data-bs-toggle="modal"
                                        data-bs-target="#editProductModal"
                                        onclick="prefillProductDetails('{{ $product->fk_category_id }}', '{{ $product->product_id }}', '{{ $product->product_code }}', '{{ $product->product_name }}', '{{ $product->priority }}', '{{ $product->gender }}', '{{ $product->p_keywords }}', '{{ $product->p_description }}', '{{ $product->status }}')">
                                        <i class="fa fa-edit"></i>
                                    </div>
                                    <div class="btn btn-danger" title="Delete"
                                        onclick="deleteProduct('{{ $product->product_id }}')"><i class="fa fa-trash"></i>
                                    </div>
                                    @if ($product->status == 0)
                                        <div class="btn btn-success" title="Show"
                                            onclick="updateRecordStatus('products', 'product_id', '{{ $product->product_id }}')">
                                            <i class="fa fa-eye"></i>
                                        </div>
                                    @else
                                        <div class="btn btn-danger" title="Hide"
                                            onclick="updateRecordStatus('products', 'product_id', '{{ $product->product_id }}')">
                                            <i class="fa fa-eye-slash"></i>
                                        </div>
                                    @endif
                                    <div class="btn btn-success"
                                        onclick="window.location=('{{ route('admin.items.index', ['c_id' => $categoryId, 'p_id' => $product->product_id]) }}')">
                                        <i class="fa fa-bars"></i> Manage Item
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="3" class="h4 text-center text-danger">No product available for this category
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Add Product Modal -->
        @include('admin.partials.add_product_modal', ['categoryList' => $categoryList])

        <!-- Edit Product Modal -->
        @include('admin.partials.edit_product_modal')

        <script>
            function prefillProductDetails(categoryId, productId, productCode, productName, priority, gender, keywords,
                description, status) {
                $('#editProductForm #categoryId').val(categoryId);
                $('#editProductForm #productId').val(productId);
                $('#editProductForm #productName').val(productName);
                $('#editProductForm #productCode').val(productCode.toUpperCase());
                $('#editProductForm #priority').val(priority);
                $('#editProductForm #description').val(description);
                $('#editProductForm #keywords').val(keywords);
                $('#editProductForm #status').prop('checked', status == 1);
                $('#editProductForm #editProductModal').modal('show');
            }
        </script>
        <script>
            function updateProduct() {
                // Fetch data from the form
                var productId = $('#editProductModal #productId').val();
                var categoryId = $('#editProductModal #categoryId').val();
                var productCode = $('#editProductModal #productCode').val();
                var productName = $('#editProductModal #productName').val();
                var description = $('#editProductModal #description').val();
                var priority = $('#editProductModal #priority').val();
                var gender = $("#editProductModal input[name='gender']:checked").val();
                var keywords = $('#editProductModal #keywords').val();
                var status = $('#status').prop('checked') ? 1 : 0;
                // Check if product name and code are not empty
                if (productName.trim() === '' || productCode.trim() === '' || productId.trim() === '') {
                    swal('Please enter product name and code.');
                }

                $.ajax({
                    type: 'PUT',
                    url: '{{ route('admin.product.update') }}', // Replace with your server-side script URL
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'productId': productId,
                        'categoryId': categoryId,
                        'productCode': productCode,
                        'productName': productName,
                        'description': description,
                        'gender': gender,
                        'keywords': keywords,
                        'priority': priority,
                        'status': status
                    },
                    success: function(response) {
                        if (response.status.trim() === 'success') {
                            swal({
                                title: response.message,
                                icon: "success"
                            }).then(function() {
                                window.location.reload();
                            });
                        } else {
                            swal({
                                title: response.message,
                                icon: "info"
                            });
                        }
                    },
                    error: function() {
                        swal('An error occurred while Updating product. Please try again later.').then(function() {
                            // window.location.reload();
                        });
                    }
                });
            }
        </script>
        <script>
            categoryId = '{{ $categoryId }}';
            $('#addProductForm #categoryId').val(categoryId).change();

            function addProduct() {
                var categoryId = $('#addProductForm #categoryId').val();
                var productCode = $('#addProductForm #productCode').val();
                var productName = $('#addProductForm #productName').val();
                var description = $('#addProductForm #description').val();
                var status = $('#status').prop('checked') ? 1 : 0;
                var priority = $('#addProductForm #priority').val();
                var keywords = $('#addProductForm #keywords').val();
                var gender = $("input[name='gender']:checked").val();
                // Check if product name and code are not empty
                if (categoryId.trim() === '' || productCode.trim() === '' || productName.trim() === '' || description.trim() ===
                    '' || priority.trim() === '' || gender.trim() === '' || keywords.trim() === '') {
                    swal('Please fill required details!');
                    return;
                }
                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.product.add') }}',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'categoryId': categoryId,
                        'productCode': productCode,
                        'productName': productName,
                        'description': description,
                        'priority': priority,
                        'gender': gender,
                        'keywords': keywords,
                        'status': status
                    },
                    success: function(response) {
                        if (response.status.trim() === 'success') {
                            swal({
                                title: "Product added successfully!",
                                icon: "success"
                            }).then(function() {
                                window.location.reload();
                            }); // Refresh the product list
                        } else {
                            swal("Failed to add product. Please try again.").then(function() {
                                // window.location.reload();
                            });
                        };
                    },
                    error: function() {
                        swal("An error occurred while adding product. Please try again later.").then(function() {
                            window.location.reload();
                        });
                    }
                });

            }
        </script>
        <script>
            function deleteProduct(productId) {
                swal({
                    title: "Sure Delete Product?",
                    text: "This action cannot be undone.",
                    icon: "warning",
                    buttons: ["Cancel", "Confirm"],
                    dangerMode: true,
                }).then((isConfirmed) => {
                    if (isConfirmed) {
                        $.ajax({
                            type: 'DELETE',
                            url: '{{ route('admin.product.delete') }}',
                            data: {
                                '_token': '{{ csrf_token() }}',
                                product_id: productId
                            },
                            success: function(response) {
                                if (response.status === 'success') {
                                    swal({
                                        icon: "success",
                                        title: response.message
                                    }).then(function() {
                                        window.location.reload();
                                    });
                                } else if (response === 'data') {
                                    swal({
                                        icon: "info",
                                        title: "There are some products associated with this product!" +
                                            swal
                                    })
                                } else {
                                    swal({
                                        icon: "error",
                                        title: "Something went wrong please try again leterrrrr!!"
                                    })
                                }
                            },
                            error: function() {
                                swal({
                                    icon: "error",
                                    title: "Something went wrong please try again!"
                                })
                            }
                        });
                    }
                });
            }
        </script>
        <script>
            function initiateDataTable() {
                var table = $('#productTable').DataTable({
                    stateSave: true
                });

                // Apply individual column search
                $('#productDetailsSearch').on('keyup', function() {
                    table.columns(1).search(this.value).draw();
                });
            };
        </script>



















        <!-- function initiateDataTable() {
                        var table = $('#productTable').DataTable({
                            stateSave: true
                        });

                        // Apply individual column search
                        $('#productDetailsSearch').on('keyup', function () {
                            table.columns(1).search(this.value).draw();
                        });
                    }; -->
        </script>
    @else
        <script>
            window.location.href = "{{ url()->previous() }}";
        </script>
    @endif
@endsection
