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
                            <li class="breadcrumb-item active" aria-current="page">Add New Expense</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Archive --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.expenses-showSoftDelete') }}" class="btn btn-danger">
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
                        <form action="{{ route('super_admin.expenses-store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                {{-- title --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="title"
                                            class="form-control border border-info @error('title') border-danger @enderror"
                                            id="tb-title" value="{{ old('title') }}" placeholder="Title">
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

                                {{-- amount --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="amount" min="0.01" step="0.001"
                                            class="form-control border border-info @error('amount') border-danger @enderror"
                                            id="tb-amount" value="{{ old('amount') }}" placeholder="amount">
                                        <label for="tb-amount">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i> Amount
                                            <strong class="text-danger">
                                                @error('amount')
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
                                            id="tb-expense-date" value="{{ old('expense_date') }}" placeholder="Expense Date">
                                        <label for="tb-expense-date">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i> Expense
                                            Date
                                            <strong class="text-danger">
                                                @error('expense_date')
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
                                            class="form-control border border-info @error('expense_file') border-danger @enderror"
                                            id="tb-expense-file" value="{{ old('expense_file') }}" placeholder="expense_file">
                                        <label for="tb-expense-file">
                                            Expense File :
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
                                                    <option value="">Select Category Name</option>
                                                    @foreach ($expensesTypes as $expenseType)
                                                        <option value="{{ $expenseType->id }}"
                                                            @if (old('category_id') == $expenseType->id) selected @endif>
                                                            {{ isset($expenseType->title_ar) ? $expenseType->title_ar : '------' }}
                                                            ({{ isset($expenseType->title_en) ? $expenseType->title_en : '------' }})
                                                        </option>
                                                    @endforeach
                                                @else
                                                    <option value="">No Category is Available</option>
                                                @endif
                                            </select>
                                            <strong class="text-danger">
                                                @error('category_id')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </div>
                                    </div>
                                </div>

                                {{-- location_id --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                            <select name="location_id"
                                                class="form-control form-select border border-info @error('location_id') border-danger @enderror custom_select_style">
                                                @if (isset($expenseLocations) && $expenseLocations->count() > 0)
                                                    <option value="">Select Location Name</option>
                                                    @foreach ($expenseLocations as $expenseLocation)
                                                        <option value="{{ $expenseLocation->id }}"
                                                            @if (old('location_id') == $expenseLocation->id) selected @endif>
                                                            {{ isset($expenseLocation->title_ar) ? $expenseLocation->title_ar : '------' }}
                                                            ({{ isset($expenseLocation->title_en) ? $expenseLocation->title_en : '------' }})
                                                        </option>
                                                    @endforeach
                                                @else
                                                    <option value="">No Location Are Available</option>
                                                @endif
                                            </select>
                                            <strong class="text-danger">
                                                @error('location_id')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
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
                                                    <option value="">Select Vendor Name</option>
                                                    @foreach ($vendors as $vendor)
                                                        <option value="{{ $vendor->id }}"
                                                            @if (old('vendor_id') == $vendor->id) selected @endif>
                                                            {{ isset($vendor->name_en) ? $vendor->name_en : '------' }}
                                                            ({{ isset($vendor->name_ar) ? $vendor->name_ar : '------' }})
                                                        </option>
                                                    @endforeach
                                                   
                                                @else
                                                    <option value="">No Vendors Are Available</option>
                                                @endif
                                            </select>
                                            <strong class="text-danger">
                                                @error('vendor_id')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </div>
                                    </div>
                                </div>

                                {{-- asset_id --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                            <select name="asset_id"
                                                class="form-control form-select border border-info @error('asset_id') border-danger @enderror custom_select_style">
                                                @if (isset($variableAssets) && $variableAssets->count() > 0)
                                                    <option value="">Select Variable Asset Name</option>
                                                    @foreach ($variableAssets as $variableAsset)
                                                        <option value="{{ $variableAsset->id }}"
                                                            @if (old('asset_id') == $variableAsset->id) selected @endif>
                                                            {{ isset($variableAsset->title) ? $variableAsset->title : '------' }}
                                                        </option>
                                                    @endforeach
                                                   
                                                @else
                                                    <option value="">No Variable Assets Are Available</option>
                                                @endif
                                            </select>
                                            <strong class="text-danger">
                                                @error('asset_id')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
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
                                                    <option value="">Select Account Name</option>
                                                    @foreach ($accounts as $account)
                                                        <option value="{{ $account->id }}"
                                                            @if (old('account_id') == $account->id) selected @endif>
                                                            {{ isset($account->title_ar) ? $account->title_ar : '------' }}
                                                            ({{ isset($account->title_en) ? $account->title_en : '------' }})
                                                        </option>
                                                    @endforeach
                                                    
                                                @else
                                                    <option value="">No Accounts Are Available</option>
                                                @endif
                                            </select>
                                            <strong class="text-danger">
                                                @error('account_id')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </div>
                                    </div>
                                </div>

                                {{-- Description --}}
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label>Description : <strong class="text-danger">
                                                @error('description')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong></label>
                                        <textarea name="description" class="form-control border border-info @error('description') border-danger @enderror"
                                            rows="5" placeholder="Description"></textarea>
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
