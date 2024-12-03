@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <h2 class="page-title">Accounts</h2>
            <div class="col-md-5 align-self-center">
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.accounts-index') }}">Accounts</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Update Account Info</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Create --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.accounts-create') }}" class="btn btn-dark">
                            <i data-feather="plus" class="fill-white feather-sm"></i> Add New Account
                        </a>
                    </div>
                    {{-- Show --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.accounts-show', isset($account->id) ? $account->id : -1) }}"
                            class="btn btn-primary">
                            <i data-feather="eye" class="fill-white feather-sm"></i> View Account
                        </a>
                    </div>

                    {{-- Delete --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.accounts-softDelete', isset($account->id) ? $account->id : -1) }}"
                            class="confirm btn btn-danger">
                            <i data-feather="trash" class="fill-white feather-sm"></i> Delete Account
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
                        <form action="{{ route('super_admin.accounts-update', isset($account->id) ? $account->id : -1) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">

                                {{-- title_ar --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="title_ar"
                                            class="form-control border border-info @error('title_ar') border-danger @enderror"
                                            id="tb-title_ar"
                                            value="{{ isset($account->title_ar) ? $account->title_ar : null }}"
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
                                            value="{{ isset($account->title_en) ? $account->title_en : null }}"
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
                                                <option value="1" @if ($account->status == 'Active') selected @endif
                                                    @if ($account->status == null) selected @endif>Active</option>
                                                <option value="2" @if ($account->status == 'Inactive') selected @endif>
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

                                {{-- account_type --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                            <select name="account_type"
                                                class="form-control form-select border border-info @error('account_type') border-danger @enderror custom_select_style">
                                                <option>--- Select Account Type ---</option>
                                                <option value="1" @if ($account->account_type == 'Main') selected @endif
                                                    @if ($account->account_type == null) selected @endif>Main</option>
                                                <option value="2" @if ($account->account_type == 'Sub') selected @endif>
                                                    Sub </option>
                                            </select>

                                            <label for="tb-name">
                                                <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                                Account Type
                                                <strong class="text-danger">
                                                    @error('account_type')
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
                                                    <option value="">--- Select Employee Name --- </option>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}"
                                                            @if ($user->id == $account->assigned_to_employee_id) selected @endif>
                                                            {{ $user->name ?? '------' }}
                                                        </option>
                                                    @endforeach
                                                @else
                                                    <option value="">
                                                        No Employee Please Check With Admin
                                                    </option>
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
                                                @if (isset($allAccounts) && $allAccounts->count() > 0)
                                                    <option value="">--- Select Account --- </option>
                                                    @foreach ($allAccounts as $allAccount)
                                                        <option value="{{ $allAccount->id }}"
                                                            @if ($allAccount->id == $account->parent_id) selected @endif>
                                                            {{ $allAccount->title_ar ?? '------' }}
                                                            ({{ $allAccount->title_en ?? '------' }})
                                                        </option>
                                                    @endforeach
                                                @else
                                                    <option value="">
                                                        No Accounts Please Check With Admin
                                                    </option>
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
            $('select[name="assigned_to_employee_id"]').select2();
            $('select[name="parent_id"]').select2();
        });
    </script>
@endsection
