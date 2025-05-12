document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector('#formFuncionario');
  const nomeInput = document.querySelector('#nome');
  const tipoCpfCnpjInput = document.querySelector('#tipoCpfCnpj');
  const cpfCnpjInput = document.querySelector('#cpfCnpj');
  const salarioInput = document.querySelector('#salario');
  const cepInput = document.querySelector('#cep');
  const idadeInput = document.querySelector('#idade');
  const emailInput = document.querySelector('#email');

  // Nome: não pode conter números
  nomeInput.addEventListener('input', function () {
    this.value = this.value.replace(/[0-9]/g, '');
  });

  // Salário: apenas números
  salarioInput.addEventListener('input', function () {
    this.value = this.value.replace(/[^0-9,]/g, '');
  });

  // CEP: apenas números
  cepInput.addEventListener('input', function () {
    this.value = this.value.replace(/[^0-9\-]/g, '');
  });

  // Idade: apenas números, no máximo 4 dígitos
  idadeInput.addEventListener('input', function () {
    this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4);
  });

  // Email: formato válido
  emailInput.addEventListener('input', function () {
    const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    if (!emailRegex.test(this.value)) {
      this.setCustomValidity('Por favor, insira um e-mail válido.');
    } else {
      this.setCustomValidity('');
    }
  });

  // Aplica a máscara para CPF ou CNPJ
  function aplicarMascaraCpfCnpj() {
    const tipo = tipoCpfCnpjInput.value;
    const input = cpfCnpjInput;
    let v = input.value.replace(/\D/g, ''); // Remove tudo o que não for número

    // Limita o número de caracteres (11 para CPF, 14 para CNPJ)
    if (tipo === 'cpf') {
      v = v.slice(0, 11)
           .replace(/(\d{3})(\d)/, '$1.$2')
           .replace(/(\d{3})(\d)/, '$1.$2')
           .replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    } else { // CNPJ
      v = v.slice(0, 14)
           .replace(/^(\d{2})(\d)/, '$1.$2')
           .replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3')
           .replace(/\.(\d{3})(\d)/, '.$1/$2')
           .replace(/(\d{4})(\d)/, '$1-$2');
    }

    input.value = v;
  }

  // Atualiza a máscara de CPF/CNPJ ao digitar ou trocar o tipo
  cpfCnpjInput.addEventListener('input', aplicarMascaraCpfCnpj);
  tipoCpfCnpjInput.addEventListener('change', aplicarMascaraCpfCnpj);

  // Limita o número de caracteres no campo CPF/CNPJ
  cpfCnpjInput.addEventListener('input', function () {
    if (tipoCpfCnpjInput.value === 'cpf' && this.value.length > 14) {
      this.value = this.value.slice(0, 14);
    } else if (tipoCpfCnpjInput.value === 'cnpj' && this.value.length > 18) {
      this.value = this.value.slice(0, 18);
    }
  });

});
