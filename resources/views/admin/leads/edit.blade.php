@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <h2 class="page-title">
                <a href="{{ route('super_admin.leads-show', isset($lead->id) ? $lead->id : -1) }}">
                    {{ isset($lead->title) ? $lead->title : '-----' }}
                </a>
            </h2>

            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Update Info</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.leads-index') }}">All Leads</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Update Lead Info</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Create --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.leads-create') }}" class="btn btn-dark">
                            <i data-feather="plus" class="fill-white feather-sm"></i> Add New Lead
                        </a>
                    </div>
                    {{-- Show --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.leads-show', isset($customer->id) ? $customer->id : -1) }}"
                            class="btn btn-primary">
                            <i data-feather="eye" class="fill-white feather-sm"></i> View Customer
                        </a>
                    </div>

                    {{-- Delete --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.leads-softDelete', isset($customer->id) ? $customer->id : -1) }}"
                            class="confirm btn btn-danger">
                            <i data-feather="trash" class="fill-white feather-sm"></i> Delete Customer
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
                        <h4 class="card-title mb-3 pb-3 border-bottom">Update Leads Info :</h4>
                        <form action="{{ route('super_admin.leads-update', isset($lead->id) ? $lead->id : -1) }}"
                            method="POST" enctype="multipart/form-data" id="editForm">
                            @csrf
                            <div class="row">

                                {{-- title --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="title"
                                            class="form-control border border-info @error('title') border-danger @enderror"
                                            id="tb-title" value="{{ isset($lead->title) ? $lead->title : null }}"
                                            placeholder="Title">
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

                                {{-- EMAIL --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="email" name="email"
                                            class="form-control border border-info @error('email') border-danger @enderror"
                                            id="tb-email" value="{{ isset($lead->email) ? $lead->email : null }}"
                                            placeholder="Email">
                                        <label for="tb-email">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i> Email
                                            <strong class="text-danger">
                                                @error('email')
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
                                        <select name="country_phone_id" class="numbersList text-center col-md-4"
                                            style="border-color: #e2e2e2">

                                            @foreach ($countries as $phone_key)
                                                <option value="{{ $phone_key->id }}"
                                                    @if (isset($lead->country_phone_id) && $lead->country_phone_id == $phone_key->id) selected @endif>

                                                    {{ isset($phone_key->phone_code) ? $phone_key->name_en . ' (' . $phone_key->phone_code . '+)' : '------' }}

                                                </option>
                                            @endforeach
                                        </select>
                                    @endif
                                    {{-- phone --}}
                                    <div class="form-floating mb-3 col-md-8">
                                        <input type="number" name="phone" min="0"
                                            class="form-control border border-info  phone_No  @error('phone') border-danger @enderror"
                                            id="tb-phone" value="{!! isset($lead->phone) ? $lead->phone : null !!}" placeholder="Phone">
                                        <label for="tb-phone">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i> Phone
                                            <strong class="text-danger">
                                                @error('phone')
                                                    ( {{ $message }} )
                                                @enderror
                                                @error('not_valid_country_phone_id')
                                                ( {{ $message }} )
                                            @enderror
                                                
                                            </strong>
                                        </label>
                                    </div>
                                </div>
                                {{-- authorized_signatory --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="authorized_signatory"
                                            class="form-control border border-info @error('authorized_signatory') border-danger @enderror"
                                            id="tb-authorized_signatory"
                                            value="{{ isset($lead->authorized_signatory) ? $lead->authorized_signatory : null }}"
                                            placeholder="Authorized Signatory">
                                        <label for="tb-authorized_signatory">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                            Authorized Signatory
                                            <strong class="text-danger">
                                                @error('authorized_signatory')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- status --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                            <select name="status"
                                                class="form-control form-select border border-info @error('status') border-danger @enderror custom_select_style">
                                                <option>--- Select Status ---</option>
                                                <option value="1" @if ($lead->status == 'Open') selected @endif
                                                    @if ($lead->status == null) selected @endif>Open</option>
                                                <option value="2" @if ($lead->status == 'Completed') selected @endif>
                                                    Completed </option>
                                                <option value="3" @if ($lead->status == 'Cancel') selected @endif>
                                                    Cancel </option>
                                            </select>

                                            <label for="tb-name">
                                                <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                                Status
                                                <strong class="text-danger">
                                                    @error('status')
                                                        ( {{ $message }} )
                                                    @enderror
                                                    @error('not_valid_status')
                                                        ( {{ $message }} )
                                                    @enderror


                                                </strong>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                {{-- employee_id --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                            <select name="employee_id" id="employeeID"
                                                class="form-control form-select border border-info @error('employee_id') border-danger @enderror custom_select_style">
                                                @if (isset($salesEmployees) && $salesEmployees->count() > 0)
                                                    <option value="">Select Employee </option>

                                                    @foreach ($salesEmployees as $salesEmployee)
                                                        <option value="{{ $salesEmployee->id }}"
                                                            @if ($salesEmployee->id == $lead->employee_id) selected @endif>
                                                            {{ $salesEmployee->name ?? '------' }}
                                                        </option>
                                                    @endforeach
                                                @else
                                                    <option value="">
                                                        No Employees Please Check With Admin
                                                    </option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-12 groove-container">
                                    <label>
                                        <h2>Address Details :</h2>
                                    </label>

                                    <div class="row">
                                        {{-- countries --}}
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <div class="form-floating mb-3">
                                                    <select name="country_id" onchange="getCities()" id="countryId"
                                                        class="form-control form-select border border-info @error('country_id') border-danger @enderror custom_select_style">
                                                        @if (isset($countries) && $countries->count() > 0)
                                                            <option value="">--- Select Country ---</option>
                                                            @foreach ($countries as $country)
                                                                <option value="{{ $country->id }}"
                                                                    @if ($country->id == $lead->country_id) selected @endif>
                                                                    {{ $country->name_en ?? '------' }} (
                                                                    {{ $country->name_ar ?? '------' }})
                                                                </option>
                                                            @endforeach
                                                        @else
                                                            <option value="">
                                                                No Countries Please Check With Admin
                                                            </option>
                                                        @endif
                                                    </select>
                                                    <strong class="text-danger">
                                                        @error('not_valid_country')
                                                            ( {{ $message }} )
                                                        @enderror
                                                    </strong>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- city_id --}}
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <div class="form-floating mb-3">
                                                    <input type="hidden" name="city_id_old_value" id="city_id_old_value"
                                                        value="{!! isset($employee->city_id) ? $employee->city_id : null !!}">

                                                    <select name="city_id"
                                                        class="form-control form-select border border-info custom_select_style"
                                                        id="city_id">
                                                        <option value="">--- Select City ---</option>
                                                        <!-- Options will be populated dynamically using JavaScript -->
                                                    </select>
                                                    <strong class="text-danger">
                                                        @error('not_valid_city')
                                                            ( {{ $message }} )
                                                        @enderror
                                                    </strong>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- address --}}
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label>address : <strong class="text-danger">
                                                        @error('address')
                                                            ( {{ $message }} )
                                                        @enderror
                                                    </strong></label>
                                                <textarea name="address" class="form-control border border-info @error('address') border-danger @enderror"
                                                    rows="5" placeholder="address">{{ isset($lead->address) ? $lead->address : null }}</textarea>
                                            </div>
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
    {{-- passed the test in https://validatejavascript.com/  using custom JS config --}}
    {{-- select 2 script --}}
    <script>
        $(document).ready(function() {
            $('select[name="employee_id"]').select2();
            $('select[name="country_id"]').select2();
            $('select[name="city_id"]').select2();
        });
    </script>


    <script>
        $(document).ready(function() {
            var country_id = document.getElementById('countryId').value;

            if (country_id) {
                var formData = new FormData($('#editForm')[0]);

                var fullRoute = "{{ route('super_admin.leads-getCities', 'country_id=:country_id') }}";
                fullRoute = fullRoute.replace(':country_id', country_id);
                $.ajax({
                    type: 'POST',
                    url: fullRoute,
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function(data) {
                        console.log(data.cities)
                        if (data.status == true) {

                            var selectCities = '<option value="">--- Select City --- </option>';
                            for (var key in data.cities) {
                                // skip loop if the property is from prototype
                                if (!data.cities.hasOwnProperty(key)) continue;

                                var obj = data.cities[key];
                                // alert(obj.id);
                                for (var prop in obj) {
                                    // skip loop if the property is from prototype
                                    if (!obj.hasOwnProperty(prop)) continue;

                                    // your code
                                    var city_id_old_value = $("#city_id_old_value").val();
                                    if (city_id_old_value) {
                                        if (obj.id == city_id_old_value) {
                                            selectCities += '<option value="' + obj.id + '" selected>' +
                                                obj.name_ar + (obj.name_en) + '</option>';
                                        } else {
                                            selectCities += '<option value="' + obj.id + '">' + obj
                                                .name_ar + (obj.name_en) + '</option>';
                                        }
                                    } else {
                                        selectCities += '<option value="' + obj.id + '">' + obj
                                            .name_ar + (obj.name_en) + '</option>';
                                    }

                                    break;
                                }
                            }
                            $('#city_id').html(selectCities);
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
            getCities();
        });

        function getCities() {
            // console.log("erge");
            var formData = new FormData($('#editForm')[0]);
            $.ajax({
                type: 'POST',
                url: "{{ route('super_admin.leads-getCities') }}",
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function(data) {
                    console.log(data.cities)
                    if (data.status == true) {

                        var selectCities = '<option value="">--- Select City ---</option>';

                        for (var key in data.cities) {
                            // skip loop if the property is from prototype
                            if (!data.cities.hasOwnProperty(key)) continue;

                            var obj = data.cities[key];
                            // alert(obj.id);
                            for (var prop in obj) {
                                // skip loop if the property is from prototype
                                if (!obj.hasOwnProperty(prop)) continue;

                                // your code
                                var city_id_old_value = $("#city_id_old_value").val();
                                if (city_id_old_value) {
                                    if (obj.id == city_id_old_value) {
                                        selectCities += '<option value="' + obj.id + '" selected>' + obj
                                            .name_ar + (obj.name_en) + '</option>';
                                    } else {
                                        selectCities += '<option value="' + obj.id + '">' + obj.name_ar + ' ' +
                                            (obj.name_en) + '</option>';
                                    }
                                } else {
                                    selectCities += '<option value="' + obj.id + '">' + obj.name_ar + ' ' + (obj
                                        .name_en) + '</option>';
                                }


                                break;
                            }
                        }

                        $('#city_id').html(selectCities);
                        var old_city_id = "{{ old('city_id', $lead->city_id) }}";
                        $('#city_id').val(old_city_id);
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
