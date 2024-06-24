@extends('app')
<?php $ActivePage = ''; ?>
@section('title', 'Krazy Kart')

@section('content')
    <?php
// $ActivePage = "product";
// if (isset($_GET['pc'])) {
// include ('header.php');
// include ('validator.php');
// $productCode = filterInput($_GET['pc']);
// $itemCondition = " product_code = '$productCode' GROUP BY item_list.product_id LIMIT 1 ";
// $sid = @$_GET['sid'] ? base64_decode(filterInput($_GET['sid'])) : '';
// $Product = getItem();
// $Product = @$Product[0];
// logVisitor($conn, $Product['item_id']);
// foreach ($Product as $Product) {
if ($Product) {
// prd($Product);
?>
    {{-- -------------------------- Full Screen Modal Start-----------------------------------  --}}
    <div id="fullscreenModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div id="fullscreenCarousel" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            {{-- Images will be added dynamically here  --}}
                        </div>
                        <a class="carousel-control-prev" href="#fullscreenCarousel" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#fullscreenCarousel" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- --------------------------------Full Screen Modal End----------------------------------- --}}
    <div class="bg-white">
        <div class=" bg-white m-0 product_varients d-flex flex-wrap">
            <div class=" m-0 rounded-0 col-12 col-md-4">
                <span style="z-index:1" class="text-white addFavourite position-absolute">
                    <i class="fas text-sec fa-heart"></i><br>
                    <div class="text-pri" id="shareButton"><i class="fa fa-share c-pointer"></i></div>
                </span>
                <div class="image-container rounded-1 images-overflow-scroll ui-effects-transfer" id="effect">
                    <div class="loading-animation"></div>
                    <?php foreach ($Product->item_images as $itemImage) { ?>
                    <img class="fullscreen-image" loading="lazy" draggable="false" style="" src="<?php echo $itemImage; ?>"
                        onerror="$(this).hide();$('.image<?php echo 'default_image'; ?>').show()">
                    <?php } ?>
                </div>
                <div class="sticky_buttons row row-cols-2 mt-lg-3">
                    <div class="btn add_wishkart addToCart" id="add_wishkart" data-product="{{ $Product->item_id }}"><i
                            class="fa fa-cart-plus"></i> ADD TO
                        WISHCART
                    </div>
                    <div class="btn <?php if ($Product->stock == 0) {
                        echo 'out_of_stock';
                    } else {
                        echo 'buy_now';
                    } ?>">
                        <?php if ($Product->stock == 0) {
                            echo "NOTIFY ME <i class='far fa-bell'></i>";
                        } else {
                            echo 'BUY NOW <i class="fas fa-bolt"></i>';
                        } ?>
                    </div>
                </div>

            </div>
            {{-- data-bs-toggle="collapse" data-bs-target="#specification"  --}}
            <div class="row overflow-hidden bg-white bg-white rounded-0 col-12 mt-3 px-3 col-md-8">
                <div class="bg-white detail overflow-hidden">
                    <div class="h4">
                        <?php echo $Product->product_name; ?> (
                        <?php echo $Product->color_name; ?>)
                    </div>
                    <div class="row">
                        <div class="col-7 " style="font-size:20px">
                            <div class="rating-container" style="scale:1.1">
                                <div class="rating-star bg-acc"></div>
                                <div class="rating-level bg-sec" style="width:50px"></div>
                            </div>
                            <small><i class="fa fa-comment-dots h2 text-pri"></i>(122)</small>
                            <span class="text-sec h6">
                                <?php if ($Product->stock == 0) {
                                    echo 'Out Of Stock';
                                } elseif ($Product->stock <= 5) {
                                    echo $Product->stock . ' Left';
                                }
                                ?>
                            </span>
                        </div>
                        <div class="text-end col-5">
                            <sub class="h2 text-sec"> <del id="del">₹
                                    <?php echo $Product->mrp; ?>
                                </del></sub>
                            <div class="h1 text-pri"> ₹<span>
                                    <?php echo $Product->price; ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="h6">Color :
                    <?php echo $Product->color_name; ?>
                </div>
                <div class="color_option">
                    <?php if(false){ $colors = getDetails($conn, itemCondition: "product_code = '$productCode' AND item_list.visible = 1 GROUP BY color_id");
                    if (count($colors) > 1) {
                        foreach ($colors as $color) { ?>
                    <div href="product?pc=<?php echo $color['product_code']; ?>&sid=<?php echo base64_encode(urlencode($color['item_id'])); ?>" class="color rounded-2 m-1 py-1"
                        style="box-shadow: inset 0 0 5px <?php echo $color['color_code']; ?>;">
                        <img draggable="false" src="assets/item_images/<?php echo $color['item_images'][0]; ?>" class="<?php if ($color['stock'] == 0) {
                            echo 'dotted';
                        } ?>">
                        <span class="text-pri <?php echo $Product['color_name'] == $color['color_name'] ? 'fw-bolder' : ''; ?>">
                            <?php echo $color['color_name']; ?>
                        </span>
                    </div>
                    <?php
                    }}
                    } ?>
                </div>
                <div class="my-2">
                    <div class="h6">Sizes :
                        <?php echo $Product->size_name; ?>
                    </div>
                    <div class="size_option">
                        <?php if(false){ $sizes = getDetails($conn, itemCondition: "product_code = '$productCode' AND item_list.visible = 1 GROUP BY size_id");
if (count($sizes) > 1) {
foreach ($sizes as $size) {
?>
                        <div href="product?pc=<?php echo $size['product_code']; ?>&sid=<?php echo base64_encode(urlencode($size['item_id'])); ?>"
                            class="size m-1 <?php echo $Product['size_code'] == $size['size_code'] ? 'bg-acc fw-bolder' : ''; ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="<?php echo $size['size_name']; ?>">
                            <span src="assets/item_images/<?php echo $size['item_images'][0]; ?>" class=""></span>
                            <span class="text-pri">
                                <?php echo $size['size_code']; ?>
                            </span>
                        </div>
                        <?php
}}
} ?>
                    </div>
                </div>
                <h2 class="d-inline">Product Specification <i class="float-end p-2 fa fa-caret-down"></i></h2>
                {{--  <hr cl> --}}
                <table class="table" id="specification">
                    <?php
