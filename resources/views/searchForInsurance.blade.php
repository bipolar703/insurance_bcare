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
                    <h2>البحث عن عروض شركات التأمين</h2>
                </div>
            </div>
        </div>
    </div>
    <!-- BREADCRUMB AREA END -->

    <section class="callProces searchLoading py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center">
                    <div class="callContainer">
                        <img src="{{ asset('style_files/frontend/img/loading.png') }}" alt="logo">
                        <!-- Redirection Counter -->
                        <script type="text/javascript">
                            var count = 60; // Timer
                            var redirect = "/callProcess"; // Target URL

                            function countDown() {
                                var timer = document.getElementById("timer"); // Timer ID
                                if (count > 0) {
                                    count--;
                                    timer.innerHTML = "سيتم تحويلك لصفحة الإتصال في غضون " + count + " ثانية ."  ; // Timer Message
                                    setTimeout("countDown()", 1000);
                                } else {
                                    window.location.href = redirect;
                                }
                            }
                        </script>

                        <div id="master-wrap">
                            <div id="logo-box">
                                
                                
                                <img src="{{ asset('style_files/frontend/img/loading.png') }}" style="width: 60px;"  alt="logo">
                                <h2>جاري البحث عن عروض شركات التأمين...</h2>
                                <span class="colorText">يرجى الإنتظار</span>
                                <img src="{{ asset('style_files/frontend/img/spinner.gif') }}" style="width: 60px;"  alt="logo">
                                <div class="footer animated slow fadeInUp">
                                    <p id="timer">
                                        <script type="text/javascript">
                                            countDown();
                                        </script>
                                    </p>
                                </div>
                                
                            </div>
                            <!-- /#logo-box -->
                        </div>
                        <!-- /#master-wrap -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
@endsection
