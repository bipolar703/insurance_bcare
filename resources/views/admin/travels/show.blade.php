@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <h2 class="page-title">{{ isset($travel->title) ? $travel->title : '-----' }} </h2>
            <div class="col-md-5 align-self-center">
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.travels-index') }}">Travels</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Lead Details</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Create --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.travels-create') }}" class="btn btn-dark">
                            <i data-feather="plus" class="fill-white feather-sm"></i> Add New
                        </a>
                    </div>
                    {{-- Edit --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.travels-edit', isset($travel->id) ? $travel->id : -1) }}"
                            class="btn btn-secondary">
                            <i data-feather="edit" class="fill-white feather-sm"></i> Edit
                        </a>
                    </div>
                    {{-- Delete --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.travels-destroy', isset($travel->id) ? $travel->id : -1) }}"
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
            <div class="col-md-12">
                <div class="card">
                    {{-- Tabs Header Section --}}
                    <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="tab_header_1" data-bs-toggle="pill" href="#tab_body_1"
                                role="tab" aria-controls="pills-profile" aria-selected="false"><strong>Main
                                    Info</strong></a>
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
                                                                {{ isset($travel->id) ? $travel->id : '----' }}
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    {{-- created_by --}}
                                                    <tr>
                                                        <th style="background-color: aliceblue">Created By:</th>
                                                        <td>
                                                            <strong>
                                                                {!! isset($travel->created_by) ? $travel->created_by : '-------' !!}
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    {{-- created_at --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue"> Added Since:</th>
                                                        <td>
                                                            <strong>{!! isset($travel->created_at) ? $travel->created_at->diffForHumans() : '-------' !!}</strong>
                                                        </td>
                                                    </tr>

                                                    {{-- created_at --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Addition Time:</th>
                                                        <td>
                                                            <strong>{!! isset($travel->created_at) ? date('h:i A', strtotime($travel->created_at)) : '-------' !!}</strong>
                                                        </td>
                                                    </tr>

                                                    {{-- created_at --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Created By:</th>
                                                        <td>
                                                            <strong>
                                                                {{-- {!! isset($travel->created_at) ? date('d/M/Y', strtotime($travel->created_at)) : '-------' !!} --}}
                                                                {{ isset($travel->created_by) ? $travel->createdBy->name : '----' }}

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

                                                    {{-- title --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Title:
                                                        </th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($travel->title) ? $travel->title : '-------' }}
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    {{-- Distance --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Distance:</th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($travel->distance) ? $travel->distance : '-------' }} KM
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    {{-- authorized_signatory --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Cost :</th>
                                                        <td>
                                                            <strong style="color: red">
                                                                {{ isset($travel->cost) ? $travel->cost : '-------' }} JOD
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    {{-- employee_id --}}
                                                    <tr>
                                                        <th style="background-color: aliceblue">Employee:</th>
                                                        <td>
                                                            <strong>
                                                                <a
                                                                    href="{{ route('super_admin.employees-show', ['id' => isset($travel->user_id) ? $travel->user_id : '-------']) }}">
                                                                    {{ isset($travel->user->name) ? $travel->user->name : '-------' }}
                                                                </a>
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
                </div>
            </div>
        </div>
    @endsection

    @section('extra_js')
    @endsection
