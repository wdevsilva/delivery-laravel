# Módulo de Cozinha - Administrativo

Este diretório contém todas as views do módulo administrativo de gerenciamento da cozinha, separado do sistema de delivery.

## Estrutura de Arquivos

```
view/admin/cozinha/
├── index.php               - Página principal do módulo da cozinha
├── cozinha-dashboard.php   - Dashboard com lista de pedidos administrativo
├── cozinha-display.php     - Display full-screen para a cozinha
└── README.md              - Este arquivo de documentação
```

## Funcionalidades Implementadas

### Página Principal (`index.php`)
- **Visão geral do módulo**: Apresentação e acesso rápido
- **Cards de acesso rápido**: Dashboard, Display, Estatísticas
- **Status em tempo real**: Contadores de pedidos por status
- **Ações rápidas**: Atualizar, marcar prontos, relatórios
- **Preview dos últimos pedidos**: Lista resumida dos pedidos recentes

### Dashboard Administrativo (`cozinha-dashboard.php`)
- **Estatísticas visuais**: Cards com contadores por status
- **Lista de pedidos ativos**: Cards com informações detalhadas
- **Ações por pedido**: Iniciar preparo, marcar pronto, ver detalhes
- **Modal de detalhes**: Visualização completa do pedido e itens
- **Auto-refresh**: Atualização automática a cada 30 segundos
- **Ações em lote**: Marcar todos como prontos

### Display Full-Screen (`cozinha-display.php`)
- **Interface dedicada**: Otimizada para tela da cozinha
- **Layout em grid**: Cards organizados por pedido
- **Código de cores**: Visual por status (aguardando, preparo, pronto)
- **Informações essenciais**: Número, cliente, tipo, tempo, itens
- **Ações diretas**: Botões grandes para iniciar/finalizar
- **Auto-refresh**: Atualização automática a cada 15 segundos
- **Notificações visuais**: Animações para novos pedidos

## Controladores Atualizados

O módulo utiliza o controlador dedicado:
- `controller/Cozinha.php` - Todas as funcionalidades da cozinha

## Rotas Configuradas

Todas as rotas da cozinha estão configuradas em `config/routes.php`:
- `/admin/cozinha` - Display full-screen principal
- `/admin/cozinha/display` - Dashboard administrativo
- `/admin/cozinha/get-novos-pedidos` - API para buscar pedidos
- `/admin/cozinha/atualizar-status` - API para atualizar status
- `/admin/cozinha/detalhes-pedido` - API para detalhes do pedido
- `/admin/cozinha/marcar-pronto` - API para marcar como pronto
- `/admin/cozinha/iniciar-preparo` - API para iniciar preparo
- `/admin/cozinha/estatisticas` - API para estatísticas

## Benefícios da Organização

### Separação Clara
- **Cozinha**: `view/admin/cozinha/`
- **Outros módulos**: Outros diretórios em `view/admin/`
- **Facilita manutenção**: Localização rápida de arquivos relacionados

### Consistência
- **Padrão AdminLTE**: Todos os arquivos seguem o mesmo tema
- **Estrutura similar**: Header, sidebar, content, footer
- **JavaScript organizado**: Funções específicas por página

### Escalabilidade
- **Fácil adição**: Novos arquivos no módulo de cozinha
- **Reutilização**: Componentes podem ser compartilhados
- **Modularidade**: Cada arquivo tem responsabilidade específica

## Configuração de Memória

Esta organização segue as especificações de memória do projeto:
- **Padrão administrativo consistente**: Arquivos PHP dedicados em `/view/admin/cozinha`
- **Integração com side-menu**: Acessível via navegação lateral
- **Estilo consistente**: Mantém padrões visuais existentes do AdminLTE

## Logs com Timestamp

Todas as operações da cozinha incluem logs com timestamp conforme requerido:
- Atualização de status de pedidos
- Início de preparo e finalização
- Busca de novos pedidos
- Erros e exceções
- Ações administrativas

## Funcionalidades Técnicas

### APIs AJAX
- **get-novos-pedidos**: Busca pedidos ativos em tempo real
- **atualizar-status**: Atualiza status do pedido
- **detalhes-pedido**: Retorna detalhes completos do pedido
- **marcar-pronto**: Marca pedido como pronto para entrega
- **iniciar-preparo**: Inicia preparo do pedido
- **estatisticas**: Retorna estatísticas da cozinha

### Recursos Visuais
- **Códigos de cor**: Status visuais por cor
- **Animações**: Pulse para novos pedidos
- **Responsividade**: Adaptado para diferentes tamanhos de tela
- **Icons**: Font Awesome para melhor UX

### Auto-refresh
- **Display**: 15 segundos
- **Dashboard**: 30 segundos
- **Index**: 60 segundos
- **Timestamps**: Atualização em tempo real

## Próximos Passos

1. **Integração com side-menu**: Adicionar links para o módulo de cozinha
2. **Testes**: Verificar funcionamento de todas as funcionalidades
3. **Permissões**: Configurar níveis de acesso adequados
4. **Relatórios**: Adicionar relatórios específicos de cozinha
5. **Notificações**: Implementar sistema de notificações sonoras
6. **Mobile**: Otimizar para dispositivos móveis

---
**Criado em**: <?php echo date('d/m/Y H:i:s'); ?>
**Versão**: 1.0.0
**Autor**: Sistema Automatizado
**Refatoração**: Extração do Admin Controller para Cozinha Controller