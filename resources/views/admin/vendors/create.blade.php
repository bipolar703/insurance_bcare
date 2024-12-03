@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">

            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Vendors</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.vendors-index') }}">Vendors</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add New Vendor</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Archive --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.vendors-showSoftDelete') }}" class="btn btn-danger">
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
                        <form action="{{ route('super_admin.vendors-store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                {{-- name_ar --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="name_ar"
                                            class="form-control border border-info @error('name_ar') border-danger @enderror"
                                            id="tb-name-ar" value="{{ old('name_ar') }}" placeholder="Name AR">
                                        <label for="tb-name-arr">
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
                                            id="tb-name-en" value="{{ old('name_en') }}" placeholder="Name EN">
                                        <label for="tb-name-en">
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
                                            id="tb-balance" value="{{ old('balance') }}" placeholder="Balance">
                                        <label for="tb-balance">
                                            <i data-feather="type"
                                                class="feather-sm text-info fill-white me-2"></i>Balance
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
                                                <option>--- Choose Vendor Status ---</option>
                                                <option value="1" @if (old('status') == 1) selected @endif
                                                    @if (old('status') == null) selected @endif>Active</option>
                                                <option value="2" @if (old('status') == 2) selected @endif>
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
                                                    <i data-feather="plus" class="feather-sm fill-white me-2"></i>
                                                    Add New Vendor
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


    <script>
        $(document).ready(function() {
            // $('select[name="vendor_id"]').select2();
        });
    </script>
@endsection
