<!-- Add Color Modal -->
    <div class="modal fade" id="addColorModal" tabindex="1" aria-labelledby="addColorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addColorModalLabel">Add Color</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Add Color Form -->
                    <form id="addColorForm">
                        <div class="mb-3">
                            <label for="colorName" class="form-label">Color Name:</label>
                            <input type="text" class="form-control" id="colorName" required>
                        </div>
                        <div class="mb-3">
                            <label for="colorCode" class="form-label">Color Code:</label>
                            <input type="color" class="form-control" id="colorCode" style="height:70px !important" required>
                        </div>
                        <div>
                            <button type="button" class="btn btn-primary float-end" onclick="addColor()">Add Color</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>