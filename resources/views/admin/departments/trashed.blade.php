@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Departments</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.departments-index') }}">Departments</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Archives</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Create --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.departments-create') }}" class="btn btn-dark">
                            <i data-feather="plus" class="fill-white feather-sm"></i> Add New Department
                        </a>
                    </div>
                    @if (isset($departments) && $departments->count() > 0)
                        {{-- Setting --}}
                        <div class="dropdown me-2">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Setting
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li><button id="softDeleteRestoreSelected" class="unarchive dropdown-item"
                                        onclick="softDeleteRestoreSelected()">Restore Selected Departments</button>
                                </li>
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
                        <div class="table-responsive">
                            <table id="file_export" class="table table-striped table-bordered display">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Code</th>
                                        <th>Status</th>
                                        <th>Type</th>
                                        <th>Created By</th>
                                        <th>Date/Time</th>
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

                                            <td>{{ isset($department->name) ? $department->name : '----' }}</td>
                                            <td>{{ isset($department->code) ? $department->code : '----' }}</td>
                                            <th>
                                                @if ($department->status == 'Active')
                                                    <span
                                                        style="color:green;">{{ isset($department->status) ? $department->status : '----' }}</span>
                                                @elseif($department->status == 'Inactive')
                                                    <span
                                                        style="color:red;">{{ isset($department->status) ? $department->status : '----' }}</span>
                                                @endif
                                            </th>
                                            <td>{{ isset($department->departmentsType) ? $department->departmentsType->title_en : '----' }}</td>

                                            <td>{{ isset($department->created_by) ? $department->created_by : '----' }}
                                            </td>
                                            <td>{!! isset($department->created_at)
                                                ? '<strong>Date : </strong>' .
                                                    date('Y -m-d', strtotime($department->created_at)) .
                                                    '<br><strong>Time : </strong>' .
                                                    date('h:i A', strtotime($department->created_at)) .
                                                    '<br><strong>Since : </strong> ' .
                                                    $department->created_at->diffForHumans()
                                                : "<span style='color:blue;'>----------</span>" !!}</td>
                                            <td>
                                                <div class="button-group">
                                                    <a href="{{ route('super_admin.departments-softDeleteRestore', [isset($department->id) ? $department->id : -1]) }}"
                                                        class="unarchive btn waves-effect waves-light btn-success btn-sm"
                                                        title="Restore this Record"><i class="mdi mdi-redo-variant"></i></a>
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



    {{-- Soft Delete Restore Selected --}}
    <script>
        function softDeleteRestoreSelected() {
            // Collect the selected rows
            var selectedDepartments = [];
            $('input[name="selectedDepartments[]"]:checked').each(function() {
                selectedDepartments.push($(this).val());
            });
            //If rows are selected, you can perform the function here
            if (selectedDepartments.length > 0) {
                //Prepare the data as a query
                var query = '?selectedDepartments=' + selectedDepartments.join(',');
                // Create the link with the query
                var link = '{{ route('super_admin.departments-softDeleteRestoreSelected') }}' + query;
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
                    [0, 'desc'] // Sorting by Date/Time column
                ],
                columnDefs: [{
                        type: 'date',
                        // targets: [2]
                    },
                    {
                        orderable: false,
                        targets: [6, 7]
                    }
                ],
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'copy',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5] // Specify the columns you want to export
                        }
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5] // Specify the columns you want to export
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5] // Specify the columns you want to export
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5] // Specify the columns you want to export
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5] // Specify the columns you want to export
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
