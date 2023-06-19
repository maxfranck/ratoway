@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mt-4 mb-4">Produtos</h2>
        <hr>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Sabor</th>
                    <th>Valor</th>
                    <th>Tamanho</th>
                    <th>Pedaços</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->flavor }}</td>
                        <td>R$ {{ $product->price }}</td>
                        <td>{{ $product->size }}</td>
                        <td>{{ $product->pieces }}</td>
                        <td>
                            <a href="{{ route('admin.product.show', $product->id) }}" class="btn btn-primary btn-sm">Ver</a>
                            <a href="{{ route('admin.product.edit', $product->id) }}"
                                class="btn btn-warning btn-sm">Editar</a>
                            <a href="#" class="btn btn-danger btn-sm"
                                onclick="event.preventDefault(); if (confirm('Tem certeza que deseja excluir este produto?')) { document.getElementById('delete-form-{{ $product->id }}').submit(); }">
                                Excluir
                            </a>
                            <form id="delete-form-{{ $product->id }}"
                                action="{{ route('admin.product.destroy', ['id' => $product->id]) }}" method="POST"
                                style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#search').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('table tbody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            $('table').DataTable();
        });
    </script>
@endsection
