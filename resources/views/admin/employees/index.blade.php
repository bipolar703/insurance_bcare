@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Employees
                    @if (isset($employees))
                        ({{ $employees->count() }})
                    @endif
                </h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Employees</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Create --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.employees-create') }}" class="btn btn-dark">
                            <i data-feather="plus" class="fill-white feather-sm"></i> Add New
                        </a>
                    </div>
                    {{-- Archive --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.employees-showSoftDelete') }}" class="btn btn-danger">
                            <i data-feather="archive" class="fill-white feather-sm"></i> View Archives
                        </a>
                    </div>
                    {{-- Setting --}}
                    @if (isset($employees) && $employees->count() > 0)
                        <div class="dropdown me-2">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Setting
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li><button id="softDeleteSelected" class="confirm dropdown-item"
                                        onclick="softDeleteSelected()">Delete Selected</button></li>
                                <li><button id="activeSelected" class="process dropdown-item"
                                        onclick="activeSelected()">Active
                                        Selected</button></li>
                                <li><button id="inactiveSelected" class="process dropdown-item"
                                        onclick="inactiveSelected()">Inactive Selected</button></li>
                            </ul>

                        </div>
                    @endif
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
                                        <th>Name</th>
                                        <th>Department</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Type</th>
                                        <th>Date/Time</th>
                                        <th>Status</th>
                                        <th>Control</th>
                                        <th>
                                            <input type="checkbox" class="toggleSelectAllCheckbox" id="selectAllCheckbox"
                                                onclick="selectDeselectAll()">
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employees as $employee)
                                        <tr>
                                            {{-- name --}}
                                            <td><a
                                                    href="{{ route('super_admin.employees-show', isset($employee->id) ? $employee->id : -1) }}"><strong>{{ isset($employee->name) ? $employee->name : '----' }}</strong></a>
                                            </td>

                                            {{-- department --}}
                                            <td>
                                                <a
                                                    href="{{ route('super_admin.departments-show', ['id' => $employee->department_id, 'department_id' => isset($employee->department_id) ? $employee->department_id : '----']) }}">
                                                    <strong>{{ isset($employee->department->name) ? $employee->department->name : '----' }}</strong>
                                                </a>
                                            </td>

                                            {{-- email --}}
                                            <td><a
                                                    href="{{ route('super_admin.employees-show', isset($employee->id) ? $employee->id : -1) }}">{{ isset($employee->email) ? $employee->email : '----' }}</a>
                                            </td>

                                            {{-- phone --}}
                                            <td>{{ isset($employee->phone) && isset($employee->country_phone_id) ? '(+' . $employee->countryPhoneKey->phone_code . ') ' . $employee->phone : '----' }}
                                            </td>

                                            {{-- type --}}
                                            <td> <strong>{{ isset($employee->employeeType) ? $employee->employeeType->title_en : '----' }} </strong>
                                            </td>

                                            {{-- created_at --}}
                                            <td>{!! isset($employee->created_at)
                                                ? '<strong>Date : </strong>' .
                                                    date('Y -m-d', strtotime($employee->created_at)) .
                                                    '<br><strong>Time : </strong>' .
                                                    date('h:i A', strtotime($employee->created_at)) .
                                                    '<br><strong>Since : </strong> ' .
                                                    $employee->created_at->diffForHumans()
                                                : "<span style='color:blue;'>----------</span>" !!}
                                            </td>

                                            {{-- status --}}
                                            <td>
                                                @if ($employee->status == 'Active')
                                                    <a href="{{ route('super_admin.employees-activeInactiveSingle', isset($employee->id) ? $employee->id : -1) }}"
                                                        class="process btn waves-effect waves-light btn-light-danger btn-sm"
                                                        title="Set Inactive"><i class="mdi mdi-pause"></i></a>
                                                    <span style="color:green;">
                                                        <strong>{{ isset($employee->status) ? $employee->status : '----' }}
                                                        </strong></span>
                                                @elseif($employee->status == 'Inactive')
                                                    <a href="{{ route('super_admin.employees-activeInactiveSingle', isset($employee->id) ? $employee->id : -1) }}"
                                                        class="process btn waves-effect waves-light btn-light-success btn-sm"
                                                        title="Set Active"><i class="mdi mdi-play"></i></a>
                                                    <span style="color:red;"><strong>{{ isset($employee->status) ? $employee->status : '----' }}
                                                        </strong></span>
                                                @endif
                                            </td>

                                            {{-- operations --}}
                                            <td>
                                                <div class="button-group">
                                                    <a href="{{ route('super_admin.employees-show', isset($employee->id) ? $employee->id : -1) }}"
                                                        class="btn waves-effect waves-light btn-primary btn-sm"
                                                        title="View Details"><i class="fas fa-eye"></i></a>
                                                    <a href="{{ route('super_admin.employees-edit', isset($employee->id) ? $employee->id : -1) }}"
                                                        class="btn waves-effect waves-light btn-secondary btn-sm"
                                                        title="Edit"><i class="fas fa-edit"></i></a>
                                                    <a href="{{ route('super_admin.employees-softDelete', isset($employee->id) ? $employee->id : -1) }}"
                                                        class="confirm btn waves-effect waves-light btn-danger btn-sm"
                                                        title="Delete"><i class="fas fa-trash-alt"></i></a>
                                                </div>
                                            </td>

                                            <td class="text-center">
                                                <input type="checkbox" class="selectedEmployees" name="selectedEmployees[]"
                                                    value="{{ $employee->id }}">
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
            var selectedEmployees = document.querySelectorAll(".selectedEmployees");

            // Check if "Select All" checkbox is checked
            var selectAllCheckbox = document.getElementById("selectAllCheckbox");
            isSelectAllChecked = selectAllCheckbox.checked;

            // Toggle the checked state of all checkboxes based on the "Select All" checkbox
            for (var i = 0; i < selectedEmployees.length; i++) {
                selectedEmployees[i].checked = isSelectAllChecked;
            }
        }
    </script>


    {{-- Soft Delete Selected --}}
    <script>
        function softDeleteSelected() {
            //Collect the selected cars
            var selectedEmployees = [];
            $('input[name="selectedEmployees[]"]:checked').each(function() {
                selectedEmployees.push($(this).val());
            });

            //If cars are selected, you can perform the function here
            if (selectedEmployees.length > 0) {
                //Prepare the data as a query
                var query = '?selectedEmployees=' + selectedEmployees.join(',');
                // Create the link with the query
                var link = '{{ route('super_admin.employees-softDeleteSelected') }}' + query;
                // Direct the bcarser to the link after preparing it
                window.location.href = link;
            } else {
                Swal.fire(
                    'Oops...',
                    'Please select at least one Task',
                    'error'
                )
            }
        }
    </script>


    {{-- Active Selected --}}
    <script>
        function activeSelected() {
            //Collect the selected cars
            var selectedEmployees = [];
            $('input[name="selectedEmployees[]"]:checked').each(function() {
                selectedEmployees.push($(this).val());
            });

            //If cars are selected, you can perform the function here
            if (selectedEmployees.length > 0) {
                //Prepare the data as a query
                var query = '?selectedEmployees=' + selectedEmployees.join(',');
                // Create the link with the query
                var link = '{{ route('super_admin.employees-activeSelected') }}' + query;
                // Direct the browser to the link after preparing it
                window.location.href = link;
            } else {
                Swal.fire(
                    'Oops...',
                    'Please select at least one row',
                    'error'
                )
            }
        }
    </script>

    {{-- Inactive Selected --}}
    <script>
        function inactiveSelected() {
            //Collect the selected cars
            var selectedEmployees = [];
            $('input[name="selectedEmployees[]"]:checked').each(function() {
                selectedEmployees.push($(this).val());
            });

            //If cars are selected, you can perform the function here
            if (selectedEmployees.length > 0) {
                //Prepare the data as a query
                var query = '?selectedEmployees=' + selectedEmployees.join(',');
                // Create the link with the query
                var link = '{{ route('super_admin.employees-inactiveSelected') }}' + query;
                // Direct the browser to the link after preparing it
                window.location.href = link;
            } else {
                Swal.fire(
                    'Oops...',
                    'Please select at least one row',
                    'error'
                )
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
                    [0, 'desc'] // Sorting  column
                ],
                columnDefs: [{
                        type: 'date',
                        // targets: [2]
                    },
                    {
                        orderable: false,
                        targets: [8, 6, 7]
                    }
                ],
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'copy',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6] // Specify the columns you want to export
                        }
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6] // Specify the columns you want to export
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6] // Specify the columns you want to export
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6] // Specify the columns you want to export
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6] // Specify the columns you want to export
                        }
                    }
                ]
            });

            // Add styling to the DataTable buttons
            $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass(
                'btn btn-primary mr-1');
        });
    </script>
@endsection
