document.addEventListener('DOMContentLoaded', function () {
  function atualizarHorario() {
    const elementoHorario = document.querySelector('.horario');
    if (!elementoHorario) return;

    const agora = new Date();

    const dia = String(agora.getDate()).padStart(2, '0');
    const mes = String(agora.getMonth() + 1).padStart(2, '0');
    const ano = agora.getFullYear();

    const horas = String(agora.getHours()).padStart(2, '0');
    const minutos = String(agora.getMinutes()).padStart(2, '0');
    const segundos = String(agora.getSeconds()).padStart(2, '0');

    elementoHorario.innerHTML = `<p>Data: ${dia}/${mes}/${ano} <br>
    Hora: ${horas}:${minutos}:${segundos}</p>`;
  }

  atualizarHorario();
  setInterval(atualizarHorario, 1000);
});

document.addEventListener('DOMContentLoaded', () => {
  const iconeOlho   = document.getElementById('icone-olho');
  const senhaTexto  = document.getElementById('senhaTexto');

  const senhaReal      = 'admin123';   // defina aqui a senha real da sua aplicação
  const senhaMascarada = '••••••';     // Definir uma senha para apresentar

  iconeOlho.addEventListener('click', () => {
    const icon = iconeOlho.querySelector('i');
    if (icon.classList.contains('fa-eye')) {
      // mostrar senha
      senhaTexto.textContent = senhaReal;
      icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
      // esconder senha
      senhaTexto.textContent = senhaMascarada;
      icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
  });
});

document.addEventListener('DOMContentLoaded', function () {
    // Cursor personalizado
    const cursor = document.querySelector('.custom-cursor');
    const pointer = document.querySelector('.pointer');
    const customPointer = document.querySelector('.custom-pointer');
  
    const interactiveElements = [
      'a', 'button', 'input', 'textarea', 'select',
      '[onclick]', '[role=button]', 'label[for]'
    ];
  
    document.addEventListener('mousemove', function (e) {
      if (cursor) {
        cursor.style.left = e.clientX + 'px';
        cursor.style.top = e.clientY + 'px';
      }
    });
  
    document.querySelectorAll(interactiveElements.join(',')).forEach(el => {
      el.addEventListener('mouseenter', function () {
        if (pointer) pointer.style.display = 'none';
        if (customPointer) customPointer.style.display = 'block';
      });
  
      el.addEventListener('mouseleave', function () {
        if (customPointer) customPointer.style.display = 'none';
        if (pointer) pointer.style.display = 'block';
      });
    });
  
    document.addEventListener('mouseout', function (e) {
      if (!e.relatedTarget) {
        if (customPointer) customPointer.style.display = 'none';
        if (pointer) pointer.style.display = 'block';
      }
    });
    
});
document.addEventListener("DOMContentLoaded", function() {
    flatpickr("#data", {
      dateFormat: "d/m/Y",
      locale: "pt"
    });
  });
 
  document.querySelectorAll('.dropdown-options div').forEach(function (option) {
    option.addEventListener('click', function () {
      if (funcaoInput && dropdown) {
        funcaoInput.value = option.textContent;
        dropdown.classList.remove('erro');
      }
    });
  });
    
    if (typeof flatpickr !== 'undefined' && document.getElementById("data-recebimento")) {
      flatpickr("#data-recebimento", {
        dateFormat: "d/m/Y",
        locale: "pt",
        allowInput: true,
        clickOpens: true,
      });
    }
  
    // Botões e redirecionamentos

    const conferirOS = document.getElementById("conferir");
    const voltarOS = document.getElementById("btnvoltaros");
    const graficopizza = document.getElementById("btnpizza");
    const graficobarra = document.getElementById("btnbarra");
    const perfil = document.getElementById("btnperfil");
    const senhaTexto = document.getElementById('senhaTexto');
    const iconeOlho = document.querySelector('.btn-olho i');
    const inputFoto = document.getElementById('inputFoto');
    const fotoUsuario = document.getElementById('fotoUsuario');

    if(inputFoto)
      inputFoto.addEventListener('change', TrocaFoto)
  
    if (conferirOS) conferirOS.addEventListener('click', (e) => {
      e.preventDefault();
      window.location.href = '../Ordem_Servico/ordem_abertas.html';
    });
  
    if (voltarOS) voltarOS.addEventListener('click', (e) => {
      e.preventDefault();
      window.location.href = '../tela_geral/tela_geral.html';
    });
  
    if (graficopizza) graficopizza.addEventListener('click', (e) => {
      e.preventDefault();
      window.location.href = '../Requisito_pecas/Pecas_requisitadas_pizza.html';
    });
  
    if (graficobarra) graficobarra.addEventListener('click', (e) => {
      e.preventDefault();
      window.location.href = '../Requisito_pecas/Pecas_requisitadas_barra.html';
    });
  
    if (perfil) perfil.addEventListener('click', (e) => {
      e.preventDefault();
      window.location.href = '../Perfil_Usuário/Perfil_Usuário.html';
    });

    if (iconeOlho) {
      iconeOlho.addEventListener('click', mostrarSenha);
    }
  
    if (conferirOS) {
      conferirOS.addEventListener('click', AbrirOS);
    }

    // Validação de formulário
    const form = document.querySelector('#formFuncionario');
    const nomeInput = document.querySelector('#nome');
    const cpfCnpjInput = document.querySelector('#cpfCnpj');
    const salarioInput = document.querySelector('#salario');
    const cepInput = document.querySelector('#cep');
    const idadeInput = document.querySelector('#idade');
    const telefoneInput= document.querySelector('#telefone');
    const emailInput = document.querySelector('#email');
    const funcaoInput = document.querySelector('#funcao');
    const dropdown = document.querySelector('.dropdown');
  
    function marcarErro(input, condicaoInvalida, mensagem) {
      const errorMessage = input.nextElementSibling;
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
  
    if (nomeInput) {
      nomeInput.addEventListener('input', function () {
        this.value = this.value.replace(/[0-9]/g, '');
        this.classList.remove('erro');
      });
    }
  
    if (salarioInput) {
      salarioInput.addEventListener('input', function () {
        let valor = this.value.replace(/\D/g, '');
        valor = (parseFloat(valor) / 100).toFixed(2);
        const valorFormatado = new Intl.NumberFormat('pt-BR', {
          style: 'currency',
          currency: 'BRL'
        }).format(valor);
        this.value = valorFormatado;
  
        if (!valorFormatado.includes('R$')) {
          this.classList.add('erro');
        } else {
          this.classList.remove('erro');
        }
      });
    }
  
    if (cepInput) {
      cepInput.addEventListener('input', function () {
        this.value = this.value.replace(/[^0-9\-]/g, '');
        this.classList.remove('erro');
      });
    }
  
    if (idadeInput) {
      idadeInput.addEventListener('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 3);
        this.classList.remove('erro');
      });
    }
  
    if (emailInput) {
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
    }
  
    if (cpfCnpjInput) {
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
    }

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
    
        this.value = valor.slice(0, 15); // Limita a 15 caracteres formatados
        this.classList.remove('erro');
      });
    }    
      
        const formFuncionario = document.querySelector('#formFuncionario');
        const formCliente = document.querySelector('#formCliente');
        
        // Função genérica de validação (adicione os campos de cliente aqui)
        function validarFormulario(form) {
          // fazer validações aqui com base no tipo de formulário
          alert('Formulário válido!');
        
          // Se estiver tudo certo:
          return true;
        }
        
        // Exemplo para cliente:
        if (formCliente) {
          formCliente.addEventListener('submit', function (e) {
            e.preventDefault();
            const valido = validarFormulario(formCliente);
            if (valido) {
              alert('Cliente cadastrado com sucesso!');
              // Se quiser, envie: formCliente.submit();
            }
          });
        }
        
    if (form) {
      form.addEventListener('submit', function (e) {
        e.preventDefault();
        let erro = false;
  
        erro = marcarErro(nomeInput, nomeInput.value.trim() === '', 'Nome é obrigatório.') || erro;
        erro = marcarErro(cpfCnpjInput, cpfCnpjInput.value.trim().length < 14, 'CPF ou CNPJ inválido.') || erro;
        erro = marcarErro(salarioInput, salarioInput.value.trim() === '' || !salarioInput.value.includes('R$'), 'Salário inválido.') || erro;
        erro = marcarErro(cepInput, cepInput.value.trim().length < 8, 'CEP inválido.') || erro;
        erro = marcarErro(idadeInput, idadeInput.value.trim() === '' || idadeInput.value < 11 || idadeInput.value > 100, 'Idade inválida.') || erro;
        erro = marcarErro(emailInput, !emailInput.checkValidity(), 'E-mail inválido.') || erro;
        erro = marcarErro(funcaoInput, funcaoInput.value.trim() === '', 'Selecione uma função.') || erro;
        erro = marcarErro(telefoneInput, telefoneInput.value.trim().length < 14, 'Telefone inválido.') || erro;
   
        if (funcaoInput.value.trim() === '') {
          dropdown.classList.add('erro');
          erro = true;
        } else {
          dropdown.classList.remove('erro');
        }
  
        if (!erro) {
          alert('Funcionário cadastrado com sucesso!');
          form.submit();
        }
      });
    }
  
  function toggleDropdown() {
    const dropdown = document.getElementById('funcao-dropdown');
    if (dropdown) dropdown.classList.toggle('open');

    if(perfil) {
        perfil.addEventListener('click', abrirperfil);
    }
    
    function AbrirOS(event) {
        event.preventDefault();
        window.location.href = '../Ordem_Servico/ordem_abertas.html';
    }
    
    function VoltarOS(event) {
        event.preventDefault();
        window.location.href = '../tela_geral/tela_geral.html';
    }
    
    function abrirpizza(event) {
        event.preventDefault();
        window.location.href = '../Requisito_pecas/Pecas_requisitadas_pizza.html';
    }
	
	function abrirbarra(event) {
		event.preventDefault();
		window.location.href = '../Requisito_pecas/Pecas_requisitadas_barra.html';
	}
    function abrirperfil(event){
        event.preventDefault();
        window.location.href = '../Perfil_Usuário/Perfil_Usuário.html';
    }
 function mostrarSenha() {
  if (senhaTexto.textContent === 'BANANA') {
    senhaTexto.textContent = 'teste123';
    iconeOlho.classList.remove('fa-eye');
    iconeOlho.classList.toggle('fa-eye-slash'); // Alterna entre os ícones
  } 
  else {
    senhaTexto.textContent = 'admin123'; // Esconde a senha
    iconeOlho.classList.remove('fa-eye-slash'); // Remove o ícone de olho fechado
    iconeOlho.classList.add('fa-eye'); // Adiciona o ícone de olho aberto
  }
}
  }
