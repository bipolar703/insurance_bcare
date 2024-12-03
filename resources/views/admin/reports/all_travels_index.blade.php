@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Travels
                    @if (isset($travelsWithTotalCost))
                        {{-- ({{ $travelsWithTotalCost->count() }}) --}}
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
                    @if (isset($travelsByUser) && $travelsByUser->count() > 0)
                        {{-- Setting --}}
                        <div class="dropdown me-2">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Setting
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li><button id="paidSelected" class="process dropdown-item" onclick="paidSelected()">Paid
                                        Selected</button></li>
                            </ul>
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
                    {{-- Tabs Header Section --}}
                    <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
                        {{-- Tab 1 : Main Info --}}
                        <li class="nav-item">
                            <a class="nav-link active" id="tab_header_1" data-bs-toggle="pill" href="#tab_body_1"
                                role="tab" aria-controls="pills-profile" aria-selected="false"><strong>UnPaid
                                    Travels</strong></a>
                        </li>

                        {{-- Tab 2 : Development Info --}}
                        <li class="nav-item">
                            <a class="nav-link fade" id="tab_header_2" data-bs-toggle="pill" href="#tab_body_2"
                                role="tab" aria-controls="pills-profile" aria-selected="false"><strong>Paid
                                    Travels</strong></a>
                        </li>
                    </ul>
                    <div class="card-body">

                        <div class="tab-content" id="pills-tabContent">
                            {{-- tab 1 --}}
                            <div class="tab-pane fade show active" id="tab_body_1" role="tabpanel"
                                aria-labelledby="tab_body_1">
                                {{-- Search --}}
                                <div class="col-md-12 groove-container">
                                    <label>
                                        <h2>Search Section</h2>
                                    </label>
                                    <br>
                                    <form action="{{ route('super_admin.reports-travelSearch') }}" method="get"
                                        class="row g-3" id="searchForm">
                                        @csrf
                                        {{-- Customer Dropdown --}}
                                        <div class="col-md-4">
                                            <label for="userID" class="form-label">Select Employee Name</label>
                                            <select name="userID"
                                                class="form-control @error('userID') border border-danger @enderror"
                                                id="userID">
                                                <option value="" selected>Select Employee Name</option>
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
                                                <th>Employee Name</th>
                                                <th>Travel Cost</th>
                                                <th>Total Distance</th>
                                                <th>Status</th>
                                                <th>
                                                    <input type="checkbox" class="toggleSelectAllCheckbox"
                                                        id="selectAllCheckbox" onclick="selectDeselectAll()">
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($travelsByUser as $userData)
                                                <tr>
                                                    {{-- employee --}}
                                                    <td>
                                                        <a
                                                            href="{{ route('super_admin.employees-show', ['id' => $userData['user']->id]) }}">
                                                            {{ $userData['user']->name }}
                                                        </a>
                                                    </td>

                                                    {{-- travel cost --}}
                                                    <td>
                                                        <strong>{{ $userData['total_cost'] }} JOD </strong>
                                                    </td>


                                                    {{-- travel_distance --}}
                                                    <td>
                                                        <strong>{{ $userData['distance'] }} KM </strong>
                                                    </td>

                                                    {{-- status --}}
                                                    <td>
                                                        @if (isset($userData['travels']) && !$userData['travels']->isEmpty())
                                                            <span
                                                                style="color: {{ $userData['travels']->first()->status == 'Paid' ? 'green' : 'red' }}">
                                                                <strong>{{ $userData['travels']->first()->status }}</strong>

                                                                <a href="{{ route('super_admin.travels-paidRecord', ['user_id' => $userData['user']->id]) }}"
                                                                    class="btn waves-effect waves-light btn-primary btn-sm"
                                                                    title="View Details">
                                                                    <i class="mdi mdi-emby"></i>
                                                                </a>

                                                            </span>
                                                        @else
                                                            <span style="color: gray;">
                                                                <strong>No Travel</strong>
                                                            </span>
                                                        @endif
                                                    </td>

                                                    <td class="text-center">
                                                        <input type="checkbox" class="selectedTravels"
                                                            name="selectedTravels[]" value="{{ $userData['user']->id }}"
                                                            data-user-id="{{ $userData['user']->id }}">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>

                                        <tfoot>
                                            <tr>
                                                <th colspan="1">Total Cost :</th>
                                                <th colspan="2">
                                                    <span style="color: red"
                                                        class="{{ $travelsByUser->isEmpty() || $travelsByUser->sum('total_cost') == 0 ? 'text-red' : 'text-green' }}">
                                                        {{ $travelsByUser->sum('total_cost') }} JOD
                                                    </span>
                                                </th>
                                            </tr>
                                        </tfoot>

                                    </table>
                                </div>
                            </div>
                            {{-- Tab 2  --}}
                            <div class="tab-pane fade show fade" id="tab_body_2" role="tabpanel" aria-labelledby="tab_body_2">
                                <div class="table-responsive">
                                    <table id="file_export2" class="table table-striped table-bordered display">
                                        <thead>
                                            <tr>
                                                <th>Employee Name</th>
                                                <th>Travel Cost</th>
                                                <th>Total Distance</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($travelsByUserThatIsPaid as $userDataPaid)
                                                <tr>
                                                    {{-- employee --}}
                                                    <td>
                                                        <a
                                                            href="{{ route('super_admin.employees-show', ['id' => $userDataPaid['user']->id]) }}">
                                                            <strong> {{ $userDataPaid['user']->name }}</strong>
                                                        </a>
                                                    </td>

                                                    {{-- travel cost --}}
                                                    <td>
                                                        <strong>{{ $userDataPaid['total_cost'] }} JOD </strong>
                                                    </td>


                                                    {{-- travel_distance --}}
                                                    <td>
                                                        <strong>{{ $userDataPaid['distance'] }} KM </strong>
                                                    </td>

                                                    {{-- status --}}
                                                    <td>
                                                        @if (isset($userDataPaid['travels']) && !$userDataPaid['travels']->isEmpty())
                                                            <span
                                                                style="color: {{ $userDataPaid['travels']->first()->status == 'Paid' ? 'green' : 'red' }}">
                                                                <strong>{{ $userDataPaid['travels']->first()->status }}</strong>

                                                            </span>
                                                        @else
                                                            <span style="color: gray;">
                                                                <strong>No Travel</strong>
                                                            </span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>

                                        <tfoot>
                                            <tr>
                                                <th colspan="1">Total Cost :</th>
                                                <th colspan="2">
                                                    <span style="color: green"
                                                        class="{{ $travelsByUserThatIsPaid->isEmpty() || $travelsByUserThatIsPaid->sum('total_cost') == 0 ? 'text-red' : 'text-green' }}">
                                                        {{ $travelsByUserThatIsPaid->sum('total_cost') }} JOD
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
    </div>
