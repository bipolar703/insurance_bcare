@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Expenses Categories
                    @if (isset($expensesCategories))
                        ({{ $expensesCategories->count() }})
                    @endif
                </h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Expenses Categories</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Create --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.expenses_categories-create') }}" class="btn btn-dark">
                            <i data-feather="plus" class="fill-white feather-sm"></i> Add New
                        </a>
                    </div>
                    {{-- Archive --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.expenses_categories-showSoftDelete') }}" class="btn btn-danger">
                            <i data-feather="archive" class="fill-white feather-sm"></i> View Archive
                        </a>
                    </div>
                    @if (isset($expensesCategories) && $expensesCategories->count() > 0)
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
                                    @if (isset($expensesCategories))
                                        @foreach ($expensesCategories as $expensesCategory)
                                            <tr>
                                                {{-- title_ar --}}
                                                <td>
                                                    <a
                                                        href="{{ route('super_admin.expenses_categories-show', isset($expensesCategory->id) ? $expensesCategory->id : -1) }}">
                                                        <strong>{{ isset($expensesCategory->title_ar) ? $expensesCategory->title_ar : '----' }}</strong>
                                                    </a>
                                                </td>

                                                {{-- title_en --}}
                                                <td>
                                                    <a
                                                        href="{{ route('super_admin.expenses_categories-show', isset($expensesCategory->id) ? $expensesCategory->id : -1) }}">
                                                        <strong>{{ isset($expensesCategory->title_en) ? $expensesCategory->title_en : '----' }}</strong>
                                                    </a>
                                                </td>
                                                {{-- Count --}}
                                                <td>
                                                    <strong>{{ optional($expensesCategory->expenses)->count() ?: '0' }}</strong>
                                                </td>
                                                {{-- Cost --}}
                                                <td>
                                                    <strong  style="color: red">{{ optional($expensesCategory->expenses)->sum('amount') ?: '0' }} JOD</strong>
                                                </td>

                                               
                                                {{-- Created By --}}
                                                <td>{{ isset($expensesCategory->createdBy->name) ? $expensesCategory->createdBy->name : '----' }}
                                                </td>
                                                {{-- status --}}
                                                <td>
                                                    @if ($expensesCategory->status == 'Active')
                                                        <a href="{{ route('super_admin.expenses_categories-activeInactiveSingle', isset($expensesCategory->id) ? $expensesCategory->id : -1) }}"
                                                            class="process btn waves-effect waves-light btn-light-danger btn-sm"
                                                            title="Set Inactive"><i class="mdi mdi-pause"></i>
                                                        </a>
                                                        <span
                                                            style="color:green;"><strong>{{ isset($expensesCategory->status) ? $expensesCategory->status : '----' }}</strong></span>
                                                    @elseif($expensesCategory->status == 'Inactive')
                                                        <a href="{{ route('super_admin.expenses_categories-activeInactiveSingle', isset($expensesCategory->id) ? $expensesCategory->id : -1) }}"
                                                            class="process btn waves-effect waves-light btn-light-success btn-sm"
                                                            title="Set Active"><i class="mdi mdi-play"></i>
                                                        </a>
                                                        <span style="color:red;"> <strong>
                                                                {{ isset($expensesCategory->status) ? $expensesCategory->status : '----' }}
                                                            </strong> </span>
                                                    @else
                                                        -----
                                                    @endif
                                                </td>
                                                 {{-- created_at --}}
                                                 <td>
                                                    {!! isset($expensesCategory->created_at)
                                                        ? $expensesCategory->created_at->toDateString()
                                                        : "<span style='color:blue;'>----------</span>" !!}
                                                </td>

                                                {{-- operations --}}
                                                <td>
                                                    <div class="button-group">
                                                        <a href="{{ route('super_admin.expenses_categories-show', isset($expensesCategory->id) ? $expensesCategory->id : -1) }}"
                                                            class="btn waves-effect waves-light btn-primary btn-sm"
                                                            title="View Details"><i class="fas fa-eye"></i></a>
                                                        <a href="{{ route('super_admin.expenses_categories-edit', isset($expensesCategory->id) ? $expensesCategory->id : -1) }}"
                                                            class="btn waves-effect waves-light btn-secondary btn-sm"
                                                            title="Edit"><i class="fas fa-edit"></i></a>
                                                        <a href="{{ route('super_admin.expenses_categories-softDelete', isset($expensesCategory->id) ? $expensesCategory->id : -1) }}"
                                                            class="confirm btn waves-effect waves-light btn-danger btn-sm"
                                                            title="Delete"><i class="fas fa-trash-alt"></i></a>
                                                    </div>
                                                </td>

                                                <td class="text-center">
                                                    <input type="checkbox" class="selectedExpensesCategories"
                                                        name="selectedExpensesCategories[]" value="{{ $expensesCategory->id }}">
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
            var selectedExpensesCategories = document.querySelectorAll(".selectedExpensesCategories");
            // Determine whether the boxes are selected or not
            var areAllChecked = true;
            for (var i = 0; i < selectedExpensesCategories.length; i++) {
                if (!selectedExpensesCategories[i].checked) {
                    areAllChecked = false;
                    break;
                }
            }
            // Change the status of the check box based on the current status
            for (var i = 0; i < selectedExpensesCategories.length; i++) {
                selectedExpensesCategories[i].checked = !areAllChecked;
            }
        }
    </script>


    {{-- Soft Delete Selected --}}
    <script>
        function softDeleteSelected() {
            //Collect the selected admins
            var selectedExpensesCategories = [];
            $('input[name="selectedExpensesCategories[]"]:checked').each(function() {
                selectedExpensesCategories.push($(this).val());
            });

            //If admins are selected, you can perform the function here
            if (selectedExpensesCategories.length > 0) {
                //Prepare the data as a query
                var query = '?selectedExpensesCategories=' + selectedExpensesCategories.join(',');
                // Create the link with the query
                var link = '{{ route('super_admin.expenses_categories-softDeleteSelected') }}' + query;
                // Direct the customers to the link after preparing it
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
            var selectedExpensesCategories = [];
            $('input[name="selectedExpensesCategories[]"]:checked').each(function() {
                selectedExpensesCategories.push($(this).val());
            });

            //If admins are selected, you can perform the function here
            if (selectedExpensesCategories.length > 0) {
                //Prepare the data as a query
                var query = '?selectedExpensesCategories=' + selectedExpensesCategories.join(',');
                // Create the link with the query
                var link = '{{ route('super_admin.expenses_categories-activeSelected') }}' + query;
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
            var selectedExpensesCategories = [];
            $('input[name="selectedExpensesCategories[]"]:checked').each(function() {
                selectedExpensesCategories.push($(this).val());
            });

            //If admins are selected, you can perform the function here
            if (selectedExpensesCategories.length > 0) {
                //Prepare the data as a query
                var query = '?selectedExpensesCategories=' + selectedExpensesCategories.join(',');
                // Create the link with the query
                var link = '{{ route('super_admin.expenses_categories-inactiveSelected') }}' + query;
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