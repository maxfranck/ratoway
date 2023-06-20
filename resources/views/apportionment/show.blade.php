<!-- resources/views/apportionment/show.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Apportionment Details</h1>

        <p><strong>Name:</strong> {{ $apportionment->name }}</p>
        <p><strong>User ID:</strong> {{ $apportionment->user_id }}</p>

        <hr>

        <h2>Add Product</h2>

        <form method="POST" action="{{ route('apportionment.product.store', $apportionment->id) }}">
            @csrf

            <div class="form-group">
                <label for="product">Product</label>
                <select name="product_id" id="product" class="form-control" required>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" name="quantity" id="quantity" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Add</button>
        </form>

        <hr>

        <h2>Total Price: ${{ $apportionment->total }}</h2>

        <h2>Items</h2>

        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Action</th>
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
                                <button type="submit" class="btn btn-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ route('apportionment.contributors', $apportionment->id) }}" class="btn btn-primary">View
            Contributors</a>
    </div>
@endsection
