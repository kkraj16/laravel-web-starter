@extends('admin.layouts.app')

@section('title', 'Market Prices')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-warning text-dark">
                <h3 class="card-title fw-bold"><i class="bi bi-currency-exchange me-2"></i>Live Market Rates</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.settings.update-rates') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label text-uppercase fs-7 fw-bold text-muted">Gold 24K (Per 10g)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light fw-bold">₹</span>
                            <input type="number" step="0.01" name="rate_gold_24k" class="form-control form-control-lg" value="{{ $settings['rate_gold_24k'] ?? '' }}" placeholder="0.00">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-uppercase fs-7 fw-bold text-muted">Gold 22K (Per 10g)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light fw-bold">₹</span>
                            <input type="number" step="0.01" name="rate_gold_22k" class="form-control form-control-lg" value="{{ $settings['rate_gold_22k'] ?? '' }}" placeholder="0.00">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-uppercase fs-7 fw-bold text-muted">Silver (Per 1kg)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light fw-bold">₹</span>
                            <input type="number" step="0.01" name="rate_silver" class="form-control form-control-lg" value="{{ $settings['rate_silver'] ?? '' }}" placeholder="0.00">
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-warning w-100 fw-bold py-2">Update Market Rates</button>
                    <div class="text-center mt-3">
                        <small class="text-muted fst-italic"><i class="bi bi-info-circle me-1"></i> Rates update globally across the ticker in real-time.</small>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
