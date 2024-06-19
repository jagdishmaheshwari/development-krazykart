@extends('layouts.admin')

@section('content')
<div class="image-upload-container">0
    <div class="d-flex flex-wrap">
        <?php
       // $imageSql = "SELECT * FROM item_images WHERE item_id = " . $itemId . " ORDER BY priority";
       // $imageResult = $conn->query($imageSql);
        // while ($imageRow = $imageResult->fetch_assoc()) {
        ?>
        <div class="image-container" style="max-width:140px; position: relative; margin: 10px;">
            <img src="../assets/item_images/<?php echo $imageRow['image_url'] ?>" class="w-100" alt="" style="border-radius: 8px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
            <div class="btns w-100 text-center" style="position:absolute;bottom:0;left: 50%; transform: translate(-50%, 55%);">
                <div class="">
                    <div class="btn btn-primary btn-sm" style="margin: 2px;"><i class="fa fa-edit"></i></div>
                    <div class="btn btn-danger btn-sm" style="margin: 2px;" onclick="window.location=('action_delete_item_image?imageUrl=<?php//echo $imageRow['image_url'] ?>&itemId=<?php echo $imageRow['item_id'] ?>')">
                        <i class="fa fa-trash"></i>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <div class="btn btn-secondary" style="margin: 2px;" onclick="editPriority('item_images','image_id','<?php//echo $imageRow['image_id'] ?>','minus')">
                        <i class="fa fa-angle-left"></i>
                    </div>
                    <div class="btn btn-light" style="margin: 2px;">
                        <?php echo $imageRow['priority']; ?>
                    </div>
                    <div class="btn btn-secondary" style="margin: 2px;" onclick="editPriority('item_images','image_id','<?php// echo $imageRow['image_id'] ?>','plus')">
                        <i class="fa fa-angle-right"></i>
                    </div>
                </div>
            </div>
        </div>
        <?php
        // }
        ?>
        <?php
        if ($imageResult->num_rows < 7) {
        ?>
        <form id="imageForm" method="POST" class="d-flex" action="action_upload_item_image" enctype="multipart/form-data" onsubmit="return validateFile()">
            <div class="file-input-container">
                <label class="d-flex opacity-75 align-items-center justify-content-center flex-column text-center upload-label" for="imageInput">
                    <i class="fa fa-upload" style="font-size:40px"></i>
                    <h3>Upload<br>Image/Video</h3>
                </label>
                <input type="file" onchange="validateFile()" id="imageInput" class="d-none" name="image" accept="image/jpeg,image/png,image/jpg,video/mp4" required>
                <input type="hidden" name="itemId" value="<?php echo $itemId ?>">
            </div>
        </form>
        <?php } ?>
    </div>
</div>

<style>
.image-upload-container {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.upload-label {
    cursor: pointer;
    background-color: #f8f9fa;
    border: 2px dashed #ced4da;
    border-radius: 8px;
    padding: 20px;
    transition: background-color 0.3s ease;
}

.upload-label:hover {
    background-color: #e9ecef;
}

.file-input-container {
    margin: 10px;
}
</style>


@endsection
