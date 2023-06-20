<!-- resources/views/apportionment/contributors.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Contributors for Apportionment {{ $apportionment->id }}</h1>

        <form method="POST" action="{{ route('apportionment.contributors.store', $apportionment->id) }}">
            @csrf

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Save Contributor</button>
        </form>

        <hr>

        <h2>Contributors List</h2>

        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($apportionment->contributors as $contributor)
                    <tr>
                        <td>{{ $contributor->name }}</td>
                        <td>
                            <form method="POST"
                                action="{{ route('apportionment.contributors.destroy', [$apportionment->id, $contributor->id]) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ route('apportionment.summary', $apportionment->id) }}" class="btn btn-primary">View Summary</a>
    </div>
@endsection
