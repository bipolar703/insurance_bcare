@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12">
                <h2 class="page-title">
                    <a href="{{ route('super_admin.projects-show', ['id' => $projectPayment->project_id]) }}">
                        {{ isset($projectPayment->project->name_en) ? $projectPayment->project->name_en : null }}
                    </a>
                </h2>
            </div>
            <br>
            <div class="col-12">
                <h2 class="page-title">
                    <a href="{{ route('super_admin.projects-show', ['id' => $projectPayment->project_id]) }}">
                        {{ isset($projectPayment->project->name_ar) ? $projectPayment->project->name_ar : null }}
                    </a>
                </h2>
            </div>
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Update Payment Info</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Update Payment Info</li>
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
            {{-- Left Section --}}
            <div class="col-lg-3 col-xlg-3 col-md-5">
                <div class="card">
                    <div class="card-body">
                        <center class="mt-4">

                            {{-- Image --}}
                            @if (isset($projectPayment->project->customer->image) &&
                                    $projectPayment->project->customer->image &&
                                    file_exists($projectPayment->project->customer->image))
                                <img src="{{ asset($projectPayment->project->customer->image) }}" class="rounded-circle"
                                    width="200" height="150" />
                            @else
                                <img src="{{ asset('style_files/shared/images_default/blueray_logo.jpg') }}"
                                    class="rounded-circle" width="150" />
                            @endif

                            {{-- id --}}
                            <h5 class="card-title mt-2">#REF
                                :{{ isset($projectPayment->id) ? $projectPayment->id : '-------' }}
                            </h5>
                            <hr>


                            {{-- name_en --}}
                            <h5 class="card-title mt-2">Project Name : <a
                                    href="{{ route('super_admin.projects-show', isset($projectPayment->project_id) ? $projectPayment->project_id : -1) }}">{{ isset($projectPayment->project->name_en) ? $projectPayment->project->name_en : '-------' }}
                                </a>
                            </h5>
                            <hr>

                            {{-- name_ar --}}
                            {{-- {{ dd($projectPayment->project->customer) }} --}}
                            {{-- @if ($projectPayment->project->customer)
                                <h6 class="card-title mt-2">Customer :
                                    <a
                                        href="{{ route('super_admin.customers-show', $projectPayment->project->customer->id) }}">
                                        {{ $projectPayment->project->customer->name_ar }}
                                    </a>
                                </h6>
                                <hr>
                            @else
                                <p>No customer associated with this project payment.</p>
                            @endif --}}

                            {{-- payment_amount --}}
                            <h5 class="card-title mt-2">Amount :<span style="color: black">
                                    {{ isset($projectPayment->payment_amount) ? $projectPayment->payment_amount : '-------' }}
                                    JOD</span> </h5>

                            {{-- payment_paid_amount --}}

                            <h5 class="card-title mt-2">Paid Amount :<span style="color: green">
                                    {{ isset($projectPayment->payment_paid_amount) ? $projectPayment->payment_paid_amount : '-------' }}
                                    JOD</span>
                            </h5>

                            {{-- payment_status --}}
                            <h5 class="card-title mt-2">Status:
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
                            </h5>


                        </center>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-xlg-9 col-md-7">
                {{-- Form Section --}}
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3 pb-3 border-bottom">Update Payment Info :</h4>
                        <form
                            action="{{ route('super_admin.project_payments-update', isset($projectPayment->id) ? $projectPayment->id : -1) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                {{-- payment_title --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="payment_title"
                                            class="form-control border border-info @error('payment_title') border-danger @enderror"
                                            id="tb-payment_title"
                                            value="{{ isset($projectPayment->payment_title) ? $projectPayment->payment_title : null }}"
                                            placeholder="Payment Title">
                                        <label for="tb-payment_title">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i> Payment
                                            Title
                                            <strong class="text-danger">
                                                @error('payment_title')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- payment_date --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="date" name="payment_date"
                                            class="form-control border border-info @error('payment_date') border-danger @enderror"
                                            id="tb-payment_date"
                                            value="{{ isset($projectPayment->payment_date) ? $projectPayment->payment_date : null }}"
                                            placeholder="Payment Date">
                                        <label for="tb-payment_date">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i> Payment
                                            Date
                                            <strong class="text-danger">
                                                @error('payment_date')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                <hr>
                                {{-- Description --}}
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label>Description : <strong class="text-danger">
                                                @error('payment_description')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong></label>
                                        <textarea name="payment_description"
                                            class="form-control border border-info @error('payment_description') border-danger @enderror" rows="5"
                                            placeholder="Description">{{ isset($projectPayment->payment_description) ? $projectPayment->payment_description : null }}</textarea>
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
                                                    Save Payment Updates
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
