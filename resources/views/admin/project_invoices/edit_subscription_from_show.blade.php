@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12">
                <h2 class="page-title">
                    <a href="{{ route('super_admin.projects-show', ['id' => $projectInvoice->project_id]) }}">
                        {{ isset($projectInvoice->project->name_en) ? $projectInvoice->project->name_en : null }}
                    </a>
                </h2>
            </div>
            <br>
            <div class="col-12">
                <h2 class="page-title">
                    <a href="{{ route('super_admin.projects-show', ['id' => $projectInvoice->project_id]) }}">
                        {{ isset($projectInvoice->project->name_ar) ? $projectInvoice->project->name_ar : null }}
                    </a>
                </h2>
            </div>
            <br>
            <div class="col-md-5 align-self-center">
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Update Invoice Info</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Show --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.project_invoices-show', isset($projectInvoice->id) ? $projectInvoice->id : -1) }}"
                            class="btn btn-primary">
                            <i data-feather="eye" class="fill-white feather-sm"></i> View
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
                        <h4 class="card-title mb-3 pb-3 border-bottom">Update invoice Info :</h4>
                        <form
                            action="{{ route('super_admin.project_invoices-updateSubscriptionInvocieFromShow', isset($projectInvoice->id) ? $projectInvoice->id : -1) }}"
                            method="POST" enctype="multipart/form-data" id="editForm">
                            @csrf
                            <div class="row">

                                <input type="hidden" name="totalAmount" value="{{ $paymentRemainingAmount }}">

                                <div>
                                    <h4>Maximum Amount You Can Enter Is :<span style="color: red">
                                            {{ $paymentRemainingAmount }}
                                            JOD </span></h4>
                                </div>

                                {{-- amount --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="amount" min="1"
                                            max="{{ $paymentRemainingAmount }}"
                                            class="form-control border border-info @error('amount') border-danger @enderror"
                                            id="tb-amount"
                                            value="{{ isset($projectInvoice->amount) ? $projectInvoice->amount : null }}"
                                            placeholder="Amount">
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

                                {{-- id --}}
                                {{-- <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="id" min="1"
                                            class="form-control border border-info @error('id') border-danger @enderror"
                                            id="tb-id"
                                            value="{{ isset($projectInvoice->id) ? $projectInvoice->id : null }}"
                                            placeholder="ID">
                                        <label for="tb-id">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i> ID
                                            <strong class="text-danger">
                                                @error('id')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div> --}}

                                {{-- Status --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                            <select name="status" id="statusMethod"
                                                class="form-control form-select border border-info @error('status') border-danger @enderror custom_select_style">
                                                <option>--- Choose Status ---</option>
                                                <option value="1" @if ($projectInvoice->status == 'Open') selected @endif
                                                    @if ($projectInvoice->status == null) selected @endif>Open
                                                </option>
                                                {{-- <option value="2" @if ($projectInvoice->status == 'Hold') selected @endif>
                                                    Hold </option> --}}
                                                <option value="3" @if ($projectInvoice->status == 'Cancelled') selected @endif>
                                                    Cancelled </option>
                                                <option value="4" @if ($projectInvoice->status == 'Paid') selected @endif>
                                                    Paid </option>
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



                                {{-- payment_method --}}
                                <div class="col-md-6" id="paymentMethod">
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                            <select name="payment_method"
                                                class="form-control form-select border border-info custom_select_style"
                                                id="paymentMethodSelect">
                                                <option>--- Choose Payment Method ---</option>
                                                <option value="1" @if ($projectInvoice->payment_method == 'Cash' || $projectInvoice->payment_method == null) selected @endif>
                                                    Cash</option>
                                                <option value="2" @if ($projectInvoice->payment_method == 'Check') selected @endif>
                                                    Check</option>
                                            </select>
                                            <label for="tb-name">
                                                <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                                Payment Method
                                                <strong class="text-danger">
                                                    @error('payment_method')
                                                        ( {{ $message }} )
                                                    @enderror
                                                </strong>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                {{-- invoice_due_date --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="date" name="invoice_due_date"
                                            class="form-control border border-info" id="tb-invoice_due_date"
                                            value="{{ isset($projectInvoice->invoice_due_date) ? $projectInvoice->invoice_due_date : null }}"
                                            placeholder="check due date">
                                        <label for="tb-invoice_due_date">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                            Check Due Date
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
                                        @if (isset($projectInvoice) && $projectInvoice->receipt_file && file_exists($projectInvoice->receipt_file))
                                            <img id="blah" src="{{ asset($projectInvoice->receipt_file) }}"
                                                class="img-thumbnail" width="200" height="180"
                                                alt="Preview receipt_file" />
                                        @endif
                                        <input type="file" name="receipt_file"
                                            class="form-control border border-info @error('receipt_file') border-danger @enderror"
                                            id="imgInp">
                                        <label for="imgInp">
                                            <i data-feather="file" class="feather-sm text-info fill-white me-2"></i>
                                            Receipt
                                            File
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
                                    @if ($projectInvoice->payment_method != 'Check') style="display:none" @endif>
                                    <div class="form-floating mb-3">
                                        <input type="date" name="check_due_date"
                                            class="form-control border border-info" id="tb-check_due_date"
                                            value="{{ isset($projectInvoice->check_due_date) ? $projectInvoice->check_due_date : null }}"
                                            placeholder="check due date">
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
                                        <textarea name="note" class="form-control border border-info @error('note') border-danger @enderror"
                                            rows="5" placeholder="Note">{{ isset($projectInvoice->note) ? $projectInvoice->note : null }}</textarea>
                                    </div>
                                </div>


                                {{-- project_id --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="hidden" name="project_id"
                                            class="form-control border border-info @error('project_id') border-danger @enderror"
                                            id="tb-project_id"
                                            value="{{ isset($projectInvoice->project_id) ? $projectInvoice->project_id : null }}">
                                    </div>
                                </div>

                                {{-- customer_id --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="hidden" name="customer_id"
                                            class="form-control border border-info @error('customer_id') border-danger @enderror"
                                            id="tb-customer_id"
                                            value="{{ isset($projectInvoice->customer_id) ? $projectInvoice->customer_id : null }}">
                                    </div>
                                </div>

                                {{-- subscription_id --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="hidden" name="subscription_id"
                                            class="form-control border border-info @error('subscription_id') border-danger @enderror"
                                            id="tb-subscription_id"
                                            value="{{ isset($projectInvoice->subscription_id) ? $projectInvoice->subscription_id : null }}">
                                    </div>
                                </div>

                                {{-- Validation message divs --}}
                                <div id="paymentValidationMessage"
                                    style="display: none; color: red; margin-bottom: 10px;"></div>
                                <div id="feeAmountValidationMessage"
                                    style="display: none; color: red; margin-bottom: 10px;"></div>


                                {{-- add new fee --}}
                                <div id="rowContainer">
                                    <div id="totalContractsValidationMessageContainer"></div>

                                    <div class="container groove-container" id="feeContainer">
                                        <div>
                                            <label>
                                                <h3>Extra Fees :</h3>
                                            </label>
                                        </div>

                                        @if (isset($projectInvoice->invoiceFees) && $projectInvoice->invoiceFees->count() > 0)
                                            <div class="container" id="paymentContainer">
                                                <div class="row" id="paymentRow1">
                                                    @if ($projectInvoice->invoiceFees->isNotEmpty())
                                                        @foreach ($projectInvoice->invoiceFees as $index => $invoiceFee)
                                                            <div class="col-md-3">
                                                                <label for="title{{ $index + 1 }}">Fee
                                                                    Title</label>
                                                                <input type='text' name='title[]'
                                                                    id="title{{ $index + 1 }}" required
                                                                    value="{{ $invoiceFee->title ?? null }}"
                                                                    class='form-control border border-info'
                                                                    placeholder='Fee Title'>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <label for="fee_amount{{ $index + 1 }}">Fee
                                                                    Amount</label>
                                                                <input type='number' name='fee_amount[]'
                                                                    id="fee_amount{{ $index + 1 }}" required
                                                                    min='0' step='0.001'
                                                                    class='form-control border border-info'
                                                                    placeholder='Fee Amount'
                                                                    value="{{ $invoiceFee->fee_amount ?? null }}">
                                                                <label for="tb-fee_amount1">
                                                                    <strong class="text-danger">
                                                                        @error('amount.*')
                                                                            ({{ $message }})
                                                                        @enderror
                                                                    </strong>
                                                                </label>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <label for="fee_attachment{{ $index + 1 }}">Fee
                                                                    File</label>
                                                                <input type='file' name='attachment[]'
                                                                    id="fee_attachment{{ $index + 1 }}"
                                                                    class='form-control border border-info'
                                                                    value="{{ $invoiceFee->attachment ?? null }}"
                                                                    placeholder='Fee Attachment'>
                                                                <label for="tb-fee_attachment">
                                                                    <strong class="text-danger">
                                                                        @error('attachment.*')
                                                                            ({{ $message }})
                                                                        @enderror
                                                                    </strong>
                                                                </label>
                                                            </div>


                                                            @if (isset($invoiceFee->attachment) && $invoiceFee->attachment && file_exists($invoiceFee->attachment))
                                                                <div class="col-md-2 d-flex align-items-center">
                                                                    <a href="{{ asset($invoiceFee->attachment) }}"
                                                                        target="_blank" class="btn btn-outline-primary">
                                                                        <i class="bi bi-file-text"></i> Open Attachment
                                                                    </a>
                                                                </div>
                                                            @endif

                                                            <div class="col-md-1 d-flex align-items-center">
                                                                <button type="button"
                                                                    class="btn btn-danger btn-sm deleteRow">Delete</button>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div>
                                    <button type="button" id="addPayment" class="btn btn-primary mt-3">Add Fee</button>
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
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}

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
            const form = document.getElementById('editForm');
            const paymentValidationMessage = document.getElementById('paymentValidationMessage');
            const feeAmountValidationMessage = document.getElementById('feeAmountValidationMessage');

            function updatePaymentValidationMessage(message) {
                paymentValidationMessage.innerText = message;
                paymentValidationMessage.style.display = message ? 'block' : 'none';
            }

            function updateFeeAmountValidationMessage(message) {
                feeAmountValidationMessage.innerText = message;
                feeAmountValidationMessage.style.display = message ? 'block' : 'none';
            }

            function setupPaymentValidation(feeTitle, paymentAmount) {
                feeTitle.addEventListener('input', validatePaymentFields);
                paymentAmount.addEventListener('input', validatePaymentFields);
            }

            function validatePaymentFields() {
                const currentType = this.value.trim();
                const currentAmount = parseFloat(this.closest('.row').querySelector('[name^="fee_amount"]').value
                    .trim());
                const maxAmount = parseFloat(document.getElementById('tb-amount').value.trim());

                if (currentType !== '' && (isNaN(currentAmount) || currentAmount > maxAmount)) {
                    updatePaymentValidationMessage('Please enter a valid amount for payment.');
                    this.closest('.row').querySelector('[name^="fee_amount"]').classList.add('border',
                        'border-danger');
                } else {
                    updatePaymentValidationMessage('');
                    this.closest('.row').querySelector('[name^="fee_amount"]').classList.remove('border',
                        'border-danger');
                }
            }

            function validateAmount() {
                const amountField = document.getElementById('tb-amount');
                const amountValue = parseFloat(amountField.value.trim());
                const totalFees = Array.from(document.querySelectorAll('[name^="fee_amount"]'))
                    .map(input => parseFloat(input.value.trim()))
                    .reduce((acc, val) => acc + val, 0);

                if (isNaN(amountValue) || amountValue <= totalFees) {
                    updateFeeAmountValidationMessage(
                        'Please enter a valid amount for fees it should be less than amount .');
                    amountField.classList.add('border', 'border-danger');
                    return false;
                } else {
                    updateFeeAmountValidationMessage('');
                    amountField.classList.remove('border', 'border-danger');
                    return true;
                }
            }

            function validateFeeAmounts() {
                const feeAmountFields = document.querySelectorAll('[name^="fee_amount"]');
                let isValid = true;

                feeAmountFields.forEach(field => {
                    const amountValue = parseFloat(field.value.trim());

                    if (isNaN(amountValue) || amountValue < 0) {
                        field.classList.add('border', 'border-danger');
                        isValid = false;
                    } else {
                        field.classList.remove('border', 'border-danger');
                    }
                });

                return isValid;
            }

            function validatePayments() {
                let isValid = true;
                const feeTitles = document.querySelectorAll('[name^="title"]');
                const paymentAmounts = document.querySelectorAll('[name^="payment_amount"]');

                feeTitles.forEach((feeTitle, index) => {
                    const currentType = feeTitle.value.trim();
                    const currentAmount = paymentAmounts[index].value.trim();

                    if ((currentType !== '' && currentAmount === '') || (currentType === '' &&
                            currentAmount !== '')) {
                        isValid = false;
                        feeTitle.classList.add('border', 'border-danger');
                        paymentAmounts[index].classList.add('border', 'border-danger');
                    } else {
                        feeTitle.classList.remove('border', 'border-danger');
                        paymentAmounts[index].classList.remove('border', 'border-danger');
                    }
                });

                return isValid;
            }

            form.addEventListener("submit", function(event) {
                if (!validateAmount() || !validateFeeAmounts() || !validatePayments()) {
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
                        <input type='text' name='title[]' id="fee_title" required class='form-control border border-info' placeholder='Fee Title'>
                        <label for="tb-fee_title" style="width: 10ch; display: inline-block;">
                            <strong class="text-danger" style="font-family: monospace; font-size: 12px;">
                                @error('fee_title.*')
                                ( {{ $message }} )
                                @enderror
                            </strong>
                        </label>
                    </div>

                    <div class="col-md-4">
                        <label for="fee_amount1">Fee Amount</label>
                        <input type='number' name='fee_amount[]' id="fee_amount1" required min='0' step='0.001' class='form-control border border-info' placeholder='Fee Amount'>
                        <label for="tb-fee_amount1">
                            <strong class="text-danger">
                                @error('amount.*')
                                ( {{ $message }} )
                                @enderror
                            </strong>
                        </label>
                    </div>

                    <div class="col-md-3">
                        <label for="fee_attachment">Fee File</label>
                        <input type='file' name='attachment[]' id="fee_attachment" required min='0' step='0.001' class='form-control border border-info' placeholder='Fee Attachment'>
                        <label for="tb-fee_attachment">
                            <strong class="text-danger">
                                @error('attachment.*')
                                ( {{ $message }} )
                                @enderror
                            </strong>
                        </label>
                    </div>

                    <div class="col-md-1 d-flex align-items-center">
                        <button type="button" class="btn btn-danger btn-sm deleteRow">Delete</button>
                    </div>
                `;

                feeContainer.appendChild(newRow);

                const newFeeTitle = newRow.querySelector('[name^="title"]');
                const newPaymentAmount = newRow.querySelector('[name^="payment_amount"]');

                setupPaymentValidation(newFeeTitle, newPaymentAmount);
            });

            document.getElementById('feeContainer').addEventListener('click', function(event) {
                if (event.target.classList.contains('deleteRow')) {
                    // Ask for confirmation before deleting
                    const confirmed = confirm('Are you sure you want to delete this row?');

                    if (confirmed) {
                        const row = event.target.closest('.row'); // Get the row to be deleted
                        const container = document.getElementById('rowContainer'); // Get the container

                        row.remove(); // Delete the row on delete button click
                        validatePayments(); // Re-validate after deletion

                        // Check if there are any rows left, if not, hide the container
                        if (container.querySelectorAll('.row').length === 0) {
                            container.style.display = 'none';
                        }
                    }
                }
            });

            document.getElementById('addPayment').addEventListener('click', function() {
                const rowContainer = document.getElementById('rowContainer');
                rowContainer.style.display = 'block'; // Show the container when triggered
            });
        });
    </script>
@endsection
