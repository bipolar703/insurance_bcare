@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <h2 class="page-title">Assets</h2>
            <div class="col-md-5 align-self-center">
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.variables_assets-index') }}">Assets</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Asset Details</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Create --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.variables_assets-create') }}" class="btn btn-dark">
                            <i data-feather="plus" class="fill-white feather-sm"></i> Add New Asset
                        </a>
                    </div>
                    {{-- Edit --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.variables_assets-edit', isset($variableAsset->id) ? $variableAsset->id : -1) }}"
                            class="btn btn-secondary">
                            <i data-feather="edit" class="fill-white feather-sm"></i> Edit Asset
                        </a>
                    </div>
                    {{-- Delete --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.variables_assets-softDelete', isset($variableAsset->id) ? $variableAsset->id : -1) }}"
                            class="confirm btn btn-danger">
                            <i data-feather="trash" class="fill-white feather-sm"></i> Delete Asset
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
            {{-- Right Section --}}
            <div class="col-lg-12">
                <div class="card">
                    {{-- Tabs Header Section --}}
                    <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
                        {{-- Tab 1 : Main Info --}}
                        <li class="nav-item">
                            <a class="nav-link active" id="tab_header_1" data-bs-toggle="pill" href="#tab_body_1"
                                role="tab" aria-controls="pills-profile" aria-selected="false"><strong>Main Info</strong></a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        {{-- Tab One --}}
                        <div class="tab-pane fade show active" id="tab_body_1" role="tabpanel" aria-labelledby="tab_body_1">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="table-responsive">
                                            <table id="file_export_main_info_part_1" class="table table-striped table-bordered display">
                                                <thead>
                                                    {{-- id --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">REF :</th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($variableAsset->id) ? $variableAsset->id : '----' }}
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    {{-- status --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Status :</th>
                                                        <td>
                                                            <strong>
                                                                @if (isset($variableAsset->status) && $variableAsset->status == 'Active')
                                                                    <span
                                                                        style="color: green;"><strong>{{ isset($variableAsset->status) ? $variableAsset->status : '----' }}</strong></span>
                                                                @else
                                                                    <span style="color: red">
                                                                        <strong>
                                                                            {{ isset($variableAsset->status) ? $variableAsset->status : '----' }}
                                                                        </strong>
                                                                    </span>
                                                                @endif
                                                            </strong>
                                                        </td>
                                                    </tr>


                                                    {{-- created_at --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue"> Added Since:</th>
                                                        <td>
                                                            <strong>{!! isset($variableAsset->created_at) ? $variableAsset->created_at->diffForHumans() : '-------' !!}</strong>
                                                        </td>
                                                    </tr>

                                                    {{-- created_at --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Addition Time:</th>
                                                        <td>
                                                            <strong>{!! isset($variableAsset->created_at) ? date('h:i A', strtotime($variableAsset->created_at)) : '-------' !!}</strong>
                                                        </td>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="col-md-7">
                                        <div class="table-responsive">
                                            <table id="file_export_status_team" class="table table-striped table-bordered display">
                                                <thead>
                                                    {{-- title --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Title :
                                                        </th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($variableAsset->title) ? $variableAsset->title : '-------' }}
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    {{-- quantity --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Quantity:</th>
                                                        <td>
                                                            <strong>
                                                                {{ isset($variableAsset->quantity) ? $variableAsset->quantity : '-------' }}
                                                            </strong>
                                                        </td>
                                                    </tr>

                                                    {{-- created_at --}}
                                                    <tr>
                                                        <th style="background-color:aliceblue">Addition Date:</th>
                                                        <td>
                                                            <strong>
                                                                {!! isset($variableAsset->created_at) ? date('d/M/Y', strtotime($variableAsset->created_at)) : '-------' !!}
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
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('extra_js')

        <script>
            $(document).ready(function() {
                // Function to initialize DataTable with buttons
                function initializeDataTable(tableId, classes) {
                    if (!$.fn.DataTable.isDataTable(tableId)) {
                        $(tableId).DataTable({
                            dom: 'Bfrtip',
                            buttons: [{
                                    extend: 'copy',
                                    className: classes
                                },
                                {
                                    extend: 'csv',
                                    className: classes
                                },
                                {
                                    extend: 'excel',
                                    className: classes
                                },
                                {
                                    extend: 'pdf',
                                    className: classes
                                },
                                {
                                    extend: 'print',
                                    className: classes
                                }
                            ]
                        });
                    }
                }

                // Initialize DataTable for Projects tab on document load
                initializeDataTable('#file_export', 'btn btn-primary'); // Define button classes for Tab 2

                // Event listener for when the Invoices tab is shown
                $('a[data-bs-toggle="pill"]').on('shown.bs.tab', function(e) {
                    var targetTab = $(e.target).attr('href'); // Get the target tab href

                    // Check if the target tab is the Invoices tab
                    if (targetTab === '#tab_body_3') {
                        initializeDataTable('#file_export_invoices',
                            'btn btn-secondary'); // Define button classes for Tab 3
                    }
                });
            });
        </script>
    @endsection
