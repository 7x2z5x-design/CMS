@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Editor Dashboard</h5>
                </div>
                <div class="card-body">
                    <p>Welcome, {{ auth()->user()->FullName ?? auth()->user()->Username }}! You are logged in as an Editor.</p>
                    <p>As an Editor, you can review and edit blog posts.</p>
                    <a href="#" class="btn btn-primary">Review Pending Posts</a>
                    <a href="#" class="btn btn-secondary">Published Posts</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection