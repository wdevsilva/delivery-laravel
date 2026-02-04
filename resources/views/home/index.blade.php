@extends('layouts.app')

@section('title', 'Bem-vindo ao Sistema de Delivery')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="jumbotron bg-light p-5 rounded">
            <h1 class="display-4">
                <i class="bi bi-check-circle text-success"></i>
                Migração para Laravel Concluída!
            </h1>
            <p class="lead">Sistema de delivery migrado com sucesso para Laravel Framework</p>
            <hr class="my-4">

            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body text-center">
                            <i class="bi bi-shield-check text-success" style="font-size: 3rem;"></i>
                            <h5 class="card-title mt-3">Estrutura Segura</h5>
                            <p class="card-text">Framework moderno com melhores práticas</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body text-center">
                            <i class="bi bi-lightning text-warning" style="font-size: 3rem;"></i>
                            <h5 class="card-title mt-3">Alta Performance</h5>
                            <p class="card-text">Otimizado com cache e ORM Eloquent</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body text-center">
                            <i class="bi bi-tools text-primary" style="font-size: 3rem;"></i>
                            <h5 class="card-title mt-3">Fácil Manutenção</h5>
                            <p class="card-text">Código organizado e documentado</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="alert alert-info mt-4">
                <h5><i class="bi bi-info-circle"></i> Status da Migração</h5>
                <ul class="mb-0">
                    <li><strong>✅ Projeto Laravel:</strong> Instalado e configurado</li>
                    <li><strong>✅ Banco de Dados:</strong> Conexão configurada</li>
                    <li><strong>✅ Models:</strong> 21 models Eloquent criados</li>
                    <li><strong>✅ Controllers:</strong> 14 controllers implementados</li>
                    <li><strong>✅ Rotas:</strong> 110+ rotas configuradas (web + api)</li>
                    <li><strong>✅ Migrations:</strong> 16 migrations preparadas</li>
                    <li><strong>✅ API REST:</strong> Sanctum configurado</li>
                </ul>
            </div>

            <div class="mt-4">
                <h5>Acesso Rápido:</h5>
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg me-2">
                    <i class="bi bi-shield-lock"></i> Área Admin
                </a>
                <a href="{{ route('cliente.login') }}" class="btn btn-success btn-lg me-2">
                    <i class="bi bi-person"></i> Área do Cliente
                </a>
                <a href="{{ route('admin.cozinha') }}" class="btn btn-warning btn-lg">
                    <i class="bi bi-fire"></i> Cozinha
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-list-check"></i> Funcionalidades Implementadas</h5>
            </div>
            <div class="card-body">
                <ul>
                    <li>Sistema de autenticação (Admin, Cliente, Garçon)</li>
                    <li>Gestão de pedidos completa</li>
                    <li>Carrinho de compras</li>
                    <li>Sistema de cupons e promoções</li>
                    <li>Programa de fidelidade</li>
                    <li>Módulo de mesas e garçons</li>
                    <li>Display de cozinha</li>
                    <li>API para entregadores</li>
                    <li>Integração WhatsApp Bot</li>
                    <li>Rastreamento de entrega</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-code-square"></i> Tecnologias Utilizadas</h5>
            </div>
            <div class="card-body">
                <ul>
                    <li><strong>Laravel 12:</strong> Framework PHP moderno</li>
                    <li><strong>Eloquent ORM:</strong> Gestão de banco de dados</li>
                    <li><strong>Blade Templates:</strong> Sistema de views</li>
                    <li><strong>Laravel Sanctum:</strong> API Authentication</li>
                    <li><strong>Bootstrap 5:</strong> Interface responsiva</li>
                    <li><strong>MySQL:</strong> Banco de dados</li>
                    <li><strong>RESTful API:</strong> Endpoints organizados</li>
                    <li><strong>Middleware:</strong> Controle de acesso</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
