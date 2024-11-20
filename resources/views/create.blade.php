<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Laravel Training Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const createTraineeForm = document.getElementById('createTraineeForm');

            createTraineeForm.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent default form submission

                // Show loading spinner and disable button
                const button = document.getElementById('createTraineeBtn');
                button.querySelector('.spinner-border').classList.remove('d-none'); // Show spinner
                button.disabled = true; // Disable the button to prevent multiple submissions

                // Submit the form after some delay (for demonstration)
                setTimeout(() => {
                    this.submit();
                }, 1000); // Adjust the delay time as needed
            });
        });
    </script>
</head>

<body>
    <div class="container mt-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left mb-2">
                    <h2>Add Trainee</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-dark" href="{{ route('trainees.index') }}">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>
            </div>
        </div>
        @if (session('status'))
            <div class="alert alert-success mb-1 mt-1">
                {{ session('status') }}
            </div>
        @endif
        <form action="{{ route('trainees.store') }}" method="POST" enctype="multipart/form-data"
            id="createTraineeForm">
            @csrf
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>First Name:</strong>
                        <input type="text" name="firstName" class="form-control" placeholder="First Name">
                        @error('firstName')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Last Name:</strong>
                        <input type="text" name="lastName" class="form-control" placeholder="Last Name">
                        @error('lastName')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Email:</strong>
                        <input type="email" name="email" class="form-control" placeholder="Email">
                        @error('email')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Phone:</strong>
                        <input type="number" name="phone" class="form-control" placeholder="Phone">
                        @error('phone')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="role"><strong>Role:</strong></label>
                        <select name="role" class="form-control @error('role') is-invalid @enderror" id="role">
                            @foreach (['guest', 'manager', 'admin'] as $option)
                                <option value="{{ $option }}" {{ old('role') == $option ? 'selected' : '' }}>
                                    {{ ucfirst($option) }}</option>
                            @endforeach
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="name"><strong>Technology:</strong></label>
                        <select name="name" class="form-control @error('name') is-invalid @enderror" id="name">
                            <option value="php">Php</option>
                            @foreach (['laravel'] as $option)
                                <option value="{{ $option }}" {{ old('name') == $option ? 'selected' : '' }}>
                                    {{ ucfirst($option) }}</option>
                            @endforeach
                        </select>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="status"><strong>Status:</strong></label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror"
                            id="status">
                            <option value="inactive">In active</option>
                            @foreach (['active', 'pending'] as $option)
                                <option value="{{ $option }}" {{ old('status') == $option ? 'selected' : '' }}>
                                    {{ $option == 'inactive' ? 'In Active' : ucfirst($option) }}</option>
                            @endforeach
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <button type="submit" class="btn btn-primary" id="createTraineeBtn">
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        Create
                    </button>
                </div>
            </div>
        </form>
    </div>
</body>

</html>
