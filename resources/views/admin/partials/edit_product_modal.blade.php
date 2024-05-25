  <!-- Edit Product Modal -->
        <div class="modal fade p-0 p-sm-5" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel"
            aria-hidden="true" stle="display:block !important;opacity:1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProductModalLabel">Edit Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editProductForm">
                            <div class="mb-3">
                                <label for="categoryId">Select Category</label>
                                <select class="form-control" id="categoryId" name="categoryId">
                                    <option value="0" disabled selected>Select Category</option>
                                    @foreach ($categoryList as $category)
                                        <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="productCode" class="form-label">Product Code:</label>
                                <input type="text" class="form-control" oninput="$(this).val($(this).val().toUpperCase())"
                                    id="productCode" name="" required>
                            </div>
                            <div class="mb-3 row">
                                <div class="col-8">
                                    <label for="productName" class="form-label col-8">Product Name:</label>
                                    <input type="text" class="form-control col-8" id="productName" required>
                                </div>
                                <div class="col-4">
                                    <label for="productName" class="form-label col-4">Priority:</label>
                                    <input type="number" id="priority" class="form-control col-4">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Suitable For Gender:</label>
                                <div>
                                    <input type="radio" name="gender" id="Female" class="form-check-input" value="f" checked>
                                    <label for="Female"> Female</label>
                                    <input type="radio" name="gender" id="Male" class="form-check-input" value="m"> <label
                                        for="Male"> Male</label>
                                    <input type="radio" name="gender" id="Everyone" class="form-check-input" value="a"> <label
                                        for="Everyone">Everyone</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="productCode" class="form-label">Description:</label>
                                <textarea type="product" class="form-control" id="description" name="description"
                                    style="height:70px !important" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="keywords" class="form-label">Keywords:</label>
                                <textarea name="" id="keywords" cols="30" rows="2" class="form-control"></textarea>
                            </div>
                            <input type="checkbox" class="mx-2" style="scale:2" id="visible" value="1" checked> <label
                                for="visible">Visible</label>
                            <input type="hidden" id="productId">
                            <div>
                                <button type="button" class="btn btn-primary float-end" onclick="updateProduct()">Update
                                    Product</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>