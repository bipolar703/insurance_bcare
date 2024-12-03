@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Update Project Support Ticket Info</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.projects-index') }}">All Projects</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Update SalesTicket Info</li>
                        </ol>
                    </nav>
                </div>
            </div>
            {{-- <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.departments-create') }}" class="btn btn-dark">
                            <i data-feather="plus" class="fill-white feather-sm"></i> Add New Deaprtment
                        </a>
                    </div>
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.departments-show', isset($department->id) ? $department->id : -1) }}"
                            class="btn btn-primary">
                            <i data-feather="eye" class="fill-white feather-sm"></i> View Deaprtment
                        </a>
                    </div>
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.departments-activeInactiveSingle', isset($department->id) ? $department->id : -1) }}"
                            class="btn btn-warning">
                            @if (isset($department->status) && $department->status == 'Active')
                                <i data-feather="pause" class="fill-white feather-sm"></i> Set Inactive
                            @elseif(isset($department->status) && $department->status == 'Inactive')
                                <i data-feather="play" class="fill-white feather-sm"></i> Set Active
                            @endif
                        </a>
                    </div>
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.departments-softDelete', isset($department->id) ? $department->id : -1) }}"
                            class="confirm btn btn-danger">
                            <i data-feather="trash" class="fill-white feather-sm"></i> Delete Deaprtment
                        </a>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>

    {{-- ========================================================== --}}
    {{-- ==================== Page Body Section =================== --}}
    {{-- ========================================================== --}}
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3 pb-3 border-bottom">Update Project Support Ticket Info :</h4>
                        <form
                            action="{{ route('super_admin.project_support_tickets-update', isset($projectSupportTicket->id) ? $projectSupportTicket->id : -1) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">

                                {{-- title --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="title"
                                            class="form-control border border-info @error('title') border-danger @enderror"
                                            id="tb-title"
                                            value="{{ isset($projectSupportTicket->title) ? $projectSupportTicket->title : null }}"
                                            placeholder="Title">
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

                                {{-- date --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="date" name="date"
                                            class="form-control border border-info @error('date') border-danger @enderror"
                                            id="tb-name"
                                            value="{{ isset($projectSupportTicket->date) ? $projectSupportTicket->date : null }}"
                                            placeholder="Date">
                                        <label for="tb-name">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i> Date
                                            <strong class="text-danger">
                                                @error('date')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- project_id --}}
                                <input type="hidden" name="project_id" value="{{ $projectSupportTicket->project_id }}">



                                {{-- Description --}}
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label>Description : <strong class="text-danger">
                                                @error('description')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong></label>
                                        <textarea name="description" class="form-control border border-info @error('description') border-danger @enderror"
                                            rows="5" placeholder="Description">{{ isset($projectSupportTicket->description) ? $projectSupportTicket->description : null }}</textarea>
                                    </div>
                                </div>

                                {{-- Button --}}
                                <div class="col-12">
                                    <div class="d-md-flex align-items-center mt-3">
                                        <div class="ms-auto mt-3 mt-md-0">
                                            <button type="submit"
                                                class="btn btn-success font-weight-medium rounded-pill px-4">
                                                <div class="d-flex align-items-center">
                                                    <i data-feather="save" class="feather-sm fill-white me-2"></i>
                                                    Save Updates
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
        </div>
    </div>
@endsection

@section('extra_js')


@endsection
