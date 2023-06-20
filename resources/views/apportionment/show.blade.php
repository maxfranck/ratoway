<!-- resources/views/apportionment/show.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mt-4">{{ $apportionment->name }}</h2>
        <hr>
        <form method="POST" action="{{ route('apportionment.product.store', $apportionment->id) }}">
            @csrf

            <div class="form-group">
                <label for="product">Produtos</label>
                <select name="product_id" id="product" class="form-control" required>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }} {{ $product->flavor }} {{ $product->size }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="quantity">Quantidade</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <button class="btn btn-outline-secondary" type="button" id="decrement">-</button>
                    </div>
                    <input type="number" name="quantity" id="quantity" class="form-control" required min="1"
                        value="1">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="increment">+</button>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-4">Adicionar</button>
        </form>

        <hr>
        <h2>Valor Total: ${{ $apportionment->total }}</h2>
        <hr>
        <table class="table">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Valor</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($apportionment->products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->pivot->quantity }}</td>
                        <td>{{ $product->price }}</td>
                        <td>
                            <form method="POST"
                                action="{{ route('apportionment.product.destroy', [$apportionment->id, $product->id]) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Remover</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-between align-items-center">
            <form method="POST" action="{{ route('apportionment.destroy', [$apportionment->id]) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-warning">
                    << Voltar</button>
            </form>
            <a href="{{ route('apportionment.contributors', $apportionment->id) }}" class="btn btn-success">Continuar
                >></a>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Incrementar a quantidade
            $('#increment').click(function() {
                var quantity = parseInt($('#quantity').val());
                $('#quantity').val(quantity + 1);
            });

            // Decrementar a quantidade
            $('#decrement').click(function() {
                var quantity = parseInt($('#quantity').val());
                if (quantity > 1) {
                    $('#quantity').val(quantity - 1);
                }
            });
        });
    </script>
@endpush
