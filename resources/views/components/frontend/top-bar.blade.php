@php
    use App\Models\Setting;
    $showGoldPrices = Setting::get('show_gold_prices', 1);
    $showSilverPrices = Setting::get('show_silver_prices', 1);
    $rateGold24k = Setting::get('rate_gold_24k', '76,500');
    $rateGold22k = Setting::get('rate_gold_22k', '71,200');
    $rateSilver = Setting::get('rate_silver', '92,500');
@endphp

<style>
    @keyframes ticker {
        0% {
            transform: translate(100%);
        }
        100% {
            transform: translate(-100%);
        }
    }

    .ticker-container {
        position: relative;
        height: 2.5rem;
        background-color: #000000;
        border-bottom: 1px solid rgb(31 41 55);
        overflow: hidden;
    }

    .ticker-badge {
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        display: flex;
        align-items: center;
        padding-left: 1.5rem;
        padding-right: 3rem;
        background: linear-gradient(to right, #000000 70%, transparent);
        z-index: 10;
    }

    .ticker-content {
        display: flex;
        align-items: center;
        height: 100%;
        white-space: nowrap;
        animation: ticker 30s linear infinite;
        gap: 3rem;
        padding: 0 3rem;
    }

    .ticker-content:hover {
        animation-play-state: paused;
    }

    .ticker-item {
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
        font-size: 0.625rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: #ffffff;
        text-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
    }

    .ticker-label {
        color: rgb(220 220 220);
        font-weight: 500;
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.5);
    }

    .ticker-value {
        color: rgb(250 204 21);
        font-weight: 800;
        font-size: 0.75rem;
        text-shadow: 0 0 20px rgba(250, 204, 21, 0.6), 0 2px 4px rgba(0, 0, 0, 0.9);
    }

    .ticker-separator {
        color: rgb(200 155 60);
        font-size: 0.75rem;
        opacity: 0.6;
    }
</style>

<div class="ticker-container">
    <!-- Fixed Live Market Badge -->
    <div class="ticker-badge">
        <span class="text-primary font-bold flex items-center text-[10px] uppercase tracking-widest">
            <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-2 animate-pulse shadow-lg shadow-green-500/50"></span>
            Live Market
        </span>
    </div>

    <!-- Scrolling Ticker Content -->
    <div class="ticker-content">
        <!-- First Set -->
        @if($showGoldPrices)
        <span class="ticker-item">
            <span class="ticker-label">Gold 24K</span>
            <span class="ticker-value">₹{{ number_format($rateGold24k) }}</span>
        </span>
        <span class="ticker-separator">|</span>

        <span class="ticker-item">
            <span class="ticker-label">Gold 22K</span>
            <span class="ticker-value">₹{{ number_format($rateGold22k) }}</span>
        </span>
        <span class="ticker-separator">|</span>
        @endif

        @if($showSilverPrices)
        <span class="ticker-item">
            <span class="ticker-label">Silver</span>
            <span class="ticker-value">₹{{ number_format($rateSilver) }}</span>
        </span>
        <span class="ticker-separator">|</span>
        @endif

        <span class="ticker-item" style="color: rgb(250 204 21); font-weight: 600; text-shadow: 0 0 12px rgba(250, 204, 21, 0.4);">
            ✨ New Collection Launch - Exclusive Traditional Designs
        </span>
        <span class="ticker-separator">|</span>

        <span class="ticker-item" style="color: rgb(96 165 250); font-weight: 600; text-shadow: 0 0 12px rgba(96, 165, 250, 0.4);">
            💍 100% Certified Hallmarked Jewellery
        </span>
        <span class="ticker-separator">|</span>

        <!-- Duplicate for seamless loop -->
        @if($showGoldPrices)
        <span class="ticker-item">
            <span class="ticker-label">Gold 24K</span>
            <span class="ticker-value">₹{{ number_format($rateGold24k) }}</span>
        </span>
        <span class="ticker-separator">|</span>

        <span class="ticker-item">
            <span class="ticker-label">Gold 22K</span>
            <span class="ticker-value">₹{{ number_format($rateGold22k) }}</span>
        </span>
        <span class="ticker-separator">|</span>
        @endif

        @if($showSilverPrices)
        <span class="ticker-item">
            <span class="ticker-label">Silver</span>
            <span class="ticker-value">₹{{ number_format($rateSilver) }}</span>
        </span>
        <span class="ticker-separator">|</span>
        @endif

        <span class="ticker-item" style="color: rgb(250 204 21); font-weight: 600; text-shadow: 0 0 12px rgba(250, 204, 21, 0.4);">
            ✨ New Collection Launch - Exclusive Traditional Designs
        </span>
        <span class="ticker-separator">|</span>

        <span class="ticker-item" style="color: rgb(96 165 250); font-weight: 600; text-shadow: 0 0 12px rgba(96, 165, 250, 0.4);">
            💍 100% Certified Hallmarked Jewellery
        </span>
        <span class="ticker-separator">|</span>
    </div>
</div>
