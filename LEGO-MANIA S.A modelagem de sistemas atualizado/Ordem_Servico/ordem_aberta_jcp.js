document.addEventListener('DOMContentLoaded', function() {
    // Carrega as ordens de serviço
    const ordens = JSON.parse(localStorage.getItem('ordensServico')) || [];
    const tabela = document.getElementById('os-table-body');
    
    // Preenche a tabela
    function preencherTabela() {
        tabela.innerHTML = '';
        
        ordens.forEach(os => {
            if (os.status !== 'RESOLVIDA') { // Só mostra se não estiver resolvida
                const tr = document.createElement('tr');
                tr.dataset.id = os.id;
                
                tr.innerHTML = `
                    <td>${os.tecnico}</td>
                    <td><span class="priority-badge ${os.prioridade.toLowerCase()}">${os.prioridade}</span></td>
                    <td>${os.marca}</td>
                    <td>${os.problema}</td>
                    <td><span class="status-badge ${getStatusClass(os.status)}">${os.status}</span></td>
                    <td>${os.dataRecebimento}</td>
                    <td class="actions-cell">
                        <button class="action-btn edit-btn" title="Editar">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="action-btn delete-btn" title="Excluir">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                `;
                
                tabela.appendChild(tr);
            }
        });
        
        // Adiciona eventos aos botões
        addEventListeners();
    }
    
    function getStatusClass(status) {
        switch(status) {
            case 'RESOLVIDA': return 'completed';
            case 'EM ANDAMENTO': return 'in-progress';
            default: return 'open';
        }
    }
    
    function addEventListeners() {
        // Botões de edição
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = parseInt(this.closest('tr').dataset.id);
                abrirModalEdicao(id);
            });
        });
        
        // Botões de exclusão
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = parseInt(this.closest('tr').dataset.id);
                if (confirm('Tem certeza que deseja excluir esta OS?')) {
                    excluirOS(id);
                }
            });
        });
    }
    
    function abrirModalEdicao(id) {
        const os = ordens.find(o => o.id === id);
        if (!os) return;
        
        // Preenche o modal
        document.getElementById('edit-id').value = os.id;
        document.getElementById('edit-funcionario').value = os.tecnico;
        document.getElementById('edit-prioridade').value = os.prioridade;
        document.getElementById('edit-equipamento').value = os.marca;
        document.getElementById('edit-problema').value = os.problema;
        document.getElementById('edit-status').value = os.status;
        
        // Abre o modal
        document.getElementById('edit-modal').style.display = 'block';
    }
    
    function excluirOS(id) {
        const novasOrdens = ordens.filter(o => o.id !== id);
        localStorage.setItem('ordensServico', JSON.stringify(novasOrdens));
        preencherTabela();
    }
    
    // Formulário de edição
    document.getElementById('edit-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const id = parseInt(document.getElementById('edit-id').value);
        const osIndex = ordens.findIndex(o => o.id === id);
        
        if (osIndex !== -1) {
            // Atualiza os dados
            ordens[osIndex].tecnico = document.getElementById('edit-funcionario').value;
            ordens[osIndex].prioridade = document.getElementById('edit-prioridade').value;
            ordens[osIndex].marca = document.getElementById('edit-equipamento').value;
            ordens[osIndex].problema = document.getElementById('edit-problema').value;
            
            const novoStatus = document.getElementById('edit-status').value;
            ordens[osIndex].status = novoStatus;
            
            // Se foi marcado como RESOLVIDO, adiciona data de conclusão
            if (novoStatus === 'RESOLVIDA') {
                ordens[osIndex].dataConclusao = new Date().toLocaleDateString('pt-BR');
            }
            
            // Salva no localStorage
            localStorage.setItem('ordensServico', JSON.stringify(ordens));
            
            // Atualiza a tabela
            preencherTabela();
            
            // Fecha o modal
            document.getElementById('edit-modal').style.display = 'none';
        }
    });
    
    // Fechar modal
    document.querySelector('.close-btn').addEventListener('click', function() {
        document.getElementById('edit-modal').style.display = 'none';
    });
    
    // Botão Nova OS
    document.getElementById('nova-os-btn').addEventListener('click', function() {
        window.location.href = 'nova_ordem.html';
    });
    
    // Botão Voltar
    document.getElementById('btnvoltaros').addEventListener('click', function() {
        window.location.href = '../tela_geral/tela_geral.html';
    });
    
    // Inicializa a tabela
    preencherTabela();
});