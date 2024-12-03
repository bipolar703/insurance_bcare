@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Update Invice Info</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.project_invoices-index') }}">All Invoices</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Update Invoice Info</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Create --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.project_invoices-create') }}" class="btn btn-dark">
                            <i data-feather="plus" class="fill-white feather-sm"></i> Add New
                        </a>
                    </div>
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
                        <h4 class="card-title mb-3 pb-3 border-bottom">Update Invoice Info :</h4>
                        <form
                            action="{{ route('super_admin.project_invoices-update', isset($projectInvoice->id) ? $projectInvoice->id : -1) }}"
                            method="POST" enctype="multipart/form-data" id="createForm">
                            @csrf
                            <div class="row">

                                {{-- Upload receipt_file --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="formFile" class="form-label">Upload Invoice Bill receipt file :
                                            <strong class="text-danger">
                                                @error('receipt_file')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                        <div class="alert alert-info alert-dismissible bg-info text-white border-0 fade show"
                                            role="alert">
                                            <strong>1- Valid extensions : jpeg, jpg, png, gif, tiff, tif or webp ,pdf ,doc ,docx.</strong>
                                        </div>
                                        <div class="alert alert-info alert-dismissible bg-info text-white border-0 fade show"
                                            role="alert">
                                            <strong>2- The maximum size of the uploaded receipt file is 20MB.</strong>
                                        </div>
                                        <div class="alert alert-info alert-dismissible bg-info text-white border-0 fade show"
                                            role="alert">
                                            <strong>3- Recommended dimensions : 200px * 300px.</strong>
                                        </div>
                                    </div>
                                </div>

                                {{-- Preview receipt_file  --}}
                                <div class="col-md-6">
                                    <div class="mb-3 border border-info @error('receipt_file') border-danger @enderror">
                                        <center class="mt-4">
                                            @if (isset($projectInvoice) && $projectInvoice->receipt_file  && file_exists($projectInvoice->receipt_file ))
                                                <img id="blah" src="{{ asset($projectInvoice->receipt_file) }}"
                                                    class="img-thumbnail fit-image" alt="Preview Image" />
                                            @else
                                                <img id="blah"
                                                    src="{{ asset('style_files/shared/images_default/blueray_logo.jpg') }}"
                                                    class="img-thumbnail fit-image" alt="Preview Image" />
                                            @endif
                                            <h4 class="card-title mt-2">Invoice receipt file</h4>
                                            <div class="col-md-6">
                                                <input type="file" name="receipt_file"
                                                    class="form-control mb-2 @error('receipt_file') is-invalid @enderror"
                                                    id="imgInp">
                                            </div>
                                        </center>
                                    </div>
                                </div>
                                <style>
                                    .fit-image {
                                        width: 100%;
                                        height: 100%;
                                        object-fit: contain;
                                    }
                                </style>
                                {{-- customer_id --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                            <select name="customer_id" onchange="getCustomerProjects()"
                                                class="form-control form-select border border-info @error('customer_id') border-danger @enderror custom_select_style">
                                                @if (isset($customers) && $customers->count() > 0)
                                                    @foreach ($customers as $customer)
                                                        @if ($customer->projects->count() > 0)
                                                            <option value="{{ $customer->id }}"
                                                                @if ($customer->id == $projectInvoice->customer_id) selected @endif>
                                                                {{ $customer->name_en ?? '------' }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    <option value="">
                                                        No Customer Is Shown Please Check With Admin
                                                    </option>
                                                @endif
                                            </select>
                                            <label for="tb-name">
                                                <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                                Customer Name
                                                <strong class="text-danger">
                                                    @error('customer_id')
                                                        ( {{ $message }} )
                                                    @enderror
                                                </strong>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                {{-- project_id --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                            <select name="project_id"
                                                class="form-control form-select border border-info custom_select_style"
                                                id="project">
                                                <!-- Initially selected project -->
                                                @if (isset($projectInvoice) && $projectInvoice->project)
                                                    <option value="{{ $projectInvoice->project->id }}" selected>
                                                        {{ $projectInvoice->project->name_en }}
                                                    </option>
                                                @endif
                                            </select>
                                            <label for="project_id">
                                                <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                                Project Name
                                                <strong class="text-danger" id="project_id_error"></strong>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                {{-- amount --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="amount"
                                            class="form-control border border-info @error('amount') border-danger @enderror"
                                            id="tb-amount"
                                            value="{{ isset($projectInvoice->amount) ? $projectInvoice->amount : null }}"
                                            placeholder="amount">
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

                                {{-- Status --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                            <select name="status"
                                                class="form-control form-select border border-info @error('status') border-danger @enderror custom_select_style">
                                                <option>--- Choose Status ---</option>
                                                <option value="1" @if ($projectInvoice->status == 'Open') selected @endif
                                                    @if ($projectInvoice->status == null) selected @endif>Open
                                                </option>
                                                <option value="2" @if ($projectInvoice->status == 'Hold') selected @endif>
                                                    Hold </option>
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
            $('#select2-with-tags-users').select2(); // Initialize Select2 for the users dropdown
            $('#select2-with-tags-departments').select2(); // Initialize Select2 for the departments dropdown
        });
    </script>

    {{-- customers_projects --}}
    <script>
        $(document).ready(function() {
            // Trigger the initial population
            // getCustomerProjects();

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
                                        .name + '</option>';
                                });
                                $('#project').html(selectProject); // Populate the project dropdown
                            }

                            var originalProjectId =
                                "{{ $projectInvoice->project_id }}";
                            if (originalProjectId) {
                                $('#project').val(
                                    originalProjectId); // Set the value of the select element
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
            getProjectsForCustomer();

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

                                        selectProject += '<option value="' + obj.id + '" selected>' +
                                            obj.name +
                                            '</option>';
                                    } else {
                                        selectProject += '<option value="' + obj.id + '">' + obj.name +
                                            '</option>';
                                    }
                                } else {
                                    selectProject += '<option value="' + obj.id + '">' + obj.name +
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
@endsection
