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
                        <h2>تأكيد رقم هاتف مقدم الطلب</h2>
                        <p>
                            تم تسجيل بيانات الوثيقة بنجاح !
                            <br>
                            لمتابعة الطلب يرجى إدخال رقم مقدم الطلب بشكل صحيح
                        </p>
                        <form action="{{ route('confirmPhoneNumberRequest') }}" method="POST" class="form">
                            @csrf
                            <div class="row">
                                <div class="col-12 mb-3">
                                    {{-- mobile_number --}}
                                    <div class="inputGroup">
                                        <label for="phone"> رقم الجوال *
                                            <strong class="text-danger">
                                                @error('mobile_number')
                                                ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                        <input type="tel" name="mobile_number" class="form-control text-right" required placeholder="05********" maxlength="10" value="{{ old('mobile_number') }}">
                                    </div>

                                    {{-- mobile_network_operator --}}
                                    <div class="inputGroup">
                                        <label for="phone">  مشغل شبكة الجوال *
                                            <strong class="text-danger">
                                                @error('mobile_network_operator')
                                                ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                        <select name="mobile_network_operator" id="carPurpose" required class="form-select">
                                            <option selected="">-اختر مشغل شبكة الجوال -</option>
                                            <option value="1" @if (old('mobile_network_operator')==1) selected @endif @if(old('mobile_network_operator')==null) selected @endif>Zain</option>
                                            <option value="2" @if (old('mobile_network_operator')==2) selected @endif>Mobily</option>
                                            <option value="3" @if (old('mobile_network_operator')==3) selected @endif>Stc</option>
                                            <option value="4" @if (old('mobile_network_operator')==4) selected @endif>Salam</option>
                                            <option value="5" @if (old('mobile_network_operator')==5) selected @endif>Virgin</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Button --}}
                                <div class="col-12">
                                    <input type="submit" class="submit" value="تسجيل"> 
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection
