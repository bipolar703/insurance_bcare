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
                        <div class="payType">
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
                        <div class="text-center mb-5">
                            <p class="text-danger declineText">نأسف, تم رفض بطاقتك , يرجى الضغط على متابعة ثم محاولة الدفع من بطاقة أخرى لإكمال الوثيقة بنجاح</p>
                        </div>
                        <a href=" {{ route('welcome') }} " class="submit mx-auto d-block text-center text-white">متابعة</a>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection
