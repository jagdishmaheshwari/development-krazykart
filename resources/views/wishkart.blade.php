@extends('app')

@section('title', 'Krazy Kart')

@section('content')
    <div class="w-100 bg-white text-center d-flex flex-column align-items-center justify-content-center">
        @auth
            <?php
            if (count($wishkartItems) < 1) {
                ?>
            <div class="h4">Your WishKart is Empty!</div>
            <a href="/" class="btn btn-primary bg-pri">Keep Shopping</a>
            <?php
            } else {
                ?>
            <section class="h-100 py-4" style="background-color: #fdccbc;">
                <div class="container h-100">
                    <div class="row d-flex justify-content-center align-items-center h-100">
                        <div class="col">
                            <p><span class="h2 text-pri">Shopping Cart </span><span
                                    class="h4 text-pri">({{ count($wishkartItems) }} item
                                    in your cart)</span></p>
                            <?php $TotalAmount = 0; ?>
                            @foreach ($wishkartItems as $wishkartItem)
                                <div class="card mb-4">
                                    <div class="card-body p-4">
                                        <div class="row align-items-center">
                                            <div class="col-md-2">
                                                <img src="{{ reset($wishkartItem->item_images) }}" class="img-fluid"
                                                    alt="Generic placeholder image">
                                            </div>
                                            <div class="col-md-2 d-flex justify-content-center">
                                                <div>
                                                    <p class="small text-muted mb-4 pb-2">Name</p>
                                                    <p class="lead fw-normal mb-0">{{ $wishkartItem->product_name }}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-2 d-flex justify-content-center">
                                                <div>
                                                    <p class="small text-muted mb-4 pb-2">Color</p>
                                                    <p class="lead fw-normal mb-0"><i class="fas fa-circle me-2"
                                                            style="color: {{ $wishkartItem->color_code }};"></i>
                                                        {{ $wishkartItem->color_name }}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-2 d-flex justify-content-center">
                                                <div>
                                                    <p class="small text-muted mb-4 pb-2">Quantity</p>
                                                    <p class="lead fw-normal mb-0">2</p>
                                                </div>
                                            </div>
                                            <div class="col-md-2 d-flex justify-content-center">
                                                <div>
                                                    <p class="small text-muted mb-4 pb-2">Price</p>
                                                    <p class="lead fw-normal mb-0">{{ $wishkartItem->price }}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-2 d-flex justify-content-center">
                                                <div>
                                                    <p class="small text-muted mb-4 pb-2">Total</p>
                                                    <p class="lead fw-normal mb-0">₹ {{ $wishkartItem->price * 2 }}
                                                        <?php $TotalAmount += $wishkartItem->price * 2; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="card mb-5">
                                <div class="card-body p-4">

                                    <div class="float-end">
                                        <p class="mb-0 me-5 d-flex align-items-center">
                                            <span class="small text-muted me-2">Order total:</span> <span
                                                class="lead fw-normal">₹ {{ $TotalAmount }}</span>
                                        </p>
                                    </div>

                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <div class="btn btn-light me-2" href='/'>Continue shopping</div>
                                <div class="btn btn-primary">Check Out</div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
            {{-- <div class="container">
                <div class="row">
                    @foreach ($wishkartItems as $wishkartItem)
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <img src="{{ reset($wishkartItem->item_images) }}" class="card-img-top"
                                    alt="{{ $wishkartItem->product_name }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $wishkartItem->product_name }}</h5>
                                    <p class="card-text">{{ $wishkartItem->color_name }},
                                        {{ $wishkartItem->size_name }}</p>
                                    <p class="card-text">Stock: {{ $wishkartItem->stock }}</p>
                                    <a href="{{ route('product.view', $wishkartItem->item_id) }}" class="btn btn-primary">View
                                        Details</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div> --}}
            <?php
                }
                ?>
        @else
            <!-- Show login button or link if user is not logged in -->
            <a href="{{ route('login') }}" class="btn btn-primary bg-pri">Login</a>
        @endauth
    </div>
@endsection
