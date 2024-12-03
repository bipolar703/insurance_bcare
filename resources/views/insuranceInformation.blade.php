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


    <!-- BREADCRUMB AREA START -->
    <div class="breadcrumb py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>معلومات التأمين</h2>
                </div>
            </div>
        </div>
    </div>
    <!-- BREADCRUMB AREA END -->


    <section class="insuranceInfo py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 card">
                    <div class="cardInfo">
                        <form action="{{ route('insuranceInformationRequest') }}" method="POST" class="form">
                            @csrf
                            <div class="top">
                                {{-- image --}}
                                <div class="image mb-3 text-center">
                                    @if (isset($insurance->image) && $insurance->image && file_exists($insurance->image))
                                        <img src="{{ asset($insurance->image) }}" alt="fender-bender">    
                                    @else
                                        <img src="{{ asset('style_files/shared/images_default/default.jpg') }}" alt="fender-bender">
                                    @endif
                                </div>
                                <div class="title">
                                    <div class="starRate d-flex">
                                        <i class="fa-solid fa-star gold"></i>
                                        <i class="fa-solid fa-star gold"></i>
                                        <i class="fa-solid fa-star gold"></i>
                                        <i class="fa-solid fa-star gold"></i>
                                    </div>
    
                                    {{-- insurance_type --}}
                                    @if (isset($insurance->insurance_type) && $insurance->insurance_type == 'ضد الغير')
                                        <h4>تأمين المركبات ضد الغير</h4>
                                    @else
                                        <h4>تأمين المركبات الشامل</h4>
                                    @endif
                                </div>
                            </div>
                            <div class="body">
                                <ul>
                                    <li>
                                        <span class="text">
                                            سعر الوثيقة
                                        </span>
                                        <span class="price">
                                            {{ isset($insurance->price) ? number_format($insurance->price,2) : '----' }}
                                            ريال
                                        </span>
                                    </li>
                                    <li>
                                        <span class="text">
                                            خصم عدم وجود مطالبات
                                        </span>
                                        <span class="price">
                                            {{ isset($insurance->price) ? number_format($insurance->price * 50 / 100,2) : '----' }}
                                            ريال
                                        </span>
                                    </li>
                                    <li>
                                        <span class="text">
                                            رسوم إدارية
                                        </span>
                                        <span class="price">
                                            00.00
                                            ريال
                                        </span>
                                    </li>
                                    <li>
                                        <span class="text">
                                            قسط إشتراك التأمين
                                        </span>
                                        <span class="price">
                                            ({{ isset($insurance->price) ? number_format($insurance->price + ($insurance->price * 15 / 100),2) : '----' }} ر.س)
                                        </span>
                                    </li>
                                    <li>
                                        <span class="text">
                                            المجموع الجزئي
                                        </span>
                                        <span class="price">
                                            {{ isset($insurance->price) ? number_format($insurance->price,2) : '----' }} ر.س
                                        </span>
                                    </li>
                                    <li>
                                        <span class="text">
                                            ضريبة القيمة المضافة
                                        </span>
                                        <span class="price">
                                            {{ isset($insurance->price) ? number_format($insurance->price * 15 / 100,2) : '----' }} ر.س
                                        </span>
                                    </li>
                                </ul>
                            </div>
                            <div class="footerInfo">
                                <div class="total">
                                    <span class="text">
                                        المجموع الإجمالي
                                    </span>
                                    <span class="price">
                                        {{ isset($insurance->price) ? number_format($insurance->price + $insurance->price * 15 / 100 - ($insurance->price * 50 / 100),2) : '----' }}
                                        <input type="hidden" name="total" value=" {{ isset($insurance->price) ? number_format($insurance->price + $insurance->price * 15 / 100 - ($insurance->price * 50 / 100),2) : '----' }}">
                                    </span>
                                </div>
                                <div class="buy">
                                    <button type="submit" class="buyBtn">الدفع</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

<!-- after form submit overlay -->
<div id="overlay">
    <div class="cv-spinner">
        <div class="spinnerContainer">
            <img src="{{ asset('style_files/frontend/img/logoInsurance.jpeg') }}" alt="">
            <span class="text-black mx-2">جاري التحميل ...</span>
            <span class="spinner"></span>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        jQuery(function($) {
                $(document).ajaxSend(function() {
                    $("#overlay").fadeIn(300);
                });
    
                $('.buyBtn').click(function() {
                    $.ajax({
                        type: 'GET',
                        success: function(data) {
                            console.log(data);
                        }
                    }).done(function() {
                        setTimeout(function() {
                            $("#overlay").fadeOut(300);
                        }, 800);
                    });
                });
            });
    </script> 

@endsection
