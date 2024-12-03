@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Add New Project</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.projects-index') }}">All Projects</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add New Project</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Archive --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.projects-showSoftDelete') }}" class="btn btn-danger">
                            <i data-feather="archive" class="fill-white feather-sm"></i> View Archived Project
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
                        <h4 class="card-title mb-3 pb-3 border-bottom">Add New Project :</h4>
                        <form action="{{ route('super_admin.projects-store') }}" method="POST"
                            enctype="multipart/form-data" id="createForm">
                            @csrf
                            <div class="row">

                                {{-- name_ar --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="name_ar" required
                                            class="form-control border border-info @error('name_ar') border-danger @enderror"
                                            id="tb-name_ar" value="{{ old('name_ar') }}" placeholder="Name AR">
                                        <label for="tb-name_ar">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i> Name AR
                                            <span>*</span>
                                            <strong class="text-danger">
                                                @error('name_ar')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- name_en --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="name_en" required
                                            class="form-control border border-info @error('name_en') border-danger @enderror"
                                            id="tb-name_en" value="{{ old('name_en') }}" placeholder="Name EN">
                                        <label for="tb-name_en">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i> Name EN
                                            <span>*</span>
                                            <strong class="text-danger">
                                                @error('name_en')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <select name="customer_id" required id="selectCustomer"
                                            class="form-control form-select border border-info @error('customer_id') border-danger @enderror custom_select_style"
                                            style="width: 100%">
                                            @if (isset($customers) && $customers->count() > 0)
                                                <option value="">Select Customer Name <span>*</span></option>
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->id }}"
                                                        @if (old('customer_id') == $customer->id) selected @endif>
                                                        {{ isset($customer->name_en) ? $customer->name_en : '------' }}
                                                        ({{ isset($customer->name_ar) ? $customer->name_ar : '------' }})
                                                    </option>
                                                @endforeach
                                            @else
                                                <option value="">No Customers Are Available</option>
                                            @endif
                                        </select>
                                        <strong class="text-danger">
                                            @error('customer_id')
                                                ( {{ $message }} )
                                            @enderror


                                        </strong>

                                    </div>
                                </div>

                                {{-- total_contracts --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="total_contracts" id="totalContrcat" min="1"
                                            step="0.001" required
                                            class="form-control border border-info @error('total_contracts') border-danger @enderror"
                                            id="tb-total_contracts" value="{{ old('total_contracts') }}"
                                            placeholder="Total Contract">
                                        <label for="tb-total_contracts">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i> Total
                                            Contracts <span>*</span>
                                            <strong class="text-danger">
                                                @error('total_contracts')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- signing_date --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="date" name="signing_date" id="signingDate" required
                                            class="form-control border border-info @error('signing_date') border-danger @enderror"
                                            value="{{ old('signing_date') }}" placeholder="Signing Date">
                                        <label for="signingDate">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                            Signing Date <span>*</span>
                                            <strong class="text-danger">
                                                @error('signing_date')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <select name="project_salesman" required id="selectSalesMen"
                                            class="form-control form-select border border-info @error('project_salesman') border-danger @enderror custom_select_style"
                                            style="width: 100%">
                                            @if (isset($salesmen) && $salesmen->count() > 0)
                                                <option value="">Select Salesman <span>*</span></option>
                                                @foreach ($salesmen as $salesman)
                                                    <option value="{{ $salesman->id }}"
                                                        @if (old('project_salesman') == $salesman->id) selected @endif>
                                                        {{ isset($salesman->name) ? $salesman->name : '------' }}
                                                    </option>
                                                @endforeach
                                            @else
                                                <option value="">No Sales Person Are Available</option>
                                            @endif
                                        </select>
                                        <strong class="text-danger">
                                            @error('project_salesman')
                                                ( {{ $message }} )
                                            @enderror


                                        </strong>
                                    </div>
                                </div>

                                {{-- total_hosting --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="total_hosting" min="0" step="0.001"
                                            class="form-control border border-info @error('total_hosting') border-danger @enderror"
                                            id="totalHosting" value="{{ old('total_hosting') }}"
                                            placeholder="Total Hosting">
                                        <label for="totalHosting">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                            Total Hosting
                                            <strong class="text-danger">
                                                @error('total_hosting')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- total_support --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="total_support" min="0" step="0.001"
                                            class="form-control border border-info @error('total_support') border-danger @enderror"
                                            id="totalSupport" value="{{ old('total_support') }}"
                                            placeholder="Total Support">
                                        <label for="totalSupport">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                            Total Support
                                            <strong class="text-danger">
                                                @error('total_support')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- due_date_hosting --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="date" name="due_date_hosting" id="dueDateHosting"
                                            class="form-control border border-info @error('due_date_hosting') border-danger @enderror"
                                            value="{{ old('due_date_hosting') }}" placeholder="Due Date Hosting">
                                        <label for="dueDateHosting">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                            Due Date Hosting
                                            <strong class="text-danger">
                                                @error('due_date_hosting')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- due_date_support --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="date" name="due_date_support" id="dueDateSupport"
                                            class="form-control border border-info @error('due_date_support') border-danger @enderror"
                                            value="{{ old('due_date_support') }}" placeholder="Due Date Support">
                                        <label for="dueDateSupport">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                            Due Date Support
                                            <strong class="text-danger">
                                                @error('due_date_support')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- launch_date --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="date" name="launch_date" id="launchDate"
                                            class="form-control border border-info @error('launch_date') border-danger @enderror"
                                            value="{{ old('launch_date') }}" placeholder="Launch Date">
                                        <label for="launchDate">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                            Launch Date
                                            <strong class="text-danger">
                                                @error('launch_date')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- customer_project_coordinator_name --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="customer_project_coordinator_name"
                                            class="form-control border border-info @error('customer_project_coordinator_name') border-danger @enderror"
                                            id="tb-customer_project_coordinator_name"
                                            value="{{ old('customer_project_coordinator_name') }}"
                                            placeholder="Customer Coordinator Name">
                                        <label for="tb-customer_project_coordinator_name">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                            Customer Coordinator Name
                                            <strong class="text-danger">
                                                @error('customer_project_coordinator_name')
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
                                        <select name="country_phone_id" id="countryPhoneId"
                                            class="numbersList text-center col-md-4" style="border-color: #e2e2e2">
                                            <option value="">--- Select Country Code ---</option>
                                            @foreach ($countries as $phone_key)
                                                <option value="{{ $phone_key->id }}"
                                                    @if (old('country_phone_id') == $phone_key->id) selected @endif>

                                                    {{ isset($phone_key->phone_code) ? $phone_key->name_en . ' (' . $phone_key->phone_code . '+)' : '------' }}

                                                </option>
                                            @endforeach
                                        </select>
                                    @endif
                                    {{-- phone --}}
                                    <div class="form-floating mb-3 col-md-8">
                                        <input type="number" name="customer_project_coordinator_phone" min="0"
                                            class="form-control border border-info  phone_No  @error('customer_project_coordinator_phone') border-danger @enderror"
                                            id="coordinatorPhone" value="{{ old('customer_project_coordinator_phone') }}"
                                            placeholder="customer_project_coordinator_phone">
                                        <label for="coordinatorPhone">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                            Customer Project Coordinator Phone
                                            <strong class="text-danger">
                                                @error('customer_project_coordinator_phone')
                                                    ( {{ $message }} )
                                                @enderror
                                                @error('country_phone_id')
                                                    ( {{ $message }} )
                                                @enderror
                                                @error('phone_not_valid')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- type --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                            <select name="type" id="selectType"
                                                class="form-control form-select border border-info @error('type') border-danger @enderror custom_select_style">
                                                <option value="">--- Choose Type * ---</option>
                                                <option value="1" @if (old('type') == 1) selected @endif
                                                    @if (old('type') == null) selected @endif>Web </option>
                                                <option value="2" @if (old('type') == 2) selected @endif>
                                                    Mobile </option>
                                                <option value="3" @if (old('type') == 3) selected @endif>
                                                    Web + Mobile </option>
                                                <option value="4" @if (old('type') == 4) selected @endif>
                                                    Hosting </option>
                                                <option value="5" @if (old('type') == 5) selected @endif>
                                                    Support </option>
                                                <option value="6" @if (old('type') == 6) selected @endif>
                                                    Design </option>
                                                <option value="7" @if (old('type') == 7) selected @endif>
                                                    Social Media </option>
                                                <option value="8" @if (old('type') == 8) selected @endif>
                                                    Design + Social Media</option>
                                                <option value="9" @if (old('type') == 9) selected @endif>
                                                    Other </option>
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


                                {{-- domain_url --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="domain_url"
                                            class="form-control border border-info @error('domain_url') border-danger @enderror"
                                            id="domainUrl" value="{{ old('domain_url') }}" placeholder="Domian URL">
                                        <label for="domainUrl">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                            Domian URL
                                            <strong class="text-danger">
                                                @error('domain_url')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- Subscriptions Status --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                            <select name="subscriptions_status" id="selectSubscriptionsStatus"
                                                class="form-control form-select border border-info @error('subscriptions_status') border-danger @enderror custom_select_style">
                                                <option value="">--- Choose Status * ---</option>
                                                <option value="1" @if (old('subscriptions_status') == 1) selected @endif
                                                    @if (old('subscriptions_status') == null) selected @endif>No </option>
                                                <option value="2" @if (old('subscriptions_status') == 2) selected @endif>
                                                    Yes </option>
                                            </select>
                                            <label for="tb-name">
                                                <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                                Subscriptions Status
                                                <strong class="text-danger">
                                                    @error('subscriptions_status')
                                                        ( {{ $message }} )
                                                    @enderror
                                                </strong>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                {{-- Subscriptions Types --}}
                                <div class="col-md-6" id="subscriptionsTypes" style="display: {{old('subscriptions_status') && old('subscriptions_status') == 2 ? 'block' : 'none'}}">
                                    <h4 class="card-title mb-3 pb-3 border-bottom">Please choose required Subscription
                                        Type, and its amount :
                                    
                                    </h4>
                                    <strong class="text-danger">
                                        @error('subscriptions_types_checkboxes')
                                            ( {{ $message }} )
                                        @enderror
                                    </strong>
                                    <div class="mb-3">

                                        @if (isset($subscriptionsTypes) && $subscriptionsTypes->count() > 0)
                                            @foreach ($subscriptionsTypes as $subscriptionsType)
                                                <div class="row mb-2">
                                                    <div class="col-md-6">
                                                        <input type="checkbox" name="subscriptions_types_checkboxes[]"
                                                            id="subscription_type{{ $subscriptionsType->id }}"
                                                            value="{{ $subscriptionsType->id }}" class="form-check-input"
                                                            @if (in_array($subscriptionsType->id, old('subscriptions_types_checkboxes', []))) checked @endif>
                                                        <label for="subscription_type{{ $subscriptionsType->id }}"
                                                            class="form-check-label me-5 mb-3">
                                                            {!! $subscriptionsType->title_en ? $subscriptionsType->title_en : null !!}
                                                        </label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="number" step=".001"
                                                            name="subscription_type_amount{{ $subscriptionsType->id }}"
                                                            id="subscription_type_amount{{ $subscriptionsType->id }}"
                                                            value="{{ old('subscription_type_amount' . $subscriptionsType->id) }}"
                                                            class="form-control"
                                                            placeholder="Enter amount for {{ $subscriptionsType->title_en }}"
                                                            style="width: 100%; display: {{old('subscription_type_amount' . $subscriptionsType->id) ? 'block' : 'none'}}"
                                                            oninput="addRemoveBorder(this)">
                                                    </div>

                                                </div>
                                            @endforeach
                                        @endif



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
                                            rows="5" placeholder="Description">{{ old('description') }}</textarea>
                                    </div>
                                </div>




                                <hr>
                                <h3>Project Contract :</h3>
                                <br>


                                {{-- project_contract_title --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="title"
                                            class="form-control border border-info @error('title') border-danger @enderror"
                                            id="projectContractTitle" value="{{ old('title') }}"
                                            placeholder="Project Contract Title">
                                        <label for="projectContractTitle">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                            Project Contract Title
                                            <strong class="text-danger">
                                                @error('title')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- project_contratc_file --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="file" name="file"
                                            class="form-control border border-info @error('file') border-danger @enderror"
                                            id="projectContractFile">
                                        <label for="projectContractFile">
                                            <i data-feather="file"
                                                class="feather-sm text-info fill-white me-2"></i>Project Contract File
                                            <strong class="text-danger">
                                                @error('file')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                <hr>
                                {{-- add new payment --}}
                                <h3>Project Payments :</h3>
                                <br>

                                <div id="totalContractsValidationMessageContainer"></div>
                                <strong class="text-danger" style="font-family: monospace; font-size: 12px;">
                                    @error('total_payment_table')
                                        ( {{ $message }} )
                                    @enderror

                                </strong>

                                <div class="container" id="paymentContainer">
                                    <div class="row" id="paymentRow1">

                                        <div class="col-md-3">
                                            <label for="payment_types1">Payment Title</label> <input type='text'
                                                name='payment_title[]' id="payment_types1" required
                                                class='form-control border border-info' placeholder='Payment Title'>
                                            <label for="tb-payment_types" style="width: 10  ch; display: inline-block;">
                                                <strong class="text-danger"
                                                    style="font-family: monospace; font-size: 12px;">
                                                    @error('payment_title.*')
                                                        ( {{ $message }} )
                                                    @enderror


                                                </strong>
                                            </label>
                                        </div>

                                        <div class="col-md-2">
                                            <label for="payment_date1">Payment Date</label>
                                            <input type='date' name='payment_date[]' id="payment_date1"
                                                class='form-control border border-info' placeholder='Payment Date'>
                                            <label for="tb-payment_dates" style="width: 10  ch; display: inline-block;">
                                                <strong class="text-danger"
                                                    style="font-family: monospace; font-size: 12px;">
                                                    @error('payment_date.*')
                                                        ( {{ $message }} )
                                                    @enderror

                                                </strong>
                                            </label>

                                        </div>

                                        <div class="col-md-2">
                                            <label for="payment_amount1">Payment Amount</label>
                                            <input type='number' name='payment_amount[]' id="payment_amount1" required`
                                                min='1' step='0.01' class='form-control border border-info'
                                                placeholder='Payment Amount'>
                                            <label for="tb-payment_amount">
                                                <strong class="text-danger">
                                                    @error('payment_amount.*')
                                                        ( {{ $message }} )
                                                    @enderror
                                                </strong>
                                            </label>
                                        </div>

                                        <div class="col-md-5">
                                            <label for="payment_description1">Payment Description</label>
                                            <textarea name='payment_description[]' id="payment_description1" class='form-control border border-info'
                                                rows='1' placeholder='Payment Description'></textarea>
                                            <label for="tb-payment_descriptions">
                                                <strong class="text-danger">
                                                    @error('payment_description.*')
                                                        ( {{ $message }} )
                                                    @enderror
                                                </strong>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <button type="button" id="addPayment" class="btn btn-primary mt-3">Add Another
                                        Payment</button>
                                </div>

                                {{-- Button --}}
                                <div class="col-12">
                                    <div class="d-md-flex align-items-center mt-3">
                                        <div class="ms-auto mt-3 mt-md-0">
                                            <button type="button" id="submitForm"
                                                class="btn btn-success font-weight-medium rounded-pill px-4">
                                                <div class="d-flex align-items-center">
                                                    <i data-feather="plus" class="feather-sm fill-white me-2"></i>
                                                    Add New Project
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
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
@section('extra_js')
    {{-- redboarder style --}}
    <style>
        .empty-field {
            border: 1px solid red;
        }

        .remove {
            display: none;
        }
    </style>
    {{-- ================================ ADD OR REMOVE RED BORDER ================================  --}}
    {{-- ============================== EDITED BY: Raghad ALKarasneh ==============================  --}}

    {{-- Project contract file and title --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById('createForm');
            const titleInput = document.getElementById('projectContractTitle');
            const fileInput = document.getElementById('projectContractFile');

            titleInput.addEventListener('input', function() {
                validateProjectFields(titleInput, fileInput);
            });

            fileInput.addEventListener('input', function() {
                validateProjectFields(titleInput, fileInput);
            });

            function validateProjectFields(titleInput, fileInput) {
                const currentTitle = titleInput.value.trim();
                const currentFile = fileInput.value.trim();

                if (currentTitle !== '' && currentFile === '') {
                    fileInput.classList.add('border', 'border-danger');
                    titleInput.classList.remove('border', 'border-danger');
                    return false;
                } else if (currentTitle === '' && currentFile !== '') {
                    titleInput.classList.add('border', 'border-danger');
                    fileInput.classList.remove('border', 'border-danger');
                    return false;
                } else {
                    titleInput.classList.remove('border', 'border-danger');
                    fileInput.classList.remove('border', 'border-danger');
                    return true;
                }
            }
        });
    </script>

    {{-- Required fields --}}

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById('createForm');
            var checkboxes = document.getElementsByName('subscriptions_types_checkboxes[]');


            function setupPaymentValidation(paymentType, paymentAmount) {
                paymentType.addEventListener('input', validatePaymentFields);
                paymentAmount.addEventListener('input', validatePaymentFields);
            }
            const fieldsToValidate = [
                'name_ar',
                'name_en',
                'customer_id',
                'total_contracts',
                'signing_date',
                'project_salesman',
                'type',
                'subscriptions_status'
            ];
            // Appear and disappear the amount field after check the Subscriptions types
            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    var subscriptionTypeId = this.value;
                    var amountInput = document.getElementById('subscription_type_amount' +
                        subscriptionTypeId);
                    if (this.checked) {
                        // Add the amount input field to the fieldsToValidate array
                        fieldsToValidate.push('subscription_type_amount' + subscriptionTypeId);

                        // Show the amount input field
                        amountInput.style.display = 'block';
                        amountInput.classList.add('border', 'border-danger');
                    } else {
                        // Remove the amount input field from the fieldsToValidate array
                        var index = fieldsToValidate.indexOf('subscription_type_amount' +
                            subscriptionTypeId);
                        if (index !== -1) {
                            fieldsToValidate.splice(index, 1);
                        }
                        // Hide the amount input field
                        amountInput.style.display = 'none';
                        amountInput.value = ""; // Set the value to an empty string

                    }
                });
            });


            fieldsToValidate.forEach(fieldName => {

                const field = form.querySelector(`[name="${fieldName}"]`);

                // Check if field is empty when the page loads
                if (field.value.trim() === '') {
                    field.classList.add('border', 'border-danger');
                }

                // Add event listeners for input event to toggle the CSS class
                field.addEventListener('input', function() {
                    if (this.value.trim() === '') {
                        this.classList.add('border', 'border-danger');
                    } else {
                        this.classList.remove('border', 'border-danger');
                    }
                });
            });


        });

        function addRemoveBorder(inputElement) {
            if (inputElement.value.trim() === '') {

                inputElement.classList.add('border', 'border-danger');
            } else {
              
                inputElement.classList.remove('border', 'border-danger');
            }
            // inputElement.classList.remove('border', 'border-danger');
        }
    </script>
    {{-- Customer and salesman  --}}
    <script>
        $(document).ready(function() {
            $('select[name="project_salesman"]').select2();
            $('select[name="customer_id"]').select2();

            // Add red border initially if the dropdown is empty
            addRedBorderIfEmpty($('select[name="project_salesman"]'));
            addRedBorderIfEmpty($('select[name="customer_id"]'));

            // Event listener to add or remove red border on input change
            $('select[name="project_salesman"], select[name="customer_id"]').on('change', function() {
                addRedBorderIfEmpty($(this));
            });

            function addRedBorderIfEmpty($select) {
                if ($select.val().trim() === '') {
                    $select.next('.select2-container').addClass('border border-danger');
                } else {
                    $select.next('.select2-container').removeClass('border border-danger');
                }
            }
            // ************************************ Done By Raghad **********************************
           
        });
    </script>
    {{-- ================================ SHOW/HIDE subscriptions Types =================================  --}}
    {{-- =================================== Done BY: Raghad ALKarasneh =================================  --}}
    <script>
         $(document).ready(function() {
             $('#selectSubscriptionsStatus').change(function() {
                var selectedValue = $('#selectSubscriptionsStatus').val();
                if (selectedValue == 2) {
                    $('#subscriptionsTypes').show(); // Show the div if value is 2
                } else {
                    $('#subscriptionsTypes').hide(); // Hide the div for other values
                    clearFilledCheckboxesAndAmounts(); // To clear the values of 
                }
            });
            // ================ To show each amount input after check the checkbox ================
            $('input[name="subscriptions_status[]"]').change(function() {
                // Get the ID of the current checkbox
                var subscriptionTypeId = $(this).val();

                // Select the corresponding subscription_type_amount input based on ID
                var subscriptionAmountInput = $('#subscription_type_amount' + subscriptionTypeId);

                // Toggle the visibility based on whether the checkbox is checked
                if ($(this).prop('checked')) {
                    subscriptionAmountInput.show();

                } else {
                    subscriptionAmountInput.value="";
                    subscriptionAmountInput.hide();
                }
            });
            // ========================== Clear checkboxes and amount values only if they are filled ==========================
            function clearFilledCheckboxesAndAmounts() {
                var checkboxes = document.getElementsByName('subscriptions_types_checkboxes[]');
                checkboxes.forEach(function (checkbox) {
                    var subscriptionTypeId = checkbox.value;
                    var amountInput = document.getElementById('subscription_type_amount' + subscriptionTypeId);

                    // Check if the checkbox is checked or the amount input has a non-empty value
                    if (checkbox.checked || amountInput.value.trim() !== "") {
                        checkbox.checked = false;
                        amountInput.value = ""; // Set the value to an empty string
                        amountInput.style.display = 'none';
                    }
                });
            }
        });

    </script>

    {{-- ===================================== Payment Table =======================================  --}}
    {{-- ============================== EDITED BY: Raghad ALKarasneh ==============================  --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById('createForm');

            function setupPaymentValidation(paymentType, paymentAmount) {
                paymentType.addEventListener('input', validatePaymentFields);
                paymentAmount.addEventListener('input', validatePaymentFields);
            }

            function validatePaymentFields() {
                const currentType = this.value.trim();
                const currentAmount = this.closest('.row').querySelector('[name^="payment_amount"]').value.trim();

                if (currentType !== '' && currentAmount === '') {
                    this.closest('.row').querySelector('[name^="payment_amount"]').classList.add('border',
                        'border-danger');
                } else if (currentType === '' && currentAmount !== '') {
                    this.classList.add('border', 'border-danger');
                } else {
                    this.closest('.row').querySelector('[name^="payment_amount"]').classList.remove('border',
                        'border-danger');
                    this.classList.remove('border', 'border-danger');
                }
            }

            document.getElementById('addPayment').addEventListener('click', function() {
                const paymentContainer = document.getElementById('paymentContainer');
                const newRow = document.createElement('div');
                newRow.classList.add('row', 'mb-3');

                newRow.innerHTML = `
            <div class="col-md-3">
                <label for="payment_types1">Payment Title</label>
                <input type='text' name='payment_title[]' class='form-control border border-info' required placeholder='Payment Title'>
            </div>

            <div class="col-md-2">
                <label for="payment_date1">Payment Date</label>
                <input type='date' name='payment_date[]' class='form-control border border-info' placeholder='Payment Date'>
            </div>

            <div class="col-md-2">
                <label for="payment_amount1">Payment Amount</label>
                <input type='number' name='payment_amount[]' min='1' step='0.01' required class='form-control border border-info' placeholder='Payment Amount'>
            </div>

            <div class="col-md-4">
                <label for="payment_description1">Payment Description</label>
                <textarea name='payment_description[]' class='form-control border border-info' rows='1' placeholder='Payment Description'></textarea>
            </div>

            <div class="col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-danger btn-sm deleteRow">Delete</button>
            </div>
        `;

                paymentContainer.appendChild(newRow);

                const newPaymentType = newRow.querySelector('[name^="payment_title"]');
                const newPaymentAmount = newRow.querySelector('[name^="payment_amount"]');

                setupPaymentValidation(newPaymentType, newPaymentAmount);
            });

            form.addEventListener("submit", function(event) {
                if (!validatePayments()) {
                    event.preventDefault(); // Prevent form submission
                    Swal.fire("Please fill out all required payment fields.");
                }
            });

            function validatePayments() {
                let isValid = true;
                const paymentTypes = document.querySelectorAll('[name^="payment_title"]');
                const paymentAmounts = document.querySelectorAll('[name^="payment_amount"]');

                paymentTypes.forEach((paymentType, index) => {
                    const currentType = paymentType.value.trim();
                    const currentAmount = paymentAmounts[index].value.trim();

                    if ((currentType !== '' && currentAmount === '') || (currentType === '' &&
                            currentAmount !== '')) {
                        isValid = false;
                        paymentType.classList.add('border', 'border-danger');
                        paymentAmounts[index].classList.add('border', 'border-danger');
                    } else {
                        paymentType.classList.remove('border', 'border-danger');
                        paymentAmounts[index].classList.remove('border', 'border-danger');
                    }
                });

                return isValid;
            }

            // Event delegation for delete button on dynamically added rows
            document.querySelector('#paymentContainer').addEventListener('click', function(event) {
                if (event.target.classList.contains('deleteRow')) {
                    event.target.closest('.row').remove(); // Delete the row on delete button click
                    validatePayments(); // Re-validate after deletion
                }
            });
        });
    </script>

    
    <script>
    // {{-- payment and total_contracts --}}
        document.addEventListener("DOMContentLoaded", function() {
            initializeForm();

            function initializeForm() {
                const form = document.getElementById('createForm');
                const addPaymentBtn = document.getElementById('addPayment');
                const totalContractsInput = document.querySelector('[name="total_contracts"]');
                const paymentAmountInputs = document.querySelectorAll('[name^="payment_amount"]');
                const messageContainer = document.getElementById('totalContractsValidationMessageContainer');

                function validateTotalPayments() {
                    const totalContracts = parseFloat(totalContractsInput.value);
                    const paymentAmountInputs = document.querySelectorAll('[name^="payment_amount[]"]');

                    let totalPayments = 0;

                    paymentAmountInputs.forEach(input => {
                        const amount = parseFloat(input.value.trim());
                        if (!isNaN(amount)) {
                            totalPayments += amount;
                        }
                    });

                    console.log('Total Contracts:', totalContracts);
                    console.log('Total Payments:', totalPayments);

                    if (totalPayments < totalContracts) {
                        showMessage('Total Payments is Less Than Total Contracts');
                        addPaymentBtn.classList.remove('remove');
                        return false;
                    }

                    if (totalPayments > totalContracts) {
                        showMessage('Total Payments is more Than Total Contracts');
                        addPaymentBtn.classList.remove('remove');
                        return false;
                    }

                    hideMessage();

                    addPaymentBtn.classList.add('remove');
                    return true;
                }

                function attachPaymentAmountListeners() {
                    const paymentAmountInputs = document.querySelectorAll('[name^="payment_amount[]"]');
                    paymentAmountInputs.forEach(input => {
                        input.addEventListener('input', validateTotalPayments);
                    });
                }

                // Call the function to attach listeners to existing payment amount inputs
                attachPaymentAmountListeners();

                // Add event listener to dynamically created inputs after adding them to the DOM
                document.getElementById('addPayment').addEventListener('click', function() {
                    // Your code to dynamically add payment inputs...

                    // After adding the inputs, attach event listeners to them
                    attachPaymentAmountListeners();
                });



                // Attach the functions to the form and input elements after DOMContentLoaded
                // form.addEventListener('submit', handleFormSubmit);
                totalContractsInput.addEventListener('input', validateTotalPayments);

                paymentAmountInputs.forEach(function(paymentAmountInput) {
                    paymentAmountInput.addEventListener('input', validateTotalPayments);
                });

                function showMessage(message) {
                    const alertDiv = document.createElement('div');
                    alertDiv.classList.add('alert', 'alert-danger');
                    alertDiv.textContent = message;
                    messageContainer.innerHTML = ''; // Clear previous messages
                    messageContainer.appendChild(alertDiv);
                }

                function hideMessage() {
                    messageContainer.innerHTML = ''; // Clear the message container
                }
            }

            // Event delegation for dynamically added rows (assumes a parent container with id 'paymentContainer')
            document.getElementById('paymentContainer').addEventListener('click', function(event) {
                if (event.target.classList.contains('deleteRow')) {
                    event.target.closest('.row').remove(); // Delete the row on delete button click
                    initializeForm(); // Reinitialize the form after dynamic changes
                }
            });
        });
        // =====================================================================================================
        // ========================================= Submit Validation =========================================
        // =========================================== DONE BY RAGHAD ==========================================
        // =====================================================================================================

        document.addEventListener('DOMContentLoaded', function() {

            // Submit Form + Validation
            $("#submitForm").click(function() {
                const form = document.getElementById('createForm');
                var totalContrcat = Number(document.getElementById('totalContrcat').value);
                var totalHosting = Number(document.getElementById('totalHosting').value);
                var totalSupport = Number(document.getElementById('totalSupport').value);
                var domainUrl = document.getElementById('domainUrl').value;
                var signingDate = document.getElementById('signingDate').value;
                var dueDateHosting = document.getElementById('dueDateHosting').value;
                var dueDateSupport = document.getElementById('dueDateSupport').value;
                var launchDate = document.getElementById('launchDate').value;
                var countryPhoneId = document.getElementById('countryPhoneId').value;
                var coordinatorPhone = document.getElementById('coordinatorPhone').value;
                var projectContractTitle = document.getElementById('projectContractTitle');
                var projectContractFile = document.getElementById('projectContractFile');
                var customerId = Number(document.getElementById('selectCustomer')
                    .value); // getElementById return string value, this is why we used Number
                var salesManId = Number(document.getElementById('selectSalesMen').value);
                var typeValue = Number(document.getElementById('selectType').value);
                var SubscriptionsStatusValue = Number(document.getElementById('selectSubscriptionsStatus').value);
                var checkboxes = document.getElementsByName('subscriptions_types_checkboxes[]');
                var customerIdsArray = @json($customerIdsArray);
                var salesMenIdsArray = @json($salesMenIdsArray);
                var subscriptionsTypesArray = @json($subscriptionsTypes);
                var subscriptionTypeIds = subscriptionsTypesArray.map(subscription => subscription.id); // To check the value of checkboxes
                var totalPaymentAmount = 0;
                var ValidationError = 0;
                var errorOccurred = false;
                var notValidCheckboxValue = false;

                //////////////////////////////////////////////////////////////////////////////////////////////////
                ////////////////////// Start Verify that all required fields have data entered //////////////////
                /////////////////////////////////////////////////////////////////////////////////////////////////
                // Fields that need to be checked for data
                const fieldsToCheck = [
                    "input[name='name_ar']",
                    "input[name='name_en']",
                    "input[name='total_contracts']",
                    "input[name='signing_date']",
                    "select[name='customer_id']",
                    "select[name='project_salesman']",
                    "select[name='type']",
                    "select[name='subscriptions_status']",
                ];

                let allFieldsFilled = true;
                // ==================== Check the checkboxes and amounts, and add them to fieldsToCheck array ====================
                if (SubscriptionsStatusValue == 2) {
                    // Check that at least one checkbox is checked
                    if (Array.from(checkboxes).some(checkbox => checkbox.checked)) {
                        checkboxes.forEach(function(checkbox) {
                            // Check the amount of each checkbox
                            var subscriptionTypeId = checkbox.value;
                            var amountInput = document.getElementById('subscription_type_amount' +
                                subscriptionTypeId);


                            if (checkbox.checked) {
                                // The value of checkbox is not valid
                                if (!subscriptionTypeIds.includes(parseInt(checkbox.value))) {
                                    notValidCheckboxValue = true;

                                }
                                // Add the amount input field to the fieldsToCheck array
                                fieldsToCheck.push("input[name='subscription_type_amount" +
                                    subscriptionTypeId + "']");
                            } else {
                                // Remove the amount input field from the fieldsToCheck array
                                var index = fieldsToCheck.indexOf(
                                    'input[name="subscription_type_amount' +
                                    subscriptionTypeId + '"]');
                                if (index !== -1) {
                                    fieldsToCheck.splice(index, 1);
                                }
                            }
                        });
                    } else {
                        // If no checkbox is checked
                        ValidationError++;
                        Swal.fire(
                            'When adding a new Project',
                            'You must choose the subscription type',
                            'question'
                        )
                        return;
                    }

                }
                // Check that the checked checkboxes values are valid
                if (notValidCheckboxValue) {
                    ValidationError++;
                    Swal.fire(
                        'When adding a new Project',
                        'You must choose a valid subscription type',
                        'question'
                    )
                    return;
                }
                // Check the required values
                $.each(fieldsToCheck, function(index, fieldSelector) {
                    const fieldValue = $(fieldSelector).val();
                    if (fieldValue === "") {
                        allFieldsFilled = false;
                    }
                });
                if (!allFieldsFilled) {
                    ValidationError++;
                    Swal.fire(
                        'When adding a new Project',
                        'You must fill the required fields',
                        'question'
                    )
                    return;
                }
                ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                /////////////////////// The customer, salesmen ID's, type, subscriptions status value limits ///////////////////////
                ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                // Customerss
                if (!customerIdsArray.includes(customerId)) {
                    ValidationError++;
                    Swal.fire(
                        'When adding a new Project',
                        'Customer value is not valid',
                        'question'
                    )
                    return;
                }

                // SalesMen
                if (!salesMenIdsArray.includes(salesManId)) {
                    ValidationError++;
                    Swal.fire(
                        'When adding a new Project',
                        'Sales man value is not valid',
                        'question'
                    )
                    return;
                }
                // Type
                if ((typeValue < 1) || (typeValue > 9)) {
                    ValidationError++;
                    Swal.fire(
                        'When adding a new Project',
                        'Type value is not valid',
                        'question'
                    )
                    return;
                }
                // Subscriptions Status
                if ((SubscriptionsStatusValue < 1) && (SubscriptionsStatusValue > 2)) {
                    ValidationError++;
                    Swal.fire(
                        'When adding a new Project',
                        'Subscriptions Status value is not valid',
                        'question'
                    )
                    return;
                }

                //////////////////////////////////////////////////////////////////////////////////////////////////
                ///////////////////////////////////// Check the dates format /////////////////////////////////////
                //////////////////////////////////////////////////////////////////////////////////////////////////


                if (signingDate && !isValidDateFormat(signingDate)) {
                    ValidationError++;
                    Swal.fire(
                        'When adding a new Project',
                        'Signing Date format is not valid',
                        'question'
                    )
                    return;
                }
                if (dueDateHosting && !isValidDateFormat(dueDateHosting)) {
                    ValidationError++;
                    Swal.fire(
                        'When adding a new Project',
                        'Due Date Hosting date format is not valid',
                        'question'
                    )
                    return;
                }

                if (dueDateSupport && !isValidDateFormat(dueDateSupport)) {
                    ValidationError++;
                    Swal.fire(
                        'When adding a new Project',
                        'Due Date Support date format is not valid',
                        'question'
                    )
                    return;
                }

                if (launchDate && !isValidDateFormat(launchDate)) {
                    ValidationError++;
                    Swal.fire(
                        'When adding a new Project',
                        'Launch Date format is not valid',
                        'question'
                    )
                    return;
                }


                ////////////////////////////////////////////////////////////////////////////////////////////////////
                ///////////////////////////////////// Check other validations //////////////////////////////////////
                ///////////////////////////////////////////////////////////////////////////////////////////////////

                // Total Contrcat value
                if (totalContrcat < 1) {
                    ValidationError++;
                    Swal.fire(
                        'When adding a new Project',
                        'Total Contracts value must be at least 1',
                        'question'
                    )
                    return;
                }
                // Total Hosting value
                if (totalHosting && totalHosting < 0) {
                    ValidationError++;
                    Swal.fire(
                        'When adding a new Project',
                        'Total Hosting value must be at least 0',
                        'question'
                    )
                    return;
                }
                // Total Support value
                if (totalSupport && totalSupport < 0) {
                    ValidationError++;
                    Swal.fire(
                        'When adding a new Project',
                        'Total Support value must be at least 0',
                        'question'
                    )
                    return;
                }

                // Domain URL value
                if (domainUrl && !isValidURL(domainUrl)) {
                    ValidationError++;
                    Swal.fire(
                        'When adding a new Project',
                        'Domain URL is not valid',
                        'question'
                    )
                    return;
                }
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                ///////////////////////////////////// Phone number and country code /////////////////////////////////////
                ////////////////////////////////////////////////////////////////////////////////////////////////////////

                // ==================== Case ONE: Country Code value is set ====================
                if (countryPhoneId) {
                    // case 1-1: Country Code is not valid
                    if ((countryPhoneId < 1) || (countryPhoneId > 250)) {
                        ValidationError++;
                        Swal.fire(
                            'When adding a new Project',
                            'Country Code is not exist',
                            'question'
                        )
                        return;
                    }

                    // case 1-2: Phone is not set or not valid
                    if (!coordinatorPhone || (coordinatorPhone && !isPhoneLengthValid(coordinatorPhone))) {
                        ValidationError++;
                        Swal.fire(
                            'When adding a new Project',
                            'Please add a valid phone number',
                            'question'
                        )
                        return;
                    }
                }
                // ==================== Case TWO: phone value is set and valid ====================
                if (coordinatorPhone && isPhoneLengthValid(coordinatorPhone)) {
                    // case 2-1: country code is not set or not valid 
                    if ((countryPhoneId === 0) || !countryPhoneId || (countryPhoneId == '')) {
                        ValidationError++;
                        Swal.fire(
                            'When adding a new Project',
                            'You must choose a Country Code',
                            'question'
                        )
                        return;
                    }
                    // case 2-2: country code is not valid 
                    if ((countryPhoneId && ((countryPhoneId < 1) || (countryPhoneId > 250)))) {
                        ValidationError++;
                        Swal.fire(
                            'When adding a new Project',
                            'You must choose a valid Country Code',
                            'question'
                        )
                        return;
                    }
                    // ==================== Case THREE: phone number is not valid  ====================
                } else if (coordinatorPhone && !isPhoneLengthValid(coordinatorPhone)) {
                    ValidationError++;
                    Swal.fire(
                        'When adding a new Project',
                        'Phone number is not valid',
                        'question'
                    )
                    return;
                }
                ////////////////////////////////////////////////////////////////////////////////////////////////////
                ///////////////////////////////////// Contract Title and File /////////////////////////////////////
                ///////////////////////////////////////////////////////////////////////////////////////////////////

                // Check of the contract file is exist or not
                if (projectContractTitle.value.trim() !== '' && projectContractFile.value.trim() ===
                    '') {
                    ValidationError++;
                    Swal.fire(
                        'When adding a new Project',
                        'Please upload the contract file since the title is filled.',
                        'question'
                    )
                    return;

                }
                if (projectContractTitle.value.trim() === '' && projectContractFile.value.trim() !==
                    '') {
                    ValidationError++;
                    Swal.fire(
                        'When adding a new Project',
                        'Please contract file title since the file is uploaded.',
                        'question'
                    )
                    return;
                }

                ///////////////////////////////////////////////////////////////////////////////////////////////////////
                ///////////////////////////////////// Payment Amount calculation /////////////////////////////////////
                /////////////////////////////////////////////////////////////////////////////////////////////////////

                // Get all radio buttons with the name "gender"
                var allPaymentAmounts = $("input[name='payment_amount[]']");


                // Loop through the radio buttons to find the selected one
                for (var i = 0; i < allPaymentAmounts.length; i++) {
                    totalPaymentAmount += Number(allPaymentAmounts[i].value)
                }
                if (totalPaymentAmount != totalContrcat) {
                    ValidationError++;
                    Swal.fire(
                        'When adding a new Project',
                        'Tot total payment amount is not equal the total contract',
                        'question'
                    )
                    return;
                }
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                // Check that Payment title and amount are filled in each record, and the payment date is valid if it is filled//
                ////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                const tableRows = document.querySelectorAll("#paymentContainer .row");;
                const paymentValidationErrors = [];
                tableRows.forEach((row) => {
                    const titleInput = row.querySelector("input[name^='payment_title[]']");
                    const amountInput = row.querySelector("input[name^='payment_amount[]']");
                    const dateInput = row.querySelector("input[name^='payment_date[]']");

                    const titleValue = titleInput.value.trim();
                    const amountValue = amountInput.value.trim();
                    const dateValue = dateInput.value.trim();

                    // Check if payment_title[] and payment_amount[] are filled
                    if (!titleValue || !amountValue) {
                        ValidationError++;
                        Swal.fire(
                            'When adding a new Project',
                            'Please fill both Payment Title and Payment Amount in each record', // Display the first error message
                            'question',

                        )
                    }

                    // Check if payment_date[] is filled and is a valid date
                    if (dateValue) {
                        const isValidDate = isValidDateFormat(dateValue);
                        if (!isValidDate) {
                            ValidationError++;
                            Swal.fire(
                                'When adding a new Project',
                                'Invalid date format in Payment Date.', // Display the first error message
                                'question',
                            )
                            return;

                        }
                    }
                });

                //     //////////////////////////////////////////////////////////////////////////////////////////////////
                //     ///////////////////////////////////// Submit the form ///////////////////////////////////////////
                //     /////////////////////////////////////////////////////////////////////////////////////////////////
                if (ValidationError == 0) {
                    $("#createForm").submit()
                }
            });


        });

        function isValidDateFormat(dateString) {
            // Define a regular expression pattern for YYYY-MM-DD format
            var pattern = /^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/;
            // Test the dateString against the pattern
            return pattern.test(dateString);
        }

        function isValidURL(url) {
            // Regular expression for a basic URL validation
            var urlPattern = /^(https?:\/\/)?([\w.-]+)\.([a-z]{2,})(\/\S*)?$/;
            // Test the URL against the pattern
            return urlPattern.test(url);
        }

        function isPhoneLengthValid(phoneNumber) {
            var phoneLength = phoneNumber.replace(/\D/g, '').length; // Remove non-numeric characters
            return phoneLength >= 9 && phoneLength <= 15;
        }
    </script>
@endsection
