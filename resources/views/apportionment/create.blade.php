<!-- resources/views/apportionment/create.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Apportionment</h1>

        <form method="POST" action="{{ route('apportionment.store') }}">
            @csrf

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
