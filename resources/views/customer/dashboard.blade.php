@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            
            <!-- Mensagens de Sucesso ou Erro -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Título do Dashboard -->
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h2 class="fw-bold text-dark mb-1">Os Meus Pedidos 🍔</h2>
                    <p class="text-muted mb-0">Acompanha o estado das tuas entregas em tempo real.</p>
                </div>
                <a href="{{ route('home') }}" class="btn btn-warning fw-bold shadow-sm">+ Novo Pedido</a>
            </div>

            <!-- Tabela de Pedidos -->
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-0">
                    @if($orders->isEmpty())
                        <div class="text-center py-5">
                            <h4 class="text-muted mb-3">Ainda não fizeste nenhum pedido.</h4>
                            <a href="{{ route('home') }}" class="btn btn-outline-warning fw-bold">Ver Menu de Hambúrgueres</a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light text-secondary text-uppercase fs-7">
                                    <tr>
                                        <th class="ps-4">Pedido #</th>
                                        <th>Hambúrguer</th>
                                        <th>Quantidade</th>
                                        <th>Preço Total</th>
                                        <th>Data</th>
                                        <th>Estado</th>
                                        <th class="text-end pe-4">Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td class="fw-bold ps-4">#{{ $order->id }}</td>
                                            <td>
                                                <span class="fw-semibold text-dark">{{ $order->burger->name }}</span>
                                            </td>
                                            <td>{{ $order->quantity }}x</td>
                                            <td class="fw-bold text-success">{{ number_format($order->total_price, 2, ',', '.') }} Kz</td>
                                            <td class="text-muted">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                @if($order->status === 'pendente')
                                                    <span class="badge bg-warning text-dark px-2.5 py-1.5 rounded-pill fw-semibold text-uppercase">Pendente</span>
                                                @elseif($order->status === 'preparado')
                                                    <span class="badge bg-info text-white px-2.5 py-1.5 rounded-pill fw-semibold text-uppercase">Em Preparação</span>
                                                @elseif($order->status === 'entregue')
                                                    <span class="badge bg-success text-white px-2.5 py-1.5 rounded-pill fw-semibold text-uppercase">Entregue</span>
                                                @else
                                                    <span class="badge bg-secondary text-white px-2.5 py-1.5 rounded-pill fw-semibold text-uppercase">Cancelado</span>
                                                @endif
                                            </td>
                                            <td class="text-end pe-4">
                                                @if($order->status === 'pendente')
                                                    <form action="{{ route('order.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Tens a certeza que queres cancelar este pedido?');">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-danger px-3 rounded-pill fw-medium">
                                                            Cancelar
                                                        </button>
                                                    </form>
                                                @else
                                                    <button class="btn btn-sm btn-light px-3 rounded-pill text-muted" disabled>
                                                        Indisponível
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
