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
    // Configuração do Flatpickr
    if (typeof flatpickr !== 'undefined' && document.getElementById("data-recebimento")) {
        flatpickr("#data-recebimento", {
            dateFormat: "d/m/Y",
            locale: "pt",
            allowInput: true,
            clickOpens: true,
        });
    }

    // Event listeners para os botões
    const conferirOS = document.getElementById("conferir");
    const voltarOS = document.getElementById("btnvoltaros");
    const graficopizza = document.getElementById("btnpizza");
	const graficobarra = document.getElementById("btnbarra");
    const perfil = document.getElementById("btnperfil")
    const senha = document.querySelector('.senha-container');
 const iconeOlho = document.querySelector('.btn-olho i');
const senhaTexto = document.getElementById('senhaTexto');
    
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
  if (senhaTexto.textContent === '***********') {
    senhaTexto.textContent = 'admin123';
    iconeOlho.classList.toggle('fa-eye');
    iconeOlho.classList.toggle('fa-eye-slash'); // Alterna entre os ícones
  } else {
    senhaTexto.textContent = '***********';
    iconeOlho.classList.toggle('fa-eye-slash');
    iconeOlho.classList.toggle('fa-eye'); // Volta ao ícone original
  }
}

// Adicionando evento ao botão corretamente
document.querySelector('.btn-olho').addEventListener('click', mostrarSenha);
function toggleDropdown() {
    document.getElementById('funcao-dropdown').classList.toggle('open');
  }

  function selecionarFuncao(valor) {
    document.getElementById('funcaoSelecionada').innerText = valor;
    document.getElementById('funcao').value = valor;
    toggleDropdown();
  }