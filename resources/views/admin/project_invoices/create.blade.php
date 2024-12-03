@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Add New Invoice</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.project_invoices-index') }}">All Admins</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add New</li>
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
                        <h4 class="card-title mb-3 pb-3 border-bottom">Add New Invoice :</h4>
                        <form action="{{ route('super_admin.project_invoices-store') }}" method="POST"
                            enctype="multipart/form-data" id="createForm">
                            @csrf
                            <div class="row">

                                {{-- customer_id --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <select name="customer_id" onchange="getCustomerProjects()"
                                            class="form-control form-select border border-info @error('customer_id') border-danger @enderror custom_select_style">
                                            @if (isset($customers) && $customers->count() > 0)
                                                <option value="">Select Customer Name</option>
                                                @foreach ($customers as $customer)
                                                    @if ($customer->projects->count() > 0)
                                                        <option value="{{ $customer->id }}"
                                                            @if (old('customer_id') == $customer->id) selected @endif>
                                                            {{ isset($customer->name_en) ? $customer->name_en : '------' }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            @else
                                                <option value="">Enter Customer first</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                {{-- project_id --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <select name="project_id"
                                            class="form-control form-select border border-info @error('project_id') border-danger @enderror custom_select_style"
                                            id="project"> <!-- Add an ID for easier targeting -->
                                            <option value="">Select Project...</option>
                                            <!-- Options will be populated dynamically through AJAX -->
                                        </select>
                                    </div>
                                </div>

                                {{-- amount --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="amount" min="1" step="0.001"
                                            class="form-control border border-info @error('amount') border-danger @enderror"
                                            id="tb-amount" value="{{ old('amount') }}" placeholder="amount">
                                        <label for="tb-amount">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                            amount
                                            <strong class="text-danger">
                                                @error('amount')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>


                                {{-- invoice_due_date --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="date" name="invoice_due_date" min="1" step="0.001"
                                            class="form-control border border-info @error('invoice_due_date') border-danger @enderror"
                                            id="tb-invoice_due_date" value="{{ old('invoice_due_date') }}"
                                            placeholder="Invoice Due Date">
                                        <label for="tb-invoice_due_date">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                            Invoice Due Date
                                            <strong class="text-danger">
                                                @error('invoice_due_date')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- Status --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <select name="status" id="statusSelect"
                                            class="form-control form-select border border-info @error('status') border-danger @enderror custom_select_style">
                                            <option>--- Choose Status ---</option>
                                            <option value="1" @if (old('status') == 1) selected @endif
                                                @if (old('status') == null) selected @endif>Open </option>
                                            {{-- <option value="2" @if (old('status') == 2) selected @endif>
                                                Hold </option> --}}
                                            <option value="3" @if (old('status') == 3) selected @endif>
                                                Cancelled </option>
                                            <option value="4" @if (old('status') == 4) selected @endif>
                                                Paid </option>
                                        </select>
                                    </div>
                                </div>


                                {{-- payment_method --}}
                                <div class="col-md-6" id="paymentMethod">
                                    <div class="mb-3">
                                        <select name="payment_method"
                                            class="form-control form-select border border-info custom_select_style"
                                            id="paymentMethodSelect">
                                            <option>--- Select Payment Method ---</option>
                                            <option value="1" @if (old('payment_method') == 1 || old('payment_method') === null) selected @endif>Cash
                                            </option>
                                            <option value="2" @if (old('payment_method') == 2) selected @endif>
                                                Check
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                {{-- receipt_file --}}
                                <div class="col-md-6" id="receiptSection" style="display: none;">
                                    <div
                                        class="mb-3 border border-info rounded p-3 @error('receipt_file') border-danger @enderror">
                                        <div class="form-group">
                                            <label for="imgInp" class="mb-1">Receipt File :</label>
                                            <input type="file" name="receipt_file"
                                                class="form-control-file @error('receipt_file') is-invalid @enderror"
                                                id="imgInp">
                                            @error('receipt_file')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- check_due_date --}}
                                <div class="col-md-6" id="checkDueDateContainer"
                                    @if (old('payment_method') != 2) style="display:none" @endif>
                                    <div class="form-floating mb-3">
                                        <input type="date" name="check_due_date"
                                            class="form-control border border-info" id="tb-check_due_date"
                                            value="{{ old('check_due_date') }}" placeholder="check duodate">
                                        <label for="tb-check_due_date">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                            check due date
                                            <strong class="text-danger">
                                                @error('check_due_date')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- note --}}
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label>Note : <strong class="text-danger">
                                                @error('note')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong></label>
                                        <textarea name="note" class="form-control border border-info @error('description') border-danger @enderror"
                                            rows="5" placeholder="Note">{{ old('note') }}</textarea>
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
    {{-- customers_projects --}}
    <script>
        $(document).ready(function() {
            // Trigger the initial population
            getCustomerProjects();

            // Event listener for changes in customer_id field
            $('#customer_id').on('change', function() {
                getProjectsForCustomer(); // Fetch new projects when customer_id changes
            });

            function getProjectsForCustomer() {
                var customer_id = $('#customer_id').val(); // Fetch the updated customer ID
                if (customer_id) {
                    var fullRoute =
                        "{{ route('super_admin.project_invoices-getProjectsForCustomer', 'customer_id=:customer_id') }}";
                    fullRoute = fullRoute.replace(':customer_id', customer_id);
                    $.ajax({
                        type: 'POST',
                        url: fullRoute,
                        processData: false,
                        contentType: false,
                        cache: false,
                        success: function(data) {
                            if (data.status == true) {
                                var selectProject = '<option value="">Select Project</option>';
                                data.projects.forEach(function(obj) {
                                    selectProject += '<option value="' + obj.id + '">' + obj
                                        .name_en + '</option>';
                                });
                                $('#project_id').html(selectProject); // Populate the project dropdown
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
            }
        });


        function getCustomerProjects() {
            var formData = new FormData($('#createForm')[0]);
            $.ajax({
                type: 'POST',
                url: "{{ route('super_admin.project_invoices-getProjectsForCustomer') }}",
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function(data) {
                    if (data.status == true) {

                        var selectProject = '<option value="">Select Project</option>';
                        for (var key in data.projects) {
                            if (!data.projects.hasOwnProperty(key)) continue;

                            var obj = data.projects[key];
                            for (var prop in obj) {
                                if (!obj.hasOwnProperty(prop)) continue;
                                var name = $("#name").val();
                                if (name) {
                                    if (obj.id == name) {

                                        selectProject += '<option value="' + obj.id + '" selected>' + obj
                                            .name_en +
                                            '</option>';
                                    } else {
                                        selectProject += '<option value="' + obj.id + '">' + obj.name_en +
                                            '</option>';
                                    }
                                } else {
                                    selectProject += '<option value="' + obj.id + '">' + obj.name_en +
                                        '</option>';
                                }
                                break;
                            }
                        }
                        $('#project').html(selectProject);
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

    <script>
        $(document).ready(function() {
            // Initially hide check due date if payment method is not 'Check'
            if ($('#paymentMethodSelect').val() != '2') {
                $('#checkDueDateContainer').hide();
            }

            // Show/hide check due date based on payment method selection
            $('#paymentMethodSelect').change(function() {
                if ($(this).val() == '2') {
                    $('#checkDueDateContainer').show();
                } else {
                    $('#checkDueDateContainer').hide();
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#statusSelect').on('change', function() {
                var selectedStatus = $(this).val();
                if (selectedStatus == 4) {
                    $('#receiptSection').show();
                } else {
                    $('#receiptSection').hide();
                }
            });

            // Trigger change event on page load to set initial visibility
            $('#statusSelect').trigger('change');
        });
    </script>
@endsection
