@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Insurances
                    @if (isset($insurances))
                        ({{ $insurances->count() }})
                    @endif
                </h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Insurances</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Create --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.insurances-create') }}" class="btn btn-dark">
                            <i data-feather="plus" class="fill-white feather-sm"></i> Add New
                        </a>
                    </div>
                    {{-- Archive --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.insurances-showSoftDelete') }}" class="btn btn-danger">
                            <i data-feather="archive" class="fill-white feather-sm"></i> View Archives
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
                        {{-- Table Section --}}
                        <div class="table-responsive">
                            <table id="file_export" class="table table-striped table-bordered display">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Insurance Type</th>
                                        <th>Price</th>
                                        <th>Date/Time</th>
                                        <th>Status</th>
                                        <th>Control</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($insurances as $insurance)
                                        <tr>
                                            {{-- Image --}}
                                            <td>
                                                <a href="{{ route('super_admin.insurances-show', isset($insurance->id) ? $insurance->id : -1) }}">
                                                    @if (isset($insurance->image) && $insurance->image && file_exists($insurance->image))
                                                        <img src="{{ asset($insurance->image) }}" width="150" height="100" />
                                                    @else
                                                        <img src="{{ asset('style_files/shared/images_default/default.jpg') }}" width="150" height="100" />
                                                    @endif
                                                </a>
                                            </td>

                                            {{-- Insurance Type --}}
                                            <td><a href="{{ route('super_admin.insurances-show', isset($insurance->id) ? $insurance->id : -1) }}"><strong>{{ isset($insurance->insurance_type) ? $insurance->insurance_type : '----' }}</strong></a></td>

                                            {{-- price --}}
                                            <td><strong>{{ isset($insurance->price) ? $insurance->price . ' SAR' : '----' }}</strong></td>

                                            {{-- created_at --}}
                                            <td>{!! isset($insurance->created_at)
                                                ? '<strong>Date : </strong>' .
                                                    date('Y -m-d', strtotime($insurance->created_at)) .
                                                    '<br><strong>Time : </strong>' .
                                                    date('h:i A', strtotime($insurance->created_at)) .
                                                    '<br><strong>Since : </strong> ' .
                                                    $insurance->created_at->diffForHumans()
                                                : "<span style='color:blue;'>----------</span>" !!}
                                            </td>

                                            {{-- status --}}
                                            <td>
                                                @if ($insurance->status == 'Active')
                                                    <a href="{{ route('super_admin.insurances-activeInactiveSingle', isset($insurance->id) ? $insurance->id : -1) }}"
                                                        class="process btn waves-effect waves-light btn-light-danger btn-sm"
                                                        title="Set Inactive"><i class="mdi mdi-pause"></i></a>
                                                    <span style="color:green;">
                                                        <strong>{{ isset($insurance->status) ? $insurance->status : '----' }}
                                                        </strong></span>
                                                @elseif($insurance->status == 'Inactive')
                                                    <a href="{{ route('super_admin.insurances-activeInactiveSingle', isset($insurance->id) ? $insurance->id : -1) }}"
                                                        class="process btn waves-effect waves-light btn-light-success btn-sm"
                                                        title="Set Active"><i class="mdi mdi-play"></i></a>
                                                    <span style="color:red;"><strong>{{ isset($insurance->status) ? $insurance->status : '----' }}
                                                        </strong></span>
                                                @endif
                                            </td>

                                            {{-- operations --}}
                                            <td>
                                                <div class="button-group">
                                                    <a href="{{ route('super_admin.insurances-show', isset($insurance->id) ? $insurance->id : -1) }}"
                                                        class="btn waves-effect waves-light btn-primary btn-sm"
                                                        title="View Details"><i class="fas fa-eye"></i></a>
                                                    <a href="{{ route('super_admin.insurances-edit', isset($insurance->id) ? $insurance->id : -1) }}"
                                                        class="btn waves-effect waves-light btn-secondary btn-sm"
                                                        title="Edit"><i class="fas fa-edit"></i></a>
                                                    <a href="{{ route('super_admin.insurances-softDelete', isset($insurance->id) ? $insurance->id : -1) }}"
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
   
    {{-- table search and pagination --}}
    <script>
        $(document).ready(function() {
            if ($.fn.DataTable.isDataTable('#file_export')) {
                $('#file_export').DataTable().destroy();
            }

            $('#file_export').DataTable({
                paging: true,
                pageLength: 50, // Set the number of records per page
                order: [
                    [3, 'desc'] // Sorting  column
                ],
                columnDefs: [{
                        type: 'date',
                        // targets: [2]
                    },
                    {
                        orderable: false,
                        // targets: [8, 6, 7]
                    }
                ],
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'copy',
                        exportOptions: {
                            columns: [1, 2, 3, 4] // Specify the columns you want to export
                        }
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [1, 2, 3, 4] // Specify the columns you want to export
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [1, 2, 3, 4] // Specify the columns you want to export
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [1, 2, 3, 4] // Specify the columns you want to export
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [1, 2, 3, 4] // Specify the columns you want to export
                        }
                    }
                ]
            });

            // Add styling to the DataTable buttons
            $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass(
                'btn btn-primary mr-1');
        });
    </script>
@endsection
