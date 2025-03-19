@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Back Navigation -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ route('home') }}" class="text-decoration-none">
                    <i class="fas fa-arrow-left"></i> Back to Feed
                </a>
            </div>

            <!-- Post Card - Social Media Style -->
            <div class="card mb-4 post-container">
                <!-- Post Header -->
                <div class="card-header bg-white">
                    <div class="d-flex align-items-center">
                        <!-- Profile Picture Placeholder -->
                        @if($post->user->profile && $post->user->profile->photo_profile)
                            <img src="{{ asset('storage/' . $post->user->profile->photo_profile) }}"
                                class="rounded-circle me-2"
                                style="width: 40px; height: 40px; object-fit: cover;"
                                alt="{{ $post->user->name }}">
                        @else
                            <div class="rounded-circle bg-secondary text-white d-flex justify-content-center align-items-center me-2"
                                style="width: 40px; height: 40px;">
                                {{ substr($post->user->name, 0, 1) }}
                            </div>
                        @endif
                        <div>
                            <strong>{{ $post->user->name }}</strong>
                            <div class="text-muted small">{{ $post->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                </div>

                <!-- Post Image - Full Width -->
                <img src="{{ asset('storage/' . $post->photo_post) }}" class="card-img-top" alt="{{ $post->caption }}" style="max-height: 600px; object-fit: contain; background-color: #f8f9fa;">

                <!-- Post Actions -->
                <div class="card-body pb-1 pt-2 border-bottom">
                    <div class="d-flex gap-3">
                        <!-- Like Button Placeholder -->
                        <button class="btn btn-sm btn-outline-secondary">
                            <i class="far fa-heart"></i> Like
                        </button>

                        <!-- Comment Count -->
                        <button class="btn btn-sm btn-outline-secondary">
                            <i class="far fa-comment"></i> Comments ({{ $comments->count() }})
                        </button>

                        <!-- Add Comment Button - Triggers Modal -->
                        <button type="button" class="btn btn-sm btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#addCommentModal">
                            <i class="fas fa-plus-circle"></i> Add Comment
                        </button>
                    </div>
                </div>

                <!-- Post Caption -->
                <div class="card-body pt-3 pb-3">
                    <p class="mb-0 caption-text"><span class="username">{{ $post->user->name }}</span> {{ $post->caption }}</p>
                </div>

                <!-- Comments Section -->
                <div class="card-body pt-0 pb-2 px-3 bg-light">
                    <h6 class="text-muted py-2 mb-2 border-bottom">Comments</h6>

                    @if($comments->count() > 0)
                        <div class="comments-container" style="max-height: 400px; overflow-y: auto;">
                            @foreach($comments as $comment)
                                <div class="comment-item py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                                    <div class="d-flex">
                                        <!-- Comment Author Avatar Placeholder -->
                                        <div class="rounded-circle bg-light text-secondary d-flex justify-content-center align-items-center me-2 comment-avatar">
                                            {{ substr($comment->user->name, 0, 1) }}
                                        </div>

                                        <div class="flex-grow-1">
                                            <div class="instagram-comment">
                                                <span class="username">{{ $comment->user->name }}</span>
                                                <span class="comment-text">{{ $comment->text }}</span>

                                                <div class="comment-metadata">
                                                    <span class="comment-time">{{ $comment->created_at->diffForHumans(null, true) }}</span>

                                                    <!-- Comment Actions (only for owner) -->
                                                    @if(auth()->id() === $comment->user_id)
                                                        <button class="btn btn-link text-danger p-0 ms-2 delete-comment-btn"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#deleteCommentModal{{ $comment->id }}">
                                                            Delete
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Delete Comment Modal -->
                                    <div class="modal fade" id="deleteCommentModal{{ $comment->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Delete Comment</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete this comment?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <form action="{{ route('comment.destroy', $comment->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-3">
                            <p class="text-muted mb-0">No comments yet. Be the first to comment!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Comment Modal -->
<div class="modal fade" id="addCommentModal" tabindex="-1" aria-labelledby="addCommentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCommentModalLabel">Add Comment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('comment.store', $post) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <textarea class="form-control @error('text') is-invalid @enderror"
                                  name="text" id="text" rows="4"
                                  placeholder="Write your comment here..." required>{{ old('text') }}</textarea>
                        @error('text')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Post Comment</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Custom CSS for social media appearance */
    .post-container {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    /* Instagram-style comment formatting */
    .instagram-comment {
        font-size: 14px;
        line-height: 1.4;
        margin-bottom: 0;
    }

    .username {
        font-weight: 700; /* Bold weight for username */
        color: #262626;
        margin-right: 4px;
        font-size: 14px;
        display: inline-block; /* Ensures proper text flow */
    }

    .comment-text {
        color: #262626;
        font-size: 14px;
        font-weight: 400; /* Normal weight for comment text */
        word-wrap: break-word;
    }

    .comment-metadata {
        margin-top: 4px;
        font-size: 12px;
    }

    .comment-time {
        color: #8e8e8e;
    }

    .comment-avatar {
        width: 28px;
        height: 28px;
        font-size: 0.7rem;
        margin-top: 2px;
    }

    .caption-text {
        font-size: 14px;
        line-height: 1.4;
    }

    .comment-item {
        padding-top: 8px !important;
        padding-bottom: 8px !important;
        border-bottom-color: #efefef !important;
    }

    .delete-comment-btn {
        font-size: 12px;
        text-decoration: none;
    }

    /* Scrollbar styling */
    .comments-container::-webkit-scrollbar {
        width: 4px;
    }

    .comments-container::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .comments-container::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 2px;
    }

    /* Optimize for mobile */
    @media (max-width: 576px) {
        .comment-item {
            padding-left: 8px;
            padding-right: 8px;
        }
    }
</style>
@endsection
