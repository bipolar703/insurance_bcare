@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <h2 class="page-title">Vendors</h2>
            <div class="col-md-5 align-self-center">
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.vendors-index') }}">Vendors</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Update Vendor Info</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Create --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.vendors-create') }}" class="btn btn-dark">
                            <i data-feather="plus" class="fill-white feather-sm"></i> Add New Vendor
                        </a>
                    </div>
                    {{-- Show --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.vendors-show', isset($vendor->id) ? $vendor->id : -1) }}"
                            class="btn btn-primary">
                            <i data-feather="eye" class="fill-white feather-sm"></i> View Vendor
                        </a>
                    </div>

                    {{-- Delete --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.vendors-softDelete', isset($vendor->id) ? $vendor->id : -1) }}"
                            class="confirm btn btn-danger">
                            <i data-feather="trash" class="fill-white feather-sm"></i> Delete Vendor
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
                        <form action="{{ route('super_admin.vendors-update', isset($vendor->id) ? $vendor->id : -1) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                {{-- name_ar --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="name_ar"
                                            class="form-control border border-info @error('name_ar') border-danger @enderror"
                                            id="tb-name_ar" value="{{ old('name_ar') ? old('name_ar') : (isset($vendor->name_ar) ? $vendor->name_ar : null) }}"
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
                                            id="tb-name_en" value="{{ old('name_en') ? old('name_en') : (isset($vendor->name_en) ? $vendor->name_en : null) }}"
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
                                            id="tb-email" value="{{ old('email') ? old('email') : (isset($vendor->email) ? $vendor->email : null) }}"
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
                                                    {{old('country_phone_id') ? (old('country_phone_id') == $phone_key->id ? 'selected' : null) : ((isset($vendor->country_phone_id) && $vendor->country_phone_id == $phone_key->id) ? 'selected' : null)}}>

                                                    {{ isset($phone_key->phone_code) ? $phone_key->name_en . ' (' . $phone_key->phone_code . '+)' : '------' }}

                                                </option>
                                            @endforeach
                                        </select>
                                    @endif
                                    {{-- phone --}}
                                    <div class="form-floating mb-3 col-md-8">
                                        <input type="number" name="phone" min="0"
                                            class="form-control border border-info  phone_No  @error('phone') border-danger @enderror"
                                            id="tb-phone" value="{{ old('phone') ? old('phone') : (isset($vendor->phone) ? $vendor->phone : null) }}"
                                            placeholder="Phone">
                                        <label for="tb-phone">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i> Phone
                                            <strong class="text-danger">
                                                @error('phone')
                                                    ( {{ $message }} )
                                                @enderror
                                                @error('country_phone_id')
                                                    ( {{ $message }} )
                                                @enderror
                                                @error('phone_not_valid')
                                                    ( {{ $message }} )
                                                @enderror   
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- balance --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="balance" step="0.001" min="0"
                                            class="form-control border border-info @error('balance') border-danger @enderror"
                                            id="tb-balance"
                                            value="{{ old('balance')  ? old('balance') : (isset($vendor->balance) ? $vendor->balance : null) }}"
                                            placeholder="Balance">
                                        <label for="tb-balance">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                            Balance
                                            <strong class="text-danger">
                                                @error('balance')
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
                                                <option value="1" {{ old('status')  ? (old('status') == 1 ? 'selected' : '') : (($vendor->status == 'Active') ? 'selected' : '') }}
                                                  >Active</option>
                                                <option value="2" {{ old('status')  ? (old('status') == 2 ? 'selected' : '') : (($vendor->status == 'Inactive') ? 'selected' : '') }}>
                                                    Inactive </option>
                                            </select>

                                            <label for="tb-status">
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
