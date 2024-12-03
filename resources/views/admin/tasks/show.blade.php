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
                            <li class="breadcrumb-item active" aria-current="page">Task Details</li>
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
                    {{-- Edit --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.tasks-edit', isset($task->id) ? $task->id : -1) }}"
                            class="btn btn-secondary">
                            <i data-feather="edit" class="fill-white feather-sm"></i> Edit
                        </a>
                    </div>
                    {{-- Active / Inactive --}}
                    <div class="dropdown me-2">
                        @if (isset($task->status) && $task->status == 'Active')
                            <a href="{{ route('super_admin.tasks-activeInactiveSingle', isset($task->id) ? $task->id : -1) }}"
                                class="process btn btn-warning">
                                <i data-feather="pause" class="fill-white feather-sm"></i> Set Inactive
                            </a>
                        @elseif(isset($task->status) && $task->status == 'Inactive')
                            <a href="{{ route('super_admin.tasks-activeInactiveSingle', isset($task->id) ? $task->id : -1) }}"
                                class="process btn btn-warning">
                                <i data-feather="play" class="fill-white feather-sm"></i> Set Active
                            </a>
                        @endif
                    </div>
                    {{-- Delete --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.tasks-softDelete', isset($task->id) ? $task->id : -1) }}"
                            class="confirm btn btn-danger">
                            <i data-feather="trash" class="fill-white feather-sm"></i> Delete
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
            {{-- Left Section --}}
            <div class="col-lg-3 col-xlg-3 col-md-5">
                <div class="card">
                    <div class="card-body">
                        <center class="mt-4">
                            {{-- Image --}}
                            <img src="{{ asset('style_files/shared/images_default/blueray_logo.jpg') }}"
                                class="rounded-circle" width="150" />

                            {{-- title --}}
                            <h4 class="card-title mt-2">
                                {{ isset($task->title) ? $task->title : '-------' }}</h4>


                            {{-- Status --}}
                            <small class="text-muted pt-4 db">Status</small>
                            <h6>
                                {{ isset($task->status) ? $task->status : '-------' }}
                            </h6>

                            {{-- Added Since --}}
                            <small class="text-muted pt-4 db">Added Since</small>
                            <h6>{!! isset($task->created_at) ? $task->created_at->diffForHumans() : '-------' !!}</h6>

                            {{-- Addition Time --}}
                            <small class="text-muted pt-4 db">Addition Time</small>
                            <h6>{!! isset($task->created_at) ? date('h:i A', strtotime($task->created_at)) : '-------' !!}</h6>

                            {{-- Addition Date --}}
                            <small class="text-muted pt-4 db">Addition Date</small>
                            <h6>{!! isset($task->created_at) ? date('Y / F (m) / d', strtotime($task->created_at)) : '-------' !!}</h6>
                        </center>
                    </div>
                </div>
            </div>

            {{-- Right Section --}}
            <div class="col-lg-9 col-xlg-9 col-md-7">
                <div class="card">
                    {{-- Tabs Header Section --}}
                    <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
                        {{-- Tab 1 : Main Info --}}
                        <li class="nav-item">
                            <a class="nav-link active" id="tab_header_1" data-bs-toggle="pill" href="#tab_body_1"
                                role="tab" aria-controls="pills-profile" aria-selected="false"><strong>Main
                                    Info</strong></a>
                        </li>

                        {{-- Tab 2 : Other files --}}
                        <li class="nav-item">
                            <a class="nav-link fade" id="tab_header_2" data-bs-toggle="pill" href="#tab_body_2"
                                role="tab" aria-controls="pills-profile" aria-selected="false"><strong>
                                    Attachments</strong></a>
                        </li>
                    </ul>

                    <div class="tab-content" id="pills-tabContent">
                        {{-- Tab One --}}
                        <div class="tab-pane fade show active" id="tab_body_1" role="tabpanel" aria-labelledby="tab_body_1">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="table-responsive">
                                            <table id="file_export_support_team"
                                                class="table table-striped table-bordered display">
                                                <thead>

                                                    <tr>
                                                        <th style="background-color:aliceblue">Title :</th>
                                                        <td> <strong>
                                                                {{ isset($task->title) ? $task->title : '----' }}
                                                            </strong></td>
                                                    </tr>
                                                    <tr>
                                                        <th style="background-color:aliceblue">Project :</th>
                                                        <td> <strong>
                                                                {{ isset($task->projects->name_en) ? $task->projects->name_en : '----' }}
                                                            </strong></td>
                                                    </tr>
                                                    <tr>
                                                        <th style="background-color:aliceblue">Department :</th>
                                                        <td> <strong>
                                                                {{ isset($task->department->name) ? $task->department->name : '----' }}
                                                            </strong></td>
                                                    </tr>
                                                    <tr>
                                                        <th style="background-color:aliceblue">Employee :</th>
                                                        <td> <strong>
                                                                {{ isset($task->users->name) ? $task->users->name : '----' }}
                                                            </strong></td>
                                                    </tr>

                                                    <tr>
                                                        <th style="background-color:aliceblue">Task Start Date :</th>
                                                        <td> <strong>
                                                                {{ isset($task->task_start_date) ? $task->task_start_date : '----' }}
                                                            </strong></td>
                                                    </tr>
                                                    <tr>
                                                        <th style="background-color:aliceblue">Task End Date :</th>
                                                        <td> <strong>
                                                                {{ isset($task->task_end_date) ? $task->task_end_date : '----' }}
                                                            </strong></td>
                                                    </tr>


                                                    <tr>
                                                        <th style="background-color:aliceblue">Task Status :</th>
                                                        <td>
                                                            <strong>
                                                                @if (isset($task->status) && $task->status == 'Completed')
                                                                    <span
                                                                        style="color: green;"><strong>{{ isset($task->status) ? $task->status : '----' }}</strong></span>
                                                                @elseif(isset($task->status) && $task->status == 'In Queue')
                                                                    <span
                                                                        style="color:ORANGE;"><strong>{{ isset($task->status) ? $task->status : '----' }}</strong></span>
                                                                @else
                                                                    <span style="color: blue">
                                                                        <strong>
                                                                            {{ isset($task->status) ? $task->status : '----' }}
                                                                        </strong>
                                                                    </span>
                                                                @endif
                                                            </strong>
                                                        </td>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="table-responsive">
                                            <table id="file_export_status_team"
                                                class="table table-striped table-bordered display">
                                                <thead>

                                                    <tr>
                                                        <th style="background-color:aliceblue">Task Priority :</th>
                                                        <td>
                                                            <strong>
                                                                @if (isset($task->task_priority) && $task->task_priority == 'High')
                                                                    <span
                                                                        style="color: red;"><strong>{{ isset($task->task_priority) ? $task->task_priority : '----' }}</strong></span>
                                                                @elseif(isset($task->task_priority) && $task->task_priority == 'Medium')
                                                                    <span
                                                                        style="color:ORANGE;"><strong>{{ isset($task->task_priority) ? $task->task_priority : '----' }}</strong></span>
                                                                @else
                                                                    <span style="color: blue">
                                                                        <strong>
                                                                            {{ isset($task->task_priority) ? $task->task_priority : '----' }}
                                                                        </strong>
                                                                    </span>
                                                                @endif
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th style="background-color:aliceblue">Created By :</th>
                                                        <td> <strong>
                                                                {{ isset($task->created_by) ? $task->created_by : '----' }}
                                                            </strong></td>
                                                    </tr>
                                                    <tr>
                                                        <th style="background-color:aliceblue">Estimated Time :</th>
                                                        <td> <strong>
                                                                {{ isset($task->estimated_time) ? $task->estimated_time : '----' }}
                                                            </strong></td>
                                                    </tr>

                                                    <tr>
                                                        <th style="background-color:aliceblue">Actual Time :</th>
                                                        <td> <strong>
                                                                {{ isset($task->actual_time) ? $task->actual_time : '----' }}
                                                            </strong></td>
                                                    </tr>
                                                    <tr>
                                                        <th style="background-color:aliceblue">Late Task :</th>
                                                        <td> <strong>
                                                                {{ isset($task->late_task) ? $task->late_task : '----' }}
                                                            </strong></td>
                                                    </tr>
                                                    <tr>
                                                        <th style="background-color:aliceblue">Received Date :</th>
                                                        <td> <strong>
                                                                {{ isset($task->received_date) ? $task->received_date : '----' }}
                                                            </strong></td>
                                                    </tr>
                                                  

                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table id="file_export_status_team"
                                                class="table table-striped table-bordered display">
                                                <thead>

                                                    

                                                  
                                                   
                                                    <tr>
                                                        <th style="background-color:aliceblue">Description :</th>
                                                        <td> <strong>
                                                                {{ isset($task->description) ? $task->description : '----' }}
                                                            </strong></td>
                                                    </tr>


                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>

                        {{-- Tab Two --}}
                        <div class="tab-pane fade show" id="tab_body_2" role="tabpanel" aria-labelledby="tab_body_2">
                            <div class="card-body">
                                <div class="row">
                                    @if (isset($task))
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="card-body">
                                                    {{-- Card Body : --}}
                                                    <div class="card-body">
                                                        {{-- Add Other attachments Form --}}
                                                        <form
                                                            action="{{ route('super_admin.tasks-addAttachments', $task->id) }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <input type="hidden" name="task_id"
                                                                value="{{ $task->id }}">

                                                            <div class="form-row">
                                                                {{-- Upload Other Files --}}
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label for="formFile"
                                                                                class="form-label">Upload Task Files :
                                                                                <strong class="text-danger">
                                                                                    @error('file')
                                                                                        ( {{ $message }} )
                                                                                    @enderror
                                                                                </strong>
                                                                            </label>
                                                                            <div class="alert alert-info alert-dismissible bg-info text-white border-0 fade show"
                                                                                role="alert">
                                                                                <strong>1- Valid extensions : pdf, word,
                                                                                    xlsx</strong>
                                                                            </div>
                                                                            <div class="alert alert-info alert-dismissible bg-info text-white border-0 fade show"
                                                                                role="alert">
                                                                                <strong>2- The maximum size of the uploaded
                                                                                    file is 20MB.</strong>
                                                                            </div>
                                                                            <div class="alert alert-info alert-dismissible bg-info text-white border-0 fade show"
                                                                                role="alert">
                                                                                <strong>3- Recommended dimensions : 200px *
                                                                                    300px.</strong>
                                                                            </div>
                                                                        </div>
                                                                    </div>


                                                                    {{-- Button --}}
                                                                    <div class="col-md-6 mb-3">
                                                                        <label class="text-dark font-weight-medium mb-3"
                                                                            for="validationServer01">Save Task Attachments
                                                                            :
                                                                        </label>

                                                                        <div class="col-md-12">
                                                                            <div
                                                                                class="mb-3 border border-info @error('file') border-danger @enderror">
                                                                                <center class="mt-4">
                                                                                    <h4 class="card-title mt-2">Task files
                                                                                    </h4>
                                                                                    <div class="col-md-6 mb-2">
                                                                                        <input type="file"
                                                                                            name="file"
                                                                                            id="otherFilesInput"
                                                                                            class="form-control" multiple>
                                                                                    </div>
                                                                                </center>
                                                                            </div> 
                                                                            <div class="col-md-12">
                                                                                <div class="form-floating mb-3">
                                                                                    <input type="text"name="title"
                                                                                        class="form-control border border-info @error('title') border-danger @enderror"
                                                                                        id="tb-name" value="{{ old('title') }}"
                                                                                        placeholder="Other File Title">
                                                                                    <label for="tb-name">
                                                                                        <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                                                                        File Title
                                                                                        <strong class="text-danger">
                                                                                            @error('title')
                                                                                                ( {{ $message }} )
                                                                                            @enderror
                                                                                        </strong>
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                            <button type="submit"
                                                                                class="btn btn-success btn-sm form-control">Upload
                                                                                Attachments </button>
                                                                        </div>


                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            @if ($task->taskAttachments->count() > 0)
                                                            <table id="file_export_sales_tickets" class="table table-striped table-bordered display">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#REF</th>
                                                                        <th>Title</th>
                                                                        <th>File</th>
                                                                        <th>Controls</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    
                                                                    @foreach ($task->taskAttachments as $attachment)
                                                                        <tr>
                                                                            <td>{{ $loop->iteration }}</td>
                                                                            <td>
                                                                                <p class="card-text">
                                                                                    {!! isset($attachment->title) ? $attachment->title : null !!}
                                                                                </p>
                                                                            </td>

                                                                            
                                                                            <td>
                                                                                <p class="card-text">
                                                                                    <a href="{{ asset($attachment->file) }}"
                                                                                        class="view-file-link" target="_blank">View
                                                                                        File</a>
                                                                                </p>
                                                                            </td>
                        
                                                                            </td>
                                                                            <td>
                                                                                <div class="button-group">
                                                                                    <a href="{{ route('super_admin.tasks-deleteAttachment', $attachment->id) }}"
                                                                                        class="btn btn-danger btn-sm"
                                                                                        onclick="return confirm('Are you sure you want to delete this file?');">
                                                                                        <i class="fa fa-trash"></i> Delete
                                                                                        File
                                                                                    </a>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                        
                                                            </table>
                                                            @else
                                                            <h3 style="color:blue;">No Files are uploaded</h3>
                                                            @endif
                                                        </div>
                                                    </div>
                                                 
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
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
            // Initialize the DataTable with export buttons
            var table = $('#file_export_sales_tickets').DataTable({
                searching: false,
            });
        });
    </script>
    @endsection
   