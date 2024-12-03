@extends('admin.layouts.app')

@section('content')
    {{-- ============================================================== --}}
    {{-- Bread crumb and right sidebar toggle --}}
    {{-- ============================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Dashboard</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    <div class="btn btn-secondary">
                        {{ date('F j, Y') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- ============================================================== --}}
    {{-- End Bread crumb and right sidebar toggle --}}
    {{-- ============================================================== --}}

    {{-- ============================================================== --}}
    {{-- Container fluid --}}
    {{-- ============================================================== --}}
    <div class="container-fluid">
        {{-- ============================================================== --}}
        {{-- Counters Section --}}
        {{-- ============================================================== --}}
        <div class="row">
            {{-- Insurances --}}
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"><a href="{{ route('super_admin.insurances-index') }}"
                                class="fw-light mb-0 text-danger">Insurances</a></h4>
                        <div class="text-end">
                            <h2 class="fw-light mb-0 text-danger">
                                <a href="{{ route('super_admin.insurances-index') }}">
                                    <i class="ti-arrow-up text-danger"></i>
                                    <span style="color: red"> {!! isset($insurances) && $insurances->count() > 0 ? $insurances->count() : 0 !!}</span>
                                </a>
                            </h2>
                            <a href="{{ route('super_admin.insurances-index') }}">
                                <span class="text-muted">Insurances</span>
                            </a>
                        </div>
                        <div class="progress mt-3">
                            <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: 50%;"
                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Insurance Requests --}}
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"><a href="{{ route('super_admin.insurance_requests-index') }}"
                                class="fw-light mb-0 text-success">Insurance Requests</a></h4>
                        <div class="text-end">
                            <h2 class="fw-light mb-0 text-success">
                                <a href="{{ route('super_admin.insurance_requests-index') }}">
                                    <i class="ti-arrow-up text-success"></i>
                                    <span style="color:green ">
                                        {!! isset($insuranceRequests) && $insuranceRequests->count() > 0 ? $insuranceRequests->count() : 0 !!}
                                    </span>
                                </a>
                            </h2>
                            <a href="{{ route('super_admin.insurance_requests-index') }}">
                                <span class="text-muted">Insurance Requests</span>
                            </a>
                        </div>
                        <div class="progress mt-3">
                            <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 60%;"
                                aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra_js')
    <script>
        $(document).ready(function() {
            $('#toggleTasksTab').on('click', function(e) {
                e.preventDefault();
                $('#tab_body_1').toggle();
            });
        });
    </script>
@endsection
