@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Add Travel</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.travels-index') }}">Travels</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add New</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    {{-- Archive --}}
                    {{-- <div class="dropdown me-2">
                        <a href="{{ route('super_admin.travels-showSoftDelete') }}" class="btn btn-danger">
                            <i data-feather="archive" class="fill-white feather-sm"></i> View Archive travels
                        </a>
                    </div> --}}
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
                        <form action="{{ route('super_admin.travels-store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">

                                {{-- title --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="title"
                                            class="form-control border border-info @error('title') border-danger @enderror"
                                            id="tb-title" value="{{ old('title') }}" placeholder="Title">
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
                                            id="tb-date" value="{{ old('date') }}" placeholder="Date">
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
                                        <input type="number" name="distance" min="0" step="0.01"
                                            class="form-control border border-info @error('distance') border-danger @enderror"
                                            id="tb-distance" value="{{ old('distance') }}" placeholder="Distance">
                                        <label for="tb-distance">
                                            <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>
                                            Distance
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
                                            <strong class="text-danger">
                                                @error('user_id')
                                                    ( {{ $message }} )
                                                @enderror
                                            </strong>
                                            <select name="user_id"
                                                class="form-control form-select border border-info @error('user_id') border-danger @enderror custom_select_style">
                                                @if (isset($users) && $users->count() > 0)
                                                    <option value="">Select Employee Name</option>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}"
                                                            @if (old('user_id') == $user->id) selected @endif>
                                                            {{ isset($user->name) ? $user->name : '------' }}
                                                        </option>
                                                    @endforeach
                                                @else
                                                    <option value="">No Employees Are Available</option>
                                                @endif
                                            </select>
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
                                                    <i data-feather="plus" class="feather-sm fill-white me-2"></i>
                                                    Add New Travel
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
