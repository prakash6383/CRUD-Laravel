<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel Training</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        body {
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
        }

        #success-alert {
            display: none;
        }

        .spinner,
        .exportBtnSpinner {
            display: none;
            width: 15px;
            height: 15px;
            border: 2px solid rgba(0, 0, 0, .1);
            border-radius: 50%;
            border-left-color: #09f;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .pagination {
            display: flex;
            padding-left: 0;
            list-style: none;
            border-radius: 0.25rem;
            justify-content: right !important;
        }

        .page-item {
            margin: 0 2px;
        }

        .page-link {
            position: relative;
            display: block;
            padding: 0.5rem 0.75rem;
            margin-left: -1px;
            line-height: 1.25;
            color: #007bff;
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .page-link:hover {
            z-index: 2;
            color: #0056b3;
            text-decoration: none;
            background-color: #e9ecef;
            border-color: #dee2e6;
        }

        .page-item.active .page-link {
            z-index: 3;
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        }

        .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
            background-color: #fff;
            border-color: #dee2e6;
        }

        .pagination .page-link {
            margin: 0 5px;
        }

        .pagination .page-item:first-child .page-link {
            margin-left: 0;
            border-top-left-radius: 0.25rem;
            border-bottom-left-radius: 0.25rem;
        }

        .pagination .page-item:last-child .page-link {
            margin-right: 0;
            border-top-right-radius: 0.25rem;
            border-bottom-right-radius: 0.25rem;
        }

        .pagination {
            justify-content: center;
            margin-top: 1rem;
        }

        .card {
            border: none;
        }

        .sidebar {
            height: 100vh;
            width: 180px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #f8f9fa;
            padding-top: 20px;
            /* padding-bottom: 20px; */
            border-right: 1px solid #dee2e6;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .sidebar .nav-link {
            margin: 0.5rem 0;
            color: #333;
        }

        .sidebar .nav-link:hover {
            background-color: #e9ecef;
            border-radius: 5px;
        }

        .content {
            margin-left: 200px;
            padding: 20px;
            width: calc(100% - 200px);
            position: relative;
        }

        .navbar {
            position: fixed;
            top: 0;
            left: 180px;
            right: 0;
            z-index: 1030;
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }

        .navbar .user-info {
            margin-left: auto;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div>
            {{-- <a class="navbar-brand" href="#">Laravel Training</a> --}}
            <a class="navbar-brand ml-3" href="#" style="margin-top: -40px">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 113.02 28.1942764712217" width="120"
                    height="120">
                    <path fill="#ff2d20"
                        d="M4.44 0v23.05h8.34v3.97H0V0h4.44zm24 11.46V9.03h4.22v18h-4.2v-2.44c-.58.9-1.38 1.6-2.42 2.1-1.04.53-2.1.78-3.15.78-1.37 0-2.62-.25-3.75-.75a8.76 8.76 0 0 1-2.92-2.06 9.6 9.6 0 0 1-1.9-3 9.72 9.72 0 0 1-.67-3.64c0-1.26.23-2.47.68-3.6a9.56 9.56 0 0 1 1.9-3.04 8.77 8.77 0 0 1 2.9-2.08c1.14-.5 2.4-.75 3.75-.75 1.05 0 2.1.26 3.14.77 1.04.52 1.84 1.22 2.4 2.12zm-.38 8.77a6.3 6.3 0 0 0 .4-2.2c0-.78-.14-1.5-.4-2.2A5.58 5.58 0 0 0 26.98 14a5.23 5.23 0 0 0-1.68-1.22 5.16 5.16 0 0 0-2.18-.47c-.8 0-1.52.17-2.16.48A5.3 5.3 0 0 0 19.3 14a5.3 5.3 0 0 0-1.06 1.83 6.56 6.56 0 0 0-.37 2.2c0 .77.12 1.5.37 2.2.24.7.6 1.3 1.06 1.8a5.28 5.28 0 0 0 1.66 1.25c.64.3 1.36.46 2.16.46s1.53-.15 2.18-.46a5.22 5.22 0 0 0 1.68-1.24 5.58 5.58 0 0 0 1.08-1.8zm7.92 6.8v-18H47.4v4.14h-7.22v13.85h-4.2zm26.67-15.57V9.03h4.2v18h-4.2v-2.44c-.56.9-1.37 1.6-2.4 2.1-1.05.53-2.1.78-3.16.78-1.37 0-2.62-.25-3.75-.75a8.76 8.76 0 0 1-2.92-2.06 9.6 9.6 0 0 1-1.9-3 9.72 9.72 0 0 1-.66-3.64c0-1.26.22-2.47.67-3.6a9.56 9.56 0 0 1 1.9-3.04 8.77 8.77 0 0 1 2.9-2.08c1.14-.5 2.4-.75 3.75-.75 1.05 0 2.1.26 3.14.77 1.04.52 1.85 1.22 2.4 2.12zm-.38 8.77a6.3 6.3 0 0 0 .38-2.2c0-.78-.13-1.5-.38-2.2A5.58 5.58 0 0 0 61.2 14a5.23 5.23 0 0 0-1.7-1.22c-.65-.3-1.38-.47-2.17-.47-.8 0-1.52.17-2.17.48A5.3 5.3 0 0 0 53.5 14a5.3 5.3 0 0 0-1.06 1.83 6.56 6.56 0 0 0-.36 2.2c0 .77.12 1.5.36 2.2.25.7.6 1.3 1.06 1.8a5.28 5.28 0 0 0 1.66 1.25c.65.3 1.37.46 2.17.46.8 0 1.52-.15 2.18-.46a5.22 5.22 0 0 0 1.7-1.24 5.58 5.58 0 0 0 1.07-1.8zm21.46-11.2H88l-6.9 18h-5.3l-6.9-18h4.25l5.3 13.78 5.28-13.77zm13.44-.46c5.73 0 9.64 5.08 8.9 11.02H92.1c0 1.54 1.58 4.54 5.3 4.54 3.2 0 5.35-2.8 5.35-2.8l2.84 2.2c-2.55 2.7-4.63 3.95-7.9 3.95-5.82 0-9.76-3.7-9.76-9.47 0-5.23 4.08-9.46 9.23-9.46zm-5.05 7.9h10.1c-.04-.35-.6-4.56-5.08-4.56-4.5 0-4.98 4.22-5.02 4.56zM108.82 27V0h4.2v27.02h-4.2z" />
                </svg>
            </a>
            <ul class="navbar-nav flex-column">
                {{-- <li class="nav-item">
                    <a class="nav-link" href="#">Dashboard</a>
                </li> --}}
                <li class="nav-item ml-3" style="font-size: 20px">
                    <a class="nav-link" href="#"><i id="fileImport" class="fas fa-users"></i> Trainees</a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link" href="#">Reports</a>
                </li> --}}
            </ul>
        </div>
        <div>
            <button type="button" class="btn btn-danger w-100" style="border-radius: inherit; height: 70px"
                onclick="logoutAndClearStorage()">
                <i class="fa fa-sign-out"></i> Log out
            </button>
        </div>
    </div>

    <div class="content">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <div class="collapse navbar-collapse justify-content-end">
                    <a class="nav-link d-flex align-items-center" href="#">
                        <i class="fas fa-user-circle mr-2 display-6"></i>
                    </a>
                    <div>
                        @if (Auth::user())
                            <div class="d-flex align-items-center" style="font-weight: 500;">
                                <span>{{ Auth::user()->firstName }} {{ Auth::user()->lastName }}</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <span>{{ ucfirst(Auth::user()->role) }}</span>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </nav>

        <div class="card m-3">
            <div class="card-body" style="margin-top: 70px;">
                @if (session('success'))
                    <div class="alert alert-success" role="alert" id="success-alert">{{ session('success') }}</div>
                @endif
                {{-- <div class="row mb-3"> --}}
                {{-- <div class="col-md-3 pl-0" id="importFormContainer">
                        {{-- <form action="{{ route('trainees.import') }}" method="POST" enctype="multipart/form-data"
                            id="importForm">
                            @csrf
                            <div class="input-group">
                                <input type="file" name="file" class="form-control">
                                <button type="submit" class="btn btn-success ml-2" id="importBtn">
                                    <span id="importBtnSpinner" class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true" style="display: none;"></span>
                                    <span id="importBtnText"><i id="fileImport" class="fas fa-file-import"></i> Import
                                        CSV</span>
                                </button>
                            </div>
                        </form> --}}
                {{-- <a id="import-file-btn" class="btn btn-success mr-3" onclick="importUsers(this, 'import-loading')">
                            <i class="fas fa-file-import"></i> Import File
                            <span id="import-loading" class="spinner-border spinner-border-sm d-none" role="status"
                                aria-hidden="true"></span>
                        </a> --}}
                {{-- </div> --}}
                <div class="col-md-12 d-flex justify-content-between pr-0 pl-0">
                    <form class="form-inline" method="GET" action="{{ route('trainees.search') }}">
                        <div class="input-group">
                            <input type="text" class="form-control" name="query" placeholder="Search"
                                aria-label="Search Trainees" style="width: 300px;" value="{{ $searchText }}">
                            <div class="input-group-append">
                                <button class="btn btn-success rounded-sm" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                                <button id="clear-filter-btn" class="btn btn-secondary rounded-sm ml-2" type="button"
                                    style="display: none;" onclick="clearFilter()">
                                    <i class="fas fa-times"></i> Clear Filter
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="ml-auto">
                        <a id="import-file-btn" class="btn btn-success mr-3"
                            onclick="importUsers(this, 'import-loading', 'importIcon')">
                            <span id="import-loading" class="spinner-border spinner-border-sm d-none" role="status"
                                aria-hidden="true"></span>
                            <i id="importIcon" class="fas fa-file-import"></i> Import File
                        </a>
                        <a class="btn btn-success mr-3" href="#" id="exportBtn"
                            onclick="showExportLoading(event)">
                            <span id="exportBtnSpinner" class="spinner-border spinner-border-sm me-2" role="status"
                                aria-hidden="true" style="display: none;"></span>
                            <span id="exportBtnText"><i class="fas fa-file-export" id="fileExport"></i> Export
                                CSV</span>
                        </a>
                        <a class="btn btn-success" href="{{ route('trainees.create') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                                class="bi bi-plus" viewBox="0 0 16 16">
                                <path
                                    d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                            </svg> Create Trainee
                        </a>
                    </div>
                </div>

                <iframe id="downloadFrame" style="display: none;"></iframe>
                <table class="table table-bordered table-striped mt-4">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Role</th>
                            <th>Technology</th>
                            <th>Status</th>
                            <th width="280px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $sno = ($trainees->currentPage() - 1) * $trainees->perPage();
                        @endphp
                        @foreach ($trainees as $trainee)
                            <tr>
                                <td>{{ ++$sno }}</td>
                                <td>{{ $trainee->firstName }} {{ $trainee->lastName }}</td>
                                <td>{{ $trainee->email }}</td>
                                <td>{{ $trainee->phone }}</td>
                                <td>{{ ucfirst($trainee->role) }}</td>
                                <td>
                                    @if ($trainee->techStacks)
                                        {{ ucfirst($trainee->techStacks->name) }}
                                    @else
                                        -
                                    @endif
                                </td>

                                <td>
                                    @if ($trainee->techStacks)
                                        {{ ucfirst($trainee->techStacks->status) }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('trainees.destroy', $trainee->id) }}" method="post"
                                        class="delete-form">
                                        <a class="btn btn-primary edit-btn"
                                            href="{{ route('trainees.edit', $trainee->id) }}"><i
                                                class="fa-solid fa-pen-to-square"></i> Edit</a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger delete-btn"><i
                                                class="fa-solid fa-trash"
                                                id="{{ 'deleteIcon' . $trainee->id }}"></i><span
                                                class="spinner"></span> Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        {{-- Page Numbers and Item Count --}}
                        @if ($trainees->isEmpty())
                            <li class="page-item disabled">
                                <span class="page-link">
                                    Showing 0 to 0 of 0 results
                                </span>
                            </li>
                        @else
                            <li class="page-item">
                                <span class="page-link">
                                    Showing {{ $trainees->firstItem() }} to {{ $trainees->lastItem() }} of
                                    {{ $trainees->total() }}
                                    results
                                </span>
                            </li>
                        @endif
                        {{-- Previous Page Link --}}
                        @if ($trainees->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span> Prev
                                </span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $trainees->appends(['query' => request('query')])->previousPageUrl() }}"
                                    aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span> Prev
                                </a>
                            </li>
                        @endif

                        {{-- Pagination Elements --}}
                        {{-- @for ($i = 1; $i <= $trainees->lastPage(); $i++)
                            <li class="page-item {{ $trainees->currentPage() == $i ? 'active' : '' }}">
                                <a class="page-link" href="{{ $trainees->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor --}}
                        @for ($i = 1; $i <= $trainees->lastPage(); $i++)
                            <li class="page-item {{ $trainees->currentPage() == $i ? 'active' : '' }}">
                                <a class="page-link"
                                    href="{{ $trainees->appends(['query' => request('query')])->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        {{-- Next Page Link --}}
                        @if ($trainees->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $trainees->appends(['query' => request('query')])->nextPageUrl() }}" aria-label="Next">
                                    Next <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link" aria-label="Next">
                                    Next <span aria-hidden="true">&raquo;</span>
                                </span>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    </div>

    <script>
        // function clearFilter() {
        //     document.querySelector('input[name="query"]').value = '';
        //     window.location.href = "{{ route('trainees.index') }}";
        // }

        // $(document).ready(function() {
        //     const search = document.querySelector('input[name="query"]').value;
        //     if (search) {
        //         const clearFilterButton = document.getElementById('clear-filter-btn');
        //         clearFilterButton.style.display = 'block';
        //     }
        // });

        document.addEventListener('DOMContentLoaded', function() {
            const query = "{{ request('query') }}";
            const clearButton = document.getElementById('clear-filter-btn');

            if (query) {
                clearButton.style.display = 'inline-block';
            }

            clearFilter = function() {
                document.querySelector('input[name="query"]').value = '';
                clearButton.style.display = 'none';
                window.location.href = "{{ route('trainees.index') }}";
            }
        });

        function refreshListData() {
            window.location.reload();
        }

        function loadingFalse(loadingElem, buttonElem, iconElem) {
            loadingElem.classList.add('d-none');
            iconElem.style.display = 'inline-block';
            buttonElem.classList.remove('disabled');
        }

        function loadingTrue(loadingElem, buttonElem, iconElem) {
            loadingElem.classList.remove('d-none');
            iconElem.style.display = 'none';
            buttonElem.classList.add('disabled');
        }

        function getFileFromUser() {
            return new Promise((resolve, reject) => {
                var input = document.createElement('input');
                input.type = 'file';
                input.accept = '.csv';
                input.onchange = (e) => {
                    const file = e.target.files[0];
                    resolve(file);
                };
                input.click();
            });
        }

        async function importUsers(button, loadingId, iconId) {
            var buttonElem = button;
            var loadingElem = document.getElementById(loadingId);
            var iconElem = document.getElementById(iconId);

            try {
                const file = await getFileFromUser();
                if (!file) {
                    console.error('No file selected.');
                    alert('No file selected.');
                    return;
                }
                loadingTrue(loadingElem, buttonElem, iconElem);
                const formData = new FormData();
                formData.append('file', file);
                const response = await fetch('import', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    body: formData
                });
                const data = await response.json();
                if (data.status === "Success" || data.status === "Warning" || data.status === "Error") {
                    setTimeout(function() {
                        loadingFalse(loadingElem, buttonElem, iconElem);
                        refreshListData();
                    }, 1000);
                }
            } catch (error) {
                loadingFalse(loadingElem, buttonElem, iconElem);
                refreshListData();
            }
        }

        function handleDelete(id) {
            var confirmed = confirm('Are you sure you want to delete this record?');
            if (!confirmed) {
                return;
            }

            document.getElementById('spinner-' + id).style.display = 'inline-block';

            axios.delete('/trainees/' + id)
                .then(response => {
                    if (response.status === 200) {
                        window.location.reload();
                    }
                })
                .catch(error => {
                    console.error('There was an error deleting the record:', error);
                    alert('Error deleting the record. Please try again.');
                    document.getElementById('spinner-' + id).style.display = 'none';
                });
        }

        function logoutAndClearStorage() {
            localStorage.clear();
            sessionStorage.clear();
            window.location.href = "{{ route('logout') }}";
        }

        function logoutAndClearStorage() {
            window.localStorage.clear();
            window.sessionStorage.clear();
            window.location.href = '{{ route('logout') }}';
        }

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
            $('#importForm').submit(function(event) {
                event.preventDefault();

                $('#fileImport').hide();
                $('#importBtnSpinner').show();

                $('#importBtn').prop('disabled', true);
                var formData = new FormData($('#importForm')[0]);
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log('Import successful:', response);
                    },
                    error: function(xhr, status, error) {
                        console.error('Import failed:', error);
                    },
                    complete: function() {
                        $('#importBtnSpinner').hide();
                        $('#fileImport').show();
                        $('#importBtn').prop('disabled', false);
                        window.location.reload();
                    }
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const deleteForms = document.querySelectorAll('.delete-form');
            console.log("deleteForms", deleteForms);
            deleteForms.forEach(form => {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();
                    showLoading(this.querySelector('.delete-btn'));
                    this.submit();
                });
            });

            function showLoading(button) {
                const icon = button.querySelector('.fa-trash');
                const spinner = button.querySelector('.spinner');

                spinner.style.display = 'inline-block';
                document.getElementById(icon.id).style.display = 'none';
                button.disabled = true;
                button.closest('form').submit();
            }
        });

        function showExportLoading(event) {
            event.preventDefault();
            document.getElementById('exportBtnSpinner').style.display = 'inline-block';
            document.getElementById('fileExport').style.display = 'none';
            document.getElementById('exportBtn').classList.add('disabled');

            var iframe = document.getElementById('downloadFrame');
            iframe.src = "{{ route('trainees.export') }}";

            setTimeout(function() {
                document.getElementById('exportBtnSpinner').style.display = 'none';
                document.getElementById('fileExport').style.display = 'inline-block';
                document.getElementById('exportBtn').classList.remove('disabled');
            }, 2000);
        }
    </script>
</body>

</html>
