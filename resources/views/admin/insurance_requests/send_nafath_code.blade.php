@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Insurance Request</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.insurance_requests-index') }}">Insurances Requests</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Send Nafath Code</li>
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
            {{-- Left Section --}}
            <div class="col-lg-3 col-xlg-3 col-md-5">
                <div class="card">
                    <div class="card-body">
                        <center class="mt-4">
                            {{-- Insurance Type --}}
                            <small class="text-muted pt-4 db">Insurance Type</small>
                            <h4 class="card-title mt-2"> {{ isset($insuranceRequest->insurance_type) ? $insuranceRequest->insurance_type : '-------' }}</h4>



                            {{-- Added Since --}}
                            <small class="text-muted pt-4 db">Added Since</small>
                            <h6>{!! isset($insuranceRequest->created_at) ? $insuranceRequest->created_at->diffForHumans() : '-------' !!}</h6>

                            {{-- Addition Time --}}
                            <small class="text-muted pt-4 db">Addition Time</small>
                            <h6>{!! isset($insuranceRequest->created_at) ? date('h:i A', strtotime($insuranceRequest->created_at)) : '-------' !!}</h6>

                            {{-- Addition Date --}}
                            <small class="text-muted pt-4 db">Addition Date</small>
                            <h6>{!! isset($insuranceRequest->created_at) ? date('Y / F (m) / d', strtotime($insuranceRequest->created_at)) : '-------' !!}</h6>
                        </center>
                    </div>
                </div>
            </div>

            {{-- Right Section --}}
            <div class="col-lg-9 col-xlg-9 col-md-7">
                <div class="card">

                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="tab_body_1" role="tabpanel" aria-labelledby="tab_body_1">
                            <div class="card-body">
                                <div class="row">
                                    <form action="{{ route('super_admin.insurance_requests-sendNafathCodeRequest', $insuranceRequest->id) }}" method="POST" id="signUpForm"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            {{-- Nafath Code --}}
                                            <div class="col-md-12">
                                                <div class="form-floating mb-3">
                                                    <input type="number"
                                                        name="nafath_code"
                                                        id="nafath_code"
                                                        min="0"
                                                        max="99"
                                                        maxlength="2"
                                                        class="form-control border border-info @error('nafath_code') border-danger @enderror"
                                                        value="{{ old('nafath_code') }}"
                                                        placeholder="Enter 2-digit code"
                                                        required>
                                                    <label for="nafath_code">
                                                        <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                                        Nafath Code (2 digits)
                                                        <strong class="text-danger">
                                                            @error('nafath_code')
                                                            ( {{ $message }} )
                                                            @enderror
                                                        </strong>
                                                    </label>
                                                </div>
                                            </div>

                                            {{-- Submit Button --}}
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-info text-white">Send Code</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
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
    $('#signUpForm').on('submit', function(e) {
        e.preventDefault();

        const form = $(this);
        const submitBtn = form.find('button[type="submit"]');
        const originalBtnText = submitBtn.text();

        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...');

        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                Swal.fire({
                    title: 'Success!',
                    text: 'Nafath Code Added Successfully',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    window.location.href = "{{ route('super_admin.insurance_requests-index') }}";
                });
            },
            error: function(xhr) {
                let errorMessage = 'An error occurred while sending the code';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }

                Swal.fire({
                    title: 'Error!',
                    text: errorMessage,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });

                submitBtn.prop('disabled', false).text(originalBtnText);
            }
        });
    });

    // Add input validation
    $('#nafath_code').on('input', function() {
        let value = $(this).val();
        // Remove any non-numeric characters
        value = value.replace(/[^0-9]/g, '');
        // Limit to 2 digits
        if (value.length > 2) {
            value = value.slice(0, 2);
        }
        $(this).val(value);
    });
});
</script>
@endsection
