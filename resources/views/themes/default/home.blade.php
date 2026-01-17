@extends('theme::layout')

@section('content')
    <div class="hero">
        <div class="container">
            <h1>Welcome to Ratannam Gold</h1>
            <p class="lead">Exquisite Jewelry for Every Occasion</p>
            <a href="#" class="btn btn-primary btn-lg">Shop Now</a>
        </div>
    </div>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Featured Products</h2>
        <div class="row">
            <!-- Dynamic products would loop here -->
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="https://via.placeholder.com/300" class="card-img-top" alt="Product">
                    <div class="card-body">
                        <h5 class="card-title">Gold Ring</h5>
                        <p class="card-text">₹ 25,000</p>
                        <a href="#" class="btn btn-outline-primary">View Details</a>
                    </div>
                </div>
            </div>
             <div class="col-md-4">
                <div class="card mb-4">
                    <img src="https://via.placeholder.com/300" class="card-img-top" alt="Product">
                    <div class="card-body">
                        <h5 class="card-title">Diamond Necklace</h5>
                        <p class="card-text">₹ 50,000</p>
                        <a href="#" class="btn btn-outline-primary">View Details</a>
                    </div>
                </div>
            </div>
             <div class="col-md-4">
                <div class="card mb-4">
                    <img src="https://via.placeholder.com/300" class="card-img-top" alt="Product">
                    <div class="card-body">
                        <h5 class="card-title">Gold Bangles</h5>
                        <p class="card-text">₹ 75,000</p>
                        <a href="#" class="btn btn-outline-primary">View Details</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
