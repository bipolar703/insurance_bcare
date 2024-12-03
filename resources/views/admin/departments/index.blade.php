@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Departments
                    @if (isset($departments))
                        ({{ $departments->count() }})
                    @endif

                </h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Departments</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Create --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.departments-create') }}" class="btn btn-dark">
                            <i data-feather="plus" class="fill-white feather-sm"></i> Add New
                        </a>
                    </div>
                    {{-- Archive --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.departments-showSoftDelete') }}" class="btn btn-danger">
                            <i data-feather="archive" class="fill-white feather-sm"></i> View Archive
                        </a>
                    </div>
                    {{-- Setting --}}
                    <div class="dropdown me-2">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Setting
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li><button id="softDeleteSelected" class="confirm dropdown-item"
                                    onclick="softDeleteSelected()">Delete Selected</button></li>
                            <li><button id="activeSelected" class="process dropdown-item" onclick="activeSelected()">Active
                                    Selected</button></li>
                            <li><button id="inactiveSelected" class="process dropdown-item"
                                    onclick="inactiveSelected()">Inactive Selected</button></li>
                        </ul>
                    </div>

                    {{-- <div class="dropdown me-2">
                        <button class="toggleSelectAllButton btn btn-primary" onclick="selectDeselectAll()">
                            Select/Deselect all</button>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>

    {{-- ========================================================== --}}
    {{-- ==================== Page Body Section =================== --}}
    {{-- ========================================================== --}}
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        {{-- Table Section --}}
                        <div class="table-responsive">
                            <table id="file_export" class="table table-striped table-bordered display">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>No.Projects</th>
                                        <th>Statistics</th>
                                        <th>Control</th>
                                        <th>
                                            <input type="checkbox" class="toggleSelectAllCheckbox" id="selectAllCheckbox"
                                                onclick="selectDeselectAll()">
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($departments as $department)
                                        <tr>
                                            {{-- code --}}
                                            <td><a
                                                    href="{{ route('super_admin.departments-show', isset($department->id) ? $department->id : -1) }}"><strong>{{ isset($department->code) ? $department->code : '----' }}</strong></a>
                                            </td>

                                            {{-- name --}}
                                            <td><a
                                                    href="{{ route('super_admin.departments-show', isset($department->id) ? $department->id : -1) }}">
                                                    <strong
                                                        style="width:200px; display:block;">{{ isset($department->name) ? $department->name : '----' }}</strong></a>
                                            </td>

                                            <td><a
                                                    href="{{ route('super_admin.departments-show', isset($department->id) ? $department->id : -1) }}">
                                                    <strong>{{ isset($department->departmentsType) ? $department->departmentsType->title_en : '----' }}</strong></a>
                                            </td>



                                            {{-- status --}}
                                            <td style="width: 15%">
                                                @if ($department->status == 'Active')
                                                    <strong>
                                                        <a href="{{ route('super_admin.departments-activeInactiveSingle', isset($department->id) ? $department->id : -1) }}"
                                                            class="process btn waves-effect waves-light btn-light-danger btn-sm"
                                                            title="Set Inactive"><i class="mdi mdi-pause"></i></a>
                                                        <span
                                                            style="color:green;">{{ isset($department->status) ? $department->status : '----' }}</span>
                                                    </strong>
                                                @elseif($department->status == 'Inactive')
                                                    <strong>
                                                        <a href="{{ route('super_admin.departments-activeInactiveSingle', isset($department->id) ? $department->id : -1) }}"
                                                            class="process btn waves-effect waves-light btn-light-success btn-sm"
                                                            title="Set Active"><i class="mdi mdi-play"></i></a>
                                                        <span
                                                            style="color:red;">{{ isset($department->status) ? $department->status : '----' }}</span>
                                                    </strong>
                                                @endif
                                            </td>

                                            @if ($department->department_type_id == 1)
                                                <td>{{ $department->web_projects_count }}</td>
                                            @elseif($department->department_type_id == 2)
                                                <td>{{ $department->mobile_projects_count }}</td>
                                            @elseif($department->department_type_id == 3)
                                                <td>{{ $department->design_projects_count }}</td>
                                            @elseif($department->department_type_id == 4)
                                                <td>{{ $numberOfProjectsSales }}</td>
                                            @else
                                                <td>-----</td>
                                            @endif

                                            {{-- Statistics --}}
                                            <td style="width: 25%">
                                                <ul class="list-style-none mt-3 mb-2">
                                                    <li>
                                                        <div class="d-flex align-items-center">
                                                            <div>
                                                                <h6 class="mb-0 fw-bold">Evaluation (Projects, Attendence)
                                                                    <span class="fw-light"></span>
                                                                </h6>
                                                            </div>
                                                            <div class="ms-auto">
                                                                <h6 class="mb-0 fw-bold">100%</h6>
                                                            </div>
                                                        </div>
                                                        <div class="progress mt-2">
                                                            <div class="progress-bar bg-danger" role="progressbar"
                                                                style="width: 25%" aria-valuenow="25" aria-valuemin="0"
                                                                aria-valuemax="100"></div>
                                                            <div class="progress-bar bg-cyan" role="progressbar"
                                                                style="width: 25%" aria-valuenow="25" aria-valuemin="0"
                                                                aria-valuemax="100"></div>
                                                            <div class="progress-bar bg-info" role="progressbar"
                                                                style="width: 25%" aria-valuenow="25" aria-valuemin="0"
                                                                aria-valuemax="100"></div>
                                                            <div class="progress-bar bg-success" role="progressbar"
                                                                style="width: 25%" aria-valuenow="25" aria-valuemin="0"
                                                                aria-valuemax="100"></div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </td>
                                            {{-- operations --}}
                                            <td>
                                                <div class="button-group">
                                                    <a href="{{ route('super_admin.departments-show', isset($department->id) ? $department->id : -1) }}"
                                                        class="btn waves-effect waves-light btn-primary btn-sm"
                                                        title="View Details"><i class="fas fa-eye"></i></a>
                                                    <a href="{{ route('super_admin.departments-edit', isset($department->id) ? $department->id : -1) }}"
                                                        class="btn waves-effect waves-light btn-secondary btn-sm"
                                                        title="Edit"><i class="fas fa-edit"></i></a>
                                                  
                                                    <!-- No projects associated, display the delete button -->

                                                    @if (
                                                        $department->webDepartmentProjects->isEmpty() &&
                                                            $department->mobileDepartmentProjects->isEmpty() &&
                                                            $department->designDepartmentProjects->isEmpty() &&
                                                            $department->departmentsType->title_en != 'Sales' &&
                                                            $department->departmentsType->title_en != 'Management' &&
                                                            $department->departmentsType->title_en != 'Finance' &&
                                                            $department->departmentsType->title_en != 'Human Resources')
                                                        {{-- 'Management', 'Finance', 'Human Resources' --}}
                                                        <a href="{{ route('super_admin.departments-softDelete', $department->id) }}"
                                                            class="confirm btn waves-effect waves-light btn-danger btn-sm"
                                                            title="Delete">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </a>
                                                    @endif
                                                    {{-- @endif --}}
                                                </div>
                                            </td>

                                            <td class="text-center">
                                                <input type="checkbox" class="selectedDepartments"
                                                    name="selectedDepartments[]" value="{{ $department->id }}">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra_js')
    {{-- Select/Deselect all --}}
    <script>
        var isSelectAllChecked = false;

        function selectDeselectAll() {
            // Get checkboxes using CSS class
            var selectedDepartments = document.querySelectorAll(".selectedDepartments");

            // Check if "Select All" checkbox is checked
            var selectAllCheckbox = document.getElementById("selectAllCheckbox");
            isSelectAllChecked = selectAllCheckbox.checked;

            // Toggle the checked state of all checkboxes based on the "Select All" checkbox
            for (var i = 0; i < selectedDepartments.length; i++) {
                selectedDepartments[i].checked = isSelectAllChecked;
            }
        }
    </script>

    {{-- table search and pagination --}}
    <script>
        $(document).ready(function() {
            if ($.fn.DataTable.isDataTable('#file_export')) {
                $('#file_export').DataTable().destroy();
            }

            $('#file_export').DataTable({
                paging: true,
                pageLength: 50, // Set the number of records per page
                order: [
                    [2, 'desc'] // Sorting by Date/Time column
                ],
                columnDefs: [{
                        type: 'date',
                        // targets: [2]
                    },
                    {
                        orderable: false,
                        targets: [5, 6, 7]
                    }
                ],
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'copy',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4] // Specify the columns you want to export
                        }
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4] // Specify the columns you want to export
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4] // Specify the columns you want to export
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4] // Specify the columns you want to export
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4] // Specify the columns you want to export
                        }
                    }
                ]
            });

            // Add styling to the DataTable buttons
            $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass(
                'btn btn-primary mr-1');
        });
    </script>

    {{-- Soft Delete Selected --}}
    <script>
        function softDeleteSelected() {
            //Collect the selected departments
            var selectedDepartments = [];
            $('input[name="selectedDepartments[]"]:checked').each(function() {
                selectedDepartments.push($(this).val());
            });

            //If departments are selected, you can perform the function here
            if (selectedDepartments.length > 0) {
                //Prepare the data as a query
                var query = '?selectedDepartments=' + selectedDepartments.join(',');
                // Create the link with the query
                var link = '{{ route('super_admin.departments-softDeleteSelected') }}' + query;
                // Direct the department to the link after preparing it
                window.location.href = link;
            } else {
                Swal.fire(
                    'Oops...',
                    'Please select at least one department',
                    'error'
                )
            }
        }
    </script>

    {{-- Active Selected --}}
    <script>
        function activeSelected() {
            //Collect the selected departments
            var selectedDepartments = [];
            $('input[name="selectedDepartments[]"]:checked').each(function() {
                selectedDepartments.push($(this).val());
            });

            //If departments are selected, you can perform the function here
            if (selectedDepartments.length > 0) {
                //Prepare the data as a query
                var query = '?selectedDepartments=' + selectedDepartments.join(',');
                // Create the link with the query
                var link = '{{ route('super_admin.departments-activeSelected') }}' + query;
                // Direct the browser to the link after preparing it
                window.location.href = link;
            } else {
                Swal.fire(
                    'Oops...',
                    'Please select at least one department',
                    'error'
                )
            }
        }
    </script>

    {{-- Inactive Selected --}}
    <script>
        function inactiveSelected() {
            //Collect the selected departments
            var selectedDepartments = [];
            $('input[name="selectedDepartments[]"]:checked').each(function() {
                selectedDepartments.push($(this).val());
            });

            //If departments are selected, you can perform the function here
            if (selectedDepartments.length > 0) {
                //Prepare the data as a query
                var query = '?selectedDepartments=' + selectedDepartments.join(',');
                // Create the link with the query
                var link = '{{ route('super_admin.departments-inactiveSelected') }}' + query;
                // Direct the browser to the link after preparing it
                window.location.href = link;
            } else {
                Swal.fire(
                    'Oops...',
                    'Please select at least one department',
                    'error'
                )
            }
        }
    </script>
@endsection
