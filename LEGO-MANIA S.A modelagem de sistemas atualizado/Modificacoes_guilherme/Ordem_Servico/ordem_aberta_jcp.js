document.addEventListener('DOMContentLoaded', function() {
    // Dados iniciais
    let ordensServico = [
        {
            id: 1,
            funcionario: 'Inácio',
            prioridade: 'ALTA',
            equipamento: 'A70',
            problema: 'Tela quebrada',
            status: 'RESOLVIDA',
            data: '25/05/2025'
        },
        {
            id: 2,
            funcionario: 'Gustavo',
            prioridade: 'MÉDIA',
            equipamento: 'Nokia',
            problema: 'Bateria viciada',
            status: 'EM ANDAMENTO',
            data: '23/05/2025'
        },
        {
            id: 3,
            funcionario: 'Guilherme',
            prioridade: 'BAIXA',
            equipamento: 'iPhone 12',
            problema: 'Conector com defeito',
            status: 'ABERTA',
            data: '19/05/2025'
        }
    ];

    // Elementos da DOM
    const tableBody = document.getElementById('os-table-body');
    const editModal = document.getElementById('edit-modal');
    const editForm = document.getElementById('edit-form');
    const closeBtn = document.querySelector('.close-btn');
    const searchInput = document.getElementById('search-input');
    const novaOsBtn = document.getElementById('nova-os-btn');
    const prevPageBtn = document.getElementById('prev-page');
    const nextPageBtn = document.getElementById('next-page');
    const pageNumber = document.getElementById('page-number');

    // Variáveis de estado
    let currentPage = 1;
    const rowsPerPage = 10;
    let filteredData = [...ordensServico];

    // Inicialização
    renderTable();

    // Event Listeners
    closeBtn.addEventListener('click', closeModal);
    novaOsBtn.addEventListener('click', openNewOsModal);
    prevPageBtn.addEventListener('click', goToPrevPage);
    nextPageBtn.addEventListener('click', goToNextPage);
    searchInput.addEventListener('input', filterTable);
    editForm.addEventListener('submit', handleFormSubmit);

    // Fechar modal ao clicar fora
    window.addEventListener('click', function(event) {
        if (event.target === editModal) {
            closeModal();
        }
    });

    // Funções principais
    function renderTable() {
        tableBody.innerHTML = '';
        
        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        const paginatedData = filteredData.slice(start, end);

        if (paginatedData.length === 0) {
            const row = document.createElement('tr');
            row.innerHTML = `<td colspan="7" class="no-results">Nenhuma ordem de serviço encontrada</td>`;
            tableBody.appendChild(row);
            return;
        }

        paginatedData.forEach(os => {
            const row = document.createElement('tr');
            row.dataset.id = os.id;
            row.innerHTML = `
                <td>${os.funcionario}</td>
                <td><span class="priority-badge ${getPriorityClass(os.prioridade)}">${os.prioridade}</span></td>
                <td>${os.equipamento}</td>
                <td>${os.problema}</td>
                <td><span class="status-badge ${getStatusClass(os.status)}">${os.status}</span></td>
                <td>${os.data}</td>
                <td class="actions-cell">
                    <button class="action-btn edit-btn" title="Editar">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="action-btn delete-btn" title="Excluir">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </td>
            `;
            tableBody.appendChild(row);
        });

        // Atualizar eventos dos botões
        addEditEvents();
        addDeleteEvents();
        updatePagination();
    }

    function addEditEvents() {
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const row = this.closest('tr');
                const id = parseInt(row.dataset.id);
                const os = ordensServico.find(item => item.id === id);
                
                if (os) {
                    document.getElementById('edit-id').value = os.id;
                    document.getElementById('edit-funcionario').value = os.funcionario;
                    document.getElementById('edit-prioridade').value = os.prioridade;
                    document.getElementById('edit-equipamento').value = os.equipamento;
                    document.getElementById('edit-problema').value = os.problema;
                    document.getElementById('edit-status').value = os.status;
                    
                    openModal();
                }
            });
        });
    }

    function addDeleteEvents() {
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const row = this.closest('tr');
                const id = parseInt(row.dataset.id);
                
                if (confirm('Tem certeza que deseja excluir esta ordem de serviço?')) {
                    ordensServico = ordensServico.filter(os => os.id !== id);
                    filteredData = filteredData.filter(os => os.id !== id);
                    renderTable();
                }
            });
        });
    }

    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        
        if (searchTerm === '') {
            filteredData = [...ordensServico];
        } else {
            filteredData = ordensServico.filter(os => 
                os.funcionario.toLowerCase().includes(searchTerm) ||
                os.equipamento.toLowerCase().includes(searchTerm) ||
                os.problema.toLowerCase().includes(searchTerm) ||
                os.status.toLowerCase().includes(searchTerm)
            );
        }
        
        currentPage = 1;
        renderTable();
    }

    function handleFormSubmit(e) {
        e.preventDefault();
        
        const id = parseInt(document.getElementById('edit-id').value);
        const osIndex = ordensServico.findIndex(os => os.id === id);
        
        if (osIndex !== -1) {
            // Atualizar OS existente
            ordensServico[osIndex] = {
                ...ordensServico[osIndex],
                funcionario: document.getElementById('edit-funcionario').value,
                prioridade: document.getElementById('edit-prioridade').value,
                equipamento: document.getElementById('edit-equipamento').value,
                problema: document.getElementById('edit-problema').value,
                status: document.getElementById('edit-status').value
            };
        } else {
            // Criar nova OS
            const newId = ordensServico.length > 0 ? Math.max(...ordensServico.map(os => os.id)) + 1 : 1;
            ordensServico.push({
                id: newId,
                funcionario: document.getElementById('edit-funcionario').value,
                prioridade: document.getElementById('edit-prioridade').value,
                equipamento: document.getElementById('edit-equipamento').value,
                problema: document.getElementById('edit-problema').value,
                status: document.getElementById('edit-status').value,
                data: new Date().toLocaleDateString('pt-BR')
            });
        }
        
        filteredData = [...ordensServico];
        renderTable();
        closeModal();
    }

    // Funções auxiliares
    function getPriorityClass(prioridade) {
        const map = {
            'ALTA': 'high',
            'MÉDIA': 'medium',
            'BAIXA': 'low'
        };
        return map[prioridade] || '';
    }

    function getStatusClass(status) {
        const map = {
            'ABERTA': 'open',
            'EM ANDAMENTO': 'in-progress',
            'RESOLVIDA': 'completed'
        };
        return map[status] || '';
    }

    function openModal() {
        editModal.style.display = 'block';
    }

    function closeModal() {
        editModal.style.display = 'none';
        editForm.reset();
    }
function openNewOsModal(){
    window.location.href = "../Ordem_Servico/nova_ordem.html";

}

    function goToPrevPage() {
        if (currentPage > 1) {
            currentPage--;
            renderTable();
        }
    }

    function goToNextPage() {
        const totalPages = Math.ceil(filteredData.length / rowsPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            renderTable();
        }
    }

    function updatePagination() {
        const totalPages = Math.ceil(filteredData.length / rowsPerPage);
        pageNumber.textContent = currentPage;
        
        prevPageBtn.disabled = currentPage === 1;
        nextPageBtn.disabled = currentPage === totalPages || totalPages === 0;
    }
});