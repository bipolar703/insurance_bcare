@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">All In Queue Tasks
                    @if (isset($allInQueueTasks))
                        ({{ $allInQueueTasks->count() }})
                    @endif
                </h3>

                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">All In Queue Tasks</li>
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
                        <h4 class="card-title mb-0">All In Queue Tasks</h4>
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
                                @if (isset($allInQueueTasks))
                                    <tbody>
                                        @foreach ($allInQueueTasks as $allInQueueTask)
                                            <tr>
                                                <td>
                                                    <strong>
                                                        {{ isset($allInQueueTask->id) ? $allInQueueTask->id : '----' }}
                                                    </strong>
                                                </td>

                                                <td>
                                                    <strong>
                                                        {{ isset($allInQueueTask->title) ? $allInQueueTask->title : '----' }}
                                                    </strong>
                                                </td>

                                                <td><a
                                                        href="{{ route('super_admin.projects-show', isset($allInQueueTask->project_id) ? $allInQueueTask->project_id : -1) }}">
                                                        <strong>
                                                            {{ isset($allInQueueTask->projects->name_ar) ? $allInQueueTask->projects->name_ar : '----' }}
                                                        </strong>
                                                    </a>
                                                </td>

                                                <td><a
                                                        href="{{ route('super_admin.employees-show', isset($allInQueueTask->user_id) ? $allInQueueTask->user_id : -1) }}">
                                                        <strong>
                                                            {{ isset($allInQueueTask->users->name) ? $allInQueueTask->users->name : '----' }}
                                                        </strong>
                                                    </a>
                                                </td>


                                                {{-- customer --}}
                                                <td>
                                                    <strong>{{ isset($allInQueueTask->task_priority) ? $allInQueueTask->task_priority : '----' }}
                                                    </strong>
                                                </td>

                                                {{-- <td>
                                                    <div class="button-group">
                                                        <a href="{{ route('super_admin.projects-show', isset($allInQueueTask->id) ? $allInQueueTask->id : -1) }}"
                                                            class="btn waves-effect waves-light btn-primary btn-sm"
                                                            title="View Details"><i class="fas fa-eye"></i></a>
                                                        <a href="{{ route('super_admin.projects-edit', isset($allInQueueTask->id) ? $allInQueueTask->id : -1) }}"
                                                            class="btn waves-effect waves-light btn-secondary btn-sm"
                                                            title="Edit"><i class="fas fa-edit"></i></a>
                                                        <a href="{{ route('super_admin.projects-softDelete', isset($allInQueueTask->id) ? $allInQueueTask->id : -1) }}"
                                                            class="confirm btn waves-effect waves-light btn-danger btn-sm"
                                                            title="Delete"><i class="fas fa-trash-alt"></i></a>
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
    {{-- Select/Deselect all --}}
    <script>
        function selectDeselectAll() {
            // Get bcheckbox using CSS class classes
            var selectedProjectsInQueue = document.querySelectorAll(".selectedProjectsInQueue");
            // Determine whether the boxes are selected or not
            var areAllChecked = true;
            for (var i = 0; i < selectedProjectsInQueue.length; i++) {
                if (!selectedProjectsInQueue[i].checked) {
                    areAllChecked = false;
                    break;
                }
            }
            // Change the status of the check box based on the current status
            for (var i = 0; i < selectedProjectsInQueue.length; i++) {
                selectedProjectsInQueue[i].checked = !areAllChecked;
            }
        }
    </script>


    {{-- Soft Delete Selected --}}
    <script>
        function softDeleteSelected() {
            //Collect the selected cars
            var selectedProjectsInQueue = [];
            $('input[name="selectedProjectsInQueue[]"]:checked').each(function() {
                selectedProjectsInQueue.push($(this).val());
            });

            //If cars are selected, you can perform the function here
            if (selectedProjectsInQueue.length > 0) {
                //Prepare the data as a query
                var query = '?selectedProjectsInQueue=' + selectedProjectsInQueue.join(',');
                // Create the link with the query
                var link = '{{ route('super_admin.projects-softDeleteSelected') }}' + query;
                // Direct the bcarser to the link after preparing it
                window.location.href = link;
            } else {
                Swal.fire(
                    'Oops...',
                    'Please select at least one Task',
                    'error'
                )
            }
        }
    </script>


    {{--  --}}
    {{-- <script>
        $(document).ready(function() {
            if ($.fn.DataTable.isDataTable('#file_export')) {
                $('#file_export').DataTable().destroy();
            }

            $('#file_export').DataTable({
                paging: true,
                pageLength: 50,
                lengthMenu: [
                    [10, 25, 50, "All"]
                ],
                order: [
                    [0, 'desc']
                ],
                columnDefs: [{
                    type: 'date',
                    targets: [3]
                }],
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });

            $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass(
                'btn btn-primary mr-1');
        });
    </script> --}}

    {{-- <script>
        $(document).ready(function() {
            if ($.fn.DataTable.isDataTable('#file_export_projects_in_queue')) {
                $('#file_export_projects_in_queue').DataTable().destroy();
            }

            $('#file_export_projects_in_queue').DataTable({
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, 'All']
                ],
                pageLength: 50,
                order: [
                    [0, 'desc']
                ],
                columnDefs: [{
                        type: 'date',
                        targets: [3]
                    },
                    {
                        orderable: false,
                        targets: [6]
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
    </script> --}}
    
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
