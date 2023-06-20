<!-- resources/views/apportionment/contributors.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mt-4">Contribuidores</h2>
        <hr>
        <form method="POST" action="{{ route('apportionment.contributors.store', $apportionment->id) }}">
            @csrf

            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary mt-4">Adicionar</button>
        </form>

        <hr>

        <table class="table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Ação</th>
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
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('apportionment.show', $apportionment->id) }}" class="btn btn-warning ">
                << Voltar</a>
                    <a href="{{ route('apportionment.summary', $apportionment->id) }}" class="btn btn-success">Continuar
                        >></a>
        </div>
    </div>
@endsection
