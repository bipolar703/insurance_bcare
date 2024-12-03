@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <h2 class="page-title">{{ isset($lead->title) ? $lead->title : '-----' }} </h2>
            <div class="col-md-5 align-self-center">
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.leads-index') }}">All Leads</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Lead Details</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Create --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.leads-create') }}" class="btn btn-dark">
                            <i data-feather="plus" class="fill-white feather-sm"></i> Add New Lead
                        </a>
                    </div>
                    {{-- Edit --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.leads-edit', isset($lead->id) ? $lead->id : -1) }}"
                            class="btn btn-secondary">
                            <i data-feather="edit" class="fill-white feather-sm"></i> Edit Lead
                        </a>
                    </div>
                    {{-- Delete --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.leads-softDelete', isset($lead->id) ? $lead->id : -1) }}"
                            class="confirm btn btn-danger">
                            <i data-feather="trash" class="fill-white feather-sm"></i> Delete Lead
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
                        {{-- Tab 1 : Main Info --}}
                        <li class="nav-item">
                            <a class="nav-link active" id="tab_header_1" data-bs-toggle="pill" href="#tab_body_1"
                                role="tab" aria-controls="pills-profile" aria-selected="false"><strong>Main
                                    Info</strong></a>
                        </li>

                        {{-- Tab 2 : Transactions --}}
                        <li class="nav-item">
                            <a class="nav-link fade" id="tab_header_2" data-bs-toggle="pill" href="#tab_body_2"
                                role="tab" aria-controls="pills-profile" aria-selected="false"><strong>Transaction
                                </strong></a>
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
                                                                {{ isset($lead->id) ? $lead->id : '----' }}
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    {{-- status --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Status :</th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($lead->status) ? $lead->status : '----' }}
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    {{-- phone --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue"> Phone:</th>
                                                        <td>
                                                            <strong>{{ isset($lead->phone)  && isset($lead->country_phone_id) ? '(+'. $lead->countryPhoneKey->phone_code.') '. $lead->phone : '----' }}</strong>
                                                        </td>
                                                    </tr>

                                                    {{-- created_by --}}
                                                    <tr>
                                                        <th style="background-color: aliceblue">Created By:</th>
                                                        <td>
                                                            <strong>
                                                                {!! isset($lead->created_by) ? $lead->created_by : '-------' !!}
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    {{-- created_at --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue"> Added Since:</th>
                                                        <td>
                                                            <strong>{!! isset($lead->created_at) ? $lead->created_at->diffForHumans() : '-------' !!}</strong>
                                                        </td>
                                                    </tr>

                                                    {{-- created_at --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Addition Time:</th>
                                                        <td>
                                                            <strong>{!! isset($lead->created_at) ? date('h:i A', strtotime($lead->created_at)) : '-------' !!}</strong>
                                                        </td>
                                                    </tr>

                                                    {{-- created_at --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Addition Date:</th>
                                                        <td>
                                                            <strong>
                                                                {!! isset($lead->created_at) ? date('d/M/Y', strtotime($lead->created_at)) : '-------' !!}
                                                            </strong>
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

                                                    {{-- title --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Title:
                                                        </th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($lead->title) ? $lead->title : '-------' }}
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    {{-- email --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Email:</th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($lead->email) ? $lead->email : '-------' }}
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    {{-- authorized_signatory --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Authorized Signatory:</th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($lead->authorized_signatory) ? $lead->authorized_signatory : '-------' }}
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    {{-- employee_id --}}
                                                    <tr>
                                                        <th style="background-color: aliceblue">Employee:</th>
                                                        <td>
                                                            <strong>
                                                                <a
                                                                    href="{{ route('super_admin.employees-show', ['id' => isset($lead->employee_id) ? $lead->employee_id : '-------']) }}">
                                                                    {{ isset($lead->salesEmployee->name) ? $lead->salesEmployee->name : '-------' }}
                                                                </a>
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    {{-- country_id --}}
                                                    <tr>
                                                        <th style="background-color: aliceblue">Country:</th>
                                                        <td>
                                                            <strong>
                                                                @if (isset($lead->country_id))
                                                                    @foreach ($countries as $country)
                                                                        @if ($country->id == $lead->country_id)
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

                                                    {{-- city_id --}}
                                                    <tr>
                                                        <th style="background-color: aliceblue">City:</th>
                                                        <td>
                                                            <strong>
                                                                @if (isset($lead->city_id))
                                                                    @foreach ($states as $state)
                                                                        @if ($state->id == $lead->city_id)
                                                                            {{ $state->name_en }} ({{ $state->name_ar }})
                                                                        @endif
                                                                    @endforeach
                                                                @else
                                                                    -------
                                                                @endif
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    {{-- address --}}
                                                    <tr>
                                                        <th style="background-color: aliceblue">Address:</th>
                                                        <td>
                                                            <strong>
                                                                {!! isset($lead->address) ? $lead->address : '-------' !!}
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


                        {{-- Tab 2 Sales Lead Transactions --}}
                        <div class="tab-pane fade show fade" id="tab_body_2" role="tabpanel" aria-labelledby="tab_body_2">
                            <br>
                            <div class="col-12 groove-container">
                                {{-- Form Section --}}
                                <div class="card-header" style="background-color: aliceblue;">
                                    <strong>Add Lead Transaction :</strong>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <form
                                            action="{{ route('super_admin.lead_transactions-store', isset($lead->id) ? $lead->id : -1) }}"
                                            method="POST" id="createFormleadTransaction" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                {{-- title --}}
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" name="title" required
                                                            class="form-control border border-info @error('title') border-danger @enderror"
                                                            id="tb-title" value="{{ old('title') }}"
                                                            placeholder="Title">
                                                        <label for="tb-title">
                                                            <i data-feather="type"
                                                                class="feather-sm text-info fill-white me-2"></i>Title
                                                            <span>*</span>
                                                            <strong class="text-danger">
                                                                @error('title')
                                                                    ( {{ $message }} )
                                                                @enderror
                                                            </strong>
                                                        </label>
                                                    </div>
                                                </div>

                                                {{-- file --}}
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3">
                                                        <input type="file" name="file"
                                                            class="form-control border border-info @error('file') border-danger @enderror"
                                                            id="tb-file" value="{{ old('file') }}"
                                                            placeholder="File">
                                                        <label for="tb-file">
                                                            <i data-feather="type"
                                                                class="feather-sm text-info fill-white me-2"></i>File
                                                            <span>*</span>
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
                                                        <select name="lead_transaction_type"
                                                            class="form-control form-select border border-info @error('lead_transaction_type') border-danger @enderror custom_select_style">
                                                            <option>--- Choose Lead Transaction Type ---</option>
                                                            <option value="1"
                                                                @if (old('lead_transaction_type') == 1) selected @endif
                                                                @if (old('lead_transaction_type') == null) selected @endif>Call
                                                            </option>
                                                            <option value="2"
                                                                @if (old('lead_transaction_type') == 2) selected @endif>
                                                                Meeting </option>
                                                            <option value="3"
                                                                @if (old('lead_transaction_type') == 3) selected @endif>
                                                                Contract </option>
                                                        </select>
                                                    </div>
                                                </div>

                                                {{-- employee_id --}}
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <select name="employee_id" required id="employeeID"
                                                            class="form-control form-select border border-info @error('employee_id') border-danger @enderror custom_select_style"
                                                            style="width: 100%">
                                                            @if (isset($salesEmployees) && $salesEmployees->count() > 0)
                                                                <option value="">Select Employee <span>*</span>
                                                                </option>
                                                                @foreach ($salesEmployees as $salesEmployee)
                                                                    <option value="{{ $salesEmployee->id }}"
                                                                        @if (old('employee_id') == $salesEmployee->id) selected @endif>
                                                                        {{ isset($salesEmployee->name) ? $salesEmployee->name : '------' }}
                                                                    </option>
                                                                @endforeach
                                                            @else
                                                                <option value="">No Countries Are Available</option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>

                                                {{-- Description --}}
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label>Description : <strong class="text-danger">
                                                                @error('description')
                                                                    ( {{ $message }} )
                                                                @enderror
                                                            </strong></label>
                                                        <textarea name="description" class="form-control border border-info @error('description') border-danger @enderror"
                                                            rows="5" placeholder="Description">{{ old('description') }}</textarea>
                                                    </div>
                                                </div>

                                                {{-- lead_id --}}
                                                <input type="hidden" name="lead_id" value="{{ $lead->id }}">

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
                            @if (isset($lead->leadTransactions) && $lead->leadTransactions->count() > 0)
                                <div class="card-header" style="background-color: aliceblue;">
                                    <strong>
                                        <h3>Lead Transactions: </h3>
                                    </strong>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @if (isset($lead->leadTransactions))
                                            @foreach ($lead->leadTransactions as $leadTransaction)
                                                <div class="col-md-12">
                                                    <div class="card mb-4 shadow-sm groove-container">
                                                        <div class="card-body">
                                                            <h5 class="card-title">
                                                                <strong>Title:</strong>{{ isset($leadTransaction->title) ? $leadTransaction->title : '----' }}
                                                            </h5>
                                                            <p class="card-text"><strong>Employee:</strong>
                                                                {{ isset($leadTransaction->salesEmployee->name) ? $leadTransaction->salesEmployee->name : '----' }}
                                                            </p>

                                                            <p class="card-text"><strong>Attachment File:</strong>
                                                                <a href="{{ asset($leadTransaction->file) }}"
                                                                    class="view-file-link" target="_blank">
                                                                    View File
                                                                </a>
                                                            </p>

                                                            <p class="card-text"><strong>Created By:</strong>
                                                                {{ isset($leadTransaction->created_by) ? $leadTransaction->created_by : '----' }}
                                                            </p>

                                                            <p class="card-text"><strong>Transaction Type:</strong>
                                                                {{ isset($leadTransaction->lead_transaction_type) ? $leadTransaction->lead_transaction_type : '----' }}
                                                            </p>

                                                            <p class="card-text"><strong>Description:</strong>
                                                                {{ isset($leadTransaction->description) ? $leadTransaction->description : '----' }}
                                                            </p>
                                                            <div class="btn-group" role="group" aria-label="Controls">
                                                                <a href="{{ route('super_admin.lead_transactions-edit', isset($leadTransaction->id) ? $leadTransaction->id : -1) }}"
                                                                    class="btn btn-secondary btn-sm" title="Edit"><i
                                                                        class="fas fa-edit"></i>
                                                                </a>
                                                                <a href="{{ route('super_admin.lead_transactions-destroyTransactionLead', isset($leadTransaction->id) ? $leadTransaction->id : -1) }}"
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
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('extra_js')
    @endsection
