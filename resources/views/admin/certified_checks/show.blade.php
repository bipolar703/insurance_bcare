@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    {{-- certifiedCheck --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.certified_checks-index') }}">Certified Checks</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Certified Check Details</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Create --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.certified_checks-create') }}" class="btn btn-dark">
                            <i data-feather="plus" class="fill-white feather-sm"></i> Add New
                        </a>
                    </div>
                    {{-- Edit --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.certified_checks-edit', isset($certifiedCheck->id) ? $certifiedCheck->id : -1) }}"
                            class="btn btn-secondary">
                            <i data-feather="edit" class="fill-white feather-sm"></i> Edit
                        </a>
                    </div>
                    {{-- Delete --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.certified_checks-softDelete', isset($certifiedCheck->id) ? $certifiedCheck->id : -1) }}"
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
                                    <div class="col-md-4">
                                        <div class="table-responsive">
                                            <table id="file_export_main_info_part_1"
                                                class="table table-striped table-bordered display">
                                                <thead>
                                                    {{-- id --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">REF :</th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($certifiedCheck->id) ? $certifiedCheck->id : '----' }}
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    {{-- check_number --}}
                                                    <tr>
                                                        <th style="background-color: aliceblue">Check No. :</th>
                                                        <td>
                                                            <strong>
                                                                {!! isset($certifiedCheck->check_number) ? $certifiedCheck->check_number : '-------' !!}
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    {{-- created_at --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue"> Added Since:</th>
                                                        <td>
                                                            <strong>{!! isset($certifiedCheck->created_at) ? $certifiedCheck->created_at->diffForHumans() : '-------' !!}</strong>
                                                        </td>
                                                    </tr>

                                                    {{-- created_at --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Addition Time:</th>
                                                        <td>
                                                            <strong>{!! isset($certifiedCheck->created_at) ? date('h:i A', strtotime($certifiedCheck->created_at)) : '-------' !!}</strong>
                                                        </td>
                                                    </tr>

                                                    {{-- created_at --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Addition Date:</th>
                                                        <td>
                                                            <strong>
                                                                {!! isset($certifiedCheck->created_at) ? date('d/M/Y', strtotime($certifiedCheck->created_at)) : '-------' !!}
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    {{-- status --}}
                                                    <tr>
                                                        <th style="background-color: aliceblue">Status :</th>
                                                        <td>
                                                            {{-- <strong>
                                                                {!! isset($certifiedCheck->status) ? $certifiedCheck->status : '-------' !!}
                                                            </strong> --}}

                                                            @if ($certifiedCheck->status === 'They Have (لديهم)')
                                                                <strong
                                                                    style="color: red">{{ $certifiedCheck->status ?? '----' }}</strong>
                                                            @elseif ($certifiedCheck->status === 'We Have (لدينا)')
                                                                <strong
                                                                    style="color: green">{{ $certifiedCheck->status ?? '----' }}</strong>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="col-md-8">
                                        <div class="table-responsive">
                                            <table id="file_export_status_team"
                                                class="table table-striped table-bordered display">
                                                <thead>

                                                    {{-- name_en --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Customer Name:
                                                        </th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($certifiedCheck->customer->name_en) ? $certifiedCheck->customer->name_en : '-------' }}
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    {{-- release_to --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Release To:</th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($certifiedCheck->release_to) ? $certifiedCheck->release_to : '-------' }}
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    {{-- amount --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Amount :</th>
                                                        <td>
                                                            <strong style="color: green">
                                                                {{ isset($certifiedCheck->amount) ? $certifiedCheck->amount : '-------' }}
                                                                JOD
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    {{-- release_date --}}
                                                    <tr>
                                                        <th style="background-color: aliceblue">Release Issue:</th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($certifiedCheck->release_date) ? $certifiedCheck->release_date : '-------' }}
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    {{-- reason_for_release --}}
                                                    <tr>
                                                        <th style="background-color: aliceblue">Reason For Release :</th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($certifiedCheck->reason_for_release) ? $certifiedCheck->reason_for_release : '-------' }}
                                                            </strong>
                                                        </td>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>

                                    {{-- image --}}
                                    <div class="col-md-12 groove-container glow">
                                        <div class="card mb-12">
                                            <div class="card-body">
                                                {{-- image --}}
                                                <div class="text-center">
                                                    @if (isset($certifiedCheck) && $certifiedCheck->image && file_exists($certifiedCheck->image))
                                                        <img src="{{ asset($certifiedCheck->image) }}" alt="Image"
                                                            height="750" width="800">
                                                    @else
                                                        <img src="{{ asset('style_files/images/notfound.png') }}"
                                                            alt="Image" class="img-thumbnail image-preview">
                                                    @endif
                                                </div>
                                            </div>
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
