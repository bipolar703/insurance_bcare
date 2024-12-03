@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">All Admins</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">All Admins</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Create --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.admins-create') }}" class="btn btn-dark">
                            <i data-feather="plus" class="fill-white feather-sm"></i> Add New
                        </a>
                    </div>
                    {{-- Archive --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.admins-showSoftDelete') }}" class="btn btn-danger">
                            <i data-feather="archive" class="fill-white feather-sm"></i> View Archive
                        </a>
                    </div>
                    @if (isset($admins) && $admins->count() > 0)
                        {{-- Setting --}}
                        <div class="dropdown me-2">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Setting
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li><button id="softDeleteSelected" class="confirm dropdown-item"
                                        onclick="softDeleteSelected()">Delete Selected</button></li>
                                <li><button id="activeSelected" class="process dropdown-item"
                                        onclick="activeSelected()">Active
                                        Selected</button></li>
                                <li><button id="inactiveSelected" class="process dropdown-item"
                                        onclick="inactiveSelected()">Inactive Selected</button></li>
                            </ul>
                        </div>

                        <div class="dropdown me-2">
                            <button class="toggleSelectAllButton btn btn-primary" onclick="selectDeselectAll()">
                                Select/Deselect all</button>
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
                    <div class="border-bottom title-part-padding">
                        <h4 class="card-title mb-0">All Admins</h4>
                    </div>
                    <div class="card-body">
                        {{-- Overview --}}
                        {{-- <h6 class="card-subtitle mb-3">A description of this page and the features available on it,You will
                            be able to manage all you Admins from this page and do a collection of actions on it like:
                            Edit,Delete,Create,See details,See Archived and much more.
                        </h6> --}}

                        {{-- Statistics Section --}}
                        {{-- <div class="col-12">
                            <div id="item-details-statistics"></div>
                            <div id="item-total-revenue"></div>
                        </div> --}}
                        {{-- Table Section --}}
                        <div class="table-responsive">
                            <table id="file_export" class="table table-striped table-bordered display">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Type</th>
                                        <th>Date/Time</th>
                                        <th>Status</th>
                                        <th>Control</th>
                                        <th>Select</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($admins as $admin)
                                        <tr>
                                            {{-- name --}}
                                            <td><a
                                                    href="{{ route('super_admin.admins-show', isset($admin->id) ? $admin->id : -1) }}">{{ isset($admin->name) ? $admin->name : '----' }}</a>
                                            </td>
                                            {{-- email --}}
                                            <td><a
                                                    href="{{ route('super_admin.admins-show', isset($admin->id) ? $admin->id : -1) }}">{{ isset($admin->email) ? $admin->email : '----' }}</a>
                                            </td>
                                            {{-- phone --}}
                                            <td>{{ isset($admin->phone) ? $admin->phone : '----' }}</td>
                                            {{-- type --}}
                                            <td>{{ isset($admin->type) ? $admin->type : '----' }}</td>
                                            {{-- created_at --}}
                                            <td>{!! isset($admin->created_at)
                                                ? '<strong>Date : </strong>' .
                                                    date('Y -m-d', strtotime($admin->created_at)) .
                                                    '<br><strong>Time : </strong>' .
                                                    date('h:i A', strtotime($admin->created_at)) .
                                                    '<br><strong>Since : </strong> ' .
                                                    $admin->created_at->diffForHumans()
                                                : "<span style='color:blue;'>----------</span>" !!}
                                            </td>
                                            {{-- status --}}
                                            <td>
                                                @if ($admin->status == 'Active')
                                                    <a href="{{ route('super_admin.admins-activeInactiveSingle', isset($admin->id) ? $admin->id : -1) }}"
                                                        class="process btn waves-effect waves-light btn-light-danger btn-sm"
                                                        title="Set Inactive"><i class="mdi mdi-pause"></i></a>
                                                    <span
                                                        style="color:green;">{{ isset($admin->status) ? $admin->status : '----' }}</span>
                                                @elseif($admin->status == 'Inactive')
                                                    <a href="{{ route('super_admin.admins-activeInactiveSingle', isset($admin->id) ? $admin->id : -1) }}"
                                                        class="process btn waves-effect waves-light btn-light-success btn-sm"
                                                        title="Set Active"><i class="mdi mdi-play"></i></a>
                                                    <span
                                                        style="color:red;">{{ isset($admin->status) ? $admin->status : '----' }}</span>
                                                @endif
                                            </td>

                                            {{-- operations --}}
                                            <td>
                                                <div class="button-group">
                                                    <a href="{{ route('super_admin.admins-show', isset($admin->id) ? $admin->id : -1) }}"
                                                        class="btn waves-effect waves-light btn-primary btn-sm"
                                                        title="View Details"><i class="fas fa-eye"></i></a>
                                                    <a href="{{ route('super_admin.admins-edit', isset($admin->id) ? $admin->id : -1) }}"
                                                        class="btn waves-effect waves-light btn-secondary btn-sm"
                                                        title="Edit"><i class="fas fa-edit"></i></a>
                                                    <a href="{{ route('super_admin.admins-softDelete', isset($admin->id) ? $admin->id : -1) }}"
                                                        class="confirm btn waves-effect waves-light btn-danger btn-sm"
                                                        title="Delete"><i class="fas fa-trash-alt"></i></a>
                                                </div>
                                            </td>

                                            <td class="text-center">
                                                <input type="checkbox" class="selectedAdmins" name="selectedAdmins[]"
                                                    value="{{ $admin->id }}">
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
    {{-- Select/Deselect all --}}
    <script>
        function selectDeselectAll() {
            // Get bcheckbox using CSS class classes
            var selectedAdmins = document.querySelectorAll(".selectedAdmins");
            // Determine whether the boxes are selected or not
            var areAllChecked = true;
            for (var i = 0; i < selectedAdmins.length; i++) {
                if (!selectedAdmins[i].checked) {
                    areAllChecked = false;
                    break;
                }
            }
            // Change the status of the check box based on the current status
            for (var i = 0; i < selectedAdmins.length; i++) {
                selectedAdmins[i].checked = !areAllChecked;
            }
        }
    </script>


    {{-- Soft Delete Selected --}}
    <script>
        function softDeleteSelected() {
            //Collect the selected admins
            var selectedAdmins = [];
            $('input[name="selectedAdmins[]"]:checked').each(function() {
                selectedAdmins.push($(this).val());
            });

            //If admins are selected, you can perform the function here
            if (selectedAdmins.length > 0) {
                //Prepare the data as a query
                var query = '?selectedAdmins=' + selectedAdmins.join(',');
                // Create the link with the query
                var link = '{{ route('super_admin.admins-softDeleteSelected') }}' + query;
                // Direct the admin to the link after preparing it
                window.location.href = link;
            } else {
                Swal.fire(
                    'Oops...',
                    'Please select at least one admin',
                    'error'
                )
            }
        }
    </script>


    {{-- Active Selected --}}
    <script>
        function activeSelected() {
            //Collect the selected admins
            var selectedAdmins = [];
            $('input[name="selectedAdmins[]"]:checked').each(function() {
                selectedAdmins.push($(this).val());
            });

            //If admins are selected, you can perform the function here
            if (selectedAdmins.length > 0) {
                //Prepare the data as a query
                var query = '?selectedAdmins=' + selectedAdmins.join(',');
                // Create the link with the query
                var link = '{{ route('super_admin.admins-activeSelected') }}' + query;
                // Direct the browser to the link after preparing it
                window.location.href = link;
            } else {
                Swal.fire(
                    'Oops...',
                    'Please select at least one admin',
                    'error'
                )
            }
        }
    </script>


    {{-- Inactive Selected --}}
    <script>
        function inactiveSelected() {
            //Collect the selected admins
            var selectedAdmins = [];
            $('input[name="selectedAdmins[]"]:checked').each(function() {
                selectedAdmins.push($(this).val());
            });

            //If admins are selected, you can perform the function here
            if (selectedAdmins.length > 0) {
                //Prepare the data as a query
                var query = '?selectedAdmins=' + selectedAdmins.join(',');
                // Create the link with the query
                var link = '{{ route('super_admin.admins-inactiveSelected') }}' + query;
                // Direct the browser to the link after preparing it
                window.location.href = link;
            } else {
                Swal.fire(
                    'Oops...',
                    'Please select at least one admin',
                    'error'
                )
            }
        }
    </script>
@endsection
