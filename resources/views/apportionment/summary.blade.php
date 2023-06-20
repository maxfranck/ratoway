<!-- resources/views/apportionment/summary.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Summary for Apportionment {{ $apportionment->name }}</h1>

        <h2>Apportionment Products</h2>
        <ul>
            @foreach ($apportionmentProducts as $product)
                <li>{{ $product->name }} - Quantity: {{ $product->pivot->quantity }}</li>
            @endforeach
        </ul>

        <h2>Contributors</h2>
        <ul>
            @foreach ($contributors as $contributor)
                <li>{{ $contributor->name }}</li>
            @endforeach
        </ul>

        @if ($apportionment->apart)
            <p>Valor Abatido: R$ {{ $apportionment->apart }}</p>
        @else
            <form method="POST" action="{{ route('apportionment.abater', $apportionment->id) }}">
                @csrf
                <div class="form-group">
                    <label for="apart">Abater Valor:</label>
                    <input type="number" step="0.01" name="apart" id="apart" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Abater</button>
            </form>
        @endif

        <p>Total Price: {{ $apportionment->total }}</p>
        <p>Pedaços: {{ $pedacos }}</p>
        <p>Pagar: R$ {{ $apportionment->total / $contributors->where('apportionment_id', $apportionment->id)->count() }}</p>

        <a href="{{ route('apportionment.final', $apportionment->id) }}" class="btn btn-primary">Final</a>
    </div>
@endsection
