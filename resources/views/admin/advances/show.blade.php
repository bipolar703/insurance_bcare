@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <h2 class="page-title">Expense</h2>
            <div class="col-md-5 align-self-center">
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.expenses-index') }}">Expense</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Expense Details</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Create --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.expenses-create') }}" class="btn btn-dark">
                            <i data-feather="plus" class="fill-white feather-sm"></i>Create Expense
                        </a>
                    </div>
                    @if ($expense->status == 'UnPost')
                        {{-- Edit --}}
                        <div class="dropdown me-2">
                            <a href="{{ route('super_admin.expenses-edit', isset($expense->id) ? $expense->id : -1) }}"
                                class="btn btn-secondary">
                                <i data-feather="edit" class="fill-white feather-sm"></i>Edit Expense
                            </a>
                        </div>
                        {{-- Delete --}}
                        <div class="dropdown me-2">
                            <a href="{{ route('super_admin.expenses-softDelete', isset($expense->id) ? $expense->id : -1) }}"
                                class="confirm btn btn-danger">
                                <i data-feather="trash" class="fill-white feather-sm"></i>Delete Expense
                            </a>
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

            {{-- Right Section --}}
            <div class="col-lg-12">
                <div class="card">
                    {{-- Tabs Header Section --}}
                    <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
                        {{-- Tab 1 : Main Info --}}
                        <li class="nav-item">
                            <a class="nav-link active" id="tab_header_1" data-bs-toggle="pill" href="#tab_body_1"
                                role="tab" aria-controls="pills-profile" aria-selected="false"><strong>Main
                                    Info</strong></a>
                        </li>
                    </ul>

                    <div class="tab-content" id="pills-tabContent">
                        {{-- Tab One --}}
                        <div class="tab-pane fade show active" id="tab_body_1" role="tabpanel" aria-labelledby="tab_body_1">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="table-responsive">
                                            <table id="file_export_main_info_part_1"
                                                class="table table-striped table-bordered display">
                                                <thead>
                                                    {{-- id --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">REF :</th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($expense->id) ? $expense->id : '----' }}
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    {{-- account_id --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Account :</th>
                                                        <td>
                                                            <strong>
                                                                <a
                                                                    href="{{ route('super_admin.accounts-show', isset($expense->account_id) ? $expense->account_id : -1) }}">
                                                                    {{ isset($expense->account->title_en) ? $expense->account->title_en : '----' }}
                                                                    ({{ isset($expense->account->title_ar) ? $expense->account->title_ar : '----' }})
                                                                </a>
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    {{-- expense_date --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Expense Date :</th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($expense->expense_date) ? $expense->expense_date : '----' }}
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    {{-- amount --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Expense Amount :</th>
                                                        <td>
                                                            <strong style="color: red">
                                                                {{ isset($expense->amount) ? $expense->amount : '----' }}
                                                                JOD
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    {{-- created_at --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue"> Added Since:</th>
                                                        <td>
                                                            <strong>{!! isset($expense->created_at) ? $expense->created_at->diffForHumans() : '-------' !!}</strong>
                                                        </td>
                                                    </tr>

                                                    {{-- created_at --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Addition Time:</th>
                                                        <td>
                                                            <strong>{!! isset($expense->created_at) ? date('h:i A', strtotime($expense->created_at)) : '-------' !!}</strong>
                                                        </td>
                                                    </tr>

                                                    {{-- created_at --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Addition Date:</th>
                                                        <td>
                                                            <strong>
                                                                {!! isset($expense->created_at) ? date('d/M/Y', strtotime($expense->created_at)) : '-------' !!}
                                                            </strong>
                                                        </td>
                                                    </tr>


                                                </thead>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="table-responsive">
                                            <table id="file_export_status_team"
                                                class="table table-striped table-bordered display">
                                                <thead>

                                                    {{-- title --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Title:
                                                        </th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($expense->title) ? $expense->title : '-------' }}
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    {{-- category_id --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Category:</th>
                                                        <td>
                                                            <a
                                                                href="{{ route('super_admin.expenses_categories-show', isset($expense->category_id) ? $expense->category_id : -1) }}">
                                                                <strong>{{ isset($expense->expenseCategory->title_en) ? $expense->expenseCategory->title_en : '----' }}</strong>
                                                                <strong>({{ isset($expense->expenseCategory->title_ar) ? $expense->expenseCategory->title_ar : '----' }})</strong>
                                                            </a>
                                                        </td>
                                                    </tr>

                                                    {{-- location_id --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Location:</th>
                                                        <td>
                                                            <a
                                                                href="{{ route('super_admin.expense_locations-show', isset($expense->location_id) ? $expense->location_id : -1) }}">
                                                                <strong>{{ isset($expense->expenseLocation->title_en) ? $expense->expenseLocation->title_en : '----' }}</strong>
                                                                <strong>({{ isset($expense->expenseLocation->title_ar) ? $expense->expenseLocation->title_ar : '----' }})</strong>
                                                            </a>
                                                        </td>
                                                    </tr>

                                                    {{-- vendor_id --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Vendor:</th>
                                                        <td>
                                                            <a
                                                                href="{{ route('super_admin.vendors-show', isset($expense->vendor_id) ? $expense->vendor_id : -1) }}">
                                                                <strong>{{ isset($expense->vendor->name_en) ? $expense->vendor->name_en : '----' }}</strong>
                                                                <strong>({{ isset($expense->vendor->name_ar) ? $expense->vendor->name_ar : '----' }})</strong>
                                                            </a>
                                                        </td>
                                                    </tr>


                                                    {{-- asset_id --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Variable Asset:</th>
                                                        <td>
                                                            <a
                                                                href="{{ route('super_admin.variables_assets-show', isset($expense->asset_id) ? $expense->asset_id : -1) }}">
                                                                <strong>{{ isset($expense->variableAsset->title) ? $expense->variableAsset->title : '----' }}</strong>
                                                            </a>
                                                        </td>
                                                    </tr>

                                                    {{-- created_by --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Created By:</th>
                                                        <td>
                                                            <strong>
                                                                <a
                                                                    href="{{ route('super_admin.employees-show', isset($expense->created_by) ? $expense->created_by : -1) }}">
                                                                    {{ isset($expense->createdBy->name) ? $expense->createdBy->name : '-------' }}
                                                                </a>
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    {{-- expense_file --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Expense File :</th>
                                                        <td>
                                                            <p class="card-text">
                                                                <a href="{{ asset($expense->expense_file) }}"
                                                                    class="view-file-link" target="_blank"> <strong> Expense
                                                                        File view </strong></a>
                                                            </p>
                                                        </td>
                                                    </tr>


                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                    @if (isset($expense->description))
                                        <div class="col-md-12 bordered">
                                            <div class="card border-primary mb-3">
                                                <div class="card-header" style="background-color: aliceblue;">
                                                    <strong>Description</strong>
                                                </div>
                                                <div class="card-body">
                                                    <p class="card-text text-muted">{{ $expense->description }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('extra_js')
        <script>
            $(document).ready(function() {
                // Function to initialize DataTable with buttons
                function initializeDataTable(tableId, classes) {
                    if (!$.fn.DataTable.isDataTable(tableId)) {
                        $(tableId).DataTable({
                            dom: 'Bfrtip',
                            buttons: [{
                                    extend: 'copy',
                                    className: classes
                                },
                                {
                                    extend: 'csv',
                                    className: classes
                                },
                                {
                                    extend: 'excel',
                                    className: classes
                                },
                                {
                                    extend: 'pdf',
                                    className: classes
                                },
                                {
                                    extend: 'print',
                                    className: classes
                                }
                            ]
                        });
                    }
                }

                // Initialize DataTable for Projects tab on document load
                initializeDataTable('#file_export', 'btn btn-primary'); // Define button classes for Tab 2

                // Event listener for when the Invoices tab is shown
                $('a[data-bs-toggle="pill"]').on('shown.bs.tab', function(e) {
                    var targetTab = $(e.target).attr('href'); // Get the target tab href

                    // Check if the target tab is the Invoices tab
                    if (targetTab === '#tab_body_3') {
                        initializeDataTable('#file_export_invoices',
                            'btn btn-secondary'); // Define button classes for Tab 3
                    }
                });
            });
        </script>
    @endsection
