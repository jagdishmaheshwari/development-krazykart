@extends('layouts.admin')

@section('content')
    <div class="container overflow-scroll mt-2  ManageItems">
        @if ($products)
            <div class="text-center h2">
                <span>
                    Category Name <i class='fa fa-angle-right'></i> {{ $products[0]['product_name'] }}
                </span>
            </div>
        @endif

        <div class="mb-2 d-flex justify-content-between">
            <h2>Manage Items</h2>
            <div>
                <div class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addItemModal"
                    onclick="$('#addItemButton').show();$('#updateItemButton').hide();"><i class="fa fa-plus"></i> Add Item
                </div>
                <div class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#specifications">Specifications <i
                        class="fa fa-list"></i>
                </div>
            </div>
        </div>

        @if (!$productId)
            <div id="specifications" class="collapse w-100 py-2 bg-grey">
                <div class="px-5">
                    @php
                        $row = getDetails($conn, "product_list.product_id = $productId")->first();
                    @endphp

                    @if ($row)
                        <div class="h2">
                            <b>Description :</b> {{ $row->p_description }}
                        </div>
                        <div class="h2">
                            <b>Keywords :</b> {{ $row->p_keywords }}
                        </div>
                    @endif

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
        <style>
            #imageContainer{
                display: flex;
                flex-wrap: wrap;
            }
            .image-wrapper{
                
            }
            .image-wrapper img{
                width: 150px;
            }

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

            .file-input-container>label,
            .image-container {
                background: var(--acc);
                color: #fff;
                border-radius: 10px;
                padding: 10px;
                min-width: 120px;
                min-height: 90%;
                cursor: pointer;
                margin: 10px 10px 40px;
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
                                        onclick="editPriority('items','item_id','{{ $item['item_id'] }}','minus')"></div>
                                    <div class="btn">{{ $item['priority'] }}</div>
                                    <div class="btn btn-xs text-danger fa fa-caret-down"
                                        onclick="editPriority('items','item_id','{{ $item['item_id'] }}','plus')"></div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex">
                                    <div>
                                        <div class="d-flex" style="height:100px;padding:5px">
                                            {{-- <i
                                            class="fa fa-circle {{ $item['status'] ? 'spinner-grow spinner-grow-sm text-green' : 'text-red' }}"></i> --}}
                                            <!-- Replace the image URL with a placeholder from Unsplash -->
                                            <img src="{{ @$item['item_images'][0] }}" alt="No Image">
                                        </div>
                                    </div>
                                    <div class="p-2">
                                        <div class="">{{ $item['category_name'] }}>{{ $item['product_name'] }} (
                                            @if ($item['gender'] == 'm')
                                                Male
                                            @elseif ($item['gender'] == 'f')
                                                Female
                                            @endif) <i class="text-light btn"
                                                style="background: {{ $item['color_code'] }}">{{ $item['color_name'] }}</i>
                                        </div>
                                        <div class="h5">
                                            <div>
                                                <span class="h2 text-sec">
                                                    <span
                                                        class="text-pri text-decoration-line-through">{{ $item['mrp'] }}</span>
                                                    &nbsp;
                                                    {{ $item['price'] }}
                                                </span>&nbsp;&nbsp;&nbsp;<span>Available 0{{ $item['stock'] }}</span>
                                                {{-- <div class="h4">
                                                    <b>Size : </b>{{ $item['size_name'] }} ({{ $item['size_code'] }})
                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            {{-- <td>
                                <div class="h2 d-flex text-sec">
                                    <span class="text-pri text-decoration-line-through">{{ $item['mrp'] }}</span>
                                    &nbsp;
                                    {{ $item['price'] }}
                                </div>
                                <div class="h4">
                                    <b>Color : </b>
                                    <i class="text-light btn"
                                        style="background: {{ $item['color_code'] }}">{{ $item['color_name'] }}</i>
                                    <br>
                                    <b>Size : </b>{{ $item['size_name'] }} ({{ $item['size_code'] }})
                                    <br>
                                    <b>Available : </b>{{ $item['stock'] }}
                                </div>
                            </td> --}}
                            <td>
                                <div class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addItemModal"
                                    onclick="prefillItemDetails('{{ $item['item_id'] }}','{{ $item['fk_size_id'] }}','{{ $item['fk_color_id'] }}','{{ $item['priority'] }}','{{ $item['mrp'] }}','{{ $item['price'] }}')">
                                    <i class="fas fa-edit"></i> Edit
                                </div>
                                <div class="btn btn-danger" onclick="deleteItem('{{ $item['item_id'] }}')">
                                    <i class="fa fa-trash"></i>
                                </div>
                                @if ($item['status'] == 0)
                                    <div class="btn btn-success"
                                        onclick="updateRecordStatus('items','item_id','{{ $item['item_id'] }}')">
                                        <i class="fa fa-eye"></i> Show
                                    </div>
                                @else
                                    <div class="btn btn-danger"
                                        onclick="updateRecordStatus('items','item_id','{{ $item['item_id'] }}')">
                                        <i class="fa fa-eye-slash"></i> Hide
                                    </div>
                                @endif
                                <div class="pt-1">
                                    <div class="btn btn-primary" data-bs-toggle="modal"
                                        onclick="openImagePopup({{ $item['item_id'] }}, {{ $item['item_images'] }})"
                                        data-bs-target="#uploadImageModal">
                                        <i class="fa fa-image"></i>
                                    </div>
                                    <div class="btn btn-primary"
                                        onclick="window.location=('manage_stock?&itemId={{ $item['item_id'] }}')">
                                        <i class="fas fa-box-open"></i> Stock
                                    </div>
                                    <div class="btn btn-warning"
                                        onclick="window.location=('clone_item?itemId={{ $item['item_id'] }}')">
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
    <style>

    </style>
    <!-- MANAGE IMAGES MODAL START-->
    <div class="modal fade" id="uploadImageModal" tabindex="-1" role="dialog" aria-labelledby="uploadImageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h3 class="modal-title w-100 text-center" id="addItemModalLabel">Manage Item Images</h3>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="imageContainer"></div>
                    <div class="sortable-list" id="sortableList">
                        <!-- Thumbnails will be added here dynamically -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submit-all">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- MANAGE IMAGES MODAL END-->


    <div class="modal fade p-0 p-sm-5" id="addItemModal" tabindex="1" aria-labelledby="addItemModalLabel"
        styles="display:block !important;" aria-hidden="tru">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h3 class="modal-title w-100 text-center" id="addItemModalLabel">Add Item</h3>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addItemForm">
                        <div class="row mb-3">
                            <div class="col">
                                <label for="categoryId">Select Category</label>
                                <select class="form-select" id="categoryId" name="categoryId">
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
                            </div>
                            <div class="col">
                                <label for="productId">Select Product</label>
                                <select class="form-select" id="productId" name="productId">
                                    <option value="" selected>Select Product</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->product_id }}">
                                            {{ $product->product_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <div class="col">
                                <label for="colorId" class="form-label">Select Color</label>
                                <select id="colorId" class="form-select" value="">
                                    <option value="0" disabled selected>Select Color</option>
                                    @foreach ($colors as $color)
                                        <option style="background-color:{{ $color->color_code }}"
                                            value="{{ $color->color_id }}">
                                            {{ $color->color_name }} ({{ $color->color_code }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <label for="sizeId" class="form-label">Select Size</label>
                                <select id="sizeId" class="form-select" value="">
                                    <option value="0" disabled selected>Select Size</option>
                                    @foreach ($sizes as $size)
                                        <option value="{{ $size->size_id }}">
                                            {{ $size->size_name }} ({{ $size->size_code }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <label for="priority" class="form-label">Priority :</label>
                                <input type="number" id="priority" value="10" class="form-control col-4">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col">
                                <label for="sellingPrice" class="form-label">Maximum Retail Price:</label>
                                <input type="number" id="sellingPrice" value="2000" class="form-control col-4">
                            </div>
                            <div class="col">
                                <label for="offerPrice" class="form-label">Offer Price:</label>
                                <input type="number" id="offerPrice" value="1299" class="form-control col-4">
                            </div>
                        </div>
                        <div>
                            <input type="hidden" id="itemId" value="">
                            <button type="button" class="btn btn-primary float-end " id="addItemButton">Add
                                Item</button>
                            <button type="button" class="btn btn-primary float-end " id="updateItemButton">Update
                                Item</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function openImagePopup(itemId, imageUrls) {
            const imageContainer = document.getElementById('imageContainer');
            const imageItemId = $('#uploadImageModal #itemId');

            // Clear any existing images in the container
            imageContainer.innerHTML = '';
            // Set the item ID in the hidden input
            imageItemId.val(itemId);

            // Loop through the image URLs and create img elements
            imageUrls.forEach(url => {
                const imageWrapper = document.createElement('div');
                imageWrapper.classList.add('image-wrapper');
                
                const img = document.createElement('img');
                img.src = url;
                img.classList.add('images_preview');

                imageWrapper.appendChild(img);
                imageContainer.appendChild(imageWrapper);
            });

            // Add upload form if image count is less than 7
            if (imageUrls.length < 7) {
                const imageInputForm = document.createElement('form');
                imageInputForm.id = 'imageForm';
                imageInputForm.method = 'POST';
                imageInputForm.classList.add('d-flex');
                imageInputForm.action = 'action_upload_item_image';
                imageInputForm.enctype = 'multipart/form-data';

                const fileInputContainer = document.createElement('div');
                fileInputContainer.classList.add('file-input-container');

                const label = document.createElement('label');
                label.classList.add('d-flex', 'opacity-75', 'align-items-center', 'justify-content-center', 'flex-column', 'text-center');
                label.setAttribute('for', 'imageInput');

                const icon = document.createElement('i');
                icon.classList.add('fa', 'fa-upload');
                icon.style.fontSize = '40px';

                const heading = document.createElement('h3');
                heading.innerHTML = 'Upload<br>Image';

                label.appendChild(icon);
                label.appendChild(heading);

                const fileInput = document.createElement('input');
                fileInput.type = 'file';
                fileInput.id = 'imageInput';
                fileInput.classList.add('d-none');
                fileInput.name = 'image';
                fileInput.accept = 'image/*';
                fileInput.required = true;

                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.id = 'itemId';
                hiddenInput.name = 'itemId'; // Ensure this name matches your form handling
                hiddenInput.value = itemId;

                fileInputContainer.appendChild(label);
                fileInputContainer.appendChild(fileInput);
                fileInputContainer.appendChild(hiddenInput);

                imageInputForm.appendChild(fileInputContainer);
                imageContainer.appendChild(imageInputForm);
            }

            // Show the modal
            $('#uploadImageModal').modal('show');
        }
        $(document).ready(function() {
            $('#uploadImageModal').on('change', '#imageInput', function() {
                const file = this.files[0];
                const formData = new FormData();
                itemId = $('#uploadImageModal #itemId').val();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('image', file);
                formData.append('item_id', itemId);
                formData.append('priority', 0);

                $.ajax({
                    url: '{{ route('item.image.upload') }}',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        window.location.reload();
                        // alert('Image uploaded successfully!');
                        // Optionally, you can update the UI to show the uploaded image
                    },
                    error: function(response) {
                        swal('Error!', response.responseJSON.message, 'error');
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Update item button click event
            $('#updateItemButton').on('click', function() {
                // Retrieve data from form fields
                var itemId = $('#addItemForm #itemId').val();
                var sizeId = $('#sizeId').val();
                var colorId = $('#colorId').val();
                var priority = $('#priority').val();
                var sellingPrice = $('#sellingPrice').val();
                var offerPrice = $('#offerPrice').val();

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
                        offerPrice: offerPrice
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
        });
    </script>
    <script>
        categoryId = '{{ $categoryId }}';
        productId = '{{ $productId }}';
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
        function prefillItemDetails(itemId, sizeId, colorId, priority, sellingPrice, offerPrice) {
            // Prefill item details in the modal
            $('#addItemModal #itemId').val(itemId);
            $('#addItemModal #sizeId').val(sizeId);
            $('#addItemModal #colorId').val(colorId);
            $('#addItemModal #priority').val(priority);
            $('#addItemModal #sellingPrice').val(sellingPrice);
            $('#addItemModal #offerPrice').val(offerPrice);

            $('#addItemButton').hide();
            $('#updateItemButton').show();
        }
        // Function to add item
        $('#addItemButton').on('click', function() {
            // Retrieve data from form fields
            var categoryId = $('#addItemForm #categoryId').val();
            var productId = $('#addItemForm #productId').val();
            var colorId = $('#addItemForm #colorId').val();
            var sizeId = $('#addItemForm #sizeId').val();
            var sellingPrice = $('#addItemForm #sellingPrice').val();
            var offerPrice = $('#addItemForm #offerPrice').val();
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

    <script>
        $(document).ready(function() {
            var itemId;

            // Capture item ID when opening the modal
            $('#uploadModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                itemId = button.data('item-id');
                console.log('Item ID:', itemId);
            });

            // Initialize Dropzone
            Dropzone.options.imageUploadDropzone = {
                paramName: 'file',
                maxFiles: 7,
                acceptedFiles: 'image/*',
                autoProcessQueue: false,
                init: function() {
                    var myDropzone = this;

                    $('#submit-all').click(function() {
                        myDropzone.processQueue(); // Process the queue
                    });

                    this.on('sending', function(file, xhr, formData) {
                        formData.append('item_id', itemId); // Append item ID to the form data
                    });

                    this.on('success', function(file, response) {
                        // Handle successful upload
                        addThumbnail(response.imageUrl); // Assume response contains the image URL
                    });

                    this.on('queuecomplete', function() {
                        myDropzone.removeAllFiles(); // Clear the Dropzone area
                    });
                }
            };

            // Initialize Sortable
            var sortable = new Sortable(document.getElementById('sortableList'), {
                animation: 150,
                onEnd: function( /**Event*/ evt) {
                    // Handle reordering here if needed
                }
            });

            // Function to add a thumbnail to the sortable list
            function addThumbnail(imageUrl) {
                var sortableList = $('#sortableList');
                var thumbnail = `
            <div class="sortable-item">
                <img src="${imageUrl}" alt="Image">
                <button class="remove-btn">&times;</button>
            </div>
        `;
                sortableList.append(thumbnail);
            }

            // Event delegation to handle thumbnail removal
            $('#sortableList').on('click', '.remove-btn', function() {
                $(this).closest('.sortable-item').remove();
            });

            // Event delegation to handle full view of images
            $('#sortableList').on('click', 'img', function() {
                var src = $(this).attr('src');
                var modalHtml = `
            <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <img src="${src}" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        `;
                $('body').append(modalHtml);
                $('#imageModal').modal('show');
                $('#imageModal').on('hidden.bs.modal', function() {
                    $(this).remove();
                });
            });
        });
    </script>

@endsection
