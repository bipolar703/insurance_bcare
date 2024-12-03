@extends('admin.layouts.app')

@section('content')
{{-- =========================================================== --}}
{{-- =================== Page Header Section =================== --}}
{{-- =========================================================== --}}
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-md-5 align-self-center">
            <h3 class="page-title">Update {{ isset($department->name) ? $department->name : '----' }} Info</h3>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a
                                href="{{ route('super_admin.departments-index') }}">Departments</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Update Info</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
            <div class="d-flex">
                {{-- Create --}}
                <div class="dropdown me-2">
                    <a href="{{ route('super_admin.departments-create') }}" class="btn btn-dark">
                        <i data-feather="plus" class="fill-white feather-sm"></i> Add New Dept
                    </a>
                </div>

                {{-- Show --}}
                <div class="dropdown me-2">
                    <a href="{{ route('super_admin.departments-show', isset($department->id) ? $department->id : -1) }}"
                        class="btn btn-primary">
                        <i data-feather="eye" class="fill-white feather-sm"></i> View Dept
                    </a>
                </div>

                {{-- Active / Inactive --}}
                <div class="dropdown me-2">
                    <a href="{{ route('super_admin.departments-activeInactiveSingle', isset($department->id) ? $department->id : -1) }}"
                        class="btn btn-warning">
                        @if (isset($department->status) && $department->status == 'Active')
                        <i data-feather="pause" class="fill-white feather-sm"></i> Set Inactive
                        @elseif(isset($department->status) && $department->status == 'Inactive')
                        <i data-feather="play" class="fill-white feather-sm"></i> Set Active
                        @endif
                    </a>
                </div>

                {{-- Delete --}}
                <div class="dropdown me-2">
                    <a href="{{ route('super_admin.departments-softDelete', isset($department->id) ? $department->id : -1) }}"
                        class="confirm btn btn-danger">
                        <i data-feather="trash" class="fill-white feather-sm"></i> Delete Dept
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
                        action="{{ route('super_admin.departments-update', isset($department->id) ? $department->id : -1) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            {{-- NAME --}}
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" name="name"
                                        class="form-control border border-info @error('name') border-danger @enderror"
                                        id="tb-name" value="{{ isset($department->name) ? $department->name : null }}"
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

                            {{-- Code --}}
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" name="code"
                                        class="form-control border border-info @error('code') border-danger @enderror"
                                        id="tb-name" value="{{ isset($department->code) ? $department->code : null }}"
                                        placeholder="Code">
                                    <label for="tb-name">
                                        <i data-feather="type" class="feather-sm text-info fill-white me-2"></i> Code
                                        <strong class="text-danger">
                                            @error('code')
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
                                            <option value="1" @if ($department->status == 'Active') selected @endif
                                                @if ($department->status == null) selected @endif>Active </option>
                                            <option value="2" @if ($department->status == 'Inactive') selected @endif>
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

                            {{-- Department Type --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="form-floating mb-3">
                                        <select name="department_type_id"
                                            class="form-control form-select border border-info @error('department_type_id') border-danger @enderror custom_select_style">
                                            <option selected>--- Select Type ---</option>
                                            @forelse ( $departmentsTypes as $departmentsType )
                                                <option value="{{ $departmentsType->id }}" {{ (old('department_type_id') ?? $department->department_type_id) == $departmentsType->id ? 'selected' : '' }}>
                                                    {{ $departmentsType->title_en }}
                                                </option>
                                            @empty
                                            @endforelse
                                        </select>
                                        <label for="tb-name">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                            Type
                                            <strong class="text-danger">
                                                @error('department_type_id')
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