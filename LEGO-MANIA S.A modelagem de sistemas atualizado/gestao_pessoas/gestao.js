function sortTable(n) {
    const table = document.querySelector(".service-table");
    const tbody = table.querySelector("tbody");
    const rows = Array.from(tbody.querySelectorAll("tr"));
    const editModal = document.getElementById('edit-modal');
    const editForm = document.getElementById('edit-form');
    let direction = "asc";
    
    if (table.getAttribute("data-sort") === String(n)) {
        direction = table.getAttribute("data-direction") === "asc" ? "desc" : "asc";
    }
    
    rows.sort((a, b) => {
        const aVal = a.cells[n].textContent.trim();
        const bVal = b.cells[n].textContent.trim();
        
        if (n === 2) {
            const numA = parseFloat(aVal.replace("R$ ", "").replace(".", "").replace(",", "."));
            const numB = parseFloat(bVal.replace("R$ ", "").replace(".", "").replace(",", "."));
            return direction === "asc" ? numA - numB : numB - numA;
        } else if (n === 3) {
            const dateA = new Date(aVal.split("/").reverse().join("-"));
            const dateB = new Date(bVal.split("/").reverse().join("-"));
            return direction === "asc" ? dateA - dateB : dateB - dateA;
        } else {
            return direction === "asc" 
                ? aVal.localeCompare(bVal, 'pt-BR', { sensitivity: 'base' }) 
                : bVal.localeCompare(aVal, 'pt-BR', { sensitivity: 'base' });
        }
    });
    
    while (tbody.firstChild) {
        tbody.removeChild(tbody.firstChild);
    }
    
    rows.forEach(row => tbody.appendChild(row));
    
    table.querySelectorAll("th").forEach(th => th.classList.remove("sorted-asc", "sorted-desc"));
    table.querySelectorAll("th")[n].classList.add(`sorted-${direction}`);
    
    table.setAttribute("data-sort", n);
    table.setAttribute("data-direction", direction);
}

