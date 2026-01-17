@extends('admin.layouts.app')

@section('title', 'Testimonials')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-outline card-warning">
            <div class="card-header">
                <h3 class="card-title">Customer Testimonials</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.testimonials.create') }}" class="btn btn-dark btn-sm">
                        <i class="bi bi-plus-lg"></i> Add New Testimonial
                    </a>
                </div>
            </div>
            
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 50px;">ID</th>
                                <th>Client Name</th>
                                <th style="width: 30%;">Review</th>
                                <th class="text-center">Rating</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Date</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($testimonials as $testimonial)
                            <tr>
                                <td>{{ $testimonial->id }}</td>
                                <td class="fw-bold">{{ $testimonial->name }}</td>
                                <td>
                                    <div class="text-truncate" style="max-width: 300px;" title="{{ $testimonial->content }}">
                                        {{ $testimonial->content }}
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="text-warning">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $testimonial->rating)
                                                <i class="bi bi-star-fill"></i>
                                            @else
                                                <i class="bi bi-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </td>
                                <td class="text-center">
                                    @if($testimonial->is_active)
                                        <span class="badge text-bg-success"><i class="bi bi-check-circle me-1"></i> Published</span>
                                    @else
                                        <span class="badge text-bg-secondary"><i class="bi bi-pause-circle me-1"></i> Pending</span>
                                    @endif
                                </td>
                                <td class="text-center text-muted small">
                                    {{ $testimonial->review_date->format('M d, Y') }}
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="btn btn-sm btn-outline-primary me-1" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                            onclick="confirmDelete('{{ route('admin.testimonials.destroy', $testimonial) }}', 'Are you sure you want to delete this specific review from {{ addslashes($testimonial->name) }}?')" 
                                            title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-chat-quote fs-1 d-block mb-3"></i>
                                    No testimonials found. Click 'Add New' to create one.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="card-footer clearfix">
                {{ $testimonials->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
