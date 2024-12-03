@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Add Certified Check</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.certified_checks-index') }}">Certified Check</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add New</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Archive --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.certified_checks-showSoftDelete') }}" class="btn btn-danger">
                            <i data-feather="archive" class="fill-white feather-sm"></i> View Archive travels
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
                        <form action="{{ route('super_admin.certified_checks-store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">

                                {{-- release_to --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="release_to"
                                            class="form-control border border-info @error('release_to') border-danger @enderror"
                                            id="tb-release_to" value="{{ old('release_to') }}" placeholder="Release To">
                                        <label for="tb-release_to">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>Release
                                            To
                                            <strong class="text-danger">
                                                @error('release_to')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- amount --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="amount" min="0" step="0.001"
                                            class="form-control border border-info @error('amount') border-danger @enderror"
                                            id="tb-amount" value="{{ old('amount') }}" placeholder="Amount">
                                        <label for="tb-amount">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>Amount

                                            <strong class="text-danger">
                                                @error('amount')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- release_date --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="date" name="release_date"
                                            class="form-control border border-info @error('release_date') border-danger @enderror"
                                            id="tb-release_date" value="{{ old('release_date') }}"
                                            placeholder="Release Date">
                                        <label for="tb-date">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>Release
                                            Date
                                            <strong class="text-danger">
                                                @error('release_date')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- check_number --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="check_number" min="0"
                                            class="form-control border border-info @error('check_number') border-danger @enderror"
                                            id="tb-check_number" value="{{ old('check_number') }}"
                                            placeholder="Check Number">
                                        <label for="tb-check_number">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>Check
                                            Number
                                            <strong class="text-danger">
                                                @error('check_number')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- image --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="file" name="image"
                                            class="form-control border border-info @error('image') border-danger @enderror"
                                            id="tb-image" value="{{ old('image') }}" placeholder="Image">
                                        <label for="tb-image">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>Check
                                            Image :
                                            <strong class="text-danger">
                                                @error('image')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- customer_id --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                            <strong class="text-danger">
                                                @error('customer_id')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                            <select name="customer_id"
                                                class="form-control form-select border border-info @error('customer_id') border-danger @enderror custom_select_style">
                                                @if (isset($customers) && $customers->count() > 0)
                                                    <option value="">Select customer Name</option>
                                                    @foreach ($customers as $customer)
                                                        <option value="{{ $customer->id }}"
                                                            @if (old('customer_id') == $customer->id) selected @endif>
                                                            {{ isset($customer->name_ar) ? $customer->name_ar : '------' }}
                                                            ({{ isset($customer->name_en) ? $customer->name_en : '------' }})
                                                        </option>
                                                    @endforeach
                                                @else
                                                    <option value="">No Custoemrs Are Available</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                {{-- reason_for_release --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                            <select name="reason_for_release" id="reason_for_release"
                                                class="form-control form-select border border-info @error('reason_for_release') border-danger @enderror custom_select_style">
                                                <option value="">--- Choose Reason For Release * ---</option>
                                                <option value="1" @if (old('reason_for_release') == 1) selected @endif>
                                                    Entering Tinder (دخول عطاء)</option>
                                                <option value="2" @if (old('reason_for_release') == 2) selected @endif>
                                                    Well Implemented (حسن التنفيذ) </option>
                                                <option value="3" @if (old('reason_for_release') == 3) selected @endif>
                                                    Maintenance (صيانة) </option>
                                            </select>
                                            <label for="tb-name">
                                                <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                                Reason For Release
                                                <strong class="text-danger">
                                                    @error('reason_for_release')
                                                        ( {{ $message }} )
                                                    @enderror
                                                </strong>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                {{-- status --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                            <select name="status" id="status"
                                                class="form-control form-select border border-info @error('status') border-danger @enderror custom_select_style">
                                                <option value="">--- Choose Status * ---</option>
                                                <option value="1" @if (old('status') == 1) selected @endif>
                                                    They Have (لديهم)</option>
                                                <option value="2" @if (old('status') == 2) selected @endif>
                                                    We Have (لدينا) </option>
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
                                                    Add New Check
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
            $('select[name="customer_id"]').select2();
        });
    </script>
@endsection
