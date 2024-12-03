@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <nav aria-label="breadcrumb">
                <div col-md-12>
                    <a
                        href="{{ route('super_admin.projects-show', isset($projectInvoice->project->id) ? $projectInvoice->project->id : -1) }}">

                        <h2 class="page-title">
                            {{ isset($projectInvoice->project->name_en) ? $projectInvoice->project->name_en : '-------' }}
                        </h2>
                    </a>
                </div>

                <div col-md-12>
                    <a
                        href="{{ route('super_admin.projects-show', isset($projectInvoice->project->id) ? $projectInvoice->project->id : -1) }}">

                        <h2 class="page-title">
                            {{ isset($projectInvoice->project->name_ar) ? $projectInvoice->project->name_ar : '-------' }}
                        </h2>
                    </a>
                </div>

                <div class="col-md-5 align-self-center">
                    <div class="d-flex align-items-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item">
                                <a
                                    href="{{ route('super_admin.projects-show', isset($projectInvoice->project->id) ? $projectInvoice->project->id : -1) }}">
                                    Project
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Invoice Details </li>
                        </ol>
            </nav>
        </div>
    </div>

    {{-- ========================================================== --}}
    {{-- ==================== Page Body Section =================== --}}
    {{-- ========================================================== --}}
    <div class="container-fluid">
        <div class="row">
            <div class="card">
                {{-- Tabs Header Section --}}
                <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
                    {{-- Tab 1 : Main Info --}}
                    <li class="nav-item">
                        <a class="nav-link active" id="tab_header_1" data-bs-toggle="pill" href="#tab_body_1" role="tab"
                            aria-controls="pills-profile" aria-selected="false">
                            <i class="bi bi-file-earmark-text"></i> Receipt File
                        </a>
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
                                                        <strong style="color: black">{{ $projectInvoice->id ?? '-------' }}
                                                        </strong>
                                                    </td>
                                                </tr>

                                                {{-- Status: --}}
                                                <tr>
                                                    <th style="background-color:aliceblue">Status:</th>
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
                                                            <p class="text-muted d-inline font-weight-bold"
                                                                style="color: black;">
                                                                <strong>----</strong>
                                                            </p>
                                                        @endif
                                                    </td>
                                                </tr>

                                                {{--  AMOUNT --}}
                                                <tr>
                                                    <th style="background-color:aliceblue">Amount:
                                                    </th>
                                                    <td> <strong
                                                            style="color: green">{{ $projectInvoice->amount ?? '-------' }}
                                                            JOD
                                                        </strong>
                                                    </td>
                                                </tr>

                                                {{--  Payment Paid Amount: --}}
                                                @if (isset($projectInvoice->check_due_date))
                                                    <tr>
                                                        <th style="background-color:aliceblue">Check Due Date:
                                                        </th>
                                                        <td> <strong>
                                                                {{ isset($projectInvoice->check_due_date) ? \Carbon\Carbon::parse($projectInvoice->check_due_date)->format('d-m-y') : '-------' }}
                                                            </strong>
                                                        </td>
                                                    </tr>
                                                @endif

                                                {{--  invoice_due_date --}}
                                                <tr>
                                                    <th style="background-color:aliceblue">Due Date:
                                                    </th>
                                                    <td> <strong>
                                                            {{ isset($projectInvoice->invoice_due_date) ? \Carbon\Carbon::parse($projectInvoice->invoice_due_date)->format('d/m/Y') : '-------' }}
                                                        </strong>
                                                    </td>
                                                </tr>

                                                {{-- Payment Method: --}}
                                                <tr>
                                                    <th style="background-color:aliceblue">Payment Method:</th>
                                                    <td>
                                                        {{ $projectInvoice->payment_method ?? '-------' }}
                                                    </td>
                                                </tr>

                                                {{-- type: --}}
                                                <tr>
                                                    <th style="background-color:aliceblue">Type:</th>
                                                    <td>
                                                        {{ $projectInvoice->project_invoice_type ?? '-------' }}
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
                                                    <th style="background-color:aliceblue">Project Name EN :
                                                    </th>
                                                    <td>
                                                        <strong style="color: black"> <a
                                                                href="{{ route('super_admin.projects-show', optional($projectInvoice->project)->id) }}"
                                                                class="text-primary">{{ optional($projectInvoice->project)->name_en ?? '-------' }}
                                                            </a></strong>
                                                    </td>
                                                </tr>

                                                {{-- customer name_en --}}
                                                <tr>
                                                    <th style="background-color:aliceblue">Customer Name EN :
                                                    </th>
                                                    <td>
                                                        <strong style="color: black"> <a
                                                                href="{{ route('super_admin.customers-show', optional($projectInvoice->project->customer)->id) }}"
                                                                class="text-info">
                                                                {{ optional($projectInvoice->project->customer)->name_en ?? '-------' }}
                                                            </a></strong>
                                                    </td>
                                                </tr>

                                                {{-- customer name_ar --}}
                                                <tr>
                                                    <th style="background-color:aliceblue">Customer Name AR :
                                                    </th>
                                                    <td>
                                                        <strong style="color: black"> <a
                                                                href="{{ route('super_admin.customers-show', optional($projectInvoice->project->customer)->id) }}"
                                                                class="text-info">
                                                                {{ optional($projectInvoice->project->customer)->name_ar ?? '-------' }}
                                                            </a></strong>
                                                    </td>
                                                </tr>

                                                {{-- Addition Date: --}}
                                                <tr>
                                                    <th style="background-color:aliceblue">Addition Date:</th>
                                                    <td>
                                                        <strong> {!! optional($projectInvoice->created_at)->format('Y / F (m) / d') ?? '-------' !!} </strong>
                                                    </td>
                                                </tr>

                                                {{-- Added Since: --}}
                                                <tr>
                                                    <th style="background-color:aliceblue">Added Since:</th>
                                                    <td>
                                                        <strong> {!! optional($projectInvoice->created_at)->diffForHumans() ?? '-------' !!}</strong>
                                                    </td>
                                                </tr>

                                                {{-- Addition Time: --}}
                                                <tr>
                                                    <th style="background-color:aliceblue"> Addition Time:</th>
                                                    <td>
                                                        <strong>
                                                            {!! optional($projectInvoice->created_at)->format('h:i A') ?? '-------' !!}
                                                        </strong>
                                                    </td>
                                                </tr>

                                            </thead>
                                        </table>
                                    </div>
                                </div>


                                @if (isset($projectInvoice->note))
                                    <div class="col-md-12 bordered">
                                        <div class="card border-primary mb-3">
                                            <div class="card-header" style="background-color: aliceblue;">
                                                <strong>Note</strong>
                                            </div>
                                            <div class="card-body">
                                                <p class="card-text text-muted">{{ $projectInvoice->note }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($projectInvoice->receipt_file) && $projectInvoice->receipt_file && file_exists($projectInvoice->receipt_file))
                                    <div class="col-md-12">
                                        <div class="card border-primary mb-3">
                                            <div class="card-header" style="background-color: aliceblue;">
                                                <h2>Receipt File</h2>
                                            </div>
                                            <div class="card-body">
                                                <a href="{{ asset($projectInvoice->receipt_file) }}" target="_blank"
                                                    class="btn btn-outline-primary">
                                                    <i class="bi bi-file-text"></i> Open Receipt File
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('extra_js')
    @endsection
