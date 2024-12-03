@extends('admin.layouts.app')

@section('content')
{{-- =========================================================== --}}
{{-- =================== Page Header Section =================== --}}
{{-- =========================================================== --}}
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-md-5 align-self-center">
            <h3 class="page-title">Subscriptions Types</h3>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a
                                href="{{ route('super_admin.subscriptions_types-index') }}">Subscriptions Types</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Archives</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
            <div class="d-flex">
                {{-- Create --}}
                <div class="dropdown me-2">
                    <a href="{{ route('super_admin.subscriptions_types-create') }}" class="btn btn-dark">
                        <i data-feather="plus" class="fill-white feather-sm"></i> Add New Subscription Type
                    </a>
                </div>
                @if (isset($subscriptionsTypes) && $subscriptionsTypes->count() > 0)
             
                {{-- Setting --}}
                <div class="dropdown me-2">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Setting
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li><button id="softDeleteRestoreSelected" class="unarchive dropdown-item"
                                onclick="softDeleteRestoreSelected()">Restore Selected Subscriptions Types</button>
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
                                @forelse ($subscriptionsTypes as $subscriptionsType)
                                <tr>

                                    <td>{{ isset($subscriptionsType->title_ar) ? $subscriptionsType->title_ar : '----' }}
                                    </td>
                                    <td>{{ isset($subscriptionsType->title_en) ? $subscriptionsType->title_en : '----' }}
                                    </td>
                                 
                                    <td>{{ isset($subscriptionsType->status) ? $subscriptionsType->status : '----' }}</td>
                                    <td>{!! isset($subscriptionsType->created_at)
                                        ? '<strong>Date : </strong>' .
                                        date('Y -m-d', strtotime($subscriptionsType->created_at)) .
                                        '<br><strong>Time : </strong>' .
                                        date('h:i A', strtotime($subscriptionsType->created_at)) .
                                        '<br><strong>Since : </strong> ' .
                                        $subscriptionsType->created_at->diffForHumans()
                                        : "<span style='color:blue;'>----------</span>" !!}
                                    </td>
                                    <td>
                                        <div class="button-group">
                                            <a href="{{ route('super_admin.subscriptions_types-softDeleteRestore', [isset($subscriptionsType->id) ? $subscriptionsType->id : -1]) }}"
                                                class="unarchive btn waves-effect waves-light btn-success btn-sm"
                                                title="Restore this Record"><i class="mdi mdi-redo-variant"></i></a>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" class="selectedSubscriptionsTypes" name="selectedSubscriptionsTypes[]"
                                            value="{{ $subscriptionsType->id }}">
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
  {{-- Soft Delete Restore Selected --}}
  <script>
    function softDeleteRestoreSelected() {
        // Collect the selected rows
        var selectedSubscriptionsTypes = [];
        $('input[name="selectedSubscriptionsTypes[]"]:checked').each(function() {
            selectedSubscriptionsTypes.push($(this).val());
        });
        //If rows are selected, you can perform the function here
        if (selectedSubscriptionsTypes.length > 0) {
            //Prepare the data as a query
            var query = '?selectedSubscriptionsTypes=' + selectedSubscriptionsTypes.join(',');
            // Create the link with the query
            var link = '{{ route('super_admin.subscriptions_types-softDeleteRestoreSelected') }}' + query;
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



@endsection