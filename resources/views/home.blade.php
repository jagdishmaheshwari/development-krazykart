@extends('app')

@section('title', 'Krazy Kart')

@section('content')
    <div class="owl-carousel main owl-theme pt-0">
        @if (count($HomeCarouselData['Items']) > 0)
            @foreach ($HomeCarouselData['Items'] as $Item)
                <div class="item d-flex align-items-center justify-content-center"
                    style="height:400px;max-height: 50vh; position: relative; overflow: hidden;background-opacity:0.2;background: {{ $Item->color_code }}c9">
                    <img src="{{ reset($Item->item_images) }}" alt="Slide 1"
                        style="width: auto; height: 100% !important; object-fit: cover; object-position: center;">
                    <div class="gradient-overlay d-flex justify-content-center align-items-center"
                        onmouseover="this.classList.add('hovered')" onmouseout="this.classList.remove('hovered')">
                        <div class="text-light text-center mt-5">
                            <div class="text-light display-6 text-center">{{ $Item->category_name }}</div>
                            <div class="px-4 h6 d-block"
                                style="width: 450px; max-height: calc(3 * 1.2em); overflow: hidden; text-overflow: ellipsis;">
                                {{ $Item->c_description }}
                            </div>
                            <div class="btn category btn-light btn-lg px-5 mt-4" categoryName="">Explore More <i
                                    class="fa fa-arrow-right"></i></div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
    <div class="container-fluid bg-white my-4 p-5">
        <section class="about-us-section">
            <div class="row">
                <div class="col-md-6">
                    <h2>About Us</h2>
                    <p>Welcome to Krazy Kart, your ultimate destination for trendy and affordable fashion.</p>
                    <p>At Krazy Kart, we believe in making fashion accessible to everyone. Our carefully curated collections
                        cater to every style and occasion, ensuring you find exactly what you're looking for.</p>
                    <p>Whether you're browsing for the latest runway trends or classic wardrobe staples, we've got you
                        covered. Our commitment to quality and customer satisfaction drives everything we do.</p>
                </div>
                <div class="col-md-6">
                    <h2>Our Mission</h2>
                    <p>Our mission at Krazy Kart is simple: to inspire confidence through style. We strive to empower
                        individuals to express themselves through fashion, offering a diverse range of apparel and
                        accessories that speak to your unique personality.</p>
                    <p>We aim to provide an exceptional shopping experience with unparalleled customer service and a
                        seamless online platform. Your satisfaction is our priority, and we're constantly evolving to meet
                        your needs.</p>
                    <p>Join us on this fashionable journey and discover why Krazy Kart is your go-to destination for all
                        things style.</p>
                </div>
            </div>
        </section>
    </div>

    <div class="my-2 d-flex justify-between ps-2 text-md-center">
        <h3 class="text-sm-end">
            Our Famous Items
        </h3>
    </div>
    <div class="owl-carousel owl-theme famouse">
        @if (count($HomeCarouselData) > 0)
            @foreach ($HomeCarouselData['Items'] as $Item)
                <div class="item">
                    <div class="card product_card border-3 border border-white p-1" productCode="">
                        <span style="z-index:1" class="ms-2 h4 text-pri addFavourite position-absolute">
                            <i class="fas text-sec fa-heart"></i>
                            <!-- <i class="far fa-heart"></i> -->
                        </span>
                        <div class="image-container rounded-1 overflow-hidden">
                            <div class="loading-animation image"></div>
                            <img User loading="lazy" src="{{ reset($Item->item_images) }}"
                                onerror="$(this).hide();$('.image').show()" class="">
                        </div>
                        <div class="bg-white itemDetail">
                            <div style="height:3em" class="small">
                            </div>
                            <div class="row">
                                <div class="col-7 text-acc" style="font-size:20px">
                                    <div class="rating-container">
                                        <div class="rating-star bg-acc"></div>
                                        <div class="rating-level bg-sec" style="width:50px"></div>
                                    </div>
                                    <small><i class="fa fa-comment-dots text-pri"></i>(122)</small>
                                </div>
                                <div class="text-end col-5">
                                    <sub class="h6 text-sec"> <del>₹
                                        </del></sub>
                                    <div class="h5 text-pri"> ₹<span>
                                        </span>
                                    </div>
                                </div>
                                <div class="row ps-3 pe-0 moreDetails text-sec" style="dissplay:one">
                                    <div class="col-6">
                                        <small><i class="fa fa-ruler text-pri"></i>Size</small>
                                    </div>
                                    <div class="col-6 text-end">

                                        Color
                                        <span class="" style="font-size:9px">
                                            <i class="fa fa-circle text-pri"></i>
                                            <i class="fa fa-circle text-sec"></i>
                                            <span>
                                                <i class="fa fa-circle text-acc"></i>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="btn btn-primary bg-pri text-nue w-100">
                            MORE DETAILS <i class="fas fa-arrow-circle-right"></i>
                        </div>
                        <div>
                            <div class="form-switch">
                                <div class="form-check-reverse">
                                    <div class="form-check-reverse"></div>
                                </div>
                            </div>
                        </div>
                        <div class="btn btn-danger bg-sec mt-2 w-100"> ADD TO WISHCART <i class="fa fa fa-cart-plus"></i>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>



    <section class="team-section">
        <div class="container">
            <h2 class="text-center mb-5">Meet Our Team</h2>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="card mb-4">
                        <img src="https://via.placeholder.com/400x400" class="card-img-top" alt="Team Member">
                        <div class="card-body">
                            <h5 class="card-title">John Doe</h5>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card mb-4">
                        <img src="https://via.placeholder.com/400x400" class="card-img-top" alt="Team Member">
                        <div class="card-body">
                            <h5 class="card-title">Jane Smith</h5>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card mb-4">
                        <img src="https://via.placeholder.com/400x400" class="card-img-top" alt="Team Member">
                        <div class="card-body">
                            <h5 class="card-title">Michael Johnson</h5>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <script>
        $(document).ready(function() {
            function isElementInViewport(elem) {
                var rect = elem.getBoundingClientRect();
                return (
                    rect.top >= 0 &&
                    rect.left >= 0 &&
                    rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                    rect.right <= (window.innerWidth || document.documentElement.clientWidth)
                );
            }

            var box = $(".gradient-overlay");
            var hovered = false;

            $(window).on("scroll load", function() {
                if (isElementInViewport(box[0])) {
                    if (!hovered) {
                        setTimeout(function() {
                            box.addClass("hovered");
                        }, 2000);
                        hovered = true;
                    }
                } else {
                    hovered = false;
                    box.removeClass("hovered");
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.owl-carousel.main').owlCarousel({
                loop: false,
                margin: 5,
                nav: true,
                autoplay: true,
                // freeDrag: false,
                autoplayTimeout: 5000,
                autoplayHoverPause: true,
                nav: false,
                // center: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    800: {
                        items: 2
                    },
                    1000: {
                        items: 3
                    }
                },
                lazyLoad: true,
                onInitialized: function(event) {
                    $('.owl-item.active .loading-animation').hide();
                },
                onLazyLoaded: function(event) {
                    $('.owl-item.active .gradient-overlay').css('opacity', 1);
                }
            });
            $('.owl-carousel.famouse').owlCarousel({
                loop: false,
                margin: 5,
                nav: true,
                autoplay: true,
                autoplayTimeout: 3000,
                autoplayHoverPause: true,
                URLhashListener: true,
                startPosition: 'URLHash',
                autoplaySpeed: 1000,
                dots: false,
                scroll: true,
                nav: false,
                responsive: {
                    0: {
                        items: 1
                    },
                    300: {
                        center: true,
                        items: 1.5

                    },
                    600: {
                        items: 2
                    },
                    900: {
                        items: 3
                    },
                    1200: {
                        items: 5
                    }
                },
                onTranslate: function(event) {
                    var currentItemIndex = event.item.index;
                    var totalItems = event.item.count;

                    // Check if the current item is the last one
                    if (currentItemIndex === totalItems - 1) {
                        $('.owl-stage').css('transform', 'translate3d(10%, 0px, 0px)');
                    }
                }
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            // Iterate over each image container
            $('.image-container').each(function() {
                var $imgContainer = $(this);
                var $loadingAnimation = $imgContainer.find('.loading-animation');
                var $img = $imgContainer.find('img');

                // Check if the image is loaded successfully
                $img.on('load', function() {
                    // Show the image and hide the loading animation
                    $img.show();
                    $loadingAnimation.hide();
                }).on('error', function() {
                    // If the image fails to load, hide the image and show the loading animation
                    $img.hide();
                    $loadingAnimation.show();
                });
            });
        });
    </script>
@endsection
