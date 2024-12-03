@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Update {{ isset($employee->name) ? $employee->name : '-----' }} Info</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.employees-index') }}">All Employees</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Update Employee Info</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Create --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.employees-create') }}" class="btn btn-dark">
                            <i data-feather="plus" class="fill-white feather-sm"></i> Add New Employee
                        </a>
                    </div>

                    {{-- Show --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.employees-show', isset($employee->id) ? $employee->id : -1) }}"
                            class="btn btn-primary">
                            <i data-feather="eye" class="fill-white feather-sm"></i> View Employee
                        </a>
                    </div>

                    {{-- Delete --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.employees-softDelete', isset($employee->id) ? $employee->id : -1) }}"
                            class="confirm btn btn-danger">
                            <i data-feather="trash" class="fill-white feather-sm"></i> Delete Employee
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
                        <h4 class="card-title mb-3 pb-3 border-bottom">Update Employees Info :</h4>
                        <form id="editForm"
                            action="{{ route('super_admin.employees-update', isset($employee->id) ? $employee->id : -1) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">

                                {{-- Upload Image --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="formFile" class="form-label">Upload Employee Image :
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
                                            @if (isset($employee) && $employee->image && file_exists($employee->image))
                                                <img id="blah" src="{{ asset($employee->image) }}" width="200"
                                                    height="180" class="img-thumbnail" alt="Preview Image" />
                                            @else
                                                <img id="blah"
                                                    src="{{ asset('style_files/shared/images_default/blueray_logo.jpg') }}"
                                                    width="200" height="180" class="img-thumbnail"
                                                    alt="Preview Image" />
                                            @endif
                                            <h4 class="card-title mt-2">Employee Image</h4>
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

                                {{-- Name --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="name"
                                            class="form-control border border-info @error('name') border-danger @enderror"
                                            id="tb-name"
                                            value="{{ old('name', isset($employee->name) ? $employee->name : null) }}"
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


                                {{-- Email --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="email" name="email"
                                            class="form-control border border-info @error('email') border-danger @enderror"
                                            id="tb-email"
                                            value="{{ old('email', isset($employee->email) ? $employee->email : null) }}"
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


                                {{-- Phone & Phone key --}}
                                <div class="phone_from border-info col-md-6 ">

                                    {{-- phone key --}}
                                    @if (isset($countries) && $countries->count() > 0)
                                        <select name="country_phone_id" class="numbersList text-center col-md-4"
                                            style="border-color: #e2e2e2">
                                            <option>--- Select Country Code ---</option>
                                            {{-- @foreach ($countries as $phone_key)
                                                <option value="{{ $phone_key->id }}"
                                                    @if (isset($employee->country_phone_id) && $employee->country_phone_id == $phone_key->id) selected @endif>

                                                    {{ isset($phone_key->phone_code) ? $phone_key->name_en . ' (' . $phone_key->phone_code . '+)' : '------' }}

                                                </option>
                                            @endforeach --}}
                                            @forelse ($countries as $phone_key)
                                                <option value="{{ $phone_key->id }}"
                                                    {{ (old('country_phone_id') ?? $employee->country_phone_id) == $phone_key->id ? 'selected' : '' }}>
                                                    {{ isset($phone_key->phone_code) ? $phone_key->name_en . ' (' . $phone_key->phone_code . '+)' : '------' }}

                                                </option>
                                            @empty
                                                <option>
                                                    No Phone Keys Please Check With Admin
                                                </option>
                                            @endforelse
                                        </select>
                                    @endif
                                    {{-- phone --}}
                                    <div class="form-floating mb-3 col-md-8">
                                        <input type="number" name="phone" min="0"
                                            class="form-control border border-info  phone_No  @error('phone') border-danger @enderror"
                                            id="tb-phone"
                                            value="{{ old('phone', isset($employee->phone) ? $employee->phone : null) }}"
                                            placeholder="Phone">
                                        <label for="tb-phone">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i> Phone
                                            <strong class="text-danger">
                                                @error('phone')
                                                    ( {{ $message }} )
                                                @enderror
                                                @error('country_phone_id')
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
                                                {{-- <option value="1" @if ($employee->status == 'Active') selected @endif
                                                    @if ($employee->status == null) selected @endif>Active </option>
                                                <option value="2" @if ($employee->status == 'Inactive') selected @endif>
                                                    Inactive </option> --}}

                                                <option value="1"
                                                    @if (old('status')) {{ old('status') == '1' ? 'selected' : '' }} @else {{ isset($employee->status) && $employee->status == 'Active' ? 'selected' : '' }} @endif>
                                                    Active
                                                </option>
                                                <option value="2"
                                                    @if (old('status')) {{ old('status') == '2' ? 'selected' : '' }} @else {{ isset($employee->status) && $employee->status == 'Inactive' ? 'selected' : '' }} @endif>
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


                                {{-- date_of_birth --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="date" name="date_of_birth"
                                            class="form-control border border-info @error('date_of_birth') border-danger @enderror"
                                            id="tb-date_of_birth"
                                            value="{{ old('date_of_birth', isset($employee->date_of_birth) ? $employee->date_of_birth : null) }}"
                                            placeholder="Date Of Birth">
                                        <label for="tb-date_of_birth">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i> Date
                                            Of Birth
                                            <strong class="text-danger">
                                                @error('date_of_birth')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- gender --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                            <select name="gender"
                                                class="form-control form-select border border-info @error('gender') border-danger @enderror custom_select_style">
                                                <option>--- Select Gender ---</option>
                                                {{-- <option value="1" @if ($employee->gender == 'Male') selected @endif
                                                    @if ($employee->gender == null) selected @endif>Male
                                                </option> --}}
                                                {{-- <option value="2" @if ($employee->gender == 'Female') selected @endif> Female </option> --}}
                                                <option value="1"
                                                    @if (old('gender')) {{ old('gender') == '1' ? 'selected' : '' }} @else {{ isset($employee->gender) && $employee->gender == 'Male' ? 'selected' : '' }} @endif>
                                                    Male
                                                </option>
                                                <option value="2"
                                                    @if (old('gender')) {{ old('gender') == '2' ? 'selected' : '' }} @else {{ isset($employee->gender) && $employee->gender == 'Female' ? 'selected' : '' }} @endif>
                                                    Female
                                                </option>

                                            </select>
                                            <label for="tb-name">
                                                <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                                Gender
                                                <strong class="text-danger">
                                                    @error('gender')
                                                        ( {{ $message }} )
                                                    @enderror

                                                </strong>
                                            </label>
                                        </div>
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

                                {{-- department_id --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                            <select name="department_id"
                                                class="form-control form-select border border-info @error('department_id') border-danger @enderror custom_select_style">
                                                {{-- @if (isset($departments) && $departments->count() > 0) --}}
                                                    <option>--- Select Department Name --- </option>
                                                    {{-- @foreach ($departments as $department)
                                                        <option value="{{ $department->id }}"
                                                            @if ($department->id == $employee->department_id) selected @endif>
                                                            {{ $department->name ?? '------' }}
                                                        </option>
                                                    @endforeach --}}

                                                    @forelse ($departments as $department)
                                                        <option value="{{ $department->id }}"
                                                            {{ (old('department_id') ?? $employee->department_id) == $department->id ? 'selected' : '' }}>
                                                            {{ $department->name }}
                                                        </option>
                                                    @empty
                                                        <option value="">
                                                            No Nationality Please Check With Admin
                                                        </option>
                                                    @endforelse
                                                {{-- @else
                                                    <option>
                                                        No Department Please Check With Admin
                                                    </option>
                                                @endif --}}


                                            </select>
                                            <label for="tb-name">
                                                <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                                Department
                                                <strong class="text-danger">
                                                    @error('department_id')
                                                        ( {{ $message }} )
                                                    @enderror
                                                </strong>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                {{-- Employee Type --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                            <select name="employee_type_id"
                                                class="form-control form-select border border-info @error('employee_type_id') border-danger @enderror custom_select_style">
                                                <option selected>--- Select Type ---</option>
                                                @forelse ($employee_types as $employee_type)
                                                    <option value="{{ $employee_type->id }}"
                                                        {{ (old('employee_type_id') ?? $employee->employee_type_id) == $employee_type->id ? 'selected' : '' }}>
                                                        {{ $employee_type->title_en }}
                                                    </option>

                                                @empty
                                                @endforelse
                                            </select>
                                            <label for="tb-name">
                                                <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                                Type
                                                <strong class="text-danger">
                                                    @error('employee_type_id')
                                                        ( {{ $message }} )
                                                    @enderror

                                                </strong>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                {{-- marital_status --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                            <select name="marital_status"
                                                class="form-control form-select border border-info @error('marital_status') border-danger @enderror custom_select_style">
                                                <option>--- Select Marital Status ---</option>
                                                {{-- <option value="1" @if ($employee->marital_status == 'Single') selected @endif
                                                    @if ($employee->marital_status == null) selected @endif>Single
                                                </option>
                                                <option value="2" @if ($employee->marital_status == 'Married') selected @endif>
                                                    Married </option>
                                                <option value="3" @if ($employee->marital_status == 'Divorced') selected @endif>
                                                    Divorced </option>
                                                <option value="4" @if ($employee->marital_status == 'Widow/Widower') selected @endif>
                                                    Widow/Widower </option> --}}

                                                <option value="1"
                                                    @if (old('marital_status')) {{ old('marital_status') == '1' ? 'selected' : '' }} @else {{ isset($employee->marital_status) && $employee->marital_status == 'Single' ? 'selected' : '' }} @endif>
                                                    Single
                                                </option>
                                                <option value="2"
                                                    @if (old('marital_status')) {{ old('marital_status') == '2' ? 'selected' : '' }} @else {{ isset($employee->marital_status) && $employee->marital_status == 'Married' ? 'selected' : '' }} @endif>
                                                    Married
                                                </option>

                                                <option value="3"
                                                    @if (old('marital_status')) {{ old('marital_status') == '3' ? 'selected' : '' }} @else {{ isset($employee->marital_status) && $employee->marital_status == 'Divorced' ? 'selected' : '' }} @endif>
                                                    Divorced
                                                </option>
                                                <option value="4"
                                                    @if (old('marital_status')) {{ old('marital_status') == '4' ? 'selected' : '' }} @else {{ isset($employee->marital_status) && $employee->marital_status == 'Widow/Widower' ? 'selected' : '' }} @endif>
                                                    Widow/Widower
                                                </option>
                                            </select>

                                            <label for="tb-name">
                                                <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                                Marital Status
                                                <strong class="text-danger">
                                                    @error('marital_status')
                                                        ( {{ $message }} )
                                                    @enderror


                                                </strong>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                {{-- nationality --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                            <select name="nationality"
                                                class="form-control form-select border border-info @error('nationality') border-danger @enderror custom_select_style">
                                                <option> --- Select Nationality ---</option>
                                                @forelse ($countries as $country)
                                                    <option value="{{ $country->id }}"
                                                        {{ (old('nationality') ?? $employee->nationality) == $country->id ? 'selected' : '' }}>
                                                        {{ $country->name_en }}
                                                        ({{ $country->name_ar }})
                                                    </option>
                                                @empty
                                                    <option value="">
                                                        No Nationality Please Check With Admin
                                                    </option>
                                                @endforelse
                                            </select>
                                            <strong class="text-danger">
                                                @error('nationality')
                                                    ( {{ $message }} )
                                                @enderror

                                            </strong>

                                        </div>
                                    </div>
                                </div>

                                {{-- work_email --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="emil" name="work_email"
                                            class="form-control border border-info @error('work_email') border-danger @enderror"
                                            id="tb-work_email"
                                            value="{{ old('work_email', isset($employee->work_email) ? $employee->work_email : null) }}"
                                            placeholder="Work Email">
                                        <label for="tb-work_email">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i> Work
                                            Email
                                            <strong class="text-danger">
                                                @error('work_email')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- work_phone --}}
                                <div class="phone_from border-info col-md-6 ">

                                    {{-- phone key --}}
                                    @if (isset($countries) && $countries->count() > 0)
                                        <select name="work_country_phone_id" class="numbersList text-center col-md-4"
                                            style="border-color: #e2e2e2">
                                            <option>--- Select Country Code ---</option>
                                            {{-- @foreach ($countries as $phone_key)
                                                <option value="{{ $phone_key->id }}"
                                                    @if (old('work_country_phone_id') == $phone_key->id || (isset($employee) && $employee->work_country_phone_id == $phone_key->id)) selected @endif>
                                                    {{ isset($phone_key->phone_code) ? $phone_key->name_en . ' (' . $phone_key->phone_code . '+)' : '------' }}
                                                </option>
                                            @endforeach --}}

                                            @forelse ($countries as $phone_key)
                                                <option value="{{ $phone_key->id }}"
                                                    {{ (old('work_country_phone_id') ?? $employee->work_country_phone_id) == $phone_key->id ? 'selected' : '' }}>
                                                    {{ isset($phone_key->phone_code) ? $phone_key->name_en . ' (' . $phone_key->phone_code . '+)' : '------' }}

                                                </option>
                                            @empty
                                                <option> No Phone Keys Please Check With Admin</option>
                                            @endforelse
                                        </select>
                                    @endif
                                    {{-- work phone --}}
                                    <div class="form-floating mb-3 col-md-8">
                                        <input type="number" name="work_phone" min="0"
                                            class="form-control border border-info  phone_No  @error('work_phone') border-danger @enderror"
                                            id="tb-phone"
                                            value="{{ old('work_phone', isset($employee->work_phone) ? $employee->work_phone : null) }}"
                                            placeholder="Phone">
                                        <label for="tb-phone">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i> Work
                                            Phone
                                            <strong class="text-danger">
                                                @error('work_phone')
                                                    ( {{ $message }} )
                                                @enderror
                                                @error('work_country_phone_id')
                                                    ( {{ $message }} )
                                                @enderror


                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- date_of_hiring --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="date" name="date_of_hiring"
                                            class="form-control border border-info @error('date_of_hiring') border-danger @enderror"
                                            id="tb-date_of_hiring"
                                            value="{{ old('date_of_hiring', isset($employee->date_of_hiring) ? $employee->date_of_hiring : null) }}"
                                            placeholder="Date Of Hiring">
                                        <label for="tb-date_of_hiring">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i> Date
                                            Of Hiring
                                            <strong class="text-danger">
                                                @error('date_of_hiring')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- date_termination --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="date" name="date_termination"
                                            class="form-control border border-info @error('date_termination') border-danger @enderror"
                                            id="tb-date_termination"
                                            value="{{ old('date_termination', isset($employee->date_termination) ? $employee->date_termination : null) }}"
                                            placeholder="Date Of Termination">
                                        <label for="tb-date_termination">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i> Date
                                            Of Termination
                                            <strong class="text-danger">
                                                @error('date_termination')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- salary --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="salary" min="0" step="0.001"
                                            class="form-control border border-info @error('salary') border-danger @enderror"
                                            id="tb-salary"
                                            value="{{ old('salary', isset($employee->salary) ? $employee->salary : null) }}"
                                            placeholder="Salary">
                                        <label for="tb-salary">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>Salary
                                            <strong class="text-danger">
                                                @error('salary')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-12 groove-container">
                                    <label>
                                        <h2>Address Details :</h2>
                                    </label>

                                    <div class="row">
                                        {{-- countries --}}
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <div class="form-floating mb-3">
                                                    <select name="country_id" onchange="getCities()" id="countryId"
                                                        class="form-control form-select border border-info @error('country_id') border-danger @enderror custom_select_style">
                                                        {{-- @if (isset($countries) && $countries->count() > 0)
                                                            <option>--- Select Country ---<span>*</span> </option>

                                                            @foreach ($countries as $country)
                                                                <option value="{{ $country->id }}"
                                                                    @if ($country->id == $employee->country_id) selected @endif>
                                                                    {{ $country->name_en ?? '------' }} (
                                                                    {{ $country->name_ar ?? '------' }})
                                                                </option>
                                                            @endforeach
                                                        @else
                                                            <option>
                                                                No Countries Please Check With Admin
                                                            </option>
                                                        @endif --}}
                                                        <option>--- Select Country ---<span>*</span> </option>
                                                        @forelse ($countries as $country)
                                                            <option value="{{ $country->id }}"
                                                                {{ (old('country_id') ?? $employee->country_id) == $country->id ? 'selected' : '' }}>
                                                                {{ $country->name_en }}
                                                                ({{ $country->name_ar }})
                                                            </option>
                                                        @empty
                                                            <option value="">
                                                                No Nationality Please Check With Admin
                                                            </option>
                                                        @endforelse
                                                    </select>
                                                    <strong class="text-danger">
                                                        @error('country_id')
                                                            ( {{ $message }} )
                                                        @enderror


                                                    </strong>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- city_id --}}
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <div class="form-floating mb-3">
                                                    <input type="hidden" name="city_id_old_value" id="city_id_old_value"
                                                        value="{!! isset($employee->city_id) ? $employee->city_id : null !!}">

                                                    <select name="city_id"
                                                        class="form-control form-select border border-info custom_select_style"
                                                        id="city_id">
                                                        <option value="">--- Select City ---</option>
                                                    </select>
                                                    <strong class="text-danger">
                                                        @error('city_id')
                                                            ( {{ $message }} )
                                                        @enderror

                                                    </strong>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- address --}}
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label>address : <strong class="text-danger">
                                                        @error('address')
                                                            ( {{ $message }} )
                                                        @enderror
                                                    </strong></label>
                                                <textarea name="address" class="form-control border border-info @error('address') border-danger @enderror"
                                                    rows="5" placeholder="address">{{ old('address', isset($employee->address) ? $employee->address : null) }}
                                                </textarea>
                                            </div>
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
    {{-- passed the test in https://validatejavascript.com/ using custom JS config --}}
    {{-- select 2 script --}}
    <script>
        $(document).ready(function() {
            $('select[name="nationality"]').select2();
            $('select[name="country_id"]').select2();
            $('select[name="city_id"]').select2();

            // Add red border initially if the dropdown is empty
            // addRedBorderIfEmpty($('select[name="nationality"]'));
            // addRedBorderIfEmpty($('select[name="country_id"]'));
            // addRedBorderIfEmpty($('select[name="city_id"]'));

            // Event listener to add or remove red border on input change
            // $('select[name="nationality"], select[name="customer_id"]').on('change', function() {
            //     addRedBorderIfEmpty($(this));
            // });

            // function addRedBorderIfEmpty($select) {
            //     if ($select.val().trim() === '') {
            //         $select.next('.select2-container').addClass('border border-danger');
            //     } else {
            //         $select.next('.select2-container').removeClass('border border-danger');
            //     }
            // }
        });
    </script>


    <script>
        $(document).ready(function() {
            var country_id = document.getElementById('countryId').value;

            if (country_id) {
                var formData = new FormData($('#editForm')[0]);

                var fullRoute = "{{ route('super_admin.employees-getCities', 'country_id=:country_id') }}";
                fullRoute = fullRoute.replace(':country_id', country_id);
                $.ajax({
                    type: 'POST',
                    url: fullRoute,
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function(data) {
                        console.log(data.cities)
                        if (data.status == true) {

                            var selectCities = '<option value="">--- Select City ---</option>';
                            for (var key in data.cities) {
                                // skip loop if the property is from prototype
                                if (!data.cities.hasOwnProperty(key)) continue;

                                var obj = data.cities[key];
                                // alert(obj.id);
                                for (var prop in obj) {
                                    // skip loop if the property is from prototype
                                    if (!obj.hasOwnProperty(prop)) continue;

                                    // your code
                                    var city_id_old_value = $("#city_id_old_value").val();
                                    if (city_id_old_value) {
                                        if (obj.id == city_id_old_value) {
                                            selectCities += '<option value="' + obj.id + '" selected>' +
                                                obj.name_ar + (obj.name_en) + '</option>';
                                        } else {
                                            selectCities += '<option value="' + obj.id + '">' + obj
                                                .name_ar + (obj.name_en) + '</option>';
                                        }
                                    } else {
                                        selectCities += '<option value="' + obj.id + '">' + obj
                                            .name_ar + (obj.name_en) + '</option>';
                                    }

                                    break;
                                }
                            }
                            $('#city_id').html(selectCities);
                        }

                    },
                    error: function(reject) {
                        var response = $.parseJSON(reject.responseText);
                        $.each(response.errors, function(key, val) {
                            $("#" + key + "_error").text(val[0]);
                        });
                    }
                });

            }
            getCities();
        });

        function getCities() {
            // console.log("erge");
            var formData = new FormData($('#editForm')[0]);
            $.ajax({
                type: 'POST',
                url: "{{ route('super_admin.employees-getCities') }}",
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function(data) {
                    console.log(data.cities)
                    if (data.status == true) {

                        var selectCities = '<option value="">--- Select City ---</option>';

                        for (var key in data.cities) {
                            // skip loop if the property is from prototype
                            if (!data.cities.hasOwnProperty(key)) continue;

                            var obj = data.cities[key];
                            // alert(obj.id);
                            for (var prop in obj) {
                                // skip loop if the property is from prototype
                                if (!obj.hasOwnProperty(prop)) continue;

                                // your code
                                var city_id_old_value = $("#city_id_old_value").val();
                                if (city_id_old_value) {
                                    if (obj.id == city_id_old_value) {
                                        selectCities += '<option value="' + obj.id + '" selected>' + obj
                                            .name_ar + (obj.name_en) + '</option>';
                                    } else {
                                        selectCities += '<option value="' + obj.id + '">' + obj.name_ar + ' ' +
                                            (obj.name_en) + '</option>';
                                    }
                                } else {
                                    selectCities += '<option value="' + obj.id + '">' + obj.name_ar + ' ' + (obj
                                        .name_en) + '</option>';
                                }


                                break;
                            }
                        }
                        // var city_id ="{{ $employee->city_id }}";
                        // $('#city_id').val(city_id);
                        $('#city_id').html(selectCities);
                        var old_city_id = "{{ old('city_id', $employee->city_id) }}";
                        $('#city_id').val(old_city_id);
                        // var old_city_id = "{{ old('city_id', $employee->city_id) }}";
                        // $('#city_id').val(old_city_id);

                    }

                },
                error: function(reject) {
                    var response = $.parseJSON(reject.responseText);
                    $.each(response.errors, function(key, val) {
                        $("#" + key + "_error").text(val[0]);
                    });
                }
            });


        }
    </script>
@endsection
