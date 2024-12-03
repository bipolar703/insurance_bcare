@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Edit Extra Task</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.tasks-index') }}">All Tasks</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Extra Task</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Archive --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.tasks-showSoftDelete') }}" class="btn btn-danger">
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
                {{-- Form Section --}}
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3 pb-3 border-bottom">Edit Extra Task :</h4>
                        <form action="{{ route('super_admin.tasks-updateExtraTask', isset($task->id) ? $task->id : -1) }}" method="POST"
                            enctype="multipart/form-data" id="createForm">
                            @csrf
                            <div class="row">

                                {{-- title --}}
                                <div class="col-md-4">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="title"
                                            class="form-control border border-info @error('title') border-danger @enderror"
                                            id="tb-title" value="{!!isset($task->title) ? $task->title : null!!}" placeholder="Title">
                                        <label for="tb-title">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i> Title
                                            <strong class="text-danger">
                                                @error('title')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- project_id --}}
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <select name="project_id" id="project_id"
                                            class="form-control form-select border border-info @error('customer_id') border-danger @enderror custom_select_style"
                                            style="width: 100%">
                                            @if (isset($myProjects) && $myProjects->count() > 0)
                                                <option value="">Select Project Name</option>
                                                @foreach ($myProjects as $project)
                                                    <option value="{{ $project->project_id }}"
                                                        @if ($task->project_id == $project->project_id) selected @endif>
                                                        {{ isset($project->project->name_en) ? $project->project->name_en : '------' }}
                                                    </option>
                                                @endforeach
                                            @else
                                                <option value="">No Project Is Available</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>



                                {{-- Task Start Date --}}
                                <div class="col-md-4">
                                    <div class="form-floating mb-3">
                                        <input type="date" name="task_start_date"
                                            class="form-control border border-info @error('task_start_date') border-danger @enderror"
                                            id="tb-name" value="{!!isset($task->task_start_date) ? $task->task_start_date : null!!}"
                                            placeholder="Task Start Date">
                                        <label for="tb-name">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>Task
                                            Start Date
                                            <strong class="text-danger">
                                                @error('task_start_date')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- Task End Date --}}
                                <div class="col-md-4">
                                    <div class="form-floating mb-3">
                                        <input type="date" name="task_end_date"
                                            class="form-control border border-info @error('task_end_date') border-danger @enderror"
                                            id="tb-name" value="{!!isset($task->task_end_date) ? $task->task_end_date : null!!}"
                                            placeholder="Task Start Date">
                                        <label for="tb-name">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>Task
                                            End Date
                                            <strong class="text-danger">
                                                @error('task_end_date')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- actual_time --}}
                                <div class="col-md-4">
                                    <div class="form-floating mb-3">
                                        <input type="number" step=".01" name="actual_time"
                                            class="form-control border border-info @error('actual_time') border-danger @enderror"
                                            id="tb-name" value="{!!isset($task->actual_time) ? $task->actual_time : null!!}" placeholder="Estimated Time">
                                        <label for="tb-name">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>Actual
                                            Time
                                            <strong class="text-danger">
                                                @error('actual_time')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>


                                {{-- task_priority --}}
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                            <select name="task_priority"
                                                class="form-control form-select border border-info @error('task_priority') border-danger @enderror custom_select_style">
                                                <option>--- Choose Task Priority ---</option>
                                                <option value="1" @if (isset($task->task_priority) && $task->task_priority == 'Low') selected @endif
                                                    @if (!isset($task->task_priority)) selected @endif>Low </option>
                                                <option value="2" @if (isset($task->task_priority) && $task->task_priority == 'Medium') selected @endif>
                                                    Medium </option>
                                                <option value="3" @if (isset($task->task_priority) && $task->task_priority == 'High') selected @endif>
                                                    High </option>

                                            </select>
                                            <label for="tb-name">
                                                <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                                Choose Task Priority
                                                <strong class="text-danger">
                                                    @error('task_priority')
                                                        ( {{ $message }} )
                                                    @enderror
                                                </strong>
                                            </label>
                                        </div>

                                    </div>
                                </div>
                                {{-- Files --}}
                                <div class="col-md-4">
                                    <div class="form-floating mb-3 ">
                                        <input type="file" name="other_file"
                                            class="form-control @error('other_file') is-invalid @enderror"
                                            id="other_file">
                                        <label for="other_file">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                            Choose File
                                            <strong class="text-danger">
                                                @error('other_file')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>


                                </div>
                                {{-- Other File Title --}}
                                <div class="col-md-4">
                                    <div class="form-floating mb-3">
                                        <input type="text"name="other_file_title"
                                            class="form-control border border-info @error('other_file_title') border-danger @enderror"
                                            id="tb-name" value="{!!old('other_file_title') ? old('other_file_title') : null!!}"
                                            placeholder="Other File Title">
                                        <label for="tb-name">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>Other
                                            File Title
                                            <strong class="text-danger">
                                                @error('other_file_title')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>
                                {{-- Description --}}
                                <div class="col-md-12">
                                    <div class="form-floating mb-3">
                                        <textarea name="description" class="form-control border border-info @error('description') border-danger @enderror"
                                            id="tb-description-en" placeholder="Description" rows="15">{!!isset($task->description) ? $task->description : null!!}</textarea>
                                        <label for="tb-description-en">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                            Description
                                            <strong class="text-danger">
                                                @error('description')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>



                                {{-- Button --}}
                                <div class="col-12">
                                    <div class="d-md-flex align-items-center mt-3">
                                        <div class="ms-auto mt-3 mt-md-0">
                                            <button type="submit"
                                                class="btn btn-success font-weight-medium rounded-pill px-4">
                                                <div class="d-flex align-items-center">
                                                    <i data-feather="plus" class="feather-sm fill-white me-2"></i>
                                                   Update
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>



                    </div>  {{-- Table Section --}}
                          @if (isset($myTasks) && $myTasks->count() > 0)
                            <div class="table-responsive  container">
                            <table id="file_export_sales_tickets" class="table table-striped table-bordered display">
                                <thead>
                                    <tr>
                                        <th>#REF</th>
                                        <th>Tilte</th>
                                        <th>Project</th>
                                        <th>Task Start Date</th>
                                        <th>Task End Date</th>
                                        <th>Actual Time</th>
                                        <th>Priority</th>
                                        <th>Date/Time</th>
                                        <th>Control</th>
                                        <th>Select</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($myTasks as $task)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>

                                            <td><a
                                                    href="{{ route('super_admin.tasks-show', isset($task->id) ? $task->id : -1) }}">{{ isset($task->title) ? $task->title : '----' }}</a>
                                            </td>

                                            <td><a
                                                    href="{{ route('super_admin.projects-show', isset($task->projects->id) ? $task->projects->id : -1) }}">{{ isset($task->projects->name_en) ? $task->projects->name_en : '----' }}</a>
                                            </td>

                                            <td>{{ isset($task->task_start_date) ? $task->task_start_date : '----' }}</td>

                                            <td>{{ isset($task->task_end_date) ? $task->task_end_date : '----' }}</td>

                                            <td>{{ isset($task->actual_time) ? $task->actual_time : '----' }}</td>
                                            <td>{{ isset($task->task_priority) ? $task->task_priority : '----' }}</td>

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
                                                    <a href="{{ route('super_admin.tasks-editExtraTask', isset($task->id) ? $task->id : -1) }}"
                                                        class="btn waves-effect waves-light btn-secondary btn-sm"
                                                        title="Edit"><i class="fas fa-edit"></i></a>
                                                    <a href="{{ route('super_admin.tasks-destroy', isset($task->id) ? $task->id : -1) }}"
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
                                        <th>#REF</th>
                                        <th>Tilte</th>
                                        <th>Project</th>
                                        <th>Task Start Date</th>
                                        <th>Task End Date</th>
                                        <th>Actual Time</th>
                                        <th>Priority</th>
                                        <th>Date/Time</th>
                                        <th>Control</th>
                                        <th>Select</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                          @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('extra_js')
    <script>
        $(document).ready(function() {
            $('select[name="project_id"]').select2();


        });
    </script>
@endsection
