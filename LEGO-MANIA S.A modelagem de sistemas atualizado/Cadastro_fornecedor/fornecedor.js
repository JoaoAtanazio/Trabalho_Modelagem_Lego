document.querySelector('.form-funcionario').addEventListener('submit', function (e) {
  e.preventDefault();

  const fornecedor = {
    id: Date.now(), // gera um ID único com base no timestamp
    nome: document.getElementById('nome').value,
    cpf_cnpj: document.getElementById('cpf').value,
    telefone: document.getElementById('Telefone').value,
    ramo: document.getElementById('salario').value,
    cep: document.getElementById('cep').value,
    email: document.getElementById('email').value,
    visible: true
  };

  // Recupera fornecedores já salvos ou cria uma lista nova
  const fornecedores = JSON.parse(localStorage.getItem('fornecedores')) || [];

  // Adiciona novo fornecedor
  fornecedores.push(fornecedor);

  // Salva de volta no localStorage
  localStorage.setItem('fornecedores', JSON.stringify(fornecedores));

  alert('Fornecedor cadastrado com sucesso!');
});