@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Update Insurance Info</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('super_admin.insurances-index') }}">All Insurances</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Update Insurance Info</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Create --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.insurances-create') }}" class="btn btn-dark">
                            <i data-feather="plus" class="fill-white feather-sm"></i> Add New Insurance
                        </a>
                    </div>

                    {{-- Show --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.insurances-show', isset($insurance->id) ? $insurance->id : -1) }}"
                            class="btn btn-primary">
                            <i data-feather="eye" class="fill-white feather-sm"></i> View Insurance
                        </a>
                    </div>

                    {{-- Delete --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.insurances-softDelete', isset($insurance->id) ? $insurance->id : -1) }}"
                            class="confirm btn btn-danger">
                            <i data-feather="trash" class="fill-white feather-sm"></i> Delete Insurance
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
                        <h4 class="card-title mb-3 pb-3 border-bottom">Update Insurances Info :</h4>
                        <form id="editForm" action="{{ route('super_admin.insurances-update', isset($insurance->id) ? $insurance->id : -1) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">

                                {{-- Upload Image --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="formFile" class="form-label">Upload Insurance Image :
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
                                            @if (isset($insurance) && $insurance->image && file_exists($insurance->image))
                                                <img id="blah" src="{{ asset($insurance->image) }}" width="200"
                                                    height="180" class="img-thumbnail" alt="Preview Image" />
                                            @else
                                                <img id="blah"
                                                    src="{{ asset('style_files/shared/images_default/default.jpg') }}"
                                                    width="200" height="180" class="img-thumbnail"
                                                    alt="Preview Image" />
                                            @endif
                                            <h4 class="card-title mt-2">Insurance Image</h4>
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

                                {{-- Insurance Type --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                            <select name="insurance_type"
                                                class="form-control form-select border border-info @error('insurance_type') border-danger @enderror custom_select_style">
                                                <option>--- Select Marital Status ---</option>
                                                <option value="1" @if (old('insurance_type')) {{ old('insurance_type') == '1' ? 'selected' : '' }} @else {{ isset($insurance->insurance_type) && $insurance->insurance_type == 'ضد الغير' ? 'selected' : '' }} @endif> ضد الغير </option>
                                                <option value="2" @if (old('insurance_type')) {{ old('insurance_type') == '2' ? 'selected' : '' }} @else {{ isset($insurance->insurance_type) && $insurance->insurance_type == 'شامل' ? 'selected' : '' }} @endif> شامل </option>
                                            </select>

                                            <label for="tb-name">
                                                <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                                Marital Status
                                                <strong class="text-danger">
                                                    @error('insurance_type')
                                                        ( {{ $message }} )
                                                    @enderror


                                                </strong>
                                            </label>
                                        </div>
                                    </div>
                                </div>
              
                                {{-- Price --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="price" min="0" step="0.001"
                                            class="form-control border border-info @error('price') border-danger @enderror"
                                            id="tb-price"
                                            value="{{ old('price', isset($insurance->price) ? $insurance->price : null) }}"
                                            placeholder="Price">
                                        <label for="tb-price">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>Price
                                            <strong class="text-danger">
                                                @error('price')
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
                                                <option value="1"
                                                    @if (old('status')) {{ old('status') == '1' ? 'selected' : '' }} @else {{ isset($insurance->status) && $insurance->status == 'Active' ? 'selected' : '' }} @endif>
                                                    Active
                                                </option>
                                                <option value="2"
                                                    @if (old('status')) {{ old('status') == '2' ? 'selected' : '' }} @else {{ isset($insurance->status) && $insurance->status == 'Inactive' ? 'selected' : '' }} @endif>
                                                    Inactive
                                                </option>
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
