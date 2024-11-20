<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
        function showLoading() {
            document.getElementById('btnText').style.display = 'none';
            document.getElementById('btnSpinner').style.display = 'inline-block';
            document.getElementById('submitBtn').disabled = true;
        }
    </script>
    <title>Document</title>
</head>

<body>
    <div class="container">
        <h1>Import Trainees</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <form action="{{ route('trainees.import.submit') }}" method="POST" enctype="multipart/form-data"
            onsubmit="showLoading()">
            @csrf
            <div class="mb-3">
                <label for="file" class="form-label">CSV file</label>
                <input class="form-control" type="file" name="file" id="file">
            </div>
            <button type="submit" class="btn btn-success" id="submitBtn">
                <span id="btnText">Import</span>
                <span id="btnSpinner" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"
                    style="display: none;"></span>
            </button>
        </form>
    </div>
</body>

</html>
