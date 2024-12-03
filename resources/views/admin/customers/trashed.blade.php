@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">All Archived Customers</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">

                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.customers-index') }}">All Archived Customers</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Archives</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Create --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.customers-create') }}" class="btn btn-dark">
                            <i data-feather="plus" class="fill-white feather-sm"></i> Add New Customer
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
                                <li><button id="softDeleteRestoreSelected" class="unarchive dropdown-item"
                                        onclick="softDeleteRestoreSelected()">Restore Selected Admins</button>
                                </li>
                            </ul>
                        </div>
                        {{-- Select/Deselect all --}}
                        <div class="dropdown me-2">
                            <button class="toggleSelectAllButton btn btn-primary" onclick="selectDeselectAll()">
                                Select/Deselect all</button>
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
                    <div class="border-bottom title-part-padding">
                        <h4 class="card-title mb-0">All Archived Customers</h4>
                    </div>
                    <div class="card-body">
                        {{-- <h6 class="card-subtitle mb-3">Exporting data from a table can often be a key part of a
                            complex application. The Buttons extension for DataTables provides three plug-ins
                            that provide overlapping functionality for data export. You can refer full
                            documentation from here <a href="https://datatables.net/">Datatables</a></h6> --}}
                        <div class="table-responsive">
                            <table id="file_export" class="table table-striped table-bordered display">
                                <thead>
                                    <tr>
                                        <th>Name AR</th>
                                        <th>Name EN</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        <th>Date/Time</th>
                                        <th>Control</th>
                                        <th>Select</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($customers as $customer)
                                        <tr>

                                            <td>{{ isset($customer->name_ar) ? $customer->name_ar : '----' }}</td>
                                            <td>{{ isset($customer->name_en) ? $customer->name_en : '----' }}</td>
                                            <td>{{ isset($customer->email) ? $customer->email : '----' }}</td>
                                            <td> {{ isset($customer->phone) && isset($customer->country_phone_id) ? '(+'. $customer->countryPhoneKey->phone_code.') '.$customer->phone : '----' }}
                                            </td>
                                            <td>{{ isset($customer->status) ? $customer->status : '----' }}</td>
                                            <td>{!! isset($customer->created_at)
                                                ? '<strong>Date : </strong>' .
                                                    date('Y -m-d', strtotime($customer->created_at)) .
                                                    '<br><strong>Time : </strong>' .
                                                    date('h:i A', strtotime($customer->created_at)) .
                                                    '<br><strong>Since : </strong> ' .
                                                    $customer->created_at->diffForHumans()
                                                : "<span style='color:blue;'>----------</span>" !!}</td>
                                            <td>
                                                <div class="button-group">
                                                    <a href="{{ route('super_admin.customers-softDeleteRestore', [isset($customer->id) ? $customer->id : -1]) }}"
                                                        class="unarchive btn waves-effect waves-light btn-success btn-sm"
                                                        title="Restore this Record"><i class="mdi mdi-redo-variant"></i></a>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" class="selectedCustomers" name="selectedCustomers[]"
                                                    value="{{ $customer->id }}">
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



    {{-- Soft Delete Restore Selected --}}
    <script>
        function softDeleteRestoreSelected() {
            // Collect the selected rows
            var selectedCustomers = [];
            $('input[name="selectedCustomers[]"]:checked').each(function() {
                selectedCustomers.push($(this).val());
            });
            //If rows are selected, you can perform the function here
            if (selectedCustomers.length > 0) {
                //Prepare the data as a query
                var query = '?selectedCustomers=' + selectedCustomers.join(',');
                // Create the link with the query
                var link = '{{ route('super_admin.customers-softDeleteRestoreSelected') }}' + query;
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
@endsection
