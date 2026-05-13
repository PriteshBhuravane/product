<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <style>
        button,
        input,
        optgroup,
        select,
        textarea {
            margin: 0;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Product Management</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
                aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                @php
                $user = Auth::user();
                @endphp
                @if($user && $user->user_type === 'admin')
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('admin.dashboard') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('category.select') }}">Add Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('product.index') }}">View Products</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="auditLogDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Audit logs
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="auditLogDropdown">
                            <li><a class="dropdown-item" href="{{ route('user.logs') }}">User Logs</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.logs') }}">Admin Logs</a></li>
                            <li><a class="dropdown-item" href="{{ route('category.logs') }}">Category Logs</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 me-3">
                    <li class="nav-item mt-1">
                        <a class="nav-link" href="{{route('admin.editProfile')}}">Edit Profile</a>
                    </li>
                    <li class="nav-item mt-2">
                        <form method="POST" action="{{route('logout')}}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link"
                                style="display:inline; padding:0;">Logout</button>
                        </form>
                    </li>
                </ul>
                @else
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ url('/user/home') }}">Home</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 me-3">
                    <li class="nav-item mt-1">
                        <a class="nav-link" href="{{route('user.editProfile')}}">Edit Profile</a>
                    </li>
                    <li class="nav-item mt-2">
                        <form method="POST" action="{{route('logout')}}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link"
                                style="display:inline; padding:0;">Logout</button>
                        </form>
                    </li>
                </ul>
                @endif
            </div>
        </div>
    </nav>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
</body>

</html>