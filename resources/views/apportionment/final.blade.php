<!-- resources/views/apportionment/final.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Rateio</h1>
        <p>Valor Total: {{ $apportionment->total }}</p>

        <h2>Contributors</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($apportionment->contributors as $contributor)
                    <tr>
                        <td>{{ $contributor->name }}</td>
                        <td>
                            <form method="POST" action="{{ route('contributor.pago', $contributor->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-success">Pago</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
