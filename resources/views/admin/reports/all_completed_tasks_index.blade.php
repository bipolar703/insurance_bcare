@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">All Completed Tasks
                    @if (isset($allCompletedTasks))
                        ({{ $allCompletedTasks->count() }})
                    @endif
                </h3>

                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">All Completed Tasks</li>
                        </ol>
                    </nav>
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
                    <div class="border-bottom title-part-padding">
                        <h4 class="card-title mb-0">All Completed Tasks</h4>
                    </div>
                    <div class="card-body">
                        {{-- Statistics Section --}}
                        {{-- <div class="col-12">
                        <div id="item-details-statistics"></div>
                        <div id="item-total-revenue"></div>
                        </div> --}}

                        {{-- Table Section --}}
                        <div class="table-responsive">
                            <table id="file_export_projects_in_queue" class="table table-striped table-bordered display">
                                <thead>
                                    <tr>
                                        <th>#REF</th>
                                        <th>Title</th>
                                        <th>Name AR</th>
                                        <th>Employee</th>
                                        <th>Priority</th>
                                        {{-- <th>Control</th> --}}
                                    </tr>
                                </thead>
                                @if (isset($allCompletedTasks))
                                    <tbody>
                                        @foreach ($allCompletedTasks as $allCompletedTask)
                                            <tr>
                                                <td>
                                                    <strong>
                                                        {{ isset($allCompletedTask->id) ? $allCompletedTask->id : '----' }}
                                                    </strong>
                                                </td>

                                                <td>
                                                    <strong>
                                                        {{ isset($allCompletedTask->title) ? $allCompletedTask->title : '----' }}
                                                    </strong>
                                                </td>

                                                <td><a
                                                        href="{{ route('super_admin.projects-show', isset($allCompletedTask->project_id) ? $allCompletedTask->project_id : -1) }}">
                                                        <strong>
                                                            {{ isset($allCompletedTask->projects->name_ar) ? $allCompletedTask->projects->name_ar : '----' }}
                                                        </strong>
                                                    </a>
                                                </td>

                                                <td><a
                                                        href="{{ route('super_admin.employees-show', isset($allCompletedTask->user_id) ? $allCompletedTask->user_id : -1) }}">
                                                        <strong>
                                                            {{ isset($allCompletedTask->users->name) ? $allCompletedTask->users->name : '----' }}
                                                        </strong>
                                                    </a>
                                                </td>


                                                {{-- customer --}}
                                                <td>
                                                    <strong>{{ isset($allCompletedTask->task_priority) ? $allCompletedTask->task_priority : '----' }}
                                                    </strong>
                                                </td>

                                                {{-- <td>
                                                    <div class="button-group">
                                                        <a href="{{ route('super_admin.projects-show', isset($allCompletedTask->id) ? $allCompletedTask->id : -1) }}"
                                    class="btn waves-effect waves-light btn-primary btn-sm"
                                    title="View Details"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('super_admin.projects-edit', isset($allCompletedTask->id) ? $allCompletedTask->id : -1) }}" class="btn waves-effect waves-light btn-secondary btn-sm" title="Edit"><i class="fas fa-edit"></i></a>
                                    <a href="{{ route('super_admin.projects-softDelete', isset($allCompletedTask->id) ? $allCompletedTask->id : -1) }}" class="confirm btn waves-effect waves-light btn-danger btn-sm" title="Delete"><i class="fas fa-trash-alt"></i></a>
                    </div>
                    </td> --}}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                @endif
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
            if ($.fn.DataTable.isDataTable('#file_export_projects_in_queue')) {
                $('#file_export_projects_in_queue').DataTable().destroy();
            }

            $('#file_export_projects_in_queue').DataTable({
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, 'All']
                ],
                pageLength: 25, // Set default page length
                paging: true, // Enable pagination
                order: [
                    [0, 'asc']
                ],
                columnDefs: [{
                    type: 'date',
                    targets: [3]
                }],
                dom: '<"top"lfB<"export-buttons">>rtip', // Place length menu at the top and buttons in a separate container
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
