document.addEventListener('DOMContentLoaded', function() {

  // Botão voltar
  document.getElementById('btnvoltaros').addEventListener('click', function() {
    window.location.href = '../tela_geral/tela_geral.html'; // Ajuste o caminho
  });

  // Pesquisa
  document.getElementById('search-input').addEventListener('input', function() {
    filtrarTabela(this.value.toLowerCase());
  });

  // Paginação (exemplo básico)
  document.getElementById('prev-page').addEventListener('click', function() {
    // Lógica para página anterior
    console.log('Página anterior');
  });

  document.getElementById('next-page').addEventListener('click', function() {
    // Lógica para próxima página
    console.log('Próxima página');
  });

  // Modal de edição
  document.querySelectorAll('.edit-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      const row = this.closest('tr');
      const id = row.getAttribute('data-id');
      abrirModalEdicao(id);
    });
  });

  // Botões de excluir
  document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      const row = this.closest('tr');
      const id = row.getAttribute('data-id');
      if (confirm('Tem certeza que deseja excluir esta peça?')) {
        row.remove();
        // Aqui você deveria também remover do localStorage ou banco de dados
      }
    });
  });

  // Fechar modal
  document.querySelector('.close-btn').addEventListener('click', fecharModal);

  // Formulário de edição
  document.getElementById('edit-form').addEventListener('submit', function(e) {
    e.preventDefault();
    salvarEdicao();
  });
});

function abrirModalEdicao(id) {
  const row = document.querySelector(`tr[data-id="${id}"]`);
  if (row) {
    const cells = row.cells;
    const modal = document.getElementById('edit-modal');
    
    // Preencher o formulário com os dados da linha
    document.getElementById('edit-id').value = id;
    document.getElementById('edit-funcionario').value = cells[0].textContent;
    document.getElementById('edit-cod').value = cells[1].textContent;
    document.getElementById('edit-salario').value = cells[2].textContent;
    document.getElementById('edit-dataRecebimento').value = cells[3].textContent;
    
    // Mostrar o modal
    modal.style.display = 'block';
  }
}

function fecharModal() {
  document.getElementById('edit-modal').style.display = 'none';
}

function salvarEdicao() {
  const id = document.getElementById('edit-id').value;
  const row = document.querySelector(`tr[data-id="${id}"]`);
  
  if (row) {
    const cells = row.cells;
    cells[0].textContent = document.getElementById('edit-funcionario').value;
    cells[1].textContent = document.getElementById('edit-cod').value;
    cells[2].textContent = document.getElementById('edit-salario').value;
    cells[3].textContent = document.getElementById('edit-dataRecebimento').value;
    
    fecharModal();
    alert("Alterações salvas com sucesso!");
    
    // Aqui você deveria também salvar no localStorage ou banco de dados
  }
}

function filtrarTabela(termo) {
  const linhas = document.querySelectorAll('#os-table-body tr');
  
  linhas.forEach(linha => {
    const textoLinha = linha.textContent.toLowerCase();
    if (textoLinha.includes(termo)) {
      linha.style.display = '';
    } else {
      linha.style.display = 'none';
    }
  });
}