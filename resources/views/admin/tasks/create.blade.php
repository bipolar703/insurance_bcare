@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Add New Task</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.tasks-index') }}">All Tasks</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add New</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Archive --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.tasks-showSoftDelete') }}" class="btn btn-danger">
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
                        <h4 class="card-title mb-3 pb-3 border-bottom">Add New Task :</h4>
                        <form action="{{ route('super_admin.tasks-store') }}" method="POST" enctype="multipart/form-data"
                            id="createForm">
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

                                {{-- project_id --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <select name="project_id" id="project_id" onchange="getDepartments()"
                                            class="form-control form-select border border-info @error('customer_id') border-danger @enderror custom_select_style"
                                            style="width: 100%">
                                            @if (isset($projects) && $projects->count() > 0)
                                                <option value="">Select Project Name</option>
                                                @foreach ($projects as $project)
                                                    <option value="{{ $project->id }}"
                                                        @if (old('project_id') == $project->id) selected @endif>
                                                        {{ isset($project->name_en) ? $project->name_en : '------' }}
                                                    </option>
                                                @endforeach
                                            @else
                                                <option value="">No Project Is Available</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" value="{{ old('department_id') ? old('department_id') : null }}"
                                    id="department_id_old_value">
                                {{-- Department --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                        <select name="department_id" id="department_id" onchange="getEmployees()"
                                            class="form-control form-select border border-info @error('department_id') border-danger @enderror custom_select_style">
                                            <option value="">Choose Depratment</option>
                                        </select>
                                        <label for="tb-name">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                            Choose Depratment
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
                                <input type="hidden" value="{{ old('user_id') ? old('user_id') : null }}"
                                    id="employee_id_old_value">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                        <select name="user_id" id="user_id"
                                            class="form-control form-select border border-info @error('user_id') border-danger @enderror custom_select_style">

                                            <option value="">Select Employee Name</option>

                                        </select>
                                        <label for="tb-name">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                            Choose Employee
                                            <strong class="text-danger">
                                                @error('user_id')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                    </div>
                                </div>


                                {{-- Task Start Date --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="date" name="task_start_date"
                                            class="form-control border border-info @error('task_start_date') border-danger @enderror"
                                            id="tb-name" value="{{ old('task_start_date') }}"
                                            placeholder="Task Start Date">
                                        <label for="tb-name">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>Task
                                            Start Date
                                            <strong class="text-danger">
                                                @error('task_start_date')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- estimated_time --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" step=".01" name="estimated_time"
                                            class="form-control border border-info @error('estimated_time') border-danger @enderror"
                                            id="tb-name" value="{{ old('estimated_time') }}"
                                            placeholder="Estimated Time">
                                        <label for="tb-name">
                                            <i data-feather="type"
                                                class="feather-sm text-info fill-white me-2"></i>Estimated Time
                                            <strong class="text-danger">
                                                @error('estimated_time')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>




                                {{-- task_priority --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                        <select name="task_priority"
                                            class="form-control form-select border border-info @error('task_priority') border-danger @enderror custom_select_style">
                                            <option>--- Choose Task Priority ---</option>
                                            <option value="1" @if (old('task_priority') == 1) selected @endif
                                                @if (old('task_priority') == null) selected @endif>Low </option>
                                            <option value="2" @if (old('task_priority') == 2) selected @endif>
                                                Medium </option>
                                            <option value="3" @if (old('task_priority') == 3) selected @endif>
                                                High </option>

                                        </select>
                                        <label for="tb-name">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                            Choose Task Priority
                                            <strong class="text-danger">
                                                @error('task_priority')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                    </div>
                                </div>
                                {{-- Files --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3 ">
                                        <input type="file" name="other_file"
                                            class="form-control @error('other_file') is-invalid @enderror"
                                            id="other_file">
                                        <label for="other_file">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                            Choose File
                                            <strong class="text-danger">
                                                @error('other_file')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>
                                {{-- Other File Title --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text"name="other_file_title"
                                            class="form-control border border-info @error('other_file_title') border-danger @enderror"
                                            id="tb-name" value="{{ old('other_file_title') }}"
                                            placeholder="Other File Title">
                                        <label for="tb-name">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>Other
                                            File Title
                                            <strong class="text-danger">
                                                @error('other_file_title')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- Description --}}
                                <div class="col-md-12">
                                    <div class="form-floating mb-3">
                                        <textarea name="description" class="form-control border border-info @error('description') border-danger @enderror"
                                            id="tb-description-en" placeholder="Description" rows="15">{{ old('description') }}</textarea>
                                        <label for="tb-description-en">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                            Description
                                            <strong class="text-danger">
                                                @error('description')
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

@endsection

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function() {
        var project_id = document.getElementById('project_id').value;

        if (project_id) {
            var formData = new FormData($('#createForm')[0]);

            var fullRoute = "{{ route('super_admin.tasks-getDepartments') }}?project_id=" + project_id;
            $.ajax({
                type: 'POST',
                url: fullRoute,
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function(data) {
                    console.log(data.records)
                    if (data.status == true) {

                        var selectdepartments = '<option value="">Choose Department ... </option>';
                        for (var key in data.records) {
                            // skip loop if the property is from prototype
                            if (!data.records.hasOwnProperty(key)) continue;

                            var obj = data.records[key];
                            // alert(obj.id);
                            for (var prop in obj) {
                                // skip loop if the property is from prototype
                                if (!obj.hasOwnProperty(prop)) continue;

                                // your code
                                var department_id_old_value = $("#department_id_old_value").val();
                                if (department_id_old_value) {
                                    if (obj.id == department_id_old_value) {
                                        selectdepartments += '<option value="' + obj.department_id +
                                            '" selected>' +
                                            obj.department_name + '</option>';
                                    } else {
                                        selectdepartments += '<option value="' + obj.department_id +
                                            '">' + obj
                                            .department_name +
                                            '</option>';
                                    }
                                } else {
                                    selectdepartments += '<option value="' + obj.department_id +
                                        '">' + obj
                                        .department_name +
                                        '</option>';
                                }
                                break;
                            }
                        }
                        $('#department_id').html(selectdepartments);
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
        getDepartments();
    });

    function getDepartments() {
        var project_id = document.getElementById('project_id').value;
        var formData = new FormData($('#createForm')[0]);
        $.ajax({
            type: 'POST',
            url: "{{ route('super_admin.tasks-getDepartments') }}?project_id=" + project_id,
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {
                console.log(data.departments)
                if (data.status == true) {

                    var selectdepartments = '<option value="">Choose Department ... </option>';

                    var obj = data.record;

                    // your code
                    var department_id_old_value = $("#department_id_old_value").val();
                    if (department_id_old_value) {
                        // If old value is design team
                        if (department_id_old_value == obj.design_department_id) {
                            selectdepartments += '<option value="' + obj.design_department_id +
                                '" selected>' + obj.design_department_name + '</option>';
                            selectdepartments += '<option value="' + obj.mobile_department_id + '">' + obj
                                .mobile_department_name + '</option>';
                            selectdepartments += '<option value="' + obj.web_department_id + '">' + obj
                                .web_department_name + '</option>';
                        } else if (department_id_old_value == obj.mobile_department_id) {
                            // If old value is mobile team
                            selectdepartments += '<option value="' + obj.design_department_id + '">' + obj
                                .design_department_name + '</option>';
                            selectdepartments += '<option value="' + obj.mobile_department_id +
                                '" selected>' + obj.mobile_department_name + '</option>';
                            selectdepartments += '<option value="' + obj.web_department_id + '">' + obj
                                .web_department_name + '</option>';
                        } else if (department_id_old_value == obj.web_department_id) {
                            // If old value is web team
                            selectdepartments += '<option value="' + obj.design_department_id + '">' + obj
                                .design_department_name + '</option>';
                            selectdepartments += '<option value="' + obj.mobile_department_id + '">' + obj
                                .mobile_department_name + '</option>';
                            selectdepartments += '<option value="' + obj.web_department_id + '" selected>' +
                                obj.web_department_name + '</option>';
                        } else {
                            // Design Department
                            selectdepartments += '<option value="' + obj.design_department_id + '">' + obj
                                .design_department_name + '</option>';
                            // Mobile Department
                            selectdepartments += '<option value="' + obj.mobile_department_id + '">' + obj
                                .mobile_department_name + '</option>';
                            // Web Department
                            selectdepartments += '<option value="' + obj.web_department_id + '">' + obj
                                .web_department_name + '</option>';
                        }

                    } else {
                        // Design Department
                        selectdepartments += '<option value="' + obj.design_department_id + '">' + obj
                            .design_department_name + '</option>';
                        // Mobile Department
                        selectdepartments += '<option value="' + obj.mobile_department_id + '">' + obj
                            .mobile_department_name + '</option>';
                        // Web Department
                        selectdepartments += '<option value="' + obj.web_department_id + '">' + obj
                            .web_department_name + '</option>';
                    }
                    $('#department_id').html(selectdepartments);
                    getEmployees()
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

    function getEmployees() {
        var department_id = document.getElementById('department_id').value;
        var formData = new FormData($('#createForm')[0]);
        $.ajax({
            type: 'POST',
            url: "{{ route('super_admin.tasks-getEmployees') }}?department_id=" + department_id,
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {

                if (data.status == true) {

                    var selectemployees = '<option value="">Choose Employee ... </option>';
                    for (var key in data.records) {
                        // skip loop if the property is from prototype
                        if (!data.records.hasOwnProperty(key)) continue;

                        var obj = data.records[key];
                        // alert(obj.id);
                        for (var prop in obj) {
                            // skip loop if the property is from prototype
                            if (!obj.hasOwnProperty(prop)) continue;

                            // your code
                            var employee_id_old_value = $("#employee_id_old_value").val();
                            if (employee_id_old_value) {
                                if (obj.id == employee_id_old_value) {
                                    selectemployees += '<option value="' + obj.id +
                                        '" selected>' +
                                        obj.name + '</option>';
                                } else {
                                    selectemployees += '<option value="' + obj.id + '">' + obj
                                        .name +
                                        '</option>';
                                }
                            } else {
                                selectemployees += '<option value="' + obj.id + '">' + obj
                                    .name +
                                    '</option>';
                            }
                            break;
                        }
                    }
                    $('#user_id').html(selectemployees);
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
        $('select[name="project_id"]').select2();


    });
</script>
