@extends('layouts.app')

<!-- Inclusão do Bootstrap Icons para eliminar emojis e usar ícones reais -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    /* Estilização para o brilho e cores vivas baseadas na imagem image_8.png */
    body {
        background-color: #fcfbf9 !important; /* Fundo claro e limpo premium */
    }
    .card-burger {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        background-color: #ffffff;
    }
    .card-burger:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08) !important;
    }
    .btn-burger-prime {
        background-color: #d62300 !important; /* Vermelho vivo inspirado na imagem */
        color: #ffffff !important;
        border: none;
    }
    .btn-burger-prime:hover {
        background-color: #b51c00 !important;
    }
    
    /* Botão Flutuante do WhatsApp */
    .whatsapp-float {
        position: fixed;
        width: 60px;
        height: 60px;
        bottom: 90px;
        right: 20px;
        background-color: #25d366;
        color: #fff;
        border-radius: 50%;
        text-align: center;
        font-size: 30px;
        box-shadow: 0px 4px 10px rgba(0,0,0,0.3);
        z-index: 100;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: transform 0.3s ease;
    }
    .whatsapp-float:hover {
        transform: scale(1.1);
        color: #fff;
    }

    /* Botão Voltar ao Topo */
    #backToTop {
        position: fixed;
        width: 45px;
        height: 45px;
        bottom: 30px;
        right: 27px;
        background-color: #333333;
        color: #ffffff;
        border: none;
        border-radius: 50%;
        display: none; /* Controlado via JavaScript */
        align-items: center;
        justify-content: center;
        font-size: 20px;
        box-shadow: 0px 2px 8px rgba(0,0,0,0.2);
        z-index: 99;
        cursor: pointer;
        transition: background-color 0.3s;
    }
    #backToTop:hover {
        background-color: #d62300;
    }
</style>

@section('content')
<div class="container mb-5">
    <!-- Banner Principal Premium -->
    <div class="p-5 mb-5 text-white rounded-3 text-center shadow-sm" style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1568901346375-23c9450c58cd?q=80&w=1000'); background-size: cover; background-position: center; border-radius: 15px;">
        <h1 class="display-4 fw-bold text-warning">Os Melhores Hambúrgueres Artesanais</h1>
        <p class="fs-4">Peça já o seu e receba no conforto da sua casa!</p>
    </div>

    <!-- Lista de Produtos Dinâmicos -->
    <div class="d-flex align-items-center mb-4">
        <div class="bg-danger p-2 rounded-3 text-white me-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
            <i class="bi bi-fire fs-5"></i>
        </div>
        <h2 class="fw-bold text-dark mb-0" style="font-family: 'Arial Black', Gadget, sans-serif;">Nossos Hambúrgueres</h2>
    </div>

    <div class="row">
        @if(isset($burgers) && count($burgers) > 0)
            @foreach($burgers as $burger)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm border-0 overflow-hidden rounded-3 card-burger">
                        <img src="{{ $burger->image }}" alt="{{ $burger->name }}" style="width: 100%; height: 250px; object-fit: cover; border-radius:10px 10px 0 0;">
                        <div class="card-body d-flex flex-column p-4">
                            <h5 class="card-title fw-bold text-dark fs-4 mb-2">{{ $burger->name }}</h5>
                            <p class="card-text text-muted flex-grow-1 fs-6">{{ $burger->description }}</p>
                            
                            <!-- Preço do Hambúrguer -->
                            <div class="mt-3">
                                <span class="fs-3 fw-bold text-success">{{ number_format($burger->price, 2, ',', '.') }} Kz</span>
                            </div>

                            <!-- Área Dinâmica de Pedido Integrada sem Emojis -->
                            @auth
                                <!-- Formulário do pedido para utilizadores logados -->
                                <form action="{{ route('order.store', $burger->id) }}" method="POST" class="mt-3 mb-0">
                                    @csrf
                                    <button type="submit" class="btn btn-burger-prime w-100 fw-bold shadow-sm py-2.5 rounded-pill text-uppercase fs-7">
                                        <i class="bi bi-cart-plus-fill me-2"></i> Fazer Pedido
                                    </button>
                                </form>
                            @else
                                <!-- Se não estiver logado -->
                                <div class="mt-3">
                                    <a href="{{ route('login') }}" class="btn btn-outline-secondary w-100 fw-bold py-2.5 rounded-pill text-uppercase fs-7">
                                        <i class="bi bi-box-arrow-in-right me-2"></i> Iniciar sessão para pedir
                                    </a>
                                </div>
                            @endauth

                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <!-- Mensagem caso não existam produtos -->
            <div class="col-12 text-center py-5">
                <div class="card border-0 shadow-sm p-5 bg-white rounded-3">
                    <p class="text-muted fs-5 mb-0"><i class="bi bi-exclamation-circle-fill text-warning me-2"></i> Nenhum hambúrguer disponível no momento. Volte mais tarde!</p>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Botão Flutuante do WhatsApp -->
<a href="https://wa.me/244934692550?text=Ol%C3%A1%21+Gostaria+de+fazer+um+pedido+de+hamb%C3%BArguer." class="whatsapp-float" target="_blank" title="Fale Connosco no WhatsApp">
    <i class="bi bi-whatsapp"></i>
</a>

<!-- Botão Seta para Cima (Voltar ao Topo) -->
<button id="backToTop" title="Voltar ao topo">
    <i class="bi bi-arrow-up-short"></i>
</button>

<!-- Rodapé Profissional da Hamburgueria -->
<footer class="bg-dark text-white pt-5 pb-4 mt-5 border-top border-warning border-3">
    <div class="container text-center text-md-start">
        <div class="row">
            <div class="col-md-4 col-lg-4 col-xl-3 mx-auto mb-4">
                <h5 class="text-warning fw-bold text-uppercase mb-4"><i class="bi bi-egg-fried me-2"></i> Hamburgueria Pro</h5>
                <p class="text-secondary fs-7">Os melhores ingredientes artesanais preparados com a máxima qualidade diretamente para a sua mesa.</p>
            </div>
            <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-4">
                <h5 class="text-uppercase fw-bold text-warning mb-4"><i class="bi bi-clock me-2"></i> Horário de Atendimento</h5>
                <p class="text-secondary mb-1 fs-7">Segunda a Sábado: 11:00h às 23:00h</p>
                <p class="text-secondary fs-7">Domingos: 12:00h às 22:00h</p>
            </div>
            <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                <h5 class="text-uppercase fw-bold text-warning mb-4"><i class="bi bi-telephone-outbound me-2"></i> Call Center & Apoio</h5>
                <p class="text-secondary fs-7"><i class="bi bi-geo-alt-fill me-2"></i> Benguela, Angola</p>
                <p class="text-secondary fs-7"><i class="bi bi-whatsapp me-2"></i> +244 934 692 550</p>
            </div>
        </div>
        <hr class="bg-secondary my-4">
        <div class="row align-items-center">
            <div class="col-md-12 text-center">
                <p class="text-secondary mb-0 fs-7">&copy; {{ date('Y') }} BurguerNêspera - Todos os direitos reservados.</p>
            </div>
        </div>
    </div>
</footer>

<!-- Scripts JavaScript para controlar a rolagem suave do Botão Topo -->
<script>
    const backToTopBtn = document.getElementById("backToTop");

    window.onscroll = function() {
        scrollFunction();
    };

    function scrollFunction() {
        if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
            backToTopBtn.style.display = "flex";
        } else {
            backToTopBtn.style.display = "none";
        }
    }

    backToTopBtn.addEventListener("click", function() {
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    });
</script>
@endsection
