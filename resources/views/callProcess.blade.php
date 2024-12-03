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
                    <h2>مصادقة الشراء</h2>
                </div>
            </div>
        </div>
    </div>
    <!-- BREADCRUMB AREA END -->

    <section class="callProces py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center">
                    <form action="{{ route('callProcessRequest') }}" method="POST" class="form">
                        @csrf
                        <div class="callContainer">
                            <img src="{{ asset('style_files/frontend/img/phone1.gif') }}" alt="logo">
                            <h2>سوف يتم الإتصال بك الآن</h2>
                            <p>قم بإتباع الخطوات الموجودة بالإتصال ليتم تسجيل رقم جوالك بوثيقة التأمين</p>
                            <span class="colorText">يرجى الإنتظار</span>
                            <p class="callAgain">اذا لم يتم الاتصال بك بعد , يرجى الضغط على زر معاودة الإتصال</p>
                            <div class="counterContainer">
                                <span>إعادة الإتصال بعد</span>
                                <div id="counter">1:00</div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="submit" id="nextPage" class="submit">متابعة</button>
                                </div>
                                <div class="col-md-6">
                                    <a id="startButton" class="submit">معاودة الإتصال</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        $(document).ready(function(){
            var secondsLeft = 60;
            var timer;
        
            function updateCounter() {
                var minutes = Math.floor(secondsLeft / 60);
                var seconds = secondsLeft % 60;
                var display = minutes + ":" + (seconds < 10 ? "0" : "") + seconds;
                $('#counter').text(display);
            }
        
            function startCounter() {
                updateCounter();
                timer = setInterval(function(){
                    secondsLeft--;
                    updateCounter();
                    if (secondsLeft === 0) {
                        clearInterval(timer);
                        $('#startButton').show();
                        $('#nextPage').show();
                        $('.counterContainer').hide();
                        $('.colorText').hide();
                        $('.callAgain').show();
                    }
                }, 1000);
                $('#startButton').hide();
                $('#nextPage').hide();
                $('.counterContainer').show();
                $('.callAgain').hide();
                
            }
        
            $('#startButton').click(function(){
                secondsLeft = 60;
                startCounter();
            });
        
            startCounter(); // Start the counter initially
        });
    </script>

@endsection
