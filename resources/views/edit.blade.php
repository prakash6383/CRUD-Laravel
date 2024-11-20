<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Laravel Training Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const updateTraineeForm = document.getElementById('updateTraineeForm');
            updateTraineeForm.addEventListener('submit', function(event) {
                event.preventDefault();
                const button = document.getElementById('updateTraineeBtn');
                button.querySelector('.spinner-border').classList.remove('d-none');
                button.disabled = true;

                setTimeout(() => {
                    this.submit();
                }, 1000);
            });
        });
    </script>
</head>

<body>
    <div class="container mt-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Edit Trainee</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-dark" href="{{ route('trainees.index') }}">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                    {{-- <a class="btn btn-primary" href="{{ route('trainees.index') }}" enctype="multipart/form-data">
                        Back</a> --}}
                </div>
            </div>
        </div>
        @if (session('status'))
            <div class="alert alert-success mb-1 mt-1">
                {{ session('status') }}
            </div>
        @endif
        <form action="{{ route('trainees.update', $trainee->id) }}" method="POST" enctype="multipart/form-data"
            id="updateTraineeForm">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>First Name:</strong>
                        <input type="text" name="firstName" value="{{ $trainee->firstName }}" class="form-control"
                            placeholder="First Name">
                        @error('firstName')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Last Name:</strong>
                        <input type="text" name="lastName" value="{{ $trainee->lastName }}" class="form-control"
                            placeholder="Last Name">
                        @error('lastName')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Email:</strong>
                        <input type="email" name="email" class="form-control" placeholder="Email"
                            value="{{ $trainee->email }}">
                        @error('email')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Phone:</strong>
                        <input type="number" name="phone" value="{{ $trainee->phone }}" class="form-control"
                            placeholder="Phone">
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
                                <option value="{{ $option }}">{{ ucfirst($option) }}</option>
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
                            <option value="">Select Technology</option>
                            @foreach (['php', 'laravel'] as $option)
                                @if ($trainee->techStacks && $trainee->techStacks->name === $option)
                                    <option value="{{ $option }}" selected>{{ ucfirst($option) }}</option>
                                @else
                                    <option value="{{ $option }}">{{ ucfirst($option) }}</option>
                                @endif
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
                            <option value="">Select Status</option>
                            @foreach (['active', 'inactive', 'pending'] as $option)
                                @if ($trainee->techStacks && $trainee->techStacks->status === $option)
                                    <option value="{{ $option }}" selected>{{ ucfirst($option) }}</option>
                                @else
                                    <option value="{{ $option }}">{{ ucfirst($option) }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <button type="submit" class="btn btn-primary" id="updateTraineeBtn">
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        Update
                    </button>
                </div>
            </div>
        </form>
    </div>
</body>

</html>
