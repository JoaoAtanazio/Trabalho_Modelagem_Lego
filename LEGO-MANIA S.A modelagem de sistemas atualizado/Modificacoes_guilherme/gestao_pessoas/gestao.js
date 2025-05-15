
function sortTable(n) {
    const table = document.querySelector(".service-table");
    const tbody = table.querySelector("tbody");
    const rows = Array.from(tbody.querySelectorAll("tr"));
    const editModal = document.getElementById('edit-modal');
    const editForm = document.getElementById('edit-form');
    let direction = "asc"; // direção padrão
    
    // Verifica se já está ordenado e inverte a direção
    if (table.getAttribute("data-sort") === String(n)) {
        direction = table.getAttribute("data-direction") === "asc" ? "desc" : "asc";
    }
    
    // Ordena as linhas
    rows.sort((a, b) => {
        const aVal = a.cells[n].textContent.trim();
        const bVal = b.cells[n].textContent.trim();
        
        // Tratamento especial para diferentes tipos de dados
        if (n === 2) { // Coluna de Salário
            const numA = parseFloat(aVal.replace("R$ ", "").replace(".", "").replace(",", "."));
            const numB = parseFloat(bVal.replace("R$ ", "").replace(".", "").replace(",", "."));
            return direction === "asc" ? numA - numB : numB - numA;
        } else if (n === 3) { // Coluna de Data
            const dateA = new Date(aVal.split("/").reverse().join("-"));
            const dateB = new Date(bVal.split("/").reverse().join("-"));
            return direction === "asc" ? dateA - dateB : dateB - dateA;
        } else { // Coluna de Texto
            return direction === "asc" 
                ? aVal.localeCompare(bVal, 'pt-BR', { sensitivity: 'base' }) 
                : bVal.localeCompare(aVal, 'pt-BR', { sensitivity: 'base' });
        }
    });
    
    // Remove todas as linhas atuais
    while (tbody.firstChild) {
        tbody.removeChild(tbody.firstChild);
    }
    
    // Adiciona as linhas ordenadas
    rows.forEach(row => tbody.appendChild(row));
    
    // Atualiza o cabeçalho com a direção da ordenação
    table.querySelectorAll("th").forEach(th => th.classList.remove("sorted-asc", "sorted-desc"));
    table.querySelectorAll("th")[n].classList.add(`sorted-${direction}`);
    
    // Armazena o estado da ordenação
    table.setAttribute("data-sort", n);
    table.setAttribute("data-direction", direction);
}

