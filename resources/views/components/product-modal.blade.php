<!-- ProductForm.blade.php -->
@props([
    'modalId' => 'addProductModal',
    'modalLabel' => 'addProductModalLabel',
    'modalTitle' => 'Add Product',
    'submitAction' => 'addProduct()',
    'submitLabel' => 'Add Product',
    'categoryList'
])

<div class="modal fade p-0 p-sm-5" id="{{ $modalId }}" tabindex="1" aria-labelledby="{{ $modalLabel }}"
    styl="" aria-hidden="tru">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $modalLabel }}">{{ $modalTitle }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="productForm">
                    <!-- Category selection -->
                    <div class="mb-3 form-floating">
                        <select class="form-control" id="categoryId" name="categoryId">
                            <option value="" disabled selected>Select Category</option>
                            @foreach ($categoryList as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <label for="categoryId">Select Category</label>
                    </div>
                    <!-- Product Code -->
                    <div class="mb-3 form-floating">
                        <input type="text" class="form-control" oninput="$(this).val($(this).val().toUpperCase())"
                            id="productCode" name="productCode" placeholder="Product Code" required
                            value="{{ $product->code ?? '' }}">
                        <label for="productCode" class="form-label">Product Code:</label>
                    </div>
                    <!-- Product Name and Priority -->
                    <div class="mb-3 row">
                        <div class="col-8">
                            <div class="form-floating">
                                <input type="text" class="form-control col-8" placeholder="Product Name"
                                    id="productName" name="productName" required value="{{ $product->name ?? '' }}">
                                <label for="productName" class="form-label col-8">Product Name:</label>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-floating">
                                <input type="number" id="priority" class="form-control col-4" placeholder="Priority"
                                    name="priority" value="{{ $product->priority ?? '' }}">
                                <label for="priority" class="form-label col-4">Priority:</label>
                            </div>
                        </div>
                    </div>
                    <!-- Gender Selection -->
                    <div class="mb-3">
                        <label for="gender" class="form-label">Suitable For Gender:</label>
                        <div>
                            <input type="radio" name="gender" id="female" class="form-check-input" value="f"
                                {{ isset($product) && $product->gender === 'f' ? 'checked' : '' }}>
                            <label for="female"> Female</label>
                            <input type="radio" name="gender" id="male" class="form-check-input" value="m"
                                {{ isset($product) && $product->gender === 'm' ? 'checked' : '' }}> <label
                                for="male">
                                Male</label>
                            <input type="radio" name="gender" id="everyone" class="form-check-input" value="a"
                                {{ isset($product) && $product->gender === 'a' ? 'checked' : '' }}> <label
                                for="everyone">
                                Everyone</label>
                        </div>
                    </div>
                    <!-- Description -->
                    <div class="mb-3 form-floating">
                        <textarea type="product" class="form-control" id="description" name="description" style="height:70px !important"
                            required>{{ $product->description ?? '' }}</textarea>
                        <label for="description" class="form-label">Description:</label>
                    </div>
                    <!-- Keywords -->
                    <div class="mb-3 form-floating">
                        <textarea name="keywords" id="keywords" cols="30" rows="2" class="form-control">{{ $product->keywords ?? '' }}</textarea>
                        <label for="keywords" class="form-label">Keywords:</label>
                    </div>
                    <!-- Submit Button -->
                    <div>
                        <button type="button" class="btn btn-primary float-end"
                            onclick="{{ $submitAction }}">{{ $submitLabel }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
