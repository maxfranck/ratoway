@extends('layouts.app')

@section('content')
    <form action="/apportionment/select" method="POST">
        @csrf
        <div class="container mt-5">
            <h2>Seleção de produtos:</h2>
            <div class="form-group">
                <select id="productSelect" class="form-control">
                    <option value="">Selecione um produto</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }}
                            {{ $product->flavor }} {{ $product->size }}</option>
                    @endforeach
                </select>
            </div>

            <h2>Produtos selecionados:</h2>
            <table id="productTable" class="table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Valor</th>
                        <th>Quantidade</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>

            <div class="d-flex justify-content-between">
                <h3>Total: <span id="total">0</span></h3>
                <button type="submit" class="btn btn-primary">Save Selected Products</button>
            </div>
        </div>
        <input type="hidden" name="selectedProducts[]" value="{{ $product->id }}" data-price="{{ $product->price }}"
            data-name="{{ $product->name }}">
    </form>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#productSelect').change(function() {
                var productId = $(this).val();
                if (productId !== '') {
                    var productName = $(this).find('option:selected').text();
                    var productPrice = parseFloat($(this).find('option:selected').data('price'));

                    $('#productTable tbody').append(
                        '<tr data-product-id="' + productId + '">' +
                        '<td>' + productName + '</td>' +
                        '<td class="price">' + productPrice.toFixed(2) + '</td>' +
                        '<td>' +
                        '<div class="input-group">' +
                        '<div class="input-group-prepend">' +
                        '<button class="btn btn-outline-secondary decrease" type="button">-</button>' +
                        '</div>' +
                        '<input type="number" class="form-control quantity" value="1" min="1">' +
                        '<div class="input-group-append">' +
                        '<button class="btn btn-outline-secondary increase" type="button">+</button>' +
                        '</div>' +
                        '</div>' +
                        '</td>' +
                        '<td><button class="btn btn-danger remove">Remove</button></td>' +
                        '</tr>'
                    );

                    $(this).find('option:selected').remove();
                    calculateTotal();
                }
            });

            $(document).on('click', '.remove', function() {
                var productId = $(this).closest('tr').data('product-id');
                var productName = $(this).closest('tr').find('td:first').text();
                var productPrice = parseFloat($(this).closest('tr').find('.price').text());

                $('#productSelect').append('<option value="' + productId + '" data-price="' + productPrice +
                    '">' + productName + '</option>');

                $(this).closest('tr').remove();
                calculateTotal();
            });

            $(document).on('click', '.decrease', function() {
                var input = $(this).parent().parent().find('.quantity');
                var value = parseInt(input.val());
                if (value > 1) {
                    input.val(value - 1);
                    calculateTotal();
                }
            });

            $(document).on('click', '.increase', function() {
                var input = $(this).parent().parent().find('.quantity');
                var value = parseInt(input.val());
                input.val(value + 1);
                calculateTotal();
            });

            $(document).on('change', '.quantity', function() {
                calculateTotal();
            });

            function calculateTotal() {
                var total = 0;
                $('#productTable tbody tr').each(function() {
                    var price = parseFloat($(this).find('.price').text());
                    var quantity = parseInt($(this).find('.quantity').val());
                    var subtotal = price * quantity;
                    total += subtotal;
                });
                $('#total').text(total.toFixed(2));
            }
        });
    </script>
@endsection
