<!DOCTYPE html>
<html>

<head>
    <title>Admin Login</title>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Krazy Kart</title>
        <link rel="stylesheet" href="/css/bootstrap.min.css">
    </head>
</head>

<body class="bg-body-secondary" style="height:100vh;width:100vw;">
    <div class="container p-3 p-md-4 p-xl-5" style="position:relative;top:50%;transform: translateY(-50%);">
        <div class="row justify-content-center">
            <div class="col-12 col-md-9 col-lg-7 col-xl-6 col-xxl-5">
                <div class="card border border-light-subtle rounded-4">
                    <div class="card-body p-3 p-md-4 p-xl-5">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-5">
                                    <h4 class="text-center">Admin Login</h4>
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('admin.login') }}" method="POST">
                            @csrf
                            <div class="row gy-3 overflow-hidden">
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" name="email" id="email"
                                            placeholder="admni@krazykart.com" required>
                                        <label for="email" class="form-label">Email</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control" name="password" id="password"
                                            value="" placeholder="Password" required>
                                        <label for="password" class="form-label">Password</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button class="btn bsb-btn-xl btn-primary py-2" style="font-size: 20px;" type="submit">Log in</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
{{-- <body style="height:100vh;width:100vw;display:flex;" class="">
<div class=" m-auto">
    <div class="card p-3 " style="width:500px">

@if ($errors->any())
<div class="alert alert-danger alert-dismissible">
        @foreach ($errors->all() as $error)
            {{ $error }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        @endforeach
</div>
@endif
    <form method="POST" action="{{ route('admin.login') }}">
        @csrf

        <h1 class="text-center">Admin Login</h1>
        <hr>
        <div class="form-floating">
            <input type="text" class="form-control" value="{{ old('email') }}"  id="email" name="email" placeholder=""
            required>
            <label for="email">Email</label>
        </div>
        <div class="mt-2 form-floating">
            <input type="password" id="password" placeholder="" name="password"
            class="form-control" required>
            <label for="password">Password</label>
        </div>
        <input type="submit" class="btn btn-primary w-100 mt-4">
    </form>
</body> --}}

</html>
