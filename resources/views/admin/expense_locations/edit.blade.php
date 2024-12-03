@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Expense Locations</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.expense_locations-index') }}">Expense Locations</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Update Expens Location Info</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Create --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.expense_locations-create') }}" class="btn btn-dark">
                            <i data-feather="plus" class="fill-white feather-sm"></i>New Expens Location
                        </a>
                    </div>
                    {{-- Show --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.expense_locations-show', isset($expenseLocation->id) ? $expenseLocation->id : -1) }}"
                            class="btn btn-primary">
                            <i data-feather="eye" class="fill-white feather-sm"></i> View Expens Location
                        </a>
                    </div>

                    {{-- Delete --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.expense_locations-softDelete', isset($expenseLocation->id) ? $expenseLocation->id : -1) }}"
                            class="confirm btn btn-danger">
                            <i data-feather="trash" class="fill-white feather-sm"></i> Delete Expens Location
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
                        <form
                            action="{{ route('super_admin.expense_locations-update', isset($expenseLocation->id) ? $expenseLocation->id : -1) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">

                                {{-- title_ar --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="title_ar"
                                            class="form-control border border-info @error('title_ar') border-danger @enderror"
                                            id="tb-title_ar"
                                            value="{{ old('title_ar') ? old('title_ar') : (isset($expenseLocation->title_ar) ? $expenseLocation->title_ar : null) }}"
                                            placeholder="Title AR">
                                        <label for="tb-title_ar">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i> Title
                                            AR
                                            <strong class="text-danger">
                                                @error('title_ar')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- title_en --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="title_en"
                                            class="form-control border border-info @error('title_en') border-danger @enderror"
                                            id="tb-title_en"
                                            value="{{ old('title_en') ? old('title_en') : (isset($expenseLocation->title_en) ? $expenseLocation->title_en : null) }}"
                                            placeholder="Title EN">
                                        <label for="tb-title_en">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i> Title
                                            EN
                                            <strong class="text-danger">
                                                @error('title_en')
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
                                                <option value="1" {{ old('status')  ? (old('status') == 1 ? 'selected' : '') : (($expenseLocation->status == 'Active') ? 'selected' : '') }}
                                                    >Active</option>
                                                <option value="2" {{ old('status') ? (old('status') == 2 ? 'selected' : '') : (($expenseLocation->status == 'Inactive') ? 'selected' : '') }}>
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
