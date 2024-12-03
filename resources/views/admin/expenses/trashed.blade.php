@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Expenses</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.expenses-index') }}">Expense</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Archives</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Create --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.expenses-create') }}" class="btn btn-dark">
                            <i data-feather="plus" class="fill-white feather-sm"></i> Add New Expense
                        </a>
                    </div>
                    @if (isset($expenses) && $expenses->count() > 0)
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
                                        <th>Title</th>
                                        <th>Employeee</th>
                                        <th>Account</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Category</th>
                                        <th>Location</th>
                                        <th>File</th>
                                        <th>Status</th>
                                        <th>Control</th>
                                        <th>
                                            <input type="checkbox" class="toggleSelectAllCheckbox" id="selectAllCheckbox"
                                                onclick="selectDeselectAll()">
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @if (isset($expenses))
                                        @foreach ($expenses as $expense)
                                            <tr>
                                                {{-- title --}}
                                                <td>
                                                    <strong>{{ isset($expense->title) ? $expense->title : '----' }}</strong>
                                                </td>

                                                {{-- created_by --}}
                                                <td>
                                                    <strong>{{ isset($expense->createdBy->name) ? $expense->createdBy->name : '----' }}</strong>
                                                </td>

                                                {{-- account_id --}}
                                                <td>
                                                    <strong>{{ isset($expense->account->title_en) ? $expense->account->title_en : '----' }}</strong>
                                                </td>

                                                {{-- expense_date --}}
                                                <td>
                                                    {!! isset($expense->expense_date) ? $expense->expense_date : "<span style='color:blue;'>----------</span>" !!}
                                                </td>

                                                {{-- amount --}}
                                                <td>
                                                    <span style="color: red">
                                                        <strong>
                                                            {!! isset($expense->amount) ? $expense->amount : "<span style='color:blue;'>----------</span>" !!} JOD
                                                        </strong>
                                                    </span>
                                                </td>

                                                {{-- category_id --}}
                                                <td>
                                                    <strong>{{ isset($expense->expenseCategory->title_ar) ? $expense->expenseCategory->title_ar : '----' }}</strong>
                                                </td>

                                                {{-- location_id --}}
                                                <td>
                                                    <strong>{{ isset($expense->expenseLocation->title_ar) ? $expense->expenseLocation->title_ar : '----' }}</strong>
                                                </td>

                                                {{-- expense_file --}}
                                                <td>
                                                    <p class="card-text">
                                                        <a href="{{ asset($expense->expense_file) }}" class="view-file-link"
                                                            target="_blank">View</a>
                                                    </p>
                                                </td>

                                                {{-- status --}}
                                                <td>
                                                    <span
                                                        style="color:red;"><strong>{{ isset($expense->status) ? $expense->status : '----' }}</strong></span>
                                                </td>

                                                {{-- operations --}}
                                                <td>
                                                    <div class="button-group">
                                                        <a href="{{ route('super_admin.expenses-softDeleteRestore', [isset($expense->id) ? $expense->id : -1]) }}"
                                                            class="unarchive btn waves-effect waves-light btn-success btn-sm"
                                                            title="Restore this Record"><i
                                                                class="mdi mdi-redo-variant"></i></a>
                                                    </div>
                                                </td>

                                                <td class="text-center">
                                                    @if ($expense->status == 'UnPost')
                                                        <input type="checkbox" class="selectedExpenses"
                                                            name="selectedExpenses[]" value="{{ $expense->id }}">
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
    {{-- <script>
        function selectDeselectAll() {
            // Get bcheckbox using CSS class classes
            var selectedExpenses = document.querySelectorAll(".selectedExpenses");
            // Determine whether the boxes are selected or not
            var areAllChecked = true;
            for (var i = 0; i < selectedExpenses.length; i++) {
                if (!selectedExpenses[i].checked) {
                    areAllChecked = false;
                    break;
                }
            }
            // Change the status of the check box based on the current status
            for (var i = 0; i < selectedExpenses.length; i++) {
                selectedExpenses[i].checked = !areAllChecked;
            }
        }
    </script> --}}
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



    {{-- Soft Delete Restore Selected --}}
    <script>
        function softDeleteRestoreSelected() {
            // Collect the selected rows
            var selectedExpenses = [];
            $('input[name="selectedExpenses[]"]:checked').each(function() {
                selectedExpenses.push($(this).val());
            });
            //If rows are selected, you can perform the function here
            if (selectedExpenses.length > 0) {
                //Prepare the data as a query
                var query = '?selectedExpenses=' + selectedExpenses.join(',');
                // Create the link with the query
                var link = '{{ route('super_admin.expenses-softDeleteRestoreSelected') }}' + query;
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
                        targets: [8, 9, 10]
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
@endsection
