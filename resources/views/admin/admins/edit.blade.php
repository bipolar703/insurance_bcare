@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Update Admin Info</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.admins-index') }}">All Admins</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Update Admin Info</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Create --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.admins-create') }}" class="btn btn-dark">
                            <i data-feather="plus" class="fill-white feather-sm"></i> Add New
                        </a>
                    </div>
                    {{-- Show --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.admins-show', isset($admin->id) ? $admin->id : -1) }}"
                            class="btn btn-primary">
                            <i data-feather="eye" class="fill-white feather-sm"></i> View
                        </a>
                    </div>

                    {{-- Delete --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.admins-softDelete', isset($admin->id) ? $admin->id : -1) }}"
                            class="confirm btn btn-danger">
                            <i data-feather="trash" class="fill-white feather-sm"></i> Delete
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
                        <h4 class="card-title mb-3 pb-3 border-bottom">Update Admins Info :</h4>
                        <form action="{{ route('super_admin.admins-update', isset($admin->id) ? $admin->id : -1) }}"
                            method="POST" enctype="multipart/form-data">
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
                                            @if (isset($admin) && $admin->image && file_exists($admin->image))
                                                <img id="blah" src="{{ asset($admin->image) }}"
                                                    class="img-thumbnail" width="200" height="180" alt="Preview Image" />
                                            @else
                                                <img id="blah"
                                                    src="{{ asset('style_files/shared/images_default/blueray_logo.jpg') }}"
                                                    class="img-thumbnail"  width="200" height="180" alt="Preview Image" />
                                            @endif
                                            <h4 class="card-title mt-2">Admin Image</h4>
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

                                {{-- NAME --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="name"
                                            class="form-control border border-info @error('name') border-danger @enderror"
                                            id="tb-name" value="{{ isset($admin->name) ? $admin->name : null }}"
                                            placeholder="Name">
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


                                {{-- EMAIL --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="email" name="email"
                                            class="form-control border border-info @error('email') border-danger @enderror"
                                            id="tb-email" value="{{ isset($admin->email) ? $admin->email : null }}"
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


                                {{-- PHONE --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="tel" name="phone"
                                            class="form-control border border-info @error('phone') border-danger @enderror"
                                            id="tb-phone" value="{{ isset($admin->phone) ? $admin->phone : null }}"
                                            placeholder="Phone">
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


                                {{-- Status --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                            <select name="status"
                                                class="form-control form-select border border-info @error('status') border-danger @enderror custom_select_style">
                                                <option>--- Choose Status ---</option>
                                                <option value="1" @if ($admin->status == 'Active') selected @endif
                                                    @if ($admin->status == null) selected @endif>Active </option>
                                                <option value="2" @if ($admin->status == 'Inactive') selected @endif>
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


                                {{-- TYPE --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                            <select name="type"
                                                class="form-control form-select border border-info @error('type') border-danger @enderror custom_select_style">
                                                <option>--- Select Admin Type ---</option>
                                                <option value="1" @if ($admin->type == 'Super Admin') selected @endif
                                                    @if ($admin->type == null) selected @endif>Super Admin </option>
                                                <option value="2" @if ($admin->type == 'Management') selected @endif>
                                                    Management </option>
                                                <option value="3" @if ($admin->type == 'Human Resources') selected @endif>
                                                    Human Resources </option>
                                                <option value="4" @if ($admin->type == 'Financial') selected @endif>
                                                    Financial </option>
                                            </select>

                                            <label for="tb-name">
                                                <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                                Type
                                                <strong class="text-danger">
                                                    @error('type')
                                                        ( {{ $message }} )
                                                    @enderror
                                                </strong>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <hr>

                                {{-- old pass --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="password" name="old_password"
                                            class="form-control border border-info @error('old_password') border-danger @enderror"
                                            id="tb-old_password" placeholder="Old Password">
                                        <label for="tb-old_password">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i> Old
                                            Password
                                            <strong class="text-danger">
                                                @error('old_password')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>


                                {{-- new pass --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="password" name="password"
                                            class="form-control border border-info @error('password') border-danger @enderror"
                                            id="tb-password" placeholder="New Password">
                                        <label for="tb-password">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                            New Password
                                            <strong class="text-danger">
                                                @error('password')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>



                                {{-- rewrite pass --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="password" name="password_confirmation"
                                            class="form-control border border-info @error('password_confirmation') border-danger @enderror"
                                            id="tb-password_confirmation" placeholder="Confirm Password">
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