document.addEventListener("DOMContentLoaded", () => {
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
            email: 'inacio@gmail.com',
            visivel: true
        },
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
    const mostrarOcultosBtn = document.getElementById('mostrar-ocultos');

    // Variáveis de estado
    let currentPage = 1;
    const rowsPerPage = 10;
    let filteredData = [...funcionarios];
    let mostrarTodos = false;

    // Inicialização
    renderTable();

    // Event Listeners
    closeBtn.addEventListener('click', closeModal);
    novaOsBtn.addEventListener('click', openNewFuncionarioModal);
    prevPageBtn.addEventListener('click', goToPrevPage);
    nextPageBtn.addEventListener('click', goToNextPage);
    searchInput.addEventListener('input', debounce(filterTable, 300));
    editForm.addEventListener('submit', handleFormSubmit);
    btnVoltar.addEventListener('click', () => {
        window.location.href = "../tela_geral/tela_geral.html";
    });
    mostrarOcultosBtn.addEventListener('click', toggleMostrarOcultos);

    // Fechar modal ao clicar fora
    window.addEventListener('click', function(event) {
        if (event.target === editModal) {
            closeModal();
        }
    });

    // Configura ordenação da tabela
    const headers = document.querySelectorAll(".service-table th");
    headers.forEach((header, index) => {
        if (index !== headers.length - 1) {
            header.style.cursor = "pointer";
            header.addEventListener("click", () => sortTable(index));
        }
    });

    // Funções principais
    function renderTable() {
        tableBody.innerHTML = '';
        
        const dadosParaExibir = mostrarTodos ? filteredData : filteredData.filter(func => func.visivel);
        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        const paginatedData = dadosParaExibir.slice(start, end);

        if (paginatedData.length === 0) {
            const row = document.createElement('tr');
            row.innerHTML = `<td colspan="8" class="no-results">Nenhum funcionário encontrado</td>`;
            tableBody.appendChild(row);
            return;
        }

        paginatedData.forEach(func => {
            const row = document.createElement('tr');
            row.dataset.id = func.id;
            row.dataset.visivel = func.visivel;
            
            row.innerHTML = `
                <td>${func.nome}</td>
                <td>${func.cpf}</td>
                <td>R$ ${func.salario}</td>
                <td>${func.dataNascimento}</td>
                <td>${func.cep}</td>
                <td>${func.funcao}</td>
                <td>${func.email}</td>
                <td class="actions-cell">
                    <button class="action-btn edit-btn" title="Editar">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="action-btn ${func.visivel ? 'hide-btn' : 'show-btn'}" 
                            title="${func.visivel ? 'Ocultar' : 'Mostrar'}">
                        <i class="fas ${func.visivel ? 'fa-eye-slash' : 'fa-eye'}"></i>
                    </button>
                </td>
            `;
            
            if (!func.visivel && mostrarTodos) {
                row.classList.add('oculto');
            }
            
            tableBody.appendChild(row);
        });

        addEditEvents();
        addToggleVisibilityEvents();
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
                    document.getElementById('edit-visivel').value = func.visivel ? 'true' : 'false';
                    
                    openModal();
                }
            });
        });
    }

    function addToggleVisibilityEvents() {
        document.querySelectorAll('.hide-btn, .show-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const row = this.closest('tr');
                const id = parseInt(row.dataset.id);
                const funcIndex = funcionarios.findIndex(func => func.id === id);
    
                if (funcIndex !== -1) {
                    const novoStatus = !funcionarios[funcIndex].visivel;
                    const acao = novoStatus ? 'mostrar' : 'ocultar';
    
                    const confirmacao = confirm(`Tem certeza que deseja ${acao} este funcionário?`);
    
                    if (confirmacao) {
                        funcionarios[funcIndex].visivel = novoStatus;
    
                        const filteredIndex = filteredData.findIndex(func => func.id === id);
                        if (filteredIndex !== -1) {
                            filteredData[filteredIndex].visivel = novoStatus;
                        }
    
                        renderTable();
                    } else {
                        console.log(`${acao.charAt(0).toUpperCase() + acao.slice(1)} cancelado.`);
                    }
                }
            });
        });
    }

    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        
        if (searchTerm === '') {
            filteredData = [...funcionarios];
        } else {
            filteredData = funcionarios.filter(func => {
                return (
                    func.nome.toLowerCase().includes(searchTerm) ||
                    func.cpf.toLowerCase().includes(searchTerm) ||
                    func.salario.toLowerCase().includes(searchTerm) ||
                    func.dataNascimento.toLowerCase().includes(searchTerm) ||
                    func.cep.toLowerCase().includes(searchTerm) ||
                    func.funcao.toLowerCase().includes(searchTerm) ||
                    func.email.toLowerCase().includes(searchTerm)
                );
            });
        }
        
        currentPage = 1;
        renderTable();
    }

    function handleFormSubmit(e) {
        e.preventDefault();
        
        const id = parseInt(document.getElementById('edit-id').value);
        const funcIndex = funcionarios.findIndex(func => func.id === id);
        
        if (funcIndex !== -1) {
            funcionarios[funcIndex] = {
                ...funcionarios[funcIndex],
                nome: document.getElementById('edit-funcionario').value,
                cpf: document.getElementById('edit-cpf').value,
                salario: document.getElementById('edit-salario').value,
                dataNascimento: document.getElementById('edit-dataNascimento').value,
                cep: document.getElementById('edit-cep').value,
                funcao: document.getElementById('edit-funcao').value,
                email: document.getElementById('edit-email').value,
                visivel: document.getElementById('edit-visivel').value === 'true'
            };
        } else {
            const newId = funcionarios.length > 0 ? Math.max(...funcionarios.map(func => func.id)) + 1 : 1;
            funcionarios.push({
                id: newId,
                nome: document.getElementById('edit-funcionario').value,
                cpf: document.getElementById('edit-cpf').value,
                salario: document.getElementById('edit-salario').value,
                dataNascimento: document.getElementById('edit-dataNascimento').value,
                cep: document.getElementById('edit-cep').value,
                funcao: document.getElementById('edit-funcao').value,
                email: document.getElementById('edit-email').value,
                visivel: true
            });
        }
        
        filteredData = [...funcionarios];
        renderTable();
        closeModal();
    }

    function toggleMostrarOcultos() {
        mostrarTodos = !mostrarTodos;
        mostrarOcultosBtn.textContent = mostrarTodos ? 'Mostrar Apenas Visíveis' : 'Mostrar Ocultos';
        currentPage = 1;
        renderTable();
    }

    function openModal() {
        editModal.style.display = 'block';
    }

    function closeModal() {
        editModal.style.display = 'none';
        editForm.reset();
    }

    function openNewFuncionarioModal() {
        editForm.reset();
        document.getElementById('edit-id').value = '';
        document.getElementById('edit-visivel').value = 'true';
        openModal();
    }

    function goToPrevPage() {
        if (currentPage > 1) {
            currentPage--;
            renderTable();
        }
    }

    function goToNextPage() {
        const dadosParaExibir = mostrarTodos ? filteredData : filteredData.filter(func => func.visivel);
        const totalPages = Math.ceil(dadosParaExibir.length / rowsPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            renderTable();
        }
    }

    function updatePagination() {
        const dadosParaExibir = mostrarTodos ? filteredData : filteredData.filter(func => func.visivel);
        const totalPages = Math.ceil(dadosParaExibir.length / rowsPerPage);
        pageNumber.textContent = currentPage;
        
        prevPageBtn.disabled = currentPage === 1;
        nextPageBtn.disabled = currentPage === totalPages || totalPages === 0;
    }

    function debounce(func, timeout = 300) {
        let timer;
        return (...args) => {
            clearTimeout(timer);
            timer = setTimeout(() => { func.apply(this, args); }, timeout);
        };
    }
});