document.addEventListener('DOMContentLoaded', function() {
    // Carrega as ordens de serviço
    const ordens = JSON.parse(localStorage.getItem('ordensServico')) || [];
    const tabela = document.getElementById('os-table-body');
    
    // Preenche a tabela
    function preencherTabela() {
        tabela.innerHTML = '';
        
        // Filtra apenas as OS resolvidas
        const ordensResolvidas = ordens.filter(os => os.status === 'RESOLVIDA');
        
        ordensResolvidas.forEach(os => {
            const tr = document.createElement('tr');
            tr.dataset.id = os.id;
            
            tr.innerHTML = `
                <td>${os.problema}</td>
                <td>${os.tecnico}</td>
                <td>Peça utilizada</td> <!-- Você pode adicionar isso no cadastro se necessário -->
                <td>${os.dataRecebimento}</td>
                <td>${os.dataConclusao || os.dataRecebimento}</td>
                <td class="actions-cell">
                    <button class="action-btn view-btn" title="Visualizar">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="action-btn delete-btn" title="Excluir">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </td>
            `;
            
            tabela.appendChild(tr);
        });
        
        // Adiciona eventos aos botões
        addEventListeners();
    }
    
    function addEventListeners() {
        // Botões de visualização
        document.querySelectorAll('.view-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = parseInt(this.closest('tr').dataset.id);
                visualizarOS(id);
            });
        });
        
        // Botões de exclusão
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = parseInt(this.closest('tr').dataset.id);
                if (confirm('Tem certeza que deseja excluir este serviço realizado?')) {
                    excluirOS(id);
                }
            });
        });
    }
    
    function visualizarOS(id) {
        const os = ordens.find(o => o.id === id);
        if (!os) return;
        
        // Preenche o modal com os dados da OS
        document.getElementById('view-cliente').textContent = os.nome || 'Não informado';
        document.getElementById('view-equipamento').textContent = os.equipamento || 'Não informado';
        document.getElementById('view-marca').textContent = `${os.marca || ''} ${os.modelo || ''}`.trim() || 'Não informado';
        document.getElementById('view-problema').textContent = os.problema || 'Não informado';
        document.getElementById('view-observacoes').textContent = os.observacao || 'Nenhuma observação';
        document.getElementById('view-tecnico').textContent = os.tecnico || 'Não informado';
        document.getElementById('view-data-recebimento').textContent = os.dataRecebimento || 'Não informado';
        document.getElementById('view-data-conclusao').textContent = os.dataConclusao || 'Não informado';
        document.getElementById('view-pecas').textContent = os.pecasUtilizadas || 'Nenhuma peça registrada';
        
        // Exibe o modal
        const modal = document.getElementById('view-modal');
        modal.style.display = 'block';
        
        // Fecha o modal quando clicar no X
        modal.querySelector('.close-btn').onclick = function() {
            modal.style.display = 'none';
        };
        
        // Fecha o modal quando clicar fora dele
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        };
    }

    // Adicione isso no final do seu DOMContentLoaded
document.addEventListener('keydown', function(event) {
    const modal = document.getElementById('view-modal');
    if (event.key === 'Escape' && modal.style.display === 'block') {
        modal.style.display = 'none';
    }
});
    
    function excluirOS(id) {
        const novasOrdens = ordens.filter(o => o.id !== id);
        localStorage.setItem('ordensServico', JSON.stringify(novasOrdens));
        preencherTabela();
    }
    
    // Botão Voltar
    document.getElementById('btnvoltaros').addEventListener('click', function() {
        window.location.href = '../tela_geral/tela_geral.html';
    });
    
    // Inicializa a tabela
    preencherTabela();
    
    // Configuração dos datepickers
    flatpickr("#data-recebimento", {
        dateFormat: "d/m/Y",
        locale: "pt"
    });
});