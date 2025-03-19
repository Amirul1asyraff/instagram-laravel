@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card-header">{{ __('Create your Post') }}</div>
                    <!-- Back Navigation -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <a href="{{ route('home') }}" class="text-decoration-none">
                            <i class="fas fa-arrow-left"></i> Back to Feed
                        </a>
                    </div>
                <div class="card">
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group mb-4">
                                <label for="photo_post" class="mb-2">Photo</label>
                                <input type="file" class="form-control @error('photo_post') is-invalid @enderror"
                                    name="photo_post" id="photo_post" accept="image/*" required>
                                @error('photo_post')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label for="caption" class="mb-2">Caption</label>
                                <textarea class="form-control @error('caption') is-invalid @enderror" name="caption" id="caption" rows="3"
                                    placeholder="Say anything that comes to mind">{{ old('caption') }}</textarea>
                                @error('caption')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Create Post</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
