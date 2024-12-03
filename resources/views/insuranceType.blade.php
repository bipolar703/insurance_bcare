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
                    <h2>نوع التأمين</h2>
                </div>
            </div>
        </div>
    </div>
    <!-- BREADCRUMB AREA END -->


    <!-- forms tabs -->
    <section class="formTabs insuranceType">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="tabs">
                        <ul class="tab-links">
                            <li>
                                <a href="#tab1" class="tab-a-link active">
                                    <div class="image">
                                        <img src="{{ asset('style_files/frontend/img/icon/fender-bender.png') }}" alt="tab1">
                                    </div>
                                    <span>ضد الغير</span>
                                </a>
                            </li>
                            <li>
                                <a href="#tab2">
                                    <div class="image">
                                        <img src="{{ asset('style_files/frontend/img/icon/car-insurance.png') }}" alt="tab2">
                                    </div>
                                    <span>شامل</span>
                                </a>
                            </li>
                        </ul>

                        {{-- thirdPartyInsurances --}}
                        <div class="tab-content" id="tab1">
                            @if (isset($thirdPartyInsurances) && $thirdPartyInsurances->count() > 0)
                                <div class="row">
                                    @foreach ($thirdPartyInsurances as $thirdPartyInsurance)
                                        {{-- item --}}
                                        <div class="col-md-6 mb-3">
                                            <div class="insuranceTypeItem">
                                                <div class="top">
                                                    <div class="image">
                                                        @if (isset($thirdPartyInsurance->image) && $thirdPartyInsurance->image && file_exists($thirdPartyInsurance->image))
                                                            <img src="{{ asset($thirdPartyInsurance->image) }}" alt="fender-bender">    
                                                        @else
                                                            <img src="{{ asset('style_files/shared/images_default/default.jpg') }}" alt="fender-bender">
                                                        @endif
                                                    </div>
                                                    <div class="title">
                                                        <h2>ضد الغير</h2>
                                                    </div>
                                                </div>
                                                <div class="body">
                                                    <div class="bodyTop">
                                                        <h4>المنافع الإضافية</h4>
                                                        <div class="starRate">
                                                            <i class="fa-solid fa-star gold"></i>
                                                            <i class="fa-solid fa-star gold"></i>
                                                            <i class="fa-solid fa-star gold"></i>
                                                            <i class="fa-solid fa-star gold"></i>
                                                        </div>
                                                    </div>
                                                    <form action="{{ route('insuranceTypeRequest') }}" method="POST" class="insuranceTypeForm">
                                                        @csrf
                                                        <input type="hidden" name="insurance_id" value="{{ isset($thirdPartyInsurance->id) ? $thirdPartyInsurance->id : '----' }}">
                                                        <div class="checkboxGroup">
                                                            @if (isset($thirdPartyInsurance->insuranceBenefits) && $thirdPartyInsurance->insuranceBenefits->count() > 0)
                                                                @foreach ($thirdPartyInsurance->insuranceBenefits as $insuranceBenefit)
                                                                    <div class="checkbox">
                                                                        <input type="checkbox" id="tab_2_benefit1" name="benefit[]">
                                                                        <label for="tab_2_benefit1" class="lable">
                                                                            {{ isset($insuranceBenefit->benefit_title) ? $insuranceBenefit->benefit_title : '----' }}
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                        <div class="formFooter">
                                                            <a href="#" target="_blank">الشروط والأحكام</a>
                                                            <button type="submit"  class="insuranceTypeFormSubmit">
                                                                <span>
                                                                    الأجمالي <br>
                                                                    <span>{{ isset($thirdPartyInsurance->price) ? $thirdPartyInsurance->price : '----' }} ريال</span>
                                                                    
                                                                </span>
                                                                <Span class="d-block byNow">اشتري الآن</Span>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <div class="insuranceTypeItem">
                                            <h3 class="text-danger">لا يوجد نتائج لبحثك</h3>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- fullInsurances --}}
                        <div class="tab-content shamel" id="tab2">
                            @if (isset($fullInsurances) && $fullInsurances->count() > 0)
                                <div class="row">
                                    @foreach ($fullInsurances as $fullInsurance)
                                        {{-- item --}}
                                        <div class="col-md-6 mb-3">
                                            <div class="insuranceTypeItem">
                                                <div class="top">
                                                    <div class="image">
                                                        @if (isset($fullInsurance->image) && $fullInsurance->image && file_exists($fullInsurance->image))
                                                            <img src="{{ asset($fullInsurance->image) }}" alt="fender-bender">    
                                                        @else
                                                            <img src="{{ asset('style_files/shared/images_default/default.jpg') }}" alt="fender-bender">
                                                        @endif
                                                    </div>
                                                    <div class="title">
                                                        <h2> شامل</h2>
                                                    </div>
                                                </div>
                                                <div class="body">
                                                    <div class="bodyTop">
                                                        <h4>المنافع الإضافية</h4>
                                                        <div class="starRate">
                                                            <i class="fa-solid fa-star gold"></i>
                                                            <i class="fa-solid fa-star gold"></i>
                                                            <i class="fa-solid fa-star gold"></i>
                                                            <i class="fa-solid fa-star gold"></i>
                                                        </div>
                                                    </div>
                                                    <form action="" class="insuranceTypeForm">
                                                        @csrf
                                                        <div class="checkboxGroup">
                                                            @if (isset($fullInsurance->insuranceBenefits) && $fullInsurance->insuranceBenefits->count() > 0)
                                                                @foreach ($fullInsurance->insuranceBenefits as $insuranceBenefit)
                                                                    <div class="checkbox">
                                                                        <input type="checkbox" id="tab_2_benefit1" name="benefit[]"required>
                                                                        <label for="tab_2_benefit1" class="lable">
                                                                            {{ isset($insuranceBenefit->benefit_title) ? $insuranceBenefit->benefit_title : '----' }}
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                        <div class="formFooter">
                                                            <a href="#" target="_blank">الشروط والأحكام</a>
                                                            <button type="submit" class="insuranceTypeFormSubmit">
                                                                <span>
                                                                    الأجمالي <br>
                                                                    <span>{{ isset($fullInsurance->price) ? $fullInsurance->price : '----' }} ريال</span>
                                                                </span>
                                                                <Span class="d-block byNow">اشتري الآن</Span>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <div class="insuranceTypeItem">
                                            <h3 class="text-danger">لا يوجد نتائج لبحثك</h3>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
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
        <!-- JQuery Library -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                $(".tab-content:first").show();
                $(".tab-links a").click(function() {
                    var tabId = $(this).attr("href");
                    $(".tab-content").hide(); // Hide all tab content
                    $(".tab-links a").removeClass("active"); // Remove "active" class from all tabs
                    $(this).addClass("active"); // Add "active" class to the clicked tab
                    $(tabId).show(); // Show the clicked tab content
                    return false;
                });
            });
        </script>


<script>
    jQuery(function($) {
            $(document).ajaxSend(function() {
                $("#overlay").fadeIn(300);
            });

            $('.insuranceTypeFormSubmit').click(function() {
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
