@extends('admin.layouts.app')
@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Accounts :
                    @if (isset($accounts))
                        ({{ $accounts->count() }})
                    @endif
                </h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Accounts</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Create --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.accounts-create') }}" class="btn btn-dark">
                            <i data-feather="plus" class="fill-white feather-sm"></i> Add Account
                        </a>
                    </div>
                    {{-- Archive --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.accounts-showSoftDelete') }}" class="btn btn-danger">
                            <i data-feather="archive" class="fill-white feather-sm"></i> View Archive
                        </a>
                    </div>
                    @if (isset($accounts) && $accounts->count() > 0)
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
                                        <th>Title AR</th>
                                        <th>Title EN</th>
                                        <th>Assigned To</th>
                                        <th>Parent</th>
                                        <th>Balance</th>
                                        <th>Date/Time</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Control</th>
                                        <th>
                                            <input type="checkbox" class="toggleSelectAllCheckbox" id="selectAllCheckbox"
                                                onclick="selectDeselectAll()">
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($accounts))
                                        @foreach ($accounts as $account)
                                            <tr>
                                                {{-- title_ar --}}
                                                <td>
                                                    <a
                                                        href="{{ route('super_admin.accounts-show', isset($account->id) ? $account->id : -1) }}">
                                                        <strong>{{ isset($account->title_ar) ? $account->title_ar : '----' }}</strong>
                                                    </a>
                                                </td>

                                                {{-- title_en --}}
                                                <td>
                                                    <a
                                                        href="{{ route('super_admin.accounts-show', isset($account->id) ? $account->id : -1) }}">
                                                        <strong>{{ isset($account->title_en) ? $account->title_en : '----' }}</strong>
                                                    </a>
                                                </td>

                                                {{-- assigned_to_employee_id --}}
                                                <td>
                                                    <a
                                                        href="{{ route('super_admin.employees-show', isset($account->assigned_to_employee_id) ? $account->assigned_to_employee_id : -1) }}">
                                                        <strong>{{ isset($account->employee->name) ? $account->employee->name : '----' }}</strong>
                                                    </a>
                                                </td>

                                                {{-- parent_id --}}
                                                <td>
                                                    <a
                                                        href="{{ route('super_admin.accounts-show', ['id' => isset($account->parent_id) ? $account->parent_id : '----']) }}">
                                                        <strong>{{ isset($account->parent->title_ar) ? $account->parent->title_ar : '----' }}</strong>
                                                    </a>
                                                </td>

                                                {{-- balance --}}
                                                <td>
                                                    @if ($account->balance > 0)
                                                        <strong
                                                            style="color: green">{{ isset($account->balance) ? $account->balance : '----' }}
                                                            JOD</strong>
                                                    @elseif ($account->balance < 0)
                                                        <strong
                                                            style="color: red">{{ isset($account->balance) ? $account->balance : '----' }}
                                                            JOD</strong>
                                                    @else
                                                        <strong>{{ isset($account->balance) ? $account->balance : '----' }}
                                                            JOD</strong>
                                                    @endif
                                                </td>

                                                {{-- created_at --}}
                                                <td>
                                                    {!! isset($account->created_at)
                                                        ? $account->created_at->toDateString()
                                                        : "<span style='color:blue;'>----------</span>" !!}
                                                </td>

                                                {{-- account_type --}}
                                                <td>
                                                    <strong>{{ isset($account->account_type) ? $account->account_type : '----' }}</strong>
                                                </td>

                                                {{-- status --}}
                                                <td>
                                                    @if ($account->status == 'Active')
                                                        <a href="{{ route('super_admin.accounts-activeInactiveSingle', isset($account->id) ? $account->id : -1) }}"
                                                            class="process btn waves-effect waves-light btn-light-danger btn-sm"
                                                            title="Set Inactive"><i class="mdi mdi-pause"></i>
                                                        </a>
                                                        <span
                                                            style="color:green;"><strong>{{ isset($account->status) ? $account->status : '----' }}</strong></span>
                                                    @elseif($account->status == 'Inactive')
                                                        <a href="{{ route('super_admin.accounts-activeInactiveSingle', isset($account->id) ? $account->id : -1) }}"
                                                            class="process btn waves-effect waves-light btn-light-success btn-sm"
                                                            title="Set Active"><i class="mdi mdi-play"></i>
                                                        </a>
                                                        <span style="color:red;"> <strong>
                                                                {{ isset($account->status) ? $account->status : '----' }}
                                                            </strong> </span>
                                                    @else
                                                        -----
                                                    @endif
                                                </td>

                                                {{-- operations --}}
                                                <td>
                                                    <div class="button-group">
                                                        <a href="{{ route('super_admin.accounts-show', isset($account->id) ? $account->id : -1) }}"
                                                            class="btn waves-effect waves-light btn-primary btn-sm"
                                                            title="View Details"><i class="fas fa-eye"></i></a>
                                                        <a href="{{ route('super_admin.accounts-edit', isset($account->id) ? $account->id : -1) }}"
                                                            class="btn waves-effect waves-light btn-secondary btn-sm"
                                                            title="Edit"><i class="fas fa-edit"></i></a>
                                                        <a href="{{ route('super_admin.accounts-softDelete', isset($account->id) ? $account->id : -1) }}"
                                                            class="confirm btn waves-effect waves-light btn-danger btn-sm"
                                                            title="Delete"><i class="fas fa-trash-alt"></i></a>
                                                    </div>
                                                </td>

                                                <td class="text-center">
                                                    <input type="checkbox" class="selectedAccounts"
                                                        name="selectedAccounts[]" value="{{ $account->id }}">
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
            var selectedAccounts = document.querySelectorAll(".selectedAccounts");
            // Determine whether the boxes are selected or not
            var areAllChecked = true;
            for (var i = 0; i < selectedAccounts.length; i++) {
                if (!selectedAccounts[i].checked) {
                    areAllChecked = false;
                    break;
                }
            }
            // Change the status of the check box based on the current status
            for (var i = 0; i < selectedAccounts.length; i++) {
                selectedAccounts[i].checked = !areAllChecked;
            }
        }
    </script>


    {{-- Soft Delete Selected --}}
    <script>
        function softDeleteSelected() {
            //Collect the selected admins
            var selectedAccounts = [];
            $('input[name="selectedAccounts[]"]:checked').each(function() {
                selectedAccounts.push($(this).val());
            });

            //If admins are selected, you can perform the function here
            if (selectedAccounts.length > 0) {
                //Prepare the data as a query
                var query = '?selectedAccounts=' + selectedAccounts.join(',');
                // Create the link with the query
                var link = '{{ route('super_admin.accounts-softDeleteSelected') }}' + query;
                // Direct the accounts to the link after preparing it
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
            var selectedAccounts = [];
            $('input[name="selectedAccounts[]"]:checked').each(function() {
                selectedAccounts.push($(this).val());
            });

            //If admins are selected, you can perform the function here
            if (selectedAccounts.length > 0) {
                //Prepare the data as a query
                var query = '?selectedAccounts=' + selectedAccounts.join(',');
                // Create the link with the query
                var link = '{{ route('super_admin.accounts-activeSelected') }}' + query;
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
            var selectedAccounts = [];
            $('input[name="selectedAccounts[]"]:checked').each(function() {
                selectedAccounts.push($(this).val());
            });

            //If admins are selected, you can perform the function here
            if (selectedAccounts.length > 0) {
                //Prepare the data as a query
                var query = '?selectedAccounts=' + selectedAccounts.join(',');
                // Create the link with the query
                var link = '{{ route('super_admin.accounts-inactiveSelected') }}' + query;
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
                    [4, 'desc'] // Sorting by Date/Time column
                ],
                columnDefs: [{
                        type: 'date',
                        targets: [4]
                    },
                    {
                        orderable: false,
                        targets: [7, 8, 9]
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
