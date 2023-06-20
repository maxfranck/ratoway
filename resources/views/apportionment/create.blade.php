<!-- resources/views/apportionment/create.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mt-4 mb-4">Cadastrar Rateio</h2>
        <hr>
        <form method="POST" action="{{ route('apportionment.store') }}">
            @csrf

            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" name="name" id="name" class="form-control mb-4" required>
            </div>

            <button type="submit" class="btn btn-success">Salvar</button>
        </form>
    </div>
@endsection
