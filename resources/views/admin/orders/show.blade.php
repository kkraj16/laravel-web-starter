@extends('admin.layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Invoice Header -->
            <div class="callout callout-info mb-4">
                <h5><i class="bi bi-info-circle-fill"></i> Order #{{ $order->order_number }}</h5>
                This page has been enhanced for printing. Click the print button at the bottom of the invoice to test.
            </div>

            <!-- Invoice Content -->
            <div class="invoice p-3 mb-3 border rounded bg-white shadow-sm">
                <!-- title row -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h4>
                            <i class="bi bi-globe"></i> {{ config('app.name', 'Ratannam Gold') }}
                            <small class="float-end text-muted">Date: {{ $order->created_at->format('d/m/Y') }}</small>
                        </h4>
                    </div>
                </div>
                <!-- info row -->
                <div class="row invoice-info mb-4">
                    <div class="col-sm-4 invoice-col">
                        From
                        <address>
                            <strong>{{ config('app.name', 'Ratannam Gold') }}</strong><br>
                            Headquarters<br>
                            Phone: +91 99999 99999<br>
                            Email: admin@example.com
                        </address>
                    </div>
                    <div class="col-sm-4 invoice-col">
                        To
                        <address>
                            <strong>{{ $order->customer->full_name }}</strong><br>
                            {{ $order->customer->address ?? 'No Address' }}<br>
                            {{ $order->customer->city ?? '-' }}<br>
                            Phone: {{ $order->customer->phone ?? '-' }}<br>
                            Email: {{ $order->customer->email }}
                        </address>
                    </div>
                    <div class="col-sm-4 invoice-col">
                        <b>Order #{{ $order->order_number }}</b><br>
                        <br>
                        <b>Payment Status:</b> <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }}">{{ ucfirst($order->payment_status) }}</span><br>
                        <b>Order Status:</b> <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                    </div>
                </div>

                <!-- Table row -->
                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Qty</th>
                                    <th>Product</th>
                                    <th>Serial #</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $item->product_name }}</td>
                                        <td>{{ $item->product->id ?? '-' }}</td>
                                        <td>${{ number_format($item->subtotal, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-6">
                        <p class="lead">Update Status:</p>
                        <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="p-3 bg-light rounded border">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Order Status</label>
                                <select name="status" class="form-select">
                                    @foreach(['pending', 'processing', 'shipped', 'completed', 'cancelled'] as $status)
                                        <option value="{{ $status }}" {{ $order->status == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Payment Status</label>
                                <select name="payment_status" class="form-select">
                                    @foreach(['pending', 'paid', 'failed'] as $status)
                                        <option value="{{ $status }}" {{ $order->payment_status == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm btn-block">
                                <i class="bi bi-save"></i> Update Order
                            </button>
                        </form>
                    </div>

                    <div class="col-6">
                        <p class="lead">Amount Due {{ $order->created_at->format('d/m/Y') }}</p>

                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th style="width:50%">Subtotal:</th>
                                    <td>${{ number_format($order->total_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Tax (0%)</th>
                                    <td>$0.00</td>
                                </tr>
                                <tr>
                                    <th>Shipping:</th>
                                    <td>$0.00</td>
                                </tr>
                                <tr>
                                    <th>Total:</th>
                                    <td>${{ number_format($order->total_amount, 2) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- this row will not appear when printing -->
                <div class="row no-print mt-4">
                    <div class="col-12">
                        <a href="javascript:window.print()" class="btn btn-default"><i class="bi bi-printer"></i> Print</a>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary float-end px-3">Back to Orders</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
