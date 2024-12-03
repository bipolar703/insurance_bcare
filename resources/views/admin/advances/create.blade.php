@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Advances</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.advances-index') }}">Advances</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add New Advance</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Archive --}}
                    {{-- <div class="dropdown me-2">
                        <a href="{{ route('super_admin.advances-showSoftDelete') }}" class="btn btn-danger">
                            <i data-feather="archive" class="fill-white feather-sm"></i> View Archive
                        </a>
                    </div> --}}
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
                        <form action="{{ route('super_admin.advances-store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                {{-- title --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="title"
                                            class="form-control border border-info @error('title') border-danger @enderror"
                                            id="tb-name" value="{{ old('title') }}" placeholder="Title">
                                        <label for="tb-name">
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
                                        <input type="number" name="amount" min="0.001" step="0.001"
                                            class="form-control border border-info @error('amount') border-danger @enderror"
                                            id="tb-name" value="{{ old('amount') }}" placeholder="amount">
                                        <label for="tb-name">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i> Amount
                                            <strong class="text-danger">
                                                @error('amount')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- file --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="file" name="file"
                                            class="form-control border border-info @error('file') border-danger @enderror"
                                            id="tb-name" value="{{ old('file') }}" placeholder="File">
                                        <label for="tb-name">
                                            File :
                                            <strong class="text-danger">
                                                @error('file')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- payment_on_salary --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <select name="payment_on_salary" id="payment-on-salary"
                                            class="form-control form-select border border-info @error('payment_on_salary') border-danger @enderror custom_select_style">
                                            <option>--- Select Payment On Salary ---</option>
                                            <option value="1" {{ old('payment_on_salary') == '1' ? 'selected' : '' }}>
                                                Yes</option>
                                            <option value="2" {{ old('payment_on_salary') == '2' ? 'selected' : '' }}>
                                                No</option>
                                        </select>
                                    </div>
                                </div>



                                {{-- employee_id --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                            <strong class="text-danger">
                                                @error('employee_id')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                            <select name="employee_id"
                                                class="form-control form-select border border-info @error('employee_id') border-danger @enderror custom_select_style">
                                                @if (isset($users) && $users->count() > 0)
                                                    <option value="">Select Employee Name</option>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}"
                                                            @if (old('employee_id') == $user->id) selected @endif>
                                                            {{ isset($user->name) ? $user->name : '------' }}
                                                        </option>
                                                    @endforeach
                                                @else
                                                    <option value="">No Location Are Available</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                {{-- account_id --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                            <strong class="text-danger">
                                                @error('account_id')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
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
                                                    <strong class="text-danger">
                                                        @error('account_id')
                                                            ( {{ $message }} )
                                                        @enderror
                                                    </strong>
                                                @else
                                                    <option value="">No Accounts Are Available</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                {{-- monthly_payment --}}
                                <div class="col-md-6" id="monthly-payment-wrapper" style="display: none;">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="monthly_payment" min="0.001" step="0.001"
                                            class="form-control border border-info @error('monthly_payment') border-danger @enderror"
                                            id="tb-name" value="{{ old('monthly_payment') }}"
                                            placeholder="Monthly Payment">
                                        <label for="tb-name">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                            Monthly Payment
                                            <strong class="text-danger">
                                                @error('monthly_payment')
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
            $('select[name="employee_id"]').select2();
            $('select[name="account_id"]').select2();
        });
    </script>


    <script>
        $(document).ready(function() {
            // Function to show/hide monthly-payment-wrapper based on payment_on_salary value
            function toggleMonthlyPaymentWrapper() {
                if ($('#payment-on-salary').val() == '1') {
                    $('#monthly-payment-wrapper').show();
                } else {
                    $('#monthly-payment-wrapper').hide();
                }
            }

            // Initial call to toggleMonthlyPaymentWrapper
            toggleMonthlyPaymentWrapper();

            // Event listener for payment_on_salary change
            $('#payment-on-salary').change(function() {
                toggleMonthlyPaymentWrapper();
            });
        });
    </script>
@endsection
