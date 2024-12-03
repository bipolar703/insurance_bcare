@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Add Developmet Team</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.projects-index') }}">All Projects</a></li>
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
            @if ($errors->any())
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
            @endif

            <div class="col-12">
                {{-- Form Section --}}
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3 pb-3 border-bottom">Add New Project :</h4>
                        <form
                            action="{{ route('super_admin.projects-storeDevelopmentTeams', isset($project->id) ? $project->id : -1) }}"
                            method="POST" id="createForm" enctype="multipart/form-data">
                            @csrf
                            <div class="row">

                                {{-- department_id --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                            <select name="department_id" onchange="getCustomerProjects()"
                                                class="form-control form-select bordre border-info @error('department_id') border-danger @enderror custom_select_style">
                                                @if (isset($departments) && $departments->count() > 0)
                                                    <option value="">Please Select Departmet</option>
                                                    @foreach ($departments as $department)
                                                        @if ($department->users->count() > 0)
                                                            <option value="{{ $department->id }}">
                                                                {{ $department->name ?? '------' }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    <option value="">
                                                        No Department Is Shown Please Check With Admin
                                                    </option>
                                                @endif
                                            </select>
                                            <label for="tb-name">
                                                <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                                Department Name
                                                <strong class="text-danger">
                                                    @error('department_id')
                                                        ( {{ $message }} )
                                                    @enderror
                                                </strong>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                {{-- user_id --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                            <select name="user_id"
                                                class="form-control form-select border border-info custom_select_style"
                                                id="user">
                                            </select>
                                            <label for="user_id">
                                                <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                                Employee Name
                                                <strong class="text-danger" id="user_id_error"></strong>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                {{-- projectCoordinators --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <select name="project_project_coordinator_name"
                                            class="form-control form-select border border-info @error('project_project_coordinator_name') border-danger @enderror custom_select_style">
                                            @if (isset($projectCoordinators) && $projectCoordinators->count() > 0)
                                                <option value="">Select Project Coordinator Name</option>
                                                @foreach ($projectCoordinators as $projectCoordinator)
                                                    <option value="{{ $projectCoordinator->id }}"
                                                        @if (old('project_project_coordinator_name') == $projectCoordinator->id) selected @endif>
                                                        {{ isset($projectCoordinator->name) ? $projectCoordinator->name : '------' }}
                                                    </option>
                                                @endforeach
                                            @else
                                                <option value="">No Sales Person Are Available</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                {{-- programming_language_used_web --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <select name="programming_language_used_web"
                                            class="form-control form-select border border-info @error('programming_language_used_web') border-danger @enderror custom_select_style">
                                            <option>--- Choose Programming language Used ---</option>
                                            <option value="1" @if (old('programming_language_used_web') == 1) selected @endif
                                                @if (old('programming_language_used_web') == null) selected @endif>Laravel </option>
                                            <option value="2" @if (old('programming_language_used_web') == 2) selected @endif>
                                                Drupal </option>
                                            <option value="3" @if (old('programming_language_used_web') == 3) selected @endif>
                                                WordPress </option>
                                            <option value="4" @if (old('programming_language_used_web') == 4) selected @endif>
                                                Not Decided Yet </option>
                                        </select>
                                    </div>
                                </div>

                                {{-- programming_language_used_mobile --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <select name="programming_language_used_mobile"
                                            class="form-control form-select border border-info @error('programming_language_used_mobile') border-danger @enderror custom_select_style">
                                            <option value="">--- Choose Programming language Used For Web---</option>
                                            <option value="1" @if (old('programming_language_used_mobile') == 1) selected @endif
                                                @if (old('programming_language_used_mobile') == null) selected @endif>IOS </option>
                                            <option value="2" @if (old('programming_language_used_mobile') == 2) selected @endif>
                                                Android </option>
                                            <option value="3" @if (old('programming_language_used_mobile') == 3) selected @endif>
                                                Flutter </option>
                                            <option value="4" @if (old('programming_language_used_mobile') == 4) selected @endif>
                                                Andoid + IOS </option>
                                        </select>
                                    </div>
                                </div>
                                <hr>

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
    {{-- department_employees --}}
    <script>
        $(document).ready(function() {
            // Trigger the initial population
            getCustomerProjects();

            // Event listener for changes in department_id field
            $('#department_id').on('change', function() {
                getProjectsForCustomer(); // Fetch new projects when department_id changes
            });

            function getProjectsForCustomer() {
                var department_id = $('#department_id').val(); // Fetch the updated department ID
                if (department_id) {
                    var fullRoute =
                        "{{ route('super_admin.projects-getEmployeesForDepartment', 'department_id=:department_id') }}";
                    fullRoute = fullRoute.replace(':department_id', department_id);
                    $.ajax({
                        type: 'POST',
                        url: fullRoute,
                        processData: false,
                        contentType: false,
                        cache: false,
                        success: function(data) {
                            if (data.status == true) {
                                var selectUser = '<option value="">Select Employee</option>';
                                data.users.forEach(function(obj) {
                                    selectUser += '<option value="' + obj.id + '">' + obj
                                        .name + '</option>';
                                });
                                $('#user_id').html(selectUser); // Populate the Employee dropdown
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
                url: "{{ route('super_admin.projects-getEmployeesForDepartment') }}",
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function(data) {
                    if (data.status == true) {

                        var selectUser = '<option value="">Select Employee</option>';
                        for (var key in data.users) {
                            if (!data.users.hasOwnProperty(key)) continue;

                            var obj = data.users[key];
                            for (var prop in obj) {
                                if (!obj.hasOwnProperty(prop)) continue;
                                var name = $("#name").val();
                                if (name) {
                                    if (obj.id == name) {

                                        selectUser += '<option value="' + obj.id + '" selected>' + obj.name +
                                            '</option>';
                                    } else {
                                        selectUser += '<option value="' + obj.id + '">' + obj.name +
                                            '</option>';
                                    }
                                } else {
                                    selectUser += '<option value="' + obj.id + '">' + obj.name + '</option>';
                                }
                                break;
                            }
                        }
                        $('#user').html(selectUser);
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
@endsection
