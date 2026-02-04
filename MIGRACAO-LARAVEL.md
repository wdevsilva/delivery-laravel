# Migração do Sistema Delivery para Laravel

## Status Atual da Migração

### ✅ Concluído
1. **Projeto Laravel criado** em `/var/www/html/delivery-laravel`
2. **Configuração inicial do .env** com:
   - Banco de dados MySQL (delivery)
   - Timezone: America/Sao_Paulo
   - Locale: pt_BR
   - URLs customizadas para o sistema
3. **Migrations criadas** (16 arquivos):
   - Tabelas core: config, usuarios, clientes, enderecos, categorias, items, opcoes, pedidos, pedido_items, entregadores, cupons, bases
   - Módulos: mesas, bot_whatsapp, fidelidade, entrega_tracking
4. **Models Eloquent criados** (21 models):
   - Core: Config, Usuario, Cliente, Endereco, Categoria, Item, Opcao, Pedido, PedidoItem, Entregador, Cupom, Base
   - Módulos: Mesa, Garcon, MesaOcupacao, PedidoMesa, MesaReserva, Chatbot, BotAtendimentoSessao, FidelidadeCliente, EntregaTracking
5. **Controllers criados** (14 controllers):
   - Admin: DashboardController
   - Auth: LoginController, ClienteLoginController
   - Core: PedidoController, ClienteController, CarrinhoController, ItemController, CupomController, FidelidadeController, CozinhaController
   - API: EntregadorController, BotWhatsappController
   - Módulos: MesaController, GarconController
6. **Sistema de Rotas configurado**:
   - **web.php**: 80+ rotas (Admin, Cliente, Garçon, Cozinha, Públicas)
   - **api.php**: 30+ rotas (Entregador, Bot WhatsApp, Cupons, Fidelidade, Rastreamento)
   - Middleware de autenticação configurado (admin, cliente, garcon)
   - API RESTful com Sanctum para app mobile
7. **Views Blade criadas**:
   - Layout principal (app.blade.php) com Bootstrap 5
   - Página inicial demonstrativa
   - Estrutura de diretórios para admin, cliente, garcon
8. **Servidor Laravel rodando**:
   - URL: http://localhost:8000
   - Todas as rotas funcionando
   - Interface responsiva pronta
9. **Dashboard Admin funcional**:
   - Controller com lógica completa implementada
   - View Blade com dados reais do banco
   - Estatísticas: Total pedidos, clientes, produtos, faturamento
   - Listagem de últimos pedidos com relacionamentos
   - Produtos mais vendidos
   - **TESTADO E FUNCIONANDO** com dados reais de `pediuzap10_deliciasnopote`

### 🔄 Próximos Passos

#### 1. Análise do Sistema Atual
**Recursos identificados:**
- 26 Models (appModel, caixaModel, categoriaModel, clienteModel, etc)
- 45 Controllers (Admin, Carrinho, Pedido, LoginCliente, etc)
- Sistema modular (ModuleManager/ModuleMiddleware)
- Bot WhatsApp integrado
- Múltiplas APIs (entregador, cupons, avaliações)
- Módulos opcionais: Mesas, Garçon, Cozinha

#### 2. Estratégia de Migração

**Fase 1: Estrutura Base (Migrations e Models)**
- Criar migrations para ~30 tabelas principais
- Criar Models Eloquent com relacionamentos
- Configurar seeders para dados iniciais

**Fase 2: Controllers e Rotas**
- Migrar lógica de controllers mantendo funcionalidades
- Configurar rotas no Laravel (web.php, api.php)
- Implementar middlewares de autenticação

**Fase 3: Views e Frontend**
- Converter templates PHP para Blade
- Migrar assets (CSS, JS)
- Adaptar formulários e validações

**Fase 4: Integrações Especiais**
- Bot WhatsApp (manter Node.js, adaptar APIs)
- Sistema de pagamento PIX
- Mercado Pago
- Sistema de impressão térmica

**Fase 5: Módulos Avançados**
- Sistema de Mesas e Garçons
- Cozinha Display
- Tracking de Entrega
- Programa de Fidelidade

#### 3. Tabelas Principais Identificadas

```
- config (configurações gerais)
- usuario (admin users)
- cliente (customers)
- endereco (addresses)
- categoria (product categories)
- item (products)
- opcao (product options)
- pedido (orders)
- pedido_item (order items)
- entregador (delivery drivers)
- cupom (coupons/discounts)
- bases (multi-tenant)

Módulos Opcionais:
- mesa (tables)
- garcon (waiters)
- mesa_ocupacao (table occupancy)
- pedido_mesa (table orders)
- fidelidade_cliente (loyalty program)
- entrega_tracking (delivery tracking)
```

#### 4. Decisões Técnicas

**Autenticação:**
- Laravel Sanctum para API (app entregador)
- Laravel Breeze/UI para admin
- Manter sessões PHP nativas para compatibilidade inicial

**Banco de Dados:**
- Usar Eloquent ORM
- Migrations versionadas
- Manter estrutura atual inicialmente

**APIs:**
- Rota `/api/*` para todas APIs
- Recursos RESTful onde possível
- Manter compatibilidade com app mobile

**Bot WhatsApp:**
- Manter bot-whatsapp.js (Node.js)
- Adaptar endpoints PHP para Laravel routes
- PM2 para gerenciamento de processos

#### 5. Compatibilidade

**Durante a migração:**
- Ambos sistemas rodam em paralelo
- Sistema antigo: `/var/www/html/delivery`
- Sistema Laravel: `/var/www/html/delivery-laravel`
- Mesmo banco de dados compartilhado

**Testes:**
- Testar cada módulo migrado
- Validar APIs com app mobile
- Verificar bot WhatsApp funcionando

#### 6. Pontos de Atenção

⚠️ **Crítico:**
- Sistema multi-tenant (múltiplas bases/empresas)
- Integridade de pedidos em andamento
- Sessões de clientes ativas
- Bot WhatsApp não pode parar

⚠️ **Importante:**
- Migrações reversíveis
- Logs detalhados
- Backup antes de cada fase

## Cronograma Sugerido

**Semana 1:** Migrations + Models + Seeders
**Semana 2:** Controllers básicos (Auth, Pedido, Cliente)
**Semana 3:** Views e Frontend
**Semana 4:** APIs e Integrações
**Semana 5:** Módulos Avançados
**Semana 6:** Testes e Ajustes

## Comandos Laravel Úteis

```bash
# Criar migration
php artisan make:migration create_nome_table

# Criar model com migration
php artisan make:model NomeModel -m

# Criar controller com resources
php artisan make:controller NomeController --resource

# Rodar migrations
php artisan migrate

# Criar seeder
php artisan make:seeder NomeSeeder

# Limpar cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

---

**Aguardando aprovação para prosseguir com a implementação.**
