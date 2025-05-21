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
                        <i class="fas fa-eye"></i>
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
        
        // Aqui você pode abrir um modal ou página com os detalhes completos
        alert(`Detalhes da OS:\n
Cliente: ${os.nome}\n
Equipamento: ${os.marca}\n
Problema: ${os.problema}\n
Observações: ${os.observacao}\n
Data de recebimento: ${os.dataRecebimento}\n
Data de conclusão: ${os.dataConclusao}\n
Técnico: ${os.tecnico}`);
    }
    
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