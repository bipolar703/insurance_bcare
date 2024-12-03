@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="col-md-12">
            <h2 class="page-title">
                <a href="{{ route('super_admin.projects-show', ['id' => $project->id]) }}">
                    {{ isset($project->name_en) ? $project->name_en : null }}
                </a>
            </h2>
        </div>

        <div class="col-md-12">
            <a href="{{ route('super_admin.projects-show', ['id' => $project->id]) }}">
                <h2 class="page-title">
                    <a href="{{ route('super_admin.projects-show', ['id' => $project->id]) }}">
                        {{ isset($project->name_ar) ? $project->name_ar : null }}
                    </a>
                </h2>
            </a>
        </div>
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Update Subscription Info</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.projects-index') }}">All Projects</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Update Subscription Info</li>
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
                {{-- Form Section --}}
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3 pb-3 border-bottom">Update Subscription Info :</h4>
                        <form
                            action="{{ route('super_admin.project_subscriptions-update', isset($projectSubscriptions->id) ? $projectSubscriptions->id : -1) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">

                                {{-- project_id --}}
                                <input name="project_id" type="hidden"
                                    value="{{ isset($project->id) ? $project->id : '-1' }}">

                                {{-- customer_id --}}
                                <input name="customer_id" type="hidden"
                                    value="{{ isset($project->customer_id) ? $project->customer_id : '-1' }}">
                                {{-- started_from --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="date" name="started_from"
                                            class="form-control border border-info @error('started_from') border-danger @enderror"
                                            id="tb-started_from"
                                            value="{{ isset($projectSubscriptions->started_from) ? $projectSubscriptions->started_from : null }}"
                                            placeholder="Started From">
                                        <label for="tb-started_from">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>Started
                                            From
                                            <strong class="text-danger">
                                                @error('started_from')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- due_date --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="date" name="due_date"
                                            class="form-control border border-info @error('due_date') border-danger @enderror"
                                            id="tb-due_date"
                                            value="{{ isset($projectSubscriptions->due_date) ? $projectSubscriptions->due_date : null }}"
                                            placeholder="Due Date">
                                        <label for="tb-due_date">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i> Due
                                            Date
                                            <strong class="text-danger">
                                                @error('due_date')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- payment_amount --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="payment_amount" min="0" step="0.001"
                                            class="form-control border border-info @error('payment_amount') border-danger @enderror"
                                            id="tb-payment_amount"
                                            value="{{ isset($projectSubscriptions->payment_amount) ? $projectSubscriptions->payment_amount : null }}"
                                            placeholder="Payment Amount">
                                        <label for="tb-payment_amount">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i> Payment Amount
                                            <strong class="text-danger">
                                                @error('payment_amount')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- plan_type --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                            <select name="plan_type"
                                                class="form-control form-select border border-info @error('plan_type') border-danger @enderror custom_select_style">
                                                <option>--- Choose Plan Type ---</option>
                                                <option value="1" @if ($projectSubscriptions->plan_type == 'Free') selected @endif
                                                    @if ($projectSubscriptions->plan_type == null) selected @endif>Free </option>
                                                <option value="2" @if ($projectSubscriptions->plan_type == 'Premium') selected @endif>
                                                    Premium </option>
                                            </select>
                                            <label for="tb-name">
                                                <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                                Plan Type
                                                <strong class="text-danger">
                                                    @error('plan_type')
                                                        ( {{ $message }} )
                                                    @enderror
                                                </strong>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                {{-- subscription_type_id	 --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                            <select name="subscription_type_id"
                                                class="form-control form-select border border-info @error('subscription_type_id') border-danger @enderror custom_select_style">
                                                <option>--- Select subscription_type_id ---</option>
                                            @if (isset($subscriptionsTypes) && $subscriptionsTypes->count() > 0)
                                                @foreach ($subscriptionsTypes as $subscriptionsType)
                                                <option value="{!!$subscriptionsType->id!!}" @if ($projectSubscriptions->subscription_type_id == $subscriptionsType->id) selected @endif
                                                    >{!!isset($subscriptionsType->title_en) && isset($subscriptionsType->title_ar) ? $subscriptionsType->title_en  .' ( '. $subscriptionsType->title_ar .' )': '-----' !!} </option>
                                                @endforeach
                                           
                                            @endif
                                             
                                            </select>

                                            <label for="tb-name">
                                                <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                                Subscription Type
                                                <strong class="text-danger">
                                                    @error('subscription_type_id')
                                                        ( {{ $message }} )
                                                    @enderror
                                                </strong>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <hr>

                                {{-- Description --}}
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label>Description : <strong class="text-danger">
                                                @error('description')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong></label>
                                        <textarea name="description" class="form-control border border-info @error('description') border-danger @enderror"
                                            rows="5" placeholder="Description">{{ isset($projectSubscriptions->description) ? $projectSubscriptions->description : null }}</textarea>
                                    </div>
                                </div>

                                {{-- Transaction Other Note --}}
                                <div class="col-md-12" id="transactionOtherNoteSection">
                                    <div class="mb-3">
                                        <label>Transaction Other Note : <strong class="text-danger">
                                                @error('transaction_other_note')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong></label>
                                        <textarea name="transaction_other_note"
                                            class="form-control border border-info @error('transaction_other_note') border-danger @enderror" rows="5"
                                            placeholder="Transaction Other Note">{{ isset($projectSubscriptions->transaction_other_note) ? $projectSubscriptions->transaction_other_note : null }}</textarea>
                                    </div>
                                </div>



                                {{-- Button --}}
                                <div class="col-12">
                                    <div class="d-md-flex align-items-center mt-3">
                                        <div class="ms-auto mt-3 mt-md-0">
                                            <button type="submit"
                                                class="btn btn-success font-weight-medium rounded-pill px-4">
                                                <div class="d-flex align-items-center">
                                                    <i data-feather="save" class="feather-sm fill-white me-2"></i>
                                                    Save Updates
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra_js')
    <script>
        $(document).ready(function() {
            // Initially hide the Transaction Other Note section
            $('#transactionOtherNoteSection').hide();

            // Show/hide based on the selected option
            $('select[name="transaction"]').change(function() {
                if ($(this).val() == 6) {
                    $('#transactionOtherNoteSection').show();
                } else {
                    $('#transactionOtherNoteSection').hide();
                }
            });

            // Trigger change event on page load to handle initial state
            $('select[name="transaction"]').trigger('change');
        });
    </script>
@endsection
