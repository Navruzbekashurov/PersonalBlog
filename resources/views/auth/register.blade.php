<!doctype html>
<html lang="uz">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Ro'yxatdan o'tish - Codebase</title>

    <meta name="description" content="Codebase Laravel register sahifasi">
    <meta name="author" content="Sizning loyihangiz">
    <meta name="robots" content="noindex, nofollow">

    <!-- Favicons -->
    <link rel="shortcut icon" href="{{ asset('assets/media/favicons/favicon.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/media/favicons/favicon-192x192.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/media/favicons/apple-touch-icon-180x180.png') }}">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/css/codebase.min.css') }}">
</head>
<body>
<div id="page-container" class="main-content-boxed">
    <main id="main-container">
        <div class="bg-gd-dusk">
            <div class="hero-static content content-full bg-light">
                <!-- Header -->
                <div class="py-4 px-1 text-center mb-4">
                    <a class="link-fx fw-bold" href="/">
                        <i class="fa fa-blog text-primary"></i>
                        <span class="fs-4 text-body-color">Maqolalar</span><span class="fs-4">Gazeta</span>
                    </a>
                    <h1 class="h3 fw-bold mt-5 mb-2">Yangi foydalanuvchi</h1>
                    <h2 class="h5 fw-medium text-muted mb-0">Ro'yxatdan o'ting</h2>
                </div>

                <!-- Register Form -->
                <div class="row justify-content-center px-1">
                    <div class="col-sm-8 col-md-6 col-xl-4">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form class="js-validation-signup" action="{{ route('register') }}" method="POST">
                            @csrf
                            <div class="form-floating mb-4">
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       name="name" value="{{ old('name') }}" placeholder="Ism" required>
                                <label class="form-label">Ismingiz</label>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-floating mb-4">
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email') }}" placeholder="Email" required>
                                <label class="form-label">Email</label>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-floating mb-4">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                       name="password" placeholder="Parol" required>
                                <label class="form-label">Parol</label>
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-floating mb-4">
                                <input type="password" class="form-control"
                                       name="password_confirmation" placeholder="Parolni tasdiqlang" required>
                                <label class="form-label">Parolni tasdiqlang</label>
                            </div>

                            <div class="row g-sm mb-4">
                                <div class="col-12 mb-2">
                                    <button type="submit" class="btn btn-lg btn-alt-primary w-100 py-3 fw-semibold">
                                        Ro'yxatdan o'tish
                                    </button>
                                </div>
                                <div class="text-center mb-4">
                                    <hr class="my-4">
                                    <p class="mb-2">Yoki Google orqali ro‘yxatdan o‘ting</p>
                                    <a href="{{ route('google.redirect') }}" class="btn btn-lg w-100 py-3 fw-semibold"
                                       style="background-color: #db4437; color: white;">
                                        <i class="fab fa-google me-2"></i> Google bilan davom etish
                                    </a>
                                </div>

                                <div class="col-12 text-center">
                                    <a class="fs-sm" href="{{ route('login') }}">
                                      Login
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Scripts -->
<script src="{{ asset('assets/js/codebase.app.min.js') }}"></script>
<script src="{{ asset('assets/js/lib/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/op_auth_signup.min.js') }}"></script>
</body>
</html>
