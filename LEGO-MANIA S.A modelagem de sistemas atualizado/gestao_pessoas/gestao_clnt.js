document.addEventListener('DOMContentLoaded', function() {
    // =============================================
    // CONSTANTES E VARIÁVEIS
    // =============================================
    const ROWS_PER_PAGE = 10;
    
    // Elementos da DOM
    const elements = {
        tableBody: document.getElementById('os-table-body'),
        editModal: document.getElementById('edit-modal'),
        editForm: document.getElementById('edit-form'),
        closeBtn: document.querySelector('.close-btn'),
        searchInput: document.getElementById('search-input'),
        novoClienteBtn: document.getElementById('nova-os-btn'),
        prevPageBtn: document.getElementById('prev-page'),
        nextPageBtn: document.getElementById('next-page'),
        pageNumber: document.getElementById('page-number'),
        btnVoltar: document.getElementById('btnvoltaros'),
        visibilityFilter: document.getElementById('visibility-filter')
    };

    // Estado da aplicação
    const state = {
        currentPage: 1,
        clientes: [
            {
                id: 1,
                nome: 'JoãoGamer',
                cpfCnpj: '123.456.789-09',
                cep: '01234-567',
                telefone: '(11) 98765-4321',
                email: 'JoãoGamer@email.com',
                visivel: true

            },
              

        ],
        filteredData: []
    };

    // Inicialização
    state.filteredData = [...state.clientes];
    
    // =============================================
    // FUNÇÕES PRINCIPAIS
    // =============================================

    function init() {
        renderTable();
        setupSortableHeaders();
        setupEventListeners();
        loadSavedData();
    }

    function renderTable() {
        elements.tableBody.innerHTML = '';
        
        const start = (state.currentPage - 1) * ROWS_PER_PAGE;
        const end = start + ROWS_PER_PAGE;
        const paginatedData = state.filteredData.slice(start, end);

        if (paginatedData.length === 0) {
            elements.tableBody.innerHTML = '<tr><td colspan="6" class="no-results">Nenhum cliente encontrado</td></tr>';
            return;
        }

        elements.tableBody.innerHTML = paginatedData.map(cliente => `
            <tr data-id="${cliente.id}">
                <td>${cliente.nome}</td>
                <td>${cliente.cpfCnpj}</td>
                <td>${cliente.cep}</td>
                <td>${cliente.telefone}</td>
                <td>${cliente.email}</td>
                <td class="actions-cell">
                    <button class="action-btn edit-btn" title="Editar">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="action-btn delete-btn" title="Excluir">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </td>
            </tr>
        `).join('');

        addEditEvents();
        addDeleteEvents();
        updatePagination();
    }

    function setupSortableHeaders() {
        document.querySelectorAll(".service-table th").forEach((header, index) => {
            if (index !== headers.length - 1) {
                header.style.cursor = "pointer";
                header.addEventListener("click", () => sortTable(index));
            }
        });
    }

    function sortTable(columnIndex) {
        const table = document.querySelector(".service-table");
        const direction = table.getAttribute("data-direction") === "asc" ? "desc" : "asc";
        
        state.filteredData.sort((a, b) => {
            const aVal = getCellValue(a, columnIndex);
            const bVal = getCellValue(b, columnIndex);

            switch(columnIndex) {
                case 2: // CEP
                    return direction === "asc" ? aVal.localeCompare(bVal) : bVal.localeCompare(aVal);
                case 3: // Telefone
                    return direction === "asc" 
                        ? aVal.replace(/\D/g, '') - bVal.replace(/\D/g, '') 
                        : bVal.replace(/\D/g, '') - aVal.replace(/\D/g, '');
                default: // Texto
                    return direction === "asc" 
                        ? aVal.localeCompare(bVal, 'pt-BR', { sensitivity: 'base' }) 
                        : bVal.localeCompare(aVal, 'pt-BR', { sensitivity: 'base' });
            }
        });

        updateSortIndicators(columnIndex, direction);
        renderTable();
    }

    function updateSortIndicators(columnIndex, direction) {
        const headers = document.querySelectorAll(".service-table th");
        headers.forEach(th => th.classList.remove("sorted-asc", "sorted-desc"));
        headers[columnIndex].classList.add(`sorted-${direction}`);
        
        const table = document.querySelector(".service-table");
        table.setAttribute("data-sort", columnIndex);
        table.setAttribute("data-direction", direction);
    }

    // =============================================
    // FUNÇÕES DE EVENTOS
    // =============================================

    function setupEventListeners() {
        // Eventos de UI
        elements.closeBtn.addEventListener('click', closeModal);
        elements.novoClienteBtn.addEventListener('click', openNovoClienteModal);
        elements.prevPageBtn.addEventListener('click', goToPrevPage);
        elements.nextPageBtn.addEventListener('click', goToNextPage);
        elements.searchInput.addEventListener('input', filterTable);
        elements.editForm.addEventListener('submit', handleFormSubmit);
        elements.btnVoltar.addEventListener('click', () => {
            window.location.href = "../tela_geral/tela_geral.html";
        });

        if (elements.visibilityFilter) {
            elements.visibilityFilter.addEventListener('change', filterVisibility);
        }

        // Fechar modal ao clicar fora
        window.addEventListener('click', function(event) {
            if (event.target === elements.editModal) {
                closeModal();
            }
        });

        // Salvar dados antes de sair
        window.addEventListener('beforeunload', saveData);
    }

    function addEditEvents() {
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const row = this.closest('tr');
                const id = parseInt(row.dataset.id);
                const cliente = state.clientes.find(item => item.id === id);
                
                if (cliente) {
                    fillEditForm(cliente);
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
                
                if (confirm('Tem certeza que deseja excluir este cliente?')) {
                    deleteClient(id);
                }
            });
        });
    }

    // =============================================
    // FUNÇÕES AUXILIARES
    // =============================================

    function getCellValue(cliente, columnIndex) {
        switch(columnIndex) {
            case 0: return cliente.nome;
            case 1: return cliente.cpfCnpj;
            case 2: return cliente.cep;
            case 3: return cliente.telefone;
            case 4: return cliente.email;
            default: return '';
        }
    }

    function fillEditForm(cliente) {
        document.getElementById('edit-id').value = cliente.id;
        document.getElementById('edit-nome').value = cliente.nome;
        document.getElementById('edit-cpfCnpj').value = cliente.cpfCnpj;
        document.getElementById('edit-cep').value = cliente.cep;
        document.getElementById('edit-telefone').value = cliente.telefone;
        document.getElementById('edit-email').value = cliente.email;
    }

    function deleteClient(id) {
        state.clientes = state.clientes.filter(cliente => cliente.id !== id);
        state.filteredData = state.filteredData.filter(cliente => cliente.id !== id);
        renderTable();
    }

    function filterTable() {
        const searchTerm = elements.searchInput.value.toLowerCase();
        
        state.filteredData = searchTerm === '' 
            ? [...state.clientes] 
            : state.clientes.filter(cliente => 
                cliente.nome.toLowerCase().includes(searchTerm) ||
                cliente.cpfCnpj.toLowerCase().includes(searchTerm) ||
                cliente.telefone.toLowerCase().includes(searchTerm) ||
                cliente.email.toLowerCase().includes(searchTerm)
            );
        
        state.currentPage = 1;
        renderTable();
    }

    function filterVisibility() {
        const filter = this.value;
        
        state.filteredData = filter === 'visible'
            ? state.clientes.filter(cliente => cliente.visivel !== false)
            : filter === 'hidden'
                ? state.clientes.filter(cliente => cliente.visivel === false)
                : [...state.clientes];
        
        state.currentPage = 1;
        renderTable();
    }

    function handleFormSubmit(e) {
        e.preventDefault();
        
        const id = parseInt(document.getElementById('edit-id').value);
        const clienteIndex = state.clientes.findIndex(cliente => cliente.id === id);
        
        if (clienteIndex !== -1) {
            // Atualizar cliente existente
            state.clientes[clienteIndex] = {
                ...state.clientes[clienteIndex],
                nome: document.getElementById('edit-nome').value,
                cpfCnpj: document.getElementById('edit-cpfCnpj').value,
                cep: document.getElementById('edit-cep').value,
                telefone: document.getElementById('edit-telefone').value,
                email: document.getElementById('edit-email').value
            };
        } else {
            // Criar novo cliente
            const newId = state.clientes.length > 0 
                ? Math.max(...state.clientes.map(cliente => cliente.id)) + 1 
                : 1;
                
            state.clientes.push({
                id: newId,
                nome: document.getElementById('edit-nome').value,
                cpfCnpj: document.getElementById('edit-cpfCnpj').value,
                cep: document.getElementById('edit-cep').value,
                telefone: document.getElementById('edit-telefone').value,
                email: document.getElementById('edit-email').value,
                visivel: true
            });
        }
        
        state.filteredData = [...state.clientes];
        renderTable();
        closeModal();
    }

    function openModal() {
        elements.editModal.style.display = 'block';
    }

    function closeModal() {
        elements.editModal.style.display = 'none';
        elements.editForm.reset();
    }

    function openNovoClienteModal() {
        elements.editForm.reset();
        document.getElementById('edit-id').value = '';
        openModal();
    }

    function goToPrevPage() {
        if (state.currentPage > 1) {
            state.currentPage--;
            renderTable();
        }
    }

    function goToNextPage() {
        const totalPages = Math.ceil(state.filteredData.length / ROWS_PER_PAGE);
        if (state.currentPage < totalPages) {
            state.currentPage++;
            renderTable();
        }
    }

    function updatePagination() {
        const totalPages = Math.ceil(state.filteredData.length / ROWS_PER_PAGE);
        elements.pageNumber.textContent = state.currentPage;
        
        elements.prevPageBtn.disabled = state.currentPage === 1;
        elements.nextPageBtn.disabled = state.currentPage === totalPages || totalPages === 0;
    }

    function saveData() {
        localStorage.setItem('clientesData', JSON.stringify({
            clientes: state.clientes,
            filteredData: state.filteredData,
            currentPage: state.currentPage
        }));
    }

    function loadSavedData() {
        const savedData = localStorage.getItem('clientesData');
        if (savedData) {
            const parsedData = JSON.parse(savedData);
            state.clientes = parsedData.clientes || state.clientes;
            state.filteredData = parsedData.filteredData || [...state.clientes];
            state.currentPage = parsedData.currentPage || 1;
            renderTable();
        }
    }

    // Inicializar a aplicação
    init();
});