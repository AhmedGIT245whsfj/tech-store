<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Tech Store')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f5f7fb;
            min-height: 100vh;
        }

        .navbar-brand {
            font-weight: 700;
        }

        .page-container {
            padding-top: 32px;
            padding-bottom: 48px;
        }

        .auth-card {
            max-width: 460px;
            margin: 70px auto;
            border: 0;
            border-radius: 18px;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.08);
        }

        .dashboard-card,
        .product-card,
        .content-card {
            border: 0;
            border-radius: 16px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.06);
        }

        .product-card {
            overflow: hidden;
            height: 100%;
        }

        .product-image {
            width: 100%;
            height: 240px;
            object-fit: contain;
            background: white;
            padding: 20px;
        }

        .product-details-image {
            width: 100%;
            height: 430px;
            object-fit: contain;
            background: white;
            padding: 30px;
            border-radius: 16px;
        }

        .table-card {
            overflow: hidden;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">Tech Store</a>

        @auth
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav me-auto">
                    @if(auth()->user()->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.products.index') }}">Manage Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.users.index') }}">Users</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.orders.index') }}">Orders</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                    @endif

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('web.products.index') }}">Products</a>
                    </li>

                    @if(auth()->user()->role === 'user')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('web.orders.index') }}">My Orders</a>
                        </li>
                    @endif
                </ul>

                <div class="d-flex align-items-center gap-3 text-white">
                    <span>{{ auth()->user()->name }}</span>
                    <span class="badge bg-primary">{{ ucfirst(auth()->user()->role) }}</span>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-outline-light btn-sm" type="submit">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>

<main class="container page-container">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
