<!-- Add Stock Modal -->
<div class="modal fade" id="addStockModal" aria-labelledby="addStockModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h3 class="modal-title w-100 text-center" id="addStockModalLabel">Add Stock<span class="itemId"></span>
                </h3>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                {{-- <div class="btn " data-bs-dismiss="modal" aria-label="Close">
                    <span class="fa fa-close"></span>
                </div> --}}
            </div>
            <div class="modal-body">
                <form id="addStockForm">
                    <div id="itemPreviewContent">
                        <div class="row">
                            <div class="col-md-4" style="height:150px">
                                <img src="/img/logo.png" id="itemImage" class="w-100" alt="">
                            </div>
                            <div class="col-md-8 ">
                                <div class="h2 text-pri"><span id="categoryName">Category Name > <span
                                            id="productName">Product Name<span id="sizeName"></span></div>
                                <div class="h3 text-pri"><span>Medium</span>(<span id="sizeCode">M</span>) | <span
                                        id="colorName">Blue</span> <button id="colorCode" style="background:#0f0ff1"
                                        class="btn">Color Preview</button>
                                </div>
                                <div class="h3">
                                    <div class="text-pri">Price : <span id="price" class="text-sec">000</span>
                                        <span class="text-decoration-line-through text-acc" id="mrp">0000</span>
                                    </div>
                                </div>
                                <h2 class="text-pri">
                                    Available : <span id="stock" class="text-sec">NaN</span><span
                                        class="ms-2 small c-pointer text-primary"
                                        onclick="OpenPopupWindow('https:/\/flipkart.com','Hellow Flipkart')">View
                                        Details</span>
                                </h2>
                                <h4>
                                    Status : Visible | Selling
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-9 col-8">
                            <div class="form-floating">
                                <select class="form-control border border-success" id="stockLocation" required>
                                    <option value="">Select Location</option>
                                    <option value="Naranpar">Naranpar</option>
                                    <option value="Bhuj">Bhuj</option>
                                    <option value="Bhujodi">Bhujodi</option>
                                    <option value="Vadodara">Vadodara</option>
                                    <option value="Surat">Surat</option>
                                </select>
                                <label for="stockLocation">Location</label>
                            </div>
                        </div>
                        <div class="col-md-3 col-4">
                            <div class="form-floating">
                                <input type="number" min="1" class="form-control border border-success"
                                    id="quantity" placeholder required>
                                <label for="quantity">Quantity</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control border border-success" id="vendor" placeholder>
                        <label for="vendor">Vendor</label>
                    </div>
                    <div class="form-floating mb-3" style="height:100px">
                        <textarea id="remark" class="form-control border-success" placeholder=""></textarea>
                        <label for="remark">Remark</label>
                    </div>
                    <input type="hidden" value="" id="itemId">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="addStockBtn">Add Stock</button>
            </div>
        </div>
    </div>
</div>
<!------------------------------------------- MODAL END------------------------------------------------->
<script>
    $(document).ready(function() {
        $('#addStockForm').validate({
            rules: {
                itemId: {
                    required: true
                },
                stockLocation: {
                    required: true
                },
                quantity: {
                    required: true,
                    digits: true // Ensure the input contains only digits
                },
                vendor: {
                    required: true
                }
                // Add more rules for other fields as needed
            },
            messages: {
                itemId: {
                    required: "Please enter the item ID."
                },
                stockLocation: {
                    required: "Please enter the stock location."
                },
                quantity: {
                    required: "Please enter the quantity.",
                    digits: "Please enter a valid quantity."
                },
                vendor: {
                    required: "Please enter the vendor."
                }
                // Add more messages for other fields as needed
            },
            submitHandler: function(form) {

                // if(!basicConfirmPopup('Are you sure you want to add stock?')){
                //     return;
                // }

                // AJAX request when the form is valid
                var itemId = $('#addStockForm #itemId').val();
                var stockLocation = $('#addStockForm #stockLocation').val();
                var quantity = $('#addStockForm #quantity').val();
                var vendor = $('#addStockForm #vendor').val();
                var remark = $('#addStockForm #remark').val();

                $.ajax({
                    url: "{{ route('admin.stock.ajax') }}",
                    method: 'POST',
                    data: {
                        action: 'AddStock',
                        itemId: itemId,
                        stockLocation: stockLocation,
                        quantity: quantity,
                        vendor: vendor,
                        remark: remark,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        showActionAlert(response.success);
                        swal({icon: 'success', title: 'Stock Added!'}).then(function(){
                            // $('#addStockForm')[0].reset();
                            window.location.reload();
                        });

                    },
                    error: function(xhr, status, error) {
                        showActionAlert(error + '! Stock not added!', status);
                    }
                });
            }
        });
    });
    $('#addStockBtn').on('click', function() {
        $('#addStockForm').submit(); // Trigger form submission on button click
    });
</script>
<script>
    // Function to retrieve and display item details in the modal
    function showItemStockDetails(itemId) {
        // AJAX request to the server
        $.ajax({
            url: '{{ route('admin.stock.ajax') }}', // Replace with your server endpoint
            type: 'POST',
            data: {
                action: 'getItemStockModalData',
                itemId: itemId,
                _token: "{{ csrf_token() }}" // Include CSRF token
            },
            success: function(response) {
                // Update modal with retrieved item details
                $('#itemPreviewContent #stock').text(response.count);
                // $('#categoryName').text(response.category_name);
                // $('#productName').text(response.product_name);
                // $('#price').text(response.price);
                // $('#mrp').text(response.mrp);
                // $('#color').text(response.color);
                // $('#sizeName').text(response.size_name);
                // $('#itemImage').attr('src', response.image_url);
                // $('#itemId').val(itemId);
                $('#addStockForm #itemId').val(itemId);

                $('#addStockModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                // Handle error
            }
        });
    }
</script>