// Adiciona os eventos de clique aos cabeçalhos
document.addEventListener("DOMContentLoaded", () => {
    const headers = document.querySelectorAll(".service-table th");
    headers.forEach((header, index) => {
        if (index !== headers.length - 1) { // Não adiciona à coluna Ações
            header.style.cursor = "pointer";
            header.addEventListener("click", () => sortTable(index));
        }
    });
});
document.addEventListener('DOMContentLoaded', function() {
    // Dados iniciais de funcionários
    let funcionarios = [
        {
            id: 1,
            nome: 'Inácio',
            cpf: '143.140.073-14',
            salario: '10000,00',
            dataNascimento: '04/12/1988',
            cep: '46288-123',
            funcao: 'Administrador',
            email: 'inacio@gmail.com'
        },
        {
            id: 2,
            nome: 'João Silva',
            cpf: '123.456.789-00',
            salario: 'R$ 4.500,00',
            dataNascimento: '15/03/1985',
            cep: '01234-567',
            funcao: 'Atendente',
            email: 'joao.silva@empresa.com'
        },
        {
            nome: 'Maria Oliveira',
            cpf: '987.654.321-00',
            salario: 'R$ 5.200,00',
            dataNascimento: '22/07/1990',
            cep: '04567-890',
            funcao: 'Atendente',
            email: 'maria.oliveira@empresa.com'
        },
         {
        id: 4,
        nome: 'Carlos Souza',
        cpf: '456.789.123-00',
        salario: 'R$ 3.800,00',
        dataNascimento: '10/11/1992',
        cep: '07890-123',
        funcao: 'Técnico',
        email: 'carlos.souza@empresa.com'
    },
    {
        id: 5,
        nome: 'Ana Costa',
        cpf: '789.123.456-00',
        salario: 'R$ 6.000,00',
        dataNascimento: '05/05/1988',
        cep: '03456-789',
        funcao: 'Estoquista',
        email: 'ana.costa@empresa.com'
    },
    {
        id: 6,
        nome: 'Pedro Rocha',
        cpf: '321.654.987-00',
        salario: 'R$ 4.200,00',
        dataNascimento: '30/09/1995',
        cep: '06789-012',
        funcao: 'Estoquista',
        email: 'pedro.rocha@empresa.com'
    },
    {
        id: 7,
        nome: 'Juliana Almeida',
        cpf: '654.321.987-00',
        salario: 'R$ 5.800,00',
        dataNascimento: '12/12/1987',
        cep: '08901-234',
        funcao: 'Técnico',
        email: 'juliana.almeida@empresa.com'
    },
    {
        id: 8,
        nome: 'Fernando Lima',
        cpf: '147.258.369-00',
        salario: 'R$ 3.500,00',
        dataNascimento: '18/04/1993',
        cep: '04512-378',
        funcao: 'Atendente',
        email: 'fernando.lima@empresa.com'
    },
    {
        id: 9,
        nome: 'Patrícia Santos',
        cpf: '258.369.147-00',
        salario: 'R$ 7.200,00',
        dataNascimento: '27/10/1984',
        cep: '07845-612',
        funcao: 'Estoquista',
        email: 'patricia.santos@empresa.com'
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
    const btnVoltar = document.getElementById('btnvoltaros');

    // Variáveis de estado
    let currentPage = 1;
    const rowsPerPage = 10;
    let filteredData = [...funcionarios];

    // Inicialização
    renderTable();

    // Event Listeners
    closeBtn.addEventListener('click', closeModal);
    novaOsBtn.addEventListener('click', openNewFuncionarioModal);
    prevPageBtn.addEventListener('click', goToPrevPage);
    nextPageBtn.addEventListener('click', goToNextPage);
    searchInput.addEventListener('input', filterTable);
    editForm.addEventListener('submit', handleFormSubmit);
    btnVoltar.addEventListener('click', () => {
        window.location.href = "../tela_geral/tela_geral.html";
    });

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
            row.innerHTML = `<td colspan="8" class="no-results">Nenhum funcionário encontrado</td>`;
            tableBody.appendChild(row);
            return;
        }

        paginatedData.forEach(func => {
            const row = document.createElement('tr');
            row.dataset.id = func.id;
            row.innerHTML = `
                <td>${func.nome}</td>
                <td>${func.cpf}</td>
                <td>${func.salario}</td>
                <td>${func.dataNascimento}</td>
                <td>${func.cep}</td>
                <td>${func.funcao}</td>
                <td>${func.email}</td>
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
                const func = funcionarios.find(item => item.id === id);
                
                if (func) {
                    document.getElementById('edit-id').value = func.id;
                    document.getElementById('edit-funcionario').value = func.nome;
                    document.getElementById('edit-cpf').value = func.cpf;
                    document.getElementById('edit-salario').value = func.salario;
                    document.getElementById('edit-dataNascimento').value = func.dataNascimento;
                    document.getElementById('edit-cep').value = func.cep;
                    document.getElementById('edit-funcao').value = func.funcao;
                    document.getElementById('edit-email').value = func.email;
                    
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
                
                if (confirm('Tem certeza que deseja excluir este funcionário?')) {
                    funcionarios = funcionarios.filter(func => func.id !== id);
                    filteredData = filteredData.filter(func => func.id !== id);
                    renderTable();
                }
            });
        });
    }

    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        
        if (searchTerm === '') {
            filteredData = [...funcionarios];
        } else {
            filteredData = funcionarios.filter(func => 
                func.nome.toLowerCase().includes(searchTerm) ||
                func.cpf.toLowerCase().includes(searchTerm) ||
                func.funcao.toLowerCase().includes(searchTerm) ||
                func.email.toLowerCase().includes(searchTerm)
            );
        }
        
        currentPage = 1;
        renderTable();
    }

    function handleFormSubmit(e) {
        e.preventDefault();
        
        const id = parseInt(document.getElementById('edit-id').value);
        const funcIndex = funcionarios.findIndex(func => func.id === id);
        
        if (funcIndex !== -1) {
            // Atualizar funcionário existente
            funcionarios[funcIndex] = {
                ...funcionarios[funcIndex],
                nome: document.getElementById('edit-funcionario').value,
                cpf: document.getElementById('edit-cpf').value,
                salario: document.getElementById('edit-salario').value,
                dataNascimento: document.getElementById('edit-dataNascimento').value,
                cep: document.getElementById('edit-cep').value,
                funcao: document.getElementById('edit-funcao').value,
                email: document.getElementById('edit-email').value
            };
        } else {
            // Criar novo funcionário
            const newId = funcionarios.length > 0 ? Math.max(...funcionarios.map(func => func.id)) + 1 : 1;
            funcionarios.push({
                id: newId,
                nome: document.getElementById('edit-funcionario').value,
                cpf: document.getElementById('edit-cpf').value,
                salario: document.getElementById('edit-salario').value,
                dataNascimento: document.getElementById('edit-dataNascimento').value,
                cep: document.getElementById('edit-cep').value,
                funcao: document.getElementById('edit-funcao').value,
                email: document.getElementById('edit-email').value
            });
        }
        
        filteredData = [...funcionarios];
        renderTable();
        closeModal();
    }

    // Funções auxiliares
    function openModal() {
        editModal.style.display = 'block';
    }

    function closeModal() {
        editModal.style.display = 'none';
        editForm.reset();
    }

    function openNewFuncionarioModal() {
        // Limpa o formulário e define o ID como vazio para novo cadastro
        editForm.reset();
        document.getElementById('edit-id').value = '';
        openModal();
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