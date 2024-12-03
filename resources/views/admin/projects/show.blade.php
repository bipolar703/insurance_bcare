@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">

            <div class="col-md-12">
                <h2 class="page-title">
                    {{ isset($project->name_en) ? $project->name_en : null }}
                </h2>
            </div>


            <div class="col-md-5 align-self-center">
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.projects-index') }}">All Projects</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Project Details</li>
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
                    {{-- Edit --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.projects-edit', isset($project->id) ? $project->id : -1) }}"
                            class="btn btn-secondary">
                            <i data-feather="edit" class="fill-white feather-sm"></i> Edit Project
                        </a>
                    </div>
                    {{-- Delete --}}
                    @if ($project->projectInvoices->count() == 0)
                        <div class="dropdown me-2">
                            <a href="{{ route('super_admin.projects-softDelete', isset($project->id) ? $project->id : -1) }}"
                                class="confirm btn btn-danger">
                                <i data-feather="trash" class="fill-white feather-sm"></i> Delete Project
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
            <div class="col-md-12">
                <div class="card">
                    {{-- Tabs Header Section --}}
                    <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">

                        {{-- Tab 1 : Main Info --}}
                        <li class="nav-item">
                            <a class="nav-link @if ($errors->isEmpty()) active @endif" id="tab_header_1"
                                data-bs-toggle="pill" href="#tab_body_1" role="tab" aria-controls="pills-profile"
                                aria-selected="false"><strong>Main
                                    Info</strong></a>
                        </li>

                        {{-- Tab 2 : Development Info --}}
                        <li class="nav-item">
                            <a class="nav-link fade @if (old('project_project_coordinator_name') ||
                                    old('gather_analyze_requirements_supervisor_id') ||
                                    old('design_department_id') ||
                                    old('web_department_id') ||
                                    old('mobile_department_id') ||
                                    old('quality_assurance_supervisor_id')) active @endif" id="tab_header_2"
                                data-bs-toggle="pill" href="#tab_body_2" role="tab" aria-controls="pills-profile"
                                aria-selected="false"><strong>Development Info
                                </strong></a>
                        </li>

                        {{-- Tab 6 : Subscription Info --}}
                        <li class="nav-item">
                            <a class="nav-link fade" id="tab_header_6" data-bs-toggle="pill" href="#tab_body_6"
                                role="tab" aria-controls="pills-profile" aria-selected="false"><strong>Subscriptions
                                </strong>
                            </a>
                        </li>

                        {{-- Tab 5 : Payments Info --}}
                        <li class="nav-item">
                            <a class="nav-link fade" id="tab_header_5" data-bs-toggle="pill" href="#tab_body_5"
                                role="tab" aria-controls="pills-profile" aria-selected="false"><strong>Payments Info
                                </strong>
                            </a>
                        </li>

                        {{-- Tab 3 : Finance Info --}}
                        <li class="nav-item">
                            <a class="nav-link fade" id="tab_header_3" data-bs-toggle="pill" href="#tab_body_3"
                                role="tab" aria-controls="pills-profile" aria-selected="false"><strong>Finance
                                    Info</strong></a>
                        </li>

                        {{-- Tab 4 : Attachments --}}
                        <li class="nav-item">
                            <a class="nav-link fade @if (
                                $errors->has('project_attachments_files') ||
                                    $errors->has('project_attachments_title') ||
                                    $errors->has('project_attachments_files.*')) active @endif" id="tab_header_4"
                                data-bs-toggle="pill" href="#tab_body_4" role="tab" aria-controls="pills-profile"
                                aria-selected="false"><strong>Attachments
                                </strong></a>
                        </li>


                        {{-- Tab 7 : Sales Tickets --}}
                        <li class="nav-item">
                            <a class="nav-link fade 
                            @if (old('sales_ticket_title') || old('sales_ticket_description') || old('sales_ticket_date')) active @endif
                                 "
                                id="tab_header_7" data-bs-toggle="pill" href="#tab_body_7" role="tab"
                                aria-controls="pills-profile" aria-selected="false"><strong>Sales Tickets
                                </strong></a>
                        </li>

                        {{-- Tab 8 : Support Tickets --}}
                        <li class="nav-item">
                            <a class="nav-link fade @if (old('support_ticket_title') || old('support_ticket_description') || old('support_ticket_date')) active @endif" id="tab_header_8"
                                data-bs-toggle="pill" href="#tab_body_8" role="tab" aria-controls="pills-profile"
                                aria-selected="false">
                                <strong>Support Tickets</strong>
                            </a>
                        </li>

                        {{-- Tab 9: Tasks --}}
                        <li class="nav-item">
                            <a class="nav-link fade" id="tab_header_9" data-bs-toggle="pill" href="#tab_body_9"
                                role="tab" aria-controls="pills-profile" aria-selected="false">
                                <strong>Tasks</strong>
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content" id="pills-tabContent">
                        {{-- ============================================================= --}}
                        {{-- ====================== Tab 1 main info ====================== --}}
                        {{-- ============================================================= --}}
                        <div class="tab-pane fade @if ($errors->isEmpty()) show active @endif " id="tab_body_1"
                            role="tabpanel" aria-labelledby="tab_body_1">
                            <div class="card-body">
                                <div class="row">
                                    {{-- Statistics --}}
                                    <div class="col-md-12 mb-4 groove-container">
                                        <div class="card-header" style="background-color: aliceblue;">
                                            <ul class="list-style-none mt-3 mb-2">
                                                <li>
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            <h6 class="mb-0 fw-bold">The percentage of completion Main Info
                                                                Section <span class="fw-light"></span></h6>
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
                                                                {{ isset($project->id) ? $project->id : '----' }}
                                                            </strong>
                                                        </td>
                                                    </tr>
                                                    {{-- status --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Project Status :</th>
                                                        <td>
                                                            <strong>
                                                                @if (isset($project->status) && $project->status == 'Completed')
                                                                    <span
                                                                        style="color: green;"><strong>{{ isset($project->status) ? $project->status : '----' }}</strong></span>
                                                                @elseif(isset($project->status) && $project->status == 'In Queue')
                                                                    <span
                                                                        style="color:ORANGE;"><strong>{{ isset($project->status) ? $project->status : '----' }}</strong></span>
                                                                @else
                                                                    <span style="color: blue">
                                                                        <strong>
                                                                            {{ isset($project->status) ? $project->status : '----' }}
                                                                        </strong>
                                                                    </span>
                                                                @endif
                                                            </strong>
                                                        </td>
                                                    </tr>
                                                    {{--  customer_project_coordinator_phone --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Customer Coordinator Phone :
                                                        </th>
                                                        <td>
                                                            <strong>{{ isset($project->customer_project_coordinator_phone) && isset($project->country_phone_id) ? '(+' . $project->countryPhoneKey->phone_code . ') ' . $project->customer_project_coordinator_phone : (isset($project->customer_project_coordinator_phone) ? $project->customer_project_coordinator_phone : '---------') }}</strong>
                                                        </td>
                                                    </tr>

                                                    {{-- Type --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue"> Type:</th>
                                                        <td>
                                                            <strong>{{ isset($project->type) ? $project->type : '----' }}
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    {{-- Signing Date --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue"> Signing Date:</th>
                                                        <td>
                                                            <strong>{{ isset($project->signing_date) ? $project->signing_date : '----' }}
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    {{-- Launch Date --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue"> Launch Date:</th>
                                                        <td>
                                                            <strong>{{ isset($project->launch_date) ? $project->launch_date : '----' }}
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    {{-- Salesman --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue"> Salesman:</th>
                                                        <td>
                                                            <a
                                                                href="{{ route('super_admin.employees-show', isset($project->salesman->id) ? $project->salesman->id : '-1') }}">
                                                                <strong>
                                                                    {{ isset($project->salesman->name) ? $project->salesman->name : '-------' }}
                                                                </strong>
                                                            </a>
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

                                                    <tr>
                                                        <th style="background-color:aliceblue">Customer EN:
                                                        </th>
                                                        <td>
                                                            <a
                                                                href="{{ route('super_admin.customers-show', isset($project->customer->id) ? $project->customer->id : '-1') }}">
                                                                <strong>
                                                                    {{ isset($project->customer->name_en) ? $project->customer->name_en : '-------' }}
                                                                </strong>
                                                            </a>
                                                        </td>
                                                    </tr>


                                                    <tr>
                                                        <th style="background-color:aliceblue">Customer AR:</th>
                                                        <td>
                                                            <a
                                                                href="{{ route('super_admin.customers-show', isset($project->customer->id) ? $project->customer->id : '-1') }}">
                                                                <strong>
                                                                    {{ isset($project->customer->name_ar) ? $project->customer->name_ar : '-------' }}
                                                                </strong>
                                                            </a>
                                                        </td>
                                                    </tr>


                                                    <tr>
                                                        <th style="background-color:aliceblue">Customer Coordinator Name:
                                                        </th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($project->customer_project_coordinator_name) ? $project->customer_project_coordinator_name : '-------' }}
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th style="background-color:aliceblue">Addition Time :</th>
                                                        <td>
                                                            <strong> {!! isset($project->created_at) ? date('h:i A', strtotime($project->created_at)) : '-------' !!} </strong>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th style="background-color:aliceblue">Addition Time :</th>
                                                        <td>
                                                            <strong> {!! isset($project->created_at) ? date('Y / F (m) / d', strtotime($project->created_at)) : '-------' !!} </strong>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th style="background-color:aliceblue">Added Since :</th>
                                                        <td>
                                                            <strong> {!! isset($project->created_at) ? $project->created_at->diffForHumans() : '-------' !!} </strong>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th style="background-color:aliceblue">Created By :</th>
                                                        <td>
                                                            <strong> {!! isset($project->created_by) ? $project->created_by : '-------' !!} </strong>
                                                        </td>
                                                    </tr>

                                                </thead>
                                            </table>
                                        </div>
                                    </div>

                                    @if (isset($project->description))
                                        <div class="col-md-12 bordered">
                                            <div class="card border-primary mb-3">
                                                <div class="card-header" style="background-color: aliceblue;">
                                                    <strong>Description</strong>
                                                </div>
                                                <div class="card-body">
                                                    <p class="card-text text-muted">{{ $project->description }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        {{-- ============================================================= --}}
                        {{-- ====================== Tab 2 DEV info ======================= --}}
                        {{-- ============================================================= --}}
                        <div class="tab-pane fade @if (old('project_project_coordinator_name') ||
                                old('gather_analyze_requirements_supervisor_id') ||
                                old('design_department_id') ||
                                old('web_department_id') ||
                                old('mobile_department_id') ||
                                old('quality_assurance_supervisor_id')) active show fade @endif
                             "
                            id="tab_body_2" role="tabpanel" aria-labelledby="tab_body_2">
                            {{-- Statistics --}}
                            <div class="col-md-12 mb-4 mt-4 groove-container">
                                <div class="card-header" style="background-color: aliceblue;">
                                    <ul class="list-style-none mt-3 mb-2">
                                        <li class="mt-4">
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <h6 class="mb-0 fw-bold">The percentage of completion Development Info
                                                        Section <span class="fw-light"></span></h6>
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
                                                <div class="progress-bar bg-success" role="progressbar"
                                                    style="width: 25%" aria-valuenow="25" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            @if (isset($project->projectCoordinatorName) ||
                                    isset($project->projectGatherAnalyze) ||
                                    isset($project->design_status) ||
                                    isset($project->web_status) ||
                                    isset($project->mobile_status) ||
                                    isset($project->status) ||
                                    isset($project->type) ||
                                    isset($project->qualityAssurancePerson))
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="table-responsive">
                                                <table id="file_export_support_team"
                                                    class="table table-striped table-bordered display">
                                                    <thead>

                                                        <tr>
                                                            <th style="background-color:aliceblue">Project Type :</th>
                                                            <td> <strong>
                                                                    {{ isset($project->type) ? $project->type : '----' }}
                                                                </strong></td>
                                                        </tr>

                                                        <tr>
                                                            <th style="background-color:aliceblue">Project Status :</th>
                                                            <td>
                                                                @if (isset($project->status) && $project->status == 'In Queue')
                                                                    <span
                                                                        style="color: orange;"><strong>{{ $project->status }}</strong></span>
                                                                @elseif(isset($project->status) && $project->status == 'In Progress')
                                                                    <span
                                                                        style="color: blue;"><strong>{{ $project->status }}</strong></span>
                                                                @elseif(isset($project->status) && $project->status == 'Completed (Active)')
                                                                    <span
                                                                        style="color: green;"><strong>{{ $project->status }}</strong></span>
                                                                @elseif(isset($project->status) && $project->status == 'Completed (Closed)')
                                                                    <span
                                                                        style="color: green;"><strong>{{ $project->status }}</strong></span>
                                                                @elseif(isset($project->status) && $project->status == 'Closed')
                                                                    <span
                                                                        style="color: red;"><strong>{{ $project->status }}</strong></span>
                                                                @else
                                                                    {{ isset($project->status) ? $project->status : '----' }}
                                                                @endif
                                                            </td>
                                                        </tr>

                                                        @if (isset($project->coordinator->name))
                                                            <tr>
                                                                <th style="background-color:aliceblue">Project Coordinator
                                                                    :
                                                                </th>
                                                                <td> <strong>
                                                                        {{ isset($project->coordinator->name) ? $project->coordinator->name : '----' }}
                                                                    </strong>
                                                                </td>
                                                            </tr>
                                                        @endif

                                                        @if (isset($project->projectGatherAnalyze->name))
                                                            <tr>
                                                                <th style="background-color:aliceblue"> BA Phase :</th>
                                                                <td><strong>{{ isset($project->projectGatherAnalyze->name) ? $project->projectGatherAnalyze->name : '----' }}</strong>
                                                                    <strong>
                                                                        ( @if (isset($project->gather_analyze_requirements_status) && $project->gather_analyze_requirements_status == 'In Queue')
                                                                            <span
                                                                                style="color: orange;"><strong>{{ isset($project->gather_analyze_requirements_status) ? $project->gather_analyze_requirements_status : '----' }}</strong></span>
                                                                        @elseif(isset($project->gather_analyze_requirements_status) &&
                                                                                $project->gather_analyze_requirements_status == 'In Progress')
                                                                            <span
                                                                                style="color:blue;"><strong>{{ isset($project->gather_analyze_requirements_status) ? $project->gather_analyze_requirements_status : '----' }}</strong></span>
                                                                        @elseif(isset($project->gather_analyze_requirements_status) && $project->gather_analyze_requirements_status == 'Completed')
                                                                            <span
                                                                                style="color:green;"><strong>{{ isset($project->gather_analyze_requirements_status) ? $project->gather_analyze_requirements_status : '----' }}</strong></span>
                                                                        @endif)
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
                                                        @if (isset($project->design_status))
                                                            <tr>
                                                                <th style="background-color:aliceblue">Design Phase Status:
                                                                </th>
                                                                <td>
                                                                    @if (isset($project->design_status) && $project->design_status == 'In Queue')
                                                                        <span
                                                                            style="color: orange;"><strong>{{ isset($project->design_status) ? $project->design_status : '----' }}</strong></span>
                                                                    @elseif(isset($project->design_status) && $project->design_status == 'In Progress')
                                                                        <span
                                                                            style="color:blue;"><strong>{{ isset($project->design_status) ? $project->design_status : '----' }}</strong></span>
                                                                    @elseif(isset($project->design_status) && $project->design_status == 'Completed')
                                                                        <span
                                                                            style="color:green;"><strong>{{ isset($project->design_status) ? $project->design_status : '----' }}</strong></span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endif

                                                        @if (isset($project->web_status))
                                                            <tr>
                                                                <th style="background-color:aliceblue">Web Phase Status :
                                                                </th>
                                                                <td>
                                                                    @if (isset($project->web_status) && $project->web_status == 'In Queue')
                                                                        <span
                                                                            style="color: orange;"><strong>{{ isset($project->web_status) ? $project->web_status : '----' }}</strong></span>
                                                                    @elseif(isset($project->web_status) && $project->web_status == 'In Progress')
                                                                        <span
                                                                            style="color:blue;"><strong>{{ isset($project->web_status) ? $project->web_status : '----' }}</strong></span>
                                                                    @elseif(isset($project->web_status) && $project->web_status == 'Completed')
                                                                        <span
                                                                            style="color:green;"><strong>{{ isset($project->web_status) ? $project->web_status : '----' }}</strong></span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endif

                                                        @if (isset($project->mobile_status))
                                                            <tr>
                                                                <th style="background-color:aliceblue">Mobile Phase Status:
                                                                </th>
                                                                <td>
                                                                    @if (isset($project->mobile_status) && $project->mobile_status == 'In Queue')
                                                                        <span
                                                                            style="color: orange;"><strong>{{ isset($project->mobile_status) ? $project->mobile_status : '----' }}</strong></span>
                                                                    @elseif(isset($project->mobile_status) && $project->mobile_status == 'In Progress')
                                                                        <span
                                                                            style="color:blue;"><strong>{{ isset($project->mobile_status) ? $project->mobile_status : '----' }}</strong></span>
                                                                    @elseif(isset($project->mobile_status) && $project->mobile_status == 'Completed')
                                                                        <span
                                                                            style="color:green;"><strong>{{ isset($project->mobile_status) ? $project->mobile_status : '----' }}</strong></span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endif

                                                        @if (isset($project->quality_assurance_status))
                                                            <tr>
                                                                <th style="background-color:aliceblue">QA Phase :</th>
                                                                <td>
                                                                    <strong>
                                                                        {{ isset($project->qualityAssurancePerson->name) ? $project->qualityAssurancePerson->name : '----' }}
                                                                        ( @if (isset($project->quality_assurance_status) && $project->quality_assurance_status == 'In Queue')
                                                                            <span
                                                                                style="color: orange;"><strong>{{ isset($project->quality_assurance_status) ? $project->quality_assurance_status : '----' }}</strong></span>
                                                                        @elseif(isset($project->quality_assurance_status) && $project->quality_assurance_status == 'In Progress')
                                                                            <span
                                                                                style="color:blue;"><strong>{{ isset($project->quality_assurance_status) ? $project->quality_assurance_status : '----' }}</strong></span>
                                                                        @elseif(isset($project->quality_assurance_status) && $project->quality_assurance_status == 'Completed')
                                                                            <span
                                                                                style="color:green;"><strong>{{ isset($project->quality_assurance_status) ? $project->quality_assurance_status : '----' }}</strong></span>
                                                                        @endif)
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
                            @endif

                            <br>

                            @if (isset($project->supervisorDesigner))
                                <div class="card-body groove-container">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <label>
                                                <h2>Design Phase Employees :</h2>
                                            </label>
                                        </div>
                                        <div class="col-md-2">
                                            <form method="POST"
                                                action="{{ route('super_admin.projects-addEmployeesThatWorkingOnProject', ['id' => $project->supervisorDesigner->department->id]) }}">
                                                @csrf
                                                <input type="hidden" name="department_id"
                                                    value="{{ $project->supervisorDesigner->department->id }}">
                                                <input type="hidden" name="project_id" value="{{ $project->id }}">
                                                <button type="submit" class="btn btn-primary">Add New Designer</button>
                                            </form>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="table-responsive">
                                        <table id="file_export_design_team"
                                            class="table table-striped table-bordered display">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Position</th>
                                                    <th>Department</th>
                                                    <th>Control</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (isset($project->projectWorkingEmployees))
                                                    @foreach ($project->projectWorkingEmployees as $projectWorkingEmployee)
                                                        @if ($projectWorkingEmployee->user->department->department_type_id == 3)
                                                            <tr>
                                                                <td>
                                                                    <a
                                                                        href="{{ route('super_admin.employees-show', ['id' => isset($projectWorkingEmployee->user->id) ? $projectWorkingEmployee->user->id : null]) }}">
                                                                        <strong>
                                                                            {{ $projectWorkingEmployee->user->name ?? '------' }}
                                                                        </strong>
                                                                    </a>
                                                                </td>

                                                                <td>
                                                                    <strong>
                                                                        {{ $projectWorkingEmployee->employee_type ?? '------' }}
                                                                    </strong>
                                                                </td>

                                                                <td>
                                                                    <strong>
                                                                        <a
                                                                            href="{{ route('super_admin.departments-show', ['id' => $projectWorkingEmployee->user->department->id ?? '------']) }}">
                                                                            {{ $projectWorkingEmployee->user->department->name ?? '------' }}
                                                                        </a>

                                                                    </strong>
                                                                </td>

                                                                <td>
                                                                    <a href="{{ route('super_admin.projects-destroyEmployeeWorkingOnProject', isset($projectWorkingEmployee->id) ? $projectWorkingEmployee->id : -1) }}"
                                                                        class="confirm btn waves-effect waves-light btn-danger btn-sm"
                                                                        title="Delete"><i class="fas fa-trash-alt"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif

                            <br>

                            @if (isset($project->supervisorWebDeveloper))
                                <div class="card-body groove-container">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <label>
                                                <h2>Web Phase Employees :</h2>
                                            </label>
                                        </div>
                                        <div class="col-md-2">
                                            <form method="POST"
                                                action="{{ route('super_admin.projects-addEmployeesThatWorkingOnProject', ['id' => $project->supervisorWebDeveloper->department->id]) }}">
                                                @csrf
                                                <input type="hidden" name="department_id"
                                                    value="{{ $project->supervisorWebDeveloper->department->id }}">
                                                <input type="hidden" name="project_id" value="{{ $project->id }}">
                                                <button type="submit" class="btn btn-primary">Add New Web Dev</button>
                                            </form>
                                        </div>
                                    </div>

                                    <br>

                                    <div class="table-responsive">
                                        <table id="file_export_web_team"
                                            class="table table-striped table-bordered display">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Position</th>
                                                    <th>Language</th>
                                                    <th>Department</th>
                                                    <th>Control</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (isset($project->projectWorkingEmployees))
                                                    @foreach ($project->projectWorkingEmployees as $projectWorkingEmployee)
                                                        @if ($projectWorkingEmployee->user->department->department_type_id == 1)
                                                            <tr>
                                                                <td>
                                                                    <a
                                                                        href="{{ route('super_admin.employees-show', ['id' => isset($projectWorkingEmployee->user->id) ? $projectWorkingEmployee->user->id : null]) }}">
                                                                        <strong>
                                                                            {{ $projectWorkingEmployee->user->name ?? '------' }}
                                                                        </strong>
                                                                    </a>
                                                                </td>

                                                                <td>
                                                                    <strong>
                                                                        {{ $projectWorkingEmployee->employee_type ?? '------' }}
                                                                    </strong>
                                                                </td>

                                                                <td>
                                                                    <strong>
                                                                        {{ isset($projectWorkingEmployee->project->programming_language_used_web) ? $projectWorkingEmployee->project->programming_language_used_web : '----' }}
                                                                    </strong>
                                                                </td>

                                                                <td>
                                                                    <strong>
                                                                        <a
                                                                            href="{{ route('super_admin.departments-show', ['id' => $projectWorkingEmployee->user->department->id ?? '------']) }}">
                                                                            {{ $projectWorkingEmployee->user->department->name ?? '------' }}
                                                                        </a>
                                                                    </strong>
                                                                </td>

                                                                <td>
                                                                    <a href="{{ route('super_admin.projects-destroyEmployeeWorkingOnProject', isset($projectWorkingEmployee->id) ? $projectWorkingEmployee->id : -1) }}"
                                                                        class="confirm btn waves-effect waves-light btn-danger btn-sm"
                                                                        title="Delete"><i class="fas fa-trash-alt"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif

                            <br>

                            @if (isset($project->supervisorMobileDeveloper))
                                <div class="card-body groove-container">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <label>
                                                <h2>Mobile Phase Employees :</h2>
                                            </label>
                                        </div>
                                        <div class="col-md-2">
                                            <form method="POST"
                                                action="{{ route('super_admin.projects-addEmployeesThatWorkingOnProject', ['id' => $project->supervisorMobileDeveloper->department->id]) }}">
                                                @csrf
                                                <input type="hidden" name="department_id"
                                                    value="{{ $project->supervisorMobileDeveloper->department->id }}">
                                                <input type="hidden" name="project_id" value="{{ $project->id }}">
                                                <button type="submit" class="btn btn-primary">Add New Mobile Dev</button>
                                            </form>
                                        </div>
                                    </div>

                                    <br>

                                    <div class="table-responsive">
                                        <table id="file_export_mobile_team"
                                            class="table table-striped table-bordered display">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Position</th>
                                                    <th>Language</th>
                                                    <th>Department</th>
                                                    <th>Control</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (isset($project->projectWorkingEmployees))
                                                    @foreach ($project->projectWorkingEmployees as $projectWorkingEmployee)
                                                        @if ($projectWorkingEmployee->user->department->department_type_id == 2)
                                                            <tr>
                                                                <td>
                                                                    <a
                                                                        href="{{ route('super_admin.employees-show', ['id' => isset($projectWorkingEmployee->user->id) ? $projectWorkingEmployee->user->id : null]) }}">
                                                                        <strong>
                                                                            {{ $projectWorkingEmployee->user->name ?? '------' }}
                                                                        </strong>
                                                                    </a>
                                                                </td>

                                                                <td>
                                                                    <strong>
                                                                        {{ $projectWorkingEmployee->employee_type ?? '------' }}
                                                                    </strong>
                                                                </td>

                                                                <td>
                                                                    <strong>
                                                                        {{ $projectWorkingEmployee->project->programming_language_used_mobile ?? '------' }}
                                                                    </strong>
                                                                </td>

                                                                <td>
                                                                    <strong>
                                                                        <a
                                                                            href="{{ route('super_admin.departments-show', ['id' => $projectWorkingEmployee->user->department->id ?? '------']) }}">
                                                                            {{ $projectWorkingEmployee->user->department->name ?? '------' }}
                                                                        </a>
                                                                    </strong>
                                                                </td>

                                                                <td>
                                                                    <a href="{{ route('super_admin.projects-destroyEmployeeWorkingOnProject', isset($projectWorkingEmployee->id) ? $projectWorkingEmployee->id : -1) }}"
                                                                        class="confirm btn waves-effect waves-light btn-danger btn-sm"
                                                                        title="Delete"><i class="fas fa-trash-alt"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif

                            <br>

                            <div class="card-body groove-container">
                                <label>
                                    <h2>Update Development Info: </h2>
                                </label>
                                <form action="{{ route('super_admin.projects-addEmployeesToProject', $project->id) }}"
                                    method="POST" enctype="multipart/form-data" id="createForm">
                                    @csrf
                                    <input type="hidden" name="project_id" value="{{ $project->id }}">

                                    <div class="row">
                                        {{-- project_project_coordinator_name --}}
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <div class="form-floating mb-3">
                                                    <select name="project_project_coordinator_name"
                                                        class="form-control form-select border border-info @error('project_project_coordinator_name') border-danger @enderror custom_select_style">
                                                        <option value="">Select Project Coordinator Supervisor
                                                        </option>
                                                        @if (isset($projectCoordinators) && $projectCoordinators->count() > 0)
                                                            @foreach ($projectCoordinators as $projectCoordinator)
                                                                <option value="{{ $projectCoordinator->id }}"
                                                                    @if ($projectCoordinator->id == $project->project_project_coordinator_name) selected @endif>
                                                                    {{ $projectCoordinator->name ?? '------' }}
                                                                </option>
                                                            @endforeach
                                                        @else
                                                            <option value="">
                                                                No Project Coordinator Is Shown Please Check With Admin
                                                            </option>
                                                        @endif
                                                    </select>
                                                    <label for="tb-name">
                                                        <i data-feather="type"
                                                            class="feather-sm text-info fill-white me-2"></i>
                                                        Project Coordinator Name
                                                    </label>
                                                    <strong class="text-danger">
                                                        @error('project_project_coordinator_name')
                                                            ( {{ $message }} )
                                                        @enderror
                                                    </strong>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- gather_analyze_requirements_supervisor_id --}}
                                        <div class="col-md-3">
                                            <div class="form-floating mb-3">
                                                <select name="gather_analyze_requirements_supervisor_id"
                                                    onchange="handleMainSelectChange('gather_analyze_requirements_supervisor_id', ['gather_analyze_requirements_status_field'])"
                                                    id="gather_analyze_requirements_supervisor_id"
                                                    class="form-control form-select border border-info @error('gather_analyze_requirements_supervisor_id') border-danger @enderror custom_select_style">
                                                    <option value="">Select BA Name</option>
                                                    @if (isset($projectCoordinators) && $projectCoordinators->count() > 0)
                                                        @foreach ($projectCoordinators as $projectCoordinator)
                                                            <option value="{{ $projectCoordinator->id }}"
                                                                @if (
                                                                    $projectCoordinator->id == $project->gather_analyze_requirements_supervisor_id ||
                                                                        $projectCoordinator->id == old('gather_analyze_requirements_supervisor_id')) selected @endif>
                                                                {{ $projectCoordinator->name ?? '------' }}
                                                            </option>
                                                        @endforeach
                                                    @else
                                                        <option value="">
                                                            No BA Name Is Shown Please Check With Admin
                                                        </option>
                                                    @endif
                                                </select>
                                                <label for="tb-name">
                                                    <i data-feather="type" class="feather-sm text-info fill-white me-2">
                                                    </i>
                                                    BA Name

                                                </label>
                                                <strong class="text-danger">
                                                    @error('gather_analyze_requirements_supervisor_id')
                                                        ( {{ $message }} )
                                                    @enderror
                                                </strong>
                                            </div>
                                        </div>

                                        {{-- gather_analyze_requirements_status --}}
                                        <div class="col-md-3" id="gather_analyze_requirements_status_field"
                                            style="display: {{ isset($project->gather_analyze_requirements_supervisor_id) || old('gather_analyze_requirements_supervisor_id') ? 'block' : 'none' }}">
                                            <div class="mb-3">
                                                <div class="form-floating mb-3">
                                                    <select name="gather_analyze_requirements_status"
                                                        onchange="handleRelatedSelectChange('gather_analyze_requirements_status_field')"
                                                        class="form-control form-select border border-info @error('gather_analyze_requirements_status') border-danger @enderror custom_select_style">
                                                        <option value="">--- Select BA Status ---</option>
                                                        <option value="1"
                                                            @if (old('gather_analyze_requirements_status') == 1 || $project->gather_analyze_requirements_status == 'In Queue') selected @endif>In Queue
                                                        </option>
                                                        <option value="2"
                                                            @if (old('gather_analyze_requirements_status') == 2 || $project->gather_analyze_requirements_status == 'In Progress') selected @endif>
                                                            In Progress
                                                        </option>
                                                        <option value="3"
                                                            @if (old('gather_analyze_requirements_status') == 3 || $project->gather_analyze_requirements_status == 'Completed') selected @endif>
                                                            Completed
                                                        </option>
                                                    </select>
                                                    <label for="tb-name">
                                                        <i data-feather="type"
                                                            class="feather-sm text-info fill-white me-2"> </i>
                                                        BA Status

                                                    </label>
                                                    <strong class="text-danger">
                                                        @error('gather_analyze_requirements_status')
                                                            ( {{ $message }} )
                                                        @enderror
                                                    </strong>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- design_department_id --}}
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <div class="form-floating mb-3">
                                                    <select name="design_department_id" id="design_department_id"
                                                        onchange="getCustomerProjects(); handleMainSelectChange('design_department_id', ['design_supervisor_field', 'design_status_field'])"
                                                        class="form-control form-select border border-info @error('design_department_id') border-danger @enderror custom_select_style">
                                                        @if (isset($designDepartments) && $designDepartments->count() > 0)
                                                            <option value="">Select Design Team</option>
                                                            @foreach ($designDepartments as $designDepartment)
                                                                @if ($designDepartment->users->count() > 0)
                                                                    <option value="{{ $designDepartment->id }}"
                                                                        {{ old('design_department_id') == $designDepartment->id || $project->design_department_id == $designDepartment->id ? 'selected' : '' }}>
                                                                        {{ isset($designDepartment->name) ? $designDepartment->name : '------' }}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            <option value="">Department not found</option>
                                                        @endif
                                                    </select>
                                                    <label for="department">
                                                        <i data-feather="type"
                                                            class="feather-sm text-info fill-white me-2"></i>
                                                        Design Department

                                                    </label>
                                                    <strong class="text-danger">
                                                        @error('design_department_id')
                                                            ( {{ $message }} )
                                                        @enderror
                                                    </strong>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- designer_id --}}
                                        <div class="col-md-3" id="design_supervisor_field"
                                            style="display: {{ isset($project->design_department_id) || old('design_department_id') ? 'block' : 'none' }}">
                                            <div class="mb-3">
                                                <div class="form-floating mb-3">
                                                    <input type="hidden" id="oldDesignSupervisorId"
                                                        value="{!! old('design_supervisor_id') ? old('design_supervisor_id') : null !!}">
                                                    <select name="design_supervisor_id"
                                                        onchange="handleRelatedSelectChange('design_supervisor_field')"
                                                        class="form-control form-select border border-info custom_select_style"
                                                        id="user">
                                                        <!-- Options will be populated dynamically using JavaScript -->
                                                    </select>
                                                    <label for="department">
                                                        <i data-feather="type"
                                                            class="feather-sm text-info fill-white me-2"></i>
                                                        Design Supervisor

                                                    </label>
                                                    <strong class="text-danger">
                                                        @error('design_supervisor_id')
                                                            ( {{ $message }} )
                                                        @enderror
                                                    </strong>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- design_status --}}
                                        <div class="col-md-3" id="design_status_field"
                                            style="display: {{ isset($project->design_department_id) || old('design_department_id') ? 'block' : 'none' }}">
                                            <div class="form-floating mb-3">
                                                <select name="design_status"
                                                    onchange="handleRelatedSelectChange('design_status_field')"
                                                    class="form-control form-select border border-info @error('design_status') border-danger @enderror custom_select_style">
                                                    <option value="">--- Choose Design Status ---</option>
                                                    <option value="1"
                                                        @if (old('design_status') == 1 || $project->design_status == 'In Queue') selected @endif>In Queue
                                                    </option>
                                                    <option value="2"
                                                        @if (old('design_status') == 2 || $project->design_status == 'In Progress') selected @endif>In Progress
                                                    </option>
                                                    <option
                                                        value="3"@if (old('design_status') == 3 || $project->design_status == 'Completed') selected @endif>
                                                        Completed</option>
                                                </select>
                                                <label for="tb-name">
                                                    <i data-feather="type"
                                                        class="feather-sm text-info fill-white me-2"></i>
                                                    Design Status

                                                </label>
                                                <strong class="text-danger">
                                                    @error('design_status')
                                                        ( {{ $message }} )
                                                    @enderror
                                                </strong>
                                            </div>
                                        </div>

                                        {{-- web_department_id --}}
                                        <div class="col-md-3">
                                            <div class="form-floating mb-3">
                                                <select name="web_department_id" id="web_department_id"
                                                    onchange="getWebSupervisor(); handleMainSelectChange('web_department_id', ['web_supervisor_id_filed', 'web_status_filed', 'programming_language_used_web_filed'])"
                                                    class="form-control form-select border border-info @error('web_department') border-danger @enderror custom_select_style">
                                                    @if (isset($webDepartments) && $webDepartments->count() > 0)
                                                        <option value="">Select Web Team</option>
                                                        @foreach ($webDepartments as $webDepartment)
                                                            @if ($webDepartment->users->count() > 0)
                                                                <option value="{{ $webDepartment->id }}"
                                                                    {{ old('web_department_id') == $webDepartment->id || $project->web_department_id == $webDepartment->id ? 'selected' : '' }}>
                                                                    {{ isset($webDepartment->name) ? $webDepartment->name : '------' }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <option value="">Department not found</option>
                                                    @endif
                                                </select>
                                                <label for="department">
                                                    <i data-feather="type"
                                                        class="feather-sm text-info fill-white me-2"></i>
                                                    Web Department

                                                </label>
                                                <strong class="text-danger">
                                                    @error('web_department_id')
                                                        ( {{ $message }} )
                                                    @enderror
                                                </strong>
                                            </div>
                                        </div>

                                        {{-- web_supervisor_id --}}
                                        <div class="col-md-3" id="web_supervisor_id_filed"
                                            style="display: {{ isset($project->web_department_id) || old('web_department_id') ? 'block' : 'none' }}">
                                            <div class="form-floating mb-3">
                                                <input type="hidden" name="oldWebSupervisor"
                                                    value="{!! old('web_supervisor_id') ? old('web_supervisor_id') : null !!}">
                                                <select name="web_supervisor_id"
                                                    onchange="handleRelatedSelectChange('web_supervisor_id_filed')"
                                                    class="form-control form-select border border-info custom_select_style"
                                                    id="webSupervisor">
                                                </select>
                                                <label for="webSupervisor">
                                                    <i data-feather="type"
                                                        class="feather-sm text-info fill-white me-2"></i>
                                                    Web Supervisor
                                                </label>
                                                <strong class="text-danger">
                                                    @error('web_supervisor_id')
                                                        ( {{ $message }} )
                                                    @enderror
                                                </strong>
                                            </div>
                                        </div>

                                        {{-- web_status --}}
                                        <div class="col-md-3" id="web_status_filed"
                                            style="display: {{ isset($project->web_department_id) || old('web_department_id') ? 'block' : 'none' }}">
                                            <div class="mb-3">
                                                <div class="form-floating mb-3">
                                                    <select name="web_status" id="web_status"
                                                        onchange="handleRelatedSelectChange('web_status_filed')"
                                                        class="form-control form-select border border-info @error('web_status') border-danger @enderror custom_select_style">
                                                        <option value="">--- Choose Web Status ---</option>
                                                        <option value="1"
                                                            @if (old('web_status') == 1 || $project->web_status == 'In Queue') selected @endif>In Queue
                                                        </option>
                                                        <option value="2"
                                                            @if (old('web_status') == 2 || $project->web_status == 'In Progress') selected @endif>
                                                            In Progress
                                                        </option>
                                                        <option value="3"
                                                            @if (old('web_status') == 3 || $project->web_status == 'Completed') selected @endif>
                                                            Completed
                                                        </option>
                                                    </select>
                                                    <label for="tb-name">
                                                        <i data-feather="type"
                                                            class="feather-sm text-info fill-white me-2"></i>
                                                        Web Status

                                                    </label>
                                                    <strong class="text-danger">
                                                        @error('web_status')
                                                            ( {{ $message }} )
                                                        @enderror
                                                    </strong>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- programming_language_used_web --}}
                                        <div class="col-md-3" id="programming_language_used_web_filed"
                                            style="display: {{ isset($project->web_department_id) || old('web_department_id') ? 'block' : 'none' }}">
                                            <div class="mb-3">
                                                <div class="form-floating mb-3">
                                                    <select name="programming_language_used_web"
                                                        onchange="handleRelatedSelectChange('programming_language_used_web_filed')"
                                                        class="form-control form-select border border-info @error('programming_language_used_web') border-danger @enderror custom_select_style">
                                                        <option value="">--- Choose Programming Language Web ---
                                                        </option>
                                                        <option value="1"
                                                            @if (old('programming_language_used_web') == 1 || $project->programming_language_used_web == 'Laravel') selected @endif>Laravel
                                                        </option>
                                                        <option value="2"
                                                            @if (old('programming_language_used_web') == 2 || $project->programming_language_used_web == 'Drupal') selected @endif>
                                                            Drupal
                                                        </option>
                                                        <option value="3"
                                                            @if (old('programming_language_used_web') == 3 || $project->programming_language_used_web == 'WordPress') selected @endif>
                                                            WordPress
                                                        </option>
                                                    </select>
                                                    <label for="tb-name">
                                                        <i data-feather="type"
                                                            class="feather-sm text-info fill-white me-2"></i>
                                                        Language Used For Web
                                                    </label>
                                                    <strong class="text-danger">
                                                        @error('programming_language_used_web')
                                                            ( {{ $message }} )
                                                        @enderror
                                                    </strong>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- mobileDepartments --}}
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <div class="form-floating mb-3">
                                                    <select name="mobile_department_id" id="mobileDepartments"
                                                        onchange="getMobileSupervisor(); handleMainSelectChange('mobileDepartments', ['mobile_supervisor_id_filed', 'mobile_status_filed', 'programming_language_used_mobile'])"
                                                        class="form-control form-select border border-info @error('web_department') border-danger @enderror custom_select_style">
                                                        @if (isset($mobileDepartments) && $mobileDepartments->count() > 0)
                                                            <option value="">Select Mobile Team</option>
                                                            @foreach ($mobileDepartments as $mobileDepartment)
                                                                @if ($mobileDepartment->users->count() > 0)
                                                                    <option value="{{ $mobileDepartment->id }}"
                                                                        {{ old('mobile_department_id') == $mobileDepartment->id || $project->mobile_department_id == $mobileDepartment->id ? 'selected' : '' }}>
                                                                        {{ isset($mobileDepartment->name) ? $mobileDepartment->name : '------' }}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            <option value="">Department not found</option>
                                                        @endif
                                                    </select>
                                                    <label for="department">
                                                        <i data-feather="type"
                                                            class="feather-sm text-info fill-white me-2"></i>
                                                        Mobile Department

                                                    </label>
                                                    <strong class="text-danger">
                                                        @error('mobile_department_id')
                                                            ( {{ $message }} )
                                                        @enderror
                                                    </strong>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- mobile_supervisor_id --}}
                                        <div class="col-md-3" id="mobile_supervisor_id_filed"
                                            style="display: {{ isset($project->mobile_department_id) || old('mobile_department_id') ? 'block' : 'none' }}">
                                            <div class="mb-3">
                                                <div class="form-floating mb-3">
                                                    <input type="hidden" id="oldMobileSupervisorid"
                                                        value="{!! old('mobile_supervisor_id') ? old('mobile_supervisor_id') : null !!}">
                                                    <select name="mobile_supervisor_id"
                                                        onchange="handleRelatedSelectChange('mobile_supervisor_id_filed')"
                                                        class="form-control form-select border border-info custom_select_style"
                                                        id="mobile_supervisor">
                                                    </select>
                                                    <label for="webSupervisor">
                                                        <i data-feather="type"
                                                            class="feather-sm text-info fill-white me-2"></i>
                                                        Mobile Supervisor

                                                    </label>
                                                    <strong class="text-danger">
                                                        @error('mobile_supervisor_id')
                                                            ( {{ $message }} )
                                                        @enderror
                                                    </strong>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- mobile_status --}}
                                        <div class="col-md-3" id="mobile_status_filed"
                                            style="display: {{ isset($project->mobile_department_id) || old('mobile_department_id') ? 'block' : 'none' }}">
                                            <div class="mb-3">
                                                <div class="form-floating mb-3">
                                                    <select name="mobile_status" id="mobile_status"
                                                        onchange="handleRelatedSelectChange('mobile_status_filed')"
                                                        class="form-control form-select border border-info @error('mobile_status') border-danger @enderror custom_select_style">
                                                        <option value="">--- Choose Mobile Status ---</option>
                                                        <option value="1"
                                                            @if (old('mobile_status') == 1 || $project->mobile_status == 'In Queue') selected @endif>In Queue
                                                        </option>
                                                        <option value="2"
                                                            @if (old('mobile_status') == 2 || $project->mobile_status == 'In Progress') selected @endif>
                                                            In Progress
                                                        </option>
                                                        <option value="3"
                                                            @if (old('mobile_status') == 3 || $project->mobile_status == 'Completed') selected @endif>
                                                            Completed
                                                        </option>
                                                    </select>
                                                    <label for="tb-name">
                                                        <i data-feather="type"
                                                            class="feather-sm text-info fill-white me-2"></i>
                                                        Mobile Status

                                                    </label>
                                                    <strong class="text-danger">
                                                        @error('mobile_status')
                                                            ( {{ $message }} )
                                                        @enderror
                                                    </strong>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- programming_language_used_mobile --}}
                                        <div class="col-md-3" id="programming_language_used_mobile"
                                            style="display: {{ isset($project->mobile_department_id) || old('mobile_department_id') ? 'block' : 'none' }}">
                                            <div class="form-floating mb-3">
                                                <select name="programming_language_used_mobile"
                                                    onchange="handleRelatedSelectChange('programming_language_used_mobile')"
                                                    class="form-control form-select border border-info @error('programming_language_used_mobile') border-danger @enderror custom_select_style">
                                                    <option value="">--- Choose Programming Language Web ---
                                                    </option>
                                                    <option value="1"
                                                        @if (old('programming_language_used_mobile') == 1 || $project->programming_language_used_mobile == 'IOS') selected @endif>IOS
                                                    </option>
                                                    <option value="2"
                                                        @if (old('programming_language_used_mobile') == 2 || $project->programming_language_used_mobile == 'Android') selected @endif>
                                                        Android
                                                    </option>
                                                    <option value="3"
                                                        @if (old('programming_language_used_mobile') == 3 || $project->programming_language_used_mobile == 'Flutter') selected @endif>
                                                        Flutter
                                                    </option>

                                                    <option value="4"
                                                        @if (old('programming_language_used_mobile') == 4 || $project->programming_language_used_mobile == 'Andoid + IOS') selected @endif>
                                                        Andoid + IOS
                                                    </option>
                                                </select>
                                                <label for="tb-name">
                                                    <i data-feather="type"
                                                        class="feather-sm text-info fill-white me-2"></i>
                                                    Language Used For Mobile

                                                </label>
                                                <strong class="text-danger">
                                                    @error('programming_language_used_mobile')
                                                        ( {{ $message }} )
                                                    @enderror
                                                </strong>
                                            </div>
                                        </div>


                                        {{-- qa --}}
                                        <div class="col-md-3">
                                            <div class="form-floating mb-3">
                                                <select name="quality_assurance_supervisor_id"
                                                    onchange="handleMainSelectChange('quality_assurance_supervisor_id', ['quality_assurance_status_filed'])"
                                                    id="quality_assurance_supervisor_id"
                                                    class="form-control form-select border border-info @error('quality_assurance_supervisor_id') border-danger @enderror custom_select_style">
                                                    <option value="">Select QA Supervisor</option>
                                                    @if (isset($projectCoordinators) && $projectCoordinators->count() > 0)
                                                        @foreach ($projectCoordinators as $projectCoordinator)
                                                            <option value="{{ $projectCoordinator->id }}"
                                                                @if (old('quality_assurance_supervisor_id') == $projectCoordinator->id ||
                                                                        $projectCoordinator->id == $project->quality_assurance_supervisor_id) selected @endif>
                                                                {{ $projectCoordinator->name ?? '------' }}
                                                            </option>
                                                        @endforeach
                                                    @else
                                                        <option value="">
                                                            No Project Coordinator Is Shown Please Check With Admin
                                                        </option>
                                                    @endif
                                                </select>
                                                <label for="tb-name">
                                                    <i data-feather="type"
                                                        class="feather-sm text-info fill-white me-2"></i>
                                                    QA Name

                                                </label>
                                                <strong class="text-danger">
                                                    @error('quality_assurance_supervisor_id')
                                                        ( {{ $message }} )
                                                    @enderror
                                                </strong>
                                            </div>
                                        </div>

                                        <div class="col-md-3" id="quality_assurance_status_filed"
                                            style="display:{{ isset($project->quality_assurance_supervisor_id) || old('quality_assurance_supervisor_id') ? 'block' : 'none' }}">
                                            <div class="form-floating mb-3">
                                                <select name="quality_assurance_status"
                                                    onchange="handleRelatedSelectChange('quality_assurance_status_filed')"
                                                    class="form-control form-select border border-info @error('quality_assurance_status') border-danger @enderror custom_select_style">
                                                    <option value="">--- Choose QA Status ---</option>
                                                    <option value="1"
                                                        @if (old('quality_assurance_status') == 1 || $project->quality_assurance_status == 'In Queue') selected @endif>In Queue
                                                    </option>
                                                    <option value="2"
                                                        @if (old('quality_assurance_status') == 2 || $project->quality_assurance_status == 'In Progress') selected @endif>
                                                        In Progress
                                                    </option>
                                                    <option value="3"
                                                        @if (old('quality_assurance_status') == 3 || $project->quality_assurance_status == 'Completed') selected @endif>
                                                        Completed
                                                    </option>
                                                </select>
                                                <label for="tb-name">
                                                    <i data-feather="type"
                                                        class="feather-sm text-info fill-white me-2"></i>
                                                    QA Status

                                                </label>
                                                <strong class="text-danger">
                                                    @error('quality_assurance_status')
                                                        ( {{ $message }} )
                                                    @enderror
                                                </strong>
                                            </div>
                                        </div>

                                        {{-- end qa --}}
                                        {{-- button --}}
                                        <div class="col-12">
                                            <div class="d-md-flex align-items-center mt-3">
                                                <div class="ms-auto mt-3 mt-md-0">
                                                    <button type="submit"
                                                        class="btn btn-success font-weight-medium rounded-pill px-4">
                                                        <div class="d-flex align-items-center">
                                                            <i data-feather="save" class="feather-sm fill-white me-2"></i>
                                                            Add Supervisors
                                                        </div>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                        {{-- ============================================================= --}}
                        {{-- ===================== Tab 3 finance info ==================== --}}
                        {{-- ============================================================= --}}
                        <div class="tab-pane fade show fade" id="tab_body_3" role="tabpanel"
                            aria-labelledby="tab_body_3">
                            {{-- Statistics --}}
                            <div class="col-md-12 mb-4 mt-4 groove-container">
                                <div class="card-header" style="background-color: aliceblue;">
                                    <ul class="list-style-none mt-3 mb-2">
                                        <li class="mt-4">
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <h6 class="mb-0 fw-bold">The percentage of completion Finance Info
                                                        Section
                                                        <span class="fw-light"></span>
                                                    </h6>
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
                                    <div class="col-md-6">
                                        <div class="table-responsive">
                                            <table id="file_export_main_info_part_1"
                                                class="table table-striped table-bordered display">
                                                <thead>
                                                    {{-- All Invoices Total --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">All Invoices Total :</th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($totalInvoices) ? $totalInvoices : '-------' }}
                                                                JOD
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    {{-- Income Total (Paid): --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Income Total (Paid):</th>
                                                        <td>
                                                            <span style="color: green;"><strong>
                                                                    {{ isset($totalAmountCollected) ? $totalAmountCollected : '-------' }}
                                                                    JOD
                                                                </strong></span>
                                                        </td>
                                                    </tr>

                                                    {{-- Cancelled Invoices : --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Cancelled Invoices :</th>
                                                        <td>
                                                            <span><strong>
                                                                    {{ isset($totalCancelledAmount) ? $totalCancelledAmount : '-------' }}
                                                                    JOD
                                                                </strong></span>
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
                                                        <th style="background-color:aliceblue">Remaining Contracts :
                                                        </th>
                                                        <td>
                                                            <strong style="color: red">
                                                                {{ isset($project->remaining_contracts) ? $project->remaining_contracts : '-------' }}
                                                                JOD
                                                            </strong>
                                                        </td>
                                                    </tr>


                                                    <tr>
                                                        <th style="background-color:aliceblue">Total Contracts :</th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($project->total_contracts) ? $project->total_contracts : '-------' }}
                                                                JOD
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th style="background-color:aliceblue">Open Invoices Total :</th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($totalOpenAmount) ? $totalOpenAmount : '-------' }}
                                                                JOD
                                                            </strong>
                                                        </td>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            {{-- table --}}
                            <div class="card-body">
                                <div class="table-responsive">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h2>Project Invoices:</h2>
                                        {{-- @if ($project->remaining_contracts != 0) --}}
                                        @if ($totalInvoicesWithoutCancelled != $project->total_contracts)
                                            <div>
                                                <a href="{{ route('super_admin.project_invoices-createNewInvoiceFromShow', isset($project->id) ? $project->id : -1) }}"
                                                    class="btn btn-dark">
                                                    <i data-feather="plus" class="fill-white feather-sm"></i> Add New
                                                    Invoice
                                                </a>
                                            </div>
                                        @endif

                                    </div>

                                    <table id="file_export" class="table table-striped table-bordered display">
                                        <thead>
                                            <tr>
                                                <th>#REF</th>
                                                <th>Amount</th>
                                                <th>Method</th>
                                                <th>Due Date</th>
                                                <th>Status</th>
                                                <th>Controls</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (isset($projectInvoices) && count($projectInvoices) > 0)
                                                @foreach ($projectInvoices as $projectInvoice)
                                                    <tr>
                                                        {{-- <td>{{ $loop->iteration }}</td> --}}
                                                        <td>{{ isset($projectInvoice->id) ? $projectInvoice->id : '----' }}
                                                        </td>
                                                        <td>{{ isset($projectInvoice->amount) ? $projectInvoice->amount : 'amount' }}
                                                            JOD </td>

                                                        <td>{{ isset($projectInvoice->payment_method) ? $projectInvoice->payment_method : '-----' }}
                                                        </td>

                                                        <td>{{ isset($projectInvoice->invoice_due_date) ? \Carbon\Carbon::parse($projectInvoice->invoice_due_date)->format('d-m-Y') : '-----' }}
                                                        </td>

                                                        <td>
                                                            @if (isset($projectInvoice->status) && $projectInvoice->status == 'Paid')
                                                                <span
                                                                    style="color: green;"><strong>{{ isset($projectInvoice->status) ? $projectInvoice->status : '----' }}</strong></span>
                                                            @elseif(isset($projectInvoice->status) && $projectInvoice->status == 'Cancelled')
                                                                <span
                                                                    style="color: black;"><strong>{{ isset($projectInvoice->status) ? $projectInvoice->status : '----' }}</strong></span>
                                                            @elseif(isset($projectInvoice->status) && $projectInvoice->status == 'Hold')
                                                                <span
                                                                    style="color: orange;"><strong>{{ isset($projectInvoice->status) ? $projectInvoice->status : '----' }}</strong></span>
                                                            @elseif(isset($projectInvoice->status) && $projectInvoice->status == 'Open')
                                                                <span
                                                                    style="color: red;"><strong>{{ isset($projectInvoice->status) ? $projectInvoice->status : '----' }}</strong></span>
                                                            @else
                                                                {{ isset($projectInvoice->status) ? $projectInvoice->status : '----' }}
                                                            @endif
                                                        </td>

                                                        <td>
                                                            <div class="button-group">
                                                                <a href="{{ route('super_admin.project_invoices-show', ['id' => isset($projectInvoice->id) ? $projectInvoice->id : -1]) }}"
                                                                    class="btn waves-effect waves-light btn-primary btn-sm"
                                                                    title="View Details"><i class="fas fa-eye"></i></a>

                                                                @if ($projectInvoice->status !== 'Paid' && $projectInvoice->status !== 'Cancelled')
                                                                    <a href="{{ route('super_admin.project_invoices-editInvoiceFromShow', isset($projectInvoice->id) ? $projectInvoice->id : -1) }}"
                                                                        class="btn waves-effect waves-light btn-secondary btn-sm"
                                                                        title="Edit"><i class="fas fa-edit"></i>
                                                                    </a>
                                                                @endif

                                                                <a href="{{ route('super_admin.project_invoices-editID', ['id' => isset($projectInvoice->id) ? $projectInvoice->id : -1]) }}"
                                                                    class="btn waves-effect waves-light btn-primary btn-sm"
                                                                    title="View Details">
                                                                    <i class="fa fa-id-badge"></i>
                                                                </a>

                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                        @if ($totalInvoices > 0)
                                            <tfoot>
                                                <tr>
                                                    <th colspan="1">Total :</th>
                                                    <th colspan="1"><span
                                                            style="color: green">{{ isset($totalInvoices) ? $totalInvoices . ' JOD' : '-------' }}</span>
                                                    </th>
                                                </tr>
                                            </tfoot>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>
                        {{-- ============================================================= --}}
                        {{-- ===================== Tab 4 attachment ====================== --}}
                        {{-- ============================================================= --}}
                        <div class="tab-pane 
                            @if (
                                $errors->has('project_attachments_files') ||
                                    $errors->has('project_attachments_title') ||
                                    $errors->has('project_attachments_files.*')) fade show active @endif"
                                id="tab_body_4" role="tabpanel" aria-labelledby="tab_body_4">
                                @if (isset($project))
                                    {{-- Statistics --}}
                                    <div class="col-md-12 mb-4 mt-4 groove-container">
                                        <div class="card-header" style="background-color: aliceblue;">
                                            <ul class="list-style-none mt-3 mb-2">
                                                <li class="mt-4">
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            <h6 class="mb-0 fw-bold">The percentage of completion Attachment
                                                                Section <span class="fw-light"></span></h6>
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
                                        <form action="{{ route('super_admin.projects-addAttachments', $project->id) }}"
                                            id="attachmentForm" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="project_id" value="{{ $project->id }}">
                                            <div class="row">
                                                <!-- First column -->
                                                <div class="col-md-3">
                                                    <div class="col-md-12">
                                                        <div class="card border-info shadow-lg">
                                                            <div class="card-body">
                                                                <h2 class="card-title mb-4">Upload Project
                                                                    Files</h2>
                                                                <div class="mb-3">
                                                                    <label for="formFile"
                                                                        class="form-label">Instructions:</label>
                                                                    <div class="alert alert-info alert-dismissible bg-info text-white border-0 fade show"
                                                                        role="alert">
                                                                        <strong>1- Valid extensions: pdf,images</strong>
                                                                    </div>
                                                                    <div class="alert alert-info alert-dismissible bg-info text-white border-0 fade show"
                                                                        role="alert">
                                                                        <strong>2- Maximum file size:
                                                                            20MB</strong>
                                                                    </div>
                                                                    <div class="alert alert-info alert-dismissible bg-info text-white border-0 fade show"
                                                                        role="alert">
                                                                        <strong>3- Recommended dimensions:
                                                                            200px * 300px</strong>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-9">
                                                    <div class="card border-primary shadow-lg mb-4">
                                                        <div class="card-body">
                                                            <div class="card-bode">
                                                                @if ($errors->any())
                                                                    <div class="text-danger">
                                                                        <h2 class="card-title mb-5">Please correct the
                                                                            following
                                                                            errors :
                                                                            <span style="color: red">
                                                                                <ul>
                                                                                    @if (
                                                                                        $errors->has('project_attachments_title') ||
                                                                                            $errors->has('project_attachments_files') ||
                                                                                            $errors->has('project_attachments_files.*'))
                                                                                        @foreach ($errors->all() as $error)
                                                                                            <li> {{ $error }}</li>
                                                                                        @endforeach
                                                                                    @endif

                                                                                </ul>
                                                                            </span>
                                                                        </h2>


                                                                    </div>
                                                                @endif
                                                            </div>

                                                            <!-- Title Card -->
                                                            <div class="card-body">
                                                                <h2 class="card-title mb-8">File Title <span
                                                                        style="color: red">(Required) * </span> :</h2>
                                                                <div class="form-floating mb-3">
                                                                    <input type="text" name="project_attachments_title"
                                                                        required
                                                                        class="form-control border border-info @error('project_attachments_title') border-danger @enderror"
                                                                        id="tb-title"
                                                                        value="{{ old('project_attachments_title') }}"
                                                                        placeholder="Title">
                                                                    <label for="tb-title">
                                                                        <i data-feather="type"
                                                                            class="feather-sm text-info fill-white me-2"></i>
                                                                        Title

                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <!-- Project Attachments Card -->
                                                            <div class="card mb-4">
                                                                {{-- <div class="card-body text-center"> --}}
                                                                <div class="card-title mb-8">
                                                                    <h2 class="card-title mb-5">Project Attachments
                                                                        <span style="color: red">(Required) *</span> :
                                                                    </h2>

                                                                    <div class="mb-4">
                                                                        <label for="otherFilesInput" class="form-label">Select
                                                                            Files:</label>
                                                                        <input type="file"
                                                                            name="project_attachments_files[]" required
                                                                            id="otherFilesInput" class="form-control"
                                                                            multiple>
                                                                    </div>
                                                                    <div class="card-body text-center">
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Upload</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </form>
                                    </div>

                                    @if (isset($project->projectAttachments) && $project->projectAttachments->count() > 0)
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="file_export" class="table table-striped table-bordered display">
                                                    <thead>
                                                        <tr>
                                                            <th>#REF</th>
                                                            <th>Title</th>
                                                            <th>File</th>
                                                            <th>Controls</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($project->projectAttachments as $attachment)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ isset($attachment->title) ? $attachment->title : '----' }}
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
                                                                        <a href="{{ route('super_admin.projects-deleteAttachment', $attachment->id) }}"
                                                                            class="btn btn-danger btn-sm"
                                                                            onclick="return confirm('Are you sure you want to delete this file?');">
                                                                            <i class="fa fa-trash"></i> Delete
                                                                            File
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                        </div>
                        {{-- ============================================================= --}}
                        {{-- ==================== Tab 5 Payments info ==================== --}}
                        {{-- ============================================================= --}}
                        <div class="tab-pane fade show fade" id="tab_body_5" role="tabpanel"
                            aria-labelledby="tab_body_5">
                            {{-- Statistics --}}
                            <div class="col-md-12 mb-4 mt-4 groove-container">
                                <div class="card-header" style="background-color: aliceblue;">
                                    <ul class="list-style-none mt-3 mb-2">
                                        <li class="mt-4">
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <h6 class="mb-0 fw-bold">The percentage of completion Payments Info
                                                        Section
                                                        <span class="fw-light"></span>
                                                    </h6>
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
                                                <div class="progress-bar bg-success" role="progressbar"
                                                    style="width: 25%" aria-valuenow="25" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="file_export" class="table table-striped table-bordered display">
                                        <thead>
                                            <tr>
                                                <th>#REF</th>
                                                <th>Title</th>
                                                <th>Date</th>
                                                <th>Amount</th>
                                                <th>Paid Amount</th>
                                                <th>Status</th>
                                                <th>Remaining Amount</th>
                                                <th>Control</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (isset($project->projectPayments) && count($project->projectPayments) > 0)
                                                @foreach ($project->projectPayments as $projectPayment)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>

                                                        <td>{{ isset($projectPayment->payment_title) ? $projectPayment->payment_title : '----' }}
                                                        </td>

                                                        <td>{{ isset($projectPayment->payment_date) ? $projectPayment->payment_date : '----' }}
                                                        </td>

                                                        <td>{{ isset($projectPayment->payment_amount) ? $projectPayment->payment_amount : '----' }}
                                                            JOD
                                                        </td>

                                                        <td>{{ isset($projectPayment->payment_paid_amount) ? $projectPayment->payment_paid_amount : '----' }}
                                                            JOD
                                                        </td>

                                                        <td>
                                                            @if (isset($projectPayment->payment_status) && $projectPayment->payment_status == 'Paid')
                                                                <span
                                                                    style="color: green;"><strong>{{ isset($projectPayment->payment_status) ? $projectPayment->payment_status : '----' }}</strong></span>
                                                            @elseif(isset($projectPayment->payment_status) && $projectPayment->payment_status == 'Un Paid')
                                                                <span
                                                                    style="color: red;"><strong>{{ isset($projectPayment->payment_status) ? $projectPayment->payment_status : '----' }}</strong></span>
                                                            @elseif(isset($projectPayment->payment_status) && $projectPayment->payment_status == 'Partially Paid')
                                                                <span
                                                                    style="color: orange;"><strong>{{ isset($projectPayment->payment_status) ? $projectPayment->payment_status : '----' }}</strong></span>
                                                            @else
                                                                {{ isset($projectPayment->payment_status) ? $projectPayment->payment_status : '----' }}
                                                            @endif
                                                        </td>
                                                        {{-- <td>
                                                            <span
                                                                class="remainingAmount">{{ isset($projectPayment->payment_amount) ? $projectPayment->payment_amount - $projectPayment->payment_paid_amounts : '----' }}</span>
                                                        </td> --}}
                                                        <td>{{ isset($projectPayment->payment_remaining_amount) ? $projectPayment->payment_remaining_amount : '----' }}
                                                            JOD
                                                        </td>

                                                        <td>

                                                            <a href="{{ route('super_admin.project_payments-edit', isset($projectPayment->id) ? $projectPayment->id : -1) }}"
                                                                class="btn waves-effect waves-light btn-secondary btn-sm"
                                                                title="Edit"><i class="fas fa-edit"></i>
                                                            </a>

                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="3">Total :</th>


                                                <th colspan="1">
                                                    {{ isset($project->total_contracts) ? $project->total_contracts . ' JOD' : '-------' }}
                                                </th>
                                                <th colspan="1"><span
                                                        style="color: green">{{ isset($projectPaymentPaid) ? $projectPaymentPaid . ' JOD' : '-------' }}</span>
                                                </th>
                                                <th colspan="1"></th>
                                                <th colspan="1">
                                                    <span
                                                        style="color: red">{{ isset($projectPaymentsRemaing) ? $projectPaymentsRemaing . ' JOD' : '-------' }}</span>
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        {{-- ============================================================= --}}
                        {{-- ==================== Tab 6 Subscriptions ==================== --}}
                        {{-- ============================================================= --}}
                        <div class="tab-pane fade show fade" id="tab_body_6" role="tabpanel"
                            aria-labelledby="tab_body_6">
                            {{-- Statistics --}}
                            <div class="col-md-12 mb-4 mt-4 groove-container">
                                <div class="card-header" style="background-color: aliceblue;">
                                    <ul class="list-style-none mt-3 mb-2">
                                        <li class="mt-4">
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <h6 class="mb-0 fw-bold">The percentage of completion Subsicription
                                                        Info
                                                        Section <span class="fw-light"></span></h6>
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
                                                <div class="progress-bar bg-success" role="progressbar"
                                                    style="width: 25%" aria-valuenow="25" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            @if (isset($project->total_hosting) ||
                                    isset($project->due_date_hosting) ||
                                    isset($project->domain_url) ||
                                    isset($project->total_support) ||
                                    isset($project->due_date_support))
                                <div class="card-body">
                                    <div class="row">
                                        <div class="card-body">
                                            <div class="row">
                                                @if (isset($project->domain_url))
                                                    <div class="col-md-12">
                                                        <div class="table-responsive">
                                                            <table id="file_export_main_info_part_1"
                                                                class="table table-striped table-bordered display">
                                                                <thead>
                                                                    {{-- Domain URL: --}}
                                                                    <tr>
                                                                        <th style="background-color: aliceblue">Domain URL:
                                                                        </th>
                                                                        <td>
                                                                            <strong>
                                                                                <a target="_blank"
                                                                                    href="{{ isset($project->domain_url) ? $project->domain_url : '-------' }}">
                                                                                    {{ isset($project->domain_url) ? $project->domain_url : '-------' }}
                                                                                </a>
                                                                            </strong>
                                                                        </td>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                @endif


                                                @if (isset($project->total_hosting) || isset($project->due_date_hosting))
                                                    <div class="col-md-6">
                                                        <div class="table-responsive">
                                                            <table id="file_export_main_info_part_1"
                                                                class="table table-striped table-bordered display">
                                                                <thead>
                                                                    {{-- Total Hosting: --}}
                                                                    @if (isset($project->total_hosting))
                                                                        <tr>
                                                                            <th style="background-color:aliceblue">Total
                                                                                Hosting:
                                                                            </th>
                                                                            <td>
                                                                                <strong>
                                                                                    {{ isset($project->total_hosting) ? $project->total_hosting : '-------' }}
                                                                                    JOD </strong>
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                    {{-- Due Date Hosting : --}}
                                                                    @if (isset($project->due_date_hosting))
                                                                        <tr>
                                                                            <th style="background-color:aliceblue">Due Date
                                                                                Hosting
                                                                                :
                                                                            </th>
                                                                            <td>
                                                                                <span style="color: green;">
                                                                                    <strong>
                                                                                        {{ isset($project->due_date_hosting) ? date('d-m-Y', strtotime($project->due_date_hosting)) : '-------' }}
                                                                                    </strong>
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                    {{-- To show the subscriptions and thier amounts --}}
                                                                    @if (isset($subscriptionsInfo) && count($subscriptionsInfo) > 0)
                                                                        @foreach ($subscriptionsInfo as $subscriptionsType)
                                                                            <tr>

                                                                                <th style="background-color:aliceblue">
                                                                                    {!! isset($subscriptionsType['title_en']) && isset($subscriptionsType['title_ar'])
                                                                                        ? $subscriptionsType['title_en'] . ' ( ' . $subscriptionsType['title_ar'] . ' )'
                                                                                        : '------------' !!}
                                                                                </th>
                                                                                <td>
                                                                                    <span style="color: green;">
                                                                                        <strong>
                                                                                            {!! isset($subscriptionsType['amount']) ? $subscriptionsType['amount'] . 'JOD' : 0 !!}
                                                                                        </strong>
                                                                                    </span>
                                                                                </td>

                                                                            </tr>
                                                                        @endforeach
                                                                    @endif
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if (isset($project->total_support) || isset($project->due_date_support))
                                                    <div class="col-md-6">
                                                        <div class="table-responsive">
                                                            <table id="file_export_status_team"
                                                                class="table table-striped table-bordered display">
                                                                <thead>

                                                                    <tr>
                                                                        <th style="background-color:aliceblue">Total
                                                                            Support:
                                                                        </th>
                                                                        <td>
                                                                            <strong>
                                                                                {{ isset($project->total_support) ? $project->total_support : '-------' }}
                                                                                JOD
                                                                            </strong>
                                                                        </td>
                                                                    </tr>


                                                                    <tr>
                                                                        <th style="background-color:aliceblue">Due Date
                                                                            Support:
                                                                        </th>
                                                                        <td>
                                                                            <strong>
                                                                                {{ isset($project->due_date_support) ? date('d-m-Y', strtotime($project->due_date_support)) : '-------' }}
                                                                            </strong>
                                                                        </td>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            {{-- table --}}
                            <div class="card-body">
                                <div class="table-responsive">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <a href="{{ route('super_admin.project_subscriptions-create', ['project_id' => $project->id]) }}"
                                                class="btn btn-dark">
                                                <i data-feather="plus" class="fill-white feather-sm"></i> Add New
                                                Subscription
                                            </a>
                                        </div>

                                    </div>
                                </div>

                                <table id="file_export_hosting" class="table table-striped table-bordered display">
                                    <thead>
                                        <tr>
                                            <th>#REF</th>
                                            <th>Transaction</th>
                                            <th>Started From</th>
                                            <th>Due Date In</th>
                                            <th>Plan Type</th>
                                            <th>Remaining Days</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Controls</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($subscriptions) && count($subscriptions) > 0)
                                            @foreach ($subscriptions as $subscription)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ isset($subscription->subscriptionType->title_en) && isset($subscription->subscriptionType->title_ar) ? $subscription->subscriptionType->title_en . ' ( ' . $subscription->subscriptionType->title_ar . ' )' : '-----' }}
                                                    </td>

                                                    <td>{{ isset($subscription->started_from) ? \Carbon\Carbon::parse($subscription->started_from)->format('d-m-Y') : '-----' }}
                                                    </td>

                                                    <td>{{ isset($subscription->due_date) ? \Carbon\Carbon::parse($subscription->due_date)->format('d-m-Y') : '-----' }}
                                                    </td>

                                                    <td>{{ isset($subscription->plan_type) ? $subscription->plan_type : '-----' }}
                                                    </td>

                                                    <td>
                                                        @if (isset($subscription->started_from) && isset($subscription->due_date))
                                                            {{ \Carbon\Carbon::now()->isBetween(\Carbon\Carbon::parse($subscription->started_from), \Carbon\Carbon::parse($subscription->due_date)) && \Carbon\Carbon::parse($subscription->due_date)->isFuture() ? \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($subscription->due_date)) : 0 }}






                                                            Days
                                                        @else
                                                            -----
                                                        @endif
                                                    </td>
                                                    <td>{{ isset($subscription->payment_amount) ? $subscription->payment_amount : '-----' }}
                                                        JOD
                                                    </td>

                                                    <td>
                                                        @if (isset($subscription->payment_status) && $subscription->payment_status == 'Paid')
                                                            <span
                                                                style="color: green;"><strong>{{ isset($subscription->payment_status) ? $subscription->payment_status : '----' }}</strong></span>
                                                        @elseif(isset($subscription->payment_status) && $subscription->payment_status == 'Un Paid')
                                                            <span
                                                                style="color: red;"><strong>{{ isset($subscription->payment_status) ? $subscription->payment_status : '----' }}</strong></span>
                                                        @elseif(isset($subscription->payment_status) && $subscription->payment_status == 'Partially Paid')
                                                            <span
                                                                style="color: orange;"><strong>{{ isset($subscription->payment_status) ? $subscription->payment_status : '----' }}</strong></span>
                                                        @else
                                                            {{ isset($subscription->payment_status) ? $subscription->payment_status : '----' }}
                                                        @endif
                                                    </td>

                                                    <td>
                                                        <div class="button-group">
                                                            <a href="{{ route('super_admin.project_subscriptions-show', ['id' => isset($subscription->id) ? $subscription->id : -1]) }}"
                                                                class="btn waves-effect waves-light btn-primary btn-sm"
                                                                title="View Details"><i class="fas fa-eye"></i>
                                                            </a>

                                                            @if ($subscription->payment_status == 'Un Paid')
                                                                <a href="{{ route('super_admin.project_subscriptions-edit', isset($subscription->id) ? $subscription->id : -1) }}"
                                                                    class="btn waves-effect waves-light btn-secondary btn-sm"
                                                                    title="Edit"><i class="fas fa-edit"></i>
                                                                </a>
                                                            @endif
                                                            @if ($subscription->payment_status != 'Paid')
                                                                <a href="{{ route('super_admin.project_invoices-createNewSubscriptionInvoiceFromShow', isset($subscription->id) ? $subscription->id : -1) }}"
                                                                    class="btn waves-effect waves-light btn-primary btn-sm"
                                                                    title="View Details">
                                                                    <i class="fa fa-book"></i>
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="6">Total :</th>
                                            <th colspan="1"><span
                                                    style="color: green">{{ isset($subscriptionsForProjectTotal) ? $subscriptionsForProjectTotal . ' JOD' : '-------' }}</span>
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        {{-- ============================================================= --}}
                        {{-- ==================== Tab 7 Sales Tickets ==================== --}}
                        {{-- ============================================================= --}}
                        <div class="tab-pane fade show fade @if (old('sales_ticket_title') || old('sales_ticket_description') || old('sales_ticket_date')) active @endif"
                            id="tab_body_7" role="tabpanel" aria-labelledby="tab_body_7">
                            <br>
                            <div class="col-12 groove-container">
                                {{-- Form Section --}}
                                <div class="card-header" style="background-color: aliceblue;">
                                    <strong>Add New Sales Ticket :</strong>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        {{-- <h4 class="card-title mb-3 pb-3 border-bottom">Add New Sales Ticket :</h4> --}}
                                        <form
                                            action="{{ route('super_admin.sales_tickets-store', isset($project->id) ? $project->id : -1) }}"
                                            method="POST" id="createFormSalesTicket" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                {{-- title --}}
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" name="sales_ticket_title" required
                                                            class="form-control border border-info @error('sales_ticket_title') border-danger @enderror"
                                                            id="tb-title" value="{{ old('sales_ticket_title') }}"
                                                            placeholder="Title">
                                                        <label for="tb-title">
                                                            <i data-feather="type"
                                                                class="feather-sm text-info fill-white me-2"></i>Title
                                                            <span>*</span>
                                                            <strong class="text-danger">
                                                                @error('sales_ticket_title')
                                                                    ( {{ $message }} )
                                                                @enderror
                                                            </strong>
                                                        </label>
                                                    </div>
                                                </div>

                                                {{-- date --}}
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3">
                                                        <input type="date" name="sales_ticket_date" required
                                                            class="form-control border border-info @error('sales_ticket_date') border-danger @enderror"
                                                            id="tb-date" value="{{ old('sales_ticket_date') }}"
                                                            placeholder="Date">
                                                        <label for="tb-date">
                                                            <i data-feather="type"
                                                                class="feather-sm text-info fill-white me-2"></i>Date
                                                            <span>*</span>
                                                            <strong class="text-danger">
                                                                @error('sales_ticket_date')
                                                                    ( {{ $message }} )
                                                                @enderror
                                                            </strong>
                                                        </label>
                                                    </div>
                                                </div>

                                                {{-- Description --}}
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label>Description : <strong class="text-danger">
                                                                @error('sales_ticket_description')
                                                                    ( {{ $message }} )
                                                                @enderror
                                                            </strong></label>
                                                        <textarea name="sales_ticket_description"
                                                            class="form-control border border-info @error('sales_ticket_description') border-danger @enderror" rows="5"
                                                            placeholder="Description">{{ old('sales_ticket_description') }}</textarea>
                                                    </div>
                                                </div>

                                                {{-- Button --}}
                                                <div class="col-12">
                                                    <div class="d-md-flex align-items-center mt-3">
                                                        <div class="ms-auto mt-3 mt-md-0">
                                                            <button type="submit"
                                                                class="btn btn-success font-weight-medium rounded-pill px-4">
                                                                <div class="d-flex align-items-center">
                                                                    <i data-feather="plus"
                                                                        class="feather-sm fill-white me-2"></i>
                                                                    Add New
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @if (isset($project->salesTickets) && $project->salesTickets->count() > 0)
                                <div class="card-header" style="background-color: aliceblue;">
                                    <strong>
                                        <h3>Sales Tickets: </h3>
                                    </strong>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @if (isset($project->salesTickets))
                                            @foreach ($project->salesTickets as $salesTicket)
                                                <div class="col-md-12">
                                                    <div class="card mb-4 shadow-sm groove-container">
                                                        <div class="card-body">
                                                            <h5 class="card-title">
                                                                <strong>Title:
                                                                </strong>{{ isset($salesTicket->title) ? $salesTicket->title : '----' }}
                                                            </h5>
                                                            <p class="card-text"><strong>Date:</strong>
                                                                {{ isset($salesTicket->date) ? $salesTicket->date : '----' }}
                                                            </p>

                                                            <p class="card-text"><strong>Created By:</strong>
                                                                {{ isset($salesTicket->created_by) ? $salesTicket->created_by : '----' }}
                                                            </p>

                                                            <p class="card-text"><strong>Description:</strong>
                                                                {{ isset($salesTicket->description) ? $salesTicket->description : '----' }}
                                                            </p>
                                                            <div class="btn-group" role="group" aria-label="Controls">
                                                                <a href="{{ route('super_admin.sales_tickets-edit', isset($salesTicket->id) ? $salesTicket->id : -1) }}"
                                                                    class="btn btn-secondary btn-sm me-2"
                                                                    title="Edit"><i class="fas fa-edit"></i>
                                                                </a>
                                                                <a href="{{ route('super_admin.sales_tickets-destroySalesTicket', isset($salesTicket->id) ? $salesTicket->id : -1) }}"
                                                                    class="confirm btn btn-danger btn-sm ml-2"
                                                                    title="Delete"><i class="fas fa-trash-alt"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                        {{-- ============================================================= --}}
                        {{-- =================== Tab 8 Support Tickets =================== --}}
                        {{-- ============================================================= --}}
                        <div class="tab-pane fade show fade @if (old('support_ticket_title') || old('support_ticket_description') || old('support_ticket_date')) active @endif"
                            id="tab_body_8" role="tabpanel" aria-labelledby="tab_body_8">
                            <hr>
                            <div class="col-12 groove-container">
                                {{-- Form Section --}}

                                <div class="card-header" style="background-color: aliceblue;">
                                    <strong>Add New Support Ticket :</strong>
                                </div>
                                <hr>
                                <div class="card">
                                    <div class="card-body">
                                        {{-- <h4 class="card-title mb-3 pb-3 border-bottom">Add New Support Ticket :</h4> --}}
                                        <form
                                            action="{{ route('super_admin.project_support_tickets-store', isset($project->id) ? $project->id : -1) }}"
                                            method="POST" id="createFormSalesTicket" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                {{-- title --}}
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" name="support_ticket_title" required
                                                            class="form-control border border-info @error('support_ticket_title') border-danger @enderror"
                                                            id="tb-title" value="{{ old('support_ticket_title') }}"
                                                            placeholder="Title">
                                                        <label for="tb-title">
                                                            <i data-feather="type"
                                                                class="feather-sm text-info fill-white me-2"></i>Title
                                                            <span>*</span>
                                                            <strong class="text-danger">
                                                                @error('support_ticket_title')
                                                                    ( {{ $message }} )
                                                                @enderror
                                                            </strong>
                                                        </label>
                                                    </div>
                                                </div>

                                                {{-- date --}}
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3">
                                                        <input type="date" name="support_ticket_date" required
                                                            class="form-control border border-info @error('support_ticket_date') border-danger @enderror"
                                                            id="tb-date" value="{{ old('support_ticket_date') }}"
                                                            placeholder="Date">
                                                        <label for="tb-date">
                                                            <i data-feather="type"
                                                                class="feather-sm text-info fill-white me-2"></i>Date
                                                            <span>*</span>
                                                            <strong class="text-danger">
                                                                @error('support_ticket_date')
                                                                    ( {{ $message }} )
                                                                @enderror
                                                            </strong>
                                                        </label>
                                                    </div>
                                                </div>

                                                {{-- Description --}}
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label>Description : <strong class="text-danger">
                                                                @error('support_ticket_description')
                                                                    ( {{ $message }} )
                                                                @enderror
                                                            </strong></label>
                                                        <textarea name="support_ticket_description"
                                                            class="form-control border border-info @error('support_ticket_description') border-danger @enderror"
                                                            rows="5" placeholder="Description">{{ old('support_ticket_description') }}</textarea>
                                                    </div>
                                                </div>

                                                {{-- Button --}}
                                                <div class="col-12">
                                                    <div class="d-md-flex align-items-center mt-3">
                                                        <div class="ms-auto mt-3 mt-md-0">
                                                            <button type="submit"
                                                                class="btn btn-success font-weight-medium rounded-pill px-4">
                                                                <div class="d-flex align-items-center">
                                                                    <i data-feather="plus"
                                                                        class="feather-sm fill-white me-2"></i>
                                                                    Add New
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @if (isset($project->projectSupportTickets) && $project->projectSupportTickets->count() > 0)
                                <div class="card-header" style="background-color: aliceblue;">
                                    <strong>
                                        <h3>Support Tickets </h3>
                                    </strong>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @if (isset($project->projectSupportTickets))
                                            @foreach ($project->projectSupportTickets as $supportTicket)
                                                <div class="col-md-12">
                                                    <div class="card mb-4 shadow-sm groove-container">
                                                        <div class="card-body">
                                                            <h5 class="card-title">
                                                                <strong>Title:
                                                                </strong>{{ isset($supportTicket->title) ? $supportTicket->title : '----' }}
                                                            </h5>
                                                            <p class="card-text"><strong>Date:</strong>
                                                                {{ isset($supportTicket->date) ? $supportTicket->date : '----' }}
                                                            </p>

                                                            <p class="card-text"><strong>Created By:</strong>
                                                                {{ isset($supportTicket->created_by) ? $supportTicket->created_by : '----' }}
                                                            </p>

                                                            <p class="card-text"><strong>Description:</strong>
                                                                {{ isset($supportTicket->description) ? $supportTicket->description : '----' }}
                                                            </p>
                                                            <div class="btn-group" role="group"
                                                                aria-label="Controls">
                                                                <a href="{{ route('super_admin.project_support_tickets-edit', isset($supportTicket->id) ? $supportTicket->id : -1) }}"
                                                                    class="btn btn-secondary btn-sm me-2"
                                                                    title="Edit"><i class="fas fa-edit"></i>
                                                                </a>
                                                                <a href="{{ route('super_admin.project_support_tickets-destroyProjectSupportTicket', isset($supportTicket->id) ? $supportTicket->id : -1) }}"
                                                                    class="confirm btn btn-danger btn-sm"
                                                                    title="Delete"><i class="fas fa-trash-alt"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                        {{-- ============================================================= --}}
                        {{-- ===================== Tab 9 Tasks info ====================== --}}
                        {{-- ============================================================= --}}
                        <div class="tab-pane fade show fade" id="tab_body_9" role="tabpanel"
                            aria-labelledby="tab_body_9">
                            {{-- Statistics --}}
                            <div class="col-md-12 mb-4 mt-4 groove-container">
                                <div class="card-header" style="background-color: aliceblue;">
                                    <ul class="list-style-none mt-3 mb-2">
                                        <li class="mt-4">
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <h6 class="mb-0 fw-bold">The percentage of completion Tasks Section
                                                        <span class="fw-light"></span>
                                                    </h6>
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
                                <div class="table-responsive">
                                    <table id="file_export" class="table table-striped table-bordered display">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Description</th>
                                                <th>Employee</th>
                                                <th>Status</th>
                                                <th>Received Date</th>
                                                <th>Date/Time</th>
                                                <th>Control</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @if (isset($project->tasks) && count($project->tasks) > 0)
                                                @foreach ($project->tasks as $task)
                                                    <tr>
                                                        <td><a
                                                                href="{{ route('super_admin.tasks-show', isset($task->id) ? $task->id : -1) }}">{{ isset($task->title) ? $task->title : '----' }}</a>
                                                        </td>

                                                        <td><a
                                                                href="{{ route('super_admin.projects-show', isset($task->projects->id) ? $task->projects->id : -1) }}">{{ isset($task->projects->name_en) ? $task->projects->name_en : '----' }}</a>
                                                        </td>

                                                        <td><a
                                                                href="#">{{ isset($task->users->name) ? $task->users->name : 'Still not assigned' }}</a>
                                                        </td>
                                                        <td>{{ isset($task->status) ? $task->status : '----' }}</td>

                                                        <td>{{ isset($task->received_date) ? $task->received_date : '----' }}
                                                        </td>

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
                                                            <input type="checkbox" class="selectedTasks"
                                                                name="selectedTasks[]" value="{{ $task->id }}">
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
    
    @endsection

    @section('extra_js')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>

        <script>
            $(document).ready(function() {
                $('.view-file-link').each(function() {
                    var fileExt = getFileExtension($(this).attr('href'));

                    $(this).attr({
                        'target': '_blank',
                        'href': fileLink
                    });
                });

                function getFileExtension(fileName) {
                    return fileName.split('.').pop().toLowerCase();
                }

                function getFileType(extension) {
                    switch (extension) {
                        case 'jpg':
                        case 'jpeg':
                        case 'png':
                        case 'gif':
                            return 'image';
                        case 'pdf':
                            return 'iframe';
                        case 'doc':
                        case 'docx':
                        case 'xls':
                        case 'xlsx':
                            return 'iframe'; // You can change this based on your preference
                        default:
                            return '';
                    }
                }
            });
        </script>

        {{-- department_employees --}}
        <script>
            $(document).ready(function() {
                getCustomerProjects();
                $('#design_department_id').on('change', function() {
                    getProjectsForCustomer(); // Fetch new projects when department_id changes
                });

                function getProjectsForCustomer() {

                    var design_department_id = $('#design_department_id').val(); // Fetch the updated department ID
                    if (design_department_id)
                        var formData = new FormData($('#createForm')[0]);
                    var fullRoute =
                        "{{ route('super_admin.projects-getEmployeesForDepartment', 'design_department_id=:design_department_id') }}";
                    fullRoute = fullRoute.replace(':design_department_id', design_department_id);
                    $.ajax({
                        type: 'POST',
                        url: fullRoute,
                        data: formData,
                        processData: false,
                        contentType: false,
                        cache: false,
                        success: function(data) {
                            if (data.status == true) {

                                var selectUser = '<option value="">Select Employee</option>';
                                for (var key in data.users) {
                                    if (!data.users.hasOwnProperty(key)) continue;

                                    var obj = data.users[key];
                                    for (var prop in obj) {
                                        if (!obj.hasOwnProperty(prop)) continue;
                                        var name = $("#name").val();
                                        console.log(88888888888);
                                        console.log(name);
                                        console.log(obj.id);
                                        if (name) {
                                            if (obj.id == name) {

                                                selectUser += '<option value="' + obj.id + '" selected>' +
                                                    obj.name +
                                                    '</option>';
                                            } else {
                                                selectUser += '<option value="' + obj.id + '">' + obj.name +
                                                    '</option>';
                                            }
                                        } else {
                                            selectUser += '<option value="' + obj.id + '">' + obj.name +
                                                '</option>';
                                        }
                                        break;
                                    }
                                }
                                console.log(selectUser);
                                $('#user').html(selectUser);
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

            });


            function getCustomerProjects() {
                var formData = new FormData($('#createForm')[0]);
                $.ajax({
                    type: 'POST',
                    url: "{{ route('super_admin.projects-getEmployeesForDepartment') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function(data) {
                        if (data.status == true) {

                            var selectUser = '<option value="">Select Employee</option>';
                            for (var key in data.users) {
                                if (!data.users.hasOwnProperty(key)) continue;

                                var obj = data.users[key];
                                for (var prop in obj) {
                                    if (!obj.hasOwnProperty(prop)) continue;
                                    var name = $("#name").val();
                                    if (name) {
                                        if (obj.id == name) {

                                            selectUser += '<option value="' + obj.id + '" selected>' + obj.name +
                                                '</option>';
                                        } else {
                                            selectUser += '<option value="' + obj.id + '">' + obj.name +
                                                '</option>';
                                        }
                                    } else {
                                        selectUser += '<option value="' + obj.id + '">' + obj.name + '</option>';
                                    }
                                    break;
                                }
                            }
                            $('#user').html(selectUser);
                            var design_supervisor_id =
                                "{{ $project->design_supervisor_id }}"; // Assuming $design_supervisor_id holds the stored value
                            $('#user').val(design_supervisor_id);

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

        {{-- department_employees_web --}}
        <script>
            $(document).ready(function() {
                getWebSupervisor();
                $('#web_department_id').on('change', function() {
                    getProjectsForCustomer();
                });

                function getProjectsForCustomer() {
                    var web_department_id = $('#web_department_id').val();
                    if (web_department_id) {
                        var fullRoute =
                            "{{ route('super_admin.projects-getEmployeesForDepartmentForWeb', 'web_department_id=:web_department_id') }}";
                        fullRoute = fullRoute.replace(':web_department_id', web_department_id);
                        $.ajax({
                            type: 'POST',
                            url: fullRoute,
                            processData: false,
                            contentType: false,
                            cache: false,
                            success: function(data) {
                                if (data.status == true) {
                                    var selectUser = '<option value="">Select Employee</option>';
                                    data.users.forEach(function(obj) {
                                        selectUser += '<option value="' + obj.id + '">' + obj
                                            .name + '</option>';
                                    });
                                    $('#user_id').html(selectUser); // Populate the Employee dropdown
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
            });


            function getWebSupervisor() {
                var formData = new FormData($('#createForm')[0]);
                $.ajax({
                    type: 'POST',
                    url: "{{ route('super_admin.projects-getEmployeesForDepartmentForWeb') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function(data) {
                        if (data.status == true) {

                            var selectUser = '<option value="">Select Employee</option>';
                            for (var key in data.users) {
                                if (!data.users.hasOwnProperty(key)) continue;

                                var obj = data.users[key];
                                for (var prop in obj) {
                                    if (!obj.hasOwnProperty(prop)) continue;
                                    var oldWebSupervisor = $("#oldWebSupervisor").val();
                                    if (oldWebSupervisor) {
                                        if (obj.id == oldWebSupervisor) {

                                            selectUser += '<option value="' + obj.id + '" selected>' + obj.name +
                                                '</option>';
                                        } else {
                                            selectUser += '<option value="' + obj.id + '">' + obj.name +
                                                '</option>';
                                        }
                                    } else {
                                        selectUser += '<option value="' + obj.id + '">' + obj.name + '</option>';
                                    }
                                    break;
                                }
                            }
                            $('#webSupervisor').html(selectUser);
                            var web_supervisor_id = "{{ $project->web_supervisor_id }}";
                            $('#webSupervisor').val(web_supervisor_id);
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

        {{-- department_employees_mobile --}}
        <script>
            $(document).ready(function() {
                getMobileSupervisor();
                $('#mobile_department_id').on('change', function() {
                    getProjectsForCustomer(); // Fetch new projects when mobile_department_id changes
                });

                function getProjectsForCustomer() {
                    var mobile_department_id = $('#mobile_department_id').val(); // Fetch the updated department ID
                    if (mobile_department_id) {
                        var fullRoute =
                            "{{ route('super_admin.projects-getEmployeesForDepartmentForMobile', 'mobile_department_id=:mobile_department_id') }}";
                        fullRoute = fullRoute.replace(':mobile_department_id', mobile_department_id);
                        $.ajax({
                            type: 'POST',
                            url: fullRoute,
                            processData: false,
                            contentType: false,
                            cache: false,
                            success: function(data) {
                                if (data.status == true) {
                                    var selectUser = '<option value="">Select Employee</option>';
                                    data.users.forEach(function(obj) {
                                        selectUser += '<option value="' + obj.id + '">' + obj
                                            .name + '</option>';
                                    });
                                    $('#user_id').html(selectUser); // Populate the Employee dropdown
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
            });


            function getMobileSupervisor() {
                var formData = new FormData($('#createForm')[0]);
                $.ajax({
                    type: 'POST',
                    url: "{{ route('super_admin.projects-getEmployeesForDepartmentForMobile') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function(data) {
                        if (data.status == true) {

                            var selectUser = '<option value="">Select Employee</option>';
                            for (var key in data.users) {
                                if (!data.users.hasOwnProperty(key)) continue;

                                var obj = data.users[key];
                                for (var prop in obj) {
                                    if (!obj.hasOwnProperty(prop)) continue;
                                    var name = $("#name").val();
                                    if (name) {
                                        if (obj.id == name) {

                                            selectUser += '<option value="' + obj.id + '" selected>' + obj.name +
                                                '</option>';
                                        } else {
                                            selectUser += '<option value="' + obj.id + '">' + obj.name +
                                                '</option>';
                                        }
                                    } else {
                                        selectUser += '<option value="' + obj.id + '">' + obj.name + '</option>';
                                    }
                                    break;
                                }
                            }
                            $('#mobile_supervisor').html(selectUser);
                            var mobile_supervisor_id = "{{ $project->mobile_supervisor_id }}";
                            $('#mobile_supervisor').val(mobile_supervisor_id);
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

        {{-- file and attachment --}}
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const form = document.getElementById('attachmentForm');
                const fieldsToValidate = ['project_attachments_title',
                    'project_attachments_files[]'
                ]; // Add other field IDs or names if needed

                fieldsToValidate.forEach(fieldName => {
                    const field = form.querySelector(`[name="${fieldName}"]`);

                    // Check if field is empty when the page loads
                    if (field.value.trim() === '') {
                        field.classList.add('border', 'border-danger');
                    }

                    // Add event listeners for input event to toggle the CSS class
                    field.addEventListener('input', function() {
                        if (this.value.trim() === '') {
                            this.classList.add('border', 'border-danger');
                        } else {
                            this.classList.remove('border', 'border-danger');
                        }
                    });
                });

                form.addEventListener("submit", function(event) {
                    if (!validateForm()) {
                        event.preventDefault(); // Prevent form submission
                        // alert('Please fill out all required fields with *');
                    }
                });

                function validateForm() {
                    let isValid = true;

                    fieldsToValidate.forEach(fieldName => {
                        const field = form.querySelector(`[name="${fieldName}"]`);
                        if (field.value.trim() === '') {
                            isValid = false;
                            field.classList.add('border', 'border-danger');
                        } else {
                            field.classList.remove('border', 'border-danger');
                        }
                    });

                    return isValid;
                }
            });
        </script>

        {{-- file_export_sales_tickets --}}
        <script>
            $(document).ready(function() {
                // Initialize the DataTable with export buttons
                var table = $('#file_export_sales_tickets').DataTable({
                    dom: 'Bfrtip',
                    buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                });

                // Add styling to DataTable buttons
                $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel')
                    .addClass('btn btn-primary mr-1');
            });
        </script>
        {{-- =========================================================== --}}
        {{-- ====================== Edited By Raghad =================== --}}
        {{-- =========================================================== --}}
        {{-- hide and show fields --}}
        <script>
            $(document).ready(function() {
                // gather_analyze_requirements_supervisor_id
                $('#gather_analyze_requirements_supervisor_id').on('change', function() {
                    var supervisorId = $(this).val();
                    if (supervisorId) {
                        $('#gather_analyze_requirements_status_field').show();
                    } else {
                        $('#gather_analyze_requirements_status_field').hide();
                    }
                }).change(); // Trigger change event on page load

                // design_department_id
                $('#design_department_id').on('change', function() {
                    var departmentId = $(this).val();
                    if (departmentId) {
                        $('#design_supervisor_field').show();
                        $('#design_status_field').show();
                    } else {
                        $('#design_supervisor_field').hide();
                        $('#design_status_field').hide();
                        // Clear selected values in selects within the specified divs => Done by Raghad
                        $('#design_supervisor_field select, #design_status_field select').val('');
                    }
                }).change(); // Trigger change event on page load


                // web_supervisor_id_filed
                $('#web_department_id').on('change', function() {
                    var departmentWebId = $(this).val();
                    if (departmentWebId) {
                        $('#web_supervisor_id_filed').show();
                        $('#web_status_filed').show();
                        $('#programming_language_used_web_filed').show();
                    } else {
                        $('#web_supervisor_id_filed').hide();
                        $('#web_status_filed').hide();
                        $('#programming_language_used_web_filed').hide();
                    }
                }).change(); // Trigger change event on page load



                // mobileDepartments
                $('#mobileDepartments').on('change', function() {
                    var departmentId = $(this).val();
                    if (departmentId) {
                        $('#mobile_supervisor_id_filed').show();
                        $('#mobile_status_filed').show();
                        $('#programming_language_used_mobile').show();
                    } else {
                        $('#mobile_supervisor_id_filed').hide();
                        $('#mobile_status_filed').hide();
                        $('#programming_language_used_mobile').hide();
                    }
                }).change(); // Trigger change event on page load



                // QAStatus
                $('#quality_assurance_supervisor_id').on('change', function() {
                    var QAStatus = $(this).val();
                    if (QAStatus) {
                        $('#quality_assurance_status_filed').show();
                    } else {
                        $('#quality_assurance_status_filed').hide();
                    }
                }).change(); // Trigger change event on page load
            });
        </script>
        {{-- ========================== DONE BY RAGHAD ========================== --}}
        {{-- Red border for selects (it works dynamiclly depends on the main select id, and sub selects ID's) --}}
        <script>
            function handleMainSelectChange(mainSelectId, containerIds) {
                var mainSelect = document.getElementById(mainSelectId);

                // Remove red border from all related selects in the specified containers
                containerIds.forEach(function(containerId) {
                    var container = document.getElementById(containerId);
                    var relatedSelect = container.querySelector('select');

                    if (relatedSelect) {
                        relatedSelect.classList.remove('border-danger');

                        // Add red border to the related select if the main select is selected
                        if (mainSelect.value) {
                            relatedSelect.classList.add('border-danger');
                        }
                    }
                });
            }
            
            function handleRelatedSelectChange(containerId) {
                var container = document.getElementById(containerId);
                var relatedSelect = container.querySelector('select');

                if (relatedSelect) {
                    console.log('relatedSelect.value: ', relatedSelect.value);
                    // Check if the select has a value
                    if (relatedSelect.value) {
                        relatedSelect.classList.remove('border-danger');
                    } else {
                        relatedSelect.classList.add('border-danger');
                    }
                }
            }
            // To keep the red border when there is an old value
            $(document).ready(function() {
                handleRelatedSelectChange('gather_analyze_requirements_status_field');
                handleRelatedSelectChange('design_supervisor_field');
                handleRelatedSelectChange('design_status_field');
                handleRelatedSelectChange('web_supervisor_id_filed');
                handleRelatedSelectChange('web_status_filed');
                handleRelatedSelectChange('programming_language_used_web_filed');
                handleRelatedSelectChange('mobile_supervisor_id_filed');
                handleRelatedSelectChange('mobile_status_filed');
                handleRelatedSelectChange('programming_language_used_mobile');
                handleRelatedSelectChange('quality_assurance_status_filed');

                function handleRelatedSelectChange(containerId) {
                    var container = document.getElementById(containerId);
                    var relatedSelect = container.querySelector('select');

                    if (relatedSelect) {
                        console.log('relatedSelect.value: ', relatedSelect.value);
                        // Check if the select has a value
                        if (relatedSelect.value) {
                            relatedSelect.classList.remove('border-danger');
                        } else {
                            relatedSelect.classList.add('border-danger');
                        }
                    }
                }
            });
        </script>

        {{-- ============================ FOR SAMER ============================  --}}
        <script>
            // $(document).ready(function() {
            //     $("#user option:selected").prependTo("#user");
            // });
        </script>

        <script>
            // $(document).ready(function() {
            //     $("select").change(function() {
            //     $("#user option:selected").prependTo("#user");
            //         var selectedOption = $("option:selected", this);
            //         selectedOption.remove();
            //         $(this).prepend(selectedOption);

            //         var newValue = selectedOption.val();
            //         alert("Selected option value: " + newValue);
            //     });
            // });
        </script>
    @endsection
