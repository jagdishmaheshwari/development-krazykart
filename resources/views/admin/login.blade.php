<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
     <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Kachchh Kala | Admin</title>
        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/admin.css">
        <script src="/src/js/jquery.js"></script>
    </head>
</head>
<body style="height:100vh;width:100vw;display:flex;" class="">
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
</body>
</html>