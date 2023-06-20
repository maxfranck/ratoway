@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mt-4 mb-4">Edição de Produtos</h2>
        <hr>
        <form method="POST" action="{{ route('admin.product.update', $product->id) }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Nome:</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Digite o nome"
                    value="{{ $product->name }}" required>
            </div>
            <div class="form-group">
                <label for="sabor">Sabor:</label>
                <input type="text" class="form-control" name="flavor" id="flavor" placeholder="Digite o sabor"
                    value="{{ $product->flavor }}">
            </div>
            <div class="form-group">
                <label for="valor">Valor:</label>
                <input type="text" class="form-control" name="price" id="price" placeholder="Digite o valor"
                    value="{{ $product->price }}">
            </div>
            <div class="form-group">
                <label for="tamanho">Tamanho:</label>
                <select class="form-control" name="size" id="size">
                    <option value="" {{ $product->size == '' ? 'selected' : '' }}>Selecione um tamanho
                    </option>
                    <option value="P" {{ $product->size == 'P' ? 'selected' : '' }}>P</option>
                    <option value="M" {{ $product->size == 'M' ? 'selected' : '' }}>M</option>
                    <option value="G" {{ $product->size == 'G' ? 'selected' : '' }}>G</option>
                    <option value="EG" {{ $product->size == 'EG' ? 'selected' : '' }}>EG</option>
                </select>
            </div>
            <div class="form-group">
                <label for="pedacos">Pedaços:</label>
                <input type="number" class="form-control" name="pieces" id="pieces"
                    placeholder="Digite o número de pedaços" value="{{ $product->pieces }}" required>
            </div>
            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <textarea class="form-control" name="description" id="description" rows="3" placeholder="Digite a descrição">{{ $product->description }}</textarea>
            </div>
            <div class="form-group  mb-3">
                <label for="imagem">Imagem:</label>
                <input type="file" class="form-control" name="image" id="image" value="{{ $product->image }}">
            </div>
            <hr>
            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="{{ route('admin.product.show', $product->id) }}" class="btn btn-primary">Voltar</a>
        </form>
    </div>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
@endsection
