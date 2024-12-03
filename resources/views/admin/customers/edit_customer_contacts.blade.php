@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Update Customer Info</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.customers-index') }}">All Customers</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Update Customer Contact Info</li>
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
                            @if (isset($customer->image) && $customer->image && file_exists($customer->image))
                                <img src="{{ asset($customer->image) }}" class="rounded-circle" width="200"
                                    height="150" />
                            @else
                                <img src="{{ asset('style_files/shared/images_default/blueray_logo.jpg') }}"
                                    class="rounded-circle" width="150" />
                            @endif

                            {{-- name_en --}}
                            <h5 class="card-title mt-2"><a
                                    href="{{ route('super_admin.customers-show', isset($customer->id) ? $customer->id : -1) }}">{{ isset($customer->name_en) ? $customer->name_en : '-------' }}
                                </a> </h5>

                            {{-- name_ar --}}
                            <h5 class="card-title mt-2"><a
                                    href="{{ route('super_admin.customers-show', isset($customer->id) ? $customer->id : -1) }}">{{ isset($customer->name_ar) ? $customer->name_ar : '-------' }}
                                </a> </h5>
                            <hr>

                        </center>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-xlg-9 col-md-7">
                {{-- Form Section --}}
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3 pb-3 border-bottom">Update Customer Contact Info :</h4>
                        <form
                            action="{{ route('super_admin.customers-updateCustomerContact', isset($customerContact->id) ? $customerContact->id : -1) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">


                                <input type="hidden" name="customer_id"
                                    value="{{ isset($customerContact->customer_id) ? $customerContact->customer_id : null }}">


                                {{-- name --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="name"
                                            class="form-control border border-info @error('name') border-danger @enderror"
                                            id="tb-name"
                                            value="{{ isset($customerContact->name) ? $customerContact->name : null }}"
                                            placeholder="Name">
                                        <label for="tb-name">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i> Name
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
                                            id="tb-position"
                                            value="{{ isset($customerContact->position) ? $customerContact->position : null }}"
                                            placeholder="Position">
                                        <label for="tb-position">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>Position
                                            <strong class="text-danger">
                                                @error('position')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>


                                {{-- EMAIL --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="email" name="email"
                                            class="form-control border border-info @error('email') border-danger @enderror"
                                            id="tb-email"
                                            value="{{ isset($customerContact->email) ? $customerContact->email : null }}"
                                            placeholder="Email">
                                        <label for="tb-email">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i> Email
                                            <strong class="text-danger">
                                                @error('email')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>


                                {{-- PHONE --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="tel" name="phone"
                                            class="form-control border border-info @error('phone') border-danger @enderror"
                                            id="tb-phone"
                                            value="{{ isset($customerContact->phone) ? $customerContact->phone : null }}"
                                            placeholder="Phone">
                                        <label for="tb-phone">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i> Phone
                                            <strong class="text-danger">
                                                @error('phone')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>
                                <hr>
                                {{-- Button --}}
                                <div class="col-12">
                                    <div class="d-md-flex align-items-center mt-3">
                                        <div class="ms-auto mt-3 mt-md-0">
                                            <button type="submit"
                                                class="btn btn-success font-weight-medium rounded-pill px-4">
                                                <div class="d-flex align-items-center">
                                                    <i data-feather="save" class="feather-sm fill-white me-2"></i>
                                                    Save Customer Contact Updates
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
