    <!-- MANAGE IMAGES MODAL START-->
    <div class="modal fade" id="uploadImageModal" tabindex="-1" role="dialog" aria-labelledby="uploadImageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl " role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h3 class="modal-title w-100 text-center" id="addItemModalLabel">Manage Item Images</h3>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="imageContainer" class="container">
                        {{-- Image container --}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveImageChanges">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- MANAGE IMAGES MODAL END-->
    <link rel="stylesheet" href="/css/fancybox.css">
    <style>
        /* Custom styles for gallery */
        #imageContainer {
            display: flex;
            flex-wrap: wrap;
        }

        .image-wrapper img {
            width: 150px;
        }

        .galary-img {
            max-width: 100%;
            object-fit: cover;
            height: 100%;
            width: auto;
            display: block;
            margin: 0 auto;
            position: relative;
            top: 50%;
            transform: translateY(-50%);
        }

        .gallery-item {
            padding: 5px;
            position: relative;
            transition: transform 0.3s ease;
            display: flex;
            justify-content: center
        }

        .gallery-buttons {
            position: absolute;
            bottom: 10px;
            left: 10px;
            right: 10px;
            display: flex;
            justify-content: space-between;
        }

        .gallery-buttons button {
            background: #00000077;
            border: none;
            color: white;
            padding: 7px;
            border-radius: 50%;
        }

        .gallery-item.active {
            border: 2px solid #007bff;
            transform: scale(1.05);
        }

        .gallery-buttons button:disabled {
            background: rgba(161, 146, 146, 0.2);
            color: #ffffffaf;
            cursor: not-allowed;
        }

        .upload-btn {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            min-height: 150px !important;
            width: 100%;
            border: 2px dashed #ddd;
            border-radius: 5px;
            color: #aaa;
            font-size: 20px;
            cursor: pointer;
        }

        .upload-btn:hover {
            background-color: #f7f7f7;
        }
    </style>








    {{-- <script src="/js/fancybox.js"></script> --}}

    <script>
        function openImagePopup(itemId) {
            const imageContainer = document.getElementById('imageContainer');
            const imageItemId = $('#uploadImageModal #itemId');

            // Clear any existing images in the container
            imageContainer.innerHTML = '';
            // Set the item ID in the hidden input
            imageItemId.val(itemId);


            $.ajax({
                url: '{{ route('admin.item.images') }}',
                method: 'POST',
                data: {
                    item_id: itemId,
                    _token: '{{ csrf_token() }}'

                },
                success: function(response) {
                    response.image_urls.forEach((imageUrls) => {
                        Object.entries(imageUrls).forEach(([imageId, url]) => {
                            const imageWrapper = document.createElement('div');
                            imageWrapper.className = 'col-6 col-lg-2 gallery-item';
                            const image = document.createElement('img');
                            image.className = 'galary-img';
                            image.setAttribute('data-fancybox', 'gallery');
                            image.src = url;

                            const buttonWrapper = document.createElement('div');
                            buttonWrapper.className = 'gallery-buttons';

                            const moveLeftButton = document.createElement('button');
                            // moveLeftButton.setAttribute('id', 'move-left', 'move-right');
                            moveLeftButton.className = 'fa fa-arrow-alt-circle-left move-left';
                            // const moveLeftButton = document.createElement('move-left', 'Increase Priority',
                            //     'bi-arrow-left');
                            const deleteButton = document.createElement('button');
                            deleteButton.setAttribute('id', 'deleteImageButton');
                            deleteButton.className = 'fa fa-trash';
                            // const deleteButton = document.createElement('delete', 'Delete', 'bi-trash');
                            deleteButton.setAttribute('data-image-id', imageId);
                            deleteButton.setAttribute('data-item-id', itemId);
                            const moveRightButton = document.createElement('button');
                            moveRightButton.className =
                                'fa fa-arrow-alt-circle-right move-right';
                            // const moveRightButton = document.createElement('move-right', 'Decrease Priority', 'bi-arrow-right');

                            buttonWrapper.appendChild(moveLeftButton);
                            buttonWrapper.appendChild(deleteButton);
                            buttonWrapper.appendChild(moveRightButton);

                            imageWrapper.appendChild(image);
                            imageWrapper.appendChild(buttonWrapper);

                            imageContainer.appendChild(imageWrapper);


                            // if (imageUrls === 0) {
                            //     moveLeftButton.disabled = true;
                            // }

                            // // Disable move-right button if index is the last item
                            // if (imageUrls === response.image_urls.length - 1) {
                            //     moveRightButton.disabled = true;
                            // }
                        });
                    });

                    if (Object.keys(response.image_urls).length < 7) {
                        const imageInputForm = document.createElement('form');
                        imageInputForm.id = 'imageForm';
                        imageInputForm.classList = 'col-6 col-lg-2 gallery-ite';
                        imageInputForm.method = 'POST';
                        imageInputForm.classList.add('d-flex');
                        imageInputForm.action = 'action_upload_item_image';
                        imageInputForm.enctype = 'multipart/form-data';

                        // const fileInputContainer = document.createElement('div');
                        // fileInputContainer.classList.add('file-input-container');

                        const label = document.createElement('label');
                        label.classList = 'upload-btn d-flex ';
                        // label.classList.add('d-flex', 'align-items-center',
                        //     'justify-content-center', 'flex-column',
                        //     'text-center');
                        label.setAttribute('for', 'imageInput');

                        const icon = document.createElement('i');
                        // icon.classList.add('fa', 'fa-upload');
                        icon.style.fontSize = '40px';

                        const heading = document.createElement('h3');
                        heading.innerHTML = 'Upload Image';

                        label.appendChild(icon);
                        label.appendChild(heading);

                        const fileInput = document.createElement('input');
                        fileInput.type = 'file';
                        fileInput.id = 'imageInput';
                        fileInput.classList.add('d-none');
                        fileInput.name = 'image';
                        fileInput.accept = 'image/*';
                        fileInput.required = true;
                        fileInput.multiple = true;

                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.id = 'itemId';
                        hiddenInput.name = 'itemId'; // Ensure this name matches your form handling
                        hiddenInput.value = itemId;

                        imageInputForm.appendChild(label);
                        imageInputForm.appendChild(fileInput);
                        imageInputForm.appendChild(hiddenInput);

                        imageContainer.appendChild(imageInputForm);
                        // Disable right button if it's the last item
                    };
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching image URLs:', error);
                }
            }).then(function() {
                // Show the modal
                $('#uploadImageModal').modal('show');
            });
        }


        $(document).ready(function() {
            // $('[data-fancybox="gallery"]').fancybox({
            //     thumbs: {
            //         autoStart: true
            //     }
            // });
            $('[data-toggle="tooltip"]').tooltip();


            // Initialize tooltips
            $('[data-bs-toggle="tooltip"]').tooltip();

            // Function to update the image order array and button states
            function getImageOrder() {
                let imageOrder = [];
                $('#imageContainer .gallery-item').each(function(index) {
                    imageOrder.push({
                        imageId: $(this).find('[data-image-id]').data('image-id'),
                        order: index
                    });

                    // Disable left button if it's the first item
                    $(this).find('.move-left').prop('disabled', index === 0);

                    // Disable right button if it's the last item
                    $(this).find('.move-right').prop('disabled', index === $('#gallery .gallery-item')
                        .length - 1);
                });
                return imageOrder;
            }
            $('#saveImageChanges').on('click', function() {
                data = {};
                data.imageOrder = getImageOrder();
                data._token = '{{ csrf_token() }}';
                $.ajax({
                    url: '{{ route('admin.item.image.order') }}',
                    data: data,
                    type: 'PUT',
                    success: function(response) {
                        $('#uploadImageModal').modal('hide');
                        showActionAlert(response.success);
                        window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        showActionAlert(error, status);
                    }
                });
            })

            // Event listeners for move-left and move-right buttons
            $('#imageContainer').on('click', '.move-left', function() {
                let current = $(this).closest('.gallery-item');
                let prev = current.prev('.gallery-item');
                if (prev.length) {
                    current.insertBefore(prev).hide().fadeIn('slow');
                    getImageOrder()
                }
            });

            $('#imageContainer').on('click', '.move-right', function() {
                let current = $(this).closest('.gallery-item');
                let next = current.next('.gallery-item');
                if (next.length) {
                    current.insertAfter(next).hide().fadeIn('slow');
                    getImageOrder();
                }
            });

            // Event listener for delete button with confirmation
            $('.delete').click(function() {
                if (confirm('Are you sure you want to delete this image?')) {
                    $(this).closest('.gallery-item').fadeOut('slow', function() {
                        $(this).remove();
                    });
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#uploadImageModal').on('change', '#imageInput', function() {
                const files = this.files;
                const formData = new FormData();
                itemId = $('#uploadImageModal #itemId').val();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('item_id', itemId);
                formData.append('priority', 0);
                for (let i = 0; i < files.length; i++) {
                    formData.append('images[]', files[i]);
                }
                // formData.append('image', file);
                $.ajax({
                    url: '{{ route('admin.item.image.upload') }}',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        showActionAlert(response.success ?? response.error, response.success ? 'success': 'error');
                        openImagePopup(itemId);
                    },
                    error: function(xhr, status, error) {
                        showActionAlert(error + '!', status);
                    }
                });
            });
            $('#uploadImageModal').on('click', '#deleteImageButton', function() {
                const imageId = $(this).data('image-id');
                const itemId = $(this).data('item-id');
                $.ajax({
                    url: '{{ route('admin.item.image.delete') }}',
                    type: 'DELETE',
                    data: {
                        image_id: imageId,
                        item_id: itemId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        showActionAlert(response.success);
                        openImagePopup(itemId);
                    },
                    error: function(response) {
                        swal('Error!', response.responseJSON.message, 'error');
                    }
                });
            });
        });
    </script>


























    {{-- <script>
    function openImagePopup(itemId) {
        const imageContainer = document.getElementById('imageContainer');
        const imageItemId = $('#uploadImageModal #itemId');

        // Clear any existing images in the container
        imageContainer.innerHTML = '';
        // Set the item ID in the hidden input
        imageItemId.val(itemId);

        // Send AJAX request to fetch image URLs
        $.ajax({
            url: '{{ route('admin.item.images') }}',
            method: 'POST',
            data: {
                item_id: itemId,
                _token: '{{ csrf_token() }}'

            },
            success: function(response) {
                const imageUrls = response.image_urls;

                // Loop through the image URLs and create img elements
                Object.entries(imageUrls).forEach(([imageId, url]) => {
                    const imageWrapper = document.createElement('div');
                    imageWrapper.classList.add('image-wrapper');

                    const img = document.createElement('img');
                    img.src = url;
                    img.onerror = function() {
                        this.src = '/img/image-placeholder-300-500.jpg';
                    };
                    img.classList.add('images_preview');

                    // Set data-image-id attribute
                    img.setAttribute('data-image-id', imageId);

                    const sequenceButton = document.createElement('button');
                    sequenceButton.textContent = 'Change Sequence';
                    sequenceButton.classList.add('sequence-button');
                    sequenceButton.onclick = function() {
                        // Handle changing sequence logic
                        // You can define your own logic for changing sequence
                        // console.log('Change sequence clicked for image ID:', imageId);
                    };

                    const deleteButton = document.createElement('button');
                    deleteButton.textContent = 'Delete';
                    deleteButton.setAttribute('id', 'deleteImageButton');
                    deleteButton.setAttribute('data-image-id', imageId);
                    deleteButton.setAttribute('data-item-id', itemId);

                    const buttonContainer = document.createElement('div');
                    buttonContainer.classList.add('button-container');
                    buttonContainer.appendChild(sequenceButton);
                    buttonContainer.appendChild(deleteButton);

                    imageWrapper.appendChild(img);
                    imageWrapper.appendChild(buttonContainer);
                    imageContainer.appendChild(imageWrapper);
                });
                if (Object.keys(imageUrls).length < 7) {
                    const imageInputForm = document.createElement('form');
                    imageInputForm.id = 'imageForm';
                    imageInputForm.method = 'POST';
                    imageInputForm.classList.add('d-flex');
                    imageInputForm.action = 'action_upload_item_image';
                    imageInputForm.enctype = 'multipart/form-data';

                    const fileInputContainer = document.createElement('div');
                    fileInputContainer.classList.add('file-input-container');

                    const label = document.createElement('label');
                    label.classList.add('d-flex', 'opacity-75', 'align-items-center',
                        'justify-content-center', 'flex-column',
                        'text-center');
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
            },
            error: function(xhr, status, error) {
                console.error('Error fetching image URLs:', error);
            }
        }).then(function() {
            // Show the modal
            $('#uploadImageModal').modal('show');
        });
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
                url: '{{ route('admin.item.image.upload') }}',
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
        $('#uploadImageModal').on('click', '#deleteImageButton', function() {

            const imageId = $(this).data('image-id');
            const itemId = $(this).data('item-id');

            // if (!basicConfirmPopup('Are you sure you want to delete this image ?')) {
            //     return;
            // }
            $.ajax({
                url: '{{ route('admin.item.image.delete') }}',
                type: 'DELETE',
                data: {
                    image_id: imageId,
                    item_id: itemId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#imagePreview').attr('src', '/img/image-placeholder-300-500.jpg');
                },
                error: function(response) {
                    swal('Error!', response.responseJSON.message, 'error');
                }
            });
        });
    });
</script> --}}
