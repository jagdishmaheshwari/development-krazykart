 <!-- Add Product Modal -->
        <div class="modal fade p-0 p-sm-5" id="addProductModal" tabindex="1" aria-labelledby="addProductModalLabel"
            styl="" aria-hidden="tru">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProductModalLabel">Add Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addProductForm">
                            <div class="mb-3 form-floating">
                                <select class="form-control" id="categoryId" disabled name="categoryId">
                                    <option value="" disabled selected>Select Category</option>
                                    @foreach ($categoryList as $category)
                                    <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                                <label for="categoryId">Select Category</label>
                            </div>
                            <div class="mb-3 form-floating">
                                <input type="text" class="form-control" oninput="$(this).val($(this).val().toUpperCase())"
                                id="productCode" name="" placeholder required>
                                <label for="productCode" class="form-label">Product Code:</label>
                            </div>
                            <div class="mb-3 row">
                                <div class="col-8">
                                    <div class="form-floating">
                                        <input type="text" class="form-control col-8" placeholder id="productName" required>
                                        <label for="productName" class="form-label col-8">Product Name:</label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-floating">
                                        <input type="number" id="priority" class="form-control col-4" placeholder>
                                        <label for="productName" class="form-label col-4">Priority:</label>
                                    </div>
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
                            <div class="mb-3 form-floating">
                                <textarea type="product" class="form-control" id="description" name="description"
                                style="height:70px !important" required></textarea>
                                <label for="productCode" class="form-label">Description:</label>
                            </div>
                            <div class="mb-3 form-floating">
                                <textarea name="" id="keywords" cols="30" placeholder rows="2" class="form-control"></textarea>
                                <label for="keywords" class="form-label">Keywords:</label>
                            </div>
                            <div>
                                <button type="button" class="btn btn-primary float-end" onclick="addProduct()">Add
                                    Product</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>