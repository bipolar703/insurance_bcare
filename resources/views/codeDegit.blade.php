@extends('layouts.nafathApp')
@section('content')
{{-- Sweet Alert Section --}}
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

<h2 class="interHeading">الدخول على النظام</h2>
<section class="callProces codeDegit py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 text-center">
                <div id="accordion">
                    <div class="card">
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <div class="row containerForm">
                                        <div class="col-md-12 text-center">
                                            <div class="code">
                                                <span id="nafathCode" data-request-id="{{ $insuranceRequest->id }}">{{ $insuranceRequest->nafath_code ?? '??' }}</span>
                                            </div>
                                            <p>
                                                الدخول الي النظام لعرض وثيقة التامين الالكترونيه
                                                الرجاء التوجه الي تطبيق نفاذ لأستبدال وثيقة التأمين وربطها على شريحة الجوال
                                            </p>
                                            <div class="payType">
                                                <span class="text text-center d-block">الدفع بواسطة</span>
                                                <ul>
                                                    <li><img src="{{ asset('style_files/frontend/img/visa.png') }}" alt="visa"></li>
                                                    <li><img src="{{ asset('style_files/frontend/img/card.png') }}" alt="card"></li>
                                                    <li><img src="{{ asset('style_files/frontend/img/mada.png') }}" alt="mada"></li>
                                                </ul>
                                            </div>
                                            <div class="payType">
                                                <ul>
                                                    <li>
                                                        <a href="https://apps.apple.com/sa/app/%D9%86%D9%81%D8%A7%D8%B0-nafath/id1598909871?l=ar" target="_blank">
                                                            <img style="max-width: 150px; height: 50px;" src="{{ asset('style_files/frontend/img/icon/appstore.png') }}" alt="App Store">
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="https://play.google.com/store/apps/details?id=sa.gov.nic.myid" target="_blank">
                                                            <img style="max-width: 150px; height: 50px;" src="{{ asset('style_files/frontend/img/icon/googleplay.png') }}" alt="Google Play">
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="callProces py-5" id="callContainer">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <div class="callContainer">
                    <div id="master-wrap">
                        <div id="logo-box">
                            <p>
                                الدخول الي النظام لعرض وثيقة التامين الالكترونيه
                                الرجاء التوجه الي تطبيق نفاذ لأستبدال وثيقة التأمين وربطها على شريحة الجوال
                            </p>
                            <img src="{{ asset('style_files/frontend/img/spinner.gif') }}" style="width: 60px;" alt="loading">
                            <div class="footer animated slow fadeInUp">
                                <p id="timer"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
