/**
 * =====================================================
 * SISTEMA DE CUPONS MODERNO - JavaScript
 * Funcionalidades: Validação, AJAX, Animações
 * ===================================================== 
 */

class CupomManager {
    constructor() {
        // Detectar baseUrl corretamente a partir do baseUri definido no PHP
        const baseTag = document.querySelector('base');
        if (baseTag && baseTag.href) {
            // Extrair o diretório base (ex: /delivery/)
            const baseHref = baseTag.href.replace(window.location.origin, '');
            const parts = baseHref.split('/');
            this.baseUrl = window.location.origin + '/' + parts[1]; // ex: http://localhost/delivery
        } else {
            this.baseUrl = window.location.origin;
        }
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.initMasks();
        this.initDatePickers();
        this.loadStatistics();
    }

    setupEventListeners() {
        // Toggle tipo de cupom
        const tipoSelect = document.getElementById('cupom_tipo');
        if (tipoSelect) {
            tipoSelect.addEventListener('change', () => this.toggleTipoCupom());
        }

        // Gerar código automático
        const nomeInput = document.getElementById('cupom_nome');
        if (nomeInput) {
            nomeInput.addEventListener('blur', () => this.gerarCodigo());
        }

        // Accordion
        document.querySelectorAll('.accordion-header').forEach(header => {
            header.addEventListener('click', () => this.toggleAccordion(header));
        });

        // Dias da semana
        document.querySelectorAll('.dia-btn').forEach(btn => {
            btn.addEventListener('click', () => this.toggleDia(btn));
        });

        // Formulário submit - Comentado para deixar o PHP redirecionar naturalmente
        // const form = document.getElementById('cupom-form');
        // if (form) {
        //     form.addEventListener('submit', (e) => this.handleSubmit(e));
        // }

        // Botões de ação
        document.querySelectorAll('.btn-edit').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const button = e.currentTarget;
                this.editarCupom(button.dataset.id);
            });
        });

        document.querySelectorAll('.btn-duplicate').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const button = e.currentTarget;
                this.duplicarCupom(button.dataset.id);
            });
        });

        document.querySelectorAll('.btn-delete').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const button = e.currentTarget;
                this.confirmarRemocao(button.dataset.id);
            });
        });

        document.querySelectorAll('.btn-toggle-status').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const button = e.currentTarget;
                this.toggleStatus(button.dataset.id, button.dataset.status);
            });
        });
    }

    initMasks() {
        // Máscara de data
        const dataInputs = document.querySelectorAll('.date-mask');
        dataInputs.forEach(input => {
            $(input).mask('00/00/0000');
        });

        // Máscara de hora
        const horaInputs = document.querySelectorAll('.time-mask');
        horaInputs.forEach(input => {
            $(input).mask('00:00');
        });

        // Máscara de dinheiro
        const moneyInputs = document.querySelectorAll('.money-mask');
        moneyInputs.forEach(input => {
            $(input).mask('#.##0,00', {reverse: true});
        });

        // Máscara de porcentagem
        const percentInputs = document.querySelectorAll('.percent-mask');
        percentInputs.forEach(input => {
            $(input).mask('##0', {reverse: true});
        });

        // Máscara de código
        const codigoInput = document.getElementById('cupom_codigo');
        if (codigoInput) {
            codigoInput.addEventListener('input', (e) => {
                e.target.value = e.target.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
            });
        }
    }

    initDatePickers() {
        $('.date-picker').datetimepicker({
            format: 'DD/MM/YYYY',
            locale: 'pt-br',
            minDate: moment()
        });
    }

    toggleTipoCupom() {
        const tipo = document.getElementById('cupom_tipo').value;
        const valorGroup = document.getElementById('group-valor');
        const percentGroup = document.getElementById('group-percent');
        const descontoMaxGroup = document.getElementById('group-desconto-max');

        if (tipo == '1') {
            // Valor fixo
            valorGroup.style.display = 'block';
            percentGroup.style.display = 'none';
            descontoMaxGroup.style.display = 'none';
            
            document.getElementById('cupom_valor').setAttribute('required', 'required');
            document.getElementById('cupom_percent').removeAttribute('required');
        } else {
            // Porcentagem
            valorGroup.style.display = 'none';
            percentGroup.style.display = 'block';
            descontoMaxGroup.style.display = 'block';
            
            document.getElementById('cupom_percent').setAttribute('required', 'required');
            document.getElementById('cupom_valor').removeAttribute('required');
        }
    }

    gerarCodigo() {
        const nomeInput = document.getElementById('cupom_nome');
        const codigoInput = document.getElementById('cupom_codigo');
        
        if (!codigoInput.value && nomeInput.value) {
            const codigo = nomeInput.value
                .toUpperCase()
                .replace(/[^A-Z0-9]/g, '')
                .substring(0, 10);
            codigoInput.value = codigo + Math.floor(Math.random() * 100);
        }
    }

    toggleAccordion(header) {
        header.classList.toggle('active');
        const content = header.nextElementSibling;
        content.classList.toggle('show');
    }

    toggleDia(btn) {
        const checkbox = btn.querySelector('input[type="checkbox"]');
        checkbox.checked = !checkbox.checked;
        btn.classList.toggle('active');
    }

    async handleSubmit(e) {
        e.preventDefault();
        
        if (!this.validarFormulario()) {
            return false;
        }

        const form = e.target;
        const formData = new FormData(form);
        const submitBtn = form.querySelector('button[type="submit"]');
        
        // Desabilitar botão
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Salvando...';

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData
            });

            if (response.ok) {
                this.showToast('Sucesso!', 'Cupom salvo com sucesso', 'success');
                setTimeout(() => {
                    window.location.href = this.baseUrl + '/cupom/?success=create';
                }, 1500);
            } else {
                throw new Error('Erro ao salvar cupom');
            }
        } catch (error) {
            this.showToast('Erro!', 'Erro ao salvar cupom: ' + error.message, 'error');
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fa fa-save"></i> Gravar Cupom';
        }
    }

    validarFormulario() {
        const nome = document.getElementById('cupom_nome').value;
        const codigo = document.getElementById('cupom_codigo').value;
        const tipo = document.getElementById('cupom_tipo').value;
        const validade = document.getElementById('cupom_validade').value;
        const quantidade = document.getElementById('cupom_quantidade').value;

        if (!nome || !codigo || !tipo || !validade || !quantidade) {
            this.showToast('Atenção!', 'Preencha todos os campos obrigatórios', 'warning');
            return false;
        }

        if (tipo == '1') {
            const valor = document.getElementById('cupom_valor').value;
            if (!valor || parseFloat(valor.replace(',', '.')) <= 0) {
                this.showToast('Atenção!', 'Informe um valor válido', 'warning');
                return false;
            }
        } else {
            const percent = document.getElementById('cupom_percent').value;
            if (!percent || parseInt(percent) <= 0 || parseInt(percent) > 100) {
                this.showToast('Atenção!', 'Informe uma porcentagem válida (1-100)', 'warning');
                return false;
            }
        }

        return true;
    }

    async loadStatistics() {
        try {
            const response = await fetch(this.baseUrl + '/cupom/estatisticas/');
            const data = await response.json();
            
            if (data) {
                this.updateStatistics(data);
            }
        } catch (error) {
            console.error('Erro ao carregar estatísticas:', error);
        }
    }

    updateStatistics(data) {
        const totalElement = document.querySelector('.stat-total');
        const ativosElement = document.querySelector('.stat-ativos');
        const usosElement = document.querySelector('.stat-usos');
        
        if (totalElement) totalElement.textContent = data.total_cupons || 0;
        if (ativosElement) ativosElement.textContent = data.ativos || 0;
        if (usosElement) usosElement.textContent = data.total_usos || 0;
    }

    editarCupom(id) {
        window.location.href = this.baseUrl + '/cupom/editar?id=' + id;
    }

    async duplicarCupom(id) {
        if (!confirm('Deseja duplicar este cupom?')) {
            return;
        }

        try {
            const response = await fetch(this.baseUrl + '/cupom/duplicar/', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'cupom_id=' + id
            });

            const data = await response.json();

            if (data.success) {
                this.showToast('Sucesso!', 'Cupom duplicado com sucesso', 'success');
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                throw new Error(data.message || 'Erro ao duplicar');
            }
        } catch (error) {
            this.showToast('Erro!', error.message, 'error');
        }
    }

    confirmarRemocao(id) {
        this.showModal({
            title: 'Confirmar Remoção',
            message: 'Tem certeza que deseja remover este cupom? Esta ação não pode ser desfeita.',
            type: 'danger',
            confirmText: 'Sim, Remover',
            cancelText: 'Cancelar',
            onConfirm: () => this.removerCupom(id)
        });
    }

    async removerCupom(id) {
        try {
            const response = await fetch(this.baseUrl + '/cupom/remove/', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'cupom_id=' + id
            });

            const data = await response.json();
            
            if (data.success) {
                this.showToast('Sucesso!', data.message || 'Cupom removido com sucesso', 'success');
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                throw new Error(data.message || 'Erro ao remover cupom');
            }
        } catch (error) {
            this.showToast('Erro!', error.message, 'error');
        }
    }

    async toggleStatus(id, currentStatus) {
        const newStatus = currentStatus == 1 ? 0 : 1;
        const action = newStatus == 1 ? 'ativar' : 'desativar';

        console.log('Toggle Status:', {
            id: id,
            currentStatus: currentStatus,
            newStatus: newStatus,
            url: this.baseUrl + '/cupom/altera_status/'
        });

        try {
            const response = await fetch(this.baseUrl + '/cupom/altera_status/', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `cupom_id=${id}&status=${newStatus}`
            });

            console.log('Response status:', response.status);
            const text = await response.text();
            console.log('Response text:', text);

            let data;
            try {
                data = JSON.parse(text);
            } catch (e) {
                console.error('Erro ao parsear JSON:', e);
                throw new Error('Resposta inválida do servidor: ' + text.substring(0, 100));
            }

            console.log('Response data:', data);

            if (data.success) {
                this.showToast('Sucesso!', data.message || `Cupom ${action}do com sucesso`, 'success');
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                const errorMsg = data.message || 'Erro ao alterar status';
                const debugInfo = data.debug ? JSON.stringify(data.debug) : '';
                throw new Error(errorMsg + (debugInfo ? ' - ' + debugInfo : ''));
            }
        } catch (error) {
            console.error('Erro completo:', error);
            this.showToast('Erro!', error.message, 'error');
        }
    }

    showToast(title, message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `toast-modern ${type} fade-in`;
        
        const icons = {
            success: 'fa-check-circle',
            error: 'fa-times-circle',
            warning: 'fa-exclamation-triangle',
            info: 'fa-info-circle'
        };

        toast.innerHTML = `
            <div class="toast-icon">
                <i class="fa ${icons[type]}"></i>
            </div>
            <div class="toast-content">
                <div class="toast-title">${title}</div>
                <div class="toast-message">${message}</div>
            </div>
            <button class="modal-close" onclick="this.parentElement.remove()">
                <i class="fa fa-times"></i>
            </button>
        `;

        document.body.appendChild(toast);

        setTimeout(() => {
            toast.remove();
        }, 5000);
    }

    showModal(options) {
        const modal = document.createElement('div');
        modal.className = 'modal-modern';
        modal.innerHTML = `
            <div class="modal-content-modern">
                <div class="modal-header-modern">
                    <h4>${options.title}</h4>
                    <button class="modal-close" onclick="this.closest('.modal-modern').remove()">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <p>${options.message}</p>
                </div>
                <div class="modal-footer" style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 20px;">
                    <button class="btn-modern btn-outline-modern" onclick="this.closest('.modal-modern').remove()">
                        ${options.cancelText || 'Cancelar'}
                    </button>
                    <button class="btn-modern btn-${options.type || 'primary'}-modern" id="modal-confirm">
                        ${options.confirmText || 'Confirmar'}
                    </button>
                </div>
            </div>
        `;

        document.body.appendChild(modal);
        
        setTimeout(() => modal.classList.add('show'), 10);

        document.getElementById('modal-confirm').addEventListener('click', () => {
            modal.remove();
            if (options.onConfirm) options.onConfirm();
        });
    }

    // Validar cupom no checkout
    async validarCupomCheckout(codigo, clienteId, valorPedido) {
        try {
            const response = await fetch(this.baseUrl + '/cupom/validar/', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `codigo=${codigo}&cliente_id=${clienteId}&valor_pedido=${valorPedido}`
            });

            const data = await response.json();
            return data;
        } catch (error) {
            console.error('Erro ao validar cupom:', error);
            return { valido: false, mensagem: 'Erro ao validar cupom' };
        }
    }
}

