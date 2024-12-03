@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Update {{ isset($travel->title) ? $travel->title : '----' }} Info</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.travels-index') }}">Travels</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Update Travel Info</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Create --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.travels-create') }}" class="btn btn-dark">
                            <i data-feather="plus" class="fill-white feather-sm"></i> Add New Travel
                        </a>
                    </div>
                    {{-- Show --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.travels-show', isset($travel->id) ? $travel->id : -1) }}"
                            class="btn btn-primary">
                            <i data-feather="eye" class="fill-white feather-sm"></i> View Travel
                        </a>
                    </div>
                    {{-- Delete --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.travels-destroy', isset($travel->id) ? $travel->id : -1) }}"
                            class="confirm btn btn-danger">
                            <i data-feather="trash" class="fill-white feather-sm"></i> Delete Travel
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
                        <h4 class="card-title mb-3 pb-3 border-bottom">Update Travels Info :</h4>
                        <form action="{{ route('super_admin.travels-update', isset($travel->id) ? $travel->id : -1) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">

                                {{-- title --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="title"
                                            class="form-control border border-info @error('title') border-danger @enderror"
                                            id="tb-title" value="{{ isset($travel->title) ? $travel->title : null }}"
                                            placeholder="Title">
                                        <label for="tb-title">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i> Title
                                            <strong class="text-danger">
                                                @error('title')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- date --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="date" name="date"
                                            class="form-control border border-info @error('date') border-danger @enderror"
                                            id="tb-date" value="{{ isset($travel->date) ? $travel->date : null }}"
                                            placeholder="Date">
                                        <label for="tb-date">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i> Date
                                            <strong class="text-danger">
                                                @error('date')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- distance --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="distance"
                                            class="form-control border border-info @error('distance') border-danger @enderror"
                                            id="tb-distance"
                                            value="{{ isset($travel->distance) ? $travel->distance : null }}"
                                            placeholder="Travel">
                                        <label for="tb-distance">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i> Travel
                                            <strong class="text-danger">
                                                @error('distance')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                        </label>
                                    </div>
                                </div>

                                {{-- user_id --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                            <select name="user_id"
                                                class="form-control form-select border border-info @error('user_id') border-danger @enderror custom_select_style">
                                                @if (isset($users) && $users->count() > 0)
                                                    <option value="">--- Select Employee Name --- </option>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}"
                                                            @if ($user->id == $travel->user_id) selected @endif>
                                                            {{ $user->name ?? '------' }}
                                                        </option>
                                                    @endforeach
                                                @else
                                                    <option value="">
                                                        No Employees Please Check With Admin
                                                    </option>
                                                @endif
                                            </select>
                                            <label for="tb-name">
                                                <strong class="text-danger">
                                                    @error('user_id')
                                                        ( {{ $message }} )
                                                    @enderror
                                                </strong>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                {{-- Status --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                            <select name="status"
                                                class="form-control form-select border border-info @error('status') border-danger @enderror custom_select_style">
                                                <option>--- Choose Status ---</option>
                                                <option value="1" @if ($travel->status == 'Paid') selected @endif
                                                    @if ($travel->status == null) selected @endif>Paid </option>
                                                <option value="2" @if ($travel->status == 'UnPaid') selected @endif>
                                                    UnPaid </option>
                                            </select>
                                            <label for="tb-name">
                                                <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                                Status
                                                <strong class="text-danger">
                                                    @error('status')
                                                        ( {{ $message }} )
                                                    @enderror
                                                </strong>
                                            </label>
                                        </div>
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
            $('select[name="user_id"]').select2();
        });
    </script>
@endsection
