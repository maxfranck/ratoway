<!-- resources/views/apportionment/final.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mt-4">{{ $apportionment->name }}</h2>
        <hr>
        <h5><b>Valor Total:</b> R$ {{ $apportionment->total }}</h5>
        <h5><b>Valor a Receber:</b> R$ {{ $pendingPayments }}</h5>
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
                    <tr class="{{ $contributor->contributed ? 'pago' : '' }}">
                        <td>{{ $contributor->name }}</td>
                        <td>
                            @if (!$contributor->contributed)
                                <form method="POST" action="{{ route('contributor.pago', $contributor->id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Pago</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('apportionment.summary', $apportionment->id) }}" class="btn btn-warning ">
                << Voltar</a>
                    <a href="{{ route('apportionment.create') }}" class="btn btn-success">Finalizar
                        >></a>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .pago {
            background-color: #c8e6c9;
            /* Cor de fundo verde */
        }
    </style>
@endpush
