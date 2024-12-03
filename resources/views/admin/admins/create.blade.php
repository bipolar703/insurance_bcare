@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">

            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Add New Admin</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.admins-index') }}">All Admins</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add New</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Archive --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.admins-showSoftDelete') }}" class="btn btn-danger">
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
                        <h4 class="card-title mb-3 pb-3 border-bottom">Add New Admin :</h4>
                        <form action="{{ route('super_admin.admins-store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                {{-- Upload Image --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="formFile" class="form-label">Upload Admin Image :
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
                                            <h4 class="card-title mt-2">Admin Image</h4>
                                            <div class="col-md-6 mb-2">
                                                <input type="file" name="image"
                                                    class="form-control @error('image') is-invalid @enderror"
                                                    id="imgInp">
                                            </div>
                                        </center>
                                    </div>
                                </div>
                                {{-- name --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="name"
                                            class="form-control border border-info @error('name') border-danger @enderror"
                                            id="tb-name" value="{{ old('name') }}" placeholder="Name">
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

                                {{-- phone --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="tel" name="phone"
                                            class="form-control border border-info @error('phone') border-danger @enderror"
                                            id="tb-phone" value="{{ old('phone') }}" placeholder="Phone">
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

                                {{-- TYPE --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <select name="type"
                                            class="form-control form-select border border-info @error('type') border-danger @enderror custom_select_style">
                                            <option>--- Choose Admin Type ---</option>
                                            <option value="1" @if (old('type') == 1) selected @endif
                                                @if (old('type') == null) selected @endif>Super Admin </option>
                                            <option value="2" @if (old('type') == 2) selected @endif>
                                                Management </option>
                                            <option value="3" @if (old('type') == 3) selected @endif>
                                                Human Resources </option>
                                            <option value="4" @if (old('type') == 4) selected @endif>
                                                Financial </option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Password --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="password" name="password"
                                            class="form-control border border-info @error('password') border-danger @enderror"
                                            id="tb-password" value="{{ old('password') }}" placeholder="Password">
                                        <label for="tb-password">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                            Password
                                            <strong class="text-danger">
                                                @error('password')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- Confirmation Password --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="password" name="password_confirmation"
                                            class="form-control border border-info @error('password_confirmation') border-danger @enderror"
                                            id="tb-password" value="{{ old('password_confirmation') }}"
                                            placeholder="Confirm Password">
                                        <label for="tb-password_confirmation">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                            Confirm Password
                                            <strong class="text-danger">
                                                @error('password_confirmation')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- Status --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <select name="status"
                                            class="form-control form-select border border-info @error('status') border-danger @enderror custom_select_style">
                                            <option>--- Choose Status ---</option>
                                            <option value="1" @if (old('status') == 1) selected @endif
                                                @if (old('status') == null) selected @endif>Active </option>
                                            <option value="2" @if (old('status') == 2) selected @endif>
                                                Inactive </option>
                                        </select>
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
                                                    Add New
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
