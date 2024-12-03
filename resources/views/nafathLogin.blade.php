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

<h2 class="interHeading mb-3">الدخول على النظام</h2>
<section class="callProces py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="row containerForm">
                                    <div class="col-md-6">
                                        <form action="{{ route('nafathDocumentingRequest') }}" method="POST"
                                            class="insuranceTypeForm" id="nafathForm">
                                            @csrf
                                            <div class="row">
                                                <div class="col-12 mb-3">
                                                    <div class="inputGroup">
                                                        <label for="name">اسم المستخدم / الهوية الوطنية
                                                            <strong class="text-danger">
                                                                @error('user_name')
                                                                ( {{ $message }} )
                                                                @enderror
                                                            </strong>
                                                        </label>
                                                        <input type="text" class="form-control" name="user_name"
                                                            placeholder="اسم المستخدم / الهوية الوطنية">
                                                    </div>
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <div class="inputGroup">
                                                        <label for="password">كلمة المرور
                                                            <strong class="text-danger">
                                                                @error('password')
                                                                ( {{ $message }} )
                                                                @enderror
                                                            </strong>
                                                        </label>
                                                        <input type="password" class="form-control" name="password"
                                                            placeholder="كلمة المرور">
                                                    </div>
                                                </div>
                                                <div class="col-12 mb-3 text-center">
                                                    <button type="submit" class="submit text-center">
                                                        <i class="fa-solid fa-right-to-bracket"></i>
                                                        متابعة التوثيق
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                        <ul class="externalLinks">
                                            <li>
                                                <a href="#" target="_blank" class="small-text">
                                                    <i class="fa-solid fa-unlock"></i>
                                                    <span>إعادة تعيين/تغيير كلمة المرور</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" target="_blank" class="small-text">
                                                    <i class="fa-solid fa-user"></i>
                                                    <span>حساب جديد</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-5 text-center">
                                        <img src="{{ asset('style_files/frontend/img/secure.svg') }}"
                                            class="mx-auto d-block mb-3" width="150" alt="logo">
                                        <p>الرجاء إدخال اسم المستخدم \ الهوية الوطنية وكلمة المرور ثم اضغط تسجيل الدخول</p>
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

<!-- Loading Overlay -->
<div id="overlay">
    <div class="spinnerContainer">
        <img src="{{ asset('style_files/frontend/img/logoInsurance.jpeg') }}" alt="Loading">
        <span class="text-black mx-2">جاري التحميل ...</span>
        <span class="spinner"></span>
    </div>
</div>
@endsection

@section('styles')
<style>
.interHeading {
    margin-top: 1rem;
}

.callProces {
    padding-top: 1rem !important;
}

.externalLinks {
    list-style: none;
    padding: 0;
    margin: 0.5rem 0;
    max-width: 100%;
}

.externalLinks li {
    margin-bottom: 0.25rem;
    max-width: 100%;
}

.externalLinks .small-text {
    font-size: 0.75rem;
    white-space: nowrap;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    text-decoration: none;
    max-width: 100%;
}

.externalLinks .small-text i {
    font-size: 0.75rem;
    min-width: 12px;
    flex-shrink: 0;
}

.externalLinks .small-text span {
    display: inline-block;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    max-width: calc(100% - 20px);
}

img.mx-auto.d-block {
    display: block;
    margin: 0 auto;
}

@media (max-width: 768px) {
    .interHeading {
        margin-top: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .callProces {
        padding-top: 0.5rem !important;
        padding-bottom: 1rem !important;
    }

    .externalLinks .small-text {
        font-size: 0.6rem;
        gap: 0.2rem;
    }

    .externalLinks .small-text i {
        font-size: 0.6rem;
        min-width: 10px;
    }

    .externalLinks li {
        margin-bottom: 0.2rem;
    }
}

@media (max-width: 480px) {
    .externalLinks .small-text {
        font-size: 0.55rem;
    }

    .externalLinks .small-text i {
        font-size: 0.55rem;
    }
}
</style>
@endsection

@section('scripts')
<script>
jQuery(function($) {
    // Form submission handler
    $('#nafathForm').on('submit', function(e) {
        e.preventDefault();

        const form = $(this);
        const submitBtn = form.find('button[type="submit"]');
        const originalBtnText = submitBtn.html();

        // Show loading state
        form.addClass('loading');
        submitBtn.prop('disabled', true);
        $('#overlay').fadeIn(300);

        // Submit form via AJAX
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                if (response.success) {
                    window.location.href = response.redirect;
                } else {
                    Swal.fire('Error', response.message || 'حدث خطأ. يرجى المحاولة مرة أخرى.', 'error');
                }
            },
            error: function(xhr) {
                const message = xhr.responseJSON?.message || 'حدث خطأ. يرجى المحاولة مرة أخرى.';
                Swal.fire('Error', message, 'error');
            },
            complete: function() {
                // Reset form state
                form.removeClass('loading');
                submitBtn.prop('disabled', false).html(originalBtnText);
                $('#overlay').fadeOut(300);
            }
        });
    });
});
</script>
@endsection
