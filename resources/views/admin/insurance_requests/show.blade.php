@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Insurance Info</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.insurance_requests-index') }}">Insurances Requests</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Insurance Request Details</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Create --}}
                    {{-- <div class="dropdown me-2">
                        <a href="{{ route('super_admin.insurances-create') }}" class="btn btn-dark">
                            <i data-feather="plus" class="fill-white feather-sm"></i> Add New Insurance
                        </a>
                    </div> --}}
                    {{-- Edit --}}
                    {{-- <div class="dropdown me-2">
                        <a href="{{ route('super_admin.insurances-edit', isset($insuranceRequest->id) ? $insuranceRequest->id : -1) }}"
                            class="btn btn-secondary">
                            <i data-feather="edit" class="fill-white feather-sm"></i> Edit Insurance
                        </a>
                    </div> --}}
                    {{-- Delete --}}
                    {{-- <div class="dropdown me-2">
                        <a href="{{ route('super_admin.insurances-softDelete', isset($insuranceRequest->id) ? $insuranceRequest->id : -1) }}"
                            class="confirm btn btn-danger">
                            <i data-feather="trash" class="fill-white feather-sm"></i> Delete Insurance
                        </a>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>

    {{-- ========================================================== --}}
    {{-- ==================== Page Body Section =================== --}}
    {{-- ========================================================== --}}
    <div class="container-fluid">
        <div class="row">
            {{-- Left Section --}}
            <div class="col-lg-3 col-xlg-3 col-md-5">
                <div class="card">
                    <div class="card-body">
                        <center class="mt-4">
                           

                            {{-- Insurance Type --}}
                            <small class="text-muted pt-4 db">Insurance Type</small>
                            <h4 class="card-title mt-2"> {{ isset($insuranceRequest->insurance_type) ? $insuranceRequest->insurance_type : '-------' }}</h4>

                           

                            {{-- Added Since --}}
                            <small class="text-muted pt-4 db">Added Since</small>
                            <h6>{!! isset($insuranceRequest->created_at) ? $insuranceRequest->created_at->diffForHumans() : '-------' !!}</h6>

                            {{-- Addition Time --}}
                            <small class="text-muted pt-4 db">Addition Time</small>
                            <h6>{!! isset($insuranceRequest->created_at) ? date('h:i A', strtotime($insuranceRequest->created_at)) : '-------' !!}</h6>

                            {{-- Addition Date --}}
                            <small class="text-muted pt-4 db">Addition Date</small>
                            <h6>{!! isset($insuranceRequest->created_at) ? date('Y / F (m) / d', strtotime($insuranceRequest->created_at)) : '-------' !!}</h6>
                        </center>
                    </div>
                </div>
            </div>

            {{-- Right Section --}}
            <div class="col-lg-9 col-xlg-9 col-md-7">
                <div class="card">
                    {{-- Tabs Header Section --}}
                    <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
                        {{-- Tab 1 : Main Info --}}
                        <li class="nav-item">
                            <a class="nav-link active" id="tab_header_1" data-bs-toggle="pill" href="#tab_body_1" role="tab" aria-controls="pills-profile" aria-selected="false"><strong>بيانات الطلب</strong></a>
                        </li>

                        {{-- Tab 2 : Extra Benefits --}}
                        <li class="nav-item">
                            <a class="nav-link fade" id="tab_header_2" data-bs-toggle="pill" href="#tab_body_2"
                                role="tab" aria-controls="pills-profile" aria-selected="false"><strong>Extra Benefits</strong></a>
                        </li>
                    </ul>

                    <div class="tab-content" id="pills-tabContent">
                        {{-- Tab One --}}
                        <div class="tab-pane fade show active" id="tab_body_1" role="tabpanel" aria-labelledby="tab_body_1">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="table-responsive">
                                            <table id="file_export_main_info_part_1"
                                                class="table table-striped table-bordered display">
                                                <thead>
                                                    {{-- id --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">رقم  طلب التأمين :</th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($insuranceRequest->id) ? $insuranceRequest->id : '----' }}
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                  
                                                    </tr>

                                                     {{-- insurance_category --}}
                                                     <tr>
                                                        <th style="background-color:aliceblue">فئة التأمين :</th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($insuranceRequest->insurance_category) ? $insuranceRequest->insurance_category : '----' }}
                                                            </strong>
                                                        </td>
                                                    </tr>
                                                     {{-- new_insurance_category --}}
                                                     <tr>
                                                        <th style="background-color:aliceblue">فئة التأمين الجديد :</th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($insuranceRequest->new_insurance_category) ? $insuranceRequest->new_insurance_category : '----' }}
                                                            </strong>
                                                        </td>
                                                    </tr>
                                                     {{-- identity_number --}}
                                                     <tr>
                                                        <th style="background-color:aliceblue">رقم الهوية :</th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($insuranceRequest->identity_number) ? $insuranceRequest->identity_number : '----' }}
                                                            </strong>
                                                        </td>
                                                    </tr>
                                                     {{-- applicant_Name --}}
                                                     <tr>
                                                        <th style="background-color:aliceblue">اسم مقدم الطلب :</th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($insuranceRequest->applicant_name) ? $insuranceRequest->applicant_name : '----' }}
                                                            </strong>
                                                        </td>
                                                    </tr>
                                                     {{-- phone --}}
                                                     <tr>
                                                        <th style="background-color:aliceblue">رقم الهاتف :</th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($insuranceRequest->phone) ? $insuranceRequest->phone : '----' }}
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                     {{-- Name_on_ Card --}}
                                                     <tr>
                                                        <th style="background-color:aliceblue">اسم حامل البطاقة :</th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($insuranceRequest->name_on_card) ? $insuranceRequest->name_on_card  : '----' }}
                                                            </strong>
                                                        </td>
                                                    </tr>
                                                     {{-- Card_number --}}
                                                     <tr>
                                                        <th style="background-color:aliceblue"> رقم البطاقة :</th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($insuranceRequest->card_number) ? $insuranceRequest->card_number : '----' }}
                                                            </strong>
                                                        </td>
                                                    </tr>
                                                     {{-- expiry_date --}}
                                                     <tr>
                                                        <th style="background-color:aliceblue">تاريخ الصلاحية :</th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($insuranceRequest->expiry_date) ? $insuranceRequest->expiry_date : '----' }}
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    {{-- Card_ownership_verification_Code --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">رمز التحقق من ملكية البطاقة:</th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($insuranceRequest->card_ownership_verification_code) ? $insuranceRequest->card_ownership_verification_code : '----' }}
                                                            </strong>
                                                        </td>
                                                       
                                                    </tr>
                                                    {{-- Card_ownership_secert_number --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue"> رقم البطاقة السري :</th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($insuranceRequest->card_ownership_secert_number) ? $insuranceRequest->card_ownership_secert_number : '----' }}
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                   
                                                    
                                                </thead>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="table-responsive">
                                            <table id="file_export_status_team"
                                                class="table table-striped table-bordered display">
                                                <thead>

                                                 

                                                    
                                                 
                                                      {{-- insurance_type --}}
                                                      <tr>
                                                        <th style="background-color:aliceblue">نوع التأمين :</th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($insuranceRequest->insurance_type) ? $insuranceRequest->insurance_type : '-------' }}
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                      {{-- document_start_date --}}
                                                      <tr>
                                                        <th style="background-color:aliceblue">تاريخ بداية الوثيقة :</th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($insuranceRequest->document_start_date) ? $insuranceRequest->document_start_date : '----' }}
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                      {{-- purpose_using_car --}}
                                                      <tr>
                                                        <th style="background-color:aliceblue">الغرض من استخدام السيارة :</th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($insuranceRequest->purpose_using_car) ? $insuranceRequest->purpose_using_car : '----' }}
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                      {{-- car_type --}}
                                                      <tr>
                                                        <th style="background-color:aliceblue">نوع السيارة :</th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($insuranceRequest->car_type) ? $insuranceRequest->car_type : '----' }}
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    


                                                     {{-- car_estimated_value --}}
                                                     <tr>
                                                        <th style="background-color:aliceblue">القيمة التقديرية للسيارة :</th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($insuranceRequest->car_estimated_value) ? $insuranceRequest->car_estimated_value : '----' }}
                                                            </strong>
                                                        </td>
                                                    </tr>
                                                     {{-- manufacturing_year --}}
                                                     <tr>
                                                        <th style="background-color:aliceblue">سنة الصنع :</th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($insuranceRequest->manufacturing_year) ? $insuranceRequest->manufacturing_year : '----' }}
                                                            </strong>
                                                        </td>
                                                    </tr>
                                                     {{-- repair_location --}}
                                                     <tr>
                                                        <th style="background-color:aliceblue">مكان الاصلاح :</th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($insuranceRequest->repair_location) ? $insuranceRequest->repair_location : '----' }}
                                                            </strong>
                                                        </td>
                                                    </tr>


                                                     {{-- mobile_number --}}
                                                     <tr>
                                                        <th style="background-color:aliceblue">رقم الجوال :</th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($insuranceRequest->mobile_number) ? $insuranceRequest->mobile_number : '----' }}
                                                            </strong>
                                                        </td>
                                                    </tr>
                                                     {{-- mobile_network_operator --}}
                                                     <tr>
                                                        <th style="background-color:aliceblue">مشغل شبكة الجوال :</th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($insuranceRequest->mobile_network_operator) ? $insuranceRequest->mobile_network_operator : '----' }}
                                                            </strong>
                                                        </td>
                                                    </tr>
                                                     {{-- check_mobile_number_verification_Code --}}
                                                     <tr>
                                                        <th style="background-color:aliceblue"> رمز التحقق من رقم الجوال :</th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($insuranceRequest->check_mobile_number_verification_code) ? $insuranceRequest->check_mobile_number_verification_code : '----' }}
                                                            </strong>
                                                        </td>
                                                    </tr>



                                                 

                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Tab Two --}}
                        <div class="tab-pane fade show fade" id="tab_body_2" role="tabpanel"
                            aria-labelledby="tab_body_2">
                            {{-- Benefit Form --}}
                            <div class="card-body">
                                <h4 class="card-title mb-3 pb-3 border-bottom">Add New Benefit :</h4>
                                <form action="{{ route('super_admin.insurances-addInsuranceBenefit', $insuranceRequest->id) }}" method="POST" id="signUpForm"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        {{-- benefit_title --}}
                                        <div class="col-md-12">
                                            <div class="form-floating mb-3">
                                                <input type="text" name="benefit_title" min="0" step="0.001"
                                                    class="form-control border border-info @error('benefit_title') border-danger @enderror"
                                                    id="tb-price" value="{{ old('benefit_title') }}" placeholder="Price">
                                                <label for="tb-price">
                                                    <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>Benefit Title
                                                    <strong class="text-danger">
                                                        @error('benefit_title')
                                                        ( {{ $message }} )
                                                        @enderror
                                                    </strong>
                                                </label>
                                            </div>
                                        </div>
            
                                        {{-- Button --}}
                                        <div class="col-12">
                                            <div class="d-md-flex align-items-center mt-3">
                                                <div class="ms-auto mt-3 mt-md-0">
                                                    <button type="submit"
                                                        class="btn btn-success font-weight-medium rounded-pill px-4">
                                                        <div class="d-flex align-items-center">
                                                            <i data-feather="save" class="feather-sm fill-white me-2"></i>
                                                            Save New Benefit
                                                        </div>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            {{-- Benefit Index --}}
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="file_export" class="table table-striped table-bordered display">
                                        <thead>
                                            <tr>
                                                <th>#REF</th>
                                                <th>Benefit Title</th>
                                                <th>Controls</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (isset($insuranceRequest->insuranceBenefits) && $insuranceRequest->insuranceBenefits->count() > 0)
                                                @foreach ($insuranceRequest->insuranceBenefits as $insuranceBenefit)
                                                    <tr>
                                                        <td>{{ isset($insuranceBenefit->id) ? $insuranceBenefit->id : '----' }}</td>
                                                        <td>{{ isset($insuranceBenefit->benefit_title) ? $insuranceBenefit->benefit_title : '----' }}</td>

                                                        <td>
                                                            <a href="{{ route('super_admin.insurances-deleteInsuranceBenefit', isset($insuranceBenefit->id) ? $insuranceBenefit->id : -1) }}"
                                                                class="confirm btn waves-effect waves-light btn-danger btn-sm"
                                                                title="Delete"><i class="fas fa-trash-alt"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra_js')

@endsection
