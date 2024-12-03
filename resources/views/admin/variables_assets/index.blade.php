@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Variable Assets
                    @if (isset($variablesAssets))
                        ({{ $variablesAssets->count() }})
                    @endif
                </h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Variable Assets</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Create --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.variables_assets-create') }}" class="btn btn-dark">
                            <i data-feather="plus" class="fill-white feather-sm"></i> Add New Variable Assets
                        </a>
                    </div>
                    {{-- Archive --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.variables_assets-showSoftDelete') }}" class="btn btn-danger">
                            <i data-feather="archive" class="fill-white feather-sm"></i> View Archive
                        </a>
                    </div>
                    @if (isset($variablesAssets) && $variablesAssets->count() > 0)
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
                                        onclick="activeSelected()">Active Selected</button></li>
                                <li><button id="inactiveSelected" class="process dropdown-item"
                                        onclick="inactiveSelected()">Inactive Selected</button></li>
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
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="file_export" class="table table-striped table-bordered display">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Quantity</th>
                                        <th>Status</th>
                                        <th>Date/Time</th>
                                       
                                        <th>Control</th>
                                        <th>
                                            <input type="checkbox" class="toggleSelectAllCheckbox" id="selectAllCheckbox"
                                                onclick="selectDeselectAll()">
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($variablesAssets))
                                        @foreach ($variablesAssets as $variableAsset)
                                            <tr>
                                                {{-- title --}}
                                                <td>
                                                    <a
                                                        href="{{ route('super_admin.variables_assets-show', isset($variableAsset->id) ? $variableAsset->id : -1) }}">
                                                        <strong>{{ isset($variableAsset->title) ? $variableAsset->title : '----' }}</strong>
                                                    </a>
                                                </td>

                                                {{-- Quantitiy --}}
                                                <td>
                                                    {{ isset($variableAsset->quantity) ? $variableAsset->quantity : '----' }}
                                                </td>
                                                    {{-- status --}}
                                                    <td>
                                                        @if ($variableAsset->status == 'Active')
                                                            <a href="{{ route('super_admin.variables_assets-activeInactiveSingle', isset($variableAsset->id) ? $variableAsset->id : -1) }}"
                                                                class="process btn waves-effect waves-light btn-light-danger btn-sm"
                                                                title="Set Inactive"><i class="mdi mdi-pause"></i>
                                                            </a>
                                                            <span
                                                                style="color:green;"><strong>{{ isset($variableAsset->status) ? $variableAsset->status : '----' }}</strong></span>
                                                        @elseif($variableAsset->status == 'Inactive')
                                                            <a href="{{ route('super_admin.variables_assets-activeInactiveSingle', isset($variableAsset->id) ? $variableAsset->id : -1) }}"
                                                                class="process btn waves-effect waves-light btn-light-success btn-sm"
                                                                title="Set Active"><i class="mdi mdi-play"></i>
                                                            </a>
                                                            <span style="color:red;"> <strong>
                                                                    {{ isset($variableAsset->status) ? $variableAsset->status : '----' }}
                                                                </strong> </span>
                                                        @else
                                                            -----
                                                        @endif
                                                    </td>
                                                {{-- created_at --}}
                                                <td>
                                                    {!! isset($variableAsset->created_at)
                                                        ? $variableAsset->created_at->toDateString()
                                                        : "<span style='color:blue;'>----------</span>" !!}
                                                </td>

                                            

                                                {{-- operations --}}
                                                <td>
                                                    <div class="button-group">
                                                        <a href="{{ route('super_admin.variables_assets-show', isset($variableAsset->id) ? $variableAsset->id : -1) }}"
                                                            class="btn waves-effect waves-light btn-primary btn-sm"
                                                            title="View Details"><i class="fas fa-eye"></i></a>
                                                        <a href="{{ route('super_admin.variables_assets-edit', isset($variableAsset->id) ? $variableAsset->id : -1) }}"
                                                            class="btn waves-effect waves-light btn-secondary btn-sm"
                                                            title="Edit"><i class="fas fa-edit"></i></a>
                                                        <a href="{{ route('super_admin.variables_assets-softDelete', isset($variableAsset->id) ? $variableAsset->id : -1) }}"
                                                            class="confirm btn waves-effect waves-light btn-danger btn-sm"
                                                            title="Delete"><i class="fas fa-trash-alt"></i></a>
                                                    </div>
                                                </td>

                                                <td class="text-center">
                                                    <input type="checkbox" class="selectedVariableAssets"
                                                        name="selectedVariableAssets[]" value="{{ $variableAsset->id }}">
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
@endsection

@section('extra_js')
    {{-- Select/Deselect all --}}
    <script>
        function selectDeselectAll() {
            // Get bcheckbox using CSS class classes
            var selectedVariableAssets = document.querySelectorAll(".selectedVariableAssets");
            // Determine whether the boxes are selected or not
            var areAllChecked = true;
            for (var i = 0; i < selectedVariableAssets.length; i++) {
                if (!selectedVariableAssets[i].checked) {
                    areAllChecked = false;
                    break;
                }
            }
            // Change the status of the check box based on the current status
            for (var i = 0; i < selectedVariableAssets.length; i++) {
                selectedVariableAssets[i].checked = !areAllChecked;
            }
        }
    </script>


    {{-- Soft Delete Selected --}}
    <script>
        function softDeleteSelected() {
            //Collect the selected admins
            var selectedVariableAssets = [];
            $('input[name="selectedVariableAssets[]"]:checked').each(function() {
                selectedVariableAssets.push($(this).val());
            });

            //If admins are selected, you can perform the function here
            if (selectedVariableAssets.length > 0) {
                //Prepare the data as a query
                var query = '?selectedVariableAssets=' + selectedVariableAssets.join(',');
                // Create the link with the query
                var link = '{{ route('super_admin.variables_assets-softDeleteSelected') }}' + query;
                // Direct the vendors to the link after preparing it
                window.location.href = link;
            } else {
                Swal.fire(
                    'Oops...',
                    'Please select at least one customer',
                    'error'
                )
            }
        }
    </script>


    {{-- Active Selected --}}
    <script>
        function activeSelected() {
            //Collect the selected admins
            var selectedVariableAssets = [];
            $('input[name="selectedVariableAssets[]"]:checked').each(function() {
                selectedVariableAssets.push($(this).val());
            });

            //If admins are selected, you can perform the function here
            if (selectedVariableAssets.length > 0) {
                //Prepare the data as a query
                var query = '?selectedVariableAssets=' + selectedVariableAssets.join(',');
                // Create the link with the query
                var link = '{{ route('super_admin.variables_assets-activeSelected') }}' + query;
                // Direct the browser to the link after preparing it
                window.location.href = link;
            } else {
                Swal.fire(
                    'Oops...',
                    'Please select at least one customer',
                    'error'
                )
            }
        }
    </script>


    {{-- Inactive Selected --}}
    <script>
        function inactiveSelected() {
            //Collect the selected admins
            var selectedVariableAssets = [];
            $('input[name="selectedVariableAssets[]"]:checked').each(function() {
                selectedVariableAssets.push($(this).val());
            });

            //If admins are selected, you can perform the function here
            if (selectedVariableAssets.length > 0) {
                //Prepare the data as a query
                var query = '?selectedVariableAssets=' + selectedVariableAssets.join(',');
                // Create the link with the query
                var link = '{{ route('super_admin.variables_assets-inactiveSelected') }}' + query;
                // Direct the browser to the link after preparing it
                window.location.href = link;
            } else {
                Swal.fire(
                    'Oops...',
                    'Please select at least one customer',
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
                paging: true,
                pageLength: 50, // Set the number of records per page
                order: [
                    [2, 'desc'] // Sorting by Date/Time column
                ],
                columnDefs: [{
                        type: 'date',
                        targets: [2]
                    },
                    {
                        orderable: false,
                        targets: [4,5]
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


    {{-- passed the test in https://validatejavascript.com/  using custom JS config --}}
    {{-- select 2 script --}}
    <script>
        $(document).ready(function() {
            $('select[name="customerID"]').select2();
            $('select[name="search"]').select2();
        });
    </script>
@endsection
