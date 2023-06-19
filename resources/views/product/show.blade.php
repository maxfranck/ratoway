@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9" style="display:flex">
                <div class="container m-2 p-2">
                    <img src="/images/{{ $product->image }}" height="450px" alt="...">
                    <div class="container m-2 p-2">
                        <h2>{{ $product->name }} {{ $product->flavor }} {{ $product->size }}</h2>
                        <hr>
                        <p><b>Valor:</b> ${{ $product->price }}</p>
                        <p><b>Pedaços:</b> {{ $product->pieces }}</p>
                        <p><b>Descrição:</b> {{ $product->description }}</p>
                        <hr>
                        <a href="{{ route('product.index') }}" class="btn btn-primary">Voltar</a>
                        <a href="{{ route('product.edit', $product->id) }}" class="btn btn-warning">Editar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
