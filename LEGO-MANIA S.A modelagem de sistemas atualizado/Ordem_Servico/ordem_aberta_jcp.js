document.addEventListener('DOMContentLoaded', function() {
    let ordens = JSON.parse(localStorage.getItem('ordensServico')) || [];
    const tabela = document.getElementById('os-table-body');
    
    // Função para salvar e atualizar a lista de ordens
    function salvarOrdens(novasOrdens) {
        ordens = novasOrdens; // Atualiza a variável global
        localStorage.setItem('ordensServico', JSON.stringify(ordens));
        preencherTabela();
    }

    // Preenche a tabela
    function preencherTabela() {
        tabela.innerHTML = '';
        
        ordens.forEach(os => {
            const tr = document.createElement('tr');
            tr.dataset.id = os.id;
            
            tr.innerHTML = `
                <td>${os.tecnico || 'Não atribuído'}</td>
                <td><span class="priority-badge ${(os.prioridade || 'MÉDIA').toLowerCase()}">${os.prioridade || 'MÉDIA'}</span></td>
                <td>${os.marca || ''}</td>
                <td>${os.problema || ''}</td>
                <td><span class="status-badge ${getStatusClass(os.status || 'ABERTA')}">${os.status || 'ABERTA'}</span></td>
                <td>${os.dataRecebimento || ''}</td>
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
        });
    }

    // Implementação com delegação de eventos
    tabela.addEventListener('click', function(e) {
        const btn = e.target.closest('.action-btn');
        if (!btn) return;
        
        const tr = btn.closest('tr');
        const id = parseInt(tr.dataset.id);
        
        if (btn.classList.contains('edit-btn')) {
            abrirModalEdicao(id);
        } else if (btn.classList.contains('delete-btn')) {
            if (confirm('Tem certeza que deseja excluir esta OS?')) {
                excluirOS(id);
            }
        }
    });

    function excluirOS(id) {
        const novasOrdens = ordens.filter(o => o.id !== id);
        salvarOrdens(novasOrdens);
    }

    function getStatusClass(status) {
        switch(status) {
            case 'RESOLVIDA': return 'completed';
            case 'EM ANDAMENTO': return 'in-progress';
            default: return 'open';
        }
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
        
        document.getElementById('edit-modal').style.display = 'block';
    }
    
    // Formulário de edição
    document.getElementById('edit-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const id = parseInt(document.getElementById('edit-id').value);
        const osIndex = ordens.findIndex(o => o.id === id);
        
        if (osIndex !== -1) {
            // Cria uma cópia do array para garantir a imutabilidade
            const novasOrdens = [...ordens];
            
            // Atualiza os dados na cópia
            novasOrdens[osIndex] = {
                ...novasOrdens[osIndex],
                tecnico: document.getElementById('edit-funcionario').value,
                prioridade: document.getElementById('edit-prioridade').value,
                marca: document.getElementById('edit-equipamento').value,
                problema: document.getElementById('edit-problema').value,
                status: document.getElementById('edit-status').value,
                dataConclusao: document.getElementById('edit-status').value === 'RESOLVIDA' 
                    ? new Date().toLocaleDateString('pt-BR') 
                    : null
            };
            
            // Salva as alterações
            salvarOrdens(novasOrdens);
            
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