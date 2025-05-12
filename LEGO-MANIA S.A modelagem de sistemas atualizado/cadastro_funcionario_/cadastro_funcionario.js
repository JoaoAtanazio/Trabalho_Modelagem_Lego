document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector('#formFuncionario');
  const nomeInput = document.querySelector('#nome');
  const cpfInput = document.querySelector('#cpf');
  const salarioInput = document.querySelector('#salario');
  const cepInput = document.querySelector('#cep');
  const idadeInput = document.querySelector('#idade');
  const emailInput = document.querySelector('#email');

  // Nome: não pode conter números
  nomeInput.addEventListener('input', function () {
    this.value = this.value.replace(/[0-9]/g, '');
  });

  // CPF/CNPJ: apenas números
  cpfInput.addEventListener('input', function () {
    this.value = this.value.replace(/[^0-9]/g, '');
  });

  // Salário: apenas números
  salarioInput.addEventListener('input', function () {
    this.value = this.value.replace(/[^0-9]/g, '');
  });

  // CEP: apenas números
  cepInput.addEventListener('input', function () {
    this.value = this.value.replace(/[^0-9]/g, '');
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

  // Envio do formulário: checagens extras
  form.addEventListener('submit', function (e) {
    if (/\d/.test(nomeInput.value)) {
      e.preventDefault();
      alert("O campo Nome não pode conter números.");
    } else if (cpfInput.value.length < 11) {
      e.preventDefault();
      alert("O CPF/CNPJ deve ter no mínimo 11 números.");
    }
  });
});
