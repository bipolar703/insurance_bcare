@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">All Support Tickets</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">All Support Tickets</li>
                        </ol>
                    </nav>
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
                        <h4 class="card-title mb-0">All Support Tickets</h4>
                    </div>
                    <div class="card-body">
                        {{-- <h6 class="card-subtitle mb-3">Exporting data from a table can often be a key part of a
                            complex application. The Buttons extension for DataTables provides three plug-ins
                            that provide overlapping functionality for data export. You can refer full
                            documentation from here <a href="https://datatables.net/">Datatables</a></h6> --}}
                        <div class="table-responsive">
                            <table id="file_export" class="table table-striped table-bordered display">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Error Description</th>
                                        <th>Function Name</th>
                                        <th>Date/Time</th>
                                        <th>Control</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($rows) && $rows->count() > 0)
                                        @foreach ($rows as $row)
                                            <tr>
                                                <td>{{ isset($row->id) ? $row->id : '----' }}</td>
                                                <td>{{ isset($row->error_description) ? $row->error_description : '----------' }}</td>
                                                <td>{{ isset($row->function_name) ? $row->function_name : '----------' }}</a></td>

                                                <td>{!! isset($row->created_at) ? '<strong>Date : </strong>' . date('Y -m-d', strtotime($row->created_at)) . '<br><strong>Time : </strong>' . date('h:i A', strtotime($row->created_at)) . '<br><strong>Since : </strong> ' . $row->created_at->diffForHumans() : "<span style='color:blue;'>----------</span>" !!}</td>
                                                <td>
                                                    <div class="button-group">

                                                        <a href="{{ route('super_admin.support_tickets-destroy', isset($row->id) ? $row->id : -1) }}" class="confirm btn waves-effect waves-light btn-danger btn-sm" title="Delete"><i class="fas fa-trash-alt"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Error Description</th>
                                        <th>Function Name</th>
                                        <th>Date/Time</th>
                                        <th>Control</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
