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
                        href="{{ route('super_admin.projects-show', isset($projectSubscription->project->id) ? $projectSubscription->project->id : -1) }}">

                        <h2 class="page-title">
                            {{ isset($projectSubscription->project->name_en) ? $projectSubscription->project->name_en : '-------' }}
                        </h2>
                    </a>
                </div>

                <div col-md-12>
                    <a
                        href="{{ route('super_admin.projects-show', isset($projectSubscription->project->id) ? $projectSubscription->project->id : -1) }}">

                        <h2 class="page-title">
                            {{ isset($projectSubscription->project->name_ar) ? $projectSubscription->project->name_ar : '-------' }}
                        </h2>
                    </a>
                </div>

                <div class="col-md-5 align-self-center">
                    <div class="d-flex align-items-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item">
                                <a
                                    href="{{ route('super_admin.projects-show', isset($projectSubscription->project->id) ? $projectSubscription->project->id : -1) }}">
                                    Project
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Subscription Details </li>
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
                            <i class="bi bi-file-earmark-text"></i> Subscription Details
                        </a>
                    </li>

                    {{-- Tab 2 : Payments Info --}}
                    <li class="nav-item">
                        <a class="nav-link" id="tab_header_2" data-bs-toggle="pill" href="#tab_body_2" role="tab"
                            aria-controls="pills-profile" aria-selected="false">
                            <i class="bi bi-file-earmark-text"></i> Payments Details
                        </a>
                    </li>
                </ul>

                <div class="tab-content" id="pills-tabContent">
                    {{-- Tab One --}}
                    <div class="tab-pane fade show active" id="tab_body_1" role="tabpanel" aria-labelledby="tab_body_1">
                        {{-- <div class="card-body">
                            <div class="row gx-4">
                                <div class="col-md-6 mb-3">
                                    <strong>Project Name EN :</strong>
                                    <p class="text-muted d-inline"><strong style="color: black"> <a
                                                href="{{ route('super_admin.projects-show', optional($projectSubscription->project)->id) }}"
                                                class="text-primary">{{ optional($projectSubscription->project)->name_en ?? '-------' }}
                                            </a></strong></p>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <strong>Project Name AR :</strong>
                                    <p class="text-muted d-inline"><strong style="color: black"> <a
                                                href="{{ route('super_admin.projects-show', optional($projectSubscription->project)->id) }}"
                                                class="text-primary">{{ optional($projectSubscription->project)->name_ar ?? '-------' }}
                                            </a></strong></p>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <strong>Customer Name EN :</strong>
                                    <p class="text-muted d-inline"><strong style="color: black"> <a
                                                href="{{ route('super_admin.customers-show', optional($projectSubscription->project->customer)->id) }}"
                                                class="text-info">
                                                {{ optional($projectSubscription->project->customer)->name_en ?? '-------' }}
                                            </a></strong>
                                    </p>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <strong>Customer Name AR :</strong>
                                    <p class="text-muted d-inline"><strong style="color: black"> <a
                                                href="{{ route('super_admin.customers-show', optional($projectSubscription->project->customer)->id) }}"
                                                class="text-info">
                                                {{ optional($projectSubscription->project->customer)->name_ar ?? '-------' }}
                                            </a></strong>
                                    </p>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <strong>REF # :</strong>
                                    <p class="text-muted d-inline"><strong
                                            style="color: black">{{ $projectSubscription->id ?? '-------' }} </strong></p>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <strong>Amount:</strong>
                                    <p class="text-muted d-inline"><strong
                                            style="color: green">{{ $projectSubscription->payment_amount ?? '-------' }}
                                            JOD</p>
                                    </strong>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <strong>Subscription Due Date:</strong>
                                    <p class="text-muted d-inline">
                                        {{ isset($projectSubscription->started_from) ? \Carbon\Carbon::parse($projectSubscription->started_from)->format('d-m-Y') : '-------' }}
                                    </p>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <strong>Subscription Due Date:</strong>
                                    <p class="text-muted d-inline">
                                        {{ isset($projectSubscription->due_date) ? \Carbon\Carbon::parse($projectSubscription->due_date)->format('d-m-Y') : '-------' }}
                                    </p>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <strong>Plan Type:</strong>
                                    <p class="text-muted d-inline">{{ $projectSubscription->plan_type ?? '-------' }}</p>
                                    </strong>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <strong>Remaining Days:</strong>
                                    <p class="text-muted d-inline">
                                        @if (isset($projectSubscription->started_from) && isset($projectSubscription->due_date))
                                            <strong>
                                                {{ \Carbon\Carbon::parse($projectSubscription->due_date)->diffInDays(\Carbon\Carbon::parse($projectSubscription->started_from)) }}
                                                Days
                                            </strong>
                                        @else
                                            -----
                                        @endif
                                    </p>
                                    </strong>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <strong>Addition Time:</strong>
                                    <p class="text-muted d-inline"><strong>
                                            {!! optional($projectSubscription->created_at)->format('h:i A') ?? '-------' !!}
                                        </strong>
                                    </p>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <strong>Addition Date:</strong>
                                    <p class="text-muted d-inline"><strong>
                                            {!! optional($projectSubscription->created_at)->format('Y / F (m) / d') ?? '-------' !!}
                                        </strong>
                                    </p>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <strong>Added Since:</strong>
                                    <p class="text-muted d-inline"><strong>
                                            {!! optional($projectSubscription->created_at)->diffForHumans() ?? '-------' !!}
                                        </strong>
                                    </p>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <strong>Payment Status:</strong>
                                    <p class="text-muted d-inline">
                                        <strong>
                                            {!! $projectSubscription->payment_status ?? '-------' !!}
                                        </strong>
                                    </p>

                                </div>

                                <div class="col-md-6 mb-3">
                                    <strong>Payment Paid Amount:</strong>
                                    <p class="text-muted d-inline">
                                        {{ $projectSubscription->payment_paid_amount ?? '-------' }} JOD</p>
                                    </strong>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <strong>Payment Remaining Amount:</strong>
                                    <p class="text-muted d-inline">
                                        {{ $projectSubscription->payment_remaining_amount ?? '-------' }} JOD</p>
                                    </strong>
                                </div>
                                <hr>
                            </div>

                            <div class="row">
                                @if (isset($projectSubscription->description))
                                    <div class="col-md-12 mb-3">
                                        <strong>Description:</strong>
                                        <p class="text-muted mt-2">{{ $projectSubscription->description ?? '-------' }}</p>
                                    </div>
                                @endif

                                @if (isset($projectSubscription->transaction_other_note))
                                    <hr class="my-4">

                                    <div class="col-md-12 mb-3">
                                        <strong>Transaction Other Note:</strong>
                                        <p class="text-muted mt-2">
                                            {{ $projectSubscription->transaction_other_note ?? '-------' }}</p>
                                    </div>
                                @endif
                            </div>
                        </div> --}}

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
                                                        <strong
                                                            style="color: black">{{ $projectSubscription->id ?? '-------' }}
                                                        </strong>
                                                    </td>
                                                </tr>
                                                {{-- Payment Status: --}}
                                                <tr>
                                                    <th style="background-color:aliceblue">Payment Status:</th>
                                                    <td>
                                                        <strong>
                                                            {!! $projectSubscription->payment_status ?? '-------' !!}
                                                        </strong>
                                                    </td>
                                                </tr>

                                                {{--  AMOUNT --}}
                                                <tr>
                                                    <th style="background-color:aliceblue">Amount:
                                                    </th>
                                                    <td> <strong
                                                            style="color: green">{{ $projectSubscription->payment_amount ?? '-------' }}
                                                            JOD
                                                        </strong>
                                                    </td>
                                                </tr>

                                                {{--  Payment Paid Amount: --}}
                                                <tr>
                                                    <th style="background-color:aliceblue">Payment Paid Amount:
                                                    </th>
                                                    <td> <strong
                                                            style="color: green">{{ $projectSubscription->payment_paid_amount ?? '-------' }}
                                                            JOD
                                                        </strong>
                                                    </td>
                                                </tr>

                                                {{--  Payment Remaining Amount: --}}
                                                <tr>
                                                    <th style="background-color:aliceblue">Payment Remaining Amount:
                                                    </th>
                                                    <td> <strong
                                                            style="color: red">{{ $projectSubscription->payment_remaining_amount ?? '-------' }}
                                                            JOD
                                                        </strong>
                                                    </td>
                                                </tr>

                                                {{-- Subscription Due Date: --}}
                                                <tr>
                                                    <th style="background-color:aliceblue">Due Date:</th>
                                                    <td>
                                                        {{ isset($projectSubscription->started_from) ? \Carbon\Carbon::parse($projectSubscription->started_from)->format('d-m-Y') : '-------' }}
                                                    </td>
                                                </tr>

                                                {{-- Plan Type: --}}
                                                <tr>
                                                    <th style="background-color:aliceblue"> Plan Type:</th>
                                                    <td>
                                                        <strong>{{ $projectSubscription->plan_type ?? '-------' }}
                                                        </strong>
                                                    </td>
                                                </tr>

                                                {{-- Remaining Days: --}}
                                                <tr>
                                                    <th style="background-color:aliceblue">Remaining Days:</th>
                                                    <td>
                                                        @if (isset($projectSubscription->started_from) && isset($projectSubscription->due_date))
                                                            <strong>
                                                                {{ \Carbon\Carbon::parse($projectSubscription->due_date)->diffInDays(\Carbon\Carbon::parse($projectSubscription->started_from)) }}
                                                                Days
                                                            </strong>
                                                        @else
                                                            -----
                                                        @endif
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
                                                {{-- transaction --}}
                                                <tr>
                                                    <th style="background-color:aliceblue">Subscription Type :
                                                    </th>
                                                    <td>
                                                        <strong style="color: black"> <a
                                                                href="{{ route('super_admin.projects-show', optional($projectSubscription->project)->id) }}"
                                                                class="text-primary">{{ isset($projectSubscription->subscriptionType->title_en) && isset($projectSubscription->subscriptionType->title_ar) ? $projectSubscription->subscriptionType->title_en .' ( '.$projectSubscription->subscriptionType->title_ar .' )': '-------' }}
                                                            </a></strong>
                                                    </td>
                                                </tr>

                                                {{-- name_en --}}
                                                <tr>
                                                    <th style="background-color:aliceblue">Project Name EN :
                                                    </th>
                                                    <td>
                                                        <strong style="color: black"> <a
                                                                href="{{ route('super_admin.projects-show', optional($projectSubscription->project)->id) }}"
                                                                class="text-primary">{{ optional($projectSubscription->project)->name_en ?? '-------' }}
                                                            </a></strong>
                                                    </td>
                                                </tr>

                                                {{-- name_ar --}}
                                                <tr>
                                                    <th style="background-color:aliceblue">Project Name AR :
                                                    </th>
                                                    <td>
                                                        <strong style="color: black"> <a
                                                                href="{{ route('super_admin.projects-show', optional($projectSubscription->project)->id) }}"
                                                                class="text-primary">{{ optional($projectSubscription->project)->name_ar ?? '-------' }}
                                                            </a></strong>
                                                    </td>
                                                </tr>

                                                {{-- customer name_en --}}
                                                <tr>
                                                    <th style="background-color:aliceblue">Customer Name EN :
                                                    </th>
                                                    <td>
                                                        <strong style="color: black"> <a
                                                                href="{{ route('super_admin.customers-show', optional($projectSubscription->project->customer)->id) }}"
                                                                class="text-info">
                                                                {{ optional($projectSubscription->project->customer)->name_en ?? '-------' }}
                                                            </a></strong>
                                                    </td>
                                                </tr>

                                                {{-- customer name_ar --}}
                                                <tr>
                                                    <th style="background-color:aliceblue">Customer Name AR :
                                                    </th>
                                                    <td>
                                                        <strong style="color: black"> <a
                                                                href="{{ route('super_admin.customers-show', optional($projectSubscription->project->customer)->id) }}"
                                                                class="text-info">
                                                                {{ optional($projectSubscription->project->customer)->name_ar ?? '-------' }}
                                                            </a></strong>
                                                    </td>
                                                </tr>

                                                {{-- Addition Date: --}}
                                                <tr>
                                                    <th style="background-color:aliceblue">Addition Date:</th>
                                                    <td>
                                                        <strong> {!! optional($projectSubscription->created_at)->format('Y / F (m) / d') ?? '-------' !!} </strong>
                                                    </td>
                                                </tr>

                                                {{-- Added Since: --}}
                                                <tr>
                                                    <th style="background-color:aliceblue">Added Since:</th>
                                                    <td>
                                                        <strong> {!! optional($projectSubscription->created_at)->diffForHumans() ?? '-------' !!}</strong>
                                                    </td>
                                                </tr>

                                                {{-- Addition Time: --}}
                                                <tr>
                                                    <th style="background-color:aliceblue"> Addition Time:</th>
                                                    <td>
                                                        <strong>
                                                            {!! optional($projectSubscription->created_at)->format('h:i A') ?? '-------' !!}
                                                        </strong>
                                                    </td>
                                                </tr>

                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                @if (isset($projectSubscription->description))
                                    <div class="col-md-12 mb-3">
                                        <strong>Description:</strong>
                                        <p class="text-muted mt-2">{{ $projectSubscription->description ?? '-------' }}</p>
                                    </div>
                                @endif

                                @if (isset($projectSubscription->transaction_other_note))
                                    <hr class="my-4">

                                    <div class="col-md-12 mb-3">
                                        <strong>Transaction Other Note:</strong>
                                        <p class="text-muted mt-2">
                                            {{ $projectSubscription->transaction_other_note ?? '-------' }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Tab Two --}}
                    <div class="tab-pane fade show fade" id="tab_body_2" role="tabpanel" aria-labelledby="tab_body_2">

                        {{-- table --}}
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h2>Project Subscription Invoices:</h2>
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
                                        @if (isset($projectSubscription))
                                            @foreach ($projectSubscription->project->projectInvoices as $allProjectSubscription)
                                                {{-- {{dd($allProjectSubscription)}} --}}

                                                @if ($allProjectSubscription->subscription_id == $projectSubscription->id)
                                                    <tr>
                                                        <td>{{ $allProjectSubscription->id }}</td>
                                                        <td>{{ $allProjectSubscription->amount }} JOD</td>
                                                        <td>{{ $allProjectSubscription->payment_method }}</td>
                                                        <td>{{ $allProjectSubscription->invoice_due_date }}</td>
                                                        {{-- <td>{{ $allProjectSubscription->status }}</td> --}}
                                                        <td>
                                                            @if (isset($allProjectSubscription->status) && $allProjectSubscription->status == 'Paid')
                                                                <span
                                                                    style="color: green;"><strong>{{ isset($allProjectSubscription->status) ? $allProjectSubscription->status : '----' }}</strong></span>
                                                            @elseif(isset($allProjectSubscription->status) && $allProjectSubscription->status == 'Cancelled')
                                                                <span
                                                                    style="color: black;"><strong>{{ isset($allProjectSubscription->status) ? $allProjectSubscription->status : '----' }}</strong></span>
                                                            @elseif(isset($allProjectSubscription->status) && $allProjectSubscription->status == 'Hold')
                                                                <span
                                                                    style="color: orange;"><strong>{{ isset($allProjectSubscription->status) ? $allProjectSubscription->status : '----' }}</strong></span>
                                                            @elseif(isset($allProjectSubscription->status) && $allProjectSubscription->status == 'Open')
                                                                <span
                                                                    style="color: red;"><strong>{{ isset($allProjectSubscription->status) ? $allProjectSubscription->status : '----' }}</strong></span>
                                                            @else
                                                                {{ isset($allProjectSubscription->status) ? $allProjectSubscription->status : '----' }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($allProjectSubscription->status != 'Paid' && $allProjectSubscription->status != 'Cancelled')
                                                                <a href="{{ route('super_admin.project_invoices-editSubscriptionInvoiceFromShow', isset($allProjectSubscription->id) ? $allProjectSubscription->id : -1) }}"
                                                                    class="btn waves-effect waves-light btn-primary btn-sm"
                                                                    title="Edit Invoice">
                                                                    <i class="fa fa-pause"></i>
                                                                </a>
                                                            @endif

                                                            <a href="{{ route('super_admin.project_invoices-editID', ['id' => isset($allProjectSubscription->id) ? $allProjectSubscription->id : -1]) }}"
                                                                class="btn waves-effect waves-light btn-primary btn-sm"
                                                                title="View Details">
                                                                <i class="fa fa-id-badge"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endif
                                    </tbody>
                                    {{-- <tfoot>

                                        <tr>
                                            <th colspan="1">Total :</th>
                                            <th colspan="1"><span
                                                    style="color: green">{{ isset($totalInvoices) ? $totalInvoices . ' JOD' : '-------' }}</span>
                                            </th>
                                        </tr>

                                    </tfoot> --}}
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
@endsection
