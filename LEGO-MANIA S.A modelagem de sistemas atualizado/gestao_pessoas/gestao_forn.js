document.addEventListener('DOMContentLoaded', function() {
    // Variáveis globais
    let currentPage = 1;
    const rowsPerPage = 10;
    let allSuppliers = [];
    let filteredSuppliers = [];
    
    // Elementos do DOM
    const tableBody = document.getElementById('os-table-body');
    const searchInput = document.getElementById('search-input');
    const prevPageBtn = document.getElementById('prev-page');
    const nextPageBtn = document.getElementById('next-page');
    const pageNumberSpan = document.getElementById('page-number');
    const visibilityFilter = document.getElementById('visibility-filter');
    
    // Modal de edição
    const editModal = document.getElementById('edit-modal');
    const closeBtn = document.querySelector('.close-btn');
    const editForm = document.getElementById('edit-form');
    
    // Inicialização
    initialize();
    
    function initialize() {
        // Carrega dados iniciais (simulados)
        loadSampleData();
        
        // Configura eventos
        setupEventListeners();
        
        // Renderiza a tabela
        filterAndRenderTable();
    }
    
    function loadSampleData() {
        // Dados de exemplo para fornecedores
        allSuppliers = [
            {
                id: 1,
                nome: 'Joseph',
                cpf_cnpj: '727.338.970.13',
                telefone: '(48) 99462-3412',
                ramo: 'Ramo de carcaça',
                cep: '46288-123',
                email: 'JosephJ&G@gmail.com',
                visible: true
            },
            {
                id: 2,
                nome: 'Fornecedor ABC',
                cpf_cnpj: '12.345.678/0001-90',
                telefone: '(11) 98765-4321',
                ramo: 'Peças eletrônicas',
                cep: '04538-132',
                email: 'contato@abc.com.br',
                visible: true
            },
            {
                id: 3,
                nome: 'Distribuidora XYZ',
                cpf_cnpj: '98.765.432/0001-21',
                telefone: '(11) 91234-5678',
                ramo: 'Componentes plásticos',
                cep: '01310-100',
                email: 'vendas@xyz.com.br',
                visible: true
            }
        ];
        
        filteredSuppliers = [...allSuppliers];
    }
    
    function setupEventListeners() {
        // Pesquisa
        searchInput.addEventListener('input', function() {
            currentPage = 1;
            filterAndRenderTable();
        });
        
        // Filtro de visibilidade
        visibilityFilter.addEventListener('change', function() {
            currentPage = 1;
            filterAndRenderTable();
        });
        
        // Paginação
        prevPageBtn.addEventListener('click', function() {
            if (currentPage > 1) {
                currentPage--;
                renderTable();
            }
        });
        
        nextPageBtn.addEventListener('click', function() {
            const totalPages = Math.ceil(filteredSuppliers.length / rowsPerPage);
            if (currentPage < totalPages) {
                currentPage++;
                renderTable();
            }
        });
        
        // Modal de edição
        closeBtn.addEventListener('click', function() {
            editModal.style.display = 'none';
        });
        
        window.addEventListener('click', function(event) {
            if (event.target === editModal) {
                editModal.style.display = 'none';
            }
        });
        
        editForm.addEventListener('submit', function(e) {
            e.preventDefault();
            saveEditedSupplier();
        });
        
        // Botão voltar
        document.getElementById('btnvoltaros').addEventListener('click', function() {
            window.location.href = '../tela_geral/tela_geral.html';
        });
    }
    
    function filterAndRenderTable() {
        // Aplica filtro de pesquisa
        const searchTerm = searchInput.value.toLowerCase();
        
        filteredSuppliers = allSuppliers.filter(supplier => {
            const matchesSearch = 
                supplier.nome.toLowerCase().includes(searchTerm) ||
                supplier.cpf_cnpj.toLowerCase().includes(searchTerm) ||
                supplier.telefone.toLowerCase().includes(searchTerm) ||
                supplier.ramo.toLowerCase().includes(searchTerm) ||
                supplier.cep.toLowerCase().includes(searchTerm) ||
                supplier.email.toLowerCase().includes(searchTerm);
            
            // Aplica filtro de visibilidade
            const matchesVisibility = 
                visibilityFilter.value === 'all' ||
                (visibilityFilter.value === 'visible' && supplier.visible) ||
                (visibilityFilter.value === 'hidden' && !supplier.visible);
            
            return matchesSearch && matchesVisibility;
        });
        
        renderTable();
    }
    
    function renderTable() {
        // Limpa a tabela
        tableBody.innerHTML = '';
        
        // Calcula paginação
        const startIndex = (currentPage - 1) * rowsPerPage;
        const endIndex = startIndex + rowsPerPage;
        const suppliersToShow = filteredSuppliers.slice(startIndex, endIndex);
        
        // Preenche a tabela
        suppliersToShow.forEach(supplier => {
            const row = document.createElement('tr');
            row.dataset.id = supplier.id;
            
            if (!supplier.visible) {
                row.classList.add('hidden-row');
            }
            
            row.innerHTML = `
                <td>${supplier.nome}</td>
                <td>${supplier.cpf_cnpj}</td>
                <td>${supplier.telefone}</td>
                <td>${supplier.ramo}</td>
                <td>${supplier.cep}</td>
                <td>${supplier.email}</td>
                <td class="actions-cell">
                    <button class="action-btn edit-btn" title="Editar">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="action-btn delete-btn" title="${supplier.visible ? 'Ocultar' : 'Mostrar'}">
                        <i class="fas ${supplier.visible ? 'fa-eye-slash' : 'fa-eye'}"></i>
                    </button>
                </td>
            `;
            
            tableBody.appendChild(row);
        });
        
        // Configura eventos dos botões na tabela
        setupTableButtons();
        
        // Atualiza paginação
        updatePagination();
    }
    
    function setupTableButtons() {
        // Botões de editar
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const row = this.closest('tr');
                const supplierId = parseInt(row.dataset.id);
                const supplier = allSuppliers.find(s => s.id === supplierId);
                
                if (supplier) {
                    openEditModal(supplier);
                }
            });
        });
        
        // Botões de ocultar/mostrar
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const row = this.closest('tr');
                const supplierId = parseInt(row.dataset.id);
                toggleSupplierVisibility(supplierId);
            });
        });
    }
    
    function openEditModal(supplier) {
        document.getElementById('edit-id').value = supplier.id;
        document.getElementById('edit-forn').value = supplier.nome;
        document.getElementById('edit-cpf_cnpj').value = supplier.cpf_cnpj;
        document.getElementById('edit-telefone').value = supplier.telefone;
        document.getElementById('edit-ramo').value = supplier.ramo;
        document.getElementById('edit-cep').value = supplier.cep;
        document.getElementById('edit-email').value = supplier.email;
        
        editModal.style.display = 'block';
    }
    
    function saveEditedSupplier() {
        const supplierId = parseInt(document.getElementById('edit-id').value);
        const supplierIndex = allSuppliers.findIndex(s => s.id === supplierId);
        
        if (supplierIndex !== -1) {
            allSuppliers[supplierIndex] = {
                ...allSuppliers[supplierIndex],
                nome: document.getElementById('edit-forn').value,
                cpf_cnpj: document.getElementById('edit-cpf_cnpj').value,
                telefone: document.getElementById('edit-telefone').value,
                ramo: document.getElementById('edit-ramo').value,
                cep: document.getElementById('edit-cep').value,
                email: document.getElementById('edit-email').value
            };
            
            editModal.style.display = 'none';
            filterAndRenderTable();
            
            // Aqui você pode adicionar uma chamada para salvar no banco de dados
            alert('Fornecedor atualizado com sucesso!');
        }
    }
    
    function toggleSupplierVisibility(supplierId) {
        const supplierIndex = allSuppliers.findIndex(s => s.id === supplierId);
        
        if (supplierIndex !== -1) {
            allSuppliers[supplierIndex].visible = !allSuppliers[supplierIndex].visible;
            filterAndRenderTable();
            
            // Aqui você pode adicionar uma chamada para atualizar no banco de dados
            alert(`Fornecedor ${allSuppliers[supplierIndex].visible ? 'mostrado' : 'ocultado'} com sucesso!`);
        }
    }
    
    function updatePagination() {
        const totalPages = Math.ceil(filteredSuppliers.length / rowsPerPage);
        pageNumberSpan.textContent = currentPage;
        
        prevPageBtn.disabled = currentPage === 1;
        nextPageBtn.disabled = currentPage === totalPages || totalPages === 0;
    }
});