@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Dashboard') }}</span>
                    <a href="{{ route('post.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus mr-1"></i> {{ __('Create New Post') }}
                    </a>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>

                <div class="card-body">
                    @if(isset($posts) && count($posts) > 0)
                        <div class="row">
                            @foreach($posts as $post)
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100">
                                        <img src="{{ asset('storage/' . $post->photo_post) }}" class="card-img-top" alt="{{ $post->caption }}" style="height: 200px; object-fit: cover;">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ Str::limit($post->caption, 50) }}</h5>

                                            <!-- Action buttons -->
                                            <div class="d-flex justify-content-between mt-3">
                                                <!-- View Comments link -->
                                                <a href="{{ route('post.show', $post->id) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-comments"></i>
                                                    Comments ({{ $post->comments_count ?? 0 }})
                                                </a>

                                                <!-- Only show edit/delete to post owner -->
                                                @if(auth()->id() === $post->user_id)
                                                    <div>
                                                        <!-- Edit button -->
                                                        <a href="{{ route('post.edit', $post->id) }}" class="btn btn-sm btn-outline-secondary">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>

                                                        <!-- Delete button -->
                                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                                                data-bs-toggle="modal" data-bs-target="#deleteModal{{ $post->id }}">
                                                            <i class="fas fa-trash"></i> Delete
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="card-footer text-muted">
                                            Uploaded {{ $post->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal{{ $post->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $post->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $post->id }}">Confirm Deletion</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete this post? This action cannot be undone.
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <form action="{{ route('post.destroy', $post->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete Post</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center">No images uploaded yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
