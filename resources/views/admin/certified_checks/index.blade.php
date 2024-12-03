@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Certified Checks
                    @if (isset($certifiedChecks))
                        ({{ $certifiedChecks->count() }})
                    @endif
                </h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">All Certified Check</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Create --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.certified_checks-create') }}" class="btn btn-dark">
                            <i data-feather="plus" class="fill-white feather-sm"></i> Add New
                        </a>
                    </div>
                    {{-- Archive --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.certified_checks-showSoftDelete') }}" class="btn btn-danger">
                            <i data-feather="archive" class="fill-white feather-sm"></i> View Archive
                        </a>
                    </div>
                    {{-- @if (isset($certifiedChecks) && $certifiedChecks->count() > 0)
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
                    @endif --}}
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
                                        <th>Customer</th>
                                        <th>Release To</th>
                                        <th>Release Date</th>
                                        <th>Check Number</th>
                                        <th>Amount</th>
                                        <th>Reason For Release</th>
                                        <th>Status</th>
                                        <th>File</th>
                                        <th>Control</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($certifiedChecks as $certifiedCheck)
                                        <tr>
                                            <td>
                                                <a
                                                    href="{{ route('super_admin.customers-show', $certifiedCheck->customer_id ?? -1) }}">
                                                    <strong>{{ $certifiedCheck->customer->name_en ?? '----' }}
                                                        ({{ $certifiedCheck->customer->name_ar ?? '----' }})
                                                    </strong>
                                                </a>
                                            </td>
                                            <td><strong>{{ $certifiedCheck->release_to ?? '----' }}</strong></td>
                                            <td><strong>{{ $certifiedCheck->release_date ?? '----' }}</strong></td>
                                            <td><strong>{{ $certifiedCheck->check_number ?? '----' }}</strong></td>
                                            <td><strong style="color: green">{{ $certifiedCheck->amount ?? '----' }}
                                                    JOD</strong></td>
                                            <td><strong>{{ $certifiedCheck->reason_for_release ?? '----' }}</strong></td>
                                            <td>
                                                @if ($certifiedCheck->status === 'They Have (لديهم)')
                                                    <strong
                                                        style="color: red">{{ $certifiedCheck->status ?? '----' }}</strong>
                                                @elseif ($certifiedCheck->status === 'We Have (لدينا)')
                                                    <strong
                                                        style="color: green">{{ $certifiedCheck->status ?? '----' }}</strong>
                                                @endif
                                            </td>

                                            <td>
                                                <p class="card-text">
                                                    <a href="{{ asset($certifiedCheck->image) }}" class="view-file-link"
                                                        target="_blank">File view</a>
                                                </p>
                                            </td>

                                            <td>
                                                <div class="button-group">
                                                    <a href="{{ route('super_admin.certified_checks-show', $certifiedCheck->id ?? -1) }}"
                                                        class="btn waves-effect waves-light btn-primary btn-sm"
                                                        title="View Details"><i class="fas fa-eye"></i></a>
                                                    <a href="{{ route('super_admin.certified_checks-edit', $certifiedCheck->id ?? -1) }}"
                                                        class="btn waves-effect waves-light btn-secondary btn-sm"
                                                        title="Edit"><i class="fas fa-edit"></i></a>
                                                    <a href="{{ route('super_admin.certified_checks-softDelete', $certifiedCheck->id ?? -1) }}"
                                                        class="confirm btn waves-effect waves-light btn-danger btn-sm"
                                                        title="Delete"><i class="fas fa-trash-alt"></i></a>
                                                </div>
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
                        targets: [7,8]
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
