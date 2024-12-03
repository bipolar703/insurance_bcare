@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">

            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Accounts</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.accounts-index') }}">Accounts</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add New Accounts</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Archive --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.accounts-showSoftDelete') }}" class="btn btn-danger">
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
            <div class="col-12">
                {{-- Form Section --}}
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('super_admin.accounts-store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                {{-- title_ar --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="title_ar"
                                            class="form-control border border-info @error('title_ar') border-danger @enderror"
                                            id="tb-name" value="{{ old('title_ar') }}" placeholder="Title AR">
                                        <label for="tb-name">
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
                                            id="tb-name" value="{{ old('title_en') }}" placeholder="Title EN">
                                        <label for="tb-name">
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
                                                <option>--- Choose Vendor Status ---</option>
                                                <option value="1" @if (old('status') == 1) selected @endif
                                                    @if (old('status') == null) selected @endif>Active</option>
                                                <option value="2" @if (old('status') == 2) selected @endif>
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

                                {{-- account_type --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                            <select name="account_type"
                                                class="form-control form-select border border-info @error('account_type') border-danger @enderror custom_select_style">
                                                <option>--- Choose Account Type ---</option>
                                                <option value="1" @if (old('account_type') == 1) selected @endif
                                                    @if (old('account_type') == null) selected @endif>Main</option>
                                                <option value="2" @if (old('account_type') == 2) selected @endif>
                                                    Sub </option>
                                            </select>
                                            <label for="tb-name">
                                                <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                                Account Type
                                                <strong class="text-danger">
                                                    @error('account_type')
                                                        ( {{ $message }} )
                                                    @enderror
                                                    @error('not_valid_account_type')
                                                        ( {{ $message }} )
                                                    @enderror
                                                </strong>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                {{-- assigned_to_employee_id --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                            <select name="assigned_to_employee_id"
                                                class="form-control form-select border border-info @error('assigned_to_employee_id') border-danger @enderror custom_select_style">
                                                @if (isset($users) && $users->count() > 0)
                                                    <option>Select Employee Name</option>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}"
                                                            @if (old('assigned_to_employee_id') == $user->id) selected @endif>
                                                            {{ isset($user->name) ? $user->name : '------' }}
                                                        </option>
                                                    @endforeach
                                                @else
                                                    <option value="">No Employee Are Available</option>
                                                @endif
                                            </select>
                                            <strong class="text-danger">
                                                @error('assigned_to_employee_id')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </div>
                                    </div>
                                </div>

                                {{-- parent_id --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                            <select name="parent_id"
                                                class="form-control form-select border border-info @error('parent_id') border-danger @enderror custom_select_style">
                                                @if (isset($accounts) && $accounts->count() > 0)
                                                    <option>Select Account Name</option>
                                                    @foreach ($accounts as $account)
                                                        <option value="{{ $account->id }}"
                                                            @if (old('parent_id') == $account->id) selected @endif>
                                                            {{ isset($account->title_ar) ? $account->title_ar : '------' }}
                                                            ({{ isset($account->title_en) ? $account->title_en : '------' }})
                                                        </option>
                                                    @endforeach
                                                @else
                                                    <option value="">No Accounts Are Available</option>
                                                @endif
                                            </select>
                                            <strong class="text-danger">
                                                @error('parent_id')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
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
                                                    Add New Account
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
            $('select[name="assigned_to_employee_id"]').select2();
            $('select[name="parent_id"]').select2();
        });
    </script>
@endsection
