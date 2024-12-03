@extends('admin.layouts.app')

@section('content')
{{-- =========================================================== --}}
{{-- =================== Page Header Section =================== --}}
{{-- =========================================================== --}}
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-md-5 align-self-center">
            <h3 class="page-title">Departments Types</h3>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a
                                href="{{ route('super_admin.departments_types-index') }}">Departments Types</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Archives</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
            <div class="d-flex">
                {{-- Create --}}
                <div class="dropdown me-2">
                    <a href="{{ route('super_admin.departments_types-create') }}" class="btn btn-dark">
                        <i data-feather="plus" class="fill-white feather-sm"></i> Add New Department Type
                    </a>
                </div>
                @if (isset($expensesCategories) && $expensesCategories->count() > 0)
                {{-- Setting --}}
                <div class="dropdown me-2">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Setting
                    </button>

                </div>

                @endif

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
                    <div class="table-responsive">
                        <table id="file_export" class="table table-striped table-bordered display">
                            <thead>
                                <tr>
                                    <th>Title AR</th>
                                    <th>Title EN</th>
                                    <th>Date/Time</th>
                                    <th>Status</th>
                                    <th>Control</th>

                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($departmentsTypes as $departmentsType)
                                <tr>

                                    <td>{{ isset($departmentsType->title_ar) ? $departmentsType->title_ar : '----' }}
                                    </td>
                                    <td>{{ isset($departmentsType->title_en) ? $departmentsType->title_en : '----' }}
                                    </td>
                                 
                                    <td>{{ isset($departmentsType->status) ? $departmentsType->status : '----' }}</td>
                                    <td>{!! isset($departmentsType->created_at)
                                        ? '<strong>Date : </strong>' .
                                        date('Y -m-d', strtotime($departmentsType->created_at)) .
                                        '<br><strong>Time : </strong>' .
                                        date('h:i A', strtotime($departmentsType->created_at)) .
                                        '<br><strong>Since : </strong> ' .
                                        $departmentsType->created_at->diffForHumans()
                                        : "<span style='color:blue;'>----------</span>" !!}
                                    </td>
                                    <td>
                                        <div class="button-group">
                                            <a href="{{ route('super_admin.departments_types-softDeleteRestore', [isset($departmentsType->id) ? $departmentsType->id : -1]) }}"
                                                class="unarchive btn waves-effect waves-light btn-success btn-sm"
                                                title="Restore this Record"><i class="mdi mdi-redo-variant"></i></a>
                                        </div>
                                    </td>

                                </tr>
                                @empty

                                @endforelse
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