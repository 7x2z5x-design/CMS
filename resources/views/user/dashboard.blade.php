@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>User Dashboard</h5>
                </div>
                <div class="card-body">
                    <p>Welcome, {{ auth()->user()->FullName ?? auth()->user()->Username }}! You are logged in as a User.</p>
                    <p>As a User, you can read blog posts and interact with the content.</p>
                    <a href="#" class="btn btn-primary">Browse Posts</a>
                    <a href="#" class="btn btn-secondary">My Profile</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection