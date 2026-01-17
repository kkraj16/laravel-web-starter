@extends('admin.layouts.app')

@section('title', 'Add Testimonial')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <form action="{{ route('admin.testimonials.store') }}" method="POST">
            @csrf
            
            <div class="card card-outline card-warning">
                <div class="card-header">
                    <h3 class="card-title fw-bold">New Testimonial Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.testimonials.index') }}" class="btn btn-tool" title="Back to List">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Customer Name -->
                    <div class="mb-4">
                        <label for="name" class="form-label text-uppercase fs-7 fw-bold text-muted">Customer Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="e.g. Anjali Sharma" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Review Date & Status -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="review_date" class="form-label text-uppercase fs-7 fw-bold text-muted">Review Date <span class="text-danger">*</span></label>
                            <input type="date" name="review_date" id="review_date" class="form-control @error('review_date') is-invalid @enderror" value="{{ old('review_date', date('Y-m-d')) }}" required>
                            @error('review_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-uppercase fs-7 fw-bold text-muted">Visibility</label>
                            <div class="form-check form-switch mt-1">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                                <label class="form-check-label fw-bold" for="is_active">Approve and Publish Immediately</label>
                            </div>
                        </div>
                    </div>

                    <!-- Rating -->
                    <div class="mb-4">
                        <label class="form-label text-uppercase fs-7 fw-bold text-muted">Rating <span class="text-danger">*</span></label>
                        <style>
                            .star-rating {
                                display: flex;
                                flex-direction: row-reverse;
                                justify-content: flex-end;
                            }
                            .star-rating input {
                                display: none;
                            }
                            .star-rating label {
                                font-size: 2rem;
                                color: #ddd;
                                cursor: pointer;
                                padding: 0 5px;
                                margin: 0;
                            }
                            /* Hover effects using row-reverse logic (next siblings are actually previous in visuals) */
                            .star-rating input:checked ~ label,
                            .star-rating label:hover,
                            .star-rating label:hover ~ label {
                                color: #ffc107;
                            }
                        </style>
                        <div class="d-flex align-items-center gap-3">
                            <div class="star-rating">
                                @for($i = 5; $i >= 1; $i--)
                                    <input type="radio" id="rating{{ $i }}" name="rating" value="{{ $i }}" {{ old('rating', 5) == $i ? 'checked' : '' }}>
                                    <label for="rating{{ $i }}" title="{{ $i }} stars">
                                        <i class="bi bi-star-fill"></i>
                                    </label>
                                @endfor
                            </div>
                            <small class="text-muted">(5 is Best, 1 is Worst)</small>
                        </div>
                        @error('rating')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Comment -->
                    <div class="mb-3">
                        <label for="content" class="form-label text-uppercase fs-7 fw-bold text-muted">Review / Comment <span class="text-danger">*</span></label>
                        <textarea name="content" id="content" rows="4" class="form-control @error('content') is-invalid @enderror" placeholder="Write the customer's feedback here..." required>{{ old('content') }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="card-footer text-end">
                    <a href="{{ route('admin.testimonials.index') }}" class="btn btn-link text-muted me-2 text-decoration-none">Cancel</a>
                    <button type="submit" class="btn btn-dark px-4">
                        <i class="bi bi-save me-1"></i> Save Testimonial
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
