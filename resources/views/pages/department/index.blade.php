@extends('layouts.app')

@section('content')

@include('inc.alert')
<div class="container">
    <h1 class="text-decoration-underline">List of Room</h1>
    <a href="{{ route('department.showAdd') }}" class="btn btn-primary mt-3">Add new Room</a>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Room Name</th>
                <th scope="col">Location</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($departments as $department)
            <tr>
                <th scope="row">{{ $department->id }}</th>
                <td>{{ $department->name }}</td>
                <td>Kampus {{ $department->location }}</td>
                <td>
                    <a href="{{ route('department.destroy', ['id' => $department->id]) }}"
                        class="btn btn-danger">Delete</a>
                    <a href="{{ route('department.showEdit', ['id' => $department->id]) }}"
                        class="btn btn-warning">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
