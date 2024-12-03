@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Archived Certified Checks</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.certified_checks-index') }}">Certified Checks</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Archived Certified Checks</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Create --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.certified_checks-create') }}" class="btn btn-dark">
                            <i data-feather="plus" class="fill-white feather-sm"></i>New Certified Checks
                        </a>
                    </div>
                    @if (isset($certifiedChecks) && $certifiedChecks->count() > 0)
                        {{-- Setting --}}
                        <div class="dropdown me-2">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Setting
                            </button>

                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li><button id="softDeleteRestoreSelected" class="unarchive dropdown-item"
                                        onclick="softDeleteRestoreSelected()">Restore Selected Departments</button>
                                </li>
                            </ul>
                        </div>
                        {{-- Select/Deselect all --}}
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
                        <h4 class="card-title mb-0">Certified Checks</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="file_export" class="table table-striped table-bordered display">
                                <thead>
                                    <tr>
                                        <th>Project Name</th>
                                        <th>Release To</th>
                                        <th>Amount</th>
                                        <th>Release Date</th>
                                        <th>check NO.</th>
                                        <th>Reason For Release</th>
                                        <th>Control</th>
                                        <th>Select</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($certifiedChecks as $certifiedCheck)
                                        <tr>
                                            <td>{{ isset($certifiedCheck->customer->name_en) ? $certifiedCheck->customer->name_en : '----' }}
                                            </td>
                                            <td>{{ isset($certifiedCheck->release_to) ? $certifiedCheck->release_to : '----' }}
                                            </td>
                                            <td>{{ isset($certifiedCheck->amount) ? $certifiedCheck->amount : '----' }} JOD
                                            </td>
                                            <td>{{ isset($certifiedCheck->release_date) ? $certifiedCheck->release_date : '----' }}
                                            </td>
                                            <td>{{ isset($certifiedCheck->check_number) ? $certifiedCheck->check_number : '----' }}
                                            </td>
                                            <td>{{ isset($certifiedCheck->reason_for_release) ? $certifiedCheck->reason_for_release : '----' }}
                                            </td>
                                            <td>
                                                <div class="button-group">
                                                    <a href="{{ route('super_admin.certified_checks-softDeleteRestore', [isset($certifiedCheck->id) ? $certifiedCheck->id : -1]) }}"
                                                        class="unarchive btn waves-effect waves-light btn-success btn-sm"
                                                        title="Restore this Record"><i class="mdi mdi-redo-variant"></i></a>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" class="selectedChecks"
                                                    name="selectedChecks[]" value="{{ $certifiedCheck->id }}">
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
            var selectedChecks = document.querySelectorAll(".selectedChecks");
            // Determine whether the boxes are selected or not
            var areAllChecked = true;
            for (var i = 0; i < selectedChecks.length; i++) {
                if (!selectedChecks[i].checked) {
                    areAllChecked = false;
                    break;
                }
            }
            // Change the status of the check box based on the current status
            for (var i = 0; i < selectedChecks.length; i++) {
                selectedChecks[i].checked = !areAllChecked;
            }
        }
    </script>



    {{-- Soft Delete Restore Selected --}}
    <script>
        function softDeleteRestoreSelected() {
            // Collect the selected rows
            var selectedChecks = [];
            $('input[name="selectedChecks[]"]:checked').each(function() {
                selectedChecks.push($(this).val());
            });
            //If rows are selected, you can perform the function here
            if (selectedChecks.length > 0) {
                //Prepare the data as a query
                var query = '?selectedChecks=' + selectedChecks.join(',');
                // Create the link with the query
                var link = '{{ route('super_admin.certified_checks-softDeleteRestoreSelected') }}' + query;
                // Direct the browser to the link after preparing it
                window.location.href = link;
            } else {
                Swal.fire(
                    'Oops...',
                    'Please select at least one row',
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
                        targets: [7]
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
