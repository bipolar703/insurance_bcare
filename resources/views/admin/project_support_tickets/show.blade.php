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
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.departments-index') }}">All Departments</a></li>
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
            {{-- Left Section --}}
            {{-- <div class="col-lg-3 col-xlg-3 col-md-5">
                <div class="card">
                    <div class="card-body">
                        <center class="mt-4">
                            <img src="{{ asset('style_files/shared/images_default/blueray_logo.jpg') }}"
                                class="rounded-circle" width="150" />
                            <h4 class="card-title mt-2">
                                {{ isset($department->name) ? $department->name : '-------' }}</h4>
                            <small class="text-muted pt-4 db">Status</small>
                            <h6>
                                @if (isset($department->status) && $department->status == 'Active')
                                    <a href="{{ route('super_admin.departments-activeInactiveSingle', isset($department->id) ? $department->id : -1) }}"
                                        class="process btn waves-effect waves-light btn-light-danger btn-sm"
                                        title="Set Inactive"><i class="mdi mdi-pause"></i></a>
                                    <span style="color: green;">{{ $department->status }}</span>
                                @elseif(isset($department->status) && $department->status == 'Inactive')
                                    <a href="{{ route('super_admin.departments-activeInactiveSingle', isset($department->id) ? $department->id : -1) }}"
                                        class="process btn waves-effect waves-light btn-light-success btn-sm"
                                        title="Set Active"><i class="mdi mdi-play"></i></a>
                                    <span style="color: red;">{{ $department->status }}</span>
                                @else
                                    -------
                                @endif
                            </h6>
                            <small class="text-muted pt-4 db">Type</small>
                            <h6>
                                {{ $department->type }}
                            </h6>

                            <small class="text-muted pt-4 db">Added Since</small>
                            <h6>{!! isset($department->created_at) ? $department->created_at->diffForHumans() : '-------' !!}</h6>

                            <small class="text-muted pt-4 db">Addition Time</small>
                            <h6>{!! isset($department->created_at) ? date('h:i A', strtotime($department->created_at)) : '-------' !!}</h6>

                            <small class="text-muted pt-4 db">Addition Date</small>
                            <h6>{!! isset($department->created_at) ? date('Y / F (m) / d', strtotime($department->created_at)) : '-------' !!}</h6>
                    </div>
                </div>
            </div> --}}

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
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row mb-3">
                                                <div class="col-md-4"><strong>Name:</strong></div>
                                                <div class="col-md-8">
                                                    <p><strong>{{ isset($department->name) ? $department->name : '-------' }}</strong>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4"><strong>Code:</strong></div>
                                                <div class="col-md-8">
                                                    <p><strong>{{ isset($department->code) ? $department->code : '-------' }}</strong>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4"><strong>Status:</strong></div>
                                                <div class="col-md-8">
                                                    <p>
                                                        @if (isset($department->status) && $department->status == 'Active')
                                                            <span
                                                                style="color: green;"><strong>{{ $department->status }}</strong>
                                                            </span>
                                                        @elseif(isset($department->status) && $department->status == 'Inactive')
                                                            <span
                                                                style="color: red;"><strong>{{ $department->status }}</strong>
                                                            </span>
                                                        @else
                                                            {{ isset($department->status) ? $department->status : '-------' }}
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4"><strong>Created By:</strong></div>
                                                <div class="col-md-8">
                                                    <p>{{ isset($department->created_by) ? $department->created_by : '-------' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="row mb-3">
                                                <div class="col-md-4"><strong>Type:</strong></div>
                                                <div class="col-md-8">
                                                    <p>{{ isset($department->type) ? $department->type : '-------' }}</p>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4"><strong>Added Since:</strong></div>
                                                <div class="col-md-8">
                                                    <p>{!! isset($department->created_at) ? $department->created_at->diffForHumans() : '-------' !!}</p>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4"><strong>Addition Time:</strong></div>
                                                <div class="col-md-8">
                                                    <p>{!! isset($department->created_at) ? date('h:i A', strtotime($department->created_at)) : '-------' !!}</p>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4"><strong>Addition Date:</strong></div>
                                                <div class="col-md-8">
                                                    <p>{!! isset($department->created_at) ? date('Y / F (m) / d', strtotime($department->created_at)) : '-------' !!}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="row mb-3">
                                                <div class="col-md-4"><strong>ID:</strong></div>
                                                <div class="col-md-8">
                                                    <p>{{ isset($department->id) ? $department->id : '-------' }}</p>
                                                </div>
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
                                        @if ($department->type === 'Web')
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
                                        @elseif ($department->type === 'Mobile')
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
                                        @elseif ($department->type === 'Design')
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
                                        @elseif ($department->type === 'Sales')
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
                                    <table id="file_export" class="table table-striped table-bordered display">
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
                                                                {{ isset($user->name) ? $user->name : '----' }}
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
    @endsection

    @section('extra_js')
        {{-- <script>
            $(document).ready(function() {
                $("#otherImagesInput").change(function() {
                    readURLs(this, '#otherImagesPreview');
                });
            });

            function readURLs(input, previewId) {
                if (input.files && input.files.length > 0) {
                    $(previewId).empty(); // Clear previous previews

                    for (var i = 0; i < input.files.length; i++) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            $(previewId).append(
                                '<img src="' + e.target.result +
                                '" class="img-thumbnail image-preview" style="border: double 3px black; margin-bottom: 5px; margin-top: 5px;">'
                            );
                        }
                        reader.readAsDataURL(input.files[i]);
                    }
                }
            }
        </script> --}}

        {{-- <script>
            $(document).ready(function() {
                $("#otherImagesInput").change(function() {
                    readURLs(this, '#otherImagesPreview');
                });
            });

            function readURLs(input, previewId) {
                if (input.files && input.files.length > 0) {
                    $(previewId).empty(); // Clear previous previews

                    for (var i = 0; i < input.files.length; i++) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            $(previewId).append(
                                '<img src="' + e.target.result +
                                '" class="img-thumbnail image-preview" style="border: double 3px black; margin: 5px; width: 150px; height: 150px;">'
                            );
                        }
                        reader.readAsDataURL(input.files[i]);
                    }
                }
            }
        </script> --}}
    @endsection
