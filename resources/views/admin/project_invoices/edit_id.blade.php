@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12">
                <h2 class="page-title">
                    <a href="{{ route('super_admin.projects-show', ['id' => $projectInvoice->project_id]) }}">
                        {{ isset($projectInvoice->project->name_en) ? $projectInvoice->project->name_en : null }}
                    </a>
                </h2>
            </div>
            <br>
            <div class="col-12">
                <h2 class="page-title">
                    <a href="{{ route('super_admin.projects-show', ['id' => $projectInvoice->project_id]) }}">
                        {{ isset($projectInvoice->project->name_ar) ? $projectInvoice->project->name_ar : null }}
                    </a>
                </h2>
            </div>
            <br>
            <div class="col-md-5 align-self-center">
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Update Update invoice ID</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Show --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.project_invoices-show', isset($projectInvoice->id) ? $projectInvoice->id : -1) }}"
                            class="btn btn-primary">
                            <i data-feather="eye" class="fill-white feather-sm"></i> View
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
                        <h4 class="card-title mb-3 pb-3 border-bottom">Update invoice ID :</h4>
                        <form
                            action="{{ route('super_admin.project_invoices-updateID', isset($projectInvoice->id) ? $projectInvoice->id : -1) }}"
                            method="POST" enctype="multipart/form-data" id="editForm">
                            @csrf
                            <div class="row">

                                {{-- id --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="id" min="1"
                                            class="form-control border border-info @error('id') border-danger @enderror"
                                            id="tb-id"
                                            value="{{ isset($projectInvoice->id) ? $projectInvoice->id : null }}"
                                            placeholder="ID">
                                        <label for="tb-id">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i> ID
                                            <strong class="text-danger">
                                                @error('id')
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