@endsection

@section('extra_js')
    {{-- Select/Deselect all --}}
    <script>
        function selectDeselectAll() {
            // Get bcheckbox using CSS class classes
            var selectedTravels = document.querySelectorAll(".selectedTravels");
            // Determine whether the boxes are selected or not
            var areAllChecked = true;
            for (var i = 0; i < selectedTravels.length; i++) {
                if (!selectedTravels[i].checked) {
                    areAllChecked = false;
                    break;
                }
            }
            // Change the status of the check box based on the current status
            for (var i = 0; i < selectedTravels.length; i++) {
                selectedTravels[i].checked = !areAllChecked;
            }
        }
    </script>

    <script>
        // Function to handle selecting all travels for a user
        function selectAllTravelsForUser(userId) {
            // Collect the IDs of travels related to the selected user
            var selectedTravels = [];
            $('input[name="selectedTravels[]"][data-user-id="' + userId + '"]:not(:checked)').each(function() {
                selectedTravels.push($(this).val());
            });

            // Prepare the data as a query
            var query = '?selectedTravels=' + selectedTravels.join(',');
            // Create the link with the query
            var link = '{{ route('super_admin.travels-paidSelected') }}' + query;
            // Direct the browser to the link after preparing it
            window.location.href = link;
        }

        // When "select all" checkbox for a user is clicked
        $('.selectAllUserTravels').on('change', function() {
            var userId = $(this).data('user-id');
            if (this.checked) {
                selectAllTravelsForUser(userId);
            }
        });
    </script>

    {{-- Paid Selected --}}
    <script>
        function paidSelected() {
            //Collect the selected admins
            var selectedTravels = [];
            $('input[name="selectedTravels[]"]:checked').each(function() {
                selectedTravels.push($(this).val());
            });

            //If admins are selected, you can perform the function here
            if (selectedTravels.length > 0) {
                //Prepare the data as a query
                var query = '?selectedTravels=' + selectedTravels.join(',');
                // Create the link with the query
                var link = '{{ route('super_admin.travels-paidSelected') }}' + query;
                // Direct the browser to the link after preparing it
                window.location.href = link;
            } else {
                Swal.fire(
                    'Oops...',
                    'Please select at least one Travel',
                    'error'
                )
            }
        }
    </script>

    <script>
        $(document).ready(function() {
            if ($.fn.DataTable.isDataTable('#file_export')) {
                $('#file_export').DataTable().destroy();
            }

            $('#file_export').DataTable({
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, 'All']
                ],
                pageLength: 25, // Set default page length
                paging: true, // Enable pagination
                searching: false, // Enable pagination
                order: [
                    [0, 'asc']
                ],
                columnDefs: [{
                        // type: 'date',
                        // targets: [3]
                    },
                    {
                        orderable: false,
                        targets: [4]
                    }
                ],
                dom: '<"top"lfB<"export-buttons">>rtip', // Place length menu at the top and buttons in a separate container
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });

            // Add styling to the DataTable buttons
            $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass(
                'btn btn-primary mr-1');
        });
    </script>

    <script>
        $(document).ready(function() {
            if ($.fn.DataTable.isDataTable('#file_export2')) {
                $('#file_export2').DataTable().destroy();
            }

            $('#file_export2').DataTable({
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, 'All']
                ],
                pageLength: 25, // Set default page length
                paging: true, // Enable pagination
                searching: false, // Enable pagination
                order: [
                    [0, 'asc']
                ],
                columnDefs: [{
                        // type: 'date',
                        // targets: [3]
                    },
                    {
                        orderable: false,
                        targets: [3]
                    }
                ],
                dom: '<"top"lfB<"export-buttons">>rtip', // Place length menu at the top and buttons in a separate container
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
