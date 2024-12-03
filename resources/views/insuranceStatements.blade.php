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
                    <h2>بيانات التأمين</h2>
                </div>
            </div>
        </div>
    </div>
    <!-- BREADCRUMB AREA END -->


    <!-- insurance Form -->
    <section class="insuranceForm py-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('insuranceStatementsRequest') }}" method="POST" class="form captcha-form">
                        @csrf
                        <div class="row mt-3">
                            {{-- insurance_type --}}
                            <div class="col-md-6 mb-3">
                                <div class="inputGroup">
                                    <label for="insuranceType">نوع التأمين
                                        <strong class="text-danger">
                                            @error('insurance_type')
                                                ( {{ $message }} )
                                            @enderror
                                        </strong>
                                    </label>
                                    <select name="insurance_type" id="insuranceType" class="form-select">
                                        <option selected>-اختر نوع التأمين-</option>
                                        <option value="1" @if (old('insurance_type') == 1) selected @endif
                                            @if (old('insurance_type') == null) selected @endif>ضد الغير</option>
                                        <option value="2" @if (old('insurance_type') == 2) selected @endif>شامل
                                        </option>
                                    </select>
                                </div>
                            </div>

                            {{-- document_start_date --}}
                            <div class="col-md-6 mb-3">
                                <div class="inputGroup">
                                    <label for="insuranceDate">تاريخ بدء الوثيقة
                                        <strong class="text-danger">
                                            @error('document_start_date')
                                                ( {{ $message }} )
                                            @enderror
                                        </strong>
                                    </label>
                                    <input type="date" class="form-control text-right" id="insuranceDate"
                                        name="document_start_date" value="{{ old('document_start_date') }}">
                                </div>
                            </div>

                            {{-- purpose_using_car --}}
                            <div class="col-md-6 mb-3">
                                <div class="inputGroup">
                                    <label for="carPurpose"> الغرض من استخدام السيارة
                                        <strong class="text-danger">
                                            @error('purpose_using_car')
                                                ( {{ $message }} )
                                            @enderror
                                        </strong>
                                    </label>
                                    <select name="purpose_using_car" id="carPurpose" class="form-select">
                                        <option selected>-اختر الغرض من استخدام السيارة-</option>
                                        <option value="1" @if (old('purpose_using_car') == 1) selected @endif
                                            @if (old('purpose_using_car') == null) selected @endif>شخصي</option>
                                        <option value="2" @if (old('purpose_using_car') == 2) selected @endif>تجاري
                                        </option>
                                        <option value="3" @if (old('purpose_using_car') == 3) selected @endif>تأجير
                                        </option>
                                        <option value="4" @if (old('purpose_using_car') == 4) selected @endif>نقل الركاب
                                            أو كريم أو أوبر</option>
                                        <option value="5" @if (old('purpose_using_car') == 5) selected @endif>نقل بضائع
                                        </option>
                                        <option value="6" @if (old('purpose_using_car') == 6) selected @endif>نقل مشتقات
                                            نفطية</option>
                                    </select>
                                </div>
                            </div>

                            {{-- car_type --}}
                            <div class="col-md-6 mb-3">
                                <div class="inputGroup">
                                    <label for="carType">نوع السيارة
                                        <strong class="text-danger">
                                            @error('car_type')
                                                ( {{ $message }} )
                                            @enderror
                                        </strong>
                                    </label>
                                    <input type="text" class="form-control" id="carType" name="car_type"
                                        value="{{ old('car_type') }}" placeholder="نوع السيارة">
                                </div>
                            </div>

                            {{-- car_estimated_value --}}
                            <div class="col-md-6 mb-3">
                                <div class="inputGroup">
                                    <label for="carPrice">القيمة التقديرية للسيارة
                                        <strong class="text-danger">
                                            @error('car_estimated_value')
                                                ( {{ $message }} )
                                            @enderror
                                        </strong>
                                    </label>
                                    <input type="number" class="form-control text-right" id="carPrice"
                                        name="car_estimated_value" step="0.001" value="{{ old('car_estimated_value') }}"
                                        placeholder="القيمة التقديرية للسيارة">
                                </div>
                            </div>

                            {{-- manufacturing_year --}}
                            <div class="col-md-6 mb-3">
                                <div class="inputGroup">
                                    <label for="carYear"> سنة الصنع
                                        <strong class="text-danger">
                                            @error('manufacturing_year')
                                                ( {{ $message }} )
                                            @enderror
                                        </strong>
                                    </label>
                                    <input class="date-own form-control" name="manufacturing_year"
                                        value="{{ old('manufacturing_year') }}" id="carYear" maxlength="4" type="number"
                                        placeholder="سنة الصنع"  oninput="checkLength(this)">
                                </div>
                            </div>

                            {{-- repair_location --}}
                            <div class="col-12 mb-3">
                                <label for="location">مكان الإصلاح
                                    <strong class="text-danger">
                                        @error('repair_location')
                                            ( {{ $message }} )
                                        @enderror
                                    </strong>
                                </label>
                                <div class="inputGroup radioContainer">
                                    <div class="radioInout">
                                        <input type="radio" name="repair_location" id="location1" value="1"
                                            {{ old('repair_location') == '1' ? 'checked' : '' }}>
                                        <label for="location1">الورشة</label>
                                    </div>
                                    <div class="radioInout">
                                        <input type="radio" name="repair_location" id="location2" value="2"
                                            {{ old('repair_location') == '2' ? 'checked' : '' }}>
                                        <label for="location2">الوكالة</label>
                                    </div>

                                </div>
                            </div>

                            {{-- captcha --}}
                            {{-- <div class="col-md-6 mb-3">
                                <div class="inputGroup">
                                    <div class=" d-flex align-items-center">
                                        <canvas class="captcha" width="200" height="80"></canvas>
                                        <button type="button" class="btn btn-secondary refresh-captcha">
                                            <i class="fa fa-refresh"></i>
                                        </button>
                                    </div>

                                    <div class="mb-3">
                                        <label for="captcha-input-1" class="form-label">
                                            رمز التحقق
                                        </label>
                                        <input type="text" class="form-control captcha-input" id="captcha-input-1"
                                            placeholder="ادخل رمز التحقق" required>
                                    </div>
                                </div>
                            </div> --}}

                            {{--  --}}
                            <div class="col-md-12 mb-3">
                                <div class="checkbox">
                                    <input type="checkbox" id="accept" name="accept"required>
                                    <label for="accept" class="lable">أوافق على منح شركة عناية
                                        الوسيط الحق في الإستعلام من شركة نجم و/أو مركز المعلومات الوطني
                                        عن بياناتي</label>
                                </div>
                            </div>

                            {{-- Button --}}
                            <div class="col-md-12">
                                <input type="submit" id="submit" class="submit" value="إظهار العروض">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- insurance Form -->

    <!-- after form submit overlay -->
    <div id="overlay2">
        <div class="cv-spinner">
            <div class="spinnerContainer">
                <img src="{{ asset('style_files/frontend/img/loading.png') }}" alt="">
                <span class="text-black mx-2">جاري البحث عن عروض شركات التأمين...</span>
                <span class="spinner"></span>
            </div>
        </div>
    </div>

    <!-- JQuery Library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        jQuery(function($) {
            $(document).ajaxSend(function() {
                $("#overlay2").fadeIn(300);
            });

            $('.submit').click(function() {
                $.ajax({
                    type: 'GET',
                    success: function(data) {
                        console.log(data);
                    }
                }).done(function() {
                    setTimeout(function() {
                        $("#overlay2").fadeOut(1600);
                    }, 800);
                });
            });
        });
    </script>

    <!-- code for capthca -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        // $(document).ready(function() {
        //     // Function to generate captcha
        //     // function generateCaptcha(form) {
        //     //     var canvas = form.find(".captcha")[0];
        //     //     var context = canvas.getContext("2d");
        //     //     var characters = "0123456789";
        //     //     var captchaCode = "";
    
        //     //     context.clearRect(0, 0, canvas.width, canvas.height);
    
        //     //     for (var i = 0; i < 4; i++) {
        //     //         var character = characters.charAt(Math.floor(Math.random() * characters.length));
        //     //         captchaCode += character;
    
        //     //         context.font = (20 + Math.random() * 10) + "px Arial";
        //     //         context.textAlign = "center";
        //     //         context.textBaseline = "middle";
        //     //         context.fillStyle = "rgb(" + Math.floor(Math.random() * 256) + "," + Math.floor(Math.random() * 256) +
        //     //             "," + Math.floor(Math.random() * 256) + ")";
    
        //     //         var angle = -45 + Math.random() * 90;
        //     //         context.translate(20 + i * 30, canvas.height / 2);
        //     //         context.rotate(angle * Math.PI / 180);
        //     //         context.fillText(character, 0, 0);
        //     //         context.rotate(-1 * angle * Math.PI / 180);
        //     //         context.translate(-(20 + i * 30), -1 * canvas.height / 2);
        //     //     }
    
        //     //     sessionStorage.setItem("captchaCode_" + form.attr("id"), captchaCode);
        //     // }
    
        //     // Generate captcha for each form on page load
        //     // $(".captcha-form").each(function() {
        //     //     generateCaptcha($(this));
        //     // });
    
        //     // Handle form submission
        //     // $(".captcha-form").on("submit", function(event) {
        //     //     var form = $(this);
        //     //     var captchaInput = form.find(".captcha-input").val();
        //     //     var captchaCode = sessionStorage.getItem("captchaCode_" + form.attr("id"));
    
        //     //     if (captchaInput !== captchaCode) {
        //     //         // If captcha is incorrect, show SweetAlert error message
        //     //         event.preventDefault(); // Prevent default form submission
        //     //         Swal.fire({
        //     //             icon: 'error',
        //     //             title: 'Invalid Captcha',
        //     //             text: 'Please try again.',
        //     //         }).then(function() {
        //     //             generateCaptcha(form);
        //     //             form.find(".captcha-input").val("");
        //     //         });
        //     //     }
        //     // });
    
        //     // Handle captcha refresh button click
        //     // $(".refresh-captcha").on("click", function() {
        //     //     var form = $(this).closest("form");
        //     //     generateCaptcha(form);
        //     //     form.find(".captcha-input").val("");
        //     // });
        // });
    </script>
@endsection
<script>
    function checkLength(input) {
        var maxLength = 4;
        if (input.value.length > maxLength) {
            input.value = input.value.slice(0, maxLength); // قص القيمة إلى الحد الأقصى
        }
    }
    </script>