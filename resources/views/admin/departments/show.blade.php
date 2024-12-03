@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">{{ isset($department->name) ? $department->name : '-------' }}</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.departments-index') }}">Departments</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Department Details</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Create --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.departments-create') }}" class="btn btn-dark">
                            <i data-feather="plus" class="fill-white feather-sm"></i> Add New Dept
                        </a>
                    </div>
                    {{-- Edit --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.departments-edit', isset($department->id) ? $department->id : -1) }}"
                            class="btn btn-secondary">
                            <i data-feather="edit" class="fill-white feather-sm"></i> Edit Dept
                        </a>
                    </div>
                    {{-- Active / Inactive --}}
                    <div class="dropdown me-2">
                        @if (isset($department->status) && $department->status == 'Active')
                            <a href="{{ route('super_admin.departments-activeInactiveSingle', isset($department->id) ? $department->id : -1) }}"
                                class="process btn btn-warning">
                                <i data-feather="pause" class="fill-white feather-sm"></i> Set Inactive
                            </a>
                        @elseif(isset($department->status) && $department->status == 'Inactive')
                            <a href="{{ route('super_admin.departments-activeInactiveSingle', isset($department->id) ? $department->id : -1) }}"
                                class="process btn btn-warning">
                                <i data-feather="play" class="fill-white feather-sm"></i> Set Active
                            </a>
                        @endif
                    </div>
                    {{-- Delete --}}
                    @if (
                        $department->webDepartmentProjects()->exists() ||
                            $department->mobileDepartmentProjects()->exists() ||
                            $department->designDepartmentProjects()->exists() ||
                            $department->department_type_id == 4)
                    @else
                        <div class="dropdown me-2">
                            <a href="{{ route('super_admin.departments-softDelete', isset($department->id) ? $department->id : -1) }}"
                                class="confirm btn btn-danger">
                                <i data-feather="trash" class="fill-white feather-sm"></i> Delete Dept
                            </a>
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
            {{-- Right Section --}}
            <div class="col-md-12">
                <div class="card">
                    {{-- Tabs Header Section --}}
                    <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
                        {{-- Tab 1 : Main Info --}}
                        <li class="nav-item">
                            <a class="nav-link active" id="tab_header_1" data-bs-toggle="pill" href="#tab_body_1"
                                role="tab" aria-controls="pills-profile" aria-selected="false"><strong>Main
                                    Info</strong></a>
                        </li>

                        {{-- Tab 2 : Projects Info --}}
                        <li class="nav-item">
                            <a class="nav-link fade" id="tab_header_2" data-bs-toggle="pill" href="#tab_body_2"
                                role="tab" aria-controls="pills-profile" aria-selected="false"><strong>Projects
                                </strong></a>
                        </li>

                        {{-- Tab 3 : Members Info --}}
                        <li class="nav-item">
                            <a class="nav-link fade" id="tab_header_3" data-bs-toggle="pill" href="#tab_body_3"
                                role="tab" aria-controls="pills-profile"
                                aria-selected="false"><strong>Members</strong></a>
                        </li>
                    </ul>

                    <div class="tab-content" id="pills-tabContent">
                        {{-- Tab One --}}
                        <div class="tab-pane fade show active" id="tab_body_1" role="tabpanel" aria-labelledby="tab_body_1">
                            <div class="card">
                                {{-- Statistics --}}
                                <div class="col-md-12 mb-4 mt-4 groove-container">
                                    <div class="card-header" style="background-color: aliceblue;">
                                        <ul class="list-style-none mt-3 mb-2">
                                            <li class="mt-4">
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <h6 class="mb-0 fw-bold">Team Evaluation Based on Projects <span
                                                                class="fw-light"></span></h6>
                                                    </div>
                                                    <div class="ms-auto">
                                                        <h6 class="mb-0 fw-bold">100%</h6>
                                                    </div>
                                                </div>
                                                <div class="progress mt-2">
                                                    <div class="progress-bar bg-danger" role="progressbar"
                                                        style="width: 25%" aria-valuenow="25" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                    <div class="progress-bar bg-cyan" role="progressbar" style="width: 25%"
                                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    <div class="progress-bar bg-info" role="progressbar"
                                                        style="width: 25%" aria-valuenow="25" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                    <div class="progress-bar bg-success" role="progressbar"
                                                        style="width: 25%" aria-valuenow="25" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                </div>
                                            </li>
                                            <li class="mt-4">
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <h6 class="mb-0 fw-bold">Team Evaluation Based on Attendence <span
                                                                class="fw-light"></span></h6>
                                                    </div>
                                                    <div class="ms-auto">
                                                        <h6 class="mb-0 fw-bold">100%</h6>
                                                    </div>
                                                </div>
                                                <div class="progress mt-2">
                                                    <div class="progress-bar bg-danger" role="progressbar"
                                                        style="width: 25%" aria-valuenow="25" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                    <div class="progress-bar bg-cyan" role="progressbar"
                                                        style="width: 25%" aria-valuenow="25" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                    <div class="progress-bar bg-info" role="progressbar"
                                                        style="width: 25%" aria-valuenow="25" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                    <div class="progress-bar bg-success" role="progressbar"
                                                        style="width: 25%" aria-valuenow="25" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="table-responsive">
                                                <table id="file_export_main_info_part_1"
                                                    class="table table-striped table-bordered display">
                                                    <thead>
                                                        {{-- id --}}
                                                        <tr>
                                                            <th style="background-color:aliceblue">REF :</th>
                                                            <td>
                                                                <strong>
                                                                    {{ isset($department->id) ? $department->id : '----' }}
                                                                </strong>
                                                            </td>
                                                        </tr>

                                                        {{-- status --}}
                                                        <tr>
                                                            <th style="background-color:aliceblue">Status :</th>
                                                            <td>
                                                                <strong>
                                                                    @if (isset($department->status) && $department->status == 'Active')
                                                                        <span
                                                                            style="color: green;"><strong>{{ isset($department->status) ? $department->status : '----' }}</strong></span>
                                                                    @else
                                                                        <span style="color: red">
                                                                            <strong>
                                                                                {{ isset($department->status) ? $department->status : '----' }}
                                                                            </strong>
                                                                        </span>
                                                                    @endif
                                                                </strong>
                                                            </td>
                                                        </tr>

                                                        {{-- Type --}}
                                                        <tr>
                                                            <th style="background-color:aliceblue"> Type:</th>
                                                            <td>
                                                                <strong>{{ isset($department->departmentsType) ? $department->departmentsType->title_en : '----' }}</strong>
                                                            </td>
                                                        </tr>

                                                        {{-- created_at --}}
                                                        <tr>
                                                            <th style="background-color:aliceblue"> Added Since:</th>
                                                            <td>
                                                                <strong>{!! isset($department->created_at) ? $department->created_at->diffForHumans() : '-------' !!}</strong>
                                                            </td>
                                                        </tr>

                                                        {{-- created_at --}}
                                                        <tr>
                                                            <th style="background-color:aliceblue"> Addition Time:</th>
                                                            <td>
                                                                <strong>{!! isset($department->created_at) ? date('h:i A', strtotime($department->created_at)) : '-------' !!}</strong>
                                                            </td>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="col-md-7">
                                            <div class="table-responsive">
                                                <table id="file_export_status_team"
                                                    class="table table-striped table-bordered display">
                                                    <thead>

                                                        {{-- name --}}
                                                        <tr>
                                                            <th style="background-color:aliceblue">Name:
                                                            </th>
                                                            <td>
                                                                <strong>
                                                                    {{ isset($department->name) ? $department->name : '-------' }}
                                                                </strong>
                                                            </td>
                                                        </tr>

                                                        {{-- created_by --}}
                                                        <tr>
                                                            <th style="background-color:aliceblue">Created By:</th>
                                                            <td>
                                                                <strong>
                                                                    <a
                                                                        href="{{ route('super_admin.employees-show', isset($department->created_by) ? $department->created_by : -1) }}">
                                                                        {{ isset($department->createdBy->name) ? $department->createdBy->name : '-------' }}
                                                                    </a>
                                                                </strong>
                                                            </td>
                                                        </tr>

                                                        {{-- code --}}
                                                        <tr>
                                                            <th style="background-color:aliceblue">Code:</th>
                                                            <td>
                                                                <strong>
                                                                    {{ isset($department->code) ? $department->code : '-------' }}
                                                                </strong>
                                                            </td>
                                                        </tr>

                                                        {{-- created_at --}}
                                                        <tr>
                                                            <th style="background-color:aliceblue">Addition Date:</th>
                                                            <td>
                                                                <strong>
                                                                    {!! isset($department->created_at) ? date('Y / F (m) / d', strtotime($department->created_at)) : '-------' !!}
                                                                </strong>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <th style="background-color: aliceblue">No. Of Employees:</th>
                                                            <td>
                                                                <strong>
                                                                    {!! isset($department->users) ? $department->users->count() : '-------' !!}
                                                                </strong>
                                                            </td>
                                                        </tr>

                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Tab Two --}}
                        <div class="tab-pane fade show fade" id="tab_body_2" role="tabpanel"
                            aria-labelledby="tab_body_2">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="file_export" class="table table-striped table-bordered display">
                                        <thead>
                                            <tr>
                                                <th>#REF</th>
                                                <th>Project</th>
                                                <th>Customer</th>
                                                <th>Status</th>
                                                <th>Controls</th>
                                            </tr>
                                        </thead>
                                        @if ($department->department_type_id == 1)
                                            <tbody>
                                                @if (isset($department->webDepartmentProjects) && count($department->webDepartmentProjects) > 0)
                                                    @foreach ($department->webDepartmentProjects as $project)
                                                        <tr>
                                                            <td>
                                                                <a
                                                                    href="{{ route('super_admin.projects-show', isset($project->id) ? $project->id : '-1') }}">
                                                                    {{ isset($project->id) ? $project->id : '----' }}
                                                                </a>
                                                            </td>

                                                            <td>
                                                                <a
                                                                    href="{{ route('super_admin.projects-show', isset($project->id) ? $project->id : '-1') }}">
                                                                    <strong>
                                                                        {{ isset($project->name_en) ? $project->name_en : '----' }}
                                                                    </strong>
                                                                </a>
                                                            </td>

                                                            <td>
                                                                <a
                                                                    href="{{ route('super_admin.customers-show', isset($project->customer->id) ? $project->customer->id : '-1') }}">
                                                                    <strong>
                                                                        {{ isset($project->customer->name_en) ? $project->customer->name_en : '----' }}
                                                                    </strong>
                                                                </a>
                                                            </td>

                                                            <td>
                                                                <strong>
                                                                    @if (isset($project->status) && $project->status == 'Completed')
                                                                        <span
                                                                            style="color: green;">{{ $project->status }}</span>
                                                                    @elseif(isset($project->status) && $project->status == 'Hold')
                                                                        <span
                                                                            style="color: red;">{{ $project->status }}</span>
                                                                    @elseif(isset($project->status) && $project->status == 'In Queue')
                                                                        <span
                                                                            style="color: orange;">{{ $project->status }}</span>
                                                                    @else
                                                                        {{ isset($project->status) ? $project->status : '----' }}
                                                                    @endif
                                                                </strong>
                                                            </td>

                                                            <td>
                                                                <a href="{{ route('super_admin.projects-show', isset($project->id) ? $project->id : -1) }}"
                                                                    class="btn waves-effect waves-light btn-primary btn-sm"
                                                                    title="View Details"><i class="fas fa-eye"></i></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        @elseif ($department->department_type_id == 2)
                                            <tbody>
                                                @if (isset($department->mobileDepartmentProjects) && count($department->mobileDepartmentProjects) > 0)
                                                    @foreach ($department->mobileDepartmentProjects as $project)
                                                        <tr>
                                                            <td>
                                                                <a
                                                                    href="{{ route('super_admin.projects-show', isset($project->id) ? $project->id : '-1') }}">
                                                                    {{ isset($project->id) ? $project->id : '----' }}
                                                                </a>
                                                            </td>

                                                            <td>
                                                                <a
                                                                    href="{{ route('super_admin.projects-show', isset($project->id) ? $project->id : '-1') }}">
                                                                    <strong>
                                                                        {{ isset($project->name_en) ? $project->name_en : '----' }}
                                                                    </strong>
                                                                </a>
                                                            </td>

                                                            <td>
                                                                <a
                                                                    href="{{ route('super_admin.customers-show', isset($project->customer->id) ? $project->customer->id : '-1') }}">
                                                                    <strong>
                                                                        {{ isset($project->customer->name_en) ? $project->customer->name_en : '----' }}
                                                                    </strong>
                                                                </a>
                                                            </td>

                                                            <td>
                                                                <strong>
                                                                    @if (isset($project->status) && $project->status == 'Completed')
                                                                        <span
                                                                            style="color: green;">{{ $project->status }}</span>
                                                                    @elseif(isset($project->status) && $project->status == 'Hold')
                                                                        <span
                                                                            style="color: red;">{{ $project->status }}</span>
                                                                    @elseif(isset($project->status) && $project->status == 'In Queue')
                                                                        <span
                                                                            style="color: orange;">{{ $project->status }}</span>
                                                                    @else
                                                                        {{ isset($project->status) ? $project->status : '----' }}
                                                                    @endif
                                                                </strong>
                                                            </td>

                                                            <td>
                                                                <a href="{{ route('super_admin.projects-show', isset($project->id) ? $project->id : -1) }}"
                                                                    class="btn waves-effect waves-light btn-primary btn-sm"
                                                                    title="View Details"><i class="fas fa-eye"></i></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        @elseif ($department->department_type_id == 3)
                                            <tbody>
                                                @if (isset($department->designDepartmentProjects) && count($department->designDepartmentProjects) > 0)
                                                    @foreach ($department->designDepartmentProjects as $project)
                                                        <tr>
                                                            <td>
                                                                <a
                                                                    href="{{ route('super_admin.projects-show', isset($project->id) ? $project->id : '-1') }}">
                                                                    {{ isset($project->id) ? $project->id : '----' }}
                                                                </a>
                                                            </td>

                                                            <td>
                                                                <a
                                                                    href="{{ route('super_admin.projects-show', isset($project->id) ? $project->id : '-1') }}">
                                                                    <strong>
                                                                        {{ isset($project->name_en) ? $project->name_en : '----' }}
                                                                    </strong>
                                                                </a>
                                                            </td>

                                                            <td>
                                                                <a
                                                                    href="{{ route('super_admin.customers-show', isset($project->customer->id) ? $project->customer->id : '-1') }}">
                                                                    <strong>
                                                                        {{ isset($project->customer->name_en) ? $project->customer->name_en : '----' }}
                                                                    </strong>
                                                                </a>
                                                            </td>

                                                            <td>
                                                                <strong>
                                                                    @if (isset($project->status) && $project->status == 'Completed')
                                                                        <span
                                                                            style="color: green;">{{ $project->status }}</span>
                                                                    @elseif(isset($project->status) && $project->status == 'Hold')
                                                                        <span
                                                                            style="color: red;">{{ $project->status }}</span>
                                                                    @elseif(isset($project->status) && $project->status == 'In Queue')
                                                                        <span
                                                                            style="color: orange;">{{ $project->status }}</span>
                                                                    @else
                                                                        {{ isset($project->status) ? $project->status : '----' }}
                                                                    @endif
                                                                </strong>
                                                            </td>

                                                            <td>
                                                                <a href="{{ route('super_admin.projects-show', isset($project->id) ? $project->id : -1) }}"
                                                                    class="btn waves-effect waves-light btn-primary btn-sm"
                                                                    title="View Details"><i class="fas fa-eye"></i></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        @elseif ($department->department_type_id == 4)
                                            <tbody>
                                                @if (isset($projects) && count($projects) > 0)
                                                    @foreach ($projects as $project)
                                                        <tr>
                                                            <td>
                                                                <a
                                                                    href="{{ route('super_admin.projects-show', isset($project->id) ? $project->id : '-1') }}">
                                                                    {{ isset($project->id) ? $project->id : '----' }}
                                                                </a>
                                                            </td>

                                                            <td>
                                                                <a
                                                                    href="{{ route('super_admin.projects-show', isset($project->id) ? $project->id : '-1') }}">
                                                                    <strong>
                                                                        {{ isset($project->name_en) ? $project->name_en : '----' }}
                                                                    </strong>
                                                                </a>
                                                            </td>

                                                            <td>
                                                                <a
                                                                    href="{{ route('super_admin.customers-show', isset($project->customer->id) ? $project->customer->id : '-1') }}">
                                                                    <strong>
                                                                        {{ isset($project->customer->name_en) ? $project->customer->name_en : '----' }}
                                                                    </strong>
                                                                </a>
                                                            </td>

                                                            <td>
                                                                <strong>
                                                                    @if (isset($project->status) && $project->status == 'Completed')
                                                                        <span
                                                                            style="color: green;">{{ $project->status }}</span>
                                                                    @elseif(isset($project->status) && $project->status == 'Hold')
                                                                        <span
                                                                            style="color: red;">{{ $project->status }}</span>
                                                                    @elseif(isset($project->status) && $project->status == 'In Queue')
                                                                        <span
                                                                            style="color: orange;">{{ $project->status }}</span>
                                                                    @else
                                                                        {{ isset($project->status) ? $project->status : '----' }}
                                                                    @endif
                                                                </strong>
                                                            </td>

                                                            <td>
                                                                <a href="{{ route('super_admin.projects-show', isset($project->id) ? $project->id : -1) }}"
                                                                    class="btn waves-effect waves-light btn-primary btn-sm"
                                                                    title="View Details"><i class="fas fa-eye"></i></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- Tab Two --}}
                        <div class="tab-pane fade show fade" id="tab_body_3" role="tabpanel"
                            aria-labelledby="tab_body_3">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="file_export_2" class="table table-striped table-bordered display">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Type</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (isset($department->users) && count($department->users) > 0)
                                                @foreach ($department->users as $user)
                                                    <tr>
                                                        <td>
                                                            <a
                                                                href="{{ route('super_admin.employees-show', isset($user->id) ? $user->id : '-1') }}">
                                                                <strong>{{ isset($user->name) ? $user->name : '----' }}
                                                                </strong>
                                                            </a>
                                                        </td>
                                                        <td>{{ isset($user->email) ? $user->email : '----' }}</td>
                                                        <td>{{ isset($user->phone) ? $user->phone : '----' }}</td>
                                                        <td>{{ isset($user->type) ? $user->type : '----' }}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra_js')
    {{-- projects table --}}
    <script>
        $(document).ready(function() {
            if ($.fn.DataTable.isDataTable('#file_export')) {
                $('#file_export').DataTable().destroy();
            }

            $('#file_export').DataTable({
                paging: true,
                pageLength: 50, // Set the number of records per page
                order: [
                    [0, 'desc'] // Sorting by
                ],
                columnDefs: [{
                        type: 'date',
                        // targets: [2]
                    },
                    {
                        orderable: false,
                        targets: [4]
                    }
                ],
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'copy',
                        exportOptions: {
                            columns: [0, 1, 2, 3] // Specify the columns you want to export
                        }
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [0, 1, 2, 3] // Specify the columns you want to export
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3] // Specify the columns you want to export
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0, 1, 2, 3] // Specify the columns you want to export
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [0, 1, 2, 3] // Specify the columns you want to export
                        }
                    }
                ]
            });

            // Add styling to the DataTable buttons
            $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass(
                'btn btn-primary mr-1');
        });
    </script>

    {{-- employee table --}}
    <script>
        $(document).ready(function() {
            if ($.fn.DataTable.isDataTable('#file_export_2')) {
                $('#file_export_2').DataTable().destroy();
            }

            $('#file_export_2').DataTable({
                paging: true,
                pageLength: 50, // Set the number of records per page
                order: [
                    [0, 'desc'] // Sorting by
                ],
                columnDefs: [{
                        type: 'date',
                        // targets: [2]
                    },
                    {
                        orderable: false,
                        // targets: [4]
                    }
                ],
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'copy',
                        exportOptions: {
                            columns: [0, 1, 2, 3] // Specify the columns you want to export
                        }
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [0, 1, 2, 3] // Specify the columns you want to export
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3] // Specify the columns you want to export
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0, 1, 2, 3] // Specify the columns you want to export
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [0, 1, 2, 3] // Specify the columns you want to export
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
