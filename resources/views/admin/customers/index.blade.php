@extends('admin.layouts.app')

@section('title', 'Customers')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title fw-bold">Customer List</h3>
                <div class="card-tools">
                    <form action="{{ route('admin.customers.index') }}" method="GET" class="input-group input-group-sm" style="width: 250px;">
                        <input type="text" name="search" class="form-control float-right" placeholder="Search customers..." value="{{ request('search') }}">
                        <div class="input-group-append">
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
                            <th>#</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>City</th>
                            <th>Orders</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers as $customer)
                            <tr>
                                <td>{{ $customer->id }}</td>
                                <td class="fw-bold">{{ $customer->full_name }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->phone ?? 'N/A' }}</td>
                                <td>{{ $customer->city ?? '-' }}</td>
                                <td><span class="badge bg-secondary">{{ $customer->orders_count }}</span></td>
                                <td>
                                    @if($customer->is_vip)
                                        <span class="badge bg-warning text-dark"><i class="bi bi-star-fill"></i> VIP</span>
                                    @else
                                        <span class="badge bg-light text-dark border">Regular</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-sm btn-info text-white" title="View Profile">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">
                                    <i class="bi bi-people display-6 d-block mb-2"></i>
                                    No customers found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                {{ $customers->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
