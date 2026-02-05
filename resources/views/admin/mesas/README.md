# Módulo de Mesas - Administrativo

Este diretório contém todas as views do módulo administrativo de gerenciamento de mesas, separado do sistema de delivery.

## Estrutura de Arquivos

```
view/admin/mesas/
├── dashboard.php    - Dashboard principal de mesas (visão geral, reservas, ações)
├── lista.php        - Lista completa de todas as mesas
├── novo.php         - Formulário para criar nova mesa
├── editar.php       - Formulário para editar mesa existente
├── detalhes.php     - Visualização detalhada de uma mesa específica
└── pedido.php       - Gerenciamento de pedidos para mesa ocupada
```

## Funcionalidades Implementadas

### Dashboard (`dashboard.php`)
- **Estatísticas em tempo real**: Mesas livres, ocupadas, reservadas, manutenção
- **Painel de reservas do dia**: Lista e gerenciamento de reservas
- **Cards visuais de mesas**: Status, informações de ocupação/reserva
- **Ações administrativas**: Ocupar, reservar, manutenção, editar, remover
- **Filtros**: Por status de mesa
- **Modais**: Para ocupação, reservas e operações

### Lista (`lista.php`)
- **Tabela completa**: Todas as mesas com informações resumidas
- **Ações por linha**: Ver detalhes, editar, remover
- **Status visual**: Labels coloridos por status
- **Informações contextuais**: Cliente/reserva quando aplicável

### Novo/Editar (`novo.php` / `editar.php`)
- **Formulários completos**: Número, capacidade, localização
- **Validação**: Client-side e server-side
- **Status inicial**: Configuração de status da mesa
- **Dicas**: Orientações para preenchimento
- **Observações**: Campo para notas especiais

### Detalhes (`detalhes.php`)
- **Informações completas**: Dados da mesa e status atual
- **Ações contextuais**: Baseadas no status da mesa
- **Histórico**: Timeline de atividades recentes
- **Pedidos**: Lista de pedidos quando mesa ocupada
- **Status em tempo real**: Duração de ocupação, dados de reserva

### Pedidos (`pedido.php`)
- **Gerenciamento de pedidos**: Para mesas ocupadas
- **Resumo financeiro**: Total de pedidos e valores
- **Ações de mesa**: Novo pedido, imprimir conta, liberar mesa
- **Status de pedidos**: Controle do fluxo de preparo

## Controladores Atualizados

Os seguintes controladores foram atualizados para usar a nova estrutura:
- `controller/Admin.php` - Métodos de mesa usando `admin.mesas.*`
- `controller/Mesa.php` - Se existir, atualizado para nova estrutura

## Rotas Configuradas

Todas as rotas administrativas de mesa estão configuradas em `config/routes.php`:
- `/admin/mesa` - Dashboard principal
- `/admin/mesa/lista` - Lista de mesas
- `/admin/mesa/novo` - Nova mesa
- `/admin/mesa/editar/{id}` - Editar mesa
- `/admin/mesa/detalhes/{id}` - Detalhes da mesa
- `/admin/mesa/pedido/{id}` - Gerenciar pedidos

## Benefícios da Organização

### Separação Clara
- **Mesas**: `view/admin/mesas/`
- **Delivery**: Outros arquivos em `view/admin/`
- **Facilita manutenção**: Localização rápida de arquivos relacionados

### Consistência
- **Padrão AdminLTE**: Todos os arquivos seguem o mesmo tema
- **Estrutura similar**: Header, sidebar, content, footer
- **JavaScript organizado**: Funções específicas por página

### Escalabilidade
- **Fácil adição**: Novos arquivos no módulo de mesas
- **Reutilização**: Componentes podem ser compartilhados
- **Modularidade**: Cada arquivo tem responsabilidade específica

## Configuração de Memória

Esta organização segue as especificações de memória do projeto:
- **Padrão administrativo consistente**: Arquivo PHP dedicado em `/view/admin`
- **Integração com side-menu**: Acessível via navegação lateral
- **Estilo consistente**: Mantém padrões visuais existentes

## Logs com Timestamp

Todas as operações administrativas incluem logs com timestamp conforme requerido:
- Operações de mesa (ocupar, liberar, criar, editar)
- Gerenciamento de reservas
- Alterações de status
- Ações administrativas

## Próximos Passos

1. **Integração com side-menu**: Adicionar links para o módulo de mesas
2. **Testes**: Verificar funcionamento de todas as funcionalidades
3. **Permissões**: Configurar níveis de acesso adequados
4. **Relatórios**: Adicionar relatórios específicos de mesas
5. **API**: Expandir endpoints para funcionalidades móveis

---
**Criado em**: <?php echo date('d/m/Y H:i:s'); ?>
**Versão**: 1.0.0
**Autor**: Sistema Automatizado