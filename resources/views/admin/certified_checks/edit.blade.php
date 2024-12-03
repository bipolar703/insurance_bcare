@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Update Check Info</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.certified_checks-index') }}">Certified Checks</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Update Certified Check Info</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Create --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.certified_checks-create') }}" class="btn btn-dark">
                            <i data-feather="plus" class="fill-white feather-sm"></i> Add New Certified Check
                        </a>
                    </div>
                    {{-- Show --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.certified_checks-show', isset($certifiedCheck->id) ? $certifiedCheck->id : -1) }}"
                            class="btn btn-primary">
                            <i data-feather="eye" class="fill-white feather-sm"></i> View Certified Check
                        </a>
                    </div>
                    {{-- Delete --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.certified_checks-softDelete', isset($certifiedCheck->id) ? $certifiedCheck->id : -1) }}"
                            class="confirm btn btn-danger">
                            <i data-feather="trash" class="fill-white feather-sm"></i> Delete Certified Check
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
                <div class="card">
                    <div class="card-body">
                        <form
                            action="{{ route('super_admin.certified_checks-update', isset($certifiedCheck->id) ? $certifiedCheck->id : -1) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">

                                {{-- release_to --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="release_to"
                                            class="form-control border border-info @error('release_to') border-danger @enderror"
                                            id="tb-release_to"
                                            value="{{ isset($certifiedCheck->release_to) ? $certifiedCheck->release_to : null }}"
                                            placeholder="Release To">
                                        <label for="tb-release_to">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i> Release
                                            To
                                            <strong class="text-danger">
                                                @error('release_to')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- check_number --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="check_number" min="1"
                                            class="form-control border border-info @error('check_number') border-danger @enderror"
                                            id="tb-name"
                                            value="{{ isset($certifiedCheck->check_number) ? $certifiedCheck->check_number : null }}"
                                            placeholder="Check Number">
                                        <label for="tb-name">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i> Check
                                            Number
                                            <strong class="text-danger">
                                                @error('check_number')
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
                                            id="tb-name"
                                            value="{{ isset($certifiedCheck->release_date) ? $certifiedCheck->release_date : null }}"
                                            placeholder="Release Date">
                                        <label for="tb-name">
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

                                {{-- amount --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="amount" min="1"
                                            class="form-control border border-info @error('amount') border-danger @enderror"
                                            id="tb-name"
                                            value="{{ isset($certifiedCheck->amount) ? $certifiedCheck->amount : null }}"
                                            placeholder="Amount">
                                        <label for="tb-name">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i> Amount
                                            <strong class="text-danger">
                                                @error('amount')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- Status --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                            <select name="status"
                                                class="form-control form-select border border-info @error('status') border-danger @enderror custom_select_style">
                                                <option>--- Choose Status ---</option>
                                                <option value="1" @if ($certifiedCheck->status == 'They Have (لديهم)') selected @endif
                                                    @if ($certifiedCheck->status == null) selected @endif>They Have (لديهم)
                                                </option>
                                                <option value="2" @if ($certifiedCheck->status == 'We Have (لدينا)') selected @endif> We
                                                    Have (لدينا) </option>
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

                                {{-- reason_for_release --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                            <select name="reason_for_release"
                                                class="form-control form-select border border-info @error('reason_for_release') border-danger @enderror custom_select_style">
                                                <option>--- Select Reason For Release ---</option>
                                                <option value="1" @if ($certifiedCheck->reason_for_release == 'Entering Tinder (دخول عطاء)') selected @endif>
                                                    Entering Tinder (دخول عطاء) </option>
                                                <option value="2" @if ($certifiedCheck->reason_for_release == 'Well Implemented (حسن التنفيذ)') selected @endif>
                                                    Well Implemented (حسن التنفيذ) </option>
                                                <option value="3" @if ($certifiedCheck->reason_for_release == 'Maintenance (صيانة)') selected @endif>
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

                                {{-- customer_id --}}
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                            <select name="customer_id"
                                                class="form-control form-select border border-info @error('customer_id') border-danger @enderror custom_select_style">
                                                @if (isset($customers) && $customers->count() > 0)
                                                    <option value=""> --- Select Customer ---</option>
                                                    @foreach ($customers as $customer)
                                                        <option value="{{ $customer->id }}"
                                                            @if ($customer->id == $certifiedCheck->customer_id) selected @endif>
                                                            {{ $customer->name_en ?? '------' }} (
                                                            {{ $customer->name_ar ?? '------' }})
                                                        </option>
                                                    @endforeach
                                                @else
                                                    <option value="">
                                                        No customers Please Check With Admin
                                                    </option>
                                                @endif
                                            </select>
                                            <strong class="text-danger">
                                                @error('customer_id')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </div>
                                    </div>
                                </div>

                                {{-- Image Field --}}
                                <div class="col-md-6">
                                    <label class="text-dark font-weight-medium mb-2" for="validationServer01"> Check Image :
                                        <strong class="text-danger">
                                            @error('image')
                                                - {{ $message }}
                                            @enderror
                                        </strong></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text mdi mdi-cloud-upload"></span>
                                        </div>
                                        <input type="file" name="image" class="form-control"
                                            id="validationServer01">
                                    </div>
                                </div>

                                {{-- preview  --}}
                                <div class="col-md-6">
                                    @if (isset($certifiedCheck->image) &&
                                            $certifiedCheck->getRawOriginal('image') &&
                                            file_exists($certifiedCheck->getRawOriginal('image')))
                                        <img src="{{ asset($certifiedCheck->image) }}" width="350" height="200"
                                            style="border-radius: 10px; border:solid 1px black;">
                                    @else
                                        <img src="{{ asset('style_files\frontend\img\logo.jpg') }}" width="200"
                                            height="100" style="border-radius: 10px; border:solid 1px black;">
                                    @endif
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
    <script>
        $(document).ready(function() {
            $('select[name="customer_id"]').select2();
        });
    </script>
@endsection
