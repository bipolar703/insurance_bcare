@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">

            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Add New Customer</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.customers-index') }}">All Customers</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add New</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Archive --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.customers-showSoftDelete') }}" class="btn btn-danger">
                            <i data-feather="archive" class="fill-white feather-sm"></i> View Archive
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
                        <h4 class="card-title mb-3 pb-3 border-bottom">Add New Customer :</h4>
                        <form action="{{ route('super_admin.customers-store') }}" method="POST"
                            enctype="multipart/form-data">
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
                                            <img id="blah"
                                                src="{{ asset('style_files/shared/images_default/blueray_logo.jpg') }}"
                                                class="rounded-circle" width="200" height="180" alt="Preview Image" />
                                            <h4 class="card-title mt-2">Customer Image</h4>
                                            <div class="col-md-6 mb-2">
                                                <input type="file" name="image"
                                                    class="form-control @error('image') is-invalid @enderror"
                                                    id="imgInp">
                                            </div>
                                        </center>
                                    </div>
                                </div>

                                {{-- name_ar --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="name_ar"
                                            class="form-control border border-info @error('name_ar') border-danger @enderror"
                                            id="tb-name" value="{{ old('name_ar') }}" placeholder="Name AR">
                                        <label for="tb-name">
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
                                            id="tb-name" value="{{ old('name_en') }}" placeholder="Name EN">
                                        <label for="tb-name">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i> Name EN
                                            <strong class="text-danger">
                                                @error('name_en')
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
                                                    @if (old('country_phone_id') == $phone_key->id) selected @endif>

                                                    {{ isset($phone_key->phone_code) ? $phone_key->name_en . ' (' . $phone_key->phone_code . '+)' : '------' }}

                                                </option>
                                            @endforeach
                                        </select>
                                    @endif
                                    {{-- phone --}}
                                    <div class="form-floating mb-3 col-md-8">
                                        <input type="number" name="phone" min="0"
                                            class="form-control border border-info  phone_No  @error('phone') border-danger @enderror"
                                            id="tb-phone" value="{{ old('phone') }}" placeholder="Phone">
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

                                {{-- Address --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="address"
                                            class="form-control border border-info @error('address') border-danger @enderror"
                                            id="tb-address" value="{{ old('address') }}" placeholder="Address">
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

                                {{-- Authorized Signatory --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="authorized_signatory"
                                            class="form-control border border-info @error('authorized_signatory') border-danger @enderror"
                                            id="tb-authorized_signatory" value="{{ old('authorized_signatory') }}"
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
                                                <option>--- Choose Customer Status ---</option>
                                                <option value="1" @if (old('status') == 1) selected @endif
                                                    @if (old('status') == null) selected @endif>Active</option>
                                                <option value="2" @if (old('status') == 2) selected @endif>
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

                                {{-- Button --}}
                                <div class="col-12">
                                    <div class="d-md-flex align-items-center mt-3">
                                        <div class="ms-auto mt-3 mt-md-0">
                                            <button type="submit"
                                                class="btn btn-success font-weight-medium rounded-pill px-4">
                                                <div class="d-flex align-items-center">
                                                    <i data-feather="plus" class="feather-sm fill-white me-2"></i>
                                                    Add New Customer
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
