<link rel="stylesheet" href="/css/summernote.min.css">
<!-- Add Stock Modal -->
<div class="modal fade" id="productDetailHtmlModal" aria-labelledby="productDetailHtmlModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h3 class="modal-title w-100 text-center" id="productDetailHtmlModalLabel">Add Stock<span class="itemId"></span>
                </h3>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="manageDetail">
                    <textarea name="productDetailHtml" id="productDetailHtml" cols="30" rows="10"></textarea>
                    <input type="hidden" value="" id="productId">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveProductDetails">Save</button>
            </div>
        </div>
    </div>
</div>
<!------------------------------------------- MODAL END------------------------------------------------->
<script src="/js/summernote.min.js"></script>
<script>
    $(document).ready(function() {
        $('#productDetailHtml').summernote();
    });
    $('#saveProductDetails').on('click', function() {
        $('#manageDetail').submit(); // Trigger form submission on button click
    });
</script>
<script>
    // Function to retrieve and display item details in the modal
    function getProductDetailHtml(productId) {
        // AJAX request to the server
        $.ajax({
            url: '{{ route('admin.product.html') }}', // Replace with your server endpoint
            type: 'POST',
            data: {
                productId: productId,
                _token: "{{ csrf_token() }}" // Include CSRF token
            },
            success: function(response) {
                $('#manageDetail #productId').val(productId);
                $('#manageDetail #productDetailHtml').summernote('code', response);
                $('#productDetailHtmlModal').modal('show');
            },
            error: function(xhr, status, error) {
                showActionAlert(error, status);
            }
        });
    }
</script>
