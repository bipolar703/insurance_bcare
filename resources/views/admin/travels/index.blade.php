@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Travels
                    @if (isset($allTravels))
                        ({{ $allTravels->count() }})
                    @endif
                </h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Travels</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Create --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.travels-create') }}" class="btn btn-dark">
                            <i data-feather="plus" class="fill-white feather-sm"></i> Add New
                        </a>
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
                            {{-- Search --}}
                            <div class="col-md-12 groove-container">
                                <label>
                                    <h2>Search Section</h2>
                                </label>
                                <br>
                                <form action="{{ route('super_admin.travels-search') }}" method="get" class="row g-3"
                                    id="searchForm">
                                    @csrf

                                    {{-- title --}}
                                    {{-- <div class="col-md-4">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" name="title"
                                        class="form-control border border-info @error('title') border-danger @enderror"
                                        id="tb-title" value="{{ $searchValues['title'] ?? '' }}" placeholder="Title">
                                    <label for="tb-title">
                                        <strong class="text-danger">
                                            @error('title')
                                                ( {{ $message }} )
                                            @enderror
                                        </strong>
                                    </label>
                                </div> --}}

                                    {{-- Customer Dropdown --}}
                                    <div class="col-md-4">
                                        <label for="userID" class="form-label">Select Employee Name</label>
                                        <select name="userID" onchange="getCustomerProjects()"
                                            class="form-control @error('userID') border border-danger @enderror"
                                            id="userID">
                                            <option value="" disabled selected>Select Employee Name</option>
                                            @if (isset($users))
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}"
                                                        @if ((isset($searchValues['userID']) && $searchValues['userID'] == $user->id) || old('userID') == $user->id) selected @endif>
                                                        {{ $user->name ?? '------' }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    {{-- Status Dropdown --}}
                                    <div class="col-md-4">
                                        <label for="status" class="form-label">Choose Travel Status</label>
                                        <select name="status"
                                            class="form-control @error('status') border border-danger @enderror">
                                            <option value="">--- Choose Travels Status ---</option>
                                            <option value="1" @if (isset($searchValues['status']) && $searchValues['status'] == 1) selected @endif>Paid
                                            </option>
                                            <option value="2" @if (isset($searchValues['status']) && $searchValues['status'] == 2) selected @endif>UnPaid
                                            </option>
                                        </select>
                                    </div>

                                    {{-- from_date --}}
                                    <div class="col-md-4">
                                        <label for="from_date" class="form-label">From Date</label>
                                        <input type="date" name="from_date"
                                            class="form-control border border-info @error('from_date') border-danger @enderror"
                                            id="tb-title" value="{{ $searchValues['from_date'] ?? '' }}"
                                            placeholder="From Date">
                                        <label for="tb-title">
                                            <strong class="text-danger">
                                                @error('from_date')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>

                                    {{-- to_date --}}
                                    <div class="col-md-4">
                                        <label for="to_date" class="form-label">To Date</label>
                                        <input type="date" name="to_date"
                                            class="form-control border border-info @error('to_date') border-danger @enderror"
                                            id="tb-title" value="{{ $searchValues['to_date'] ?? '' }}"
                                            placeholder="To Date">
                                        <label for="tb-title">
                                            <strong class="text-danger">
                                                @error('to_date')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>

                                    {{-- Add more filters as needed --}}
                                    <div class="col-md-12 text-end">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </form>
                            </div>
                            <br>
                            <div class="table-responsive">
                                <table id="file_export" class="table table-striped table-bordered display">
                                    <thead>
                                        <tr>
                                            <th>Employee</th>
                                            <th>Title</th>
                                            <th>Distance</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Cost</th>
                                            <th>Control</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($allTravels))
                                            @foreach ($allTravels as $allTravel)
                                                <tr>

                                                    {{-- created_by --}}
                                                    <td>
                                                        {{-- {{ isset($allTravel->created_by) ? $allTravel->created_by : '----' }} --}}
                                                        <a
                                                            href="{{ route('super_admin.employees-show', ['id' => isset($allTravel->user) ? $allTravel->user->id : '----']) }}">
                                                            <strong>{{ isset($allTravel->user) ? $allTravel->user->name : '----' }}</strong>
                                                        </a>
                                                    </td>

                                                    {{-- title --}}
                                                    <td>
                                                        <a
                                                            href="{{ route('super_admin.travels-show', isset($allTravel->id) ? $allTravel->id : -1) }}">
                                                            <strong>{{ isset($allTravel->title) ? $allTravel->title : '----' }}</strong>
                                                        </a>
                                                    </td>

                                                    {{-- distance --}}
                                                    <td>
                                                        <strong>{{ isset($allTravel->distance) ? $allTravel->distance : '----' }}
                                                            KM</strong>
                                                    </td>

                                                    {{-- date --}}
                                                    <td>
                                                        <a
                                                            href="{{ route('super_admin.travels-show', isset($allTravel->id) ? $allTravel->id : -1) }}">
                                                            <strong>{{ isset($allTravel->date) ? $allTravel->date : '----' }}</strong>
                                                        </a>
                                                    </td>

                                                    {{-- status --}}
                                                    <td>
                                                        @if (isset($allTravel->status) && $allTravel->status == 'Paid')
                                                            <span style="color: green">
                                                                <strong>
                                                                    {{ $allTravel->status }}
                                                                </strong>
                                                            </span>
                                                        @else
                                                            <span style="color: red">
                                                                <strong>
                                                                    {{ isset($allTravel->status) ? $allTravel->status : '----' }}
                                                                </strong>
                                                            </span>
                                                        @endif
                                                    </td>

                                                    {{-- cost --}}
                                                    <td>
                                                        @if (isset($allTravel->status) && $allTravel->status == 'Paid')
                                                            <strong
                                                                style="color: green">{{ isset($allTravel->cost) ? $allTravel->cost : '----' }}
                                                                JOD</strong>
                                                        @else
                                                            <strong
                                                                style="color: red">{{ isset($allTravel->cost) ? $allTravel->cost : '----' }}
                                                                JOD</strong>
                                                        @endif
                                                    </td>

                                                    {{-- operations --}}
                                                    <td>
                                                        <div class="button-group">
                                                            <a href="{{ route('super_admin.travels-show', isset($allTravel->id) ? $allTravel->id : -1) }}"
                                                                class="btn waves-effect waves-light btn-primary btn-sm"
                                                                title="View Details"><i class="fas fa-eye"></i>
                                                            </a>

                                                            @if ($allTravel->status === 'UnPaid')
                                                                <a href="{{ route('super_admin.travels-edit', isset($allTravel->id) ? $allTravel->id : -1) }}"
                                                                    class="btn waves-effect waves-light btn-secondary btn-sm"
                                                                    title="Edit"><i class="fas fa-edit"></i>
                                                                </a>
                                                            @endif

                                                            @if ($allTravel->status === 'UnPaid')
                                                                <a href="{{ route('super_admin.travels-destroy', isset($allTravel->id) ? $allTravel->id : -1) }}"
                                                                    class="confirm btn waves-effect waves-light btn-danger btn-sm"
                                                                    title="Delete"><i class="fas fa-trash-alt"></i>
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="5">Total Cost :</th>
                                            <th colspan="2">
                                                <span
                                                    class="{{ !$allTravels->isEmpty() && $allTravels->sum('cost') > 0 ? 'text-green' : 'text-red' }}">
                                                    {{ !$allTravels->isEmpty() ? $allTravels->sum('cost') . ' JOD' : '-------' }}
                                                </span>
                                            </th>

                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra_js')
    {{-- passed the test in https://validatejavascript.com/  using custom JS config --}}
    {{-- select 2 script --}}
    <script>
        $(document).ready(function() {
            $('select[name="allTravelID"]').select2();
            $('select[name="search"]').select2();
            $('select[name="userID"]').select2();
        });
    </script>

    <script>
        $(document).ready(function() {
            if ($.fn.DataTable.isDataTable('#file_export')) {
                $('#file_export').DataTable().destroy();
            }

            $('#file_export').DataTable({
                paging: true,
                searching: false,
                pageLength: 50, // Set the number of records per page
                order: [
                    [3, 'desc'] // Sorting by Date/Time column
                ],
                columnDefs: [{
                        type: 'date',
                        targets: [3]
                    },
                    {
                        orderable: false,
                        targets: [6]
                    }
                ],
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });

            // Add styling to the DataTable buttons
            $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass(
                'btn btn-primary mr-1');
        });
    </script>
@endsection
