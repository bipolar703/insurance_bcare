@extends('layouts.app')
@section('content')
    {{-- =========================================================== --}}
    {{-- ================== Sweet Alert Section ==================== --}}
    {{-- =========================================================== --}}
    <div>
        @if (session()->has('success'))
            <script>
                Swal.fire('"Great Job !!!"', '{!! Session::get('success') !!}', 'success');
            </script>
        @endif
        @if (session()->has('danger'))
            <script>
                Swal.fire('"Great Job !!!"', '{!! Session::get('danger') !!}', 'danger');
            </script>
        @endif
    </div>


    <section class="paymentMethodCheck py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 paymentCard">
                    <div class="cardInfo">
                        <h2>التحقق من رقم الهاتف</h2>
                        <p>
                            تم إرسال رسالة نصية إلى جوالك لربط الوثيقة على رقم الهاتف الخاص بك !
                            <br>
                            يرجى إدخال رمز التحقق المرسل الى جوالك
                            <br>
                            <span class="phone">+966 {{ $allFormData['mobile_number'] !== null ? $allFormData['mobile_number'] : '----' }}</span>
                        </p>
                        <form action="{{ route('checkPhoneNumberRequest') }}" method="POST" class="form">
                            @csrf
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <div class="inputGroup">
                                        <label for="code">رمز التحقق *
                                            <strong class="text-danger">
                                                @error('check_mobile_number_verification_code')
                                                ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                        <input name="check_mobile_number_verification_code" type="number" class="form-control" placeholder="ادخل رمز التحقق المرسل الى جوالك" value="{{ old('check_mobile_number_verification_code') }}" oninput="checkLength(this)" min="0">

                                        {{-- <input name="check_mobile_number_verification_code" type="number"  class="form-control" maxlength="6" minlength="4" placeholder="ادخل رمز التحقق المرسل الى جوالك" value="{{ old('check_mobile_number_verification_code') }}"> --}}
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <p>سيتم إرسال رمز التحقق في خلال دقيقة</p>
                                </div>
                                <div class="col-12">
                                    <input type="submit" class="submit" value="تأكيد"> 
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection
<script>
    function checkLength(input) {
        var maxLength = 6;
        if (input.value.length > maxLength) {
            input.value = input.value.slice(0, maxLength); // قص القيمة إلى الحد الأقصى
        }
    }
    </script>
    