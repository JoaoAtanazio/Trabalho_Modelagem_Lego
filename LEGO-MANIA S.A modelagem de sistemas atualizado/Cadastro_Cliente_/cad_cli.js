document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector('#formcliente');
  const nomeInput = document.querySelector('#nome');
  const cpfCnpjInput = document.querySelector('#cpfCnpj');
  const cepInput = document.querySelector('#cep');
  const emailInput = document.querySelector('#email');
  const telefoneInput = document.querySelector('#telefone')

  // Função para exibir erro
  function marcarErro(input, condicaoInvalida, mensagem) {
    const errorMessage = input.nextElementSibling;  // Assume que a mensagem de erro está após o campo
    if (condicaoInvalida) {
        input.classList.add('erro');
      if (errorMessage) errorMessage.textContent = mensagem;
    
      return true;
    } else {
      input.classList.remove('erro');
      if (errorMessage) errorMessage.textContent = '';
      return false;
    }
  }

  nomeInput.addEventListener('input', function () {
    this.value = this.value.replace(/[0-9]/g, '');
    this.classList.remove('erro');
  });


  cepInput.addEventListener('input', function () {
    this.value = this.value.replace(/[^0-9\-]/g, '');
    this.classList.remove('erro');
  });

  emailInput.addEventListener('input', function () {
    const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    if (!emailRegex.test(this.value)) {
      this.setCustomValidity('Por favor, insira um e-mail válido.');
      this.classList.add('erro');
    } else {
      this.setCustomValidity('');
      this.classList.remove('erro');
    }
  });

  cpfCnpjInput.addEventListener('input', function () {
    let v = this.value.replace(/\D/g, '');
    if (v.length <= 11) {
         v = v.replace(/(\d{3})(\d)/, '$1.$2');
      v = v.replace(/(\d{3})(\d)/, '$1.$2');
      v = v.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    } else {
      v = v.replace(/^(\d{2})(\d)/, '$1.$2');
      v = v.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
      v = v.replace(/\.(\d{3})(\d)/, '.$1/$2');
      v = v.replace(/(\d{4})(\d)/, '$1-$2');
    }
    this.value = v;
    this.classList.remove('erro');
  });

  if (telefoneInput) {
      // Impede a digitação de letras e caracteres inválidos
      telefoneInput.addEventListener('keydown', function (e) {
        // Permitir: Backspace, Delete, Setas, Tab, Home, End
        const teclasPermitidas = [8, 9, 37, 38, 39, 40, 46];
        if (
          (e.key >= '0' && e.key <= '9') ||
          teclasPermitidas.includes(e.keyCode)
        ) {
          // Permite a digitação
        } else {
          e.preventDefault(); // Bloqueia qualquer outra tecla
        }
      });
    
      // Aplica a máscara ao digitar
      telefoneInput.addEventListener('input', function () {
        let valor = this.value.replace(/\D/g, ''); // Remove não números
    
        // Aplica a máscara
        if (valor.length <= 10) {
          valor = valor.replace(/^(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
        } else {
          valor = valor.replace(/^(\d{2})(\d{5})(\d{0,4})/, '($1) $2-$3');
        }
    
        this.value = valor.slice(0, 19); // Limita a 19 caracteres formatados
        this.classList.remove('erro');
      });
    }    
    

  // Função para selecionar a função e atualizar o input
  function selecionarFuncao(funcao) {
    funcaoInput.value = funcao;  // Atualiza o campo do input
    dropdown.classList.remove('erro');  // Remove o erro se a função for válida
  }

  // Exemplo de como associar isso ao seu dropdown
  document.querySelectorAll('.dropdown-options div').forEach(function(option) {
    option.addEventListener('click', function() {
      selecionarFuncao(option.textContent);
    });
  });

  // Validação ao enviar
  form.addEventListener('submit', function (e) {
    e.preventDefault();
    let erro = false;

    erro = marcarErro(nomeInput, nomeInput.value.trim() === '', 'Nome é obrigatório.') || erro;
    erro = marcarErro(cpfCnpjInput, cpfCnpjInput.value.trim().length < 14, 'CPF ou CNPJ inválido.') || erro;
    erro = marcarErro(cepInput, cepInput.value.trim().length < 8, 'CEP inválido.') || erro;
    erro = marcarErro(emailInput, !emailInput.checkValidity(), 'E-mail inválido.') || erro;

  if (!erro) {
      alert('Cliente cadastrado com sucesso!');
      form.submit();
    }
  });
});
 
        const formCliente = document.querySelector('#formCliente');