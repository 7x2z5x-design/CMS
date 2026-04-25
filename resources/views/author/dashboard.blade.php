@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Author Dashboard</h5>
                </div>
                <div class="card-body">
                    <p>Welcome, {{ auth()->user()->FullName ?? auth()->user()->Username }}! You are logged in as an Author.</p>
                    <p>As an Author, you can create and manage your blog posts.</p>
                    <a href="#" class="btn btn-primary">Create New Post</a>
                    <a href="#" class="btn btn-secondary">View My Posts</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection