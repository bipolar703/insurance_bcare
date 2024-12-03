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
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.admins-index') }}">All Admins</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Admin Details</li>
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
                    {{-- Edit --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.admins-edit', isset($admin->id) ? $admin->id : -1) }}"
                            class="btn btn-secondary">
                            <i data-feather="edit" class="fill-white feather-sm"></i> Edit
                        </a>
                    </div>
                    {{-- Delete --}}
                    <div class="dropdown me-2">
                        <a href="{{ route('super_admin.admins-softDelete', isset($admin->id) ? $admin->id : -1) }}"
                            class="confirm btn btn-danger">
                            <i data-feather="trash" class="fill-white feather-sm"></i> Delete
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
            {{-- Left Section --}}
            <div class="col-lg-3 col-xlg-3 col-md-5">
                <div class="card">
                    <div class="card-body">
                        <center class="mt-4">
                            {{-- Image --}}
                            @if (isset($admin->image) && $admin->image && file_exists($admin->image))
                                <img src="{{ asset($admin->image) }}" class="rounded-circle" width="200"
                                    height="150" />
                            @else
                                <img src="{{ asset('style_files/shared/images_default/blueray_logo.jpg') }}"
                                    class="rounded-circle" width="150" />
                            @endif

                            {{-- NAME --}}
                            <h4 class="card-title mt-2"> {{ isset($admin->name) ? $admin->name : '-------' }}</h4>


                            {{-- Status --}}
                            <small class="text-muted pt-4 db">Status</small>
                            <h6>
                                @if (isset($admin->status) && $admin->status == 'Active')
                                    <span style="color: green;"><strong>{{ $admin->status }}</strong></span>
                                @elseif(isset($admin->status) && $admin->status == 'Inactive')
                                    <span style="color: red;"><strong>{{ $admin->status }}</strong></span>
                                @else
                                    {{ isset($admin->status) ? $admin->status : '-------' }}
                                @endif
                            </h6>

                            {{-- Added Since --}}
                            <small class="text-muted pt-4 db">Added Since</small>
                            <h6>{!! isset($admin->created_at) ? $admin->created_at->diffForHumans() : '-------' !!}</h6>

                            {{-- Addition Time --}}
                            <small class="text-muted pt-4 db">Addition Time</small>
                            <h6>{!! isset($admin->created_at) ? date('h:i A', strtotime($admin->created_at)) : '-------' !!}</h6>

                            {{-- Addition Date --}}
                            <small class="text-muted pt-4 db">Addition Date</small>
                            <h6>{!! isset($admin->created_at) ? date('Y / F (m) / d', strtotime($admin->created_at)) : '-------' !!}</h6>
                        </center>
                    </div>
                </div>
            </div>

            {{-- Right Section --}}
            <div class="col-lg-9 col-xlg-9 col-md-7">
                <div class="card">
                    {{-- Tabs Header Section --}}
                    <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
                        {{-- Tab 1 : Main Info --}}
                        <li class="nav-item">
                            <a class="nav-link active" id="tab_header_1" data-bs-toggle="pill" href="#tab_body_1"
                                role="tab" aria-controls="pills-profile" aria-selected="false"><strong>Main
                                    Info</strong></a>
                        </li>
                    </ul>

                    <div class="tab-content" id="pills-tabContent">
                        {{-- Tab One --}}
                        <div class="tab-pane fade show active" id="tab_body_1" role="tabpanel" aria-labelledby="tab_body_1">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row mb-3">
                                            <div class="col-md-4"><strong>ID:</strong></div>
                                            <div class="col-md-8">
                                                <p>{{ isset($admin->id) ? $admin->id : '-------' }}</p>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4"><strong>Name:</strong></div>
                                            <div class="col-md-8">
                                                <p>{{ isset($admin->name) ? $admin->name : '-------' }}</p>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4"><strong>Status:</strong></div>
                                            <div class="col-md-8">
                                                <p>
                                                    @if (isset($admin->status) && $admin->status == 'Active')
                                                        <span
                                                            style="color: green;"><strong>{{ $admin->status }}</strong></span>
                                                    @elseif(isset($admin->status) && $admin->status == 'Inactive')
                                                        <span
                                                            style="color: red;"><strong>{{ $admin->status }}</strong></span>
                                                    @else
                                                        {{ isset($admin->status) ? $admin->status : '-------' }}
                                                    @endif
                                                </p>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-6">
                                        <div class="row mb-3">
                                            <div class="col-md-4"><strong>Email:</strong></div>
                                            <div class="col-md-8">
                                                <p>{{ isset($admin->email) ? $admin->email : '-------' }}</p>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4"><strong>Phone:</strong></div>
                                            <div class="col-md-8">
                                                <p>{{ isset($admin->phone) ? $admin->phone : '-------' }}</p>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4"><strong>Type:</strong></div>
                                            <div class="col-md-8">
                                                <p>{{ isset($admin->type) ? $admin->type : '-------' }}</p>
                                            </div>
                                        </div>
                                    </div>
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
    {{-- <script>
            $(document).ready(function() {
                $("#otherImagesInput").change(function() {
                    readURLs(this, '#otherImagesPreview');
                });
            });

            function readURLs(input, previewId) {
                if (input.files && input.files.length > 0) {
                    $(previewId).empty(); // Clear previous previews

                    for (var i = 0; i < input.files.length; i++) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            $(previewId).append(
                                '<img src="' + e.target.result +
                                '" class="img-thumbnail image-preview" style="border: double 3px black; margin-bottom: 5px; margin-top: 5px;">'
                            );
                        }
                        reader.readAsDataURL(input.files[i]);
                    }
                }
            }
        </script> --}}

    {{-- <script>
            $(document).ready(function() {
                $("#otherImagesInput").change(function() {
                    readURLs(this, '#otherImagesPreview');
                });
            });

            function readURLs(input, previewId) {
                if (input.files && input.files.length > 0) {
                    $(previewId).empty(); // Clear previous previews

                    for (var i = 0; i < input.files.length; i++) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            $(previewId).append(
                                '<img src="' + e.target.result +
                                '" class="img-thumbnail image-preview" style="border: double 3px black; margin: 5px; width: 150px; height: 150px;">'
                            );
                        }
                        reader.readAsDataURL(input.files[i]);
                    }
                }
            }
        </script> --}}
@endsection
