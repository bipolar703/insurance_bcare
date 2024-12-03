@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <h2 class="page-title">
                {{ isset($leadTransaction->title) ? $leadTransaction->title : '-----' }}
            </h2>

            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Update Info</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.leads-index') }}">All Leads</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Update Lead Transaction Info</li>
                        </ol>
                    </nav>
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
                        <h4 class="card-title mb-3 pb-3 border-bottom">Update Leads Info :</h4>
                        <form
                            action="{{ route('super_admin.lead_transactions-update', isset($leadTransaction->id) ? $leadTransaction->id : -1) }}"
                            method="POST" enctype="multipart/form-data" id="editForm">
                            @csrf
                            <div class="row">

                                {{-- title --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="title"
                                            class="form-control border border-info @error('title') border-danger @enderror"
                                            id="tb-title"
                                            value="{{ isset($leadTransaction->title) ? $leadTransaction->title : null }}"
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

                                {{-- lead_transaction_type --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                            <select name="lead_transaction_type"
                                                class="form-control form-select border border-info @error('lead_transaction_type') border-danger @enderror custom_select_style">
                                                <option>--- Select Lead Transaction Type ---</option>
                                                <option value="1" @if ($leadTransaction->lead_transaction_type == 'Call') selected @endif
                                                    @if ($leadTransaction->lead_transaction_type == null) selected @endif>Call</option>
                                                <option value="2" @if ($leadTransaction->lead_transaction_type == 'Meeting') selected @endif>
                                                    Meeting </option>
                                                <option value="3" @if ($leadTransaction->lead_transaction_type == 'Contract') selected @endif>
                                                    Contract </option>
                                            </select>

                                            <label for="tb-name">
                                                <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                                Lead Transaction Type
                                                <strong class="text-danger">
                                                    @error('status')
                                                        ( {{ $message }} )
                                                    @enderror
                                                </strong>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                {{-- file --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="file" name="file"
                                            class="form-control border border-info @error('file') border-danger @enderror"
                                            id="tb-file"
                                            value="{{ isset($leadTransaction->file) ? $leadTransaction->file : null }}"
                                            placeholder="file">
                                        <label for="tb-file">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i> File
                                            <strong class="text-danger">
                                                @error('file')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- employee_id --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                            <select name="employee_id" id="employeeID"
                                                class="form-control form-select border border-info @error('employee_id') border-danger @enderror custom_select_style">
                                                @if (isset($salesEmployees) && $salesEmployees->count() > 0)
                                                    @foreach ($salesEmployees as $salesEmployee)
                                                        <option value="{{ $salesEmployee->id }}"
                                                            @if ($salesEmployee->id == $leadTransaction->employee_id) selected @endif>
                                                            {{ $salesEmployee->name ?? '------' }}
                                                        </option>
                                                    @endforeach
                                                @else
                                                    <option value="">
                                                        No Employees Please Check With Admin
                                                    </option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                {{-- description --}}
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label>Description : <strong class="text-danger">
                                                @error('description')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong></label>
                                        <textarea name="description" class="form-control border border-info @error('description') border-danger @enderror"
                                            rows="5" placeholder="description">{{ isset($leadTransaction->description) ? $leadTransaction->description : null }}</textarea>
                                    </div>
                                </div>

                                <input type="hidden" name="lead_id" value="{{ isset($leadTransaction->lead_id) ? $leadTransaction->lead_id : null }}">


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
    {{-- passed the test in https://validatejavascript.com/  using custom JS config --}}
    {{-- select 2 script --}}
    <script>
        $(document).ready(function() {
            $('select[name="employee_id"]').select2();
        });
    </script>
@endsection
