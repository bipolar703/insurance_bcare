@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Expenses</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.expenses-index') }}">Expenses</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Update Expense Info</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Create --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.expenses-create') }}" class="btn btn-dark">
                            <i data-feather="plus" class="fill-white feather-sm"></i>New Expense
                        </a>
                    </div>
                    {{-- Show --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.expenses-show', isset($expense->id) ? $expense->id : -1) }}"
                            class="btn btn-primary">
                            <i data-feather="eye" class="fill-white feather-sm"></i> View Expense
                        </a>
                    </div>

                    {{-- Delete --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.expenses-softDelete', isset($expense->id) ? $expense->id : -1) }}"
                            class="confirm btn btn-danger">
                            <i data-feather="trash" class="fill-white feather-sm"></i> Delete Expense
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
                        <form action="{{ route('super_admin.expenses-update', isset($expense->id) ? $expense->id : -1) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">

                                {{-- title --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="title"
                                            class="form-control border border-info @error('title') border-danger @enderror"
                                            id="tb-title" value="{{ isset($expense->title) ? $expense->title : null }}"
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

                                {{-- expense_date --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="date" name="expense_date"
                                            class="form-control border border-info @error('expense_date') border-danger @enderror"
                                            id="tb-expense_date"
                                            value="{{ isset($expense->expense_date) ? $expense->expense_date : null }}"
                                            placeholder="Expense Date">
                                        <label for="tb-expense_date">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>Expense
                                            Date
                                            <strong class="text-danger">
                                                @error('expense_date')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- amount --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="amount" min="0.01" step="0.001"
                                            class="form-control border border-info @error('amount') border-danger @enderror"
                                            id="tb-amount" value="{{ isset($expense->amount) ? $expense->amount : null }}"
                                            placeholder="amount">
                                        <label for="tb-amount">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i> amount
                                            <strong class="text-danger">
                                                @error('amount')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- expense_file --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="file" name="expense_file"
                                            value="{{ isset($expense->expense_file) ? $expense->expense_file : null }}"
                                            class="form-control border border-info @error('expense_file') border-danger @enderror"
                                            id="expense_file">
                                        <label for="expense_file">
                                            <i data-feather="file" class="feather-sm text-info fill-white me-2"></i>Expense
                                            File
                                            <strong class="text-danger">
                                                @error('expense_file')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- category_id --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                            <select name="category_id"
                                                class="form-control form-select border border-info @error('category_id') border-danger @enderror custom_select_style">
                                                @if (isset($expensesTypes) && $expensesTypes->count() > 0)
                                                    <option value="">--- Select Category --- </option>
                                                    @foreach ($expensesTypes as $expenseType)
                                                        <option value="{{ $expenseType->id }}"
                                                            @if ($expenseType->id == $expense->category_id) selected @endif>
                                                            {{ $expenseType->title_ar ?? '------' }}
                                                            ({{ $expenseType->title_en ?? '------' }})
                                                        </option>
                                                    @endforeach
                                                @else
                                                    <option value="">
                                                        No Category Please Check With Admin
                                                    </option>
                                                @endif
                                            </select>
                                            <label for="tb-name">
                                                <strong class="text-danger">
                                                    @error('category_id')
                                                        ( {{ $message }} )
                                                    @enderror
                                                </strong>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                {{-- location_id --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                            <select name="location_id"
                                                class="form-control form-select border border-info @error('location_id') border-danger @enderror custom_select_style">
                                                @if (isset($costsCenters) && $costsCenters->count() > 0)
                                                    <option value="">--- Select Category --- </option>
                                                    @foreach ($costsCenters as $costsCenter)
                                                        <option value="{{ $costsCenter->id }}"
                                                            @if ($costsCenter->id == $expense->location_id) selected @endif>
                                                            {{ $costsCenter->title_ar ?? '------' }}
                                                            ({{ $costsCenter->title_en ?? '------' }})
                                                        </option>
                                                    @endforeach
                                                @else
                                                    <option value="">
                                                        No Employees Please Check With Admin
                                                    </option>
                                                @endif
                                            </select>
                                            <label for="tb-name">
                                                <strong class="text-danger">
                                                    @error('location_id')
                                                        ( {{ $message }} )
                                                    @enderror
                                                </strong>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                {{-- account_id --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                            <select name="account_id"
                                                class="form-control form-select border border-info @error('account_id') border-danger @enderror custom_select_style">
                                                @if (isset($accounts) && $accounts->count() > 0)
                                                    <option value="">--- Select Account --- </option>
                                                    @foreach ($accounts as $account)
                                                        <option value="{{ $account->id }}"
                                                            @if ($account->id == $expense->account_id) selected @endif>
                                                            {{ $account->title_ar ?? '------' }}
                                                            ({{ $account->title_en ?? '------' }})
                                                        </option>
                                                    @endforeach
                                                @else
                                                    <option value="">
                                                        No Account Please Check With Admin
                                                    </option>
                                                @endif
                                            </select>
                                            <label for="tb-name">
                                                <strong class="text-danger">
                                                    @error('account_id')
                                                        ( {{ $message }} )
                                                    @enderror
                                                </strong>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                {{-- vendor_id --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                            <select name="vendor_id"
                                                class="form-control form-select border border-info @error('vendor_id') border-danger @enderror custom_select_style">
                                                @if (isset($vendors) && $vendors->count() > 0)
                                                    <option value="">--- Select vendor Name --- </option>
                                                    @foreach ($vendors as $vendor)
                                                        <option value="{{ $vendor->id }}"
                                                            @if ($vendor->id == $expense->vendor_id) selected @endif>
                                                            {{ $vendor->name_en ?? '------' }}
                                                            ({{ $vendor->name_ar ?? '------' }})
                                                        </option>
                                                    @endforeach
                                                @else
                                                    <option value="">
                                                        No vendor Please Check With Admin
                                                    </option>
                                                @endif
                                            </select>
                                            <label for="tb-name">
                                                <strong class="text-danger">
                                                    @error('vendor_id')
                                                        ( {{ $message }} )
                                                    @enderror
                                                </strong>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                {{-- asset_id --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                            <select name="asset_id"
                                                class="form-control form-select border border-info @error('asset_id') border-danger @enderror custom_select_style">
                                                @if (isset($varableAssets) && $varableAssets->count() > 0)
                                                    <option value="">--- Select Asset Types Name --- </option>
                                                    @foreach ($varableAssets as $varableAsset)
                                                        <option value="{{ $varableAsset->id }}"
                                                            @if ($varableAsset->id == $expense->asset_id) selected @endif>
                                                            {{ $varableAsset->title ?? '------' }}
                                                        </option>
                                                    @endforeach
                                                @else
                                                    <option value="">
                                                        No Assets Please Check With Admin
                                                    </option>
                                                @endif
                                            </select>
                                            <label for="tb-name">
                                                <strong class="text-danger">
                                                    @error('asset_id')
                                                        ( {{ $message }} )
                                                    @enderror
                                                </strong>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                {{-- status --}}
                                {{-- <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                            <select name="status"
                                                class="form-control form-select border border-info @error('status') border-danger @enderror custom_select_style">
                                                <option>--- Select Status ---</option>
                                                <option value="1" @if ($expense->status == 'Active') selected @endif
                                                    @if ($expense->status == null) selected @endif>Active</option>
                                                <option value="2" @if ($expense->status == 'Inactive') selected @endif>
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
                                </div> --}}

                                {{-- Description --}}
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label>Description : <strong class="text-danger">
                                                @error('description')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong></label>
                                        <textarea name="description" class="form-control border border-info @error('description') border-danger @enderror"
                                            rows="5" placeholder="Description">{{ isset($expense->description) ? $expense->description : null }}</textarea>
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
            $('select[name="category_id"]').select2();
            $('select[name="location_id"]').select2();
            $('select[name="vendor_id"]').select2();
            $('select[name="asset_id"]').select2();
            $('select[name="account_id"]').select2();
        });
    </script>
@endsection
