@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Invoices
                    @if (isset($projectInvoicesCount))
                        ({{ $projectInvoicesCount }})
                    @endif
                </h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">All Invoices</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Create --}}
                    {{-- <div class="dropdown me-2">
                        <a href="{{ route('super_admin.project_invoices-create') }}" class="btn btn-dark">
                            <i data-feather="plus" class="fill-white feather-sm"></i> Add New Invoice
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
                <div class="card">
                    {{-- Search --}}
                    <div class="col-md-12 groove-container">
                        <label>
                            <h2>Search Section :</h2>
                        </label>
                        <br>
                        <form action="{{ route('super_admin.project_invoices-index') }}" method="get" class="row g-3"
                            id="searchForm">
                            @csrf

                            {{-- invoice_number --}}
                            <div class="col-md-3">
                                <label for="invoice_number" class="form-label">Invoice Number</label>
                                <input type="number" name="invoice_number" min="1"
                                    class="form-control border border-info @error('invoice_number') border-danger @enderror"
                                    id="tb-invoice_number" value="{{ $searchValues['invoice_number'] ?? '' }}"
                                    placeholder="Invoice Number">
                                <label for="tb-invoice_number">
                                    <strong class="text-danger">
                                        @error('invoice_number')
                                            ( {{ $message }} )
                                        @enderror
                                    </strong>
                                </label>
                            </div>

                            {{-- Customer Dropdown --}}
                            <div class="col-md-3">
                                <label for="customerID" class="form-label">Select Customer Name</label>
                                <select name="customerID" onchange="getCustomerProjects()"
                                    class="form-control @error('customerID') border border-danger @enderror"
                                    id="customerID">
                                    <option value="" disabled selected>Select Customer Name</option>
                                    @if (isset($customers))
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}"
                                                @if (isset($searchValues['customerID']) &&
                                                        ($searchValues['customerID'] == $customer->id || old('customer_id') == $customer->id)) selected @endif>
                                                {{ $customer->name_en ?? '------' }}
                                                ({{ $customer->name_ar ?? '------' }})
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            {{-- Project Dropdown --}}
                            <div class="col-md-3">
                                <label for="projectSelect" class="form-label">Select Project Name </label>
                                <select name="projectID"
                                    class="form-control @error('project_id') border border-danger @enderror" id="project">
                                    <option value="" disabled selected>Select Project Name</option>
                                    @if (isset($allProjects))
                                        @forelse ($allProjects as $allProject)
                                            <option value="{{ $allProject->id }}"
                                                @if (isset($searchValues['projectID']) &&
                                                        ($searchValues['projectID'] == $allProject->id || old('project_id') == $allProject->id)) selected @endif>
                                                {{ $allProject->name_en ?? '------' }}
                                                ({{ $allProject->name_ar ?? '------' }})
                                            </option>
                                        @empty
                                            <option value="" disabled>No Projects Are Available</option>
                                        @endforelse
                                    @endif
                                </select>
                            </div>

                            {{-- Status Dropdown --}}
                            <div class="col-md-3">
                                <label for="status" class="form-label">Choose Invoice Status</label>
                                <select name="status" class="form-control @error('status') border border-danger @enderror">
                                    <option value="">--- All Statuses ---</option>
                                    <option value="Open" @if (isset($searchValues['status']) && $searchValues['status'] == 'Open') selected @endif>Open
                                    </option>
                                    {{-- <option value="Hold" @if (isset($searchValues['status']) && $searchValues['status'] == 'Hold') selected @endif>Hold</option> --}}
                                    <option value="Cancelled" @if (isset($searchValues['status']) && $searchValues['status'] == 'Cancelled') selected @endif>
                                        Cancelled
                                    </option>
                                    <option value="Paid" @if (isset($searchValues['status']) && $searchValues['status'] == 'Paid') selected @endif>Paid
                                    </option>
                                </select>
                            </div>


                            {{-- from_date --}}
                            <div class="col-md-3">
                                <label for="from_date" class="form-label">From Date (Created At)</label>
                                <input type="date" name="from_date" min="1"
                                    class="form-control border border-info @error('from_date') border-danger @enderror"
                                    id="tb-from_date" value="{{ $searchValues['from_date'] ?? '' }}"
                                    placeholder="From Date">
                                <label for="tb-from_date">
                                    <strong class="text-danger">
                                        @error('from_date')
                                            ( {{ $message }} )
                                        @enderror
                                    </strong>
                                </label>
                            </div>

                            {{-- to_date --}}
                            <div class="col-md-3">
                                <label for="to_date" class="form-label">To Date (Created At)</label>
                                <input type="date" name="to_date" min="1"
                                    class="form-control border border-info @error('to_date') border-danger @enderror"
                                    id="tb-to_date" value="{{ $searchValues['to_date'] ?? '' }}" placeholder="To Date">
                                <label for="tb-to_date">
                                    <strong class="text-danger">
                                        @error('to_date')
                                            ( {{ $message }} )
                                        @enderror
                                    </strong>
                                </label>
                            </div>


                            {{-- from_due_date  --}}
                            <div class="col-md-3">
                                <label for="from_due_date" class="form-label">From Date (Due Date)</label>
                                <input type="date" name="from_due_date" min="1"
                                    class="form-control border border-info @error('from_due_date') border-danger @enderror"
                                    id="tb-from_due_date" value="{{ $searchValues['from_due_date'] ?? '' }}"
                                    placeholder="From Date">
                                <label for="tb-from_due_date">
                                    <strong class="text-danger">
                                        @error('from_due_date')
                                            ( {{ $message }} )
                                        @enderror
                                    </strong>
                                </label>
                            </div>

                            {{-- to_due_date --}}
                            <div class="col-md-3">
                                <label for="to_due_date" class="form-label">To Date (Due Date)</label>
                                <input type="date" name="to_due_date" min="1"
                                    class="form-control border border-info @error('to_due_date') border-danger @enderror"
                                    id="tb-to_due_date" value="{{ $searchValues['to_due_date'] ?? '' }}"
                                    placeholder="To Date">
                                <label for="tb-to_due_date">
                                    <strong class="text-danger">
                                        @error('to_due_date')
                                            ( {{ $message }} )
                                        @enderror
                                    </strong>
                                </label>
                            </div>

                            {{-- invoice_amount_from --}}
                            <div class="col-md-3">
                                <label for="invoice_amount_from" class="form-label">Invoice Amount From</label>
                                <input type="number" name="invoice_amount_from" min="1"
                                    class="form-control border border-info @error('invoice_amount_from') border-danger @enderror"
                                    id="tb-invoice_amount_from" value="{{ $searchValues['invoice_amount_from'] ?? '' }}"
                                    placeholder="Invoice Amount From">
                                <label for="tb-invoice_amount_from">
                                    <strong class="text-danger">
                                        @error('invoice_amount_from')
                                            ( {{ $message }} )
                                        @enderror
                                    </strong>
                                </label>
                            </div>

                            {{-- invoice_amount_to --}}
                            <div class="col-md-3">
                                <label for="invoice_amount_to" class="form-label">Invoice Amount To</label>
                                <input type="number" name="invoice_amount_to" min="0"
                                    class="form-control border border-info @error('invoice_amount_to') border-danger @enderror"
                                    id="tb-invoice_amount_to" value="{{ $searchValues['invoice_amount_to'] ?? '' }}"
                                    placeholder="Invoice Amount To">
                                <label for="tb-invoice_amount_to">
                                    <strong class="text-danger">
                                        @error('invoice_amount_to')
                                            ( {{ $message }} )
                                        @enderror
                                    </strong>
                                </label>
                            </div>

                            {{-- Add more filters as needed --}}
                            <div class="col-md-12 text-end">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>

                        </form>
                    </div>
                    <br>
                    {{-- Finance --}}
                    <div class="col-md-12 groove-container">
                        {{-- <div class="row">
                            <label>
                                <h2>Finance Info :</h2>
                            </label>
                            <br>

                            <div class="col-md-6">
                                <div class="row mb-3">
                                    <div class="col-md-4"> <strong>All Invoices Total:</strong></div>
                                    <div class="col-md-8">
                                        <span style="color: blue">
                                            <strong>
                                                <p> {{ isset($allInvoices) ? $allInvoices : '-------' }} JOD </p>
                                            </strong>
                                        </span>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <span><strong>
                                                Income Total (Paid):
                                            </strong></span>
                                    </div>
                                    <div class="col-md-8">
                                        <span style="color: green;">
                                            <strong>
                                                <p>
                                                    {{ isset($totalPaidInvoices) ? $totalPaidInvoices : '-------' }}
                                                    JOD
                                                </p>
                                            </strong>
                                        </span>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4"><strong>Cancelled Invoices :</strong></div>
                                    <div class="col-md-8">
                                        <span style="color: grey">
                                            <strong>
                                                <p>{{ isset($totalCancelledInvoices) ? $totalCancelledInvoices : '-------' }}
                                                    JOD
                                                </p>
                                            </strong>
                                        </span>
                                    </div>
                                </div>


                                <div class="row mb-3">
                                    <div class="col-md-4"><strong>Total Paid Contracts :</strong></div>
                                    <div class="col-md-8">
                                        <span style="color: green">
                                            <strong>
                                                <p>{{ isset($totalContractsPaid) ? $totalContractsPaid : '-------' }}
                                                    JOD
                                                </p>
                                            </strong>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <span><strong>Remaining Contracts :</strong></span>
                                    </div>
                                    <div class="col-md-8">
                                        <span style="color: red;"><strong>
                                                <p>{{ isset($totalContractsRemaining) ? $totalContractsRemaining : '-------' }}
                                                    JOD
                                                </p>
                                            </strong></span>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4"><strong>Open Invoices Total :</strong></div>
                                    <div class="col-md-8">
                                        <span style="color: orangered">
                                            <strong>
                                                <p>{{ isset($totalOpenInvoices) ? $totalOpenInvoices : '-------' }} JOD</p>
                                            </strong>
                                        </span>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4"><strong>Total Contracts :</strong></div>
                                    <div class="col-md-8">
                                        <span style="color: black">
                                            <strong>
                                                <p>{{ isset($totalContracts) ? $totalContracts : '-------' }}
                                                    JOD
                                                </p>
                                            </strong>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <div class="card-body">
                            <div class="row">
                                <label>
                                    <h2>Finance Info :</h2>
                                </label>
                                <div class="col-md-6">
                                    <div class="table-responsive">
                                        <table id="file_export_main_info_part_1"
                                            class="table table-striped table-bordered display">
                                            <thead>
                                                {{-- All Invoices Total: --}}
                                                <tr>
                                                    <th style="background-color:aliceblue">All Invoices Total:</th>
                                                    <td>
                                                        <span style="color: blue">
                                                            <strong>
                                                                {{ isset($allInvoices) ? $allInvoices : '-------' }} JOD
                                                            </strong>
                                                        </span>
                                                    </td>
                                                </tr>
                                                {{--  Income Total (Paid): --}}
                                                <tr>
                                                    <th style="background-color:aliceblue"> Income Total (Paid):</th>
                                                    <td>
                                                        <span style="color: red;"><strong>
                                                                {{ isset($totalContractsRemaining) ? $totalContractsRemaining : '-------' }}
                                                                JOD
                                                            </strong></span>
                                                    </td>
                                                </tr>
                                                {{--  Cancelled Invoices : --}}
                                                <tr>
                                                    <th style="background-color:aliceblue">Cancelled Invoices :
                                                    </th>
                                                    <td> <strong>
                                                            {{ isset($totalCancelledInvoices) ? $totalCancelledInvoices : '-------' }}
                                                            JOD
                                                        </strong>
                                                    </td>
                                                </tr>
                                                {{-- Total Paid Contracts : --}}
                                                <tr>
                                                    <th style="background-color:aliceblue">Total Paid Contracts :</th>
                                                    <td>
                                                        <span style="color: green">
                                                            <strong>
                                                                {{ isset($totalContractsPaid) ? $totalContractsPaid : '-------' }}
                                                                JOD
                                                            </strong>
                                                        </span>
                                                    </td>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="table-responsive">
                                        <table id="file_export_status_team"
                                            class="table table-striped table-bordered display">
                                            <thead>

                                                <tr>
                                                    <th style="background-color:aliceblue">Remaining Contracts :
                                                    </th>
                                                    <td>
                                                        <span style="color: red;">
                                                            <strong>
                                                                {{ isset($totalContractsRemaining) ? $totalContractsRemaining : '-------' }} JOD
                                                            </strong>
                                                        </span>
                                                    </td>
                                                </tr>


                                                <tr>
                                                    <th style="background-color:aliceblue">Open Invoices Total :</th>
                                                    <td>
                                                        <span style="color: orangered">
                                                            <strong>
                                                                {{ isset($totalOpenInvoices) ? $totalOpenInvoices : '-------' }} JOD
                                                            </strong>
                                                        </span>
                                                    </td>
                                                </tr>


                                                <tr>
                                                    <th style="background-color:aliceblue">Total Contracts :
                                                    </th>
                                                    <td>
                                                        <span style="color: black">
                                                            <strong>
                                                                {{ isset($totalContracts) ? $totalContracts : '-------' }}
                                                                    JOD
                                                            </strong>
                                                        </span>
                                                    </td>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <br>

                    <div class="border-bottom title-part-padding">
                        <h4 class="card-title mb-0">All Invoices</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="file_export" class="table table-striped table-bordered display">
                                <thead>
                                    <tr>
                                        <th>#REF</th>
                                        <th colspan="1">Project</th>
                                        <th>Customer</th>
                                        <th>Amount</th>
                                        <th>Due Date</th>
                                        <th>Status</th>
                                        <th>Method</th>
                                        <th>Control</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($projectInvoices as $projectInvoice)
                                        @if (empty($searchValues) ||
                                                ((empty($searchValues['invoice_number']) ||
                                                    strpos($projectInvoice->id, $searchValues['invoice_number']) !== false) &&
                                                    (empty($searchValues['customerID']) || $projectInvoice->customer_id == $searchValues['customerID']) &&
                                                    (empty($searchValues['projectID']) || $projectInvoice->project_id == $searchValues['projectID']) &&
                                                    (empty($searchValues['status']) || $projectInvoice->status == $searchValues['status']) &&
                                                    (empty($searchValues['from_date']) || $projectInvoice->created_at >= $searchValues['from_date']) &&
                                                    (empty($searchValues['to_date']) || $projectInvoice->created_at <= $searchValues['to_date']) &&
                                                    (empty($searchValues['from_due_date']) ||
                                                        $projectInvoice->invoice_due_date >= $searchValues['from_due_date']) &&
                                                    (empty($searchValues['to_due_date']) ||
                                                        $projectInvoice->invoice_due_date <= $searchValues['to_due_date']) &&
                                                    (empty($searchValues['invoice_amount_from']) ||
                                                        $projectInvoice->amount >= $searchValues['invoice_amount_from']) &&
                                                    (empty($searchValues['invoice_amount_to']) ||
                                                        $projectInvoice->amount <= $searchValues['invoice_amount_to'])))
                                            <tr>
                                                {{-- <td class="counter"></td> --}}
                                                <td>{{ isset($projectInvoice->id) ? $projectInvoice->id : '----' }}
                                                </td>

                                                {{-- project --}}
                                                {{-- <td>{{ isset($projectInvoice->project->name_en) ? $projectInvoice->project->name_en : '----' }}
                                                </td> --}}
                                                <td>
                                                    <a
                                                        href="{{ route('super_admin.projects-show', ['id' => isset($projectInvoice->project->id) ? $projectInvoice->project->id : '----']) }}">
                                                        {{ isset($projectInvoice->project->name_en) ? $projectInvoice->project->name_en : '----' }}
                                                    </a>
                                                </td>

                                                {{-- customer --}}
                                                <td>
                                                    <a
                                                        href="{{ route('super_admin.customers-show', ['id' => isset($projectInvoice->customer->id) ? $projectInvoice->customer->id : '----']) }}">
                                                        {{ isset($projectInvoice->customer->name_en) ? $projectInvoice->customer->name_en : '----' }}
                                                    </a>
                                                </td>


                                                {{-- amount --}}
                                                <td>
                                                    <span
                                                        style="color: {{ $projectInvoice->status == 'Paid' ? 'green' : ($projectInvoice->status == 'Open' ? 'red' : 'black') }}">
                                                        <strong>
                                                            {{ isset($projectInvoice->amount) ? $projectInvoice->amount : '----' }}
                                                            JOD
                                                        </strong>
                                                    </span>
                                                </td>



                                                {{-- invoice_due_date --}}
                                                <td style="padding: 10px;">
                                                    <strong>
                                                        {{ isset($projectInvoice->invoice_due_date) ? \Carbon\Carbon::parse($projectInvoice->invoice_due_date)->format('d/m/Y') : '----' }}
                                                    </strong>
                                                </td>

                                                {{-- status --}}
                                                <td>
                                                    @if (isset($projectInvoice->status) && $projectInvoice->status == 'Paid')
                                                        <span
                                                            style="color: green;"><strong>{{ isset($projectInvoice->status) ? $projectInvoice->status : '----' }}</strong></span>
                                                    @elseif(isset($projectInvoice->status) && $projectInvoice->status == 'Cancelled')
                                                        <span
                                                            style="color: black;"><strong>{{ isset($projectInvoice->status) ? $projectInvoice->status : '----' }}</strong></span>
                                                    @elseif(isset($projectInvoice->status) && $projectInvoice->status == 'Hold')
                                                        <span
                                                            style="color: orange;"><strong>{{ isset($projectInvoice->status) ? $projectInvoice->status : '----' }}</strong></span>
                                                    @elseif(isset($projectInvoice->status) && $projectInvoice->status == 'Open')
                                                        <span
                                                            style="color: red;"><strong>{{ isset($projectInvoice->status) ? $projectInvoice->status : '----' }}</strong></span>
                                                    @else
                                                        {{ isset($projectInvoice->status) ? $projectInvoice->status : '----' }}
                                                    @endif
                                                </td>

                                                {{-- payment_method --}}
                                                <td>{{ isset($projectInvoice->payment_method) ? $projectInvoice->payment_method : '----' }}
                                                </td>

                                                {{-- operations --}}
                                                <td>
                                                    <div class="button-group">
                                                        <a href="{{ route('super_admin.project_invoices-show', isset($projectInvoice->id) ? $projectInvoice->id : -1) }}"
                                                            class="btn waves-effect waves-light btn-primary btn-sm"
                                                            title="View Details">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                        <div class="mt-3 d-flex justify-content-center">
                            @if (isset($searchValues) && !empty(array_filter($searchValues)))
                                {{-- {{ $projectInvoices->appends($searchValues)->links('pagination::bootstrap-4') }} --}}
                            @else
                                {{ $projectInvoices->links('pagination::bootstrap-4') }}
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra_js')
    <script>
        $(document).ready(function() {

            var originalOrder = []; // Array to store the original order of rows

            // Check if the DataTable already exists and destroy it if needed
            if ($.fn.DataTable.isDataTable('#file_export')) {
                $('#file_export').DataTable().destroy();
            }

            // Update reference numbers based on the original order
            updateReferenceNumbers();

            function updateReferenceNumbers() {
                // Update project counter placeholders based on the original order
                $('#file_export tbody tr').each(function(index) {
                    originalOrder.push($(this).find('.counter').text()); // Store original order
                    $(this).find('.counter').text(index + 1); // Update counter
                });
            }

            // Initialize the DataTable
            var table = $('#file_export').DataTable({
                paging: false,
                searching: false,
                order: [
                    [4, 'asc']
                ],
                columnDefs: [{
                        type: 'date',
                        targets: [4]
                    },
                    {
                        orderable: false,
                        targets: [7, 6, 0]
                    }
                ],
                dom: 'Bfrtip',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
            });

            // Add styling to DataTable buttons
            $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass(
                'btn btn-primary mr-1');

            // Handle DataTable draw event to update reference numbers after sorting
            table.on('draw', function() {
                updateReferenceNumbers();
            });
        });
    </script>



    {{-- passed the test in https://validatejavascript.com/  using custom JS config --}}
    {{-- select 2 script --}}
    <script>
        $(document).ready(function() {
            $('select[name="projectID"]').select2();
            $('select[name="customerID"]').select2();
            $('select[name="search"]').select2();
        });
    </script>
@endsection
