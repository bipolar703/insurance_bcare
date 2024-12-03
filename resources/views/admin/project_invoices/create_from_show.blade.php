@extends('admin.layouts.app')
@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12">
                <h2 class="page-title">
                    <a href="{{ route('super_admin.projects-show', ['id' => $project->id]) }}">
                        {{ isset($project->name_en) ? $project->name_en : null }}
                    </a>
                </h2>
            </div>


            <br>


            <div class="col-12">
                <h2 class="page-title">
                    <a href="{{ route('super_admin.projects-show', ['id' => $project->id]) }}">
                        {{ isset($project->name_ar) ? $project->name_ar : null }}
                    </a>
                </h2>
            </div>


            <div class="col-md-5 align-self-center">
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add New Invoice</li>
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
                        <h4 class="card-title mb-3 pb-3 border-bottom">Add New Invoice :</h4>
                        <form
                            action="{{ route('super_admin.project_invoices-storeInvoiceComingFromShow', ['id' => isset($project->id) ? $project->id : -1]) }}"
                            method="POST" id="createForm" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="totalMaxAmount" value="{{ $totalMaxAmount }}">


                                <div>
                                    <h4>Maximum Amount You Can Enter Is :<span style="color: red"> {{ $totalMaxAmount }}
                                            JOD
                                        </span></h4>
                                </div>



                                {{-- id --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="id" min="1"
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
                                        <input type="number" name="amount" min="1" step="0.001"
                                            max="{{ $totalMaxAmount }}" max="{{ $totalMaxAmount }}"
                                            class="form-control border border-info @error('amount') border-danger @enderror"
                                            id="amountValue" value="{{ old('amount') }}" placeholder="amount">
                                        <label for="amountValue">
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
                                        <div class="form-floating mb-3">
                                            <select name="status" id="statusMethod"
                                                class="form-control form-select border border-info @error('status') border-danger @enderror custom_select_style">
                                                <option>--- Select Status ---</option>
                                                <option value="1" @if (old('status') == 1) selected @endif
                                                    @if (old('status') == null) selected @endif>Open</option>
                                                <option value="4" @if (old('status') == 4) selected @endif>
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
                                                <option>--- Select Payment Method ---</option>
                                                <option value="1" @if (old('payment_method') == 1 || old('payment_method') === null) selected @endif>
                                                    Cash
                                                </option>
                                                <option value="2" @if (old('payment_method') == 2) selected @endif>
                                                    Check
                                                </option>
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
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                            <input type="date" name="invoice_due_date"
                                                class="form-control border border-info" id="invoiceDueDate"
                                                value="{{ old('invoice_due_date') }}" placeholder="Invoice Due Date">
                                            <label for="invoiceDueDate">
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
                                </div>


                                {{-- receipt_file --}}
                                <div class="col-md-6" id="previewReceiptFile">
                                    <div class="form-floating mb-3">
                                        <input type="file" name="receipt_file"
                                            class="form-control border border-info @error('receipt_file') border-danger @enderror"
                                            id="receiptFile">
                                        <label for="receiptFile">
                                            <i data-feather="file" class="feather-sm text-info fill-white me-2"></i>
                                            Invoice
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
                                    @if (old('payment_method') != 2) style="display:none" @endif>
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                            <input type="date" name="check_due_date"
                                                class="form-control border border-info" id="checkDueDate"
                                                value="{{ old('check_due_date') }}" placeholder="Check Due Date">
                                            <label for="checkDueDate">
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
                                            <button type="button" id="submitForm"
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
                    $('#checkDueDateContainer input').val(
                        ''); //To clear the inputs values that are in the container
                }
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            // Initially hide check due date if payment method is not 'Check'
            if ($('#statusMethod').val() != '4') {
                $('#previewReceiptFile').hide();
                $('#previewReceiptFile input').val(''); //To clear the inputs values that are in the container
            }

            $('#statusMethod').change(function() {
                if ($(this).val() == '4') {
                    $('#previewReceiptFile').show();
                } else {
                    $('#previewReceiptFile').hide();
                    $('#previewReceiptFile input').val(
                        ''); //To clear the inputs values that are in the container
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
                    if (input.value.trim() !== '') {
                        totalAmount += parseFloat(input.value.trim());
                    }
                });

                const paymentAmount = parseFloat(document.getElementById('amountValue').value.trim());

                if (totalAmount > paymentAmount) {
                    errorMessageContainer.innerText = 'Total fee amount cannot exceed the payment amount.';
                } else {
                    errorMessageContainer.innerText = ''; // Clear error message if total amount is valid
                }
            }

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

            // form.addEventListener("submit", function(event) {
            //     const paymentAmount = parseFloat(document.getElementById('amountValue').value.trim());
            //     const feeAmountInputs = document.querySelectorAll('[name^="fee_amount"]');
            //     let totalAmount = 0;

            //     feeAmountInputs.forEach(input => {
            //         if (input.value.trim() !== '') {
            //             totalAmount += parseFloat(input.value.trim());
            //         }
            //     });

            //     if (totalAmount > paymentAmount) {
            //         errorMessageContainer.innerText = 'Total fee amount cannot exceed the payment amount.';
            //         event.preventDefault(); // Prevent form submission
            //     }
            // });

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

            document.getElementById('addPayment').addEventListener('click', function() {
                const rowContainer = document.getElementById('rowContainer');
                rowContainer.style.display = 'block'; // Show the container when triggered
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
                var statusValue = Number(document.getElementById('statusMethod').value);
                var paymentMethodValue = Number(document.getElementById('paymentMethodSelect').value);
                var invoiceDueDate = document.getElementById('invoiceDueDate').value;
                var checkDueDate = document.getElementById('checkDueDate').value;
                var amountValue = Number(document.getElementById('amountValue').value);
                var receiptFileInput= document.getElementById('receiptFile');
                var receiptFile = receiptFileInput.files[0]; // Access the file object from the file input
                var totalMaxAmountValue = @json($totalMaxAmount);
                let allFieldsFilled = true;
                var ValidationError = 0;

                //////////////////////////////////////////////////////////////////////////////////////////////////
                ////////////////////// Start Verify that all required fields have data entered //////////////////
                /////////////////////////////////////////////////////////////////////////////////////////////////
                // Fields that need to be checked for data
                const fieldsToCheck = [
                    "input[name='id']",
                    "input[name='amount']",
                    "input[select='status']",
                    "input[select='payment_method']",
                ];
                // If status is paid => The receipt file is required
                if (statusValue == 4) {
                    fieldsToCheck.push("input[name='invoice_due_date']");
                    fieldsToCheck.push("input[name='receipt_file']");
                }
                 // If payment method is check => The check due date is required
                if (paymentMethodValue == 2) {
                    fieldsToCheck.push("input[name='check_due_date']");
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
                ///////////////////////////////////// status and payment method value limits //////////////////////////////////////
                ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                // Status
                if ((statusValue != 1) && (statusValue != 4)) {
                    ValidationError++;
                    Swal.fire(
                        'When adding a new Project',
                        'Status value is not valid',
                        'question'
                    )
                    return;
                }
                // Payment Method
                if ((paymentMethodValue != 1) && (paymentMethodValue != 2)) {
                    ValidationError++;
                    Swal.fire(
                        'When adding a new Project',
                        'Payment Method value is not valid',
                        'question'
                    )
                    return;
                }

                //////////////////////////////////////////////////////////////////////////////////////////////////
                ///////////////////////////////////// Check the dates format /////////////////////////////////////
                //////////////////////////////////////////////////////////////////////////////////////////////////

                if (invoiceDueDate && !isValidDateFormat(invoiceDueDate)) {
                    ValidationError++;
                    Swal.fire(
                        'When adding a new Project',
                        'Invoice Due Date format is not valid',
                        'question'
                    )
                    return;
                }

                if (checkDueDate && !isValidDateFormat(checkDueDate)) {
                    ValidationError++;
                    Swal.fire(
                        'When adding a new Project',
                        'Check Due Date format is not valid',
                        'question'
                    )
                    return;
                }
                ////////////////////////////////////////////////////////////////////////////////////////////////////
                ///////////////////////////////////// Check other validations //////////////////////////////////////
                ///////////////////////////////////////////////////////////////////////////////////////////////////

                // Amount value min: 1
                if (amountValue < 1) {
                    ValidationError++;
                    Swal.fire(
                        'When adding a new Project',
                        'Amount value must be at least 1',
                        'question'
                    )
                    return;
                }
                // Amount value must be less than totalMaxAmountValue
                if (amountValue > totalMaxAmountValue) {
                    ValidationError++;
                    Swal.fire(
                        'When adding a new Project',
                        'Amount value must be less than total amount value',
                        'question'
                    )
                    return;
                }
                // Receipt File Extensions
                if((statusValue == 4) && receiptFile){
                    var fileName = receiptFile.name.toLowerCase(); // Get the file name in lowercase
                        var validExtensions = ['png', 'jpg', 'webp', 'pdf']; // Valid file extensions
                        
                        // Check if the file extension is valid
                        var isValid = validExtensions.some(function(extension) {
                            return fileName.endsWith('.' + extension);
                        });
                        
                        // If the file extension is not valid, return false
                        if (!isValid) {
                            ValidationError++;
                            Swal.fire(
                                'When adding a new Project',
                                'Receipt File is invalid', 
                                'question',
                            )
                            return;
                        }
                }         
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                // Check that Payment title and amount are filled in each record, and the payment date is valid if it is filled//
                ////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                const tableRows = document.querySelectorAll("#feeContainer .row");;
                const feesValidationErrors = [];
                var totFeesAmount = 0;
                tableRows.forEach((row) => {
                    const titleInput = row.querySelector(
                        "input[name^='title[]']");
                    const amountInput = row.querySelector(
                        "input[name^='fee_amount[]']");
                    const attachment = row.querySelector(
                        "input[name^='attachment[]']");
                    const attachmentInput = attachment.files[0]; 

                    const titleValue = titleInput.value.trim();
                    const amountValue = amountInput.value.trim();
                    const attachmentValue = attachment.value.trim();

                    // Check if title[] and fee_amount[] are filled
                    if (!titleValue || !amountValue) {
                        ValidationError++;
                        Swal.fire(
                            'When adding a new Project',
                            'Please fill both Fee Title and Amount in each record', 
                            'question',

                        )
                        return;
                    }
                    totFeesAmount += Number(amountValue);

                    // Check if attachment[] is filled then it has a valid date
                    if (attachmentValue) {
                        var fileName = attachmentInput.name.toLowerCase(); // Get the file name in lowercase
                        var validExtensions = ['png', 'jpg', 'webp', 'pdf']; // Valid file extensions
                        
                        // Check if the file extension is valid
                        var isValid = validExtensions.some(function(extension) {
                            return fileName.endsWith('.' + extension);
                        });
                        
                        // If the file extension is not valid, return false
                        if (!isValid) {
                            ValidationError++;
                            Swal.fire(
                                'When adding a new Project',
                                'Fee File is invalid', // Display the first error message
                                'question',
                            )
                            return;
                        }
                     
                    }
                });
          
                if (totFeesAmount >= amountValue) {
                    ValidationError++;
                        Swal.fire(
                            'When adding a new Project',
                            'Total fees must be less than amount value', 
                            'question',

                        )
                        return;
                }

                //     //////////////////////////////////////////////////////////////////////////////////////////////////
                //     ///////////////////////////////////// Submit the form ///////////////////////////////////////////
                //     /////////////////////////////////////////////////////////////////////////////////////////////////
                if (ValidationError == 0) {
                    // $("#createForm").submit()
                }
            });
            function isValidDateFormat(dateString) {
                // Define a regular expression pattern for YYYY-MM-DD format
                var pattern = /^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/;
                // Test the dateString against the pattern
                return pattern.test(dateString);
            }


        });
    </script>
@endsection
