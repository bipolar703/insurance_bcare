@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">

            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Add New Lead</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.leads-index') }}">All Leads</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add New</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Archive --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.leads-showSoftDelete') }}" class="btn btn-danger">
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
                        <h4 class="card-title mb-3 pb-3 border-bottom">Add New Lead :</h4>
                        <form action="{{ route('super_admin.leads-store') }}" method="POST" enctype="multipart/form-data"
                            id="createForm">
                            @csrf
                            <div class="row">
                                {{-- title --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="title"
                                            class="form-control border border-info @error('title') border-danger @enderror"
                                            id="tb-name" value="{{ old('title') }}" placeholder="Title">
                                        <label for="tb-name">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i> Title
                                            <strong class="text-danger">
                                                @error('title')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- email --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="email" name="email"
                                            class="form-control border border-info @error('email') border-danger @enderror"
                                            id="tb-email" value="{{ old('email') }}" placeholder="Email">
                                        <label for="tb-email">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>Email
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
                                                    @if (old('country_phone_id') == $phone_key->id) selected @endif>

                                                    {{ isset($phone_key->phone_code) ? $phone_key->name_en . ' (' . $phone_key->phone_code . '+)' : '------' }}

                                                </option>
                                            @endforeach
                                        </select>
                                    @endif
                                    {{-- phone --}}
                                    <div class="form-floating mb-3 col-md-8">
                                        <input type="number" name="phone" min="0"
                                            class="form-control border border-info  phone_No  @error('phone') border-danger @enderror"
                                            id="tb-phone" value="{{ old('phone') }}" placeholder="Phone">
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
                                            id="tb-authorized_signatory" value="{{ old('authorized_signatory') }}"
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
                                                <option value="">--- Choose Lead Status ---</option>
                                                <option value="1" @if (old('status') == 1) selected @endif
                                                    @if (old('status') == null) selected @endif>Open</option>
                                                <option value="2" @if (old('status') == 2) selected @endif>
                                                    Completed </option>
                                                <option value="3" @if (old('status') == 3) selected @endif>
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
                                        <select name="employee_id" required id="employeeID"
                                            class="form-control form-select border border-info @error('employee_id') border-danger @enderror custom_select_style"
                                            style="width: 100%">
                                            @if (isset($salesEmployees) && $salesEmployees->count() > 0)
                                                <option value="">--- Select Employee ---<span>*</span></option>
                                                @foreach ($salesEmployees as $salesEmployee)
                                                    <option value="{{ $salesEmployee->id }}"
                                                        @if (old('employee_id') == $salesEmployee->id) selected @endif>
                                                        {{ isset($salesEmployee->name) ? $salesEmployee->name : '------' }}
                                                    </option>
                                                @endforeach
                                            @else
                                                <option value="">No Employees Are Available</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                {{-- address section --}}
                                <div class="col-md-12 groove-container">

                                    <label>
                                        <h2>Address Details :</h2>
                                    </label>

                                    <div class="row">
                                        {{-- country_id --}}
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <select name="country_id" onchange="getCities()" id="countryId"
                                                    class="form-control form-select border border-info @error('country_id') border-danger @enderror @error('not_valid_country') border-danger @enderror  custom_select_style"
                                                    style="width: 100%">
                                                    @if (isset($countries) && $countries->count() > 0)
                                                        <option value="">--- Select Country ---</option>
                                                        @foreach ($countries as $country)
                                                            <option value="{{ $country->id }}"
                                                                @if (old('country_id') == $country->id) selected @endif>
                                                                {{ isset($country->name_en) ? $country->name_en : '------' }}
                                                                ({{ isset($country->name_ar) ? $country->name_ar : '------' }})
                                                            </option>
                                                        @endforeach
                                                    @else
                                                        <option value="">No Countries Are Available</option>
                                                    @endif
                                                </select>
                                                <strong class="text-danger">
                                                    @error('country_id')
                                                    ( {{ $message }} )
                                                @enderror
                                                    @error('not_valid_country')
                                                        ( {{ $message }} )
                                                    @enderror
                                                </strong>
                                            </div>
                                        </div>

                                        {{-- city_id --}}
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <input type="hidden" name="city_id_old_value" id="city_id_old_value"
                                                    value="{!! old('city_id') !!}">
                                                <select name="city_id" id="city_id"
                                                    class="form-control form-select border border-info @error('city_id') border-danger @enderror custom_select_style"
                                                    style="width: 100%">
                                                    <option value="">--- Select City ---</option>
                                                </select>
                                                <strong class="text-danger">
                                                    @error('not_valid_city')
                                                        ( {{ $message }} )
                                                    @enderror
                                                </strong>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label>Address : <strong class="text-danger">
                                                    @error('address')
                                                        ( {{ $message }} )
                                                    @enderror
                                                </strong></label>
                                            <textarea name="address" class="form-control border border-info @error('address') border-danger @enderror"
                                                rows="5" placeholder="Address">{{ old('address') }}</textarea>
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
                                                    <i data-feather="plus" class="feather-sm fill-white me-2"></i>
                                                    Add New Lead
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
            $('select[name="employee_id"]').select2();
            $('select[name="country_id"]').select2();
            $('select[name="city_id"]').select2();
        });
    </script>


    <script>
        $(document).ready(function() {
            var country_id = document.getElementById('countryId').value;

            if (country_id) {
                var formData = new FormData($('#createForm')[0]);

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
            var formData = new FormData($('#createForm')[0]);
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
                        // $('.selectpicker').selectpicker('refresh');
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