if(false){
$productId = $Product->product_id;
$specification = getProductSpecification($conn, $productId);
foreach ($specification as $specification) {
?>

                    <div id="specification" class="show">
                        <span class="h6 text-uppercase" class="">
                            <?php echo $specification['name']; ?>
                        </span>
                        <span>
                            :
                            <?php echo $specification['value']; ?>
                        </span>
                        <br>
                    </div>
                    {{-- <tr class="border">
                        <td class="text-uppercase fw-semibold">
                            <?php echo $specification['name']; ?>
                        </td>
                        <td class="border-start">
                            <?php echo $specification['value']; ?>
                        </td>
                    </tr> --}}
                    <?php
}}
?>
                </table>
                <hr class="text-sec border-2">
                <div class="bg-white bg-white rounded-0 col-12">
                    <div class="my-3">
                        <i class="fas fa-shipping-fast" style="font-size:20px"></i> 7 Days Free Delivery <i
                            class="fa fa-angle-right float-end me-3"></i>
                    </div>
                    <div class="my-3">
                        <i class="fas fa-undo" style="font-size:20px"></i> &nbsp;7 Days Return Policy <i
                            class="fa fa-angle-right float-end me-3"></i>
                    </div>
                    <div class="my-3">
                        <i class="fa fa-inr" style="font-size:20px"></i> &nbsp;&nbsp;Cash On Delivery Available <i
                            class="fa fa-angle-right float-end me-3"></i>
                    </div>
                </div>
                <hr class="text-sec border-2">
            </div>
        </div>
        <div>
            <?php
