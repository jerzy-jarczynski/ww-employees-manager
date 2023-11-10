<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management</title>
    @vite(['resources/js/app.js'])
</head>
<body>
    <div class="container mt-4">

        <nav class="navbar navbar-expand-lg navbar-primary bg-primary">
            <div class="container">
                <a class="navbar-brand text-light" href="/">Employee Management</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon text-light"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link text-light" href="/">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="{{ route('employees.create') }}">Add Employee</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>
</body>
</html>
