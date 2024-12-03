@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Tasks
                    @if (isset($tasks))
                        ({{ $tasks->count() }})
                    @endif
                </h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">All Tasks</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Create --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.tasks-create') }}" class="btn btn-dark">
                            <i data-feather="plus" class="fill-white feather-sm"></i> Add New
                        </a>
                    </div>
                    {{-- Archive --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.tasks-showSoftDelete') }}" class="btn btn-danger">
                            <i data-feather="archive" class="fill-white feather-sm"></i> View Archive
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
                            <li><button id="inQueueStatusSelected" class="process dropdown-item"
                                    onclick="inQueueStatusSelected()">In Queue Status Selected</button></li>
                            <li><button id="inProgressSelected" class="process dropdown-item"
                                    onclick="inProgressSelected()">In Progress Selected</button></li>
                            <li><button id="inReviewSelected" class="process dropdown-item" onclick="inReviewSelected()">In
                                    Review Selected</button></li>
                            <li><button id="completedSelected" class="process dropdown-item"
                                    onclick="completedSelected()">Completed Selected</button></li>
                            <li><button id="extraTaskSelected" class="process dropdown-item"
                                    onclick="extraTaskSelected()">Extra Task Selected</button></li>


                        </ul>

                    </div>

                    <div class="dropdown me-2">
                        <button class="toggleSelectAllButton btn btn-primary" onclick="selectDeselectAll()">
                            Select/Deselect all</button>
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
                    <div class="border-bottom title-part-padding">
                        <h4 class="card-title mb-0">All Tasks</h4>
                    </div>
                    <div class="card-body">

                        {{-- Search --}}
                        <div class="col-md-12 groove-container">
                            <label>
                                <h2>Search Section</h2>
                            </label>
                            <br>
                            <form action="{{ route('super_admin.tasks-search') }}" method="get" class="row g-3"
                                id="searchForm">
                                @csrf

                                {{-- Task Title --}}
                                <div class="col-md-4">
                                    <label for="name" class="form-label">Task Name</label>
                                    <input type="text" name="title"
                                        class="form-control border border-info @error('title') border-danger @enderror"
                                        id="tb-name" value="{{ $searchValues['title'] ?? '' }}" placeholder="Task Title">
                                    <label for="tb-name">
                                        <strong class="text-danger">
                                            @error('title')
                                                ( {{ $message }} )
                                            @enderror
                                        </strong>
                                    </label>
                                </div>


                                {{-- Project Dropdown --}}
                                <div class="col-md-4">
                                    <label for="projectSelect" class="form-label">Select Project Name </label>
                                    <select name="project_id" onchange="getDepartments()"
                                    class="form-control form-select border border-info @error('project_id') border-danger @enderror custom_select_style"
                                    style="width: 100%"
                                        id="project_id">
                                        <option value="" selected>Select Project Name</option>
                                        @if (isset($projects) && $projects->count() > 0)
                                            @forelse ($projects as $project)
                                                <option value="{{ $project->id }}"
                                                    @if (isset($searchValues['project_id']) &&
                                                            ($searchValues['project_id'] == $project->id || old('project_id') == $project->id)) selected @endif>
                                                    {{ $project->name_en ?? '------' }}
                                                    ({{ $project->name_ar ?? '------' }})
                                                </option>
                                            @empty
                                                <option value="" disabled>No Projects Are Available</option>
                                            @endforelse
                                        @endif
                                    </select>
                                </div>
                                 {{-- Departments Dropdown --}}
                                 <div class="col-md-4">
                                    <label for="department" class="form-label">Select Department Name</label>
                                    <select name="department_id"  onchange="getProjects()"
                                    class="form-select border border-info @error('department_id') border-danger @enderror "
                                    style="width: 100%"
                                        id="department_id">
                                        <option value="" selected>Select Department Name</option>
                                        @if (isset($departments) && $departments->count() > 0)
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}"
                                                    @if (isset($searchValues['department_id']) &&
                                                            ($searchValues['department_id'] == $department->id || old('department_id') == $department->id)) selected @endif>
                                                    {{ $department->name ?? '------' }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                {{-- Status Dropdown --}}
                                <div class="col-md-4">
                                    <label for="status" class="form-label">Choose Task Status</label>
                                    <select name="status"
                                    class="form-select border border-info @error('status_id') border-danger @enderror "
                                    style="width: 100%">
                                        <option value="">--- Choose Task Status ---</option>
                                        <option value="1" @if (isset($searchValues['status']) && $searchValues['status'] == 1) selected @endif>In Queue
                                        </option>
                                        <option value="2" @if (isset($searchValues['status']) && $searchValues['status'] == 2) selected @endif>In Progress
                                        </option>
                                        <option value="3" @if (isset($searchValues['status']) && $searchValues['status'] == 3) selected @endif>In Review

                                        </option>
                                        <option value="4" @if (isset($searchValues['status']) && $searchValues['status'] == 4) selected @endif>Completed

                                        </option>
                                        <option value="5" @if (isset($searchValues['status']) && $searchValues['status'] == 5) selected @endif>Extra Task
                                        </option>
                                    </select>
                                </div>

                                {{-- Employees Dropdown --}}
                                <div class="col-md-4">
                                    <label for="user_id" class="form-label">Select Employee Name</label>
                                    <select name="user_id"
                                    class="form-select border border-info @error('user_id') border-danger @enderror "
                                    style="width: 100%"
                                        id="user_id">
                                        <option value="" selected>Select Employee Name</option>
                                        @if (isset($users) && $users->count() > 0 )
                                            @foreach ($users  as $user)
                                                <option value="{{ $user->id }}"
                                                    @if (isset($searchValues['user_id']) && ($searchValues['user_id'] == $user->id || old('user_id') == $user->id)) selected @endif>
                                                    {{ $user->name ?? '------' }}

                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>



                                {{-- Priority Dropdown --}}
                                <div class="col-md-4">
                                    <label for="task_priority" class="form-label">Choose Task Priority </label>
                                    <select name="task_priority"
                                    class="form-select border border-info @error('task_priority') border-danger @enderror "
                                    style="width: 100%">
                                        <option value="">--- Choose Task Priority ---</option>
                                        <option value="1" @if (isset($searchValues['task_priority']) && $searchValues['task_priority'] == 1) selected @endif>Low
                                        </option>
                                        <option value="2" @if (isset($searchValues['task_priority']) && $searchValues['task_priority'] == 2) selected @endif>Medium
                                        </option>
                                        <option value="3" @if (isset($searchValues['task_priority']) && $searchValues['task_priority'] == 3) selected @endif>High

                                        </option>

                                    </select>
                                </div>
                                {{-- Late Dropdown --}}
                                <div class="col-md-4">
                                    <label for="late_task" class="form-label">Choose Late Task Status </label>
                                    <select name="late_task"
                                    class="form-select border border-info @error('late_task') border-danger @enderror "
                                    style="width: 100%">
                                        <option value="">--- Choose Late Task Status ---</option>
                                        <option value="1" @if (isset($searchValues['late_task']) && $searchValues['late_task'] == 1) selected @endif>No
                                        </option>
                                        <option value="2" @if (isset($searchValues['late_task']) && $searchValues['late_task'] == 2) selected @endif>Yes
                                        </option>

                                    </select>
                                </div>

                                {{-- Task Start Date --}}
                                <div class="col-md-4">
                                    <div class="form-floating mb-3">
                                        <input type="date" name="task_start_date"
                                            class="form-control border border-info @error('task_start_date') border-danger @enderror"
                                            id="tb-name" value="{{ $searchValues['task_start_date'] ?? '' }}"
                                            placeholder="Task Start Date">
                                        <label for="tb-name">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>Task
                                            Start Date

                                        </label>
                                    </div>
                                </div>
                                {{-- Task End Date --}}
                                <div class="col-md-4">
                                    <div class="form-floating mb-3">
                                        <input type="date" name="task_end_date"
                                            class="form-control border border-info @error('task_end_date') border-danger @enderror"
                                            id="tb-name" value="{{ $searchValues['task_end_date'] ?? '' }}"
                                            placeholder="Task Start Date">
                                        <label for="tb-name">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>Task
                                            End Date

                                        </label>
                                    </div>
                                </div>
                                {{-- Task Received Date --}}
                                <div class="col-md-4">
                                    <div class="form-floating mb-3">
                                        <input type="date" name="received_date"
                                            class="form-control border border-info @error('received_date') border-danger @enderror"
                                            id="tb-name"  value="{{ $searchValues['received_date'] ?? '' }}"
                                            placeholder="Task Start Date">
                                        <label for="tb-name">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>Task
                                            Received Date

                                        </label>
                                    </div>
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
                            <table id="file_export_sales_tickets" class="table table-striped table-bordered display">
                                <thead>
                                    <tr>
                                        <th>Tilte</th>
                                        <th>Description</th>
                                        <th>Project</th>
                                        <th>Employee</th>
                                        <th>Status</th>
                                        <th>Received Date</th>
                                        <th>Date/Time</th>
                                        <th>Control</th>
                                        <th>Select</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tasks as $task)
                                        <tr>
                                            <td><a
                                                    href="{{ route('super_admin.tasks-show', isset($task->id) ? $task->id : -1) }}">{{ isset($task->title) ? $task->title : '----' }}</a>
                                            </td>
                                            <td><a
                                                    href="{{ route('super_admin.tasks-show', isset($task->id) ? $task->id : -1) }}">{{ isset($task->description) ? $task->description : '----' }}</a>
                                            </td>
                                            <td><a
                                                    href="{{ route('super_admin.projects-show', isset($task->projects->id) ? $task->projects->id : -1) }}">{{ isset($task->projects->name_en) ? $task->projects->name_en : '----' }}</a>
                                            </td>

                                            <td><a
                                                    href="#">{{ isset($task->users->name) ? $task->users->name : 'Still not assigned' }}</a>
                                            </td>
                                            <td>{{ isset($task->status) ? $task->status : '----' }}</td>

                                            <td>{{ isset($task->received_date) ? $task->received_date : '----' }}</td>

                                            <td>{!! isset($task->created_at)
                                                ? '<strong>Date : </strong>' .
                                                    date('Y -m-d', strtotime($task->created_at)) .
                                                    '<br><strong>Time : </strong>' .
                                                    date('h:i A', strtotime($task->created_at)) .
                                                    '<br><strong>Since : </strong> ' .
                                                    $task->created_at->diffForHumans()
                                                : "<span style='color:blue;'>----------</span>" !!}
                                            </td>

                                            <td>
                                                <div class="button-group">
                                                    <a href="{{ route('super_admin.tasks-show', isset($task->id) ? $task->id : -1) }}"
                                                        class="btn waves-effect waves-light btn-primary btn-sm"
                                                        title="View Details"><i class="fas fa-eye"></i></a>
                                                    <a href="{{ route('super_admin.tasks-edit', isset($task->id) ? $task->id : -1) }}"
                                                        class="btn waves-effect waves-light btn-secondary btn-sm"
                                                        title="Edit"><i class="fas fa-edit"></i></a>
                                                    <a href="{{ route('super_admin.tasks-softDelete', isset($task->id) ? $task->id : -1) }}"
                                                        class="confirm btn waves-effect waves-light btn-danger btn-sm"
                                                        title="Delete"><i class="fas fa-trash-alt"></i></a>
                                                </div>
                                            </td>

                                            <td class="text-center">
                                                <input type="checkbox" class="selectedTasks" name="selectedTasks[]"
                                                    value="{{ $task->id }}">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Tilte</th>
                                        <th>Description</th>
                                        <th>Project</th>
                                        <th>Employee</th>
                                        <th>Status</th>
                                        <th>Received Date</th>
                                        <th>Date/Time</th>
                                        <th>Control</th>
                                        <th>Select</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="mt-3 d-flex justify-content-center">
                            {{-- {{ $projects->links('pagination::bootstrap-4') }} --}}
                            @if (isset($tasks))
                                {{ $tasks->appends(request()->query())->links('pagination::bootstrap-4') }}
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
            var selectedTasks = document.querySelectorAll(".selectedTasks");
            // Determine whether the boxes are selected or not
            var areAllChecked = true;
            for (var i = 0; i < selectedTasks.length; i++) {
                if (!selectedTasks[i].checked) {
                    areAllChecked = false;
                    break;
                }
            }
            // Change the status of the check box based on the current status
            for (var i = 0; i < selectedTasks.length; i++) {
                selectedTasks[i].checked = !areAllChecked;
            }
        }
    </script>


    {{-- Soft Delete Selected --}}
    <script>
        function softDeleteSelected() {
            //Collect the selected cars
            var selectedTasks = [];
            $('input[name="selectedTasks[]"]:checked').each(function() {
                selectedTasks.push($(this).val());
            });

            //If cars are selected, you can perform the function here
            if (selectedTasks.length > 0) {
                //Prepare the data as a query
                var query = '?selectedTasks=' + selectedTasks.join(',');
                // Create the link with the query
                var link = '{{ route('super_admin.tasks-softDeleteSelected') }}' + query;
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


    {{-- inQueueStatusSelected --}}
    <script>
        function inQueueStatusSelected() {
            //Collect the selected cars
            var selectedTasks = [];
            $('input[name="selectedTasks[]"]:checked').each(function() {
                selectedTasks.push($(this).val());
            });

            //If cars are selected, you can perform the function here
            if (selectedTasks.length > 0) {
                //Prepare the data as a query
                var query = '?selectedTasks=' + selectedTasks.join(',');
                // Create the link with the query
                var link = '{{ route('super_admin.tasks-inQueueStatusSelected') }}' + query;
                // Direct the browser to the link after preparing it
                window.location.href = link;
            } else {
                Swal.fire(
                    'Oops...',
                    'Please select at least one row',
                    'error'
                )
            }
        }
    </script>


    {{-- inProgressSelected --}}
    <script>
        function inProgressSelected() {
            //Collect the selected cars
            var selectedTasks = [];
            $('input[name="selectedTasks[]"]:checked').each(function() {
                selectedTasks.push($(this).val());
            });

            //If cars are selected, you can perform the function here
            if (selectedTasks.length > 0) {
                //Prepare the data as a query
                var query = '?selectedTasks=' + selectedTasks.join(',');
                // Create the link with the query
                var link = '{{ route('super_admin.tasks-inProgressSelected') }}' + query;
                // Direct the browser to the link after preparing it
                window.location.href = link;
            } else {
                Swal.fire(
                    'Oops...',
                    'Please select at least one row',
                    'error'
                )
            }
        }
    </script>
    {{-- inReviewSelected --}}
    <script>
        function inReviewSelected() {
            //Collect the selected cars
            var selectedTasks = [];
            $('input[name="selectedTasks[]"]:checked').each(function() {
                selectedTasks.push($(this).val());
            });

            //If cars are selected, you can perform the function here
            if (selectedTasks.length > 0) {
                //Prepare the data as a query
                var query = '?selectedTasks=' + selectedTasks.join(',');
                // Create the link with the query
                var link = '{{ route('super_admin.tasks-inReviewSelected') }}' + query;
                // Direct the browser to the link after preparing it
                window.location.href = link;
            } else {
                Swal.fire(
                    'Oops...',
                    'Please select at least one row',
                    'error'
                )
            }
        }
    </script>
    {{-- completedSelected --}}
    <script>
        function completedSelected() {
            //Collect the selected cars
            var selectedTasks = [];
            $('input[name="selectedTasks[]"]:checked').each(function() {
                selectedTasks.push($(this).val());
            });

            //If cars are selected, you can perform the function here
            if (selectedTasks.length > 0) {
                //Prepare the data as a query
                var query = '?selectedTasks=' + selectedTasks.join(',');
                // Create the link with the query
                var link = '{{ route('super_admin.tasks-completedSelected') }}' + query;
                // Direct the browser to the link after preparing it
                window.location.href = link;
            } else {
                Swal.fire(
                    'Oops...',
                    'Please select at least one row',
                    'error'
                )
            }
        }
    </script>
    {{-- extraTaskSelected --}}
    <script>
        function extraTaskSelected() {
            //Collect the selected cars
            var selectedTasks = [];
            $('input[name="selectedTasks[]"]:checked').each(function() {
                selectedTasks.push($(this).val());
            });

            //If cars are selected, you can perform the function here
            if (selectedTasks.length > 0) {
                //Prepare the data as a query
                var query = '?selectedTasks=' + selectedTasks.join(',');
                // Create the link with the query
                var link = '{{ route('super_admin.tasks-extraTaskSelected') }}' + query;
                // Direct the browser to the link after preparing it
                window.location.href = link;
            } else {
                Swal.fire(
                    'Oops...',
                    'Please select at least one row',
                    'error'
                )
            }
        }
    </script>
    <script>
        $(document).ready(function() {
            $('select[name="project_id"]').select2();

            var table = $('#file_export_sales_tickets').DataTable({
                    searching: false,
                    dom: 'Bfrtip',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                });
                // Add styling to DataTable buttons
            $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel')
                .addClass('btn btn-primary mr-1');

        });
    </script>
    {{-- GetProjects --}}
       <script>
        function getDepartments() {
        var project_id = document.getElementById('project_id').value;
        var formData = new FormData($('#searchForm')[0]);
        $.ajax({
            type: 'POST',
            url: "{{ route('super_admin.tasks-getDepartments') }}?project_id=" + project_id,
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {
                console.log(data.departments)
                if (data.status == true) {

                    var selectdepartments = '<option value="">Choose Department ... </option>';

                    var obj = data.record;

                        // Design Department
                        selectdepartments += '<option value="' + obj.design_department_id + '">' + obj
                            .design_department_name + '</option>';
                        // Mobile Department
                        selectdepartments += '<option value="' + obj.mobile_department_id + '">' + obj
                            .mobile_department_name + '</option>';
                        // Web Department
                        selectdepartments += '<option value="' + obj.web_department_id + '">' + obj
                            .web_department_name + '</option>';

                    $('#department_id').html(selectdepartments);

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
    function getProjects() {
        var department_id = document.getElementById('department_id').value;
        var formData = new FormData($('#searchForm')[0]);
        $.ajax({
            type: 'POST',
            url: "{{ route('super_admin.tasks-getProjects') }}?department_id=" + department_id,
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {
                if (data.status == true) {
                    var selectProjects = '<option value="">Choose Project ... </option>';

                    for (var key in data.records) {
                        // skip loop if the property is from prototype
                        if (!data.records.hasOwnProperty(key)) continue;

                        var obj = data.records[key];
                        // alert(obj.id);
                        for (var prop in obj) {
                            // skip loop if the property is from prototype
                            if (!obj.hasOwnProperty(prop)) continue;


                                selectProjects += '<option value="' + obj.id + '">' + obj
                                    .name_en + ' ('+obj
                                    .name_ar +') ' +
                                    '</option>';

                            break;
                        }
                    }

                    $('#project_id').html(selectProjects);

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
@endsection
