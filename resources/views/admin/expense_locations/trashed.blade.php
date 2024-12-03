@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Expenses Locations</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.expense_locations-index') }}">Expenses Locations</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Archives</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Create --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.expense_locations-create') }}" class="btn btn-dark">
                            <i data-feather="plus" class="fill-white feather-sm"></i> Add New Expenses Location
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
                                    @foreach ($expenseLocations as $expenseLocation)
                                        <tr>

                                            <td>{{ isset($expenseLocation->title_ar) ? $expenseLocation->title_ar : '----' }}</td>
                                            <td>{{ isset($expenseLocation->title_en) ? $expenseLocation->title_en : '----' }}</td>
                                              {{-- Count --}}
                                              <td>
                                                <strong>{{ optional($expenseLocation->expenses)->count() ?: '0' }}</strong>
                                            </td>
                                            {{-- Cost --}}
                                            <td>
                                                <strong  style="color: red">{{ optional($expenseLocation->expenses)->sum('amount') ?: '0' }} JOD</strong>
                                            </td>

                                            <td>{{ isset($expenseLocation->createdBy->name) ? $expenseLocation->createdBy->name : '----' }}
                                            </td>
                                            <td>{{ isset($expenseLocation->status) ? $expenseLocation->status : '----' }}</td>
                                            <td>{!! isset($expenseLocation->created_at)
                                                ? '<strong>Date : </strong>' .
                                                    date('Y -m-d', strtotime($expenseLocation->created_at)) .
                                                    '<br><strong>Time : </strong>' .
                                                    date('h:i A', strtotime($expenseLocation->created_at)) .
                                                    '<br><strong>Since : </strong> ' .
                                                    $expenseLocation->created_at->diffForHumans()
                                                : "<span style='color:blue;'>----------</span>" !!}
                                            </td>
                                            <td>
                                                <div class="button-group">
                                                    <a href="{{ route('super_admin.expense_locations-softDeleteRestore', [isset($expenseLocation->id) ? $expenseLocation->id : -1]) }}"
                                                        class="unarchive btn waves-effect waves-light btn-success btn-sm"
                                                        title="Restore this Record"><i class="mdi mdi-redo-variant"></i></a>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" class="selectedExpenseLocations"
                                                    name="selectedExpenseLocations[]" value="{{ $expenseLocation->id }}">
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



    {{-- Soft Delete Restore Selected --}}
    <script>
        function softDeleteRestoreSelected() {
            // Collect the selected rows
            var selectedExpenseLocations = [];
            $('input[name="selectedExpenseLocations[]"]:checked').each(function() {
                selectedExpenseLocations.push($(this).val());
            });
            //If rows are selected, you can perform the function here
            if (selectedExpenseLocations.length > 0) {
                //Prepare the data as a query
                var query = '?selectedExpenseLocations=' + selectedExpenseLocations.join(',');
                // Create the link with the query
                var link = '{{ route('super_admin.expense_locations-softDeleteRestoreSelected') }}' + query;
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
