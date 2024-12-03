@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">{{ isset($employee->name) ? $employee->name : '-------' }} Info</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.employees-index') }}">Employees</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Employee Details</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Create --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.employees-create') }}" class="btn btn-dark">
                            <i data-feather="plus" class="fill-white feather-sm"></i> Add New Employee
                        </a>
                    </div>
                    {{-- Edit --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.employees-edit', isset($employee->id) ? $employee->id : -1) }}"
                            class="btn btn-secondary">
                            <i data-feather="edit" class="fill-white feather-sm"></i> Edit Employee
                        </a>
                    </div>
                    {{-- Delete --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.employees-softDelete', isset($employee->id) ? $employee->id : -1) }}"
                            class="confirm btn btn-danger">
                            <i data-feather="trash" class="fill-white feather-sm"></i> Delete Employee
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
                            @if (isset($employee->image) && $employee->image && file_exists($employee->image))
                                <img src="{{ asset($employee->image) }}" class="rounded-circle" width="200"
                                    height="150" />
                            @else
                                <img src="{{ asset('style_files/shared/images_default/blueray_logo.jpg') }}"
                                    class="rounded-circle" width="150" />
                            @endif

                            {{-- NAME --}}
                            <h4 class="card-title mt-2"> {{ isset($employee->name) ? $employee->name : '-------' }}</h4>

                            {{-- department --}}
                            <small class="text-muted pt-4 db">Department</small>
                            <h4 class="card-title mt-2">
                                <a
                                    href="{{ route('super_admin.departments-show', isset($employee->department->id) ? $employee->department->id : '-1') }}">
                                    {{ isset($employee->department->name) ? $employee->department->name : '-------' }}
                                </a>

                            </h4>


                            {{-- Status --}}
                            <small class="text-muted pt-4 db">Status</small>
                            <h6>
                                @if (isset($employee->status) && $employee->status == 'Active')
                                    <span style="color: green;"><strong>{{ $employee->status }}</strong></span>
                                @elseif(isset($employee->status) && $employee->status == 'Inactive')
                                    <span style="color: red;"><strong>{{ $employee->status }}</strong></span>
                                @else
                                    {{ isset($employee->status) ? $employee->status : '-------' }}
                                @endif
                            </h6>

                            {{-- Added Since --}}
                            <small class="text-muted pt-4 db">Added Since</small>
                            <h6>{!! isset($employee->created_at) ? $employee->created_at->diffForHumans() : '-------' !!}</h6>

                            {{-- Addition Time --}}
                            <small class="text-muted pt-4 db">Addition Time</small>
                            <h6>{!! isset($employee->created_at) ? date('h:i A', strtotime($employee->created_at)) : '-------' !!}</h6>

                            {{-- Addition Date --}}
                            <small class="text-muted pt-4 db">Addition Date</small>
                            <h6>{!! isset($employee->created_at) ? date('Y / F (m) / d', strtotime($employee->created_at)) : '-------' !!}</h6>
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

                        {{-- Tab 2 : Projects --}}
                        <li class="nav-item">
                            <a class="nav-link fade" id="tab_header_2" data-bs-toggle="pill" href="#tab_body_2"
                                role="tab" aria-controls="pills-profile" aria-selected="false"><strong>Projects
                                </strong></a>
                        </li>
                    </ul>

                    <div class="tab-content" id="pills-tabContent">
                        {{-- Tab One --}}
                        <div class="tab-pane fade show active" id="tab_body_1" role="tabpanel" aria-labelledby="tab_body_1">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="table-responsive">
                                            <table id="file_export_main_info_part_1"
                                                class="table table-striped table-bordered display">
                                                <thead>
                                                    {{-- id --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">REF :</th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($employee->id) ? $employee->id : '----' }}
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    {{-- status --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Status :</th>
                                                        <td>
                                                            <strong>
                                                                @if (isset($employee->status) && $employee->status == 'Active')
                                                                    <span
                                                                        style="color: green;"><strong>{{ isset($employee->status) ? $employee->status : '----' }}</strong></span>
                                                                @else
                                                                    <span style="color: red">
                                                                        <strong>
                                                                            {{ isset($employee->status) ? $employee->status : '----' }}
                                                                        </strong>
                                                                    </span>
                                                                @endif
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    {{--  phone --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Phone :
                                                        </th>
                                                        <td> <strong>
                                                                {{ isset($employee->phone) && isset($employee->country_phone_id) ? '(+' . $employee->countryPhoneKey->phone_code . ') ' . $employee->phone : '----' }}
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    {{-- Type --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue"> Type:</th>
                                                        <td>
                                                            <strong>{{ isset($employee->employeeType) ? $employee->employeeType->title_en : '----' }}</strong>
                                                        </td>
                                                    </tr>

                                                    {{-- date_of_birth --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue"> Date Of Birth:</th>
                                                        <td>
                                                            <strong>{{ isset($employee->date_of_birth) ? $employee->date_of_birth : '----' }}
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    {{-- marital_status --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue"> Marital Status:</th>
                                                        <td>
                                                            <strong>{{ isset($employee->marital_status) ? $employee->marital_status : '----' }}
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    {{-- date_of_hiring --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue"> Date Of Hiring:</th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($employee->date_of_hiring) ? $employee->date_of_hiring : '-------' }}
                                                            </strong>
                                                        </td>
                                                    </tr>


                                                    {{-- department --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue"> Department:</th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($employee->department->name) ? $employee->department->name : '-------' }}
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    {{-- work_email --}}
                                                    @if (isset($employee->work_email))
                                                        <tr>
                                                            <th style="background-color:aliceblue"> Work Email:</th>
                                                            <td>
                                                                <strong>
                                                                    {{ isset($employee->work_email) ? $employee->work_email : '-------' }}
                                                                </strong>
                                                            </td>
                                                        </tr>
                                                    @endif



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
                                                        <th style="background-color:aliceblue">Name:
                                                        </th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($employee->name) ? $employee->name : '-------' }}
                                                            </strong>
                                                        </td>
                                                    </tr>


                                                    <tr>
                                                        <th style="background-color:aliceblue">Email:</th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($employee->email) ? $employee->email : '-------' }}
                                                            </strong>
                                                        </td>
                                                    </tr>


                                                    <tr>
                                                        <th style="background-color: aliceblue">Nationality:</th>
                                                        <td>
                                                            <strong>
                                                                @if (isset($employee->nationality))
                                                                    @foreach ($countries as $country)
                                                                        @if ($country->id == $employee->nationality)
                                                                            {{ $country->name_en }}
                                                                            ({{ $country->name_ar }})
                                                                        @endif
                                                                    @endforeach
                                                                @else
                                                                    -------
                                                                @endif
                                                            </strong>
                                                        </td>
                                                    </tr>


                                                    <tr>
                                                        <th style="background-color:aliceblue">Salary:</th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($employee->salary) ? $employee->salary : '-------' }}
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th style="background-color: aliceblue">Country:</th>
                                                        <td>
                                                            <strong>
                                                                @if (isset($employee->country_id))
                                                                    @foreach ($countries as $country)
                                                                        @if ($country->id == $employee->country_id)
                                                                            {{ $country->name_en }}
                                                                            ({{ $country->name_ar }})
                                                                        @endif
                                                                    @endforeach
                                                                @else
                                                                    -------
                                                                @endif
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th style="background-color: aliceblue">City:</th>
                                                        <td>
                                                            <strong>
                                                                @if (isset($employee->city_id))
                                                                    @foreach ($states as $state)
                                                                        @if ($state->id == $employee->city_id)
                                                                            {{ $state->name_en }} ({{ $state->name_ar }})
                                                                        @endif
                                                                    @endforeach
                                                                @else
                                                                    -------
                                                                @endif
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th style="background-color:aliceblue">Gender :</th>
                                                        <td>
                                                            <strong> {!! isset($employee->gender) ? $employee->gender : '-------' !!} </strong>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th style="background-color:aliceblue">Address :</th>
                                                        <td>
                                                            <strong> {!! isset($employee->address) ? $employee->address : '-------' !!} </strong>
                                                        </td>
                                                    </tr>

                                                    @if (isset($employee->date_termination))
                                                        <tr>
                                                            <th style="background-color:aliceblue">Date Of Termination:
                                                            </th>
                                                            <td>
                                                                <strong>
                                                                    {{ isset($employee->date_termination) ? $employee->date_termination : '-------' }}
                                                                </strong>
                                                            </td>
                                                        </tr>
                                                    @endif

                                                    {{-- work_phone --}}
                                                    @if (isset($employee->work_phone))
                                                        <tr>
                                                            <th style="background-color:aliceblue"> Work Phone:</th>
                                                            <td>
                                                                <strong>
                                                                    {{ isset($employee->work_phone) && isset($employee->work_country_phone_id) ? '(+' . $employee->workCountryPhoneKey->phone_code . ') ' . $employee->work_phone : '----' }}
                                                                </strong>
                                                            </td>
                                                        </tr>
                                                    @endif

                                                </thead>
                                            </table>
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
                                            @elseif($employee)
                                                @foreach ($projectSalesman as $projectSale)
                                                    <tr>
                                                        <td>
                                                            <a
                                                                href="{{ route('super_admin.projects-show', isset($projectSale->id) ? $projectSale->id : '-1') }}">
                                                                {{ isset($projectSale->id) ? $projectSale->id : '----' }}
                                                            </a>
                                                        </td>

                                                        <td>
                                                            <a
                                                                href="{{ route('super_admin.projects-show', isset($projectSale->id) ? $projectSale->id : '-1') }}">
                                                                {{ isset($projectSale->name_en) ? $projectSale->name_en : '----' }}
                                                            </a>
                                                        </td>

                                                        <td>
                                                            <a
                                                                href="{{ route('super_admin.customers-show', isset($projectSale->customer->id) ? $projectSale->customer->id : '-1') }}">
                                                                {{ isset($projectSale->customer->name_en) ? $projectSale->customer->name_en : '----' }}
                                                            </a>
                                                        </td>

                                                        <td>
                                                            @if (isset($projectSale->status) && $projectSale->status == 'Completed')
                                                                <span
                                                                    style="color: green;">{{ $projectSale->status }}</span>
                                                            @elseif(isset($projectSale->status) && $projectSale->status == 'Hold')
                                                                <span
                                                                    style="color: red;">{{ $projectSale->status }}</span>
                                                            @elseif(isset($projectSale->status) && $projectSale->status == 'In Queue')
                                                                <span
                                                                    style="color: orange;">{{ $projectSale->status }}</span>
                                                            @else
                                                                {{ isset($projectSale->status) ? $projectSale->status : '----' }}
                                                            @endif
                                                        </td>

                                                        <td>
                                                            <a href="{{ route('super_admin.projects-show', isset($projectSale->id) ? $projectSale->id : -1) }}"
                                                                class="btn waves-effect waves-light btn-primary btn-sm"
                                                                title="View Details"><i class="fas fa-eye"></i></a>
                                                        </td>
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

@endsection
