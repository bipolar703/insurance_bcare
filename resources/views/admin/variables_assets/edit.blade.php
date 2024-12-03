@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <h2 class="page-title">Variables Assets</h2>
            <div class="col-md-5 align-self-center">
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.variables_assets-index') }}">Variables Assets</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Update Variable Asset Info</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Create --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.variables_assets-create') }}" class="btn btn-dark">
                            <i data-feather="plus" class="fill-white feather-sm"></i> Add New Variable Asset
                        </a>
                    </div>
                    {{-- Show --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.variables_assets-show', isset($variableAsset->id) ? $variableAsset->id : -1) }}"
                            class="btn btn-primary">
                            <i data-feather="eye" class="fill-white feather-sm"></i> View Variable Asset
                        </a>
                    </div>

                    {{-- Delete --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.variables_assets-softDelete', isset($variableAsset->id) ? $variableAsset->id : -1) }}"
                            class="confirm btn btn-danger">
                            <i data-feather="trash" class="fill-white feather-sm"></i> Delete Variable Asset
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
                            action="{{ route('super_admin.variables_assets-update', isset($variableAsset->id) ? $variableAsset->id : -1) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">

                                {{-- title --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="title"
                                            class="form-control border border-info @error('title') border-danger @enderror"
                                            id="tb-title"
                                            value="{{ old('title') ? old('title') : (isset($variableAsset->title) ? $variableAsset->title : null) }}"
                                            placeholder="Title">
                                        <label for="tb-title">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i> Title
                                            <strong class="text-danger">
                                                @error('title')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- Quantity --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="quantity" min="0"
                                            class="form-control border border-info @error('quantity') border-danger @enderror"
                                            id="tb-quantity"
                                            value="{{ old('quantity') ? old('quantity') : (isset($variableAsset->quantity) ? $variableAsset->quantity : null) }}"
                                            placeholder="Quantity">
                                        <label for="tb-quantity">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                            Quantity
                                            <strong class="text-danger">
                                                @error('quantity')
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

                                            <label for="tb-name">
                                                <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                                Status
                                                <strong class="text-danger">
                                                    @error('status')
                                                        ( {{ $message }} )
                                                    @enderror
                                                    @error('not_valid_status')
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
