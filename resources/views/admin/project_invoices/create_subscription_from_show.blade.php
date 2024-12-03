@extends('admin.layouts.app')
@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12">
                <h2 class="page-title">
                    <a href="{{ route('super_admin.projects-show', ['id' => $projectSubscription->project_id]) }}">
                        {{ isset($projectSubscription->project->name_en) ? $projectSubscription->project->name_en : null }}
                    </a>
                </h2>
            </div>


            <br>


            <div class="col-12">
                <h2 class="page-title">
                    <a href="{{ route('super_admin.projects-show', ['id' => $projectSubscription->project_id]) }}">
                        {{ isset($projectSubscription->project->name_ar) ? $projectSubscription->project->name_ar : null }}
                    </a>
                </h2>
            </div>


            <div class="col-md-5 align-self-center">
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add New Subscription Invoice</li>
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
            <div class="col-12">
                {{-- Form Section --}}
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3 pb-3 border-bottom">Add New Subscription Invoice :</h4>
                        <form action="{{ route('super_admin.project_invoices-storeSubscriptionInvoiceComingFromShow') }}"
                            method="POST" enctype="multipart/form-data" id="createForm">
                            @csrf
                            <div class="row">
                                <div>
                                    <h4>Maximum Amount You Can Enter Is :<span style="color: red"> {{ $remainingAmount }}
                                            JOD </span></h4>
                                </div>
                                <input type="hidden" name="subscriptionTotal" value="{{ $remainingAmount }}">

                                {{-- id --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="id" min="1" required
                                            class="form-control border border-info @error('id') border-danger @enderror"
                                            id="tb-id" value="{{ old('id') }}" placeholder="ID">
                                        <label for="tb-id">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i> ID
                                            <strong class="text-danger">
                                                @error('id')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- amount --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="amount" min="1" step="0.001" required
                                            max="{{ $remainingAmount }}"
                                            class="form-control border border-info @error('amount') border-danger @enderror"
                                            id="tb-amount" value="{{ old('amount') }}" placeholder="Amount">
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

                                {{-- Status --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <select name="status" id="statusMethod" required
                                            class="form-control form-select border border-info @error('status') border-danger @enderror custom_select_style">
                                            <option>--- Select Status ---</option>
                                            <option value="1" @if (old('status') == 1) selected @endif
                                                @if (old('status') == null) selected @endif>Open</option>
                                            {{-- <option value="2" @if (old('status') == 2) selected @endif>
                                                Hold </option> --}}
                                            {{-- <option value="3" @if (old('status') == 3) selected @endif>
                                                Cancelled </option> --}}
                                            <option value="4" @if (old('status') == 4) selected @endif>
                                                Paid </option>
                                        </select>
                                    </div>
                                </div>

                                {{-- payment_method --}}
                                <div class="col-md-6" id="paymentMethod">
                                    <div class="mb-3">
                                        <select name="payment_method" required
                                            class="form-control form-select border border-info custom_select_style"
                                            id="paymentMethodSelect">
                                            <option>--- Select Payment Method ---</option>
                                            <option value="1" @if (old('payment_method') == 1 || old('payment_method') === null) selected @endif>Cash
                                            </option>
                                            <option value="2" @if (old('payment_method') == 2) selected @endif>Check
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                {{-- invoice_due_date --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="date" name="invoice_due_date"
                                            class="form-control border border-info" id="tb-invoice_due_date"
                                            value="{{ old('invoice_due_date') }}" placeholder="Invoice Due Date">
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

                                {{-- receipt_file --}}
                                <div class="col-md-6" id="previewReceiptFile">
                                    <div class="form-floating mb-3">
                                        <input type="file" name="receipt_file"
                                            class="form-control border border-info @error('receipt_file') border-danger @enderror"
                                            id="imgInp">
                                        <label for="imgInp">
                                            <i data-feather="file" class="feather-sm text-info fill-white me-2"></i>
                                            Invoice File
                                            <strong class="text-danger">
                                                @error('receipt_file')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- check_due_date --}}
                                <div class="col-md-6" id="checkDueDateContainer"
                                    @if (old('payment_method') != 2) style="display:none" @endif>
                                    <div class="form-floating mb-3">
                                        <input type="date" name="check_due_date"
                                            class="form-control border border-info" id="tb-check_due_date"
                                            value="{{ old('check_due_date') }}" placeholder="Check Due Date">
                                        <label for="tb-check_due_date">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                            Check Due Date
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

                                {{-- project_id --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="hidden" name="project_id"
                                            class="form-control border border-info @error('project_id') border-danger @enderror"
                                            id="tb-project_id"
                                            value="{{ $projectSubscription->project_id ?? old('$projectSubscription->project_id') }}">
                                    </div>
                                </div>

                                {{-- subscription_id --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="hidden" name="subscription_id"
                                            class="form-control border border-info @error('subscription_id') border-danger @enderror"
                                            id="tb-subscription_id"
                                            value="{{ $projectSubscription->id ?? old('projectSubscription->id') }}">
                                    </div>
                                </div>

                                {{-- customer_id --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="hidden" name="customer_id"
                                            class="form-control border border-info @error('customer_id') border-danger @enderror"
                                            id="tb-customer_id"
                                            value="{{ $projectSubscription->customer_id ?? old('$projectSubscription->customer_id') }}">
                                    </div>
                                </div>


                                <div id="errorMessage" class="text-danger"></div>

                                {{-- add new payment --}}
                                <div id="rowContainer" style="display: none;">
                                    <div id="totalContractsValidationMessageContainer"></div>

                                    <div class="container groove-container" id="feeContainer">
                                        <div>
                                            <label>
                                                <h3>Extra Fees :</h3>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <button type="button" id="addPayment" class="btn btn-primary mt-3">Add Another
                                        Fee</button>
                                </div>

                                {{-- Button --}}
                                <div class="col-12">
                                    <div class="d-md-flex align-items-center mt-3">
                                        <div class="ms-auto mt-3 mt-md-0">
                                            <button type="submit"
                                                class="btn btn-success font-weight-medium rounded-pill px-4">
                                                <div class="d-flex align-items-center">
                                                    <i data-feather="plus" class="feather-sm fill-white me-2"></i>
                                                    Add New Invoice
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
            // Initially hide check due date if payment method is not 'Check'
            if ($('#statusMethod').val() != '4') {
                $('#uploadReceiptFile').hide();
                $('#previewReceiptFile').hide();
            }

            $('#statusMethod').change(function() {
                if ($(this).val() == '4') {
                    $('#uploadReceiptFile').show();
                    $('#previewReceiptFile').show();
                } else {
                    $('#previewReceiptFile').hide();
                    $('#uploadReceiptFile').hide();
                }
            });
        });
    </script>

    {{-- passed the test in https://validatejavascript.com/ using custom JS config --}}
    {{-- payment amount --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById('createForm');
            const errorMessageContainer = document.getElementById('errorMessage');

            function setupPaymentValidation(feeTitle, paymentAmountInput) {
                feeTitle.addEventListener('input', validatePaymentFields);
                paymentAmountInput.addEventListener('input', validateTotalAmount);
            }

            function validatePaymentFields() {
                const currentType = this.value.trim();
                const currentAmount = this.closest('.row').querySelector('[name^="fee_amount"]').value.trim();

                if (currentType !== '' && currentAmount === '') {
                    this.closest('.row').querySelector('[name^="fee_amount"]').classList.add('border',
                        'border-danger');
                } else if (currentType === '' && currentAmount !== '') {
                    this.classList.add('border', 'border-danger');
                } else {
                    this.closest('.row').querySelector('[name^="fee_amount"]').classList.remove('border',
                        'border-danger');
                    this.classList.remove('border', 'border-danger');
                }
            }

            function validateTotalAmount() {
                const feeAmountInputs = document.querySelectorAll('[name^="fee_amount"]');
                let totalAmount = 0;

                feeAmountInputs.forEach(input => {
                    const inputValue = input.value.trim();
                    const feeAmount = inputValue !== '' ? parseFloat(inputValue) : 0;
                    totalAmount += feeAmount;
                });

                const paymentAmount = parseFloat(document.getElementById('tb-amount').value.trim());

                if (totalAmount > paymentAmount) {
                    errorMessageContainer.innerText = 'Total fee amount cannot exceed the payment amount.';
                } else {
                    errorMessageContainer.innerText = ''; // Clear error message if total amount is valid
                }
            }



            form.addEventListener("submit", function(event) {
                const paymentAmount = parseFloat(document.getElementById('tb-amount').value.trim());
                const feeAmountInputs = document.querySelectorAll('[name^="fee_amount"]');
                let totalAmount = 0;

                feeAmountInputs.forEach(input => {
                    if (input.value.trim() !== '') {
                        totalAmount += parseFloat(input.value.trim());
                    }
                });

                if (totalAmount > paymentAmount) {
                    errorMessageContainer.innerText = 'Total fee amount cannot exceed the payment amount.';
                    event.preventDefault(); // Prevent form submission
                } else {
                    errorMessageContainer.innerText = ''; // Clear error message if total amount is valid
                }
            });


            form.addEventListener("submit", function(event) {
                const paymentAmount = parseFloat(document.getElementById('tb-amount').value.trim());
                const feeAmountInputs = document.querySelectorAll('[name^="fee_amount"]');
                let totalAmount = 0;

                feeAmountInputs.forEach(input => {
                    if (input.value.trim() !== '') {
                        totalAmount += parseFloat(input.value.trim());
                    }
                });

                if (totalAmount > paymentAmount) {
                    errorMessageContainer.innerText = 'Total fee amount cannot exceed the payment amount.';
                    event.preventDefault(); // Prevent form submission
                }
            });


            document.getElementById('addPayment').addEventListener('click', function() {
                const feeContainer = document.getElementById('feeContainer');
                const newRow = document.createElement('div');
                newRow.classList.add('row', 'mb-3');
                newRow.innerHTML = `
                    <div class="col-md-4">
                        <label for="fee_title">Fee Title</label>
                        <input type='text' name='title[]' required class='form-control border border-info' placeholder='Fee Title'>
                    </div>

                    <div class="col-md-4">
                        <label for="feeAmount">Fee Amount</label>
                        <input type='number' name='fee_amount[]' required min='0' step='0.001' class='form-control border border-info' placeholder='Fee Amount'>
                    </div>

                    <div class="col-md-3">
                        <label for="fee_attachment">Fee File</label>
                        <input type='file' name='attachment[]' required class='form-control border border-info' placeholder='Fee Attachment'>
                    </div>

                    <div class="col-md-1 d-flex align-items-center">
                        <button type="button" class="btn btn-danger btn-sm deleteRow">Delete</button>
                    </div>
            `;

                feeContainer.appendChild(newRow);

                const newFeeTitle = newRow.querySelector('[name^="title"]');
                const newFeeAmount = newRow.querySelector('[name^="fee_amount"]');

                setupPaymentValidation(newFeeTitle, newFeeAmount);
            });

            form.addEventListener("submit", function(event) {
                const paymentAmount = parseFloat(document.getElementById('tb-amount').value.trim());
                const feeAmountInputs = document.querySelectorAll('[name^="fee_amount"]');
                let totalAmount = 0;

                feeAmountInputs.forEach(input => {
                    if (input.value.trim() !== '') {
                        totalAmount += parseFloat(input.value.trim());
                    }
                });

                if (totalAmount > paymentAmount) {
                    errorMessageContainer.innerText = 'Total fee amount cannot exceed the payment amount.';
                    event.preventDefault(); // Prevent form submission
                }
            });

            // Other event listeners and functions remain unchanged
            // Ensure that the event listeners for adding payments and form submission are not duplicated
            document.getElementById('feeContainer').addEventListener('click', function(event) {
                if (event.target.classList.contains('deleteRow')) {
                    // Ask for confirmation before deleting
                    const confirmed = confirm('Are you sure you want to delete this row?');

                    if (confirmed) {
                        const row = event.target.closest('.row'); // Get the row to be deleted
                        const container = document.getElementById('rowContainer'); // Get the container

                        row.remove(); // Delete the row on delete button click
                        validateTotalAmount(); // Re-validate after deletion

                        // Check if there are any rows left, if not, hide the container
                        if (container.querySelectorAll('.row').length === 0) {
                            container.style.display = 'none';
                        }
                    }
                }
            });
            // Show the container when triggered
            document.getElementById('addPayment').addEventListener('click', function() {
                const rowContainer = document.getElementById('rowContainer');
                rowContainer.style.display = 'block';
            });

        });
    </script>

    <script>
        document.getElementById('createForm').addEventListener('submit', function(event) {
            if (document.getElementById('tb-id').value === '' && document.getElementById('tb-amount').value ===
                '' && document.getElementById('statusMethod').value === '' && document.getElementById(
                    'paymentMethodSelect').value === '') {
                event.preventDefault();
                // Use SweetAlert for the alert
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'ID , Amount ,Status ,Payment Method fields are required!',
                });
            }
        });
    </script>
@endsection
