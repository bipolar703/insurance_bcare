@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">All Tasks</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.tasks-index') }}">All Tasks</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Archive</li>
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
                    @if (isset($tasks) && $tasks->count() > 0)
                        {{-- Setting --}}
                        <div class="dropdown me-2">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Setting
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li><button id="softDeleteRestoreSelected" class="unarchive dropdown-item"
                                        onclick="softDeleteRestoreSelected()">Restore Selected Tasks</button>
                                </li>
                            </ul>
                        </div>
                        {{-- Select/Deselect all --}}
                        <div class="dropdown me-2">
                            <button class="toggleSelectAllButton btn btn-primary" onclick="selectDeselectAll()">
                                Select/Deselect all</button>
                        </div>
                    @endif

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
                        <div class="table-responsive">
                            <table id="file_export" class="table table-striped table-bordered display">
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
                                            <td>{{ isset($task->title) ? $task->title : '----' }}</td>
                                            <td>{{ isset($task->description) ? $task->description : '----' }}</td>
                                            <td>{{ isset($task->projects->name_en) ? $task->projects->name_en : '----' }}</td>
                                            <td>{{ isset($task->users->name) ? $task->users->name : 'not assigned yet' }}
                                            </td>
                                            <th>{{ isset($task->status) ? $task->status : '----' }}</th>
                                            <th>{{ isset($task->received_date) ? $task->received_date : '----' }}</th>
                                            <td>{!! isset($task->created_at)
                                                ? '<strong>Date : </strong>' .
                                                    date('Y -m-d', strtotime($task->created_at)) .
                                                    '<br><strong>Time : </strong>' .
                                                    date('h:i A', strtotime($task->created_at)) .
                                                    '<br><strong>Since : </strong> ' .
                                                    $task->created_at->diffForHumans()
                                                : "<span style='color:blue;'>----------</span>" !!}</td>
                                            <td>
                                                <div class="button-group">
                                                    <a href="{{ route('super_admin.tasks-softDeleteRestore', [isset($task->id) ? $task->id : -1]) }}"
                                                        class="unarchive btn waves-effect waves-light btn-success btn-sm"
                                                        title="Restore this Record"><i class="mdi mdi-redo-variant"></i></a>

                                                    <a href="{{ route('super_admin.tasks-destroy', isset($task->id) ? $task->id : -1) }}"
                                                        class="confirm btn waves-effect waves-light btn-danger btn-sm"
                                                        title="Destroy Record"><i class="fas fa-trash-alt"></i></a>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" class="selectedTasks" name="selectedTasks[]"
                                                    value="{{ $task->id }}">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
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



    {{-- Soft Delete Restore Selected --}}
    <script>
        function softDeleteRestoreSelected() {
            // Collect the selected rows
            var selectedTasks = [];
            $('input[name="selectedTasks[]"]:checked').each(function() {
                selectedTasks.push($(this).val());
            });
            //If rows are selected, you can perform the function here
            if (selectedTasks.length > 0) {
                //Prepare the data as a query
                var query = '?selectedTasks=' + selectedTasks.join(',');
                // Create the link with the query
                var link = '{{ route('super_admin.tasks-softDeleteRestoreSelected') }}' + query;
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
@endsection
