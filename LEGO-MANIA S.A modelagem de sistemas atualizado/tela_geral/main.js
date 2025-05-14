document.addEventListener('DOMContentLoaded', function() {
    const cursor = document.querySelector('.custom-cursor');
    const pointer = document.querySelector('.pointer');
    const customPointer = document.querySelector('.custom-pointer');
    
    // Elementos que devem mostrar o cursor personalizado
    const interactiveElements = [
        'a', 'button', 'input', 'textarea', 'select', 
        '[onclick]', '[role=button]', 'label[for]'
    ];
    
    // Atualiza posição do cursor
    document.addEventListener('mousemove', function(e) {
        cursor.style.left = e.clientX + 'px';
        cursor.style.top = e.clientY + 'px';
    });
    
    // Mostra/oculta os cursores baseado no elemento sob o mouse
    document.querySelectorAll(interactiveElements.join(',')).forEach(el => {
        el.addEventListener('mouseenter', function() {
            pointer.style.display = 'none';
            customPointer.style.display = 'block';
        });
        
        el.addEventListener('mouseleave', function() {
            customPointer.style.display = 'none';
            pointer.style.display = 'block';
        });
    });
    
    // Garante que o cursor padrão seja mostrado quando o mouse sair da janela
    document.addEventListener('mouseout', function(e) {
        if (!e.relatedTarget) {
            customPointer.style.display = 'none';
            pointer.style.display = 'block';
        }
    });
    
    // Restante do seu código...
});
document.addEventListener("DOMContentLoaded", function() {
    flatpickr("#data", {
      dateFormat: "d/m/Y",
      locale: "pt"
    });
  });

    

    // Event listeners para os botões
    const conferirOS = document.getElementById("conferir");
    const voltarOS = document.getElementById("btnvoltaros");
    const graficopizza = document.getElementById("btnpizza");
	const graficobarra = document.getElementById("btnbarra");
    const perfil = document.getElementById("btnperfil")
    const senha = document.querySelector('.senha-container');
    const iconeOlho = document.querySelector('.btn-olho');
    const senhaTexto = document.getElementById('senhaTexto');
    
    if (iconeOlho) {
        iconeOlho.addEventListener('click', mostrarSenha);
    }
    
    if (conferirOS) {
        conferirOS.addEventListener('click', AbrirOS);
    }
    
    if (voltarOS) {
        voltarOS.addEventListener('click', VoltarOS);
    }
    
    if (graficopizza) {
        graficopizza.addEventListener('click', abrirpizza); // Corrigido para usar graficopizza
    }
	if (graficobarra) {
		graficobarra.addEventListener('click', abrirbarra);
	}

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

// Adicionando evento ao botão corretamente



function toggleDropdown() {
    document.getElementById('funcao-dropdown').classList.toggle('open');
  }

  function selecionarFuncao(valor) {
    document.getElementById('funcaoSelecionada').innerText = valor;
    document.getElementById('funcao').value = valor;
    toggleDropdown();
  }
  let informações = [
    {
    Nome_usuario: 'bananinhas123',
    Senha: 'admin123',
    Telefone: '47 98432-9882'
  }
]