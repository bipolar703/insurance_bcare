@extends('admin.layouts.app')

@section('content')
{{-- =========================================================== --}}
{{-- =================== Page Header Section =================== --}}
{{-- =========================================================== --}}
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-md-5 align-self-center">
            <h3 class="page-title">Subscriptions Types
                @if (isset($subscriptionsTypes))
                ({{ $subscriptionsTypes->count() }})
                @endif
            </h3>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Subscriptions Types</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
            <div class="d-flex">
                {{-- Create --}}
                <div class="dropdown me-2">
                    <a href="{{ route('super_admin.subscriptions_types-create') }}" class="btn btn-dark">
                        <i data-feather="plus" class="fill-white feather-sm"></i> Add New
                    </a>
                </div>
                {{-- Archive --}}
                <div class="dropdown me-2">
                    <a href="{{ route('super_admin.subscriptions_types-showSoftDelete') }}" class="btn btn-danger">
                        <i data-feather="archive" class="fill-white feather-sm"></i> View Archive
                    </a>
                </div>
                 {{-- Setting --}}
                 <div class="dropdown me-2">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Setting
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li><button id="softDeleteSelected" class="confirm dropdown-item"
                                onclick="softDeleteSelected()">Delete Selected</button></li>
                        <li><button id="inactiveSelected" class="process dropdown-item"
                                onclick="inactiveSelected()">Inactive Selected</button></li>
                        <li><button id="activeSelected" class="process dropdown-item"
                                    onclick="activeSelected()">Active Selected</button></li>
                    </ul>
                </div>
                 {{-- Select/Deselect all --}}
                 <div class="dropdown me-2">
                    <button class="toggleSelectAllButton btn btn-primary" onclick="selectDeselectAll()">
                        Select/Deselect all</button>
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
                    <div class="table-responsive">
                        <table id="file_export" class="table table-striped table-bordered display">
                            <thead>
                                <tr>
                                    <th>Title AR</th>
                                    <th>Title EN</th>
                                 
                                    <th>Date/Time</th>
                                    <th>Status</th>
                                    <th>Control</th>
                                    <th>Select</th>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($subscriptionTypes as $subscriptionsType)
                                <tr>
                                    {{-- title_ar --}}
                                    <td>
                                        <strong>{{ isset($subscriptionsType->title_ar) ? $subscriptionsType->title_ar :
                                            '----' }}</strong>
                                    </td>
                                    {{-- title_en --}}
                                    <td>
                                        <strong>{{ isset($subscriptionsType->title_en) ? $subscriptionsType->title_en :
                                            '----' }}</strong>
                                    </td>
                                    
                                    {{-- created_at --}}
                                    <td>
                                        {!! isset($subscriptionsType->created_at)
                                        ? $subscriptionsType->created_at->toDateString()
                                        : "<span style='color:blue;'>----------</span>" !!}
                                    </td>
                                    {{-- status --}}
                                    <td>
                                        @if ($subscriptionsType->status == 'Active')
                                        <a href="{{ route('super_admin.subscriptions_types-activeInactiveSingle', isset($subscriptionsType->id) ? $subscriptionsType->id : -1) }}"
                                            class="process btn waves-effect waves-light btn-light-danger btn-sm"
                                            title="Set Inactive"><i class="mdi mdi-pause"></i>
                                        </a>
                                        <span style="color:green;"><strong>{{ isset($subscriptionsType->status) ?
                                                $subscriptionsType->status : '----' }}</strong></span>
                                        @elseif($subscriptionsType->status == 'Inactive')
                                        <a href="{{ route('super_admin.subscriptions_types-activeInactiveSingle', isset($subscriptionsType->id) ? $subscriptionsType->id : -1) }}"
                                            class="process btn waves-effect waves-light btn-light-success btn-sm"
                                            title="Set Active"><i class="mdi mdi-play"></i>
                                        </a>
                                        <span style="color:red;"> <strong>
                                                {{ isset($subscriptionsType->status) ? $subscriptionsType->status : '----'
                                                }}
                                            </strong> </span>
                                        @else
                                        -----
                                        @endif
                                    </td>
                                    {{-- optiones --}}
                                    <td>
                                        <div class="button-group">

                                            <a href="{{ route('super_admin.subscriptions_types-edit', isset($subscriptionsType->id) ? $subscriptionsType->id : -1) }}"
                                                class="btn waves-effect waves-light btn-secondary btn-sm"
                                                title="Edit"><i class="fas fa-edit"></i></a>
                                            <a href="{{ route('super_admin.subscriptions_types-softDelete', isset($subscriptionsType->id) ? $subscriptionsType->id : -1) }}"
                                                class="confirm btn waves-effect waves-light btn-danger btn-sm"
                                                title="Delete"><i class="fas fa-trash-alt"></i></a>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <input type="checkbox" class="selectedSubscriptionsTypes"
                                            name="selectedSubscriptionsTypes[]" value="{{ $subscriptionsType->id }}">
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
<script>
    $(document).ready(function() {
            if ($.fn.DataTable.isDataTable('#file_export')) {
                $('#file_export').DataTable().destroy();
            }

            $('#file_export').DataTable({
                paging: true,
                searching:false,
                pageLength: 50, // Set the number of records per page
                order: [
                    [2, 'desc'] // Sorting by Date/Time column
                ],
                columnDefs: [{
                        type: 'date',
                        targets: [2]
                    },
                   
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

<script>
    function selectDeselectAll() {
        // Get bcheckbox using CSS class classes
        var selectedSubscriptionsTypes = document.querySelectorAll(".selectedSubscriptionsTypes");
        // Determine whether the boxes are selected or not
        var areAllChecked = true;
        for (var i = 0; i < selectedSubscriptionsTypes.length; i++) {
            if (!selectedSubscriptionsTypes[i].checked) {
                areAllChecked = false;
                break;
            }
        }
        // Change the status of the check box based on the current status
        for (var i = 0; i < selectedSubscriptionsTypes.length; i++) {
            selectedSubscriptionsTypes[i].checked = !areAllChecked;
        }
    }
</script>
{{-- Soft Delete Selected --}}
<script>
    function softDeleteSelected() {
        //Collect the selected subscriptions_types
        var selectedSubscriptionsTypes = [];
        $('input[name="selectedSubscriptionsTypes[]"]:checked').each(function() {
            selectedSubscriptionsTypes.push($(this).val());
        });

        //If subscriptions_types are selected, you can perform the function here
        if (selectedSubscriptionsTypes.length > 0) {
            //Prepare the data as a query
            var query = '?selectedSubscriptionsTypes=' + selectedSubscriptionsTypes.join(',');
            // Create the link with the query
            var link = '{{ route('super_admin.subscriptions_types-softDeleteSelected') }}' + query;
            // Direct the department to the link after preparing it
            window.location.href = link;
        } else {
            Swal.fire(
                'Oops...',
                'Please select at least one department',
                'error'
            )
        }
    }
</script>

{{-- Active Selected --}}
<script>
    function activeSelected() {
        //Collect the selected subscriptions_types
        var selectedSubscriptionsTypes = [];
        $('input[name="selectedSubscriptionsTypes[]"]:checked').each(function() {
            selectedSubscriptionsTypes.push($(this).val());
        });

        //If subscriptions_types are selected, you can perform the function here
        if (selectedSubscriptionsTypes.length > 0) {
            //Prepare the data as a query
            var query = '?selectedSubscriptionsTypes=' + selectedSubscriptionsTypes.join(',');
            // Create the link with the query
            var link = '{{ route('super_admin.subscriptions_types-activeSelected') }}' + query;
            // Direct the browser to the link after preparing it
            window.location.href = link;
        } else {
            Swal.fire(
                'Oops...',
                'Please select at least one department',
                'error'
            )
        }
    }
</script>

{{-- Inactive Selected --}}
<script>
    function inactiveSelected() {
        //Collect the selected subscriptions_types
        var selectedSubscriptionsTypes = [];
        $('input[name="selectedSubscriptionsTypes[]"]:checked').each(function() {
            selectedSubscriptionsTypes.push($(this).val());
        });

        //If subscriptions_types are selected, you can perform the function here
        if (selectedSubscriptionsTypes.length > 0) {
            //Prepare the data as a query
            var query = '?selectedSubscriptionsTypes=' + selectedSubscriptionsTypes.join(',');
            // Create the link with the query
            var link = '{{ route('super_admin.subscriptions_types-inactiveSelected') }}' + query;
            // Direct the browser to the link after preparing it
            window.location.href = link;
        } else {
            Swal.fire(
                'Oops...',
                'Please select at least one department',
                'error'
            )
        }
    }
</script>
@endsection