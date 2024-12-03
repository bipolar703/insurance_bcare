@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Add Employee To Project</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    {{-- ========================================================== --}}
    {{-- ==================== Page Body Section =================== --}}
    {{-- ========================================================== --}}
    <div class="container-fluid">
        <div class="row">

            @if ($errors->any())
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
            @endif

            <div class="col-12">
                {{-- Form Section --}}
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3 pb-3 border-bottom">Add Employee To Project:</h4>
                        <form action="{{ route('super_admin.projects-storeEmployeeThatAreWorkingOnProject') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">

                                {{-- project_id --}}
                                <input type="hidden" name="project_id" value="{{ $projectId }}">

                                {{-- department_id --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="hidden" name="department_id" value="{{ isset($department->id) ? $department->id : null }}">
                                        <input type="text" readonly required
                                            class="form-control border border-info @error('department_id') border-danger @enderror"
                                            id="tb-department_name"
                                            value="{{ isset($department->name) ? $department->name : null }}"
                                            placeholder="Department Name">
                                        <label for="tb-department_name">
                                            <i data-feather="type"
                                                class="feather-sm text-info fill-white me-2"></i>Department
                                            Name
                                            <strong class="text-danger">
                                                @error('department_id')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- employee_id --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <select name="employee_id" required
                                            class="form-control form-select border border-info @error('employee_id') border-danger @enderror custom_select_style">
                                            @if (isset($department->users) && $department->users->count() > 0)
                                                <option value="">Select Employee Name</option>
                                                @foreach ($usersNotAssigned as $user)
                                                @if($user->type =='Developer' ||$user->type =='Team Leader'||$user->type =='Designer')
                                                    <option value="{{ $user->id }}"
                                                        @if (old('employee_id') == $user->id) selected @endif>
                                                        {{ $user->name ?? '------' }}
                                                    </option>
                                                    @endif
                                                @endforeach
                                            @else
                                                <option value="">No Project Are Available</option>
                                            @endif
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
