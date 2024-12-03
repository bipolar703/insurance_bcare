@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="col-md-12">
            <h2 class="page-title">
                <a href="{{ route('super_admin.project_invoices-show', ['id' => $project->id]) }}">
                    {{ isset($project->name_en) ? $project->name_en : null }}
                </a>
            </h2>
        </div>

        <div class="col-md-12">
            <a href="{{ route('super_admin.project_invoices-show', ['id' => $project->id]) }}">
                <h2 class="page-title">
                    <a href="{{ route('super_admin.project_invoices-show', ['id' => $project->id]) }}">
                        {{ isset($project->name_ar) ? $project->name_ar : null }}
                    </a>
                </h2>
            </a>
        </div>
        <br>
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Add New Subscription</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.projects-index') }}">All Projects</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Archive --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.projects-showSoftDelete') }}" class="btn btn-danger">
                            <i data-feather="archive" class="fill-white feather-sm"></i> View Archived Project
                        </a>
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
                        <h4 class="card-title mb-3 pb-3 border-bottom">Add New Subscription :</h4>
                        <form action="{{ route('super_admin.project_subscriptions-store') }}" method="POST"
                            enctype="multipart/form-data" id="createForm">
                            @csrf
                            <div class="row">
                                {{-- subscription_type_id --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <select name="subscription_type_id"
                                            class="form-control form-select border border-info @error('subscription_type_id') border-danger @enderror custom_select_style"
                                            id="subscription_type_idSelect">
                                            @if (isset($subscriptionsTypes) && $subscriptionsTypes->count() > 0)
                                                <option>--- Select Subscription Type * ---</option>
                                                @foreach ($subscriptionsTypes as $subscriptionsType)
                                                <option value="{!!isset($subscriptionsType->id) ? $subscriptionsType->id : -1 !!}" @if (old('subscription_type_id') == $subscriptionsType->id ) selected @endif>
                                                    {!!isset($subscriptionsType->title_en) && isset($subscriptionsType->title_ar) ? $subscriptionsType->title_en .' ( '. $subscriptionsType->title_ar .' )' : null !!} </option>
                                                @endforeach
                                            @else
                                            <option>--- No avaliable subscriptions ---</option>
                                            @endif
                                           
                                            
                                        </select>
                                    </div>
                                </div>

                                {{-- plan_type --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <select name="plan_type"
                                            class="form-control form-select border border-info @error('plan_type') border-danger @enderror custom_select_style">
                                            <option>--- Select Plan Type * ---</option>
                                            <option value="1" @if (old('plan_type') == 1) selected @endif
                                                @if (old('plan_type') == null) selected @endif>Free </option>
                                            <option value="2" @if (old('plan_type') == 2) selected @endif>
                                                Premium </option>
                                        </select>
                                    </div>
                                </div>

                                {{-- payment_amount --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="payment_amount" min="0" step="0.001"
                                            class="form-control border border-info @error('payment_amount') border-danger @enderror"
                                            id="tb-payment_amount" value="{{ old('payment_amount') }}"
                                            placeholder="Payment Amount">
                                        <label for="tb-payment_amount">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>Payment
                                            Amount
                                            <span>*</span>
                                            <strong class="text-danger">
                                                @error('payment_amount')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- started_from --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="date" name="started_from"
                                            class="form-control border border-info @error('started_from') border-danger @enderror"
                                            id="tb-started_from" value="{{ old('started_from') }}"
                                            placeholder="Started From">
                                        <label for="tb-started_from">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                            Started From
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
                                            id="tb-due_date" value="{{ old('due_date') }}" placeholder="Due Date">
                                        <label for="tb-due_date">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                            Due Date
                                            <strong class="text-danger">
                                                @error('due_date')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- Description --}}
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label>Description : <strong class="text-danger">
                                                @error('description')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong></label>
                                        <textarea name="description" class="form-control border border-info @error('description') border-danger @enderror"
                                            rows="5" placeholder="Description">{{ old('description') }}</textarea>
                                    </div>
                                </div>

                                {{-- transaction_other_note --}}
                                <div class="col-md-12" id="transactionOtherNoteContainer" style="display: none;">
                                    <div class="mb-3">
                                        <label>Transaction Other Note :
                                            <strong class="text-danger">
                                                @error('transaction_other_note')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                        <textarea name="transaction_other_note"
                                            class="form-control border border-info @error('transaction_other_note') border-danger @enderror" rows="5"
                                            placeholder="Transaction Other Note">{{ old('transaction_other_note') }}</textarea>
                                    </div>
                                </div>


                                {{-- project_id --}}
                                <input name="project_id" type="hidden"
                                    value="{{ isset($project->id) ? $project->id : '-1' }}">

                                {{-- customer_id --}}
                                <input name="customer_id" type="hidden"
                                    value="{{ isset($project->customer_id) ? $project->customer_id : '-1' }}">
                                {{-- Button --}}
                                <div class="col-12">
                                    <div class="d-md-flex align-items-center mt-3">
                                        <div class="ms-auto mt-3 mt-md-0">
                                            <button type="submit"
                                                class="btn btn-success font-weight-medium rounded-pill px-4">
                                                <div class="d-flex align-items-center">
                                                    <i data-feather="plus" class="feather-sm fill-white me-2"></i>
                                                    Add New Subscription
                                                </div>
                                            </button>
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
            $('#transactionSelect').on('change', function() {
                if ($(this).val() == '6') {
                    $('#transactionOtherNoteContainer').show();
                } else {
                    $('#transactionOtherNoteContainer').hide();
                }
            });

            // Initial check on page load
            if ($('#transactionSelect').val() == '6') {
                $('#transactionOtherNoteContainer').show();
            }
        });
    </script>
@endsection