if(0){
echo $Product->p_keywords ?>
            <div class="text-center display-6">You Should also Like</div>
            <div class="owl-carousel owl-theme">
                <?php
$KeywordString = $Product->p_keywords;
$KeywordArray = array_map('trim', explode(',', $KeywordString));
$itemCondition = " 1=1 AND";
foreach ($KeywordArray as $keyword) {
$itemCondition .= " product_list.keywords LIKE '%$keyword%' OR";
}
$itemCondition .= " 2=1 GROUP BY product_id ORDER BY product_id";
$itemList = getDetails($conn, $itemCondition);
foreach ($itemList as $item) {
?>
                <div class="item">
                    <div class="card product_card" productCode="<?php echo $item['product_code']; ?>">
                        <div class="image-container bg-primary">
                            <img class="rounded-5" src="assets/item_images/<?php echo $item['item_images']['0']; ?>">
                        </div>
                        <div>
                            <?php echo $item['product_name']; ?>
                        </div>
                        <div class="text-center">
                            <?php
                            $ColorCount = count(getDetails($conn, '1=1 GROUP BY color_id', $item['item_id']));
                            echo $ColorCount > 1 ? $ColorCount . ' Colors' : ''; ?>
                        </div>
                    </div>
                </div>
                <?php } } ?>
            </div>
        </div>
    </div>
    {{-- Share Product Modal Start --}}
    <div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="shareModalLabel">Share This Page</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Choose how you want to share this link:</p>
                    <div>
                        <button class="btn btn-outline-primary rounded-circle me-2 mb-2" id="shareEmail"><i
                                class="fa fa-envelope"></i></button>
                        <button class="btn btn-outline-primary rounded-circle me-2 mb-2" id="shareFacebook"><i
                                class="fab fa-facebook"></i></button>
                        <button class="btn btn-outline-primary rounded-circle me-2 mb-2" id="shareTwitter"><i
                                class="fab fa-twitter"></i></button>
                        <button class="btn btn-outline-primary rounded-circle mb-2" id="shareWhatsapp"><i
                                class="fab fa-whatsapp"></i></button>
                    </div>
                    <!-- Add more sharing buttons as needed -->
                </div>
            </div>
        </div>
    </div>
    {{-- Share Product Modal End --}}
    <script>
        $(document).ready(function() {
            $('.owl-carousel').owlCarousel({
                loop: false,
                margin: 10,
                nav: true,
                dots: false,
                responsive: {
                    0: {
                        items: 3
                    },
                    768: {
                        items: 5
                    },
                    992: {
                        items: 8
                    }
                },
                navClass: ['carousel-control-prev h-50 my-auto bg-danger btn',
                    'carousel-control-next h-50 my-auto bg-primary btn'
                ], // Bootstrap style navigation buttons
                navText: ['<span class="carousel-control-prev-icon" aria-hidden="true"></span>',
                    '<span class="carousel-control-next-icon" aria-hidden="true"></span>'
                ]
            });
            $('#shareButton').click(function() {
                $('#shareModal').modal('show'); // Show the modal
            });

            // Share via email
            var currentUrl = window.location.href;
            message = "Hey, check this url for view the Crazy Offers From Krazy Kart: " + currentUrl;
            $('#shareEmail').click(function() {
                var subject = "Krazy Kart Brings Amazing Offers For You!";
                var body = message;
                var mailToUrl = "mailto:?subject=" + encodeURIComponent(subject) + "&body=" +
                    encodeURIComponent(body);
                window.location.href = mailToUrl;
            });

            // Share via Facebook
            $('#shareFacebook').click(function() {
                var facebookUrl = "https://www.facebook.com/sharer/sharer.php?u=" +
                    encodeURIComponent(currentUrl);
                window.open(facebookUrl, "_blank");
            });

            // Share via Twitter
            $('#shareTwitter').click(function() {
                var twitterUrl = "https://twitter.com/intent/tweet?text=" + encodeURIComponent(
                    message);
                window.open(twitterUrl, "_blank");
            });

            // Add more share button functionality here

            // Close modal when any share button is clicked
            $('.modal-body button').click(function() {
                $('#shareModal').modal('hide');
            });
        });
    </script>
    <script>
        function runTransferEffect() {
            var options = {
                to: ".fa-shopping-cart",
                className: "ui-effects-transfer"
            };
            $("#effect").effect("transfer", options, 500, callback);
        };

        function callback() {
            setTimeout(function() {
                $("#effect").removeAttr("style").hide().fadeIn();
            }, 500);
        };
        $("#add_wishkart").on("click", function() {
            runTransferEffect();
            return false;
        });
    </script>

    <?php
} else {
?>
    <div class="text-center mt-5 p-5" href="/">
        <h2>Item Not Found</h2>
        <div class="btn btn-primary">Go To Homepage</div>
    </div>
    <?php
}
// }?>
@endsection
