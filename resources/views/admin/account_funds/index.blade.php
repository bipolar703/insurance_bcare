@extends('admin.layouts.app')
@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Account Funds :
                    @if (isset($accountFunds))
                        ({{ $accountFunds->count() }})
                    @endif
                </h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Account Funds</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Create --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.account_funds-create') }}" class="btn btn-dark">
                            <i data-feather="plus" class="fill-white feather-sm"></i> Add Account Funds
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
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="file_export" class="table table-striped table-bordered display">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Amount</th>
                                        <th>Fund Type</th>
                                        <th>Main Account</th>
                                        <th>Sub Account</th>
                                        <th>Date/Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($accountFunds))
                                        @foreach ($accountFunds as $accountFund)
                                            <tr>
                                                {{-- title --}}
                                                <td>
                                                    <strong>{{ isset($accountFund->title) ? $accountFund->title : '----' }}</strong>
                                                </td>

                                                {{-- amount --}}
                                                <td>
                                                    <strong
                                                        style="color: green">{{ isset($accountFund->amount) ? $accountFund->amount : '----' }}
                                                        JOD</strong>
                                                </td>

                                                {{-- fund_type --}}
                                                <td>
                                                    <strong>{{ isset($accountFund->fund_type) ? $accountFund->fund_type : '----' }}</strong>
                                                </td>

                                                {{-- from_account_id --}}
                                                <td>
                                                    <a
                                                        href="{{ route('super_admin.accounts-show', ['id' => isset($accountFund->from_account_id) ? $accountFund->from_account_id : '----']) }}">
                                                        <strong>{{ isset($accountFund->mainAccount->title_ar) ? $accountFund->mainAccount->title_ar : '----' }}</strong>
                                                    </a>
                                                </td>

                                                {{-- to_account_id --}}
                                                <td>
                                                    @if (isset($accountFund->to_account_id))
                                                        <a
                                                            href="{{ route('super_admin.accounts-show', ['id' => isset($accountFund->to_account_id) ? $accountFund->to_account_id : '----']) }}">
                                                            <strong>{{ isset($accountFund->subAccount->title_ar) ? $accountFund->subAccount->title_ar : '----' }}</strong>
                                                        </a>
                                                    @else
                                                        <strong>-------</strong>
                                                    @endif
                                                </td>

                                                {{-- created_at --}}
                                                <td>
                                                    {!! isset($accountFund->created_at)
                                                        ? $accountFund->created_at->toDateString()
                                                        : "<span style='color:blue;'>----------</span>" !!}
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
    <script>
        $(document).ready(function() {
            if ($.fn.DataTable.isDataTable('#file_export')) {
                $('#file_export').DataTable().destroy();
            }

            $('#file_export').DataTable({
                paging: true,
                pageLength: 50, // Set the number of records per page
                order: [
                    [5, 'desc'] // Sorting by Date/Time column
                ],
                columnDefs: [{
                        type: 'date',
                        targets: [5]
                    },
                    {
                        orderable: false,
                        // targets: [7, 8,9]
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
