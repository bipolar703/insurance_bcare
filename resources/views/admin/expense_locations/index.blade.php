@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Expense Locations
                    @if (isset($expenseLocations))
                        ({{ $expenseLocations->count() }})
                    @endif
                </h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Expense Locations</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Create --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.expense_locations-create') }}" class="btn btn-dark">
                            <i data-feather="plus" class="fill-white feather-sm"></i> Add New
                        </a>
                    </div>
                    {{-- Archive --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.expense_locations-showSoftDelete') }}" class="btn btn-danger">
                            <i data-feather="archive" class="fill-white feather-sm"></i> View Archive
                        </a>
                    </div>
                    @if (isset($expenseLocations) && $expenseLocations->count() > 0)
                        {{-- Setting --}}
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


                        {{-- <div class="dropdown me-2">
                            <button class="toggleSelectAllButton btn btn-primary" onclick="selectDeselectAll()">
                                Select/Deselect all</button>
                        </div> --}}
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
                                        <th>Title AR</th>
                                        <th>Title EN</th>
                                        <th>Count</th>
                                        <th>Cost</th>
                                        <th>Created By</th>
                                        <th>Status</th>
                                        <th>Date/Time</th>
                                        <th>Control</th>
                                        <th>
                                            <input type="checkbox" class="toggleSelectAllCheckbox" id="selectAllCheckbox"
                                                onclick="selectDeselectAll()">
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($expenseLocations))
                                        @foreach ($expenseLocations as $expenseLocation)
                                            <tr>
                                                {{-- title_ar --}}
                                                <td>
                                                    <a
                                                        href="{{ route('super_admin.expense_locations-show', isset($expenseLocation->id) ? $expenseLocation->id : -1) }}">
                                                        <strong>{{ isset($expenseLocation->title_ar) ? $expenseLocation->title_ar : '----' }}</strong>
                                                    </a>
                                                </td>

                                                {{-- title_en --}}
                                                <td>
                                                    <a
                                                        href="{{ route('super_admin.expense_locations-show', isset($expenseLocation->id) ? $expenseLocation->id : -1) }}">
                                                        <strong>{{ isset($expenseLocation->title_en) ? $expenseLocation->title_en : '----' }}</strong>
                                                    </a>
                                                </td>

                                               
                                                {{-- count --}}
                                                <td>
                                                    <strong>{{ optional($expenseLocation->expenses)->count() ?: '0' }}</strong>
                                                </td>
                                                {{-- amount --}}
                                                <td>
                                                    <strong
                                                        style="color: red">{{ optional($expenseLocation->expenses)->sum('amount') ?: '0' }}
                                                        JOD</strong>
                                                </td>
                                                 {{-- created_by --}}
                                                 <td>
                                                    <a
                                                        href="{{ route('super_admin.employees-show', ['id' => isset($expenseLocation->createdBy->id) ? $expenseLocation->createdBy->id : '----']) }}">
                                                        <strong>{{ isset($expenseLocation->createdBy->name) ? $expenseLocation->createdBy->name : '----' }}</strong>
                                                    </a>
                                                </td>
                                                  {{-- status --}}
                                                  <td>
                                                    @if ($expenseLocation->status == 'Active')
                                                        <a href="{{ route('super_admin.expense_locations-activeInactiveSingle', isset($expenseLocation->id) ? $expenseLocation->id : -1) }}"
                                                            class="process btn waves-effect waves-light btn-light-danger btn-sm"
                                                            title="Set Inactive"><i class="mdi mdi-pause"></i>
                                                        </a>
                                                        <span
                                                            style="color:green;"><strong>{{ isset($expenseLocation->status) ? $expenseLocation->status : '----' }}</strong></span>
                                                    @elseif($expenseLocation->status == 'Inactive')
                                                        <a href="{{ route('super_admin.expense_locations-activeInactiveSingle', isset($expenseLocation->id) ? $expenseLocation->id : -1) }}"
                                                            class="process btn waves-effect waves-light btn-light-success btn-sm"
                                                            title="Set Active"><i class="mdi mdi-play"></i>
                                                        </a>
                                                        <span style="color:red;"> <strong>
                                                                {{ isset($expenseLocation->status) ? $expenseLocation->status : '----' }}
                                                            </strong> </span>
                                                    @else
                                                        -----
                                                    @endif
                                                </td>

                                                {{-- created_at --}}
                                                <td>
                                                    {!! isset($expenseLocation->created_at)
                                                        ? $expenseLocation->created_at->toDateString()
                                                        : "<span style='color:blue;'>----------</span>" !!}
                                                </td>

                                              

                                                {{-- operations --}}
                                                <td>
                                                    <div class="button-group">
                                                        <a href="{{ route('super_admin.expense_locations-show', isset($expenseLocation->id) ? $expenseLocation->id : -1) }}"
                                                            class="btn waves-effect waves-light btn-primary btn-sm"
                                                            title="View Details"><i class="fas fa-eye"></i></a>
                                                        <a href="{{ route('super_admin.expense_locations-edit', isset($expenseLocation->id) ? $expenseLocation->id : -1) }}"
                                                            class="btn waves-effect waves-light btn-secondary btn-sm"
                                                            title="Edit"><i class="fas fa-edit"></i></a>
                                                        <a href="{{ route('super_admin.expense_locations-softDelete', isset($expenseLocation->id) ? $expenseLocation->id : -1) }}"
                                                            class="confirm btn waves-effect waves-light btn-danger btn-sm"
                                                            title="Delete"><i class="fas fa-trash-alt"></i></a>
                                                    </div>
                                                </td>

                                                <td class="text-center">
                                                    <input type="checkbox" class="selectedExpenseLocations"
                                                        name="selectedExpenseLocations[]" value="{{ $expenseLocation->id }}">
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
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
        function selectDeselectAll() {
            // Get bcheckbox using CSS class classes
            var selectedExpenseLocations = document.querySelectorAll(".selectedExpenseLocations");
            // Determine whether the boxes are selected or not
            var areAllChecked = true;
            for (var i = 0; i < selectedExpenseLocations.length; i++) {
                if (!selectedExpenseLocations[i].checked) {
                    areAllChecked = false;
                    break;
                }
            }
            // Change the status of the check box based on the current status
            for (var i = 0; i < selectedExpenseLocations.length; i++) {
                selectedExpenseLocations[i].checked = !areAllChecked;
            }
        }
    </script>


    {{-- Soft Delete Selected --}}
    <script>
        function softDeleteSelected() {
            //Collect the selected admins
            var selectedExpenseLocations = [];
            $('input[name="selectedExpenseLocations[]"]:checked').each(function() {
                selectedExpenseLocations.push($(this).val());
            });

            //If admins are selected, you can perform the function here
            if (selectedExpenseLocations.length > 0) {
                //Prepare the data as a query
                var query = '?selectedExpenseLocations=' + selectedExpenseLocations.join(',');
                // Create the link with the query
                var link = '{{ route('super_admin.expense_locations-softDeleteSelected') }}' + query;
                // Direct the Costs Centers to the link after preparing it
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


    {{-- Active Selected --}}
    <script>
        function activeSelected() {
            //Collect the selected admins
            var selectedExpenseLocations = [];
            $('input[name="selectedExpenseLocations[]"]:checked').each(function() {
                selectedExpenseLocations.push($(this).val());
            });

            //If admins are selected, you can perform the function here
            if (selectedExpenseLocations.length > 0) {
                //Prepare the data as a query
                var query = '?selectedExpenseLocations=' + selectedExpenseLocations.join(',');
                // Create the link with the query
                var link = '{{ route('super_admin.expense_locations-activeSelected') }}' + query;
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
            //Collect the selected admins
            var selectedExpenseLocations = [];
            $('input[name="selectedExpenseLocations[]"]:checked').each(function() {
                selectedExpenseLocations.push($(this).val());
            });

            //If admins are selected, you can perform the function here
            if (selectedExpenseLocations.length > 0) {
                //Prepare the data as a query
                var query = '?selectedExpenseLocations=' + selectedExpenseLocations.join(',');
                // Create the link with the query
                var link = '{{ route('super_admin.expense_locations-inactiveSelected') }}' + query;
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

    <script>
        $(document).ready(function() {
            if ($.fn.DataTable.isDataTable('#file_export')) {
                $('#file_export').DataTable().destroy();
            }

            $('#file_export').DataTable({
                paging: true,
                searching:false,
                pageLength: 50, // Set the number of records per page
                order: [
                    [3, 'desc'] // Sorting by Date/Time column
                ],
                columnDefs: [{
                        type: 'date',
                        targets: [3]
                    },
                    {
                        orderable: false,
                        targets: [6,7]
                    }
                ],
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });

            // Add styling to the DataTable buttons
            $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass(
                'btn btn-primary mr-1');
        });
    </script>


    {{-- passed the test in https://validatejavascript.com/  using custom JS config --}}
    {{-- select 2 script --}}
    <script>
        $(document).ready(function() {
            $('select[name="customerID"]').select2();
            $('select[name="search"]').select2();
        });
    </script>
@endsection
