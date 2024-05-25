 <div class="modal fade" id="editColorModal" tabindex="-1" aria-labelledby="editColorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editColorModalLabel">Edit Color</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Edit Color Form -->
                    <form id="editColorForm">
                        <div class="mb-3">
                            <label for="colorName" class="form-label">Color Name:</label>
                            <input type="text" class="form-control" id="colorName" name="color_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="colorCode" class="form-label">Color Code:</label>
                            <input type="color" class="form-control" id="colorCode" name="color_code"
                                style="height:70px !important" value="" required>
                            <input type="hidden" name="colorId" id="colorId" value="">
                        </div>
                        <div>
                            <input type="button" class="btn btn-primary float-end" onclick="updateColor()"
                                value="Update This Color">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>