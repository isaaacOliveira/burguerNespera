@extends('layouts.app')

<!-- Inclusão do Bootstrap Icons para o layout profissional -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

@section('content')
<div class="container-fluid px-4">
    
    <!-- Header Superior com Saudação Profissional -->
    <div class="d-flex justify-content-between align-items-center bg-white p-4 rounded-3 shadow-sm mb-4">
        <div class="d-flex align-items-center">
            <div class="bg-dark text-warning p-3 rounded-3 me-3">
                <i class="bi bi-shield-lock-fill fs-3"></i>
            </div>
            <div>
                <h4 class="fw-bold text-dark mb-0">Painel de Administração</h4>
                <p class="text-muted mb-0">Bem-vindo de volta.</p>
            </div>
        </div>
        <!-- botao sair com icon<div>
            <a href="{{ route('logout') }}" class="btn btn-outline-danger fw-bold rounded-pill px-4"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right me-2"></i> Sair
            </a>
        </div>-->
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Menu de Separadores Nav Tabs -->
    <ul class="nav nav-pills mb-4 bg-white p-2 rounded-3 shadow-sm" id="adminTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active fw-bold px-4" id="products-tab" data-bs-toggle="tab" data-bs-target="#products" type="button" role="tab">
                <i class="bi bi-egg-fried me-2"></i> Cardápio & Produtos
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold px-4" id="orders-tab" data-bs-toggle="tab" data-bs-target="#orders" type="button" role="tab">
                <i class="bi bi-receipt-cutoff me-2"></i> Pedidos Realizados
                @if($orders->where('status','pendente')->count() > 0)
                    <span class="badge bg-danger ms-2">{{ $orders->where('status','pendente')->count() }}</span>
                @endif
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold px-4" id="customers-tab" data-bs-toggle="tab" data-bs-target="#customers" type="button" role="tab">
                <i class="bi bi-people-fill me-2"></i> Clientes Cadastrados
            </button>
        </li>
    </ul>

    <!-- Conteúdo dos Separadores -->
    <div class="tab-content" id="adminTabsContent">
        
        <!-- SEPARADOR 1: PRODUTOS (IGUAL AO SEU ANTERIOR, MAS COM ÍCONES) -->
        <div class="tab-pane fade show active" id="products" role="tabpanel">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm border-0 rounded-3">
                        <div class="card-header bg-dark text-warning fw-bold d-flex align-items-center">
                            <i class="bi bi-plus-circle-fill me-2"></i> Novo Hambúrguer
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.burgers.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-medium">Nome do Hambúrguer</label>
                                    <input type="text" name="name" class="form-control" placeholder="Ex: Cheese Bacon" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-medium">Descrição / Ingredientes</label>
                                    <textarea name="description" class="form-control" rows="3" placeholder="Carne 180g, queijo cheddar..."></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-medium">Preço (Kz)</label>
                                    <input type="number" step="0.01" name="price" class="form-control" placeholder="0,00" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-medium">Foto do Produto</label>
                                    <input type="file" name="image" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-dark text-warning w-100 fw-bold rounded-pill">
                                    <i class="bi bi-cloud-arrow-up-fill me-2"></i> Publicar no Site
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-8 mb-4">
                    <div class="card shadow-sm border-0 rounded-3">
                        <div class="card-header bg-dark text-white fw-bold d-flex align-items-center">
                            <i class="bi bi-grid-3x3-gap-fill me-2"></i> Produtos Publicados
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-3">Foto</th>
                                            <th>Nome</th>
                                            <th>Preço</th>
                                            <th class="text-end pe-4">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($burgers as $burger)
                                            <tr>
                                                <td class="ps-3">
                                                    <img src="{{ asset('storage/' . $burger->image) }}" class="rounded shadow-sm" style="width: 55px; height: 45px; object-fit: cover;">
                                                </td>
                                                <td class="fw-bold text-dark">{{ $burger->name }}</td>
                                                <td class="text-success fw-bold">{{ number_format($burger->price, 2, ',', '.') }} Kz</td>
                                                <td class="text-end pe-4">
                                                    <form action="{{ route('admin.burgers.destroy', $burger->id) }}" method="POST" onsubmit="return confirm('Deseja mesmo remover este produto?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                                            <i class="bi bi-trash3-fill"></i> Remover
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SEPARADOR 2: PAINEL DE PEDIDOS (NOME, PREÇOS, QUANTIDADE, CLIENTE E VALIDAÇÃO) -->
        <div class="tab-pane fade" id="orders" role="tabpanel">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-dark text-white fw-bold d-flex align-items-center">
                    <i class="bi bi-cart-check-fill me-2"></i> Fluxo de Pedidos Ativos
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">ID</th>
                                    <th>Cliente</th>
                                    <th>Hambúrguer</th>
                                    <th>Preço Unitário</th>
                                    <th>Qtd.</th>
                                    <th>Preço Total</th>
                                    <th>Estado</th>
                                    <th class="text-end pe-4">Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td class="ps-4 fw-bold text-secondary">#{{ $order->id }}</td>
                                        <td class="fw-semibold text-dark"><i class="bi bi-person me-1"></i> {{ $order->user->name }}</td>
                                        <td class="fw-bold">{{ $order->burger->name }}</td>
                                        <td>{{ number_format($order->burger->price, 2, ',', '.') }} Kz</td>
                                        <td><span class="badge bg-light text-dark border px-2">{{ $order->quantity }}x</span></td>
                                        <td class="text-success fw-bold">{{ number_format($order->total_price, 2, ',', '.') }} Kz</td>
                                        <td>
                                            @if($order->status === 'pendente')
                                                <span class="badge bg-warning text-dark px-2.5 py-1.5 rounded-pill fw-semibold"><i class="bi bi-clock-history me-1"></i> PENDENTE</span>
                                            @elseif($order->status === 'entregue')
                                                <span class="badge bg-success text-white px-2.5 py-1.5 rounded-pill fw-semibold"><i class="bi bi-check2-all me-1"></i> ENTREGUE</span>
                                            @else
                                                <span class="badge bg-secondary text-white px-2.5 py-1.5 rounded-pill fw-semibold"><i class="bi bi-x-circle me-1"></i> CANCELADO</span>
                                            @endif
                                        </td>
                                        <td class="text-end pe-4">
                                            @if($order->status === 'pendente')
                                                <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="entregue">
                                                    <button type="submit" class="btn btn-sm btn-success rounded-pill px-3 fw-bold">
                                                        <i class="bi bi-hand-thumbs-up-fill me-1"></i> Entregar Pedido
                                                    </button>
                                                </form>
                                            @else
                                                <button class="btn btn-sm btn-light rounded-pill px-3 text-muted" disabled>Concluído</button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- SEPARADOR 3: GESTÃO DE CLIENTES (LISTAR, EDITAR, SALVAR, ELIMINAR) -->
        <div class="tab-pane fade" id="customers" role="tabpanel">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-dark text-white fw-bold d-flex align-items-center">
                    <i class="bi bi-people-fill me-2"></i> Clientes Registados no Sistema
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Nome do Cliente</th>
                                    <th>E-mail Corporativo / Pessoal</th>
                                    <th>Membro Desde</th>
                                    <th class="text-end pe-4">Ações de Gestão</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td class="ps-4 fw-bold text-dark">{{ $user->name }}</td>
                                        <td class="text-muted">{{ $user->email }}</td>
                                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                        <td class="text-end pe-4">
                                            <!-- Botão que abre a janela Modal de Edição -->
                                            <button class="btn btn-sm btn-outline-primary rounded-pill px-3 me-2" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">
                                                <i class="bi bi-pencil-square me-1"></i> Editar
                                            </button>
                                            
                                            <!-- Formulário para Eliminar Cliente -->
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem a certeza que deseja banir/eliminar este cliente?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger rounded-pill px-3">
                                                    <i class="bi bi-trash3-fill"></i> Eliminar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- JANELA MODAL POP-UP PARA EDITAR E SALVAR O CLIENTE -->
                                    <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 shadow">
                                                <div class="modal-header bg-dark text-white">
                                                    <h5 class="modal-title fw-bold"><i class="bi bi-person-gear me-2"></i> Editar Dados do Cliente</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body text-start">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Nome Completo</label>
                                                            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">E-mail</label>
                                                            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer bg-light">
                                                        <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancelar</button>
                                                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold"><i class="bi bi-save2-fill me-1"></i> Salvar Alterações</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
