{{-- ====================================================================== --}}
{{-- ========================= Start Top Section ========================== --}}
{{-- ====================================================================== --}}
@include('admin.layouts.top')
{{-- ====================================================================== --}}
{{-- ========================== End Top Section =========================== --}}
{{-- ====================================================================== --}}

{{-- ====================================================================== --}}
{{-- ============================= Start Header =========================== --}}
{{-- ====================================================================== --}}
@include('admin.layouts.header')
{{-- ====================================================================== --}}
{{-- ============================= End Header ============================= --}}
{{-- ====================================================================== --}}

{{-- ====================================================================== --}}
{{-- ========================== Start Main Menu =========================== --}}
{{-- ====================================================================== --}}
@include('admin.layouts.menu')
{{-- ====================================================================== --}}
{{-- ============================ End Main Menu =========================== --}}
{{-- ====================================================================== --}}

{{-- ============================================================== --}}
{{-- ===================== Start Page Wrapper ===================== --}}
{{-- ============================================================== --}}
<div class="page-wrapper">
    {{-- ====================================================================== --}}
    {{-- ============================= Start Content ========================== --}}
    {{-- ====================================================================== --}}
    @yield('content')
    {{-- ====================================================================== --}}
    {{-- ============================= End Content ============================ --}}
    {{-- ====================================================================== --}}
</div>
{{-- ============================================================== --}}
{{-- ====================== End Page Wrapper ====================== --}}
{{-- ============================================================== --}}

{{-- ====================================================================== --}}
{{-- ============================= Start Footer =========================== --}}
{{-- ====================================================================== --}}
@include('admin.layouts.footer')
{{-- ====================================================================== --}}
{{-- ============================= End Footer ============================= --}}
{{-- ====================================================================== --}}

{{-- ====================================================================== --}}
{{-- ======================= Start Bottom Section ========================= --}}
{{-- ====================================================================== --}}
@include('admin.layouts.bottom')

{{-- ====================================================================== --}}
{{-- ======================== End Bottom Section ========================== --}}
{{-- ====================================================================== --}}