// Adicionando evento ao botão corretamente

  function selecionarFuncao(valor) {
    const funcaoSelecionada = document.getElementById('funcaoSelecionada');
    const funcao = document.getElementById('funcao');
    if (funcaoSelecionada) funcaoSelecionada.innerText = valor;
    if (funcao) funcao.value = valor;
    toggleDropdown();
  }

   function TrocaFoto(e) {
    if (e.target.files && e.target.files[0]) {
      file = e.target.files[0];
      
      // Validações
      if (!file.type.match('image.*')) {
          alert('Por favor, selecione uma imagem válida (JPEG, PNG, etc.)');
          return;
      }
      
      if (file.size > 2 * 1024 * 1024) { // 2MB
          alert('A imagem deve ter menos de 2MB');
          return;
      }
      
      // Criar preview da imagem
      const reader = new FileReader();
      
      reader.onload = function(event) {
          fotoUsuario.src = event.target.result;
          
          // Aqui você pode chamar a função para enviar ao servidor
          // uploadFotoPerfil(file);
      };
      
      reader.readAsDataURL(file);
  }
};
async function uploadFotoPerfil(file) {
  const formData = new FormData();
  formData.append('fotoPerfil', file);
  
  try {
      const response = await fetch('/upload-foto-perfil', {
          method: 'POST',
          body: formData
      });
      
      const data = await response.json();
      
      if (!response.ok) {
          throw new Error(data.message || 'Erro ao atualizar foto');
      }
      
      console.log('Foto atualizada com sucesso:', data);
  } catch (error) {
      console.error('Erro:', error);
      alert('Erro ao enviar foto: ' + error.message);
  }
}

  form.addEventListener('submit', function (e) {
    let erro = false;
  
    // todas as validações...
  
    if (erro) {
      e.preventDefault(); // só bloqueia o envio se tiver erro
    } else {
      alert('Funcionário cadastrado com sucesso!');
      // envio segue normalmente
    }
  });
  
  let informações = [
    {
    Nome_usuario: 'bananinhas123',
    Senha: 'admin123',
    Telefone: '47 98432-9882'
  }
]