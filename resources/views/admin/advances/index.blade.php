@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Advances
                    @if (isset($advances))
                        ({{ $advances->count() }})
                    @endif
                </h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Advances</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Create --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.advances-create') }}" class="btn btn-dark">
                            <i data-feather="plus" class="fill-white feather-sm"></i> Add New
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- ========================================================== --}}
    {{-- ==================== Page Body Section =================== --}}
    {{-- ========================================================== --}}
    {{-- advances --}}
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="file_export" class="table table-striped table-bordered display">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Employee</th>
                                        <th>Account</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Payment On Salary</th>
                                        <th>Monthly Payment</th>
                                        <th>File</th>
                                        <th>Status</th>
                                        {{-- <th>Control</th> --}}
                                        <th>
                                            <input type="checkbox" class="toggleSelectAllCheckbox" id="selectAllCheckbox"
                                                onclick="selectDeselectAll()">
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($advances))
                                        @foreach ($advances as $advance)
                                            <tr>
                                                {{-- title --}}
                                                <td>
                                                    <strong>{{ isset($advance->title) ? $advance->title : '----' }}</strong>
                                                    </td>

                                                {{-- created_by --}}
                                                <td>
                                                    <a
                                                        href="{{ route('super_admin.employees-show', ['id' => isset($advance->employee_id) ? $advance->employee_id : '----']) }}">
                                                        <strong>{{ isset($advance->employee->name) ? $advance->employee->name : '----' }}</strong>
                                                    </a>
                                                </td>

                                                {{-- account_id --}}
                                                <td>
                                                    <a
                                                        href="{{ route('super_admin.accounts-show', ['id' => isset($advance->account_id) ? $advance->account_id : '----']) }}">
                                                        <strong>{{ isset($advance->account->title_en) ? $advance->account->title_en : '----' }}</strong>
                                                    </a>
                                                </td>

                                                {{-- expense_date --}}
                                                <td>
                                                    {!! isset($advance->created_at) ? $advance->created_at : "<span style='color:blue;'>----------</span>" !!}
                                                </td>

                                                {{-- amount --}}
                                                <td>
                                                    <span style="color: red">
                                                        <strong>
                                                            {!! isset($advance->amount) ? $advance->amount : "<span style='color:blue;'>----------</span>" !!} JOD
                                                        </strong>
                                                    </span>
                                                </td>

                                                {{-- payment_on_salary --}}
                                                <td>
                                                    <strong>{{ isset($advance->payment_on_salary) ? $advance->payment_on_salary : '----' }}</strong>
                                                </td>

                                                {{-- monthly_payment --}}
                                                <td>
                                                    <strong>{{ isset($advance->monthly_payment) ? $advance->monthly_payment : '----' }}</strong>
                                                </td>

                                                {{-- expense_file --}}
                                                <td>
                                                    @if (isset($advance->file))
                                                        <p class="card-text">
                                                            <a href="{{ asset($advance->file) }}" class="view-file-link"
                                                                target="_blank">View</a>
                                                        </p>
                                                    @else
                                                        -----
                                                    @endif
                                                </td>

                                                {{-- status --}}
                                                <td>
                                                    @if ($advance->status == 'UnPaid')
                                                        <span
                                                            style="color:red;"><strong>{{ isset($advance->status) ? $advance->status : '----' }}</strong></span>
                                                    @elseif ($advance->status == 'Paid')
                                                        <span
                                                            style="color:green;"><strong>{{ isset($advance->status) ? $advance->status : '----' }}</strong></span>
                                                    @else
                                                        <strong>{{ isset($advance->status) ? $advance->status : '----' }}</strong>
                                                    @endif
                                                </td>

                                                {{-- operations --}}
                                                {{-- <td>
                                                    <div class="button-group">
                                                        <a href="{{ route('super_admin.advances-show', isset($advance->id) ? $advance->id : -1) }}"
                                                            class="btn waves-effect waves-light btn-primary btn-sm"
                                                            title="View Details"><i class="fas fa-eye"></i>
                                                        </a>
                                                        @if ($advance->status == 'UnPaid')
                                                            <a href="{{ route('super_admin.advances-edit', isset($advance->id) ? $advance->id : -1) }}"
                                                                class="btn waves-effect waves-light btn-secondary btn-sm"
                                                                title="Edit"><i class="fas fa-edit"></i>
                                                            </a>

                                                            <a href="{{ route('super_admin.advances-softDelete', isset($advance->id) ? $advance->id : -1) }}"
                                                                class="confirm btn waves-effect waves-light btn-danger btn-sm"
                                                                title="Delete"><i class="fas fa-trash-alt"></i>
                                                            </a>
                                                        @endif
                                                    </div>
                                                </td> --}}

                                                <td class="text-center">
                                                    @if ($advance->status == 'UnPaid')
                                                        <input type="checkbox" class="selectedExpenses"
                                                            name="selectedExpenses[]" value="{{ $advance->id }}">
                                                    @endif
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
        var isSelectAllChecked = false;

        function selectDeselectAll() {
            // Get checkboxes using CSS class
            var selectedExpenses = document.querySelectorAll(".selectedExpenses");

            // Check if "Select All" checkbox is checked
            var selectAllCheckbox = document.getElementById("selectAllCheckbox");
            isSelectAllChecked = selectAllCheckbox.checked;

            // Toggle the checked state of all checkboxes based on the "Select All" checkbox
            for (var i = 0; i < selectedExpenses.length; i++) {
                selectedExpenses[i].checked = isSelectAllChecked;
            }
        }
    </script>






    {{-- Soft Delete Selected --}}
    {{-- <script>
        function softDeleteSelected() {
            //Collect the selected admins
            var selectedExpenses = [];
            $('input[name="selectedExpenses[]"]:checked').each(function() {
                selectedExpenses.push($(this).val());
            });

            //If admins are selected, you can perform the function here
            if (selectedExpenses.length > 0) {
                //Prepare the data as a query
                var query = '?selectedExpenses=' + selectedExpenses.join(',');
                // Create the link with the query
                var link = '{{ route('super_admin.advances-softDeleteSelected') }}' + query;
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
    </script> --}}


    {{-- Active Selected --}}
    {{-- <script>
        function postSelected() {
            //Collect the selected admins
            var selectedExpenses = [];
            $('input[name="selectedExpenses[]"]:checked').each(function() {
                selectedExpenses.push($(this).val());
            });

            //If admins are selected, you can perform the function here
            if (selectedExpenses.length > 0) {
                //Prepare the data as a query
                var query = '?selectedExpenses=' + selectedExpenses.join(',');
                // Create the link with the query
                var link = '{{ route('super_admin.advances-postSelected') }}' + query;
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
    </script> --}}


    {{-- Inactive Selected --}}
    {{-- <script>
        function inactiveSelected() {
            //Collect the selected admins
            var selectedExpenses = [];
            $('input[name="selectedExpenses[]"]:checked').each(function() {
                selectedExpenses.push($(this).val());
            });

            //If admins are selected, you can perform the function here
            if (selectedExpenses.length > 0) {
                //Prepare the data as a query
                var query = '?selectedExpenses=' + selectedExpenses.join(',');
                // Create the link with the query
                var link = '{{ route('super_admin.advances-inactiveSelected') }}' + query;
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
    </script> --}}

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
                        targets: [2]
                    },
                    {
                        orderable: false,
                        targets: [9, 7, 8]
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
            $('select[name="userID"]').select2();
            $('select[name="expensesTypesID"]').select2();
            $('select[name="costCenterID"]').select2();
            $('select[name="accountID"]').select2();
            $('select[name="search"]').select2();
        });
    </script>
@endsection
