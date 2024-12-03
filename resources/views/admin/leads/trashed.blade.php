@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">All Archived Leads</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">

                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.leads-index') }}">All Leads</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Archives</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Create --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.leads-create') }}" class="btn btn-dark">
                            <i data-feather="plus" class="fill-white feather-sm"></i> Add New Lead
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
                    <div class="border-bottom title-part-padding">
                        <h4 class="card-title mb-0">All Archived Leads</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="file_export" class="table table-striped table-bordered display">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        <th>Date/Time</th>
                                        <th>Control</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($leads as $lead)
                                        <tr>

                                            <td>{{ isset($lead->title) ? $lead->title : '----' }}</td>
                                            <td>{{ isset($lead->email) ? $lead->email : '----' }}</td>
                                            <td> {{ isset($lead->phone) && isset($lead->country_phone_id) ? '(+'. $lead->countryPhoneKey->phone_code.') '.$lead->phone : '----' }}</td>
                                            <td>{{ isset($lead->status) ? $lead->status : '----' }}</td>
                                            <td>{!! isset($lead->created_at)
                                                ? '<strong>Date : </strong>' .
                                                    date('Y -m-d', strtotime($lead->created_at)) .
                                                    '<br><strong>Time : </strong>' .
                                                    date('h:i A', strtotime($lead->created_at)) .
                                                    '<br><strong>Since : </strong> ' .
                                                    $lead->created_at->diffForHumans()
                                                : "<span style='color:blue;'>----------</span>" !!}
                                            </td>

                                            <td>
                                                <div class="button-group">
                                                    <a href="{{ route('super_admin.leads-softDeleteRestore', [isset($lead->id) ? $lead->id : -1]) }}"
                                                        class="unarchive btn waves-effect waves-light btn-success btn-sm"
                                                        title="Restore this Record"><i class="mdi mdi-redo-variant"></i></a>
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


@endsection
