@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <h2 class="page-title"><a
                    href="{{ route('super_admin.customers-show', isset($customer->id) ? $customer->id : -1) }}">{{ isset($customer->name_en) ? $customer->name_en : '-----' }}
                </a></h2>
            <h2 class="page-title"><a
                    href="{{ route('super_admin.customers-show', isset($customer->id) ? $customer->id : -1) }}">{{ isset($customer->name_ar) ? $customer->name_ar : '-----' }}
                </a></h2>
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Update Info</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.customers-index') }}">All Customers</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Update Customer Info</li>
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
                    {{-- Show --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.customers-show', isset($customer->id) ? $customer->id : -1) }}"
                            class="btn btn-primary">
                            <i data-feather="eye" class="fill-white feather-sm"></i> View Customer
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

            {{-- @if ($errors->any())
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-3 pb-3 border-bottom">Please correct the following errors : (
                                {{ $errors->count() }} Errors )</h4>
                            @foreach ($errors->all() as $error)
                                <div class="alert customize-alert alert-dismissible rounded-pill border-danger text-danger fade show remove-close-icon"
                                    role="alert">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                        <i data-feather="x" class="fill-white text-danger feather-sm"></i>
                                    </button>
                                    <div class="d-flex align-items-center font-weight-medium me-3 me-md-0">
                                        <i data-feather="info" class="text-danger fill-white feather-sm me-2"></i>
                                        {{ $error }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif --}}

            <div class="col-12">
                {{-- Form Section --}}
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3 pb-3 border-bottom">Update Customers Info :</h4>
                        <form
                            action="{{ route('super_admin.customers-update', isset($customer->id) ? $customer->id : -1) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">

                                {{-- Upload Image --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="formFile" class="form-label">Upload Customer Image :
                                            <strong class="text-danger">
                                                @error('image')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                        <div class="alert alert-info alert-dismissible bg-info text-white border-0 fade show"
                                            role="alert">
                                            <strong>1- Valid extensions : jpeg, jpg, png, gif, tiff, tif or webp.</strong>
                                        </div>
                                        <div class="alert alert-info alert-dismissible bg-info text-white border-0 fade show"
                                            role="alert">
                                            <strong>2- The maximum size of the uploaded image is 20MB.</strong>
                                        </div>
                                        <div class="alert alert-info alert-dismissible bg-info text-white border-0 fade show"
                                            role="alert">
                                            <strong>3- Recommended dimensions : 200px * 300px.</strong>
                                        </div>
                                    </div>
                                </div>

                                {{-- Preview Image --}}
                                <div class="col-md-6">
                                    <div class="mb-3 border border-info @error('image') border-danger @enderror">
                                        <center class="mt-4">
                                            @if (isset($customer) && $customer->image && file_exists($customer->image))
                                                <img id="blah" src="{{ asset($customer->image) }}"
                                                    class="img-thumbnail" width="200" height="180"
                                                    alt="Preview Image" />
                                            @else
                                                <img id="blah"
                                                    src="{{ asset('style_files/shared/images_default/blueray_logo.jpg') }}"
                                                    class="img-thumbnail" width="200" height="180"
                                                    alt="Preview Image" />
                                            @endif
                                            <h4 class="card-title mt-2">Customer Image</h4>
                                            <div class="col-md-6">
                                                <input type="file" name="image"
                                                    class="form-control mb-2 @error('image') is-invalid @enderror"
                                                    id="imgInp">
                                            </div>
                                        </center>
                                    </div>
                                </div>
                                <style>
                                    .fit-image {
                                        width: 100%;
                                        height: 100%;
                                        object-fit: contain;
                                    }
                                </style>

                                {{-- name_ar --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="name_ar"
                                            class="form-control border border-info @error('name_ar') border-danger @enderror"
                                            id="tb-name_ar"
                                            value="{{ isset($customer->name_ar) ? $customer->name_ar : null }}"
                                            placeholder="Name AR">
                                        <label for="tb-name_ar">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i> Name AR
                                            <strong class="text-danger">
                                                @error('name_ar')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- name_en --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="name_en"
                                            class="form-control border border-info @error('name_en') border-danger @enderror"
                                            id="tb-name_en"
                                            value="{{ isset($customer->name_en) ? $customer->name_en : null }}"
                                            placeholder="Name EN">
                                        <label for="tb-name_en">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i> Name
                                            EN
                                            <strong class="text-danger">
                                                @error('name_en')
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
                                            value="{{ isset($customer->email) ? $customer->email : null }}"
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


                                 {{-- Phone & Phone key --}}
                            <div class="phone_from border-info col-md-6 ">

                                {{-- phone key --}}
                                @if (isset($countries) && $countries->count() > 0)
                                    <select name="country_phone_id" class="numbersList text-center col-md-4"
                                        style="border-color: #e2e2e2">
                                        <option value="">--- Select Country Code ---</option>
                                        @foreach ($countries as $phone_key)
                                            <option value="{{ $phone_key->id }}"
                                                @if (isset($customer->country_phone_id) && $customer->country_phone_id  == $phone_key->id) selected @endif>

                                                {{ isset($phone_key->phone_code) ? $phone_key->name_en . ' (' . $phone_key->phone_code . '+)' : '------' }}

                                            </option>
                                        @endforeach
                                    </select>
                                @endif
                                {{-- phone --}}
                                <div class="form-floating mb-3 col-md-8">
                                    <input type="number" name="phone" min="0"
                                        class="form-control border border-info  phone_No  @error('phone') border-danger @enderror"
                                        id="tb-phone" value="{{ isset($customer->phone) ? $customer->phone : null }}" placeholder="Phone">
                                    <label for="tb-phone">
                                        <i data-feather="type" class="feather-sm text-info fill-white me-2"></i> Phone
                                        <strong class="text-danger">
                                            @error('phone')
                                                ( {{ $message }} )
                                            @enderror
                                            @error('country_phone_id')
                                                ( {{ $message }} )
                                            @enderror
                                           
                                        </strong>
                                    </label>
                                </div>
                            </div>


                                {{-- email_two --}}
                                {{-- <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="email_two" name="email_two"
                                            class="form-control border border-info @error('email_two') border-danger @enderror"
                                            id="tb-email_two"
                                            value="{{ isset($customer->email_two) ? $customer->email_two : null }}"
                                            placeholder="2nd Email">
                                        <label for="tb-email_two">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i> 2nd
                                            Email
                                            <strong class="text-danger">
                                                @error('email_two')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div> --}}


                                {{-- phone_two --}}
                                {{-- <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="tel" name="phone_two"
                                            class="form-control border border-info @error('phone_two') border-danger @enderror"
                                            id="tb-phone_two"
                                            value="{{ isset($customer->phone_two) ? $customer->phone_two : null }}"
                                            placeholder="2nd Phone">
                                        <label for="tb-phone_two">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i> 2nd Phone
                                            <strong class="text-danger">
                                                @error('phone_two')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div> --}}

                                {{-- Address --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="address"
                                            class="form-control border border-info @error('address') border-danger @enderror"
                                            id="tb-address"
                                            value="{{ isset($customer->address) ? $customer->address : null }}"
                                            placeholder="Address">
                                        <label for="tb-address">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                            Address
                                            <strong class="text-danger">
                                                @error('address')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- authorized_signatory --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="authorized_signatory"
                                            class="form-control border border-info @error('authorized_signatory') border-danger @enderror"
                                            id="tb-authorized_signatory"
                                            value="{{ isset($customer->authorized_signatory) ? $customer->authorized_signatory : null }}"
                                            placeholder="Authorized Signatory">
                                        <label for="tb-authorized_signatory">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                            Authorized Signatory
                                            <strong class="text-danger">
                                                @error('authorized_signatory')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- status --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                            <select name="status"
                                                class="form-control form-select border border-info @error('status') border-danger @enderror custom_select_style">
                                                <option>--- Select Status ---</option>
                                                <option value="1" @if ($customer->status == 'Active') selected @endif
                                                    @if ($customer->status == null) selected @endif>Active</option>
                                                <option value="2" @if ($customer->status == 'Inactive') selected @endif>
                                                    Inactive </option>
                                            </select>

                                            <label for="tb-name">
                                                <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                                Status
                                                <strong class="text-danger">
                                                    @error('status')
                                                        ( {{ $message }} )
                                                    @enderror
                                                    

                                                </strong>
                                            </label>
                                        </div>
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
