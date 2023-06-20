<!-- resources/views/apportionment/summary.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mt-4">Resumo</h2>
        <hr>
        <h4>Produtos</h4>
        <ul>
            @foreach ($apportionmentProducts as $product)
                <li>{{ $product->pivot->quantity }} - {{ $product->name }} {{ $product->flavor }} {{ $product->size }} -
                    <b>Valor:</b> R$ {{ number_format($product->pivot->quantity * $product->price, 2) }}
                </li>
            @endforeach
        </ul>
        <hr>
        <h4>Contribuidores</h4>
        <ul>
            @foreach ($contributors as $contributor)
                <li>{{ $contributor->name }}</li>
            @endforeach
        </ul>
        <hr>
        <h4>Abater Valor</h4>
        @if ($apportionment->apart)
            <p>Valor Abatido: R$ {{ $apportionment->apart }}</p>
        @else
            <form method="POST" action="{{ route('apportionment.abater', $apportionment->id) }}">
                @csrf
                <div class="form-group">
                    <input type="number" step="0.01" name="apart" id="apart" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary mt-4">Abater</button>
            </form>
        @endif
        <hr>
        <p>
        <h5><b>Valor Total:</b> R$ {{ $apportionment->total }}</h5>
        </p>
        <p>
        <h5><b>Pedaços:</b> {{ $pedacos }} para cada</h5>
        </p>
        <p>
        <h5><b>Pagar:</b> R$ {{ $contributor->pay }}</h5>
        </p>
        <hr>
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('apportionment.contributors', $apportionment->id) }}" class="btn btn-warning ">
                << Voltar</a>
                    <a href="{{ route('apportionment.final', $apportionment->id) }}" class="btn btn-success">Continuar
                        >></a>
        </div>
    </div>
@endsection
