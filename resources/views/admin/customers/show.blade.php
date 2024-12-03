@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <h2 class="page-title">{{ isset($customer->name_en) ? $customer->name_en : '-----' }} </h2>
            <br>
            <h2 class="page-title">{{ isset($customer->name_ar) ? $customer->name_ar : '-----' }} </h2>
            <div class="col-md-5 align-self-center">
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.customers-index') }}">All Customers</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Customer Details</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Create --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.customers-create') }}" class="btn btn-dark">
                            <i data-feather="plus" class="fill-white feather-sm"></i> Add New Customer
                        </a>
                    </div>
                    {{-- Edit --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.customers-edit', isset($customer->id) ? $customer->id : -1) }}"
                            class="btn btn-secondary">
                            <i data-feather="edit" class="fill-white feather-sm"></i> Edit Customer
                        </a>
                    </div>
                    {{-- Delete --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.customers-softDelete', isset($customer->id) ? $customer->id : -1) }}"
                            class="confirm btn btn-danger">
                            <i data-feather="trash" class="fill-white feather-sm"></i> Delete Customer
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
                            @if (isset($customer->image) && $customer->image && file_exists($customer->image))
                                <img src="{{ asset($customer->image) }}" class="rounded-circle" width="200"
                                    height="150" />
                            @else
                                <img src="{{ asset('style_files/shared/images_default/blueray_logo.jpg') }}"
                                    class="rounded-circle" width="150" />
                            @endif

                            {{-- name_en --}}
                            <h5 class="card-title mt-2"> {{ isset($customer->name_en) ? $customer->name_en : '-------' }}
                            </h5>
                            <hr>

                            <h5 class="card-title mt-2">Remaining : <span
                                    style="color: red">{{ isset($totalRemainingAmount) ? $totalRemainingAmount : 'Not set' }}
                                    JOD
                                </span></h5>

                            <h5 class="card-title mt-2">Paid: <span
                                    style="color:Green">{{ isset($totalAmountCollected) ? $totalAmountCollected : 'Not set' }}
                                    JOD
                                </span>
                            </h5>
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
                                role="tab" aria-controls="pills-profile" aria-selected="false"><strong>Projects</strong>
                            </a>
                        </li>

                        {{-- Tab 3 : Invoices --}}
                        <li class="nav-item">
                            <a class="nav-link fade" id="tab_header_3" data-bs-toggle="pill" href="#tab_body_3"
                                role="tab" aria-controls="pills-profile" aria-selected="false"><strong>Invoices</strong>
                            </a>
                        </li>

                        {{-- Tab 4 : Contacts --}}
                        <li class="nav-item">
                            <a class="nav-link fade" id="tab_header_4" data-bs-toggle="pill" href="#tab_body_4"
                                role="tab" aria-controls="pills-profile"
                                aria-selected="false"><strong>Contacts</strong></a>
                        </li>
                    </ul>

                    <div class="tab-content" id="pills-tabContent">
                        {{-- Tab One --}}
                        <div class="tab-pane fade show active" id="tab_body_1" role="tabpanel" aria-labelledby="tab_body_1">
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
                                                                {{ isset($customer->id) ? $customer->id : '----' }}
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    {{-- status --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Status :</th>
                                                        <td>
                                                            <strong>
                                                                @if (isset($customer->status) && $customer->status == 'Active')
                                                                    <span
                                                                        style="color: green;"><strong>{{ isset($customer->status) ? $customer->status : '----' }}</strong></span>
                                                                @else
                                                                    <span style="color: red">
                                                                        <strong>
                                                                            {{ isset($customer->status) ? $customer->status : '----' }}
                                                                        </strong>
                                                                    </span>
                                                                @endif
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    {{-- phone --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue"> Phone:</th>
                                                        <td>
                                                            <strong>{{ isset($customer->phone) && isset($customer->country_phone_id) ? '(+'. $customer->countryPhoneKey->phone_code.') '.$customer->phone : (isset($customer->phone) ? $customer->phone : '---------') }}</strong>
                                                        </td>
                                                    </tr>

                                                    {{-- created_at --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue"> Added Since:</th>
                                                        <td>
                                                            <strong>{!! isset($customer->created_at) ? $customer->created_at->diffForHumans() : '-------' !!}</strong>
                                                        </td>
                                                    </tr>

                                                    {{-- created_at --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Addition Time:</th>
                                                        <td>
                                                            <strong>{!! isset($customer->created_at) ? date('h:i A', strtotime($customer->created_at)) : '-------' !!}</strong>
                                                        </td>
                                                    </tr>

                                                    {{-- created_at --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Addition Date:</th>
                                                        <td>
                                                            <strong>
                                                                {!! isset($customer->created_at) ? date('d/M/Y', strtotime($customer->created_at)) : '-------' !!}
                                                            </strong>
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

                                                    {{-- name_en --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Name EN:
                                                        </th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($customer->name_en) ? $customer->name_en : '-------' }}
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    {{-- name_ar --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Name AR:</th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($customer->name_ar) ? $customer->name_ar : '-------' }}
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    {{-- email --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Email:</th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($customer->email) ? $customer->email : '-------' }}
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    {{-- authorized_signatory --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Authorized Signatory:</th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($customer->authorized_signatory) ? $customer->authorized_signatory : '-------' }}
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th style="background-color: aliceblue">Address:</th>
                                                        <td>
                                                            <strong>
                                                                {!! isset($customer->address) ? $customer->address : '-------' !!}
                                                            </strong>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="background-color: aliceblue">No.Of Projects:</th>
                                                        <td>
                                                            <strong>
                                                                {!! isset($customer->projects) ? $customer->projects->count() : '-------' !!}
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

                        {{-- tab 2 --}}
                        <div class="tab-pane fade show fade" id="tab_body_2" role="tabpanel"
                            aria-labelledby="tab_body_2">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="file_export" class="table table-striped table-bordered display">
                                        <thead>
                                            <tr>
                                                <th>#REF</th>
                                                <th>Name EN</th>
                                                <th>Type</th>
                                                <th>Total Contract</th>
                                                <th>Status</th>
                                                <th>Controls</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (isset($customer->projects) && count($customer->projects) > 0)
                                                @foreach ($customer->projects as $project)
                                                    <tr>
                                                        {{-- REF --}}
                                                        <td>{{ isset($project->id) ? $project->id : '----' }}</td>

                                                        {{-- name_en --}}
                                                        <td>
                                                            <a
                                                                href="{{ route('super_admin.projects-show', isset($project->id) ? $project->id : '-1') }}">
                                                                <strong>
                                                                    {{ isset($project->name_en) ? $project->name_en : '----' }}
                                                                </strong>
                                                            </a>
                                                        </td>

                                                        {{-- type --}}
                                                        <td>{{ isset($project->type) ? $project->type : '-----' }}</td>

                                                        {{-- total_contracts --}}
                                                        <td style="color: green">
                                                            <strong>{{ isset($project->total_contracts) ? $project->total_contracts : '-----' }}
                                                                JOD </strong>
                                                        </td>

                                                        {{-- status --}}
                                                        <td>
                                                            @if (isset($project->status) && $project->status == 'Completed')
                                                                <span
                                                                    style="color: green;"><strong>{{ $project->status }}</strong></span>
                                                            @elseif(isset($project->status) && $project->status == 'Hold')
                                                                <span
                                                                    style="color: red;"><strong>{{ $project->status }}</strong></span>
                                                            @elseif(isset($project->status) && $project->status == 'In Queue')
                                                                <span
                                                                    style="color: orange;"><strong>{{ $project->status }}</strong></span>
                                                            @else
                                                                {{ isset($project->status) ? $project->status : '----' }}
                                                            @endif
                                                        </td>

                                                        <td>
                                                            <div class="button-group">
                                                                <a href="{{ route('super_admin.projects-show', ['id' => isset($project->id) ? $project->id : -1]) }}"
                                                                    class="btn waves-effect waves-light btn-primary btn-sm"
                                                                    title="View Details"><i class="fas fa-eye"></i></a>

                                                                <a href="{{ route('super_admin.projects-edit', isset($project->id) ? $project->id : -1) }}"
                                                                    class="btn waves-effect waves-light btn-secondary btn-sm"
                                                                    title="Edit"><i class="fas fa-edit"></i></a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                        <tfoot>
                                            @if ($customer->projects->count() > 0)
                                                @if (isset($totalContracts))
                                                    <tr>
                                                        <th colspan="3">Total :</th>
                                                        <th colspan="2"><span
                                                                style="color: green">{{ isset($totalContracts) ? $totalContracts . ' JOD' : '-------' }}</span>
                                                        </th>
                                                    </tr>
                                                @endif
                                            @endif
                                        </tfoot>
                                    </table>
                                    <hr class="mt-5">
                                </div>
                            </div>
                        </div>

                        {{-- tab 3 --}}
                        <div class="tab-pane fade show fade" id="tab_body_3" role="tabpanel"
                            aria-labelledby="tab_body_3">
                            <div class="card-body">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="table-responsive">
                                                <table id="file_export_main_info_part_1"
                                                    class="table table-striped table-bordered display">
                                                    <thead>
                                                        {{-- totalInvoices --}}
                                                        <tr>
                                                            <th style="background-color:aliceblue">All Invoices Total:</th>
                                                            <td>
                                                                <strong>
                                                                    {{ isset($totalInvoices) ? $totalInvoices : '-------' }}
                                                                    JOD
                                                                </strong>
                                                            </td>
                                                        </tr>

                                                        {{-- Income Total (Paid): --}}
                                                        <tr>
                                                            <th style="background-color:aliceblue">Income Total (Paid):
                                                            </th>
                                                            <td>
                                                                <strong style="color: green">
                                                                    {{ isset($totalAmountCollected) ? $totalAmountCollected : '-------' }}
                                                                    JOD
                                                                </strong>
                                                            </td>
                                                        </tr>

                                                        {{-- Cancelled Invoices: --}}
                                                        <tr>
                                                            <th style="background-color:aliceblue"> Cancelled Invoices:
                                                            </th>
                                                            <td>
                                                                <strong>{{ isset($totalCancelledAmount) ? $totalCancelledAmount : '-------' }}
                                                                    JOD</strong>
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

                                                        {{-- Remaining Contracts: --}}
                                                        <tr>
                                                            <th style="background-color:aliceblue">Remaining Contracts:
                                                            </th>
                                                            <td>
                                                                <strong style="color: red">
                                                                    {{ isset($project->remaining_contracts) ? $project->remaining_contracts : '-------' }}
                                                                    JOD
                                                                </strong>
                                                            </td>
                                                        </tr>

                                                        {{-- Open Invoices Total: --}}
                                                        <tr>
                                                            <th style="background-color:aliceblue">Open Invoices Total:
                                                            </th>
                                                            <td>
                                                                <strong>
                                                                    {{ isset($totalOpenAmount) ? $totalOpenAmount : '-------' }}
                                                                    JOD
                                                                </strong>
                                                            </td>
                                                        </tr>

                                                        {{-- Total Contracts: --}}
                                                        <tr>
                                                            <th style="background-color:aliceblue">Total Contracts:</th>
                                                            <td>
                                                                <strong>
                                                                    {{ isset($totalContracts) ? $totalContracts : '-------' }}
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
                                @if (isset($customer->projectInvoices) && count($customer->projectInvoices) > 0)
                                    <div class="table-responsive">
                                        <table id="file_export_invoices"
                                            class="table table-striped table-bordered display">
                                            <thead>
                                                <tr>
                                                    <th>#REF</th>
                                                    <th>Project</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                    <th>Controls</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (isset($customer->projectInvoices) && count($customer->projectInvoices) > 0)
                                                    @foreach ($customer->projectInvoices as $projectInvoice)
                                                        @if ($projectInvoice->project_invoice_type == 'Contract')
                                                            <tr>
                                                                <td>{{ isset($projectInvoice->id) ? $projectInvoice->id : '----' }}
                                                                </td>

                                                                <td>
                                                                    <a
                                                                        href="{{ route('super_admin.projects-show', ['id' => $projectInvoice->project->id]) }}">
                                                                        <strong>
                                                                            {{ isset($projectInvoice->project->name_en) ? $projectInvoice->project->name_en : '----' }}
                                                                        </strong>
                                                                    </a>
                                                                </td>

                                                                <td>{{ isset($projectInvoice->amount) ? $projectInvoice->amount : '----' }}
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
                                                                            title="View Details"><i
                                                                                class="fas fa-eye"></i>
                                                                        </a>

                                                                        @if ($projectInvoice->status != 'Paid')
                                                                            <a href="{{ route('super_admin.project_invoices-editInvoiceFromShow', isset($projectInvoice->id) ? $projectInvoice->id : -1) }}"
                                                                                class="btn waves-effect waves-light btn-secondary btn-sm"
                                                                                title="Edit"><i class="fas fa-edit"></i>
                                                                            </a>
                                                                        @endif
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="2">Total Invoices :</th>
                                                    <th colspan="2"><span
                                                            style="color: green">{{ isset($totalInvoices) ? $totalInvoices . ' JOD' : '-------' }}</span>
                                                    </th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- tab 4 --}}
                        <div class="tab-pane fade show fade" id="tab_body_4" role="tabpanel"
                            aria-labelledby="tab_body_4">
                            <div class="card-body">

                                <form action="{{ route('super_admin.customers-storeCustomerContacts', $customer->id) }}"
                                    method="POST" enctype="multipart/form-data" id="createForm">
                                    @csrf
                                    <input type="hidden" name="customer_id" value="{{ $customer->id }}">

                                    <div class="row">
                                        {{-- name --}}
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3">
                                                <input type="text" name="name"
                                                    class="form-control border border-info @error('name') border-danger @enderror"
                                                    id="tb-name" value="{{ old('name') }}" placeholder="Name">
                                                <label for="tb-name">
                                                    <i data-feather="type"
                                                        class="feather-sm text-info fill-white me-2"></i>
                                                    Name
                                                    <strong class="text-danger">
                                                        @error('name')
                                                            ( {{ $message }} )
                                                        @enderror
                                                    </strong>
                                                </label>
                                            </div>
                                        </div>

                                        {{-- position --}}
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3">
                                                <input type="text" name="position"
                                                    class="form-control border border-info @error('position') border-danger @enderror"
                                                    id="tb-position" value="{{ old('position') }}"
                                                    placeholder="Position">
                                                <label for="tb-position">
                                                    <i data-feather="type"
                                                        class="feather-sm text-info fill-white me-2"></i>
                                                    Position
                                                    <strong class="text-danger">
                                                        @error('position')
                                                            ( {{ $message }} )
                                                        @enderror
                                                    </strong>
                                                </label>
                                            </div>
                                        </div>

                                        {{-- phone --}}
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3">
                                                <input type="tel" name="phone"
                                                    class="form-control border border-info @error('phone') border-danger @enderror"
                                                    id="tb-phone" value="{{ old('phone') }}" placeholder="Phone">
                                                <label for="tb-phone">
                                                    <i data-feather="type"
                                                        class="feather-sm text-info fill-white me-2"></i>
                                                    Phone
                                                    <strong class="text-danger">
                                                        @error('phone')
                                                            ( {{ $message }} )
                                                        @enderror
                                                    </strong>
                                                </label>
                                            </div>
                                        </div>

                                        {{-- email --}}
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3">
                                                <input type="email" name="email"
                                                    class="form-control border border-info @error('email') border-danger @enderror"
                                                    id="tb-email" value="{{ old('email') }}" placeholder="Email">
                                                <label for="tb-email">
                                                    <i data-feather="type"
                                                        class="feather-sm text-info fill-white me-2"></i>
                                                    Email
                                                    <strong class="text-danger">
                                                        @error('email')
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
                                                            <i data-feather="plus" class="feather-sm fill-white me-2"></i>
                                                            Add New Customer Contact
                                                        </div>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            @if (isset($customer->customerContacts) && count($customer->customerContacts) > 0)
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="file_export_contacts"
                                            class="table table-striped table-bordered display">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Position</th>
                                                    <th>Phone</th>
                                                    <th>Email</th>
                                                    <th>Controls</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (isset($customer->customerContacts) && count($customer->customerContacts) > 0)
                                                    @foreach ($customer->customerContacts as $customerContact)
                                                        <tr>
                                                            <td>{{ isset($customerContact->name) ? $customerContact->name : '----' }}
                                                            </td>
                                                            <td>{{ isset($customerContact->position) ? $customerContact->position : '----' }}
                                                            </td>
                                                            <td>{{ isset($customerContact->phone) ? $customerContact->phone : '----' }}
                                                                
                                                            </td>
                                                            <td>{{ isset($customerContact->email) ? $customerContact->email : '----' }}
                                                            </td>
                                                            <td>
                                                                <div>
                                                                    <a href="{{ route('super_admin.customers-editCustomerContact', isset($customerContact->id) ? $customerContact->id : -1) }}"
                                                                        class="btn waves-effect waves-light btn-secondary btn-sm"
                                                                        title="Edit"><i class="fas fa-edit"></i>
                                                                    </a>
                                                                    <a href="{{ route('super_admin.customers-destroy', isset($customerContact->id) ? $customerContact->id : -1) }}"
                                                                        class="btn waves-effect waves-light btn-danger btn-sm"
                                                                        title="Destroy"
                                                                        onclick="return confirm('Are you sure you want to delete this record?');">
                                                                        <i class="fas fa-trash"></i>
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
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

        <script>
            $(document).ready(function() {
                // Function to initialize DataTable with buttons
                function initializeDataTable(tableId, classes) {
                    if (!$.fn.DataTable.isDataTable(tableId)) {
                        $(tableId).DataTable({
                            dom: 'Bfrtip',
                            buttons: [{
                                    extend: 'copy',
                                    className: classes
                                },
                                {
                                    extend: 'csv',
                                    className: classes
                                },
                                {
                                    extend: 'excel',
                                    className: classes
                                },
                                {
                                    extend: 'pdf',
                                    className: classes
                                },
                                {
                                    extend: 'print',
                                    className: classes
                                }
                            ]
                        });
                    }
                }

                // Initialize DataTable for Projects tab on document load
                initializeDataTable('#file_export', 'btn btn-primary'); // Define button classes for Tab 2

                // Event listener for when the Invoices tab is shown
                $('a[data-bs-toggle="pill"]').on('shown.bs.tab', function(e) {
                    var targetTab = $(e.target).attr('href'); // Get the target tab href

                    // Check if the target tab is the Invoices tab
                    if (targetTab === '#tab_body_3') {
                        initializeDataTable('#file_export_invoices',
                            'btn btn-secondary'); // Define button classes for Tab 3
                    }
                });
            });
        </script>
    @endsection
