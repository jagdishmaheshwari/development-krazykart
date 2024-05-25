@extends('app')

@section('title', 'Krazy Kart')

@section('content')
<div class="w-100 bg-white text-center d-flex flex-column align-items-center justify-content-center" style="height: 85vh">
    @auth
        <?php
    $count = 1; // Assuming this variable is used to determine if the user has items in their WishKart
    if ($count != 0) {
        ?>
            <div class="h4">Your WishKart is Empty!</div>
            <a href="/" class="btn btn-primary bg-pri">Keep Shopping</a>
        <?php
    } else {
        ?>
            <!-- Display other content if needed when WishKart is not empty -->
        <?php
        }
        ?>
    @else
        <!-- Show login button or link if user is not logged in -->
        <a href="{{ route('login') }}" class="btn btn-primary bg-pri">Login</a>
    @endauth
</div>
@endsection
