 <div class="modal fade" id="editColorModal" tabindex="-1" aria-labelledby="editColorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h3 class="modal-title w-100 text-center" id="editColorModalLabel">Edit Color</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Edit Color Form -->
                    <form id="editColorForm">
                        <div class="mb-3 form-floating">
                            <input type="text" class="form-control" id="colorName" name="color_name" placeholder required>
                            <label for="colorName" class="form-label">Color Name:</label>
                        </div>
                        <div class="mb-3">
                            <label for="colorCode" class="form-label">Color Code:</label>
                            <input type="color" class="form-control" id="colorCode" name="color_code"
                                style="height:70px !important" value="" required>
                            <input type="hidden" name="colorId" id="colorId" value="">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="button" class="btn btn-success float-end" onclick="updateColor()"
                                value="Update Color">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>