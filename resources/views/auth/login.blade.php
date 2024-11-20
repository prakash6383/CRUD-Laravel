<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Custom User Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }

        .login-container {
            margin-top: 100px;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background: #fff;
            border-bottom: none;
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
        }

        .form-control {
            border-radius: 30px;
        }

        .btn-primary {
            border-radius: 30px;
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .logo {
            display: block;
            margin: 0 auto 20px;
            width: 100px;
            height: auto;
        }

        .spinner-border {
            width: 1rem;
            height: 1rem;
            border-width: 0.2em;
        }
    </style>
</head>

<body>
    <section class="login-container">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success" role="alert" id="success-alert">{{ session('success') }}</div>
            @endif
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa-solid fa-right-to-bracket"></i> {{ __('Login') }}
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('login') }}" id="login-form">
                                @csrf
                                <div class="mb-3">
                                    <label for="email" class="form-label">{{ __('E-Mail Address') }}</label>
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">{{ __('Password') }}</label>
                                    <div class="input-group">
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="current-password">
                                        <button class="btn btn-outline-secondary" type="button" id="password-toggle">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary" id="login-button">
                                        <span id="login-spinner" class="spinner-border text-light d-none" role="status"
                                            aria-hidden="true"></span>
                                        <span id="login-text">{{ __(' Login') }}</span>
                                    </button>
                                    <div class="ml-5">
                                        <a class="btn btn-link" style="padding-left: 0 !important;"
                                            href="{{ route('reset') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    </div>
                                    <span id="login-spinner" class="spinner-border text-light d-none" role="status"
                                        aria-hidden="true"></span>
                                    <span id="login-text">Do you not have an account?<a href="{{ route('register') }}"
                                            class="underline text-gray-900 dark:text-white ml-5">
                                            {{ __(' Register Now') }}</a></span>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script>
        document.getElementById('login-form').addEventListener('submit', function() {
            var loginButton = document.getElementById('login-button');
            var loginText = document.getElementById('login-text');
            var loginSpinner = document.getElementById('login-spinner');

            loginButton.disabled = true;
            loginSpinner.classList.remove('d-none');
        });
        $(document).ready(function() {
            var alertMessage = $('#success-alert');
            if (alertMessage.length) {
                alertMessage.slideDown(400);

                setTimeout(function() {
                    alertMessage.slideUp(400);

                }, 2000);
            }
        });

        $(document).ready(function() {
            $('#password-toggle').on('click', function() {
                const passwordField = $('#password');
                const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
                passwordField.attr('type', type);
                $(this).find('i').toggleClass('fa-eye fa-eye-slash'); // Toggle eye and eye-slash icons
            });
        });
    </script>
</body>

</html>
