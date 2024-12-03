@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Vendors
                    @if (isset($vendors))
                        ({{ $vendors->count() }})
                    @endif
                </h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Vendors</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Create --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.vendors-create') }}" class="btn btn-dark">
                            <i data-feather="plus" class="fill-white feather-sm"></i> Add New Vendor
                        </a>
                    </div>
                    {{-- Archive --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.vendors-showSoftDelete') }}" class="btn btn-danger">
                            <i data-feather="archive" class="fill-white feather-sm"></i> View Archive
                        </a>
                    </div>
                    @if (isset($vendors) && $vendors->count() > 0)
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
                                        onclick="activeSelected()">Active Selected</button></li>
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
                        <div class="table-responsive">
                            <table id="file_export" class="table table-striped table-bordered display">
                                <thead>
                                    <tr>
                                        <th>Name AR</th>
                                        <th>Name EN</th>
                                        <th>Balance</th>
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
                                    @if (isset($vendors))
                                        @foreach ($vendors as $vendor)
                                            <tr>
                                                {{-- name_ar --}}
                                                <td>
                                                    <a
                                                        href="{{ route('super_admin.vendors-show', isset($vendor->id) ? $vendor->id : -1) }}">
                                                        <strong>{{ isset($vendor->name_ar) ? $vendor->name_ar : '----' }}</strong>
                                                    </a>
                                                </td>

                                                {{-- name_en --}}
                                                <td>
                                                    <a
                                                        href="{{ route('super_admin.vendors-show', isset($vendor->id) ? $vendor->id : -1) }}">
                                                        <strong>{{ isset($vendor->name_en) ? $vendor->name_en : '----' }}</strong>
                                                    </a>
                                                </td>

                                                {{-- balance --}}
                                                <td>
                                                    <a
                                                        href="{{ route('super_admin.vendors-show', isset($vendor->id) ? $vendor->id : -1) }}">
                                                        <strong>{{ isset($vendor->balance) ? $vendor->balance .' JOD' : '----' }}</strong>
                                                    </a>
                                                </td>

                                                {{-- created_at --}}
                                                <td>
                                                    {!! isset($vendor->created_at)
                                                        ? $vendor->created_at->toDateString()
                                                        : "<span style='color:blue;'>----------</span>" !!}
                                                </td>

                                                {{-- status --}}
                                                <td>
                                                    @if ($vendor->status == 'Active')
                                                        <a href="{{ route('super_admin.vendors-activeInactiveSingle', isset($vendor->id) ? $vendor->id : -1) }}"
                                                            class="process btn waves-effect waves-light btn-light-danger btn-sm"
                                                            title="Set Inactive"><i class="mdi mdi-pause"></i>
                                                        </a>
                                                        <span
                                                            style="color:green;"><strong>{{ isset($vendor->status) ? $vendor->status : '----' }}</strong></span>
                                                    @elseif($vendor->status == 'Inactive')
                                                        <a href="{{ route('super_admin.vendors-activeInactiveSingle', isset($vendor->id) ? $vendor->id : -1) }}"
                                                            class="process btn waves-effect waves-light btn-light-success btn-sm"
                                                            title="Set Active"><i class="mdi mdi-play"></i>
                                                        </a>
                                                        <span style="color:red;"> <strong>
                                                                {{ isset($vendor->status) ? $vendor->status : '----' }}
                                                            </strong> </span>
                                                    @else
                                                        -----
                                                    @endif
                                                </td>

                                                {{-- operations --}}
                                                <td>
                                                    <div class="button-group">
                                                        <a href="{{ route('super_admin.vendors-show', isset($vendor->id) ? $vendor->id : -1) }}"
                                                            class="btn waves-effect waves-light btn-primary btn-sm"
                                                            title="View Details"><i class="fas fa-eye"></i></a>
                                                        <a href="{{ route('super_admin.vendors-edit', isset($vendor->id) ? $vendor->id : -1) }}"
                                                            class="btn waves-effect waves-light btn-secondary btn-sm"
                                                            title="Edit"><i class="fas fa-edit"></i></a>
                                                        <a href="{{ route('super_admin.vendors-softDelete', isset($vendor->id) ? $vendor->id : -1) }}"
                                                            class="confirm btn waves-effect waves-light btn-danger btn-sm"
                                                            title="Delete"><i class="fas fa-trash-alt"></i></a>
                                                    </div>
                                                </td>

                                                <td class="text-center">
                                                    <input type="checkbox" class="selectedVendors" name="selectedVendors[]"
                                                        value="{{ $vendor->id }}">
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
            var selectedVendors = document.querySelectorAll(".selectedVendors");
            // Determine whether the boxes are selected or not
            var areAllChecked = true;
            for (var i = 0; i < selectedVendors.length; i++) {
                if (!selectedVendors[i].checked) {
                    areAllChecked = false;
                    break;
                }
            }
            // Change the status of the check box based on the current status
            for (var i = 0; i < selectedVendors.length; i++) {
                selectedVendors[i].checked = !areAllChecked;
            }
        }
    </script>


    {{-- Soft Delete Selected --}}
    <script>
        function softDeleteSelected() {
            //Collect the selected admins
            var selectedVendors = [];
            $('input[name="selectedVendors[]"]:checked').each(function() {
                selectedVendors.push($(this).val());
            });

            //If admins are selected, you can perform the function here
            if (selectedVendors.length > 0) {
                //Prepare the data as a query
                var query = '?selectedVendors=' + selectedVendors.join(',');
                // Create the link with the query
                var link = '{{ route('super_admin.vendors-softDeleteSelected') }}' + query;
                // Direct the vendors to the link after preparing it
                window.location.href = link;
            } else {
                Swal.fire(
                    'Oops...',
                    'Please select at least one customer',
                    'error'
                )
            }
        }
    </script>


    {{-- Active Selected --}}
    <script>
        function activeSelected() {
            //Collect the selected admins
            var selectedVendors = [];
            $('input[name="selectedVendors[]"]:checked').each(function() {
                selectedVendors.push($(this).val());
            });

            //If admins are selected, you can perform the function here
            if (selectedVendors.length > 0) {
                //Prepare the data as a query
                var query = '?selectedVendors=' + selectedVendors.join(',');
                // Create the link with the query
                var link = '{{ route('super_admin.vendors-activeSelected') }}' + query;
                // Direct the browser to the link after preparing it
                window.location.href = link;
            } else {
                Swal.fire(
                    'Oops...',
                    'Please select at least one customer',
                    'error'
                )
            }
        }
    </script>


    {{-- Inactive Selected --}}
    <script>
        function inactiveSelected() {
            //Collect the selected admins
            var selectedVendors = [];
            $('input[name="selectedVendors[]"]:checked').each(function() {
                selectedVendors.push($(this).val());
            });

            //If admins are selected, you can perform the function here
            if (selectedVendors.length > 0) {
                //Prepare the data as a query
                var query = '?selectedVendors=' + selectedVendors.join(',');
                // Create the link with the query
                var link = '{{ route('super_admin.vendors-inactiveSelected') }}' + query;
                // Direct the browser to the link after preparing it
                window.location.href = link;
            } else {
                Swal.fire(
                    'Oops...',
                    'Please select at least one customer',
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
                pageLength: 50, // Set the number of records per page
                order: [
                    [3, 'desc'] // Sorting by Date/Time column
                ],
                columnDefs: [{
                        type: 'date',
                        targets: [2]
                    },
                    {
                        orderable: false,
                        targets: [3, 4, 5]
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
