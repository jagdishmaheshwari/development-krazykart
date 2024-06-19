@extends('layouts.admin')

@section('content')
    <link rel="stylesheet" href="/css/owl_carousel.min.css">
    <style>
        /* Custom styles for gallery */
        .itemsContainer {
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

        #category_selection .item,
        #item_selection .item,
        #product_selection .item {
            text-align: center;
            background: #fff;
            padding: 20px;
        }

        #category_selection .item:hover,
        #item_selection .item:hover,
        #product_selection .item:hover {
            cursor: pointer;
            background: #e6e6e6;
            border-radius: 10px;

        }

        #category_selection .item img,
        #item_selection .item img,
        #product_selection .item img {
            width: 100%;
            max-width: fit-content;
            height: auto;
            max-height: 130px;
            border-radius: 5px;
        }

        #category_selection .item h4,
        #item_selection .item h4,
        #product_selection .item h4 {
            margin-top: 10px;
            font-size: 12px;
        }

        #category_selection .selected,
        #item_selection .selected,
        #product_selection .selected {
            border-radius: 10px;
            border: 3px solid var(--acc);
        }
    </style>
    <div class="container">
        <h1 class="text-center">{{ $CollectionData->CollectionName }}</h1>
        <div class="mb-2 d-flex justify-content-end">
            {{-- <h2>Manage Collections</h2> --}}
            <div>
                <div class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addItemToCollectionModal">
                    <i class="fa fa-plus"></i> Add Item
                </div>
                <button type="button" class="btn btn-primary" id="saveCollectionForm"
                    onclick="$('#collectionForm').submit()">Save</button>
            </div>
        </div>
        <form id="collectionForm">
            @csrf
            <div id="selected_items" class="owl-carousel">
                <?php if(isset($CollectionData->Items) AND count($CollectionData->Items) > 0){ ?>
                @foreach ($CollectionData->Items as $Items)
                    <div class="container itemsContainer">
                        <div class="gallery-item"><img class="galary-img" data-fancybox="gallery"
                                src="{{ reset($Items->item_images) }}"
                                onerror="this.src='/img/image-placeholder-300-500.jpg'">
                            <div class="gallery-buttons"><button
                                    class="fa fa-arrow-alt-circle-left move-left"></button><button id="deleteImageButton"
                                    class="fa fa-trash delete" data-id={{ $Items->item_id }} data-item-id="3"></button><button
                                    class="fa fa-arrow-alt-circle-right move-right"></button></div>
                        </div>
                        <input type="hidden" name="item[]" value="{{ $Items->item_id }}" alt="Item Image">
                    </div>
                @endforeach
                <?php } ?>
            </div>
            <input type="hidden" name="collection_id" value='{{ $CollectionData->CollectionId }}'>
        </form>
    </div>
    {{-- Add item to collection modal Start --}}
    <div class="modal fade" id="addItemToCollectionModal" tabindex="-1" role="dialog"
        aria-labelledby="addItemToCollectionLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl mmmodal-fullscreen" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h3 class="modal-title w-100 text-center">Add Item to Collection</h3>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-9">
                            <div id="category_selection" class="owl-carousel"></div>
                            <div id="product_selection" class="owl-carousel"></div>
                            <div id="item_selection" class="owl-carousel"></div>
                        </div>
                        <div class="col-12 col-md-3">
                            {{-- //<form action="" id="collectionForm">
                                //@csrf
                                //<div id="selected_items" class="owl-carousel"></div>
                                //<input type="hidden" name="collection_id" value='{{ $CollectionData->CollectionId }}'>
                            //</form> --}}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Add item to collection modal End --}}
    <script src="/js/owl_carousel.min.js"></script>
    <script>
        $(document).ready(function() {
            $.ajax({
                url: "{{ route('admin.categories.list.ajax') }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    $.each(data, function(index, item) {
                        var imageUrl = item.image_url ? '{{ asset('storage') }}/' + item
                            .image_url :
                            '/img/image-placeholder-300-500.jpg'; // Replace with your default image
                        var slideContent = '<div class="item category" data-id="' + item
                            .category_id + '" >' +
                            '<img src="' + imageUrl + '">' +
                            '<h4>' + item.category_name + '</h4>' +
                            '</div>';
                        $('#category_selection').append(slideContent);
                    });
                    $('#category_selection').owlCarousel({
                        loop: false,
                        margin: 20,
                        nav: false,
                        dots: false,
                        autoplay: false,
                        // autoplayTimeout: 3000,
                        // autoplayHoverPause: true,
                        responsive: {
                            0: {
                                items: 4
                            },
                            600: {
                                items: 6
                            },
                            1000: {
                                items: 8
                            }
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.log('Error:', error);
                }
            });
            $('#category_selection').on('click', '.category', function() {
                $('#category_selection .category').removeClass('selected');
                $('#item_selection').html('');
                // Add 'selected' class to the clicked category
                $(this).addClass('selected');
                categoryId = $(this).closest('[data-id]').data('id');
                $.ajax({
                    url: "{{ route('admin.product.list.ajax') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        categoryId: categoryId
                    },
                    success: function(data) {

                        if ($('#product_selection').hasClass('owl-loaded')) {
                            $('#product_selection').trigger('destroy.owl.carousel').removeClass(
                                'owl-loaded');
                            $('#product_selection').find('.owl-stage-outer').children()
                                .unwrap();
                        }

                        // Clear the previous content
                        $('#product_selection').html('');

                        $.each(data, function(index, item) {
                            var imageUrl = item.image_url ? '{{ asset('storage') }}/' +
                                item
                                .image_url :
                                '/img/image-placeholder-300-500.jpg'; // Replace with your default image
                            var slideContent = '<div class="item product" data-id="' +
                                item.product_id + '" >' +
                                '<img src="' + imageUrl + '">' +
                                '<h4>' + item.product_name + '</h4>' +
                                '</div>';
                            $('#product_selection').append(slideContent);
                        });
                        $('#product_selection').owlCarousel({
                            loop: false,
                            margin: 20,
                            nav: false,
                            dots: false,
                            autoplay: false,
                            // autoplayTimeout: 3000,
                            // autoplayHoverPause: true,
                            responsive: {
                                0: {
                                    items: 4
                                },
                                600: {
                                    items: 6
                                },
                                1000: {
                                    items: 8
                                }
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.log('Error:', error);
                    }
                });
            });
            $('#product_selection').on('click', '.product', function() {
                $('#product_selection .product').removeClass('selected');

                // Add 'selected' class to the clicked product
                $(this).addClass('selected');
                productId = $(this).closest('[data-id]').data('id');
                $.ajax({
                    url: "{{ route('admin.items.list.ajax') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        productId: productId
                    },
                    success: function(data) {

                        if ($('#item_selection').hasClass('owl-loaded')) {
                            $('#item_selection').trigger('destroy.owl.carousel').removeClass(
                                'owl-loaded');
                            $('#item_selection').find('.owl-stage-outer').children()
                                .unwrap();
                        }

                        // Clear the previous content
                        $('#item_selection').html('');

                        $.each(data, function(index, item) {
                            var imageUrl = item.image_url ? '{{ asset('storage') }}/' +
                                item
                                .image_url :
                                '/img/image-placeholder-300-500.jpg'; // Replace with your default image
                            var slideContent = '<div class="item " data-id="' +
                                item.item_id + '" >' +
                                '<img src="' + imageUrl + '">' +
                                '<div class="btn btn-primary addToCollection">Add</div>' +
                                '</div>';
                            $('#item_selection').append(slideContent);
                        });
                        $('#item_selection').owlCarousel({
                            loop: false,
                            margin: 20,
                            nav: true,
                            dots: false,
                            autoplay: false,
                            // autoplayTimeout: 3000,
                            // autoplayHoverPause: true,
                            responsive: {
                                0: {
                                    items: 4
                                },
                                600: {
                                    items: 6
                                },
                                1000: {
                                    items: 8
                                }
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.log('Error:', error);
                    }
                });
            });
            var $owlCarousel = $('#selected_items').owlCarousel({
                loop: false,
                margin: 20,
                nav: false,
                dots: false,
                autoplay: false,
                // autoplayTimeout: 3000,
                // autoplayHoverPause: true,
                responsive: {
                    0: {
                        items: 3
                    },
                    600: {
                        items: 4
                    },
                    1000: {
                        items: 6
                    }
                }
            });
            $owlCarousel.trigger('add.owl.carousel', []).trigger('refresh.owl.carousel');
            $('#item_selection').on('click', '.addToCollection', function() {
                var $closestItem = $(this).closest('[data-id]');
                var dataId = $closestItem.data('id');
                var imageUrl = $closestItem.find('img').attr('src');

                // Check if the item with the same data-id is already in #collectionForm .items
                if ($('#collectionForm #selected_items [data-id="' + dataId + '"]').length === 0) {
                    // Create a new element with the collected data-id and image URL
                    var newItem = '<div class="item" data-id="' + dataId + '">' +
                        '<img src="' + imageUrl + '" alt="Item Image">' +
                        '<input type="hidden" name="item[]" value="' + dataId + '" alt="Item Image">' +
                        '</div>';
                    // $('#collectionForm #selected_items').append(newItem);
                    $owlCarousel.trigger('add.owl.carousel', [$(newItem)]).trigger('refresh.owl.carousel');
                }
                // $('#addItemToCollectionModal').modal('hide');
            });
            $('#collectionForm').on('submit', function(e) {
                e.preventDefault();
            });
            $('#saveCollectionForm').on('click', function(e) {
                e.preventDefault();

                // Serialize form data
                var formData = $('#collectionForm').serialize();

                // Submit form data via Ajax
                $.ajax({
                    url: '{{ route('admin.collection.item.add') }}', // Replace with your Laravel route
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        showActionAlert(response.success);
                        window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.error(error);
                    }
                });
            });
            $('#collectionForm').on('click', '.move-left', function() {
                let current = $(this).closest('.owl-item');
                let prev = current.prev('.owl-item');
                if (prev.length) {
                    current.insertBefore(prev).hide().fadeIn('slow');
                    getImageOrder()
                }
            });

            $('#collectionForm').on('click', '.move-right', function() {
                let current = $(this).closest('.owl-item');
                let next = current.next('.owl-item');
                if (next.length) {
                    current.insertAfter(next).hide().fadeIn('slow');
                    getImageOrder();
                }
            });

            // Event listener for delete button with confirmation
            $('.delete').click(function() {
                if (confirm('Are you sure you want to delete this image?')) {
                    $(this).closest('.owl-item').fadeOut('slow', function() {
                        $(this).remove();
                    });
                }
            });

        });
    </script>
@endsection