// Inicializar quando o DOM estiver pronto
document.addEventListener('DOMContentLoaded', () => {
    window.cupomManager = new CupomManager();
    
    // Verificar mensagens de sucesso/erro na URL
    const urlParams = new URLSearchParams(window.location.search);
    const success = urlParams.get('success');
    const error = urlParams.get('error');

    if (success) {
        const messages = {
            'create': 'Cupom criado com sucesso!',
            'update': 'Cupom atualizado com sucesso!',
            'delete': 'Cupom removido com sucesso!'
        };
        window.cupomManager.showToast('Sucesso!', messages[success] || 'Operação realizada com sucesso', 'success');
    }

    if (error) {
        window.cupomManager.showToast('Erro!', decodeURIComponent(error), 'error');
    }
});

// Funções auxiliares globais
function formatarMoeda(valor) {
    return new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL'
    }).format(valor);
}

function formatarData(data) {
    return new Date(data).toLocaleDateString('pt-BR');
}

function calcularDesconto(tipo, valor, percent, valorPedido, descontoMax) {
    if (tipo == 1) {
        return Math.min(valor, valorPedido);
    } else {
        let desconto = (valorPedido * percent) / 100;
        if (descontoMax && desconto > descontoMax) {
            desconto = descontoMax;
        }
        return desconto;
    }
}
