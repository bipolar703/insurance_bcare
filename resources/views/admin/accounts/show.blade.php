@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <h2 class="page-title">Accounts</h2>
            <div class="col-md-5 align-self-center">
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.accounts-index') }}">Accounts</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Account Details</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Create --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.accounts-create') }}" class="btn btn-dark">
                            <i data-feather="plus" class="fill-white feather-sm"></i> Add New Account
                        </a>
                    </div>
                    {{-- Edit --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.accounts-edit', isset($account->id) ? $account->id : -1) }}"
                            class="btn btn-secondary">
                            <i data-feather="edit" class="fill-white feather-sm"></i> Edit Account
                        </a>
                    </div>
                    {{-- Delete --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.accounts-softDelete', isset($account->id) ? $account->id : -1) }}"
                            class="confirm btn btn-danger">
                            <i data-feather="trash" class="fill-white feather-sm"></i> Delete Account
                        </a>
                    </div>
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
                        {{-- Tab 2 : Transaction History --}}
                        <li class="nav-item">
                            <a class="nav-link fade" id="tab_header_2" data-bs-toggle="pill" href="#tab_body_2"
                                role="tab" aria-controls="pills-profile" aria-selected="false"><strong>Transaction
                                    History </strong></a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        {{-- Tab One --}}
                        <div class="tab-pane fade show active" id="tab_body_1" role="tabpanel" aria-labelledby="tab_body_1">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="table-responsive">
                                            <table id="file_export_main_info_part_1"
                                                class="table table-striped table-bordered display">
                                                <thead>
                                                    {{-- id --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">REF :</th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($account->id) ? $account->id : '----' }}
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th style="background-color:aliceblue">Parent :</th>
                                                        {{-- parent_id --}}
                                                        <td>
                                                            <a
                                                                href="{{ route('super_admin.accounts-show', ['id' => isset($account->parent_id) ? $account->parent_id : '----']) }}">
                                                                <strong>{{ isset($account->parent->title_ar) ? $account->parent->title_ar : '----' }}</strong>
                                                            </a>

                                                        </td>
                                                    </tr>

                                                    {{-- status --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Status :</th>
                                                        <td>
                                                            <strong>
                                                                @if (isset($account->status) && $account->status == 'Active')
                                                                    <span
                                                                        style="color: green;"><strong>{{ isset($account->status) ? $account->status : '----' }}</strong></span>
                                                                @else
                                                                    <span style="color: red">
                                                                        <strong>
                                                                            {{ isset($account->status) ? $account->status : '----' }}
                                                                        </strong>
                                                                    </span>
                                                                @endif
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    {{-- balance --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue"> Balance:</th>
                                                        <td>
                                                            @if ($account->balance > 0)
                                                                <span style="color: green">
                                                                    <strong>
                                                                        {{ isset($account->balance) ? $account->balance : '----' }}
                                                                        JOD
                                                                    </strong>
                                                                </span>
                                                            @elseif($account->balance < 0)
                                                                <span style="color: red">
                                                                    <strong>
                                                                        {{ isset($account->balance) ? $account->balance : '----' }}
                                                                        JOD
                                                                    </strong>
                                                                </span>
                                                            @else
                                                                <strong>
                                                                    {{ isset($account->balance) ? $account->balance : '----' }}
                                                                    JOD
                                                                </strong>
                                                            @endif
                                                        </td>
                                                    </tr>

                                                    {{-- created_at --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue"> Added Since:</th>
                                                        <td>
                                                            <strong>{!! isset($account->created_at) ? $account->created_at->diffForHumans() : '-------' !!}</strong>
                                                        </td>
                                                    </tr>

                                                    {{-- created_at --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Addition Time:</th>
                                                        <td>
                                                            <strong>{!! isset($account->created_at) ? date('h:i A', strtotime($account->created_at)) : '-------' !!}</strong>
                                                        </td>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="col-md-7">
                                        <div class="table-responsive">
                                            <table id="file_export_status_team"
                                                class="table table-striped table-bordered display">
                                                <thead>
                                                    {{-- title_ar --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Title AR:
                                                        </th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($account->title_ar) ? $account->title_ar : '-------' }}
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    {{--  title_en --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Title EN:</th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($account->title_en) ? $account->title_en : '-------' }}
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    {{--  account_type --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Type:</th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($account->account_type) ? $account->account_type : '-------' }}
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    {{-- assigned_to_employee_id --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Assigned To :</th>
                                                        <td>
                                                            <strong>
                                                                <a href="{{ route('super_admin.employees-show', isset($account->assigned_to_employee_id) ? $account->assigned_to_employee_id : -1) }}"
                                                                    target="_blank">
                                                                    {{ isset($account->employee->name) ? $account->employee->name : '-------' }}
                                                                </a>
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    {{-- created_at --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Addition Date:</th>
                                                        <td>
                                                            <strong>
                                                                {!! isset($account->created_at) ? date('d/M/Y', strtotime($account->created_at)) : '-------' !!}
                                                            </strong>
                                                        </td>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Tab Two --}}
                        <div class="tab-pane fade show fade" id="tab_body_2" role="tabpanel" aria-labelledby="tab_body_2">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="file_export" class="table table-striped table-bordered display">
                                        <thead>
                                            <tr>
                                                <th>#REF</th>
                                                <th>From</th>
                                                <th>To</th>
                                                <th>Amount</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (isset($account->funds) && count($account->funds) > 0)
                                                @foreach ($account->funds as $accountFund)
                                                    <tr>
                                                        <td>{{ isset($accountFund->id) ? $accountFund->id : '----' }}</td>
                                                       
                                                        <td>
                                                        {!! isset($accountFund->mainAccount->title_ar) && isset($accountFund->mainAccount->title_ar)
                                                                        ? $accountFund->mainAccount->title_en . ' ( ' . $accountFund->mainAccount->title_ar . ' )'
                                                                        : '----------' !!}
                                                           

                                                        </td>
                                                
                                                        <td>
                                                            {!! isset($accountFund->subAccount->title_ar) && isset($accountFund->subAccount->title_ar)
                                                                        ? $accountFund->subAccount->title_en . ' ( ' . $accountFund->subAccount->title_ar . ' )'
                                                                        : '----------' !!}
                                                              
                                                        </td>

                                                        <td>
                                                            {{-- The Account is the main account --}}
                                                            @if ($account->id == $accountFund->from_account_id)
                                                                {{-- Case One: Fund Type is Main Account --}}
                                                                @if ($accountFund->fund_type == 'Main Account')
                                                                    <strong style="color: green">
                                                                        {{ isset($accountFund->amount) ? $accountFund->amount : '----' }}
                                                                        JOD</strong>
                                                                @else
                                                                    {{-- Case Two: Fund Type is Account to Account --}}
                                                                    <strong style="color: red">
                                                                        {{ isset($accountFund->amount) ? $accountFund->amount : '----' }}
                                                                        JOD</strong>
                                                                @endif
                                                            @else
                                                                {{-- The account is not the main account --}}
                                                                <strong style="color: green">
                                                                    {{ isset($accountFund->amount) ? $accountFund->amount : '----' }}
                                                                    JOD</strong>
                                                            @endif
                                                        </td>
                                                        <td>{{ isset($accountFund->created_at) ? $accountFund->created_at : '----' }}
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
