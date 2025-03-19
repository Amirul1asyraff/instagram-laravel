@extends('layouts.app')



@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">{{ __('User Profile') }}</h4>
                    </div>



                    <div class="card-body p-4">
                        <form action="{{ route('profile.store', auth()->user()) }}" method="POST"
                            enctype="multipart/form-data" class="d-inline">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                            <!-- Profile Photo -->
                            <div class="text-center mb-4">
                                <div class="text-center mb-4">
                                    @if ($profile->exists && $profile->photo_profile)
                                    <img src="{{ asset('storage/' . $profile->photo_profile) }}" alt="Profile Photo"
                                        id="profile-preview" class="rounded-circle"
                                        style="width: 150px; height: 150px; object-fit: cover;">
                                     @else
                                     <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center mx-auto"
                                     style="width: 150px; height: 150px;">
                                     <span class="fs-2">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                         </div>
                                    <img id="profile-preview" class="d-none rounded-circle"
                                     style="width: 150px; height: 150px; object-fit: cover;">
                                    @endif

                                {{-- Hidden File Input --}}
                                <div class="mt-3">
                                    <input type="file" name="photo_profile" id="inputFile" class="form-control d-none" accept="image/*" onchange="previewImage(this)">
                                    <label for="inputFile" class="btn btn-outline-primary">
                                        <i class="fas fa-upload me-2"></i>Choose Photo
                                    </label>
                                    @error('attachment')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary mt-3">
                                    <i class="fas fa-save me-2"></i>Update Profile Picture
                                </button>
                            </div>



                            {{-- User Information Section --}}
                            <div class="user-info mt-4">
                                <div class="mb-4">
                                    <label for="name" class="form-label fw-bold">Name</label>
                                    <input type="text" class="form-control bg-light" id="name"
                                        value="{{ auth()->user()->name }}" readonly>
                                </div>



                                <div class="mb-4">
                                    <label for="email" class="form-label fw-bold">Email</label>
                                    <input type="email" class="form-control bg-light" id="email"
                                        value="{{ auth()->user()->email }}" readonly>
                                </div>



                                <div class="mb-4">
                                    <label for="created_at" class="form-label fw-bold">Member Since</label>
                                    <input type="text" class="form-control bg-light" id="created_at"
                                        value="{{ auth()->user()->created_at->format('F d, Y') }}" readonly>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    @push('styles')
        <style>
            .profile-picture-container {
                position: relative;
                width: 200px;
                height: 200px;
                border-radius: 50%;
                overflow: hidden;
                border: 3px solid #fff;
                box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
                transition: all 0.3s ease;
            }



            .profile-picture {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }



            .upload-overlay {
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                background: rgba(0, 0, 0, 0.5);
                padding: 10px;
                color: white;
                text-align: center;
                opacity: 0;
                transition: opacity 0.3s ease;
            }



            .profile-picture-container:hover .upload-overlay {
                opacity: 1;
            }



            .form-control:readonly {
                background-color: #f8f9fa;
                cursor: not-allowed;
            }



            .card {
                border: none;
                border-radius: 15px;
            }



            .card-header {
                border-radius: 15px 15px 0 0 !important;
            }
        </style>
    @endpush



    @push('scripts')
        <script>
            function previewImage(input) {
                if (input.files && input.files[0]) {
                    const reader = new FileReader();



                    reader.onload = function(e) {
                        document.getElementById('profile-preview').src = e.target.result;
                    }



                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>
    @endpush
@endsection
