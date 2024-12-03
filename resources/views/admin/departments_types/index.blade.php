@extends('admin.layouts.app')

@section('content')
{{-- =========================================================== --}}
{{-- =================== Page Header Section =================== --}}
{{-- =========================================================== --}}
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-md-5 align-self-center">
            <h3 class="page-title">Departments Types
                @if (isset($departmentsTypes))
                ({{ $departmentsTypes->count() }})
                @endif
            </h3>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Departments Types</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
            <div class="d-flex">
                {{-- Create --}}
                <div class="dropdown me-2">
                    <a href="{{ route('super_admin.departments_types-create') }}" class="btn btn-dark">
                        <i data-feather="plus" class="fill-white feather-sm"></i> Add New
                    </a>
                </div>
                {{-- Archive --}}
                <div class="dropdown me-2">
                    <a href="{{ route('super_admin.departments_types-showSoftDelete') }}" class="btn btn-danger">
                        <i data-feather="archive" class="fill-white feather-sm"></i> View Archive
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
                                    <th>Title AR</th>
                                    <th>Title EN</th>
                                    <th>No.Departments</th>

                                    <th>Date/Time</th>
                                    <th>Status</th>
                                    <th>Control</th>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($departmentsTypes as $departmentsType)
                                <tr>
                                    {{-- title_ar --}}
                                    <td>
                                        <strong>{{ isset($departmentsType->title_ar) ? $departmentsType->title_ar :
                                            '----' }}</strong>
                                    </td>
                                    {{-- title_en --}}
                                    <td>
                                        <strong>{{ isset($departmentsType->title_en) ? $departmentsType->title_en :
                                            '----' }}</strong>
                                    </td>
                                    {{-- No.Departments --}}
                                    <td>
                                        <strong>{{ isset($departmentsType->departments) ?
                                            $departmentsType->departments->count() :
                                            '----' }}</strong>
                                    </td>
                                    {{-- created_at --}}
                                    <td>
                                        {!! isset($departmentsType->created_at)
                                        ? $departmentsType->created_at->toDateString()
                                        : "<span style='color:blue;'>----------</span>" !!}
                                    </td>
                                    {{-- status --}}
                                    <td>
                                        @if ($departmentsType->status == 'Active')
                                        <a href="{{ route('super_admin.departments_types-activeInactiveSingle', isset($departmentsType->id) ? $departmentsType->id : -1) }}"
                                            class="process btn waves-effect waves-light btn-light-danger btn-sm"
                                            title="Set Inactive"><i class="mdi mdi-pause"></i>
                                        </a>
                                        <span style="color:green;"><strong>{{ isset($departmentsType->status) ?
                                                $departmentsType->status : '----' }}</strong></span>
                                        @elseif($departmentsType->status == 'Inactive')
                                        <a href="{{ route('super_admin.departments_types-activeInactiveSingle', isset($departmentsType->id) ? $departmentsType->id : -1) }}"
                                            class="process btn waves-effect waves-light btn-light-success btn-sm"
                                            title="Set Active"><i class="mdi mdi-play"></i>
                                        </a>
                                        <span style="color:red;"> <strong>
                                                {{ isset($departmentsType->status) ? $departmentsType->status : '----'
                                                }}
                                            </strong> </span>
                                        @else
                                        -----
                                        @endif
                                    </td>
                                    {{-- optiones --}}
                                    <td>
                                        <div class="button-group">

                                            <a href="{{ route('super_admin.departments_types-edit', isset($departmentsType->id) ? $departmentsType->id : -1) }}"
                                                class="btn waves-effect waves-light btn-secondary btn-sm"
                                                title="Edit"><i class="fas fa-edit"></i></a>
                                            <a href="{{ route('super_admin.departments_types-softDelete', isset($departmentsType->id) ? $departmentsType->id : -1) }}"
                                                class="confirm btn waves-effect waves-light btn-danger btn-sm"
                                                title="Delete"><i class="fas fa-trash-alt"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @empty

                                @endforelse

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
                searching:false,
                pageLength: 50, // Set the number of records per page
                order: [
                    [2, 'desc'] // Sorting by Date/Time column
                ],
                columnDefs: [{
                        type: 'date',
                        targets: [2]
                    },
                   
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