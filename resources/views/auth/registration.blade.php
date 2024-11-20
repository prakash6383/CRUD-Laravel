<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Custom User Register Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }

        .register-container {
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

        .navbar-brand {
            display: flex;
            align-items: center;
        }

        .navbar-brand img {
            margin-right: 10px;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
    <script>
        // function encryptPassword(event) {
        //     event.preventDefault();
        //     event.target.submit();
        //     // console.log('{{ $hashedAppKey }}')
        //     // const secretKey = '{{ $hashedAppKey }}';
        //     // const secretKey = '{{ config('app.key') }}';
        //     // const passwordField = document.getElementById('password');
        //     // const confirmPasswordField = document.getElementById('password-confirm');
        //     // if (passwordField.value !== confirmPasswordField.value) {
        //     //     alert('The password confirmation does not match.');
        //     //     return;
        //     // }

        //     // const key = CryptoJS.enc.Utf8.parse('{{ config('app.key') }}');
        //     // const iv = CryptoJS.enc.Utf8.parse('1234567891011121');

        //     // const encrypted = CryptoJS.AES.encrypt(passwordField.value, key, {
        //     //     iv: iv,
        //     //     mode: CryptoJS.mode.CBC,
        //     //     padding: CryptoJS.pad.Pkcs7
        //     // });

        //     // const encryptedConfirm = CryptoJS.AES.encrypt(confirmPasswordField.value, key, {
        //     //     iv: iv,
        //     //     mode: CryptoJS.mode.CBC,
        //     //     padding: CryptoJS.pad.Pkcs7
        //     // });

        //     // const encryptedPassword = encrypted.toString();
        //     // const encryptedConfirmPassword = encryptedConfirm.toString();

        //     // passwordField.value = encryptedPassword;
        //     // confirmPasswordField.value = encryptedConfirmPassword;

        //     // $encryptedPassword = openssl_encrypt(passwordField.value, "AES-256-CBC", '{{ config('app.key') }}', 0, '1234567891011121');
        //     // $encryptedConfirmPassword = openssl_encrypt(confirmPasswordField.value, "AES-256-CBC", '{{ config('app.key') }}', 0, '1234567891011121');

        //     // const encryptedPassword = CryptoJS.AES.encrypt(passwordField.value, secretKey).toString();
        //     // const encryptedConfirmPassword = CryptoJS.AES.encrypt(confirmPasswordField.value, secretKey).toString();

        // }
        // function validatePassword() {
        //     const password = document.getElementById('password').value;
        //     const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
        //     if (!passwordRegex.test(password)) {
        //         alert(
        //         'Password must be at least 8 characters long, include at least one uppercase letter, and one symbol.');
        //         return false;
        //     }
        //     return true;
        // }
    </script>
</head>

<body>
    {{-- {{ $hashedAppKey }} --}}
    <section class="register-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa-solid fa-address-card"></i> {{ __('Register') }}
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3">
                                    <label for="firstName" class="form-label">{{ __('First Name') }}</label>
                                    <input id="firstName" type="text"
                                        class="form-control @error('firstName') is-invalid @enderror" name="firstName"
                                        value="{{ old('firstName') }}" required autocomplete="firstName" autofocus>

                                    @error('firstName')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="lastName" class="form-label">{{ __('Last Name') }}</label>
                                    <input id="lastName" type="text"
                                        class="form-control @error('lastName') is-invalid @enderror" name="lastName"
                                        value="{{ old('lastName') }}" required autocomplete="lastName" autofocus>

                                    @error('lastName')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">{{ __('E-Mail Address') }}</label>
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="phone" class="form-label">{{ __('Phone Number') }}</label>
                                    <input id="phone" type="phone"
                                        class="form-control @error('phone') is-invalid @enderror" name="phone"
                                        value="{{ old('phone') }}" required autocomplete="phone">

                                    @error('phone')
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
                                            required autocomplete="new-password">
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

                                <div class="mb-3">
                                    <label for="password-confirm"
                                        class="form-label">{{ __('Confirm Password') }}</label>
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                    <a href="{{ route('login') }}" class="btn btn-link d-flex justify-content-center">
                                        {{ __('Back') }}
                                    </a>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
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
