@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">All Closed Projects
                    @if (isset($allClosedProjects))
                        ({{ $allClosedProjects->count() }})
                    @endif
                </h3>

                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">All Closed Projects</li>
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
                        <h4 class="card-title mb-0">All Closed Projects</h4>
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
                                        <th>Name AR</th>
                                        <th>Name EN</th>
                                        <th>Customer</th>
                                        <th>Date/Time</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        {{-- <th>Control</th> --}}
                                    </tr>
                                </thead>
                                @if (isset($allClosedProjects))
                                    <tbody>
                                        @foreach ($allClosedProjects as $allClosedProject)
                                            <tr>
                                                <td><a
                                                        href="{{ route('super_admin.projects-show', isset($allClosedProject->id) ? $allClosedProject->id : -1) }}">
                                                        <strong>
                                                            {{ isset($allClosedProject->id) ? $allClosedProject->id : '----' }}
                                                        </strong>
                                                    </a>
                                                </td>

                                                <td><a
                                                        href="{{ route('super_admin.projects-show', isset($allClosedProject->id) ? $allClosedProject->id : -1) }}">
                                                        <strong>
                                                            {{ isset($allClosedProject->name_ar) ? $allClosedProject->name_ar : '----' }}
                                                        </strong>
                                                    </a>
                                                </td>

                                                <td><a
                                                        href="{{ route('super_admin.projects-show', isset($allClosedProject->projects->id) ? $allClosedProject->projects->id : -1) }}">
                                                        <strong>
                                                            {{ isset($allClosedProject->name_en) ? $allClosedProject->name_en : '----' }}
                                                        </strong>
                                                    </a>
                                                </td>


                                                {{-- customer --}}
                                                <td><a
                                                        href="{{ route('super_admin.customers-show', isset($allClosedProject->customer->id) ? $allClosedProject->customer->id : -1) }}">
                                                        <strong>{{ isset($allClosedProject->customer->name_en) ? $allClosedProject->customer->name_en : '----' }}
                                                        </strong>
                                                    </a>
                                                </td>



                                                <td>{!! isset($allClosedProject->created_at)
                                                    ? '<strong>Date : </strong>' .
                                                        date('Y -m-d', strtotime($allClosedProject->created_at)) .
                                                        '<br><strong>Time : </strong>' .
                                                        date('h:i A', strtotime($allClosedProject->created_at)) .
                                                        '<br><strong>Since : </strong> ' .
                                                        $allClosedProject->created_at->diffForHumans()
                                                    : "<span style='color:blue;'>----------</span>" !!}
                                                </td>

                                                <td>
                                                    <span style="color: red">
                                                        <strong>
                                                            {{ isset($allClosedProject->status) ? $allClosedProject->status : '----' }}
                                                        </strong>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span style="color: green">
                                                        <strong>
                                                            {{ isset($allClosedProject->total_contracts) ? $allClosedProject->total_contracts : '----' }}
                                                            JOD
                                                        </strong>
                                                    </span>
                                                </td>

                                                {{-- <td>
                                                    <div class="button-group">
                                                        <a href="{{ route('super_admin.projects-show', isset($allClosedProject->id) ? $allClosedProject->id : -1) }}"
                                                            class="btn waves-effect waves-light btn-primary btn-sm"
                                                            title="View Details"><i class="fas fa-eye"></i></a>
                                                        <a href="{{ route('super_admin.projects-edit', isset($allClosedProject->id) ? $allClosedProject->id : -1) }}"
                                                            class="btn waves-effect waves-light btn-secondary btn-sm"
                                                            title="Edit"><i class="fas fa-edit"></i></a>
                                                        <a href="{{ route('super_admin.projects-softDelete', isset($allClosedProject->id) ? $allClosedProject->id : -1) }}"
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
                    },
                    {
                        orderable: false,
                        targets: [6]
                    }
                ],
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
