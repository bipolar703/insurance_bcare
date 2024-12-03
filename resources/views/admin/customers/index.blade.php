@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Customers
                    @if (isset($customers))
                        ({{ $customers->count() }})
                    @endif
                </h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">All Customers</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Create --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.customers-create') }}" class="btn btn-dark">
                            <i data-feather="plus" class="fill-white feather-sm"></i> Add New
                        </a>
                    </div>
                    {{-- Archive --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.customers-showSoftDelete') }}" class="btn btn-danger">
                            <i data-feather="archive" class="fill-white feather-sm"></i> View Archive
                        </a>
                    </div>
                    @if (isset($customers) && $customers->count() > 0)
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
                        {{-- Search --}}
                        <div class="col-md-12 groove-container">
                            <label>
                                <h2>Search Section</h2>
                            </label>
                            <br>
                            <form action="{{ route('super_admin.customers-search') }}" method="get" class="row g-3"
                                id="searchForm">
                                @csrf

                                {{-- name --}}
                                <div class="col-md-4">
                                    <label for="name" class="form-label">Customer Name</label>
                                    <input type="text" name="name"
                                        class="form-control border border-info @error('name') border-danger @enderror"
                                        id="tb-name" value="{{ $searchValues['name'] ?? '' }}"
                                        placeholder="Customer Name">
                                    <label for="tb-name">
                                        <strong class="text-danger">
                                            @error('name')
                                                ( {{ $message }} )
                                            @enderror
                                        </strong>
                                    </label>
                                </div>

                                {{-- Customer Dropdown --}}
                                {{-- <div class="col-md-6">
                                <label for="customerID" class="form-label">Select Customer Name</label>
                                <select name="customerID" onchange="getCustomerProjects()"
                                    class="form-control @error('customerID') border border-danger @enderror"
                                    id="customerID">
                                    <option value="" disabled selected>Select Customer Name</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}"
                                            @if (isset($searchValues['customerID']) && ($searchValues['customerID'] == $customer->id || old('id') == $customer->id)) selected @endif>
                                            {{ $customer->name_en ?? '------' }}
                                            ({{ $customer->name_ar ?? '------' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div> --}}
                                {{-- Customer Dropdown --}}
                                {{-- <div class="col-md-6">
                                <label for="customerID" class="form-label">Select Customer Name</label>
                                <select name="customerID" onchange="getCustomerProjects()"
                                    class="form-control @error('customerID') border border-danger @enderror"
                                    id="customerID">
                                    <option value="" disabled selected>Select Customer Name</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}"
                                            @if ((isset($searchValues['customerID']) && $searchValues['customerID'] == $customer->id) || old('customerID') == $customer->id) selected @endif>
                                            {{ $customer->name_en ?? '------' }}
                                            ({{ $customer->name_ar ?? '------' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div> --}}

                                {{-- Customer Dropdown --}}
                                <div class="col-md-4">
                                    <label for="customerID" class="form-label">Select Customer Name</label>
                                    <select name="customerID" onchange="getCustomerProjects()"
                                        class="form-control @error('customerID') border border-danger @enderror"
                                        id="customerID">
                                        <option value="" disabled selected>Select Customer Name</option>
                                        @if (isset($allCustomers))
                                            @foreach ($allCustomers as $customer)
                                                <option value="{{ $customer->id }}"
                                                    @if (
                                                        (isset($searchValues['customerID']) && $searchValues['customerID'] == $customer->id) ||
                                                            old('customerID') == $customer->id) selected @endif>
                                                    {{ $customer->name_en ?? '------' }}
                                                    ({{ $customer->name_ar ?? '------' }})
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                {{-- Status Dropdown --}}
                                <div class="col-md-4">
                                    <label for="status" class="form-label">Choose Customers Status</label>
                                    <select name="status"
                                        class="form-control @error('status') border border-danger @enderror">
                                        <option value="">--- Choose Customers Status ---</option>
                                        <option value="1" @if (isset($searchValues['status']) && $searchValues['status'] == 1) selected @endif>Active
                                        </option>
                                        <option value="2" @if (isset($searchValues['status']) && $searchValues['status'] == 2) selected @endif>Inactive
                                        </option>
                                    </select>
                                </div>

                                {{-- Add more filters as needed --}}
                                <div class="col-md-12 text-end">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </form>
                        </div>

                        <div class="border-bottom title-part-padding">
                            <h4 class="card-title mb-0">All Customers</h4>
                        </div>

                        <div class="table-responsive">
                            <table id="file_export" class="table table-striped table-bordered display">
                                <thead>
                                    <tr>
                                        {{-- <th>#REF</th> --}}
                                        <th>Name AR</th>
                                        <th>Name EN</th>
                                        <th>Phone</th>
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
                                    @if (isset($customers))
                                        @foreach ($customers as $customer)
                                            <tr>
                                                {{-- name_ar --}}
                                                <td>
                                                    <a
                                                        href="{{ route('super_admin.customers-show', isset($customer->id) ? $customer->id : -1) }}">
                                                        <strong>{{ isset($customer->name_ar) ? $customer->name_ar : '----' }}</strong>
                                                    </a>
                                                </td>

                                                {{-- name_en --}}
                                                <td>
                                                    <a
                                                        href="{{ route('super_admin.customers-show', isset($customer->id) ? $customer->id : -1) }}">
                                                        <strong>{{ isset($customer->name_en) ? $customer->name_en : '----' }}</strong>
                                                    </a>
                                                </td>

                                                {{-- phone --}}
                                                <td>

                                                    {{ isset($customer->phone) && isset($customer->country_phone_id) ? '(+'. $customer->countryPhoneKey->phone_code.') '.$customer->phone : (isset($customer->phone) ? $customer->phone  : '-------') }}
                                                </td>

                                                {{-- created_at --}}
                                                <td>
                                                    {!! isset($customer->created_at)
                                                        ? $customer->created_at->toDateString()
                                                        : "<span style='color:blue;'>----------</span>" !!}
                                                </td>

                                                {{-- status --}}
                                                <td>
                                                    @if ($customer->status == 'Active')
                                                        <a href="{{ route('super_admin.customers-activeInactiveSingle', isset($customer->id) ? $customer->id : -1) }}"
                                                            class="process btn waves-effect waves-light btn-light-danger btn-sm"
                                                            title="Set Inactive"><i class="mdi mdi-pause"></i>
                                                        </a>
                                                        <span
                                                            style="color:green;"><strong>{{ isset($customer->status) ? $customer->status : '----' }}</strong></span>
                                                    @elseif($customer->status == 'Inactive')
                                                        <a href="{{ route('super_admin.customers-activeInactiveSingle', isset($customer->id) ? $customer->id : -1) }}"
                                                            class="process btn waves-effect waves-light btn-light-success btn-sm"
                                                            title="Set Active"><i class="mdi mdi-play"></i>
                                                        </a>
                                                        <span style="color:red;"> <strong>
                                                                {{ isset($customer->status) ? $customer->status : '----' }}
                                                            </strong> </span>
                                                    @else
                                                        -----
                                                    @endif
                                                </td>

                                                {{-- operations --}}
                                                <td>
                                                    <div class="button-group">
                                                        <a href="{{ route('super_admin.customers-show', isset($customer->id) ? $customer->id : -1) }}"
                                                            class="btn waves-effect waves-light btn-primary btn-sm"
                                                            title="View Details"><i class="fas fa-eye"></i></a>
                                                        <a href="{{ route('super_admin.customers-edit', isset($customer->id) ? $customer->id : -1) }}"
                                                            class="btn waves-effect waves-light btn-secondary btn-sm"
                                                            title="Edit"><i class="fas fa-edit"></i></a>
                                                        <a href="{{ route('super_admin.customers-softDelete', isset($customer->id) ? $customer->id : -1) }}"
                                                            class="confirm btn waves-effect waves-light btn-danger btn-sm"
                                                            title="Delete"><i class="fas fa-trash-alt"></i></a>
                                                    </div>
                                                </td>

                                                <td class="text-center">
                                                    <input type="checkbox" class="selectedCustomers"
                                                        name="selectedCustomers[]" value="{{ $customer->id }}">
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
            var selectedCustomers = document.querySelectorAll(".selectedCustomers");
            // Determine whether the boxes are selected or not
            var areAllChecked = true;
            for (var i = 0; i < selectedCustomers.length; i++) {
                if (!selectedCustomers[i].checked) {
                    areAllChecked = false;
                    break;
                }
            }
            // Change the status of the check box based on the current status
            for (var i = 0; i < selectedCustomers.length; i++) {
                selectedCustomers[i].checked = !areAllChecked;
            }
        }
    </script>


    {{-- Soft Delete Selected --}}
    <script>
        function softDeleteSelected() {
            //Collect the selected admins
            var selectedCustomers = [];
            $('input[name="selectedCustomers[]"]:checked').each(function() {
                selectedCustomers.push($(this).val());
            });

            //If admins are selected, you can perform the function here
            if (selectedCustomers.length > 0) {
                //Prepare the data as a query
                var query = '?selectedCustomers=' + selectedCustomers.join(',');
                // Create the link with the query
                var link = '{{ route('super_admin.customers-softDeleteSelected') }}' + query;
                // Direct the customers to the link after preparing it
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
            var selectedCustomers = [];
            $('input[name="selectedCustomers[]"]:checked').each(function() {
                selectedCustomers.push($(this).val());
            });

            //If admins are selected, you can perform the function here
            if (selectedCustomers.length > 0) {
                //Prepare the data as a query
                var query = '?selectedCustomers=' + selectedCustomers.join(',');
                // Create the link with the query
                var link = '{{ route('super_admin.customers-activeSelected') }}' + query;
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
            var selectedCustomers = [];
            $('input[name="selectedCustomers[]"]:checked').each(function() {
                selectedCustomers.push($(this).val());
            });

            //If admins are selected, you can perform the function here
            if (selectedCustomers.length > 0) {
                //Prepare the data as a query
                var query = '?selectedCustomers=' + selectedCustomers.join(',');
                // Create the link with the query
                var link = '{{ route('super_admin.customers-inactiveSelected') }}' + query;
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
                        targets: [3]
                    },
                    {
                        orderable: false,
                        targets: [6]
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
