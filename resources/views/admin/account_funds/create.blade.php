@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Account Funds</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.account_funds-index') }}">Account Funds</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add New Fund For Account</li>
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
                        <form action="{{ route('super_admin.account_funds-store') }}" method="POST"
                            enctype="multipart/form-data" id="createForm">
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

                                {{-- amount --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="amount" min="1" step="0.001"
                                            class="form-control border border-info @error('amount') border-danger @enderror"
                                            id="tb-name" value="{{ old('amount') }}" placeholder="Amount">
                                        <label for="tb-name">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i> Amount
                                            <strong class="text-danger">
                                                @error('amount')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- fund_type	 --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                            <select name="fund_type" id="fundType"
                                                class="form-control form-select border border-info @error('fund_type') border-danger @enderror custom_select_style">
                                                <option value="">--- Select Fund Type ---</option>
                                                <option value="1" @if (old('fund_type') == 1) selected @endif>
                                                    Main Account </option>
                                                <option value="2" @if (old('fund_type') == 2) selected @endif>
                                                    Account To Account </option>
                                            </select>
                                            <label for="tb-name">
                                                <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                                Fund Type
                                                <strong class="text-danger">
                                                    @error('fund_type')
                                                        ( {{ $message }} )
                                                    @enderror
                                                </strong>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                {{-- file --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="file" name="file"
                                            class="form-control border border-info @error('file') border-danger @enderror"
                                            id="tb-name" placeholder="file">
                                        <label for="tb-name">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i> File
                                            <strong class="text-danger">
                                                @error('file')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <input type="hidden" id="old_from_account_id" value="{!! old('from_account_id') !!}">
                                        <select name="from_account_id" required id="mainAccountID" onchange="getTitles()"
                                            class="form-control form-select border border-info @error('from_account_id') border-danger @enderror custom_select_style"
                                            style="width: 100%">
                                            <option value="">--- Select Main Account ---</option>
                                        </select>
                                        <strong class="text-danger">
                                            @error('from_account_id')
                                                ( {{ $message }} )
                                            @enderror
                                        </strong>
                                    </div>
                                </div>

                                {{-- to_account_id --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <input type="hidden" id="old_to_account_id" value="{!! old('to_account_id') !!}">
                                        <select name="to_account_id" id="to_account_id"
                                            class="form-control form-select border border-info @error('to_account_id') border-danger @enderror custom_select_style"
                                            style="width: 100%">
                                            <option value="">--- Select Sub Account ---</option>
                                        </select>
                                        <strong class="text-danger">
                                            @error('to_account_id')
                                                ( {{ $message }} )
                                            @enderror
                                        </strong>

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
                                                    Add New Account
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
    {{-- select 2 --}}
    <script>
        $(document).ready(function() {
            $('select[name="from_account_id"]').select2();
            $('select[name="to_account_id"]').select2();
        });
    </script>

    {{-- GET ACCOUNTS & GET TITLES --}}
    <script>
        $(document).ready(function() {
            $('#fundType').change(function() {
                getAccounts();
            });
        });
        // =============== Edited By Raghad =============== 
        function getAccounts() {
            var formData = new FormData($('#createForm')[0]);
            var fundType = document.getElementById('fundType').value;
            if (fundType) {
                $.ajax({
                type: 'POST',
                url: "{{ route('super_admin.account_funds-getAccounts') }}",
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function(data) {
                    if (data.status == true) {
                        var selectMainAccount =
                            '<option value="">--- Select Main Account ---</option>';
                        for (var key in data.accounts) {
                            // skip loop if the property is from prototype
                            if (!data.accounts.hasOwnProperty(key)) continue;

                            var obj = data.accounts[key];
                            // alert(obj.id);
                            for (var prop in obj) {
                                // skip loop if the property is from prototype
                                if (!obj.hasOwnProperty(prop)) continue;

                                // your code
                                var old_from_account_id = $("#old_from_account_id").val();
                                if (old_from_account_id) {
                                    if (obj.id == old_from_account_id) {
                                        selectMainAccount += '<option value="' + obj.id +
                                            '" selected>' +
                                            obj.title_ar + '(' + (obj.title_en) + ')' + '</option>';
                                    } else {
                                        selectMainAccount += '<option value="' + obj.id + '">' + obj
                                            .title_ar + '(' + (obj.title_en) + ')' + '</option>';
                                    }
                                } else {
                                    selectMainAccount += '<option value="' + obj.id + '">' + obj
                                        .title_ar + '(' + (obj.title_en) + ')' + '</option>';
                                }

                                break;
                            }
                        }
                        $('#mainAccountID').html(selectMainAccount);
                        getTitles();
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

        function getTitles() {
            var parent_id = document.getElementById('mainAccountID').value;

            if (parent_id) {
                var formData = new FormData($('#createForm')[0]);

                var fullRoute = "{{ route('super_admin.account_funds-getTitles', 'parent_id=:parent_id') }}";
                fullRoute = fullRoute.replace(':parent_id', parent_id);
                $.ajax({
                    type: 'POST',
                    url: fullRoute,
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function(data) {

                        if (data.status == true) {

                            var selectSubAccount =
                                '<option value="">--- Select Sub Account ---</option>';

                            for (var key in data.accounts) {
                                // skip loop if the property is from prototype
                                if (!data.accounts.hasOwnProperty(key)) continue;

                                var obj = data.accounts[key];

                                for (var prop in obj) {
                                    // skip loop if the property is from prototype
                                    if (!obj.hasOwnProperty(prop)) continue;
                                    var old_to_account_id = $("#old_to_account_id").val();
                                    if (old_to_account_id) {
                                        if (obj.id == old_to_account_id) {
                                            selectSubAccount += '<option value="' + obj.id +
                                                '" selected>' +
                                                obj.title_ar + '(' + (obj.title_en) + ')' +
                                                '</option>';
                                        } else {
                                            selectSubAccount += '<option value="' + obj.id + '">' +
                                                obj
                                                .title_ar + '(' + (obj.title_en) + ')' +
                                                '</option>';
                                        }
                                    } else {
                                        selectSubAccount += '<option value="' + obj.id + '">' + obj
                                            .title_ar + ' ' +
                                            '(' + (obj.title_en) + ')' + '</option>';
                                    }

                                    break;
                                }
                            }
                            $('#to_account_id').html(selectSubAccount);

                        } else {

                            // To clear the select before adding options => Done By Raghad, to remove the value of the select if we changed the main account select value
                            var subAccountSelect = $('#to_account_id');
                            subAccountSelect.find('option').remove();
                            var selectSubAccount =
                                '<option value="">--- There are no available accounts ---</option>';
                            subAccountSelect.html(selectSubAccount);

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
    </script>

    {{-- HIDE/SHOW SUB ACCOUNT --}}
    <script>
        $(document).ready(function() {
            $('#fundType').change(function() {
                var fundType = $(this).val();

                // If fundType is "Account To Account", show the to_account_id select
                if (fundType == 2) {
                    $('#to_account_id').closest('.col-md-6').show();
                } else {
                    // Otherwise, hide the to_account_id select
                    $('#to_account_id').closest('.col-md-6').hide();
                }
            });

            // Trigger change event initially to set the initial visibility state
            $('#fundType').change();
        });
    </script>
@endsection
