<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verify OTP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }

        .otp-container {
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

        .spinner-border {
            width: 1rem;
            height: 1rem;
            border-width: 0.2em;
        }
    </style>
</head>

<body>
    <section class="otp-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa-solid fa-lock"></i> {{ __('Verify OTP') }}
                        </div>

                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <div class="mb-3">
                                <p>{{ __('An OTP has been sent to your email address. Please enter it below to verify your account.') }}
                                </p>
                            </div>

                            <form method="POST" action="{{ route('verify-otp') }}" id="otp-form">
                                @csrf

                                <div class="mb-3">
                                    <label for="otp" class="form-label">{{ __('Enter OTP') }}</label>
                                    <input id="otp" type="text"
                                        class="form-control @error('otp') is-invalid @enderror" name="otp" required
                                        autofocus>

                                    @error('otp')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary" id="verify-button">
                                        <span id="verify-spinner" class="spinner-border text-light d-none"
                                            role="status" aria-hidden="true"></span>
                                        <span id="verify-text">{{ __('Verify OTP') }}</span>
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
    <script>
        document.getElementById('otp-form').addEventListener('submit', function() {
            var verifyButton = document.getElementById('verify-button');
            var verifySpinner = document.getElementById('verify-spinner');
            var verifyText = document.getElementById('verify-text');

            verifyButton.disabled = true;
            verifySpinner.classList.remove('d-none');
        });
    </script>
</body>

</html>
