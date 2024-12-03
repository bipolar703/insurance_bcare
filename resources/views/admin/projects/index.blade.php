@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">All Projects
                    @if (isset($allProjects))
                        ({{ $allProjects->count() }})
                    @endif
                </h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">All Projects</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Create --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.projects-create') }}" class="btn btn-dark">
                            <i data-feather="plus" class="fill-white feather-sm"></i> Add New Project
                        </a>
                    </div>
                    {{-- Archive --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.projects-showSoftDelete') }}" class="btn btn-danger">
                            <i data-feather="archive" class="fill-white feather-sm"></i> View Archived Projects
                        </a>
                    </div>
                    {{-- Setting --}}
                    <div class="dropdown me-2">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Setting
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li><button id="softDeleteSelected" class="confirm dropdown-item"
                                    onclick="softDeleteSelected()">Delete Selected</button></li>
                            {{-- <li><button id="activeSelected" class="process dropdown-item"
                                        onclick="activeSelected()">Active
                                        Selected</button></li>
                                <li><button id="inactiveSelected" class="process dropdown-item"
                                        onclick="inactiveSelected()">Inactive Selected</button></li> --}}
                        </ul>
                    </div>

                    {{-- <div class="dropdown me-2">
                        <button class="toggleSelectAllButton btn btn-primary" onclick="selectDeselectAll()">
                            Select/Deselect all</button>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>

    {{-- ========================================================== --}}
    {{-- ==================== Page Body Section =================== --}}
    {{-- ========================================================== --}}
    <div class="container-fluid ">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        {{-- Statistics --}}
                        <div class="col-md-12 mb-4 mt-4 groove-container">
                            <div class="card-header" style="background-color: aliceblue;">
                                <ul class="list-style-none mt-3 mb-2">
                                    <li class="mt-4">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <h4 class="mb-0 fw-bold">The Percentage of Projects Completed
                                                    <span class="fw-light"></span>
                                                </h4>
                                            </div>
                                            <div class="ms-auto">
                                                <h6 class="mb-0 fw-bold">100%</h6>
                                            </div>
                                        </div>
                                        <div class="progress mt-2">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 25%"
                                                aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                            <div class="progress-bar bg-cyan" role="progressbar" style="width: 25%"
                                                aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                            <div class="progress-bar bg-info" role="progressbar" style="width: 25%"
                                                aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 25%"
                                                aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        {{-- Search --}}
                        <div class="col-md-12 groove-container">
                            <label>
                                <h2>Search Section</h2>
                            </label>
                            <br>
                            <form action="{{ route('super_admin.projects-search') }}" method="get" class="row g-3"
                                id="searchForm">
                                @csrf

                                {{-- name --}}
                                <div class="col-md-3">
                                    <label for="name" class="form-label">Project Name</label>
                                    <input type="text" name="name"
                                        class="form-control border border-info @error('name') border-danger @enderror"
                                        id="tb-name" value="{{ $searchValues['name'] ?? '' }}" placeholder="Project Name">
                                    <label for="tb-name">
                                        <strong class="text-danger">
                                            @error('name')
                                                ( {{ $message }} )
                                            @enderror
                                        </strong>
                                    </label>
                                </div>

                                {{-- Customer Dropdown --}}
                                <div class="col-md-3">
                                    <label for="customerID" class="form-label">Select Customer Name</label>
                                    <select name="customerID" onchange="getCustomerProjects()"
                                        class="form-control @error('customerID') border border-danger @enderror"
                                        id="customerID">
                                        <option value="" selected>Select Customer Name</option>
                                        @if (isset($customers))
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}"
                                                    @if (isset($searchValues['customerID']) &&
                                                            ($searchValues['customerID'] == $customer->id || old('customer_id') == $customer->id)) selected @endif>
                                                    {{ $customer->name_en ?? '------' }}
                                                    ({{ $customer->name_ar ?? '------' }})
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                {{-- Project Dropdown --}}
                                <div class="col-md-3">
                                    <label for="projectSelect" class="form-label">Select Project Name <span>*</span></label>
                                    <select name="projectID"
                                        class="form-control @error('project_id') border border-danger @enderror"
                                        id="project">
                                        <option value="" selected>Select Project Name</option>
                                        @if (isset($allProjects))
                                            @forelse ($allProjects as $allProject)
                                                <option value="{{ $allProject->id }}"
                                                    @if (isset($searchValues['projectID']) &&
                                                            ($searchValues['projectID'] == $allProject->id || old('project_id') == $allProject->id)) selected @endif>
                                                    {{ $allProject->name_en ?? '------' }}
                                                    ({{ $allProject->name_ar ?? '------' }})
                                                </option>
                                            @empty
                                                <option value="" disabled>No Projects Are Available</option>
                                            @endforelse
                                        @endif
                                    </select>
                                </div>

                                {{-- Status Dropdown --}}
                                <div class="col-md-3">
                                    <label for="status" class="form-label">Choose Project Status</label>
                                    <select name="status"
                                        class="form-control @error('status') border border-danger @enderror">
                                        <option value="">--- Choose Project Status ---</option>
                                        <option value="1" @if (isset($searchValues['status']) && $searchValues['status'] == 1) selected @endif>In Queue
                                        </option>
                                        <option value="2" @if (isset($searchValues['status']) && $searchValues['status'] == 2) selected @endif>In Progress
                                        </option>
                                        <option value="3" @if (isset($searchValues['status']) && $searchValues['status'] == 3) selected @endif>Completed
                                            (Active)
                                        </option>
                                        <option value="4" @if (isset($searchValues['status']) && $searchValues['status'] == 4) selected @endif>Completed
                                            (Closed)
                                        </option>
                                        <option value="5" @if (isset($searchValues['status']) && $searchValues['status'] == 5) selected @endif>Closed
                                        </option>
                                    </select>
                                </div>

                                {{-- phone number --}}
                                <div class="col-md-3">
                                    <label for="name" class="form-label">Customer Number</label>
                                    <input type="text" name="phone"
                                        class="form-control border border-info @error('phone') border-danger @enderror"
                                        id="tb-phone" value="{{ $searchValues['phone'] ?? '' }}"
                                        placeholder="Customer Phone">
                                    <label for="tb-phone">
                                        <strong class="text-danger">
                                            @error('phone')
                                                ( {{ $message }} )
                                            @enderror
                                        </strong>
                                    </label>
                                </div>

                                {{-- email --}}
                                <div class="col-md-3">
                                    <label for="email" class="form-label">Customer Email</label>
                                    <input type="email" name="email"
                                        class="form-control border border-info @error('email') border-danger @enderror"
                                        id="tb-email" value="{{ $searchValues['email'] ?? '' }}"
                                        placeholder="Customer Email">
                                    <label for="tb-email">
                                        <strong class="text-danger">
                                            @error('email')
                                                ( {{ $message }} )
                                            @enderror
                                        </strong>
                                    </label>
                                </div>

                                {{-- Add more filters as needed --}}
                                <div class="col-md-12 text-end">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </form>
                        </div>
                        <br>
                        {{-- Table Section --}}
                        <div class="table-responsive">
                            {{-- project->id --}}
                            <table id="file_export_project" class="table table-striped table-bordered display">
                                <thead>
                                    <tr>
                                        <th>#REF</th>
                                        <th>Name</th>
                                        {{-- <th>Customer</th> --}}
                                        <th>Date/Time</th>
                                        <th>Status</th>
                                        <th>Domain</th>
                                        <th>Total</th>
                                        <th>Statistics</th>
                                        <th>Control</th>
                                        <th>
                                            <input type="checkbox" class="toggleSelectAllCheckbox" id="selectAllCheckbox"
                                                onclick="selectDeselectAll()">
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @if (isset($projects))
                                        @forelse  ($projects as $project)
                                            <tr>
                                                <td class="counter"></td>

                                                {{-- name_ar && name_en --}}
                                                <td><a
                                                        href="{{ route('super_admin.projects-show', isset($project->id) ? $project->id : -1) }}">
                                                        <strong style="width:225px; display:block;">
                                                            {{ isset($project->name_en) ? $project->name_en : '----' }} ({{ isset($project->name_ar) ? $project->name_ar : '----' }})
                                                        </strong>
                                                    </a>
                                                </td>

                                                {{-- customer --}}
                                                {{-- <td><a
                                                        href="{{ route('super_admin.customers-show', isset($project->customer->id) ? $project->customer->id : -1) }}">
                                                        {{ isset($project->customer->name_en) ? $project->customer->name_en : '----' }}
                                                    </a>
                                                </td> --}}

                                                {{-- signing_date --}}
                                                <td><strong  style="width:100px; display:block;">{{ isset($project->signing_date) ? $project->signing_date : '----' }}</strong></td>

                                                {{-- status --}}
                                                {{-- 1 => In Queue || 2 => In Progress || 3 => Completed (Archived) || 4 => Completed (Closed) || 5=> Closed --}}
                                                <td>
                                                    @if (isset($project->status) && $project->status == 'In Queue')
                                                        <span style="color: orange;"><strong>{{ $project->status }}</strong></span>
                                                    @elseif(isset($project->status) && $project->status == 'In Progress')
                                                        <span style="color: blue;"><strong>{{ $project->status }}</strong></span>
                                                    @elseif(isset($project->status) && $project->status == 'Completed (Active)')
                                                        <span style="color: green;"><strong>{{ $project->status }}</strong></span>    
                                                    @elseif(isset($project->status) && $project->status == 'Completed (Closed)')
                                                        <span style="color: green;"><strong>{{ $project->status }}</strong></span>    
                                                    @elseif(isset($project->status) && $project->status == 'Closed')
                                                        <span style="color: red;"><strong>{{ $project->status }}</strong></span>    
                                                    @else
                                                        {{ isset($project->status) ? $project->status : '----' }}
                                                    @endif
                                                </td>

                                                {{-- customer --}}
                                                <td><a
                                                        href="{{ isset($project->domain_url) ? $project->domain_url: '----' }}" target="_blank">
                                                        {{ isset($project->domain_url) ? $project->domain_url: '----' }}
                                                    </a>
                                                </td>

                                                <td><span style="color:GREEN;">
                                                        <strong>
                                                            {{ isset($project->total_contracts) ? $project->total_contracts : '----' }}
                                                            JOD
                                                        </strong>
                                                    </span>
                                                </td>

                                                {{-- Statistics --}}
                                                <td style="width: 50%">
                                                    <ul class="list-style-none mt-3 mb-2">
                                                        <li>
                                                            <div class="d-flex align-items-center">
                                                                <div>
                                                                    <h6 class="mb-0 fw-bold">Main <span class="fw-light"></span></h6>
                                                                </div>
                                                                <div class="ms-auto">
                                                                    <h6 class="mb-0 fw-bold">100%</h6>
                                                                </div>
                                                            </div>
                                                            <div class="progress mt-2">
                                                                <div class="progress-bar bg-danger" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                                <div class="progress-bar bg-cyan" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                                <div class="progress-bar bg-info" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                                <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </li>
                                                        <li class="mt-4">
                                                            <div class="d-flex align-items-center">
                                                                <div>
                                                                    <h6 class="mb-0 fw-bold">Dev <span class="fw-light"></span></h6>
                                                                </div>
                                                                <div class="ms-auto">
                                                                    <h6 class="mb-0 fw-bold">100%</h6>
                                                                </div>
                                                            </div>
                                                            <div class="progress mt-2">
                                                                <div class="progress-bar bg-danger" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                                <div class="progress-bar bg-cyan" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                                <div class="progress-bar bg-info" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                                <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </li>
                                                        <li class="mt-4">
                                                            <div class="d-flex align-items-center">
                                                                <div>
                                                                    <h6 class="mb-0 fw-bold">Finance <span class="fw-light"></span></h6>
                                                                </div>
                                                                <div class="ms-auto">
                                                                    <h6 class="mb-0 fw-bold">100%</h6>
                                                                </div>
                                                            </div>
                                                            <div class="progress mt-2">
                                                                <div class="progress-bar bg-danger" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                                <div class="progress-bar bg-cyan" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                                <div class="progress-bar bg-info" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                                <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </li>
                                                        {{-- <li class="mt-4">
                                                            <div class="d-flex align-items-center">
                                                                <div>
                                                                    <h6 class="mb-0 fw-bold">Subsicription <span class="fw-light"></span></h6>
                                                                </div>
                                                                <div class="ms-auto">
                                                                    <h6 class="mb-0 fw-bold">100%</h6>
                                                                </div>
                                                            </div>
                                                            <div class="progress mt-2">
                                                                <div class="progress-bar bg-danger" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                                <div class="progress-bar bg-cyan" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                                <div class="progress-bar bg-info" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                                <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </li> --}}
                                                    </ul>
                                                </td>

                                                {{-- operations --}}
                                                <td>
                                                    <div class="button-group" style="width:90px;">
                                                        <a href="{{ route('super_admin.projects-show', isset($project->id) ? $project->id : -1) }}"
                                                            class="btn waves-effect waves-light btn-primary btn-sm"
                                                            title="View Details"><i class="fas fa-eye"></i></a>

                                                        <a href="{{ route('super_admin.projects-edit', isset($project->id) ? $project->id : -1) }}"
                                                            class="btn waves-effect waves-light btn-secondary btn-sm"
                                                            title="Edit"><i class="fas fa-edit"></i></a>

                                                        @if ($project->projectInvoices->where('status', 'Paid')->isEmpty() && $project->status != 'Completed')
                                                            <a href="{{ route('super_admin.projects-softDelete', isset($project->id) ? $project->id : -1) }}"
                                                                class="confirm btn waves-effect waves-light btn-danger btn-sm"
                                                                title="Delete"><i class="fas fa-trash-alt"></i></a>
                                                        @endif


                                                    </div>
                                                </td>

                                                <td class="text-center">
                                                    <input type="checkbox" class="selectedProjects"
                                                        name="selectedProjects[]" value="{{ $project->id }}">
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8">No projects found</td>
                                            </tr>
                                        @endforelse
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3 d-flex justify-content-center">
                            {{-- {{ $projects->links('pagination::bootstrap-4') }} --}}
                            @if (isset($projects))
                                {{ $projects->appends(request()->query())->links('pagination::bootstrap-4') }}
                            @endif
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
            var selectedProjects = document.querySelectorAll(".selectedProjects");
            // Determine whether the boxes are selected or not
            var areAllChecked = true;
            for (var i = 0; i < selectedProjects.length; i++) {
                if (!selectedProjects[i].checked) {
                    areAllChecked = false;
                    break;
                }
            }
            // Change the status of the check box based on the current status
            for (var i = 0; i < selectedProjects.length; i++) {
                selectedProjects[i].checked = !areAllChecked;
            }
        }
    </script>

    {{-- Soft Delete Selected --}}
    <script>
        function softDeleteSelected() {
            //Collect the selected projects
            var selectedProjects = [];
            $('input[name="selectedProjects[]"]:checked').each(function() {
                selectedProjects.push($(this).val());
            });

            //If projects are selected, you can perform the function here
            if (selectedProjects.length > 0) {
                //Prepare the data as a query
                var query = '?selectedProjects=' + selectedProjects.join(',');
                // Create the link with the query
                var link = '{{ route('super_admin.projects-softDeleteSelected') }}' + query;
                // Direct the project to the link after preparing it
                window.location.href = link;
            } else {
                Swal.fire(
                    'Oops...',
                    'Please select at least one project',
                    'error'
                )
            }
        }
    </script>
    {{--
    <script>
        $(document).ready(function() {
            if ($.fn.DataTable.isDataTable('#file_export_project')) {
                $('#file_export_project').DataTable().destroy();
            }
            updateReferenceNumbers();


            function updateReferenceNumbers() {
                $('#projectTable .project-counter-placeholder').each(function(index) {
                    $(this).text(index + 1);
                });
            }


            $('#file_export_project').DataTable({
                paging: false,
                searching: false,
                order: [
                    [4, 'desc']
                ],
                columnDefs: [{
                        type: 'date',
                        targets: [4]
                    },
                    {
                        orderable: false,
                        targets: [7]
                    }
                ],
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

            // Check if the DataTable already exists and destroy it if needed
            if ($.fn.DataTable.isDataTable('#file_export_project')) {
                $('#file_export_project').DataTable().destroy();
            }

            // Update reference numbers
            updateReferenceNumbers();

            function updateReferenceNumbers() {
                $('#file_export_project .counter').each(function(index) {
                    $(this).text(index + 1);
                });
            }

            // Initialize the DataTable
            $('#file_export_project').DataTable({
                paging: false,
                searching: false,
                order: [
                    [4, 'desc']
                ],
                columnDefs: [{
                        type: 'date',
                        targets: [4]
                    },
                    {
                        orderable: false,
                        targets: [7,0,8]
                    }
                ],
                dom: 'Bfrtip',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
            });

            // Add styling to DataTable buttons
            $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass(
                'btn btn-primary mr-1');
        });
    </script> --}}

    <script>
        $(document).ready(function() {

            var originalOrder = []; // Array to store the original order of rows

            // Check if the DataTable already exists and destroy it if needed
            if ($.fn.DataTable.isDataTable('#file_export_project')) {
                $('#file_export_project').DataTable().destroy();
            }

            // Update reference numbers based on the original order
            updateReferenceNumbers();

            function updateReferenceNumbers() {
                // Update project counter placeholders based on the original order
                $('#file_export_project tbody tr').each(function(index) {
                    originalOrder.push($(this).find('.counter').text()); // Store original order
                    $(this).find('.counter').text(index + 1); // Update counter
                });
            }

            // Initialize the DataTable
            var table = $('#file_export_project').DataTable({
                paging: false,
                searching: false,
                order: [
                    [4, 'desc']
                ],
                columnDefs: [{
                        type: 'date',
                        targets: [4]
                    },
                    {
                        orderable: false,
                        targets: [8, 9]
                    }
                ],
                dom: 'Bfrtip',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
            });

            // Add styling to DataTable buttons
            $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass(
                'btn btn-primary mr-1');

            // Handle DataTable draw event to update reference numbers after sorting
            table.on('draw', function() {
                updateReferenceNumbers();
            });
        });
    </script>



    {{-- passed the test in https://validatejavascript.com/  using custom JS config --}}
    {{-- select 2 script --}}
    <script>
        $(document).ready(function() {
            $('select[name="projectID"]').select2();
            $('select[name="customerID"]').select2();
            $('select[name="search"]').select2();
        });
    </script>

    {{-- customers_projects --}}
    <script>
        // $(document).ready(function() {
        // Trigger the initial population
        // getCustomerProjects();

        // Event listener for changes in customer_id field
        $('#customerID').on('change', function() {
            getProjectsForCustomer(); // Fetch new projects when customer_id changes
        });

        function getProjectsForCustomer() {
            var customerID = $('#customerID').val(); // Fetch the updated customer ID
            if (customerID) {
                var fullRoute =
                    "{{ route('super_admin.projects-getProjectsForCustomer', 'customerID=:customerID') }}";
                fullRoute = fullRoute.replace(':customerID', customerID);
                $.ajax({
                    type: 'POST',
                    url: fullRoute,
                    processData: false,
                    contentType: false,
                    data: $('#searchForm').serialize(), // Serialize the form data including CSRF token
                    cache: false,
                    success: function(data) {
                        if (data.status == true) {
                            var selectProject = '<option value="">Select Project</option>';
                            data.projects.forEach(function(obj) {
                                selectProject += '<option value="' + obj.id + '">' + obj
                                    .name_en + '</option>';
                            });
                            $('#project_id').html(selectProject); // Populate the project dropdown
                        }
                    },
                    error: function(reject) {
                        var response = $.parseJSON(reject.responseText);
                        $.each(response.errors, function(key, val) {
                            $("#" + key + "_error").text(val[0]);
                        });
                    }
                });
            }
        }
        // });


        function getCustomerProjects() {
            var formData = new FormData($('#searchForm')[0]);
            $.ajax({
                type: 'POST',
                url: "{{ route('super_admin.projects-getProjectsForCustomer') }}",
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function(data) {
                    if (data.status == true) {

                        var selectProject = '<option value="">Select Project</option>';
                        for (var key in data.projects) {
                            if (!data.projects.hasOwnProperty(key)) continue;

                            var obj = data.projects[key];
                            for (var prop in obj) {
                                if (!obj.hasOwnProperty(prop)) continue;
                                var name = $("#name").val();
                                if (name) {
                                    if (obj.id == name) {

                                        selectProject += '<option value="' + obj.id + '" selected>' + obj
                                            .name_en +
                                            '</option>';
                                    } else {
                                        selectProject += '<option value="' + obj.id + '">' + obj.name_en +
                                            '</option>';
                                    }
                                } else {
                                    selectProject += '<option value="' + obj.id + '">' + obj.name_en +
                                        '</option>';
                                }
                                break;
                            }
                        }
                        $('#project').html(selectProject);
                    }

                },
                error: function(reject) {
                    var response = $.parseJSON(reject.responseText);
                    $.each(response.errors, function(key, val) {
                        $("#" + key + "_error").text(val[0]);
                    });
                }
            });
        }
    </script>


    {{-- <script>
    $(document).ready(function() {
        // Your existing DataTable initialization code goes here

        // Update reference numbers dynamically
        updateReferenceNumbers();
    });

    function updateReferenceNumbers() {
        // Select all elements with the class "project-counter-placeholder" within the project table
        $('#projectTable .project-counter-placeholder').each(function(index) {
            // Update the text content to the current index + 1
            $(this).text(index + 1);
        });
    }
</script> --}}
@endsection
