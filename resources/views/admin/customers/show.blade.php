@extends('admin.layouts.app')

@section('title', 'Customer Profile')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <div class="avatar-initial rounded-circle bg-primary text-white fs-1 d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 100px; height: 100px;">
                        {{ substr($customer->first_name, 0, 1) }}
                    </div>
                </div>

                <h3 class="profile-username text-center">{{ $customer->full_name }}</h3>
                <p class="text-muted text-center">{{ $customer->city ?? 'Unknown City' }}</p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Email</b> <a class="float-right text-decoration-none">{{ $customer->email }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Phone</b> <a class="float-right text-decoration-none">{{ $customer->phone ?? '-' }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Joined</b> <a class="float-right text-decoration-none">{{ $customer->created_at->format('M d, Y') }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Status</b> 
                        <a class="float-right">
                             @if($customer->is_vip)
                                <span class="badge bg-warning text-dark">VIP</span>
                            @else
                                <span class="badge bg-light text-dark border">Regular</span>
                            @endif
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card card-outline card-secondary">
            <div class="card-header p-2">
                <h3 class="card-title fw-bold p-1">Order History</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customer->orders as $order)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order) }}" class="fw-bold text-decoration-none">
                                        #{{ $order->order_number }}
                                    </a>
                                </td>
                                <td>{{ $order->created_at->format('M d, Y') }}</td>
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
                                <td>${{ number_format($order->total_amount, 2) }}</td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-light border">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
