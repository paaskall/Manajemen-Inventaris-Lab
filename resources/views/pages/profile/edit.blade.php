@extends('layouts.app')

@section('content')

@include('inc.alert')
<div class="container">
    <h1 class="text-decoration-underline">Edit Profile</h1>
    <a href="{{ route('profile') }}" class="btn btn-primary mt-3">Back</a>

    <div class="border p-4 mt-3">
        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $profile->name }}" required>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" value="{{ $profile->email }}" required>
            </div>
            <div class="mb-3">
                <label for="current_password" class="form-label">Current Password</label>
                <input type="password" name="current_password" class="form-control" placeholder="Enter current password if changing password">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">New Password</label>
                <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current password">
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Leave blank to keep current password">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
@endsection
