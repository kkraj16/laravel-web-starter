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
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="mb-3 text-uppercase fs-7 fw-bold text-muted">
                                <i class="bi bi-gem me-2"></i>Gold Rates (Per 10g)
                            </h5>
                        </div>
                        <div class="col-md-12 mb-4">
                            <label class="form-label text-uppercase fs-7 fw-bold text-primary">Gold 24K (Base Rate)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white fw-bold">₹</span>
                                <input type="number" step="0.01" name="rate_gold_24k" id="rate_gold_24k" class="form-control form-control-lg border-primary" value="{{ $settings['rate_gold_24k'] ?? '' }}" placeholder="0.00">
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-uppercase fs-8 fw-bold text-muted">Gold 22K</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light">₹</span>
                                <input type="text" id="display_gold_22k" class="form-control bg-light" value="{{ $settings['rate_gold_22k'] ?? '0.00' }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-uppercase fs-8 fw-bold text-muted">Gold 18K</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light">₹</span>
                                <input type="text" id="display_gold_18k" class="form-control bg-light" value="{{ $settings['rate_gold_18k'] ?? '0.00' }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-uppercase fs-8 fw-bold text-muted">Gold 14K</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light">₹</span>
                                <input type="text" id="display_gold_14k" class="form-control bg-light" value="{{ $settings['rate_gold_14k'] ?? '0.00' }}" readonly>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="mb-3 text-uppercase fs-7 fw-bold text-muted">
                                <i class="bi bi-shield-shaded me-2"></i>Silver Rates
                            </h5>
                        </div>
                        <div class="col-md-12 mb-4">
                            <label class="form-label text-uppercase fs-7 fw-bold text-secondary">Silver (Per 1kg - Base)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-secondary text-white fw-bold">₹</span>
                                <input type="number" step="0.01" name="rate_silver" id="rate_silver" class="form-control form-control-lg border-secondary" value="{{ $settings['rate_silver'] ?? '' }}" placeholder="0.00">
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label text-uppercase fs-8 fw-bold text-muted">Silver (Per 100g)</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light">₹</span>
                                <input type="text" id="display_silver_100g" class="form-control bg-light" value="{{ $settings['rate_silver_100g'] ?? '0.00' }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-uppercase fs-8 fw-bold text-muted">Silver (Per 10g)</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light">₹</span>
                                <input type="text" id="display_silver_10g" class="form-control bg-light" value="{{ $settings['rate_silver_10g'] ?? '0.00' }}" readonly>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h5 class="mb-3 text-uppercase fs-7 fw-bold text-muted">
                        <i class="bi bi-eye me-2"></i>Visibility Settings
                    </h5>
                    
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="showGoldPrices" name="show_gold_prices" value="1" {{ ($settings['show_gold_prices'] ?? 1) ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="showGoldPrices">
                                Show Gold Prices in Ticker
                            </label>
                            <small class="d-block text-muted mt-1">Display Gold 24K and 22K rates in the top price ticker</small>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="showSilverPrices" name="show_silver_prices" value="1" {{ ($settings['show_silver_prices'] ?? 1) ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="showSilverPrices">
                                Show Silver Prices in Ticker
                            </label>
                            <small class="d-block text-muted mt-1">Display Silver rates in the top price ticker</small>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="form-check form-switch p-3 bg-light rounded border">
                            <input class="form-check-input ms-0 me-2" type="checkbox" id="hidePrices" name="hide_prices" value="1" {{ ($settings['hide_prices'] ?? 0) ? 'checked' : '' }} style="margin-left: -2em;">
                            <label class="form-check-label fw-bold text-danger" for="hidePrices">&nbsp;&nbsp;&nbsp;Hide All Prices Globally</label>
                            <small class="d-block mt-1 ms-4 text-muted">When enabled, all product prices will be hidden across the website. Customers will see "Price on Request" instead.</small>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-warning w-100 fw-bold py-2">Update Market Rates</button>
                    <div class="text-center mt-3">
                        <small class="text-muted fst-italic"><i class="bi bi-info-circle me-1"></i> Rates update globally across the ticker in real-time.</small>
                    </div>
                </form>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const gold24kInput = document.getElementById('rate_gold_24k');
                        const silver1kgInput = document.getElementById('rate_silver');

                        const displayGold22k = document.getElementById('display_gold_22k');
                        const displayGold18k = document.getElementById('display_gold_18k');
                        const displayGold14k = document.getElementById('display_gold_14k');

                        const displaySilver100g = document.getElementById('display_silver_100g');
                        const displaySilver10g = document.getElementById('display_silver_10g');

                        function updateGoldRates() {
                            const val = parseFloat(gold24kInput.value) || 0;
                            displayGold22k.value = ((val * 22) / 24).toFixed(2);
                            displayGold18k.value = ((val * 18) / 24).toFixed(2);
                            displayGold14k.value = ((val * 14) / 24).toFixed(2);
                        }

                        function updateSilverRates() {
                            const val = parseFloat(silver1kgInput.value) || 0;
                            displaySilver100g.value = (val / 10).toFixed(2);
                            displaySilver10g.value = (val / 100).toFixed(2);
                        }

                        gold24kInput.addEventListener('input', updateGoldRates);
                        silver1kgInput.addEventListener('input', updateSilverRates);
                    });
                </script>
            </div>
        </div>
    </div>
</div>
@endsection
