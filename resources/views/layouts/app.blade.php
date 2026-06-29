
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Booking System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background:#f5f7fb;
        }

        .navbar-brand{
            font-weight:bold;
        }

        .card{
            border:none;
            border-radius:15px;
            box-shadow:0 2px 10px rgba(0,0,0,.08);
            transition:.2s;
        }

        .card:hover{
            transform:translateY(-3px);
        }

        .badge{
            font-size:.85rem;
        }

        footer{
            margin-top:60px;
            padding:20px;
            background:#212529;
            color:white;
            text-align:center;
        }
    </style>

    @stack('styles')

</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">

        <a class="navbar-brand" href="{{ route('events.index') }}">
            🎫 Ticket Booking
        </a>

        <button class="navbar-toggler"
                data-bs-toggle="collapse"
                data-bs-target="#navbar">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="navbar">

            <ul class="navbar-nav me-auto">

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('events.index') }}">
                        Home
                    </a>
                </li>

                @auth

                <li class="nav-item">
                    <a class="nav-link"
                       href="{{ route('bookings.index') }}">
                        My Bookings
                    </a>
                </li>

                @endauth

            </ul>

            <ul class="navbar-nav ms-auto">

                @guest

                    <li class="nav-item">
                        <a class="nav-link"
                           href="{{ route('login') }}">
                            Login
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link"
                           href="{{ route('register') }}">
                            Sign Up
                        </a>
                    </li>

                @endguest


                @auth

                    <li class="nav-item dropdown">

                        <a class="nav-link dropdown-toggle"
                           href="#"
                           data-bs-toggle="dropdown">

                            {{ Auth::user()->name }}

                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">

                            <li>

                                <a class="dropdown-item"
                                   href="{{ route('profile.edit') }}">

                                    Profile

                                </a>

                            </li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li>

                                <form action="{{ route('logout') }}"
                                      method="POST">

                                    @csrf

                                    <button class="dropdown-item">

                                        Logout

                                    </button>

                                </form>

                            </li>

                        </ul>

                    </li>

                @endauth

            </ul>

        </div>

    </div>
</nav>

<div class="container mt-4">

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif

    @if(session('error'))

        <div class="alert alert-danger">

            {{ session('error') }}

        </div>

    @endif

    @if ($errors->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    @yield('content')

</div>

<footer>

    Ticket Booking System © {{ date('Y') }}

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')

</body>
</html>
```
