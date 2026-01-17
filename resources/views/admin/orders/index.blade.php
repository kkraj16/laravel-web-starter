@extends('admin.layouts.app')

@section('title', 'Orders')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title fw-bold">Order Management</h3>
                <div class="card-tools">
                    <form action="{{ route('admin.orders.index') }}" method="GET" class="d-flex align-items-center">
                        <select name="status" class="form-select form-select-sm me-2" style="width: 150px;" onchange="this.form.submit()">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        <div class="input-group input-group-sm" style="width: 200px;">
                            <input type="text" name="search" class="form-control" placeholder="Order #" value="{{ request('search') }}">
                            <button type="submit" class="btn btn-default">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Payment</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td class="fw-bold font-monospace">#{{ $order->order_number }}</td>
                                <td>
                                    @if($order->customer)
                                        <a href="{{ route('admin.customers.show', $order->customer) }}" class="text-dark text-decoration-none">
                                            {{ $order->customer->full_name }}
                                        </a>
                                    @else
                                        <span class="text-muted">Guest</span>
                                    @endif
                                </td>
                                <td>{{ $order->created_at->format('M d, Y H:i') }}</td>
                                <td class="fw-bold">${{ number_format($order->total_amount, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ match($order->status) {
                                        'completed' => 'success',
                                        'pending' => 'warning',
                                        'cancelled' => 'danger',
                                        'processing' => 'info',
                                        default => 'secondary'
                                    } }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td>
                                     <span class="badge bg-{{ match($order->payment_status) {
                                        'paid' => 'success',
                                        'pending' => 'warning',
                                        'failed' => 'danger',
                                        default => 'secondary'
                                    } }}">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-primary" title="View Details">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="bi bi-cart-x display-6 d-block mb-2"></i>
                                    No orders found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                {{ $orders->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
