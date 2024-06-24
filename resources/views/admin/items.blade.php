@extends('layouts.admin')

@section('content')
    <div class="container overflow-scroll mt-2  ManageItems">
        @if ($items)
            <div class="text-center h2">
                <span>
                    {{ $CategoryName }} <i class='fa fa-angle-right'></i> {{ $ProductName }}
                </span>
            </div>
        @endif

        <div class="mb-2 d-flex justify-content-between">
            <h2>Manage Items</h2>
            <div>
                <div class="btn btn-success" data-bs-toggle="modal"
                    onclick="$('#addItemButton').show();$('#updateItemButton').hide();$('#addItemModal').modal('show')"><i
                        class="fa fa-plus"></i> Add Item
                </div>
                <div class="btn btn-primary" data-bs-toggle="modal" onclick="getProductDetailHtml({{$productId}});">Description <i
                        class="fa fa-list"></i>
                </div>
            </div>
        </div>

       <?php /* @if (!$items[0]->product_id)
            <div id="specifications" class="collapse w-100 py-2 bg-grey">
                <div class="px-5">
                    {{-- @php
                        $row = getDetails($conn, "product_list.product_id = $productId")->first();
                    @endphp

                    @if ($row)
                        <div class="h2">
                            <b>Description :</b> {{ $row->p_description }}
                        </div>
                        <div class="h2">
                            <b>Keywords :</b> {{ $row->p_keywords }}
                        </div>
                    @endif --}}

                    <hr>

                    <div class="row">
                        <form id="addSpecificationForm" class="col-12 col-md-5">
                            <h4 class="text-center">Add Specifications</h4>
                            <!-- Your form fields here -->
                        </form>
                        <div class="col-12 col-md-7">
                            <table class="table table-bordered table-striped">
                                <!-- Table header and rows -->
                                <tr>
                                    <th>Item Details</th>
                                    <!-- Add more table headers as needed -->
                                </tr>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $item->item_details }}</td>
                                        <!-- Add more table cells with item details as needed -->
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        */?>
        <style>
            .ManageItems .table td {
                padding: 10px 10px !important;
            }

            .ManageItems .table th {
                height: 40px;
                color: var(--nue);
            }

            .ManageItems .table td img {
                height: 100%;
            }

            .ManageItems .table tbody td {
                height: 50px;
                max-height: 50px
            }
        </style>
        <div class="car">
            <table class="table table-head-bg-primary bg-white table-bordered-bd-primary table-hover" id="itemTable"
                style="min-width:1300px">
                <colgroup>
                    <col style="width:10%">
                    <col>
                    <col style="width:25%">
                </colgroup>


                {{-- <thead style="padding:0px !important"> --}}
                <tr class="bg-primary text-light">
                    <th><span>Priority</span></th>
                    <th class="text-center"><span>Item Details</span></th>
                    <th><span>Action</span></th>
                </tr>
                {{-- </thead> --}}
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td class="">
                                <div class="d-flex flex-row">
                                    <div class="btn btn-xs text-success fa fa-caret-up"
                                        onclick="editPriority('items','item_id','{{ $item->item_id }}','minus')"></div>
                                    <div class="btn">{{ $item->priority }}</div>
                                    <div class="btn btn-xs text-danger fa fa-caret-down"
                                        onclick="editPriority('items','item_id','{{ $item->item_id }}','plus')"></div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex">
                                    <div>
                                        <div class="d-flex" style="height:100px;padding:5px">
                                            {{-- <i
                                            class="fa fa-circle {{ $item->status ? 'spinner-grow spinner-grow-sm text-green' : 'text-red' }}"></i> --}}
                                            <!-- Replace the image URL with a placeholder from Unsplash -->
                                            <img src="{{ reset($item->item_images) }}"
                                                onerror="this.src='/img/image-placeholder-300-500.jpg'" alt="No Image">
                                        </div>
                                    </div>
                                    <div class="p-2">
                                        <div class="">
                                            @if ($item->gender == 'M')
                                                Male
                                            @elseif ($item->gender == 'F')
                                                Female
                                            @endif <i class="text-light btn"
                                                style="background: {{ $item->color_code }}">{{ $item->color_name }}</i>
                                        </div>
                                        <div class="h5">
                                            <div>
                                                <span class="h2 text-sec">
                                                    <span
                                                        class="text-pri text-decoration-line-through">{{ $item->mrp }}</span>
                                                    &nbsp;
                                                    {{ $item->price }}
                                                </span>&nbsp;&nbsp;&nbsp;<span>Available 0{{ $item->stock }}</span>
                                                {{-- <div class="h4">
                                                    <b>Size : </b>{{ $item->size_name }} ({{ $item->size_code }})
                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            {{-- <td>
                                <div class="h2 d-flex text-sec">
                                    <span class="text-pri text-decoration-line-through">{{ $item->mrp }}</span>
                                    &nbsp;
                                    {{ $item->price }}
                                </div>
                                <div class="h4">
                                    <b>Color : </b>
                                    <i class="text-light btn"
                                        style="background: {{ $item->color_code }}">{{ $item->color_name }}</i>
                                    <br>
                                    <b>Size : </b>{{ $item->size_name }} ({{ $item->size_code }})
                                    <br>
                                    <b>Available : </b>{{ $item->stock }}
                                </div>
                            </td> --}}
                            <td>
                                {{-- <div class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addItemModal"
                                    onclick="prefillItemDetails('{{ $item->item_id }}','{{ $item->fk_size_id }}','{{ $item->fk_color_id }}','{{ $item->priority }}','{{ $item->mrp }}','{{ $item->price }}')">
                                    <i class="fas fa-edit"></i> Edit
                                </div> --}}
                                <div class="btn btn-primary btn-smmmmm"
                                    onclick="prefillItemDetails('{{ $item->item_id }}','{{ $item->fk_size_id }}','{{ $item->fk_color_id }}','{{ $item->priority }}','{{ $item->mrp }}','{{ $item->price }}','{{ $item->cost_price }}')">
                                    <i class="fas fa-edit"></i> Edit
                                </div>
                                <div class="btn btn-danger btn-smmmmm" onclick="deleteItem('{{ $item->item_id }}')">
                                    <i class="fa fa-trash"></i>
                                </div>
                                @if ($item->status == 0)
                                    <div class="btn btn-success btn-smmmmm"
                                        onclick="updateRecordStatus('items','item_id','{{ $item->item_id }}')">
                                        <i class="fa fa-eye"></i> Show
                                    </div>
                                @else
                                    <div class="btn btn-danger btn-smmmmm"
                                        onclick="updateRecordStatus('items','item_id','{{ $item->item_id }}')">
                                        <i class="fa fa-eye-slash"></i> Hide
                                    </div>
                                @endif
                                <div class="pt-1">
                                    <div class="btn btn-primary btn-smmmmm" onclick="openImagePopup({{ $item->item_id }})">
                                        <i class="fa fa-image"></i>
                                    </div>
                                    <div class="btn btn-primary btn-smmmmm" onclick="showItemStockDetails('{{ $item->item_id }}')">
                                        {{-- data-bs-toggle="modal" data-bs-target="#addStockModal" --}}
                                        <i class="fas fa-box-open"></i> Stock
                                    </div>
                                    <div class="btn btn-warning btn-smmmmm cloneItem" data-item-id="{{ $item->item_id }}">
                                        <i class="fas fa-clone"></i> Clone
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade p-0 p-sm-5" id="addItemModal" tabindex="1" aria-labelledby="addItemModalLabel"
        aria-hidden="tru">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h3 class="modal-title w-100 text-center" id="addItemModalLabel">Add Item</h3>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addItemForm">
                        <div>
                            <h2 class="text-center"> {{ $CategoryName }} > {{ $ProductName }}
                            </h2 class="text-center">
                        </div>
                        {{-- <div class="row mb-3">
                            <div class="col">
                                <div class="form-floating">
                                    <select class="form-control" id="categoryId" disabled name="categoryId" placeholder>
                                        <option value="" selected>Select Category</option>
                                        @if ($categories)
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->category_id }}">
                                                    {{ $category->category_name }}
                                                </option>
                                            @endforeach
                                        @else
                                            <script>
                                                swal('Category List not fetched!');
                                            </script>
                                        @endif
                                    </select>
                                    <label for="categoryId">Select Category</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <select class="form-control" id="productId" disabled name="productId" placeholder>
                                        <option value="" selected>Select Product</option>
                                        @foreach ($items as $item)
                                            <option value="{{ $item->product_id }}">
                                                {{ $item->product_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="productId">Select Product</label>
                                </div>
                            </div>
                        </div> --}}

                        <div class="mb-3 row">
                            <div class="col">
                                <div class="form-floating">
                                    <select id="colorId" class="form-select" value="" placeholder>
                                        <option value="0" disabled selected>Select Color</option>
                                        @foreach ($colors as $color)
                                            <option style="background-color:{{ $color->color_code }}"
                                                value="{{ $color->color_id }}">
                                                {{ $color->color_name }} ({{ $color->color_code }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="colorId" class="form-label">Select Color</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <select id="sizeId" class="form-select" value="" placeholder>
                                        <option value="0" disabled selected>Select Size</option>
                                        @foreach ($sizes as $size)
                                            <option value="{{ $size->size_id }}">
                                                {{ $size->size_name }} ({{ $size->size_code }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="sizeId" class="form-label">Select Size</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="number" id="priority" value="10" class="form-control col-4"
                                        placeholder>
                                    <label for="priority" class="form-label">Priority :</label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col">
                                <div class="form-floating">
                                    <input type="number" id="sellingPrice" value="2000" class="form-control col-4"
                                        placeholder>
                                    <label for="sellingPrice" class="form-label">Maximum Retail Price:</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="number" id="offerPrice" value="1299" class="form-control col-4"
                                        placeholder>
                                    <label for="offerPrice" class="form-label">Offer Price:</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="number" id="costPrice" value="1299" class="form-control col-4"
                                        placeholder>
                                    <label for="costPrice" class="form-label">Cost Price(optional) : </label>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <input type="hidden" id="itemId" value="">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" style="display:none" id="addItemButton">Add
                                Item</button>
                            <button type="button" class="btn btn-primary" style="display:none"
                                id="updateItemButton">Update Item</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('admin.partials.manage-stock-modal')
    @include('admin.partials.manage-image-modal')
    @include('admin.partials.product_detail_modal')
    <script>
        $(document).ready(function() {
            // Update item button click event
            $('#updateItemButton').on('click', function() {
                // Retrieve data from form fields
                var itemId = $('#addItemForm #itemId').val();
                var sizeId = $('#addItemForm #sizeId').val();
                var colorId = $('#addItemForm #colorId').val();
                var priority = $('#addItemForm #priority').val();
                var sellingPrice = $('#addItemForm #sellingPrice').val();
                var offerPrice = $('#addItemForm #offerPrice').val();
                var costPrice = $('#addItemForm #costPrice').val();

                // Make AJAX request to update item
                $.ajax({
                    url: '{{ route('admin.items.update') }}', // Assuming this is your route for updating items
                    type: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}',
                        itemId: itemId,
                        sizeId: sizeId,
                        colorId: colorId,
                        priority: priority,
                        sellingPrice: sellingPrice,
                        offerPrice: offerPrice,
                        costPrice: costPrice
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            swal('Success', 'Item updated successfully!', 'success').then(
                                function() {
                                    location.reload();
                                });
                        } else {
                            swal('Error', response.message, 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        swal('Error', 'An error occurred while updating the item.', 'error');
                    }
                });
            });
            $('.cloneItem').click(function() {
                // Get the item ID to be cloned (replace with your logic to get the ID)
                var itemId = $(this).data('item-id'); // Assuming the ID is stored in a data attribute

                $.ajax({
                    url: '{{ route('admin.item.clone') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        itemId: itemId
                    },
                    success: function(response) {
                        if (response.success) {
                            showActionAlert(response.success);
                            window.location.reload();
                        } else {
                            alert('Failed to clone item.');
                        }
                    },
                    error: function(xhr, status, error) {
                        showActionAlert(error + '! Clone failed!', status);
                    }
                });
            });
        });
    </script>
    <script>
        const categoryId = '{{ $categoryId }}';
        const productId = '{{ $productId }}';
        if (categoryId && productId) {
            $('#categoryId').val(categoryId).change();
            setTimeout(function() {
                $('#addItemModal #productId').val(productId).change();
            }, 200);
        }
        // -------------------------------  TESTING PURPOSE --------------------------------------
        $('#addItemModal #colorId').val(1).change();
        $('#addItemModal #sizeId').val(1).change();
        // -------------------------------  TESTING PURPOSE --------------------------------------
    </script>

    <!-- Other scripts for adding, deleting items -->
    <!-- Ensure to replace 'admin.items.add', 'admin.items.delete' with your actual route names -->
    <script>
        // Function to prefill item details in the modal
        function prefillItemDetails(itemId, sizeId, colorId, priority, sellingPrice, offerPrice, costPrice) {
            // Prefill item details in the modal
            $('#addItemModal #itemId').val(itemId);
            $('#addItemModal #sizeId').val(sizeId);
            $('#addItemModal #colorId').val(colorId);
            $('#addItemModal #priority').val(priority);
            $('#addItemModal #sellingPrice').val(sellingPrice);
            $('#addItemModal #offerPrice').val(offerPrice);
            $('#addItemModal #costPrice').val(costPrice);

            $('#addItemButton').hide();
            $('#updateItemButton').show();
            $('#addItemModal').modal('show');
        }
        // Function to add item
        $('#addItemButton').on('click', function() {
            // Retrieve data from form fields
            var colorId = $('#addItemForm #colorId').val();
            var sizeId = $('#addItemForm #sizeId').val();
            var sellingPrice = $('#addItemForm #sellingPrice').val();
            var offerPrice = $('#addItemForm #offerPrice').val();
            var costPrice = $('#addItemForm #costPrice').val();
            var priority = $('#addItemForm #priority').val();

            // Validate form fields
            if (categoryId.trim() === null || productId.trim() === null || colorId.trim() === null || sizeId
                .trim() === null || sellingPrice.trim() === '' || offerPrice.trim() === '' || priority.trim() === ''
            ) {
                swal('Please fill required details!');
                return;
            }

            // Make AJAX request to add item
            $.ajax({
                type: 'POST',
                url: '{{ route('admin.items.add') }}', // Assuming this is your route for adding items
                data: {
                    _token: '{{ csrf_token() }}',
                    categoryId: categoryId,
                    productId: productId,
                    colorId: colorId,
                    sizeId: sizeId,
                    sellingPrice: sellingPrice,
                    offerPrice: offerPrice,
                    costPrice: costPrice,
                    priority: priority
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
                        swal("Failed to add Item. Please try again.").then(function() {
                            // window.location.reload();
                        });
                    }
                },
                error: function() {
                    swal("An error occurred while adding product. Please try again later.").then(
                        function() {
                            // window.location.reload();
                        });
                }
            });
        });
    </script>

    <script>
        // Function to delete item
        function deleteItem(itemId) {
            swal({
                title: "Sure Delete This Item?",
                text: "This action cannot be undone.",
                icon: "warning",
                buttons: ["Cancel", "Confirm"],
                dangerMode: true,
            }).then((isConfirmed) => {
                if (isConfirmed) {
                    // Make AJAX request to delete item
                    $.ajax({
                        type: 'DELETE',
                        url: '{{ route('admin.items.delete') }}', // Assuming this is your route for deleting items
                        data: {
                            itemId: itemId,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                swal({
                                    icon: "success",
                                    title: response.message
                                }).then(function() {
                                    window.location.reload();
                                });
                            } else if (response.status === 'data') {
                                swal({
                                    icon: "info",
                                    title: "There are some contents which depend on this Item!"
                                })
                            } else {
                                swal({
                                    icon: "error",
                                    title: " Error!" + response.message
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

@endsection
