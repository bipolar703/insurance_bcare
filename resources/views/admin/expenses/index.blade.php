@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Expenses
                    @if (isset($expenses))
                        ({{ $expenses->count() }})
                    @endif
                </h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Expenses</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Create --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.expenses-create') }}" class="btn btn-dark">
                            <i data-feather="plus" class="fill-white feather-sm"></i> Add New
                        </a>
                    </div>
                    {{-- Archive --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.expenses-showSoftDelete') }}" class="btn btn-danger">
                            <i data-feather="archive" class="fill-white feather-sm"></i> View Archive
                        </a>
                    </div>
                    @if (isset($expenses) && $expenses->count() > 0)
                        {{-- Setting --}}
                        {{-- postSelected --}}
                        <div class="dropdown me-2">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Setting
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li><button id="softDeleteSelected" class="confirm dropdown-item"
                                        onclick="softDeleteSelected()">Delete Selected
                                    </button>
                                </li>
                                <li><button id="postSelected" class="process dropdown-item"
                                    onclick="postSelected()">Post Selected</button></li>
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
                    {{-- Search --}}
                    <div class="col-md-12 groove-container">
                        <label>
                            <h2>Search Section</h2>
                        </label>
                        <br>
                        <form action="{{ route('super_admin.expenses-searchExpenses') }}" method="get" class="row g-3"
                            id="searchForm">
                            @csrf

                            {{-- Customer Dropdown --}}
                            <div class="col-md-3">
                                <label for="userID" class="form-label">Select Employee Name</label>
                                <select name="userID" onchange="getCustomerProjects()"
                                    class="form-control @error('userID') border border-danger @enderror" id="userID">
                                    <option value="" disabled selected>Select Employee Name</option>
                                    @if (isset($users))
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                @if ((isset($searchValues['userID']) && $searchValues['userID'] == $user->id) || old('userID') == $user->id) selected @endif>
                                                {{ $user->name ?? '------' }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            {{-- expensesTypes Dropdown --}}
                            <div class="col-md-3">
                                <label for="expensesTypesID" class="form-label">Select Category</label>
                                <select name="expensesTypesID"
                                    class="form-control @error('expensesTypesID') border border-danger @enderror"
                                    id="expensesTypesID">
                                    <option value="" disabled selected>Select Category</option>
                                    @if (isset($expensesTypes))
                                        @foreach ($expensesTypes as $expenseType)
                                            <option value="{{ $expenseType->id }}"
                                                @if (
                                                    (isset($searchValues['expensesTypesID']) && $searchValues['expensesTypesID'] == $expenseType->id) ||
                                                        old('expensesTypesID') == $expenseType->id) selected @endif>
                                                {{ $expenseType->title_ar ?? '------' }}
                                                ({{ $expenseType->title_en ?? '------' }})
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            {{-- locationID Dropdown --}}
                            <div class="col-md-3">
                                <label for="locationID" class="form-label">Select Location</label>
                                <select name="locationID"
                                    class="form-control @error('locationID') border border-danger @enderror"
                                    id="locationID">
                                    <option value="" disabled selected>Select Location</option>
                                    @if (isset($expenseLocations))
                                        @foreach ($expenseLocations as $expenseLocation)
                                            <option value="{{ $expenseLocation->id }}"
                                                @if (
                                                    (isset($searchValues['locationID']) && $searchValues['locationID'] == $expenseLocation->id) ||
                                                        old('locationID') == $expenseLocation->id) selected @endif>
                                                {{ $expenseLocation->title_ar ?? '------' }}
                                                ({{ $expenseLocation->title_en ?? '------' }})
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            {{-- accountID Dropdown --}}
                            <div class="col-md-3">
                                <label for="accountID" class="form-label">Select Account</label>
                                <select name="accountID"
                                    class="form-control @error('accountID') border border-danger @enderror" id="accountID">
                                    <option value="" disabled selected>Select Account</option>
                                    @if (isset($accounts))
                                        @foreach ($accounts as $account)
                                            <option value="{{ $account->id }}"
                                                @if (
                                                    (isset($searchValues['accountID']) && $searchValues['accountID'] == $account->id) ||
                                                        old('accountID') == $account->id) selected @endif>
                                                {{ $account->title_ar ?? '------' }}
                                                ({{ $account->title_en ?? '------' }})
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>


                            {{-- Status Dropdown --}}
                            <div class="col-md-3">
                                <label for="status" class="form-label">Choose Expense Status</label>
                                <select name="status" class="form-control @error('status') border border-danger @enderror">
                                    <option value="">--- All Statuses ---</option>
                                    <option value="1" @if (isset($searchValues['status']) && $searchValues['status'] == '1') selected @endif>Post</option>
                                    <option value="2" @if (isset($searchValues['status']) && $searchValues['status'] == '2') selected @endif>UnPost
                                    </option>
                                </select>

                            </div>


                            {{-- from_date --}}
                            <div class="col-md-3">
                                <label for="from_date" class="form-label">From Date</label>
                                <input type="date" name="from_date"
                                    class="form-control border border-info @error('from_date') border-danger @enderror"
                                    id="tb-title" value="{{ $searchValues['from_date'] ?? '' }}" placeholder="From Date">
                                <label for="tb-title">
                                    <strong class="text-danger">
                                        @error('from_date')
                                            ( {{ $message }} )
                                        @enderror
                                    </strong>
                                </label>
                            </div>


                            {{-- to_date --}}
                            <div class="col-md-3">
                                <label for="to_date" class="form-label">To Date</label>
                                <input type="date" name="to_date"
                                    class="form-control border border-info @error('to_date') border-danger @enderror"
                                    id="tb-title" value="{{ $searchValues['to_date'] ?? '' }}" placeholder="To Date">
                                <label for="tb-title">
                                    <strong class="text-danger">
                                        @error('to_date')
                                            ( {{ $message }} )
                                        @enderror
                                    </strong>
                                </label>
                            </div>

                            {{-- Add more filters as needed --}}
                            <div class="col-md-12 text-end">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </form>
                    </div>
                    <br>

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
                                                    <a
                                                        href="{{ route('super_admin.expenses-show', isset($expense->id) ? $expense->id : -1) }}">
                                                        <strong>{{ isset($expense->title) ? $expense->title : '----' }}</strong>
                                                    </a>
                                                </td>

                                                {{-- created_by --}}
                                                <td>
                                                    <a
                                                        href="{{ route('super_admin.employees-show', ['id' => isset($expense->createdBy->id) ? $expense->createdBy->id : '----']) }}">
                                                        <strong>{{ isset($expense->createdBy->name) ? $expense->createdBy->name : '----' }}</strong>
                                                    </a>
                                                </td>
                                              
                                                {{-- account_id --}}
                                                <td>
                                                    <a
                                                        href="{{ route('super_admin.accounts-show', ['id' => isset($expense->account_id) ? $expense->account_id : '----']) }}">
                                                        <strong>{{ isset($expense->account->title_en) ? $expense->account->title_en : '----' }}</strong>
                                                    </a>
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
                                                    <a
                                                        href="{{ route('super_admin.expenses_categories-show', isset($expense->category_id) ? $expense->category_id : -1) }}">
                                                        <strong>{{ isset($expense->expenseCategory->title_ar) ? $expense->expenseCategory->title_ar : '----' }}</strong>
                                                    </a>
                                                </td>

                                                {{-- location_id --}}
                                                <td>
                                                    <a
                                                        href="{{ route('super_admin.expense_locations-show', isset($expense->location_id) ? $expense->location_id : -1) }}">

                                                        <strong>{{ isset($expense->expenseLocation->title_ar) ? $expense->expenseLocation->title_ar : '----' }}</strong>

                                                    </a>
                                                </td>

                                                {{-- expense_file --}}
                                                <td>
                                                    <p class="card-text">
                                                        <a href="{{ asset($expense->expense_file) }}"
                                                            class="view-file-link" target="_blank">View</a>
                                                    </p>
                                                </td>

                                                {{-- status --}}
                                                <td>
                                                    @if ($expense->status == 'UnPost')
                                                        <a href="{{ route('super_admin.expenses-transferTheAmount', isset($expense->id) ? $expense->id : -1) }}"
                                                            class="process btn waves-effect waves-light btn-light-danger btn-sm"
                                                            title="Set Post"><i class="mdi mdi-pause"></i>
                                                        </a>
                                                        <span
                                                            style="color:red;"><strong>{{ isset($expense->status) ? $expense->status : '----' }}</strong></span>
                                                    @elseif ($expense->status == 'Post')
                                                        <span
                                                            style="color:green;"><strong>{{ isset($expense->status) ? $expense->status : '----' }}</strong></span>
                                                    @else
                                                        <strong>{{ isset($expense->status) ? $expense->status : '----' }}</strong>
                                                    @endif
                                                </td>

                                                {{-- operations --}}
                                                <td>
                                                    <div class="button-group">
                                                        <a href="{{ route('super_admin.expenses-show', isset($expense->id) ? $expense->id : -1) }}"
                                                            class="btn waves-effect waves-light btn-primary btn-sm"
                                                            title="View Details"><i class="fas fa-eye"></i>
                                                        </a>
                                                        @if ($expense->status == 'UnPost')
                                                            <a href="{{ route('super_admin.expenses-edit', isset($expense->id) ? $expense->id : -1) }}"
                                                                class="btn waves-effect waves-light btn-secondary btn-sm"
                                                                title="Edit"><i class="fas fa-edit"></i>
                                                            </a>

                                                            <a href="{{ route('super_admin.expenses-softDelete', isset($expense->id) ? $expense->id : -1) }}"
                                                                class="confirm btn waves-effect waves-light btn-danger btn-sm"
                                                                title="Delete"><i class="fas fa-trash-alt"></i>
                                                            </a>
                                                        @endif

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
    <script>
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
                var link = '{{ route('super_admin.expenses-softDeleteSelected') }}' + query;
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
                var link = '{{ route('super_admin.expenses-postSelected') }}' + query;
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
            var selectedExpenses = [];
            $('input[name="selectedExpenses[]"]:checked').each(function() {
                selectedExpenses.push($(this).val());
            });

            //If admins are selected, you can perform the function here
            if (selectedExpenses.length > 0) {
                //Prepare the data as a query
                var query = '?selectedExpenses=' + selectedExpenses.join(',');
                // Create the link with the query
                var link = '{{ route('super_admin.expenses-inactiveSelected') }}' + query;
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
                        targets: [8, 10]
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
            $('select[name="locationID"]').select2();
            $('select[name="accountID"]').select2();
            $('select[name="search"]').select2();
        });
    </script>
@endsection
